<?php

namespace App\Http\Controllers;

use App\Models\LichSuaChua;
use Illuminate\Http\Request;

class LichSuaChuaController extends Controller
{
    public function index()
    {
        $lichsuachua = LichSuaChua::with(
            [
            'yeucau.nhanvienyeucau',
            'yeucau.may',
            'nhanvienkithuat'
            ]
        )->get();
            
        return view('lichsuachua', compact('lichsuachua'));
    }
}
