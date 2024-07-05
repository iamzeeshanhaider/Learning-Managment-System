<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ActivityLogsController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\CourseMasterController;
use App\Http\Controllers\FrontEnd\AboutUsController;
use App\Http\Controllers\FrontEnd\ContactUsController;
use App\Http\Controllers\FrontEnd\CourseController as FrontEndCourseController;
use App\Http\Controllers\FrontEnd\FrontEndEventController;
use App\Http\Controllers\LessonResourceController;
use App\Http\Controllers\LocationsController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TicketsController;
use App\Http\Controllers\TicketCategoryController;
use App\Http\Controllers\ChatLayerController;
use App\Http\Controllers\ChatQuestionsController;
use App\Http\Controllers\ChatOptionsController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ChatRequestsController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\LessonFolderController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\UserRegistration;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes(['register' => false]);

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/Courses', [FrontEndCourseController::class, 'index'])->name('Courses.index');
Route::get('/Courses/{course}/{slug?}', [FrontEndCourseController::class, 'single'])->name('Courses.single');
Route::post('/Courses/store/{slug?}', [FrontEndCourseController::class, 'enroll'])->name('Courses.enroll');

// Route::get('/teachers', [TeacherController::class, 'index'])->name('teachers.index');
// Route::get('/teachers/{slug}', [TeacherController::class, 'single'])->name('teachers.single');

Route::get('/aboutUs', [AboutUsController::class, 'index'])->name('aboutUs.index');
Route::get('/aboutUs/{slug}', [AboutUsController::class, 'single'])->name('aboutUs.single');

Route::get('/contactUs', [ContactUsController::class, 'index'])->name('contactUs.index');
Route::get('/contactUs/{slug}', [ContactUsController::class, 'single'])->name('contactUs.single');

Route::get('/Events', [FrontEndEventController::class, 'index'])->name('Events.index');
Route::get('/Events/{slug}', [FrontEndEventController::class, 'single'])->name('Events.single');

Route::get('Category/{slug}', [CategoryController::class, 'single'])->name('Categories.single');


// TODO: review this
Route::get('/registration', [UserRegistration::class, 'index']);

