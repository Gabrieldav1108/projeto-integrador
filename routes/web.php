<?php

use App\Http\Controllers\Admin\ClassSubjectController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\AssignmentSubmissionController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\ClassInformationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentAssignmentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\Teacher\GradeController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\Teacher\TeacherStudentController;
use Illuminate\Support\Facades\Route;

//-------------------- Rotas Públicas --------------------
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

//-------------------- Rotas Autenticadas Comuns --------------------
Route::middleware(['auth'])->group(function () {
    // Logout
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    
    // Perfil (comum a todos os usuários)
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    
    // Home baseada no role
    Route::get('/', [HomeController::class, 'redirectToRoleBasedHome'])->name('home');
});

//-------------------- ADMIN --------------------
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function() {
    Route::get('home', [HomeController::class, 'indexAdmin'])->name('admin.home');
    Route::get('dashboard', [HomeController::class, 'indexAdmin'])->name('admin.dashboard');

    Route::get('classes/{classId}/subjects', [ClassSubjectController::class, 'edit'])
        ->name('admin.classes.subjects.edit');
    Route::put('classes/{classId}/subjects', [ClassSubjectController::class, 'update'])
        ->name('admin.classes.subjects.update');
    
    // Gerenciar Estudantes
    Route::prefix('students')->group(function() {
        Route::get('/', [StudentController::class, 'index'])->name('admin.students.index');
        Route::get('create', [StudentController::class, 'create'])->name('admin.students.create');
        Route::post('store', [StudentController::class, 'store'])->name('admin.students.store');
        Route::get('{id}/edit', [StudentController::class, 'edit'])->name('admin.students.edit');
        Route::put('{id}/update', [StudentController::class, 'update'])->name('admin.students.update');
        Route::delete('{id}/delete', [StudentController::class, 'destroy'])->name('admin.students.destroy');
    });

    // Gerenciar Professores
    Route::prefix('teachers')->group(function() {
        Route::get('/', [TeacherController::class, 'index'])->name('admin.teachers.index');
        Route::get('create', [TeacherController::class, 'create'])->name('admin.teachers.create');
        Route::post('store', [TeacherController::class, 'store'])->name('admin.teachers.store');
        Route::get('{teacher}/edit', [TeacherController::class, 'edit'])->name('admin.teachers.edit');
        Route::put('{teacher}/update', [TeacherController::class, 'update'])->name('admin.teachers.update');
        Route::delete('{teacher}/delete', [TeacherController::class, 'destroy'])->name('admin.teachers.destroy');
    });

    // Gerenciar Turmas
    Route::prefix('classes')->group(function() {
        Route::get('/', [ClassController::class, 'index'])->name('admin.classes.index');
        Route::get('create', [ClassController::class, 'create'])->name('admin.classes.create');
        Route::post('store', [ClassController::class, 'store'])->name('admin.classes.store');
        Route::get('{class}/edit', [ClassController::class, 'edit'])->name('admin.classes.edit');
        Route::put('{class}/update', [ClassController::class, 'update'])->name('admin.classes.update');
        Route::delete('{class}/delete', [ClassController::class, 'destroy'])->name('admin.classes.destroy');
        Route::get('{class}/show', [ClassController::class, 'show'])->name('admin.classes.show');
    });
});

