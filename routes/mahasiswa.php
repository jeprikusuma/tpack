<?php

use App\Http\Controllers\Mahasiswa\AssignmentController;
use App\Http\Controllers\Mahasiswa\DashboardController;
use App\Http\Controllers\Mahasiswa\DiscussionController;
use App\Http\Controllers\Mahasiswa\PerceptionController;
use App\Http\Controllers\Mahasiswa\PosttestController;
use App\Http\Controllers\Mahasiswa\PretestController;
use App\Http\Controllers\Mahasiswa\ReflectionController;
use App\Http\Controllers\Mahasiswa\TopicController;
use Illuminate\Support\Facades\Route;

Route::prefix('mahasiswa')->middleware(['auth', 'role:mahasiswa'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('mahasiswa.dashboard');

    // topic
    Route::get('/topic', [TopicController::class, 'index'])->name('mahasiswa.topic');
    Route::middleware(['auth', 'topic.access'])->group(function () {
        Route::get('/topic/{topic_id}', [TopicController::class, 'subtopic'])->name('mahasiswa.subtopic');

        // discussion
        Route::get('/topic/{topic_id}/discussion', [DiscussionController::class, 'index'])->name('mahasiswa.discussion');
        Route::post('/topic/{topic_id}/discussion', [DiscussionController::class, 'store'])->name('mahasiswa.discussion.store');
        Route::post('/topic/{topic_id}/discussion/{discussion_id}', [DiscussionController::class, 'reply'])->name('mahasiswa.discussion.reply');
        Route::post('/topic/{topic_id}/discussion/{discussion_id}/delete', [DiscussionController::class, 'destroy'])->name('mahasiswa.discussion.delete');

        // reflection
        Route::get('/topic/{topic_id}/reflection', [ReflectionController::class, 'index'])->name('mahasiswa.reflection');
        Route::post('/topic/{topic_id}/reflection', [ReflectionController::class, 'store'])->name('mahasiswa.reflection.store');

        // contents
        Route::get('/topic/{topic_id}/{subtopic_id}', [TopicController::class, 'contents'])->name('mahasiswa.contents');
        Route::get('/topic/{topic_id}/{subtopic_id}/{content_id}', [TopicController::class, 'content'])->name('mahasiswa.content');
    });


    // pretest
    Route::get('/pretest', [PretestController::class, 'index'])->name('mahasiswa.pretest');
    Route::get('/pretest/do', [PretestController::class, 'do'])->name('mahasiswa.pretest.do');
    Route::post('/pretest/submit', [PretestController::class, 'submit'])->name('mahasiswa.pretest.submit');
    

    // assignment
    Route::get('/assignment', [AssignmentController::class, 'index'])->name('mahasiswa.assignment');
    Route::post('/assignment/upload', [AssignmentController::class, 'upload'])->name('mahasiswa.assignment.upload');

    // posttest
    Route::get('/posttest', [PosttestController::class, 'index'])->name('mahasiswa.posttest');
    Route::get('/posttest/do', [PosttestController::class, 'do'])->name('mahasiswa.posttest.do');
    Route::post('/posttest/submit', [PosttestController::class, 'submit'])->name('mahasiswa.posttest.submit');
    
    // perception
    Route::get('/perception', [PerceptionController::class, 'index'])->name('mahasiswa.perception');
    Route::get('/perception/do', [PerceptionController::class, 'do'])->name('mahasiswa.perception.do');
    Route::post('/perception/submit', [PerceptionController::class, 'submit'])->name('mahasiswa.perception.submit');
});