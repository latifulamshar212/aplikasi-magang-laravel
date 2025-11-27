<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Logbook;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function print()
    {
        $user = Auth::user();

        // Ambil data Absensi
        $attendances = Attendance::where('user_id', $user->id)
                        ->orderBy('date', 'asc')
                        ->get();

        // Ambil data Logbook
        $logbooks = Logbook::where('user_id', $user->id)
                        ->orderBy('date', 'asc')
                        ->get();

        return view('reports.print', compact('user', 'attendances', 'logbooks'));
    }
}