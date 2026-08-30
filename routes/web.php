<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminDokumenMutuController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\AdminPelaporanSpmiController;
use App\Http\Controllers\Admin\AdminJadwalAmiController;
use App\Http\Controllers\Admin\AdminKategoriDokumenController;
use App\Http\Controllers\Admin\SubKategoriDokumenController;
use \App\Http\Controllers\Admin\BeritaController;
use \App\Http\Controllers\Admin\SurveyController;
use \App\Http\Controllers\Admin\SurveyQuestionController;


use App\Models\DokumenMutu;

use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\User\SurveyIsiController;
use App\Http\Controllers\User\UserSurveyController;
use App\Http\Controllers\User\DokumenController;



use App\Http\Controllers\PublicDokumenController;
use \App\Http\Controllers\PublicBeritaController;
use App\Http\Controllers\WelcomeController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::middleware(['auth', 'role:admin-upmi'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('user', App\Http\Controllers\Admin\UserManagementController::class);
    Route::resource('dokumen', AdminDokumenMutuController::class)->parameters([
    'dokumen' => 'dokumen',
]);
Route::delete('/admin/dokumen/{dokumen}', [AdminDokumenMutuController::class, 'destroy'])->name('dokumen.destroy');

    // Route::put('dokumen/{dokumen}', [App\Http\Controllers\Admin\AdminDokumenMutuController::class, 'update'])->name('dokumen.update');
    //Route::get('/admin/dokumen/{dokumen}', [App\Http\Controllers\Admin\AdminDokumenMutuController::class, 'show'])->name('dokumen.show');
    Route::post('user/{user}/reset-password', [UserManagementController::class, 'resetPassword'])->name('user.reset-password');
    Route::resource('pelaporan', AdminPelaporanSpmiController::class);
Route::delete('admin/pelaporan/{pelaporan}', [AdminPelaporanSpmiController::class, 'destroy'])->name('pelaporan.destroy');
    Route::resource('ami', AdminJadwalAmiController::class)->parameters(['ami' => 'jadwalAmi']);
    Route::patch('ami/{id}/selesaikan', [AdminJadwalAmiController::class, 'selesaikan'])->name('ami.selesaikan');
    Route::put('ami/{ami}/update-temuan', [AdminJadwalAmiController::class, 'updateTemuan'])->name('ami.update_temuan');

    Route::resource('kategori', AdminKategoriDokumenController::class);
Route::delete('/admin/kategori/{kategori}', [AdminKategoriDokumenController::class, 'destroy'])->name('kategori.destroy');
    Route::resource('subkategori', SubKategoriDokumenController::class);
    Route::resource('berita', BeritaController::class)->parameters([
    'berita' => 'berita' 
]);

    Route::resource('survey', SurveyController::class);
    Route::get('survey/{id}/hasil', [SurveyController::class, 'hasil'])->name('survey.hasil');
    Route::get('survey/{survey}/pertanyaan/create', [SurveyQuestionController::class, 'create'])->name('survey.pertanyaan.create');
Route::post('survey/{survey}/pertanyaan', [SurveyQuestionController::class, 'store'])->name('survey.pertanyaan.store');
Route::get('/admin/survey/{survey}/pertanyaan/{pertanyaan}/edit', [SurveyQuestionController::class, 'edit'])->name('survey.pertanyaan.edit');
Route::put('/admin/survey/{survey}/pertanyaan/{pertanyaan}', [SurveyQuestionController::class, 'update'])->name('survey.pertanyaan.update');
Route::delete('survey/{survey}/pertanyaan/{pertanyaan}', [SurveyQuestionController::class, 'destroy'])->name('survey.pertanyaan.destroy');
Route::get('/admin/survey/{id}/export', [SurveyController::class, 'export'])->name('survey.export');
Route::get('/admin/survey/{id}/export-pdf', [SurveyController::class, 'exportPdf'])->name('survey.export.pdf');


});


Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/survey', [UserSurveyController::class, 'index'])->name('survey.index');
    Route::get('/{id}/isi', [UserSurveyController::class, 'fill'])->name('survey.fill');
    Route::post('/{id}/isi', [UserSurveyController::class, 'store'])->name('survey.store');

    // Jika SurveyIsiController tetap dipakai
    Route::get('/survey/{survey}/isi', [App\Http\Controllers\User\SurveyIsiController::class, 'show'])->name('survey.fill.alt');
    Route::post('/user/survey/{survey}/isi', [App\Http\Controllers\User\SurveyIsiController::class, 'store'])->name('survey.submit');
   
   
    Route::get('/', [DokumenController::class, 'index'])->name('dokumen.index');
    Route::get('/create', [DokumenController::class, 'create'])->name('dokumen.create');
    Route::post('/store', [DokumenController::class, 'store'])->name('dokumen.store');
    Route::get('/dokumen/{id}/edit', [DokumenController::class, 'edit'])->name('dokumen.edit');
    Route::put('/dokumen/{id}', [DokumenController::class, 'update'])->name('dokumen.update');
    Route::delete('/dokumen/{id}', [DokumenController::class, 'destroy'])->name('dokumen.destroy');
});


//Public
// Berita Publik
Route::get('/berita', [PublicBeritaController::class, 'index'])->name('berita.publik.index');
Route::get('/berita/{slug}', [PublicBeritaController::class, 'show'])->name('berita.publik.show');
Route::get('/dokumen-publik', [PublicDokumenController::class, 'index'])->name('dokumen.publik.index');
Route::get('/dokumen-publik/{slug}', [PublicDokumenController::class, 'show'])->name('dokumen.publik.show');
Route::get('/', [WelcomeController::class, 'index'])->name('home');
//


Route::get('/redirect-dashboard', function () {
    $user = Auth::user();

    if ($user->hasRole('admin-upmi')) {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('user.dashboard');
})->middleware(['auth'])->name('redirect.dashboard');
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