//-------------------- TEACHER --------------------
Route::prefix('teacher')->middleware(['auth', 'role:teacher'])->group(function() {
    Route::get('home', [HomeController::class, 'indexTeacher'])->name('teacher.home');
    Route::get('dashboard', [HomeController::class, 'indexTeacher'])->name('teacher.dashboard');
    
    // Turmas do Professor
    Route::prefix('classes')->group(function() {
        Route::get('{classId}', [ClassController::class, 'show'])->name('teacher.classes.show');
    });

    // Informações de Turma
    Route::prefix('class/{classId}')->group(function () {
        Route::get('/informations', [ClassInformationController::class, 'index'])
            ->name('teacher.class.informations');
        Route::get('/information/create', [ClassInformationController::class, 'create'])
            ->name('teacher.class.information.add');
        Route::post('/information', [ClassInformationController::class, 'store'])
            ->name('teacher.class.information.store');
        Route::get('/information/{information}/edit', [ClassInformationController::class, 'edit'])
            ->name('teacher.class.information.edit');
        Route::put('/information/{information}', [ClassInformationController::class, 'update'])
            ->name('teacher.class.information.update');
        Route::delete('/information/{information}', [ClassInformationController::class, 'destroy'])
            ->name('teacher.class.information.destroy');



        //trabalhos - LISTA DE TRABALHOS
        Route::get('/assignments', [AssignmentController::class, 'show'])
            ->name('assignments');

        // CRIAR TRABALHO
        Route::get('/assignment/create', [AssignmentController::class, 'create'])
            ->name('assignment.create');
        Route::post('/assignment', [AssignmentController::class, 'store'])
            ->name('assignment.store');

        // EDITAR / ATUALIZAR TRABALHO
        Route::get('/assignment/{assignment}/edit', [AssignmentController::class, 'edit'])
            ->name('assignment.edit');
        Route::put('/assignment/{assignment}', [AssignmentController::class, 'update'])
            ->name('assignment.update');

        Route::delete('/assignment/{assignment}', [AssignmentController::class, 'destroy'])
            ->name('assignment.destroy');

        // ROTAS DE SUBMISSÕES (usando AssignmentSubmissionController)
        Route::get('/assignment/{assignment}/submissions', [AssignmentSubmissionController::class, 'showSubmissions'])
            ->name('assignment.submissions');

        Route::post('/grades/student/{studentId}/assignment', [AssignmentSubmissionController::class, 'updateAssignmentGrade'])
            ->name('teacher.grades.update-assignment');

        Route::post('/assignment/{assignment}/submission/{submission}/grade', [AssignmentSubmissionController::class, 'gradeSubmission'])
            ->name('assignment.submission.grade');

        Route::get('/assignment/{assignment}/submission/{submission}/download', [AssignmentSubmissionController::class, 'downloadSubmission'])
            ->name('assignment.submission.download');

        Route::delete('/assignment/{assignment}/submission/{submission}', [AssignmentSubmissionController::class, 'destroy'])
            ->name('assignment.submission.destroy');
        });

    // Estudantes - AGORA USANDO O CONTROLLER DO PROFESSOR
    Route::prefix('students')->group(function() {
        Route::get('/', [TeacherStudentController::class, 'show'])
            ->name('teacher.students.index');
        Route::get('all', [TeacherStudentController::class, 'show'])
            ->name('teacher.students.all');
        Route::get('class/{classId}', [TeacherStudentController::class, 'showByClass'])
            ->name('teacher.students.by-class');
        Route::get('{studentId}', [TeacherStudentController::class, 'show'])
            ->name('teacher.students.show');
        Route::get('user/{userId}', [TeacherStudentController::class, 'showByUser']) // ← ADICIONE ESTA
        ->name('teacher.students.showByUser');
    });

    // Notas
    Route::prefix('grades')->group(function () {
        Route::get('/student/{studentId}/create', [GradeController::class, 'create'])->name('teacher.grades.create');
        Route::post('/student/{studentId}', [GradeController::class, 'store'])->name('teacher.grades.store');
        Route::get('/student/{studentId}/edit/{gradeId}', [GradeController::class, 'edit'])->name('teacher.grades.edit');
        Route::put('/student/{studentId}/{gradeId}', [GradeController::class, 'update'])->name('teacher.grades.update');
        Route::delete('/student/{studentId}/{gradeId}', [GradeController::class, 'destroy'])->name('teacher.grades.destroy');
    });

        Route::get('schedules', function(){
        return view('teacher.schedules');
    })->name('teacher.schedules');
});

//-------------------- STUDENT --------------------
Route::prefix('student')->middleware(['auth', 'role:student'])->group(function() {
    Route::get('home', [HomeController::class, 'indexStudent'])->name('student.home');
    Route::get('dashboard', [HomeController::class, 'indexStudent'])->name('student.dashboard'); 
    
    Route::get('/assignments', [StudentAssignmentController::class, 'index'])
    ->name('student.assignments');
    
    // Trabalhos por matéria
    Route::get('/assignments/subject/{subjectId}', [StudentAssignmentController::class, 'showSubjectAssignments'])
    ->name('student.assignments.subject');
    
    // Detalhes do trabalho
    Route::get('/assignment/{assignmentId}', [StudentAssignmentController::class, 'show'])
    ->name('student.assignment.show');
    
    // Entrega do trabalho
    Route::get('/assignment/{assignmentId}/submit', [StudentAssignmentController::class, 'createSubmission'])
    ->name('student.assignment.submit');
    Route::post('/assignment/{assignmentId}/submit', [StudentAssignmentController::class, 'storeSubmission'])
    ->name('student.assignment.submit.store');
    
    // Minhas entregas
    Route::get('/my-submissions', [StudentAssignmentController::class, 'mySubmissions'])
    ->name('student.submissions');

    // Matérias do estudante  
       Route::get('subject/{subjectId}', [StudentController::class, 'showSubject'])
        ->name('student.subject.show');

    // Minhas Notas
    Route::get('/grades', [StudentController::class, 'showGrades'])->name('grades.index');
    Route::get('/grades/subject/{subjectId}', [StudentController::class, 'showGrades'])->name('grades.subject');

    // Meus Horários
    Route::get('schedules', function(){
        return view('student.schedules');
    })->name('student.schedules.index');
    
    // Meu Boletim
    Route::get('bulletin', function () {
        return view('student.bulletin');
    })->name('student.bulletin');
    
    // Meu Desempenho
    Route::get('performance', function() {
        return view('student.performance');
    })->name('student.performance');
});

require __DIR__.'/auth.php';