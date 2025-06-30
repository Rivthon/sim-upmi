<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;

class PublicBeritaController extends Controller
{
    public function index()
    {
        $beritas = Berita::latest()->get();
        return view('public.berita.index', compact('beritas'));
    }

public function show($slug)
{
    $berita = Berita::where('slug', $slug)->firstOrFail();
    return view('public.berita.show', compact('berita'));
}


}
