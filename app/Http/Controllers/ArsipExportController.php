<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ArsipExport;
use Illuminate\Support\Facades\Auth;

class ArsipExportController extends Controller
{
    public function export()
    {
        return Excel::download(new ArsipExport(Auth::user()),  'Arsip_LLDIKTI4.xlsx');
    }
}
