<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\SubKategoriDokumen;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::get('/subkategoris-by-kategori/{kategoriId}', function ($kategoriId) {
    return SubKategoriDokumen::where('kategori_dokumen_id', $kategoriId)->get();
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
