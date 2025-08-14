<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


//--------------------adm-------------
Route::get("/homeAdmin", function () {
    return view("admin.home");
})->name('homeAdmin');

Route::get("/manageTeachers", function () {
    return view("admin.teachers.index");
})->name('manageTeachers');

Route::get("/createTeacher", function () {
    return view("admin.teachers.create");
})->name('createTeacher');

Route::get("/editTeacher", function () {
    return view("admin.teachers.edit");
})->name('editTeacher');


//teacher
Route::get('/home', function(){
    return view('teacher.home');
})->name('homeTeacher');

Route::get('/addClassInformation', function(){
    return view('teacher.addClassInformation');
})->name('addClassInformation');

Route::get('/editClassInformation', function(){
    return view('teacher.editClassInformation');
})->name('editClassInformation');

Route::get('class', function(){
    return view('teacher.class');
})->name('class');

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
