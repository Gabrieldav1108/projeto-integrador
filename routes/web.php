<?php

use App\Http\Controllers\ClassInformation as ControllersClassInformation;
use App\Http\Controllers\ClassInformationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Models\ClassInformation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


//--------------------adm-------------
Route::get('/homeAdmin', [HomeController::class, 'indexAdmin'])->name('homeAdmin');
Route::prefix('admin')->group(function() {
    Route::get('manageStudent', [StudentController::class, 'index'])->name('admin.index');
    Route::get("createStudent", [StudentController::class, 'create'])->name('student.add');
    Route::get("editStudent/{id}", [StudentController::class, 'edit'])->name('student.edit');
    Route::post("storeStudent", [StudentController::class, 'store'])->name('student.store');
    Route::delete("deleteStudent/{id}", [StudentController::class, 'destroy'])->name('student.destroy');
    Route::put("updateStudent/{id}", [StudentController::class, 'update'])->name('student.update');
});


Route::get("/manageTeachers", function () {
    return view("admin.teachers.manage");
})->name('manageTeachers');


// Rotas para Teachers
Route::prefix('admin')->group(function() {
    Route::get('teachers', [TeacherController::class, 'index'])->name('admin.teachers.manage');
    Route::get('teachers/create', [TeacherController::class, 'create'])->name('admin.teachers.create');
    Route::post('teachers', [TeacherController::class, 'store'])->name('admin.teachers.store');
    Route::get('teachers/{teacher}/edit', [TeacherController::class, 'edit'])->name('admin.teachers.edit');
    Route::put('teachers/{teacher}', [TeacherController::class, 'update'])->name('admin.teachers.update');
    Route::delete('teachers/{teacher}', [TeacherController::class, 'destroy'])->name('admin.teachers.destroy');
});

Route::get("/manageClasses", function () {
    return view("admin.classes.manage");
})->name('manageClasses');

Route::get("/createClass", function () {
    return view("admin.classes.create");
})->name('createClass');

Route::get("/editClass", function () {
    return view("admin.classes.edit");
})->name('editClass');






//teacher
Route::get('/home', [HomeController::class, 'indexSchoolClass'])->name('homeTeacher');
Route::prefix('class/{classId}')->group(function () {
    Route::get('/informations', [ClassInformationController::class, 'index'])
        ->name('class.informations');

    Route::get('/information', [ClassInformationController::class, 'show'])
        ->name('class.information.show');
        
    Route::get('/information/add', [ClassInformationController::class, 'create'])
        ->name('class.information.add');
        
    Route::post('/information', [ClassInformationController::class, 'store'])
        ->name('class.information.store');
        
    Route::get('/information/{id}/edit', [ClassInformationController::class, 'edit'])
        ->name('class.information.edit');
        
    Route::put('/information/{id}', [ClassInformationController::class, 'update'])
        ->name('class.information.update');
        
    Route::delete('/information/{id}', [ClassInformationController::class, 'destroy'])
        ->name('class.information.destroy');
});

Route::get('/studentInformation', function(){
    return view('teacher.studentInformation');
})->name('studentInformation');

Route::get('/studentGrade', function(){
    return view('teacher.editStudentGrade');
})->name('editGrade');

Route::get('/schedules', function () {
    return view('teacher.schedules');
})->name('schedules');

//student
Route::get('homeStudent', function(){
    return view('student.home');
})->name('studentHome');

Route::get('classInformation', function(){
    return view('student.classInformation');
})->name('classInformation');

Route::get('classGrade', function () {
    return view('student.classGrade');
})->name('studentClassGrade');

Route::get('schedulesStudent', function(){
    return view('student.schedules');
})->name('studentSchedules');
Route::get('/bulletin', function () {
    return view('student.bulletin');
})->name('bulletin');

//-------------------profile------------------

Route::get('/profile', function(){
    return view('user.profile');
})->name('profile');

Route::get('editProfile', function(){
    return view('user.editProfile');
})->name('editProfile');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/login');
});

require __DIR__.'/auth.php';
