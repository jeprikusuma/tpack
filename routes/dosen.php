<?php

use App\Http\Controllers\Dosen\AssignmentController;
use App\Http\Controllers\Dosen\ContentController;
use App\Http\Controllers\Dosen\DashboardController;
use App\Http\Controllers\Dosen\DiscussionControler;
use App\Http\Controllers\Dosen\PerceptionController;
use App\Http\Controllers\Dosen\PosttestController;
use App\Http\Controllers\Dosen\PretestController;
use App\Http\Controllers\Dosen\ReflectionController;
use App\Http\Controllers\Dosen\SubTopicController;
use App\Http\Controllers\Dosen\TopicController;
use Illuminate\Support\Facades\Route;

Route::prefix('dosen')->middleware(['auth', 'role:dosen'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dosen.dashboard');

    Route::get('/topic', [TopicController::class, 'index'])->name('dosen.topic');
    Route::get('/topic/form/{id?}', [TopicController::class, 'form'])->name('dosen.topic.form');
    Route::post('/topic/form/{id?}', [TopicController::class, 'store'])->name('dosen.topic.store');
    Route::post('/topic/delete/{id}', [TopicController::class, 'destroy'])->name('dosen.topic.delete');
    
    //subtopic
    Route::get('/topic/{topic_id}', [SubTopicController::class, 'index'])->name('dosen.subtopic');
    Route::get('/topic/{topic_id}/form/{id?}', [SubTopicController::class, 'form'])->name('dosen.subtopic.form');
    Route::post('/topic/{topic_id}/form/{id?}', [SubTopicController::class, 'store'])->name('dosen.subtopic.store');
    Route::post('/topic/{topic_id}/delete/{id}', [SubTopicController::class, 'destroy'])->name('dosen.subtopic.delete');

    // discussion
    Route::get('/topic/{topic_id}/discussion', [DiscussionControler::class, 'index'])->name('dosen.discussion');
    Route::post('/topic/{topic_id}/discussion', [DiscussionControler::class, 'store'])->name('dosen.discussion.store');
    Route::post('/topic/{topic_id}/discussion/{discussion_id}', [DiscussionControler::class, 'reply'])->name('dosen.discussion.reply');
    Route::post('/topic/{topic_id}/discussion/{discussion_id}/delete', [DiscussionControler::class, 'destroy'])->name('dosen.discussion.delete');

    // reflection
    Route::get('/topic/{topic_id}/reflection', [ReflectionController::class, 'index'])->name('dosen.reflection');
    
    // content
    Route::get('/topic/{topic_id}/{subtopic_id}', [ContentController::class, 'index'])->name('dosen.content');
    Route::get('/topic/{topic_id}/{subtopic_id}/form/{id?}', [ContentController::class, 'form'])->name('dosen.content.form');
    Route::post('/topic/{topic_id}/{subtopic_id}/form/{id?}', [ContentController::class, 'store'])->name('dosen.content.store');
    Route::post('/topic/{topic_id}/{subtopic_id}/delete/{id?}', [ContentController::class, 'destroy'])->name('dosen.content.delete');

    
    // pretest
    Route::get('/pretest', [PretestController::class, 'index'])->name('dosen.pretest');
    Route::post('/pretest/update', [PretestController::class, 'update'])->name('dosen.pretest.update');
    
    // assignment
    Route::get('/assignment', [AssignmentController::class, 'index'])->name('dosen.assignment');
    Route::post('/assignment/update', [AssignmentController::class, 'update'])->name('dosen.assignment.update');

    // perception
    Route::get('/perception', [PerceptionController::class, 'index'])->name('dosen.perception');
    Route::post('/perception/update', [PerceptionController::class, 'update'])->name('dosen.perception.update');
    Route::get('/perception/{studentId}', [PerceptionController::class, 'show'])->name('dosen.perception.show');

    // posttest
    Route::get('/posttest', [PosttestController::class, 'index'])->name('dosen.posttest');
    Route::post('/posttest/update', [PosttestController::class, 'update'])->name('dosen.posttest.update');

});
