<?php

namespace App\Http\Controllers\halo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HaloController extends Controller
{
    public function index () {
        
        $nama = 'Joko';
        $data = ['nama' => $nama];
        return view('coba.cobacoba', $data);
    }
}