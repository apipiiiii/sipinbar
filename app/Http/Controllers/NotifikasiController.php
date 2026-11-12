<?php

namespace App\Http\Controllers;

use App\Support\Notifikasi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/** Daftar notifikasi pengguna yang sedang login (dipanggil berkala oleh lonceng di navbar). */
class NotifikasiController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        return response()->json(['items' => Notifikasi::untuk($request->user())]);
    }
}
