<?php

use App\Http\Controllers\ConsumerController;
use App\Http\Controllers\MovementRecordController;
use App\Http\Controllers\OperationController;
use App\Http\Controllers\SubConsumerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Models\MovementRecord;
use App\Models\Operation;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return view('auth.login');
    });
    Route::get('/register', function () {
        return view('auth.register');
    });
});

Route::get('/dashboard', function () {
    $operaions = Operation::orderByDesc('date')->orderByDesc('created_at')->take(10)->get();
    return view('home', ['operations' => $operaions]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::resource('users', UserController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('users/password-reset/{user}', [UserController::class, 'passwordReset'])->name('users.password-reset');
    Route::put('users/password-reset/{user}', [UserController::class, 'updatePassword'])->name('users.updatePassword');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('consumers', ConsumerController::class);
    Route::resource('sub_consumers', SubConsumerController::class);
    Route::POST('operations/store-income', [OperationController::class, 'store_income'])->name('operations.store-income');
    Route::get('operations/create-income', [OperationController::class, 'createIncome'])->name('operations.create-income');

    Route::get('operations/index-income/{time}', [OperationController::class, 'indexIncome'])->name('operations.index-income');
    Route::get('operations/index-outcome/{time}', [OperationController::class, 'indexOutcome'])->name('operations.index-outcome');

    Route::get('operations/search', [OperationController::class, 'search'])->name('operations.search');
    Route::get('operations/search-result', [OperationController::class, 'searchResult'])->name('operations.search-result');
    Route::get('operations/print', [OperationController::class, 'print'])->name('operations.print');

    Route::get('operations/create-outcome/{consumer_id}', [ConsumerController::class, 'getSubConsumers'])->name('operations.getSubConsumer');
    Route::get('operations/create-outcome', [OperationController::class, 'createOutcome'])->name('operations.create-outcome');
    Route::PUT('operations/update-income/{operation}', [OperationController::class, 'update'])->name('operations.update');
    Route::PUT('operations/update-income/{operation}', [OperationController::class, 'updateIncome'])->name('operations.update-income');
    Route::get('operations/{operation}/show-income', [OperationController::class, 'showIncome'])->name('operations.show-income');
    Route::get('operations/{operation}/show-outcome', [OperationController::class, 'showOutcome'])->name('operations.show-outcome');
    Route::get('operations/{operation}/edit-outcome/{page}', [OperationController::class, 'editOutcome'])->name('operations.edit-outcome');
    Route::get('operations/{operation}/edit-income/{page}', [OperationController::class, 'editIncome'])->name('operations.edit-income');
    Route::resource('operations', OperationController::class);
    Route::get('movement_records/{sub_consumer_id}/create', [MovementRecordController::class, 'create'])->name('movement_records.create');
    Route::post('movement_records/{sub_consumer_id}', [MovementRecordController::class, 'store'])->name('movement_records.store');
    Route::get('movement_records/{sub_consumer_id}/edit/{movement_record}', [MovementRecordController::class, 'edit'])->name('movement_records.edit');
    Route::PUT('movement_records/{movement_record}', [MovementRecordController::class, 'update'])->name('movement_records.update');
    Route::delete('movement_records/{movement_record}', [MovementRecordController::class, 'destroy'])->name('movement_records.destroy');
    Route::get('sub_consumers/{consumer}/create', [SubConsumerController::class, 'create'])->name('sub_consumers.create');

    // Route::resource('movement_records', MovementRecordController::class);
    Route::view('/invoice-print', 'invoice-print')->name('invoice-print');
});



require __DIR__ . '/auth.php';
