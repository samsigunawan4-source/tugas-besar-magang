<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use App\Models\Company;
use App\Models\Vacancy;
use App\Models\Application;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->user()->role;
        $user = $request->user();
        
        if ($role === 'admin') {
            $stats = [
                'total_students' => Student::count(),
                'active_programs' => Vacancy::where('status', 'approved')->count(),
                'pending_applications' => Application::where('status', 'pending_admin')->count(),
                'running_programs' => Application::where('status', 'accepted')->count(),
            ];
            
            $recentApplications = Application::with(['student.user', 'vacancy.company'])->latest()->take(5)->get();
            
            // Dummy chart data for pie chart
            $pieChartData = [
                'pending' => Application::whereIn('status', ['pending_admin', 'pending_company'])->count(),
                'accepted' => Application::where('status', 'accepted')->count(),
                'rejected' => Application::where('status', 'rejected')->count(),
            ];
            
            return view('admin.dashboard', compact('stats', 'recentApplications', 'pieChartData'));
        } elseif ($role === 'perusahaan') {
            $totalLowongan = 0;
            $totalPelamar = 0;
            $lowonganAktif = 0;
            $pelamarDiterima = 0;
            $recentApplications = collect();

            if ($user->company) {
                $totalLowongan = $user->company->vacancies()->count();
                $lowonganAktif = $user->company->vacancies()->where('status', 'approved')->count();
                
                $vacancyIds = $user->company->vacancies()->pluck('id');
                $totalPelamar = Application::whereIn('vacancy_id', $vacancyIds)->count();
                $pelamarDiterima = Application::whereIn('vacancy_id', $vacancyIds)->where('status', 'accepted')->count();
                
                $recentApplications = Application::whereIn('vacancy_id', $vacancyIds)
                    ->with(['student.user', 'vacancy'])
                    ->latest()
                    ->take(5)
                    ->get();
            }

            return view('company.dashboard', compact('totalLowongan', 'totalPelamar', 'lowonganAktif', 'pelamarDiterima', 'recentApplications'));
        } else {
            $totalPengajuan = 0;
            $statusSaatIni = 'Belum Melamar';
            $program = '-';
            $periode = '-';
            $recentLogbooks = collect();

            if ($user->student) {
                $totalPengajuan = $user->student->applications()->count();
                $latestApp = $user->student->applications()->latest()->first();
                
                if ($latestApp) {
                    $statusSaatIni = $latestApp->status;
                    if ($statusSaatIni === 'accepted') {
                        $program = $latestApp->vacancy->posisi . ' (' . $latestApp->vacancy->company->nama_resmi . ')';
                        $periode = 'Aktif';
                        
                        $recentLogbooks = $latestApp->logbooks()->latest()->take(3)->get();
                    }
                }
            }
            
            return view('student.dashboard', compact('totalPengajuan', 'statusSaatIni', 'program', 'periode', 'recentLogbooks'));
        }
    }
}
