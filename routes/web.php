<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GradeController;
use App\Http\Controllers\Admin\GradeBookController as AdminGradeBookController;
use App\Http\Controllers\Admin\BookChapterController as AdminBookChapterController;
use App\Http\Controllers\Admin\ChapterQuestionController as AdminChapterQuestionController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\PoetryLineController as AdminPoetryLineController;
use App\Http\Controllers\Admin\QbankBooksController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\TypeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Collaborator\ChapterQuestionController as CollaboratorChapterQuestionController;
use App\Http\Controllers\Collaborator\DashboardController as CollaboratorDashboardController;
use App\Http\Controllers\Collaborator\GradeChapterController;
use App\Http\Controllers\Collaborator\GradeController as CollaboratorGradeController;
use App\Http\Controllers\Operator\BookChapterController;
use App\Http\Controllers\Operator\BookController;
use App\Http\Controllers\Operator\ChapterQuestionController;
use App\Http\Controllers\Operator\GradeBookController;
use App\Http\Controllers\Operator\DashboardController as OperatorDashboardController;
use App\Http\Controllers\Operator\PoetryLineController;
use App\Http\Controllers\Operator\QuestionMovementController;
use App\Http\Controllers\Operator\QuestionTypeChangeController;
use App\Http\Controllers\SelfTestController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\User\AccountController;
use App\Http\Controllers\User\BaseQuestionController;
use App\Http\Controllers\User\DashboardController as TeacherDashboardController;
use App\Http\Controllers\User\LatexPdfController;
use App\Http\Controllers\User\PaperChapterController;
use App\Http\Controllers\User\PaperController as TeacherPaperController;
use App\Http\Controllers\User\PaperKeyController;
use App\Http\Controllers\User\PaperQuestionController as UserPaperQuestionController;
use App\Http\Controllers\User\PaperQuestionExtensionController;
use App\Http\Controllers\User\PaperQuestionPartController;
use App\Http\Controllers\User\PartialQuestionController;
use App\Http\Controllers\User\ProfileController;
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

Route::resource('signup', SignupController::class);
Route::view('signup-success', 'signup-success');

Route::view('forgot', 'forgot');
Route::post('forgot', [AuthController::class, 'forgot']);

Route::get('login/as', function () {
    $year = date('Y');
    return view('login_as', compact('year'));
});

Route::get('switch/as/{role}', [UserController::class, 'switchAs']);

Route::post('login', [AuthController::class, 'login']);

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
    Route::resource('chapter.poetry-lines', AdminPoetryLineController::class);
    Route::view('change/password', 'admin.change_password');
    Route::post('change/password', [AuthController::class, 'changePassword'])->name('change.password');
});

Route::group(['prefix' => 'collaborator', 'as' => 'collaborator.', 'middleware' => ['role:collaborator']], function () {
    Route::get('/', [CollaboratorDashboardController::class, 'index']);
    Route::resource('grades', CollaboratorGradeController::class);
    Route::resource('grade.chapters', GradeChapterController::class);
    Route::resource('chapter.questions', CollaboratorChapterQuestionController::class);
});
Route::group(['prefix' => 'operator', 'as' => 'operator.', 'middleware' => ['role:operator']], function () {
    Route::get('/', [OperatorDashboardController::class, 'index']);

    Route::resource('books', BookController::class);
    Route::resource('grade.books', GradeBookController::class);
    Route::resource('books.chapters', BookChapterController::class);
    Route::resource('chapter.questions', ChapterQuestionController::class);
    Route::resource('chapter.poetry-lines', PoetryLineController::class);
    Route::resource('type-changes', QuestionTypeChangeController::class);
    Route::resource('question-movements', QuestionMovementController::class);
});

Route::group(['prefix' => 'user', 'as' => 'user.', 'middleware' => ['role:user']], function () {
    Route::get('/', [TeacherDashboardController::class, 'index']);
    Route::resource('papers', TeacherPaperController::class);
    Route::resource('paper.chapters', PaperChapterController::class);
    Route::resource('paper.questions', UserPaperQuestionController::class);
    Route::resource('paper-question-parts', PaperQuestionPartController::class);

    Route::resource('paper.question-type.partial-questions', PartialQuestionController::class);
    Route::resource('paper.question-type.simple-questions', SimpleQuestionController::class);
    Route::resource('paper.base-questions', BaseQuestionController::class);

    Route::resource('paper-question.type.extensions', PaperQuestionExtensionController::class);

    Route::resource('papers.latex-pdf', LatexPdfController::class);
    Route::resource('papers.simple-pdf', SimplePdfController::class);

    Route::resource('accounts', AccountController::class);
    Route::resource('profiles', ProfileController::class);

    Route::get('paper-question-parts/{part}/refresh', [PaperQuestionPartController::class, 'refresh'])->name('paper-question-parts.refresh');

    Route::get('papers/{paper}/key', [PaperKeyController::class, 'show'])->name('papers.keys.show');
    Route::get('papers/{paper}/key/pdf', [PaperKeyController::class, 'pdf'])->name('papers.keys.pdf');
});

Route::get('/test-api', function () {
    $res = "Divide & Conquer";
    $res = App\Helpers\Helper::parseTex($res);
    return response()->json($res);
});
