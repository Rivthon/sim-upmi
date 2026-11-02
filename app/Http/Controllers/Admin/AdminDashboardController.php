<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Capa;
use App\Models\DokumenMutu;
use App\Models\JadwalAmi;
use App\Models\ManagementReview;
use App\Models\PpeppMonitoring;
use App\Models\QualityCalendar;
use App\Models\QualityIndicator;
use App\Models\QualityStandard;
use App\Models\TemuanAudit;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalDokumen = DokumenMutu::count();
        $dokumenPending = DokumenMutu::where('approval_status', 'pending')->count();
        $dokumenApproved = DokumenMutu::where('approval_status', 'approved')->count();
        $dokumenRejected = DokumenMutu::where('approval_status', 'rejected')->count();
        $auditTerjadwal = JadwalAmi::whereIn('status', ['draft', 'Draft', 'Rencana'])->count();
        $temuanBelumDitindak = TemuanAudit::where('status', 'belum ditindaklanjuti')->count();
        $tindakLanjutBelum = JadwalAmi::whereNotNull('hasil_temuan')->where('status_tindak_lanjut', 'belum')->count();
        $tindakLanjutProses = JadwalAmi::whereNotNull('hasil_temuan')->where('status_tindak_lanjut', 'proses')->count();
        $tindakLanjutSelesai = JadwalAmi::whereNotNull('hasil_temuan')->where('status_tindak_lanjut', 'selesai')->count();
        $totalStandarMutu = QualityStandard::count();
        $totalIndikatorMutu = QualityIndicator::count();
        $totalPpepp = PpeppMonitoring::count();
        $totalRtm = ManagementReview::count();
        $totalCapaOpen = Capa::whereIn('status', ['open', 'proses'])->count();
        $agendaMendatang = QualityCalendar::whereDate('start_date', '>=', today())->count();

        return view('admin.dashboard', compact(
            'totalDokumen',
            'dokumenPending',
            'dokumenApproved',
            'dokumenRejected',
            'auditTerjadwal',
            'temuanBelumDitindak',
            'tindakLanjutBelum',
            'tindakLanjutProses',
            'tindakLanjutSelesai',
            'totalStandarMutu',
            'totalIndikatorMutu',
            'totalPpepp',
            'totalRtm',
            'totalCapaOpen',
            'agendaMendatang'
        ));
    }
}
