<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GradeController;
use App\Http\Controllers\Admin\GradeBookController as AdminGradeBookController;
use App\Http\Controllers\Admin\BookChapterController as AdminBookChapterController;
use App\Http\Controllers\Admin\GradeBookChapterController as AdminGradeBookChapterController;
use App\Http\Controllers\Admin\ChapterQuestionController as AdminChapterQuestionController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\QbankBooksController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\TypeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Collaborator\ApprovalController;
use App\Http\Controllers\Collaborator\BookApprovableController;
use App\Http\Controllers\Collaborator\ChapterApprovableController;
use App\Http\Controllers\Collaborator\DashboardController as CollaboratorDashboardController;
use App\Http\Controllers\Collaborator\PaperController;
use App\Http\Controllers\Collaborator\PaperGradeBookChapterController;
use App\Http\Controllers\Collaborator\PaperQuestionController;
use App\Http\Controllers\Collaborator\PaperTypeQuestionController;
use App\Http\Controllers\Operator\BookChapterController;
use App\Http\Controllers\Operator\BookController;
use App\Http\Controllers\Operator\ChapterQuestionController;
use App\Http\Controllers\Operator\GradeBookChapterController;
use App\Http\Controllers\Operator\GradeBookController;
use App\Http\Controllers\SelfTestController;
use App\Http\Controllers\Operator\DashboardController as OperatorDashboardController;
use App\Http\Controllers\Operator\QuestionChoiceController as OperatorQuestionChoiceController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\User\AccountController;
use App\Http\Controllers\User\DashboardController as TeacherDashboardController;
use App\Http\Controllers\User\ExtendedPartController;
use App\Http\Controllers\User\MultipartFromMultiChapterController;
use App\Http\Controllers\User\MultipartFromSingleChapterController;
use App\Http\Controllers\User\PaperChapterController;
use App\Http\Controllers\User\PaperController as TeacherPaperController;
use App\Http\Controllers\User\PaperKeyController;
use App\Http\Controllers\User\PaperMcqController;
use App\Http\Controllers\User\PaperPdfController;
use App\Http\Controllers\User\PaperQuestionController as UserPaperQuestionController;
use App\Http\Controllers\User\PaperQuestionPartController;
use App\Http\Controllers\User\PaperShortController;
use App\Http\Controllers\User\PartialQuestionController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\QuestionChoiceController;
use App\Http\Controllers\User\SimplePdfController;
use App\Http\Controllers\User\SimpleQuestionController;
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
Route::view('signup/success', 'signup-success');

Route::view('forgot', 'forgot');
Route::post('forgot', [AuthController::class, 'forgot']);

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
Route::get('findSimilarQuestions', [AjaxController::class, 'findSimilarQuestions']);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['role:admin']], function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::resource('users', UserController::class);
    Route::resource('subjects', SubjectController::class);
    Route::resource('grades', GradeController::class);
    Route::resource('types', TypeController::class);
    Route::resource('tags', TagController::class);
    Route::resource('packages', PackageController::class);
    Route::resource('grade.books', AdminGradeBookController::class);
    Route::resource('qbank-books', QbankBooksController::class);
    Route::resource('qbank-books.chapters', AdminBookChapterController::class);

    Route::resource('chapter.questions', AdminChapterQuestionController::class);
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

    Route::resource('books', BookController::class);
    Route::resource('grade.books', GradeBookController::class);
    Route::resource('books.chapters', BookChapterController::class);
    Route::resource('grade.book.chapters', GradeBookChapterController::class);
    Route::resource('chapter.question-choices', OperatorQuestionChoiceController::class);
    Route::resource('chapter.questions', ChapterQuestionController::class);
    Route::resource('chapter.questionables.questions', ChapterQuestionController::class);
});

Route::post('/generate-pdf', 'PdfController@generatePDF');


Route::group(['prefix' => 'user', 'as' => 'user.', 'middleware' => ['role:user']], function () {
    Route::get('/', [TeacherDashboardController::class, 'index']);
    Route::resource('papers', TeacherPaperController::class);
    Route::resource('papers.chapters', PaperChapterController::class);
    Route::resource('papers.questionChoices', QuestionChoiceController::class);
    Route::resource('papers.mcqs', PaperMcqController::class);
    Route::resource('papers.shorts', PaperShortController::class);
    Route::resource('paper.questions', UserPaperQuestionController::class);
    Route::resource('papers.simpleQuestions', SimpleQuestionController::class)->only('store');

    // Route::resource('papers.partialQuestions', PartialQuestionController::class)->only('store');
    Route::resource('papers.multipart-singlechapter-questions', MultipartFromSingleChapterController::class)->only('store');
    Route::resource('papers.multipart-multichapter-questions', MultipartFromMultiChapterController::class)->only('store');

    Route::resource('paperQuestions.extendedParts', ExtendedPartController::class);
    Route::resource('papers.pdf', PaperPdfController::class);
    Route::resource('papers.simple-pdf', SimplePdfController::class);

    Route::resource('accounts', AccountController::class);
    Route::resource('profiles', ProfileController::class);

    Route::get('paper-question-parts/{part}/refresh', [PaperQuestionPartController::class, 'refresh'])->name('paper-question-parts.refresh');

    Route::get('papers/{paper}/key', [PaperKeyController::class, 'show'])->name('papers.keys.show');
    Route::get('papers/{paper}/key/pdf', [PaperKeyController::class, 'pdf'])->name('papers.keys.pdf');
});
