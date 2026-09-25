<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\InvitationLinkController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware('throttle:60,1')->group(function () {

    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'signIn'])->name('signIn');
        Route::post('register', [AuthController::class, 'signUp'])->name('signUp');
        Route::get('link/verify', [InvitationLinkController::class, 'verify'])->name('verify.link');

        Route::middleware('login.verify')->get('logout', [AuthController::class, 'signOut'])->name('signOut');
    });

    Route::middleware('login.verify')->group(function () {
        Route::get('link/generate', [InvitationLinkController::class, 'generate'])->name('generate.link');

        Route::apiResource('project', ProjectController::class);
        Route::get('project/{project}/tickets',[ProjectController::class, 'getProjectTickets']);
        Route::apiResource('ticket', TicketController::class);
        Route::patch('ticket-status/{ticket}', [TicketController::class, 'updateStatus']);

        Route::get('assignee',[UserController::class,'getAssignees']);
    });

    Route::get('/identity-check', function (Request $request) {
        if (! in_array($_GET['slug'], ['login']) && request()->user()->getTenant()?->slug !== $_GET['slug']) {
            return response()->json([
                'message' => 'Unauthenticated',
                'status' => false,
                'data' => null,
            ], 401);
        }

        return response()->json([
            'message' => 'Authenticated',
            'status' => true,
            'data' => [
                'user' => request()->user(),
                'slug' => request()->user()->getTenant()?->slug,
            ],
        ]);
    })->middleware('login.verify');
});
