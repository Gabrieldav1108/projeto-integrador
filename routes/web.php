<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

//teacher
Route::get('/home', function(){
    return view('teacher.home');
})->name('homeTeacher');

Route::get('/addClassInformation', function(){
    return view('teacher.addClassInformation');
})->name('classInformation');

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';
