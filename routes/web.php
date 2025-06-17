<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/home', function(){
    return view('teacher.home');
})->name('homeTeacher');

Route::get('/classInformation', function(){
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';
