<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;

class BantuanController extends Controller
{
    public function index()
    {
        return view('siswa.bantuan');
    }
}
