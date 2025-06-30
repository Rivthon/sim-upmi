<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriDokumen;
use App\Models\Berita;

class WelcomeController extends Controller
{
    public function index()
    {
        $kategorisPublik = KategoriDokumen::with('subKategoris')
                            ->where('tipe', 'Publik')
                            ->get();
        $beritas = Berita::latest()->take(6)->get();
        return view('welcome', compact('kategorisPublik','beritas'));
    }
}
