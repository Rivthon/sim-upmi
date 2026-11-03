<?php

use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\AccreditationController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminDokumenMutuController;
use App\Http\Controllers\Admin\AdminJadwalAmiController;
use App\Http\Controllers\Admin\AdminKategoriDokumenController;
use App\Http\Controllers\Admin\AdminPelaporanSpmiController;
use App\Http\Controllers\Admin\AmiFollowUpController;
use App\Http\Controllers\Admin\BackupRestoreController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\CapaController;
use App\Http\Controllers\Admin\DocumentApprovalController;
use App\Http\Controllers\Admin\ExecutiveReportController;
use App\Http\Controllers\Admin\ManagementReviewController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\PpeppMonitoringController;
use App\Http\Controllers\Admin\QualityCalendarController;
use App\Http\Controllers\Admin\QualityIndicatorController;
use App\Http\Controllers\Admin\QualityRecommendationController;
use App\Http\Controllers\Admin\QualityRiskController;
use App\Http\Controllers\Admin\QualityStandardController;
use App\Http\Controllers\Admin\SiteContentController;
use App\Http\Controllers\Admin\SubKategoriDokumenController;
use App\Http\Controllers\Admin\SurveyController;
use App\Http\Controllers\Admin\SurveyQuestionController;
use App\Http\Controllers\Admin\UnitMonitoringController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicBeritaController;
use App\Http\Controllers\PublicDokumenController;
use App\Http\Controllers\PublicSurveyController;
use App\Http\Controllers\User\DokumenController;
use App\Http\Controllers\User\UserSurveyController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('activity-log', [ActivityLogController::class, 'index'])->name('activity-log.index');
    Route::get('activity-log/{activityLog}', [ActivityLogController::class, 'show'])->name('activity-log.show');
    Route::resource('site-content', SiteContentController::class)->except(['show']);
    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('backup-restore', [BackupRestoreController::class, 'index'])->name('backup-restore.index');
    Route::post('backup-restore/backup', [BackupRestoreController::class, 'backup'])->name('backup-restore.backup');
    Route::post('backup-restore/restore', [BackupRestoreController::class, 'restore'])->name('backup-restore.restore');
    Route::get('backup-restore/download/{file}', [BackupRestoreController::class, 'download'])->name('backup-restore.download');
    Route::get('ami-follow-up', [AmiFollowUpController::class, 'index'])->name('ami-follow-up.index');
    Route::get('ami-follow-up/{ami}/edit', [AmiFollowUpController::class, 'edit'])->name('ami-follow-up.edit');
    Route::put('ami-follow-up/{ami}', [AmiFollowUpController::class, 'update'])->name('ami-follow-up.update');
    Route::resource('quality-standards', QualityStandardController::class)->except(['show']);
    Route::resource('quality-indicators', QualityIndicatorController::class)->except(['show']);
    Route::resource('ppepp-monitorings', PpeppMonitoringController::class)->except(['show']);
    Route::resource('quality-risks', QualityRiskController::class)->except(['show']);
    Route::resource('unit-monitorings', UnitMonitoringController::class)->except(['show']);
    Route::resource('accreditations', AccreditationController::class)->except(['show']);
    Route::resource('recommendations', QualityRecommendationController::class)->except(['show']);
    Route::get('executive-reports', [ExecutiveReportController::class, 'index'])->name('executive-reports.index');
    Route::resource('management-reviews', ManagementReviewController::class)->except(['show']);
    Route::resource('capas', CapaController::class)->except(['show']);
    Route::resource('quality-calendars', QualityCalendarController::class)->except(['show']);

    Route::resource('user', UserManagementController::class);
    Route::get('dokumen/{dokumen}/download', [AdminDokumenMutuController::class, 'download'])->name('dokumen.download');
    Route::post('dokumen/{dokumen}/approve', [DocumentApprovalController::class, 'approve'])->name('dokumen.approve');
    Route::post('dokumen/{dokumen}/reject', [DocumentApprovalController::class, 'reject'])->name('dokumen.reject');
    Route::resource('dokumen', AdminDokumenMutuController::class)->parameters([
        'dokumen' => 'dokumen',
    ]);

    // Route::put('dokumen/{dokumen}', [App\Http\Controllers\Admin\AdminDokumenMutuController::class, 'update'])->name('dokumen.update');
    // Route::get('/admin/dokumen/{dokumen}', [App\Http\Controllers\Admin\AdminDokumenMutuController::class, 'show'])->name('dokumen.show');
    Route::post('user/{user}/reset-password', [UserManagementController::class, 'resetPassword'])->name('user.reset-password');
    Route::get('pelaporan/{pelaporan}/download', [AdminPelaporanSpmiController::class, 'download'])->name('pelaporan.download');
    Route::resource('pelaporan', AdminPelaporanSpmiController::class);
    Route::resource('ami', AdminJadwalAmiController::class)->parameters(['ami' => 'jadwalAmi']);
    Route::patch('ami/{id}/selesaikan', [AdminJadwalAmiController::class, 'selesaikan'])->name('ami.selesaikan');
    Route::put('ami/{ami}/update-temuan', [AdminJadwalAmiController::class, 'updateTemuan'])->name('ami.update_temuan');

    Route::resource('kategori', AdminKategoriDokumenController::class)->except(['show']);
    Route::resource('subkategori', SubKategoriDokumenController::class)->except(['show']);
    Route::resource('berita', BeritaController::class)->parameters([
        'berita' => 'berita',
    ]);

    Route::resource('survey', SurveyController::class);
    Route::get('survey/{id}/hasil', [SurveyController::class, 'hasil'])->name('survey.hasil');
    Route::get('survey/{survey}/pertanyaan/create', [SurveyQuestionController::class, 'create'])->name('survey.pertanyaan.create');
    Route::post('survey/{survey}/pertanyaan', [SurveyQuestionController::class, 'store'])->name('survey.pertanyaan.store');
    Route::get('survey/{survey}/pertanyaan/{pertanyaan}/edit', [SurveyQuestionController::class, 'edit'])->name('survey.pertanyaan.edit');
    Route::put('survey/{survey}/pertanyaan/{pertanyaan}', [SurveyQuestionController::class, 'update'])->name('survey.pertanyaan.update');
    Route::delete('survey/{survey}/pertanyaan/{pertanyaan}', [SurveyQuestionController::class, 'destroy'])->name('survey.pertanyaan.destroy');
    Route::get('survey/{id}/export', [SurveyController::class, 'export'])->name('survey.export');
    Route::get('survey/{id}/export-pdf', [SurveyController::class, 'exportPdf'])->name('survey.export.pdf');

});

Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/survey', [UserSurveyController::class, 'index'])->name('survey.index');
    Route::get('/survey/{id}/isi', [UserSurveyController::class, 'fill'])->name('survey.fill');
    Route::post('/survey/{id}/isi', [UserSurveyController::class, 'store'])->name('survey.store');

    Route::get('/', [DokumenController::class, 'index'])->name('dokumen.index');
    Route::get('/create', [DokumenController::class, 'create'])->name('dokumen.create');
    Route::post('/store', [DokumenController::class, 'store'])->name('dokumen.store');
    Route::get('/dokumen/{id}/edit', [DokumenController::class, 'edit'])->name('dokumen.edit');
    Route::get('/dokumen/{id}/download', [DokumenController::class, 'download'])->name('dokumen.download');
    Route::put('/dokumen/{id}', [DokumenController::class, 'update'])->name('dokumen.update');
    Route::delete('/dokumen/{id}', [DokumenController::class, 'destroy'])->name('dokumen.destroy');
});

// Public
// Berita Publik
Route::get('/berita', [PublicBeritaController::class, 'index'])->name('berita.publik.index');
Route::get('/berita/{slug}', [PublicBeritaController::class, 'show'])->name('berita.publik.show');
Route::get('/dokumen-publik', [PublicDokumenController::class, 'index'])->name('dokumen.publik.index');
Route::get('/dokumen-publik/file/{dokumen}', [PublicDokumenController::class, 'download'])->name('dokumen.publik.download');
Route::get('/dokumen-publik/{slug}', [PublicDokumenController::class, 'show'])->name('dokumen.publik.show');
Route::get('/survey-publik/{token}', [PublicSurveyController::class, 'show'])->name('survey.public.show');
Route::post('/survey-publik/{token}', [PublicSurveyController::class, 'store'])
    ->middleware('throttle:30,1')
    ->name('survey.public.store');
Route::get('/survey-publik/{token}/terima-kasih', [PublicSurveyController::class, 'thanks'])->name('survey.public.thanks');
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
