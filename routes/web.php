<?php

use App\Events\CourseStartNotification;
use Illuminate\Support\Facades\{Route, Auth};
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\{
    HomeController,
    StudentController,
    UserController,
    ClassroomController,
    EvaluationController,
    EvaluationModelController,
    CourseController,
    FileController,
    GuardianController,
    ModuleController,
    CalendarController,
    DataYoutubeController,
    VideoCourseController,
    VideoCourseClassController,
    VideoCourseFileController,
    VideoCourseModuleController,
    SwitchLanguageController,
    PreRegistrationController,
    AdminPreRegistrationController,
    AdminPreRegistrationTemporaryController,
    ChatsController,
    EventPreRegistrationController,
    PreRegistrationTemporaryController,
};
use App\Models\User;
use App\Http\Middleware\Locale;

Route::get('/', [LoginController::class, 'showLoginForm']);

Auth::routes();

Route::prefix('/preRegistration')->group(function () {
    Route::get('{courses?}', PreRegistrationController::class)
        ->name('preRegistration.form');
    Route::post('/', [PreRegistrationController::class, 'store'])
        ->name('preRegistration.store');
    Route::post('/tryGetAddressByEmail', [PreRegistrationController::class, 'tryGetAddressByEmail'])
        ->name('preRegistration.tryGetAddressByEmail');
});

Route::prefix('/gakulab-30dias')->group(function () {
    Route::get('{courses?}', PreRegistrationTemporaryController::class)
        ->name('gakulab.preRegistration.form');
    Route::post('/', [PreRegistrationTemporaryController::class, 'store'])
        ->name('preRegistration.store');
    Route::post('/tryGetAddressByEmail', [PreRegistrationTemporaryController::class, 'tryGetAddressByEmail'])
        ->name('preRegistration.tryGetAddressByEmail');
});


