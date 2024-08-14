<?php

use App\Http\Controllers\Admin\BookAndTypeMappingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GradeController;
use App\Http\Controllers\Admin\GradeBookController as AdminGradeBookController;
use App\Http\Controllers\Admin\BookChapterController as AdminBookChapterController;
use App\Http\Controllers\Admin\GradeBookChapterController as AdminGradeBookChapterController;
use App\Http\Controllers\Admin\ChapterQuestionController as AdminChapterQuestionController;
use App\Http\Controllers\Admin\MappingController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\SubtypeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Collaborator\ApprovalController;
use App\Http\Controllers\Collaborator\BookApprovableController;
use App\Http\Controllers\Collaborator\BookChapterQuestionController;
use App\Http\Controllers\Collaborator\ChapterApprovableController;
use App\Http\Controllers\Collaborator\ChapterQuestionController as CollaboratorChapterQuestionController;
use App\Http\Controllers\Collaborator\DashboardController as CollaboratorDashboardController;
use App\Http\Controllers\Collaborator\PaperController;
use App\Http\Controllers\Collaborator\PaperGradeBookChapterController;
use App\Http\Controllers\Collaborator\PaperQuestionController;
use App\Http\Controllers\Collaborator\PaperTypeQuestionController;
use App\Http\Controllers\Operator\BookChapterController;
use App\Http\Controllers\Operator\ChapterQuestionController;
use App\Http\Controllers\Operator\GradeBookChapterController;
use App\Http\Controllers\Operator\GradeBookController;
use App\Http\Controllers\SelfTestController;
use App\Http\Controllers\Operator\DashboardController as OperatorDashboardController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\Teacher\DashboardController as TeacherDashboardController;
use App\Http\Controllers\Teacher\PaperController as TeacherPaperController;
use App\Http\Controllers\Teacher\PaperLongController;
use App\Http\Controllers\Teacher\PaperMcqController;
use App\Http\Controllers\Teacher\PaperPdfController;
use App\Http\Controllers\Teacher\PaperQuestionController as TeacherPaperQuestionController;
use App\Http\Controllers\Teacher\PaperQuestionPartController;
use App\Http\Controllers\Teacher\PaperShortController;
use App\Http\Middleware\CheckSessionExpiry;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect(session('role'));
    } else {
        return view('index');
    }
});


Route::view('about', 'about');
Route::view('services', 'services');
Route::view('team', 'team');
Route::view('blogs', 'blogs');
Route::view('login', 'login');
Route::view('signup/me', 'signup');

Route::get('login/as', function () {
    $year = date('Y');
    return view('login_as', compact('year'));
});

Route::get('switch/as/{role}', [UserController::class, 'switchAs']);

Route::post('login', [AuthController::class, 'login']);
Route::post('signup', [AuthController::class, 'signup']);

Route::post('login/as', [AuthController::class, 'loginAs'])->name('login.as');
Route::get('signout', [AuthController::class, 'signout'])->name('signout');

Route::resource('passwords', PasswordController::class);

Route::resource('self-tests', SelfTestController::class);
Route::get('fetchSubTypesByTypeId', [AjaxController::class, 'fetchSubTypesByTypeId']);
Route::get('findSimilarQuestions', [AjaxController::class, 'findSimilarQuestions']);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['role:admin']], function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::resource('users', UserController::class);
    Route::resource('grades', GradeController::class);
    Route::resource('subtypes', SubtypeController::class);
    Route::resource('mappings', MappingController::class);
    Route::resource('book.type.mappings', BookAndTypeMappingController::class);

    Route::resource('subjects', SubjectController::class);
    Route::resource('grade.books', AdminGradeBookController::class);
    Route::resource('book.chapters', AdminBookChapterController::class);
    Route::resource('chapter.questions', AdminChapterQuestionController::class);
    Route::resource('grade.book.chapters', AdminGradeBookChapterController::class);
    Route::view('change/password', 'admin.change_password');
    Route::post('change/password', [AuthController::class, 'changePassword'])->name('change.password');
});

Route::group(['prefix' => 'collaborator', 'as' => 'collaborator.', 'middleware' => ['role:collaborator']], function () {
    Route::get('/', [CollaboratorDashboardController::class, 'index']);
    Route::resource('approvables', ApprovalController::class);
    Route::resource('book.approvables', BookApprovableController::class);
    Route::resource('chapter.approvables', ChapterApprovableController::class);
    Route::resource('papers', PaperController::class);
    Route::resource('paper.questions', PaperQuestionController::class);
    Route::resource('paper.pdf', PdfController::class);
    Route::resource('paper.type.questions', PaperTypeQuestionController::class);

    Route::resource('grade.book.chapters', PaperGradeBookChapterController::class);
});
Route::group(['prefix' => 'operator', 'as' => 'operator.', 'middleware' => ['role:operator']], function () {
    Route::get('/', [OperatorDashboardController::class, 'index']);
    Route::resource('grade.books', GradeBookController::class);
    Route::resource('book.chapters', BookChapterController::class);
    Route::resource('grade.book.chapters', GradeBookChapterController::class);
    Route::resource('chapter.questions', ChapterQuestionController::class);
});

Route::post('/generate-pdf', 'PdfController@generatePDF');


Route::group(['prefix' => 'teacher', 'as' => 'teacher.', 'middleware' => ['role:teacher']], function () {
    Route::get('/', [TeacherDashboardController::class, 'index']);
    Route::resource('papers', TeacherPaperController::class);
    Route::resource('papers.pdf', PaperPdfController::class);
    Route::resource('papers.mcqs', PaperMcqController::class);
    Route::resource('papers.shorts', PaperShortController::class);
    Route::resource('papers.longs', PaperLongController::class);
    Route::resource('paper.questions', TeacherPaperQuestionController::class);

    Route::get('paper-question-part/refresh', [PaperQuestionPartController::class, 'refresh']);


    Route::resource('test-questions', TestQuestionController::class);
    Route::get('test/questions/add/{test}/{questionType}', [TestQuestionController::class, 'add'])->name('tests.questions.add');
    Route::get('test/{test}/questions/{q}/refresh',);
    Route::resource('question-parts', TestQuestionPartController::class);
    Route::get('paper-question-parts/{part}/refresh', [PaperQuestionPartController::class, 'refresh'])->name('paper-question-parts.refresh');
    Route::get('tests/{test}/anskey', [AnswerKeyController::class, 'show'])->name('tests.anskey.show');
    Route::get('tests/{test}/anskey/pdf', [AnswerKeyController::class, 'pdf'])->name('tests.anskey.pdf');
});
