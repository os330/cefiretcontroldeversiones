<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VideoController extends Controller
{
    public function index()
    {
        $videos = DB::table('video')->get();
        return view('video.index', compact('videos'));
    }

    public function crear()
    {
        return view('video.crear');
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'titulo' => 'required',
            'url' => 'required'
        ]);

        DB::table('video')->insert([
            'titulo' => $request->titulo,
            'url' => $request->url
        ]);

        return redirect()->route('videos');
    }

    public function eliminar($id)
    {
        DB::table('video')->where('idvideo', $id)->delete();
        return redirect()->route('videos');
    }
}