Route::group(['middleware' => ['auth', 'locale']], function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    Route::get('/preRegistrations/index', [AdminPreRegistrationController::class, 'index'])
        ->name('preRegistration.index');
    Route::get('/preRegistrations/{preRegistration}', [AdminPreRegistrationController::class, 'show'])
        ->name('preRegistration.show');
    Route::get('/preRegistrations/{preRegistration}/edit', [AdminPreRegistrationController::class, 'edit'])
        ->name('preRegistration.edit');
    Route::put('/preRegistrations/{preRegistration}', [AdminPreRegistrationController::class, 'update'])
        ->name('preRegistration.update');
    Route::post('/preRegistrations/delete', [AdminPreRegistrationController::class, 'destroy'])
        ->name('preRegistration.destroy');
    Route::get('/preRegistrations/{preRegistration}/approve', [AdminPreRegistrationController::class, 'approve'])
        ->name('preRegistration.approve');
    Route::post('/preRegistrations/approveStore', [AdminPreRegistrationController::class, 'approveStore'])
        ->name('preRegistration.approve.store');
    Route::post('/preRegistrations/sendWelcome', [AdminPreRegistrationController::class, 'sendWelcome'])
        ->name('preRegistration.sendWelcome');

    Route::get('/preRegistrationsTemporary/{preRegistrationTemporary}', [AdminPreRegistrationTemporaryController::class, 'show'])
        ->name('preRegistrationTemporary.show');
    

    Route::prefix('/guardians')->group(function () {
        Route::get('/', [GuardianController::class, 'index'])->name('guardians.index');
        Route::get('/create', [GuardianController::class, 'create'])->name('guardians.create');
        Route::post('/', [GuardianController::class, 'store'])->name('guardians.store');
        Route::get('/{user}', [GuardianController::class, 'show'])->name('guardians.show');
        Route::get('/{user}/edit', [GuardianController::class, 'edit'])->name('guardians.edit');
        Route::put('/{user}', [GuardianController::class, 'update'])->name('guardians.update');
        Route::delete('/{user}', [GuardianController::class, 'destroy'])->name('guardians.destroy');

        Route::get('/{user}/addStudent', [GuardianController::class, 'addStudent'])->name('guardians.addStudent');
        Route::post('/{user}/addStudentToGuardian', [GuardianController::class, 'addStudentToGuardian'])->name('guardians.addStudentToGuardian');
        Route::post('/{user}/sendAccess', [GuardianController::class, 'sendAccessEmail'])->name('guardians.sendAccessEmail');

        Route::put('/{user}/consultancy/update', [GuardianController::class, 'consultancyUpdate'])->name('guardians.consultancy.update');
    });

    Route::get('/myProfile', [UserController::class, 'myProfile'])->name('myProfile');
    Route::prefix('/users')->group(function () {
        Route::post('/getUser', [UserController::class, 'getUser'])->name('users.getUser');
        Route::get('/getStudents', [UserController::class, 'getStudents'])->name('users.getStudents');
    });
    Route::resource('users', UserController::class);

    Route::resource('chats',ChatsController::class);

    Route::resource('evaluationModels', EvaluationModelController::class);


    Route::prefix('/evaluations')->group(function () {
        Route::get('create/{classroom}', [EvaluationController::class, 'create'])->name('evaluations.create');
        Route::post('store/{classroom}', [EvaluationController::class, 'store'])->name('evaluations.store');
        Route::get('edit/{classroom}/{evaluation}', [EvaluationController::class, 'edit'])->name('evaluations.edit');
        Route::put('update/{classroom}/{evaluation}', [EvaluationController::class, 'update'])->name('evaluations.update');
        Route::delete('delete/{evaluation}', [EvaluationController::class, 'destroy'])->name('evaluations.delete');
        Route::get('show/{evaluation}', [EvaluationController::class, 'show'])->name('evaluations.show');
    });

    Route::resource('classrooms', ClassroomController::class);
    Route::prefix('/classrooms')->group(function () {
        Route::post('/getBasicData', [ClassroomController::class, 'getBasicData'])->name('classrooms.getBasicData');
        Route::get('/{id}/getSchedule', [ClassroomController::class, 'getSchedule']);
        Route::post('/addStudent', [ClassroomController::class, 'addStudent'])->name('classrooms.addStudent');
        Route::post('/removeStudent', [ClassroomController::class, 'removeStudent'])->name('classrooms.removeStudent');

        Route::get('/{classroom}/recorded-courses', [CourseController::class, 'index'])->name('classrooms.recorded-courses');

        Route::get('/{classroom}/courses/create', [CourseController::class, 'create'])->name('classrooms.courses.create');
        Route::get('/{classroom}/courses/{course}/edit', [CourseController::class, 'edit'])->name('classrooms.courses.edit');
        Route::post('/getClassroomWithEvaluationsByPeriod', [ClassroomController::class, 'getClassroomWithEvaluationsByPeriod'])->name('classrooms.getClassroomWithEvaluationsByPeriod');
    });

    Route::prefix('/courses')->group(function () {
        Route::get('/{course}/getBasicData', [CourseController::class, 'getBasicData'])->name('courses.getBasicData');
    });
    Route::resource('courses', CourseController::class);

    Route::prefix('/video-courses')->name('video-courses.')->group(function () {
        Route::post('/getBasicData', [VideoCourseController::class, 'getBasicData'])->name('getBasicData');
        Route::get('/{video_course}/students', [VideoCourseController::class, 'viewAllStudents'])->name('students');
        Route::resource('/{video_course}/modules', VideoCourseModuleController::class)->except(['index', 'show']);
        Route::resource('/{video_course}/classes', VideoCourseClassController::class)->except('index');

        Route::post('/addStudent', [VideoCourseController::class, 'addStudent'])->name('addStudent');
        Route::post('/removeStudent', [VideoCourseController::class, 'removeStudent'])->name('removeStudent');
    });

    Route::prefix('/video-course-classes')
        ->name('video-course-classes.')
        ->controller(VideoCourseClassController::class)
        ->group(function () {
            Route::get('/{class}/getBasicData', 'getBasicData')->name('getBasicData');
            Route::get('/{class}/getVideoClassData', 'getVideoClassData')->name('getVideoClassData');
            Route::put('/reorderPositions', 'reorderPositions')->name('reorderPositions');
        });

    Route::prefix('/video-course-modules')
        ->name('video-course-modules.')
        ->controller(VideoCourseModuleController::class)
        ->group(function () {
            Route::get('/{module}/getBasicData', 'getBasicData')->name('getBasicData');
            Route::put('/reorderPositions', 'reorderPositions')->name('reorderPositions');
        });
    Route::get('video-course-files/{file}', [VideoCourseFileController::class, 'downloadfile'])->name('video-course-files.download');
    Route::get('video-course-files/{file}/view', [VideoCourseFileController::class, 'viewfile'])->name('video-course-files.view');

    Route::resource('video-courses', VideoCourseController::class);

    Route::prefix('/students')->group(function () {
        Route::get('/chooseStudent', [StudentController::class, 'choose_student'])->name('students.chooseStudent');
        Route::post('/selectStudent', [StudentController::class, 'select_student'])->name('students.selectStudent');
        Route::post('/markCourseAsDone', [StudentController::class, 'mark_course_as_done'])->name('students.markCourseAsDone');
        Route::post('/unmarkCourseAsDone', [StudentController::class, 'unmark_course_as_done'])->name('students.unmarkCourseAsDone');
        Route::put('/{student}/videoCourseClassView/{class}', [StudentController::class, 'video_course_class_view'])->name('students.videoCourseClassView');
        Route::get('/getCoursesOfSelectedStudent', [StudentController::class, 'getCoursesOfSelectedStudent'])->name('students.getCoursesOfSelectedStudent');
        Route::get('/getWeeklyNotificationsByStudentSelected/{course_type?}', [StudentController::class, 'getWeeklyNotificationsByStudentSelected'])->name('students.getWeeklyNotificationsByStudentSelected');
        Route::get('/{student}/update-classroom-onboarding-preference', [StudentController::class, 'update_classroom_onboarding_preference'])->name('students.update-classroom-onboarding-preference');
        Route::get('/{student}/update-course-onboarding-preference', [StudentController::class, 'update_course_onboarding_preference'])->name('students.update-course-onboarding-preference');
        Route::put('/switchLanguage', SwitchLanguageController::class)->name('students.switchLanguage');
        Route::get('/export', [StudentController::class, 'export'])->name('students.export');
        Route::post('/getUnrelatedClassrooms', [StudentController::class, 'getUnrelatedClassrooms']);
        Route::post('/getRelatedClassrooms', [StudentController::class, 'getRelatedClassrooms']);
        Route::post('/changeClassrooms', [StudentController::class, 'changeClassrooms']);
        Route::post('/changeSeries', [StudentController::class, 'changeSeries']);
        Route::post('/includeVideoCourses', [StudentController::class, 'includeVideoCourses']);
        Route::post('/removalClassrooms', [StudentController::class, 'removalClassrooms']);
        Route::post('/evaluations/download', [StudentController::class, 'downloadEvaluations'])->name('students.evaluations.download');
        Route::post('/evaluations/filter', [StudentController::class, 'fetchEvaluationsByPeriodAndClassroom'])->name('students.evaluations.byPeriodAndClassroom');
    });
    
    Route::resource('students', StudentController::class);

    // Route::resource('modules', ModuleController::class);
    Route::prefix('/modules')->group(function () {
        Route::get('/', [ModuleController::class, 'index'])->name('modules.index');
        Route::get('/create/classroom/{classroom?}', [ModuleController::class, 'create'])->name('classrooms.modules.create');
        Route::post('/', [ModuleController::class, 'store'])->name('modules.store');
        Route::get('/{module}', [ModuleController::class, 'show'])->name('modules.show');
        Route::get('/{module}/edit', [ModuleController::class, 'edit'])->name('modules.edit');
        Route::put('/{module}', [ModuleController::class, 'update'])->name('modules.update');
        Route::delete('/{module}', [ModuleController::class, 'destroy'])->name('modules.destroy');
        Route::get('/{module}/getBasicData', [ModuleController::class, 'getBasicData'])->name('module.getBasicData');
    });

    Route::prefix('/session')->group(function () {
        Route::get('/getStudent', function () {
            return response()->json(session()->get('student_id'));
        })->name('session.getStudentId');
        Route::get('/getUserRole', function () {
            $roles = User::find(Auth::id())->roles()->get()->pluck('id')->toArray();
            return response()->json($roles);
        })->name('session.getUserRoleId');
        Route::get('/getUserId', function () {
            return response()->json(session()->get('user_id'));
        })->name('session.getUserId');
    });

    Route::prefix('/file')->group(function () {
        Route::get('/material/{material}', [FileController::class, 'downloadMaterial'])->name('materials.download');
        Route::get('/material/{material}/view', [FileController::class, 'viewMaterial'])->name('materials.view');
    });

    Route::prefix('/calendars')->group(function () {
        Route::get('/new-calendar', [CalendarController::class, 'newCalendar'])->name('calendars.newCalendar');
        Route::post('/register-event', [CalendarController::class, 'registerEvent'])->name('calendars.registerEvent');
        Route::post('/update-event', [CalendarController::class, 'updateEvent'])->name('calendars.updateEvent');
        Route::post('/delete-event', [CalendarController::class, 'deleteEvent'])->name('calendars.deleteEvent');
        Route::get('/get-events/{classroom}/{month}/{year}', [CalendarController::class, 'getEvents'])
            ->name('calendars.getEvents');
        Route::get('/get-event-by-id/{event_id}', [CalendarController::class, 'getEventById'])
            ->name('calendars.getEventById');
        Route::get('/student', [CalendarController::class, 'student'])->name('calendars.student');
        Route::get('/student-new-calendar', [CalendarController::class, 'studentNewCalendar'])->name('calendars.student.new');
        Route::get('/student/{id}', [CalendarController::class, 'calendarById'])->name('calendars.calendarById');
    });

    Route::resource('calendars', CalendarController::class);

    Route::prefix('/youtube')->group(function () {
        Route::get('/getVideos', [DataYoutubeController::class, 'getVideos']);
        Route::get('/getSearch/{keywords}', [DataYoutubeController::class, 'getSearch']);
    });
});

// Route::get('/event', function () {
//     CourseStartNotification::dispatch(1);
// });
