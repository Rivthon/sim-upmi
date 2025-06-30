<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DokumenMutu;
use App\Models\JadwalAmi;
use App\Models\TemuanAudit;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalDokumen = DokumenMutu::count();
        $auditTerjadwal = JadwalAmi::where('status', 'draft')->count();
        $temuanBelumDitindak = TemuanAudit::where('status', 'belum ditindaklanjuti')->count();

        return view('admin.dashboard', compact(
            'totalDokumen',
            'auditTerjadwal',
            'temuanBelumDitindak'
        ));
    }
}
