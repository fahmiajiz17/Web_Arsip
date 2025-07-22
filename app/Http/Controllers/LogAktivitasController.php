<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LogAktivitasController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $user = Auth::user();

        $logs = LogAktivitas::with('userLogin') // pakai relasi userLogin
            ->when($user->role == 4, function ($query) use ($user) {
                // Untuk role operator, hanya tampilkan log milik user login
                $query->where('user_id', $user->id);
            })
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('aktivitas', 'like', "%{$search}%")
                        ->orWhereDate('created_at', $search)
                        ->orWhereTime('created_at', $search)
                        ->orWhereHas('userLogin', function ($q2) use ($search) {
                            $q2->where('username', 'like', "%{$search}%");
                        });
                });
            })
            ->when($startDate, function ($query) use ($startDate) {
                $query->whereDate('created_at', '>=', Carbon::parse($startDate));
            })
            ->when($endDate, function ($query) use ($endDate) {
                $query->whereDate('created_at', '<=', Carbon::parse($endDate));
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('log-aktivitas.index', compact('logs'));
    }
}
