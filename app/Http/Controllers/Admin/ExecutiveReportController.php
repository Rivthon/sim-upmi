<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Accreditation;
use App\Models\Capa;
use App\Models\DokumenMutu;
use App\Models\PpeppMonitoring;
use App\Models\QualityRecommendation;
use App\Models\QualityRisk;
use App\Models\UnitMonitoring;

class ExecutiveReportController extends Controller
{
    public function index()
    {
        return view('admin.executive-reports.index', [
            'riskTotal' => QualityRisk::count(),
            'riskHigh' => QualityRisk::whereIn('level', ['tinggi', 'ekstrem'])->count(),
            'monevTotal' => UnitMonitoring::count(),
            'monevNeedFollowUp' => UnitMonitoring::where('achievement_status', 'perlu tindak lanjut')->count(),
            'accreditationTotal' => Accreditation::count(),
            'accreditationActive' => Accreditation::whereNotIn('status', ['selesai'])->count(),
            'recommendationOpen' => QualityRecommendation::whereIn('status', ['open', 'proses'])->count(),
            'documentPending' => DokumenMutu::where('approval_status', 'pending')->count(),
            'ppeppOpen' => PpeppMonitoring::whereNotIn('status', ['selesai'])->count(),
            'capaOpen' => Capa::whereIn('status', ['open', 'proses'])->count(),
            'topRisks' => QualityRisk::with('standard')->orderByDesc('risk_score')->limit(5)->get(),
            'recentMonev' => UnitMonitoring::with(['standard', 'indicator'])->latest()->limit(5)->get(),
            'upcomingAccreditations' => Accreditation::whereNotNull('expiry_date')->orderBy('expiry_date')->limit(5)->get(),
            'openRecommendations' => QualityRecommendation::whereIn('status', ['open', 'proses'])->orderBy('due_date')->limit(5)->get(),
        ]);
    }
}
