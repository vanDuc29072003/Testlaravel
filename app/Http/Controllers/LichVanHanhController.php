<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LichVanHanhController extends Controller
{
    public function lichVanHanh()
    {
        return view('lichvanhanh');
    }
}
