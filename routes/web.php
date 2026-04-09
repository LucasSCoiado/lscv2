<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConfirmAccountController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\PacientesController;
use App\Http\Controllers\UserController;
use App\Models\Admin;

Route::middleware('guest')->group(function (): void {
    Route::view('/login', 'auth.login')->name('login');

    // forgot pass
    Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');
    Route::post('/forgot-password', [AuthController::class, 'sendRessetPasswordLink'])->name('send_restart_password_link');

    // reset pass
    Route::get('/reset-password/{token}', [AuthController::class, 'reset_password'])->name('reset_password');
    Route::post('/reset-password', [AuthController::class, 'reset_password_update'])->name('reset_password_update');
});

// rotas públicas para confirmação de conta
Route::get('/confirm-account/{token}', [ConfirmAccountController::class, 'confirmAccount'])->name('confirm.account');
Route::post('/confirm-account-submit', [ConfirmAccountController::class, 'confirmAcountSubmit'])->name('confirm.account.submit');

Route::middleware('auth')->group(function () {
    Route::get('/', [MainController::class, 'index'])->name('home');

    // dados 
    Route::get('/dados/paciente/{id}', [MainController::class, 'showPaciente'])->name('dados.paciente');
    Route::get('/dados/medico/{id}', [MainController::class, 'showMedico'])->name('dados.medico');
    Route::get('/pacientes', [MainController::class, 'allPacientes'])->name('allPacientes');

    // Admin

    // PACIENTES
    Route::get('/admin-user/paciente', [MainController::class, 'pacientes'])->name('admin.pacientes');
    // Cadastro paciente
    Route::get('/admin-user/paciente/create', [AdminController::class, 'cadastrarPaciente'])->name('admin.cadastrar_paciente');
    Route::post('/admin-user/paciente/store', [AdminController::class, 'storePaciente'])->name('admin.store_paciente');

    // editar paciente
    Route::get('/admin-user/paciente/editar/{id}', [AdminController::class, 'editPacientes'])->name('admin.edit_paciente');
    Route::post('/admin-user/paciente/{id}', [AdminController::class, 'updatePaciente'])->name('admin.update_paciente');
    // atualizar foto do paciente
    Route::post('/admin-user/paciente/{id}/foto', [AdminController::class, 'updateFoto'])->name('admin.update_paciente_foto');

    // apagar paciente
    Route::get('/admin-user/paciente/apagar/{id}', [AdminController::class, 'deletarPacientes'])->name('admin.deletar_paciente');
    Route::post('/admin-user/paciente/destroy/{id}', [AdminController::class, 'destroyPacientes'])->name('admin.destroy_paciente');

    // MÉDICOS
    Route::get('/admin-user/medico', [AdminController::class, 'medicos'])->name('admin.medicos');

    // cadastro de médicos
    Route::get('/admin-user/medico/create', [AdminController::class, 'cadastrarMedico'])->name('admin.create_medico');
    Route::post('/admin-user/medico/store', [AdminController::class, 'storeMedico'])->name('admin.store_medico');

    // Editar médicos
    Route::get('/admin-user/medico/edit/{id}', [AdminController::class, 'editMedicos'])->name('admin.edit_medico');
    Route::post('/admin-user/medico/update/{id}', [AdminController::class, 'updateMedicos'])->name('admin.update_medico');

    // Delete médicos
    Route::get('/admin-user/medicos/apagar/{id}', [AdminController::class, 'deleteMedicos'])->name('admin.deletar_medico');
    Route::post('/admin-user/medicos/destroy/{id}', [AdminController::class, 'destroyMedicos'])->name('admin.destroy_medico');

    // Usuario
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/alterar-senha/{id}', [UserController::class, 'alterarSenha'])->name('user.alter-senha');
    Route::post('/user/profile/update-password/{id}', [UserController::class, 'updatePassword'])->name('user.update-password');

    Route::get('/user/confirm-password/{token}', [UserController::class, 'confirmPass'])->name('user.confirm-pass');
    Route::post('/user/confirm-password-submit', [UserController::class, 'confirmPassSubmit'])->name('user.confirm-pass-submit');

    Route::get('/user/alterar-dados/{id}', [UserController::class, 'editUser'])->name('user.edit-user');
    Route::post('/user/alterar-dados-submit/{id}', [UserController::class, 'updateUser'])->name('user.update-user');

    // Pacientes Crises
    Route::get('/crises', [PacientesController::class, 'index'])->name('paciente.crises');

    //create
    Route::get('/create', [PacientesController::class, 'create'])->name('create');
    Route::post('/store', [PacientesController::class, 'store'])->name('store');

    //edit
    Route::get('/edit/{id}', [PacientesController::class, 'edit'])->name('edit');
    Route::post('/update', [PacientesController::class, 'update'])->name('update');

    //Delete
    Route::get('/delete/{id}', [PacientesController::class, 'delete'])->name('delete');
    Route::get('/destroy/{id}', [PacientesController::class, 'destroy'])->name('destroy');

    // dados crise
    // allow optional id so we can also access this page via query parameters from the calendar
    Route::get('/dados-crise/{id}', [PacientesController::class, 'dadosCrise'])->name('dados.crise');
});