Route::group(['middleware' => ['auth', 'is_enabled']], function () {

    Route::group(['middleware' => ['has_completed_profile']], function () {

        Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

        // Admin, Instructor
        Route::group(['middleware' => ['role:Admin|Instructor']], function () {
            Route::resource('categories', CategoryController::class)->parameter('categories', 'category:slug');
            Route::resource('modules', ModuleController::class)->parameter('modules', 'module:slug');
            Route::resource('locations', LocationsController::class)->parameter('locations', 'location:slug');
            Route::resource('batches', BatchController::class)->parameter('batches', 'batch:slug')->except(['destroy']);

            // Course Master & Courses
            Route::resource('courses_masters', CourseMasterController::class)->parameter('courses_masters', 'course_master:slug');
            Route::resource('courses', CourseController::class)->parameter('courses', 'course:slug')->except(['destroy']);
            Route::resource('quiz', QuizController::class)->parameter('quiz', 'quiz:slug')->except(['store', 'update']);
            Route::get('quiz/{quiz:slug}/clone', [QuizController::class, 'clone'])->name('quiz.clone');

            // Lesson & Lesson Resources
            Route::resource('lessons', LessonController::class)->parameter('lessons', 'lesson:slug')->except('destroy');
            Route::group(['prefix' => '/lessons/{lesson:slug}', 'as' => 'lesson.',], function () {
                Route::resource('/folder', LessonFolderController::class)->parameter('folder', 'folder:slug')->except(['show']);
                Route::get('{folder:slug}/duplicate', [LessonFolderController::class, 'duplicate_folder'])->name('folder.duplicate');
                Route::resource('{folder:slug}/resource', LessonResourceController::class)->parameter('resource', 'resource:slug')->except(['show']);
                Route::get('resource', [LessonResourceController::class, 'unlisted_resources'])->name('resource.unlisted');
                Route::get('resource/{resource:slug}', [LessonResourceController::class, 'init_add_to_folder'])->name('resource.init_add_to_folder');
                Route::post('resource/{resource:slug}', [LessonResourceController::class, 'add_to_folder'])->name('resource.add_to_folder');
            });



            // Users by group
            Route::resource('{group?}/users', UserController::class)->parameter('users', 'user:slug')->except(['destroy'])->whereIn('group', ['admin', 'student', 'instructor']);

            Route::get('handle_enrolment', [StudentController::class, 'init_handle_enrolment'])->name('students.bulk_enrol.init');
            Route::post('handle_enrolment', [StudentController::class, 'handle_enrolment'])->name('students.bulk_enrol');
            Route::get('payment_log/{payment_log}', [StudentController::class, 'show_payment_log'])->name('student.payment_log');
            Route::get('update_payment_log/{batchUser}', [StudentController::class, 'init_update_payment'])->name('student.payment.add');
            Route::post('update_payment_log/{payment}', [StudentController::class, 'update_payment'])->name('student.payment.update');

        });

        // Student Only - assumed to be students
        Route::group(['prefix' => '/student', 'as' => 'student.', 'middleware' => ['role:Student']], function () {
            Route::get('/dashboard', [HomeController::class, 'index'])->name('student_dashboard');
            Route::get('/courses', [CourseController::class, 'user_courses'])->name('courses');
            Route::get('/courses/{course}/show', [CourseController::class, 'show_user_courses'])->name('courses.show');
            Route::get('{action?}/quiz/{quizzes:slug}', [QuizController::class, 'attempt_quiz'])->name('quiz.attempt')->whereIn('action', ['init', 'attempt']);
        });

        // All authenticated users
        Route::get('lessons/{lesson:slug}/{resource:slug}', [LessonResourceController::class, 'show'])->name('lesson.resource.show');
        Route::resource('settings', SettingController::class);
        Route::resource('{quiz:slug}/submission', SubmissionController::class)->except(['create', 'destroy']);

        // General Items
        Route::get('/all_courses', [GeneralController::class, 'get_courses'])->name('courses.list');
        Route::get('/all_batches', [GeneralController::class, 'get_batches'])->name('batches.list');
        Route::get('/calendar', [GeneralController::class, 'init_calendar'])->name('calendar');
        Route::get('/sessions', [GeneralController::class, 'init_sessions'])->name('sessions');

        // Attendance
        Route::get('attendance', [AttendanceController::class, 'index'])->name('attendance.index');

        Route::resource('events', EventController::class)->parameter('events', 'event:slug')->except(['store', 'update']);

        Route::resource('reviews', ReviewController::class);


        // Paypal Routes
        Route::get('payment-success', [PaymentController::class, 'success'])->name('payment.success');
        Route::get('payment-cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');

        Route::post('/upload', [TicketsController::class, 'update'])->name('lessons.image-upload');

        //Ticket Routes
        Route::resource('tickets', TicketsController::class)->parameter('tickets', 'ticket:slug');
        Route::resource('ticket_category', TicketCategoryController::class)->parameter('ticket_category', 'ticket_category:slug');

        Route::resource('chat_layers', ChatLayerController::class);
        Route::resource('chat_questions', ChatQuestionsController::class);
        Route::resource('chat_options', ChatOptionsController::class);
        Route::resource('live_chat', ChatController::class)->except('store');
        Route::get('/chat-room', [ChatController::class, 'chatroom'])->name('chat_room');
        Route::get('/chat_assign/{chat}', [ChatController::class, 'chat_assign'])->name('chat_assign');

        Route::get('logs', [ActivityLogsController::class, 'index'])->name('logs');
        Route::get('logs/{log}', [ActivityLogsController::class, 'show'])->name('logs.show');
        Route::resource('chat_requests', ChatRequestsController::class);
    });

    // User Profile
    Route::get('profile', [UserProfileController::class, 'index'])->name('user.profile');
    Route::post('profile_photo', [UserProfileController::class, 'storePhoto'])->name('user.profile.photo');
    Route::post('update_password', [UserProfileController::class, 'updatePassword'])->name('user.profile.password');

    // Certificate
    Route::group(['prefix' => '/certificate', 'as' => 'certificate.'], function () {
        Route::get('/preview', [CertificateController::class, 'preview'])->name('preview');
        Route::get('/{certificate}/download', [CertificateController::class, 'download'])->name('download');
        Route::get('/{certificate}/revoke', [CertificateController::class, 'revoke'])->name('revoke');
        Route::get('/{certificate}/send-to-mail', [CertificateController::class, 'send'])->name('send');
        Route::post('/{certificate}/send-to-mail', [CertificateController::class, 'sendToMail'])->name('send-to-mail');
        Route::get('/{student}/{course}/preview', [CertificateController::class, 'student_certificate'])->name('student_certificate');
    });


});


