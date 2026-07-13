<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vacancy;
use App\Models\Application;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Vacancies
    public function vacancies(Request $request)
    {
        $tab = $request->query('tab', 'active');
        $query = Vacancy::with('company')->latest();

        if ($tab === 'expired') {
            $query->where('batas_daftar', '<', now()->toDateString());
        } else {
            $query->where('batas_daftar', '>=', now()->toDateString());
        }

        $vacancies = $query->get();
        return view('admin.vacancies', compact('vacancies', 'tab'));
    }

    public function showVacancy(Vacancy $vacancy)
    {
        $vacancy->load(['company', 'skills']);
        return view('admin.vacancy_show', compact('vacancy'));
    }

    public function approveVacancy(Request $request, Vacancy $vacancy)
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,rejected'
        ]);
        $vacancy->update(['status' => $validated['status']]);
        return back()->with('success', 'Status lowongan magang berhasil diubah.');
    }

    // User Role Management
    public function users()
    {
        $users = User::latest()->get();
        return view('admin.users.index', compact('users'));
    }

    public function updateUserRole(Request $request, User $user)
    {
        // Cegah admin mengubah role dirinya sendiri secara tidak sengaja
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat mengubah role Anda sendiri.');
        }

        $validated = $request->validate([
            'role' => 'required|in:admin,mahasiswa,perusahaan'
        ]);

        $user->update(['role' => $validated['role']]);
        return back()->with('success', "Role pengguna {$user->name} berhasil diubah menjadi {$validated['role']}.");
    }

    public function destroyUser(User $user)
    {
        // Cegah admin menghapus dirinya sendiri
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $name = $user->name;
        $user->delete();
        
        return back()->with('success', "Akun pengguna {$name} berhasil dihapus.");
    }

    // User Management Split
    public function students()
    {
        $students = User::with(['student.skills', 'student.applications.vacancy.company'])
            ->where('role', 'mahasiswa')
            ->latest()
            ->get();
        return view('admin.students.index', compact('students'));
    }

    public function showStudent(User $user)
    {
        if ($user->role !== 'mahasiswa') {
            abort(404);
        }

        $user->load(['student.skills', 'student.applications.vacancy.company', 'student.logbooks']);
        
        return view('admin.students.show', compact('user'));
    }

    public function companies()
    {
        $companies = User::with(['company.vacancies'])
            ->where('role', 'perusahaan')
            ->latest()
            ->get();
        return view('admin.companies.index', compact('companies'));
    }

    public function showCompany(User $user)
    {
        if ($user->role !== 'perusahaan') {
            abort(404);
        }

        $user->load(['company.vacancies.applications.student.user']);
        
        return view('admin.companies.show', compact('user'));
    }

    // Application Verification
    public function applications()
    {
        $applications = Application::with(['student.user', 'student.skills', 'vacancy.company', 'vacancy.skills'])->whereIn('status', ['pending_admin', 'pending_company', 'accepted', 'rejected'])->latest()->get();
        return view('admin.applications.index', compact('applications'));
    }

    public function verifyApplication(Request $request, Application $application)
    {
        $validated = $request->validate([
            'status' => 'required|in:accepted,rejected'
        ]);
        $application->update(['status' => $validated['status']]);
        
        if ($validated['status'] === 'accepted') {
            // Auto-reject lamaran lain yang masih pending
            Application::where('student_id', $application->student_id)
                ->where('id', '!=', $application->id)
                ->whereIn('status', ['pending_admin', 'pending_company'])
                ->update(['status' => 'rejected']);
        }
        
        $msg = 'Status lamaran berhasil diperbarui.';
        if ($validated['status'] === 'accepted') {
            $msg = 'Mahasiswa resmi diterima untuk penempatan di perusahaan ini. Lamaran lainnya di tempat lain otomatis ditolak.';
        } elseif ($validated['status'] === 'rejected') {
            $msg = 'Lamaran ditolak.';
        }
        
        return back()->with('success', $msg);
    }
}
