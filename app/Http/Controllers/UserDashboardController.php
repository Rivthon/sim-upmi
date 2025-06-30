<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Survey;
use App\Models\SurveyResponse;
use App\Models\JadwalAmi;
use App\Models\DokumenMutu;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
public function index()
{
    $user = auth()->user();
    $allowedUnits = ['Tendik', 'Prodi D3 Kebidanan', 'Prodi S1 Farmasi', 'Prodi S1 Gizi'];

    if (!in_array(auth()->user()->unit, $allowedUnits)) {
        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }
 $unit = $user->unit;
    $jadwalAmi = JadwalAmi::where('status', 'Aktif')->get(); 
    // sesuaikan kondisi
    $surveys = Survey::whereHas('targets', function ($q) use ($unit) {
        $q->where('target', $unit);
    })->with('responses')->get();

    foreach ($surveys as $survey) {
        $survey->sudah_isi = $survey->responses->where('user_id', $user->id)->count() > 0;
    }

    // Ambil jadwal AMI jika ingin ditampilkan
    $jadwalAmi = JadwalAmi::all(); // Bisa difilter berdasarkan unit jika perlu


     $dokumenUser = DokumenMutu::where('uploaded_by', $user->id)
                          ->where('tipe', 'Internal') // jika perlu filter tipe
                          ->get();
   return view('user.dashboard', compact('surveys', 'jadwalAmi', 'dokumenUser'));
}

}
