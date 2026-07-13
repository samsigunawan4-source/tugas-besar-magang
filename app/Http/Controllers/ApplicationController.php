<?php

namespace App\Http\Controllers;

use App\Models\Vacancy;
use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->role === 'mahasiswa') {
            if (!$user->student) {
                return redirect()->route('student.profile.edit')->with('error', 'Lengkapi profil akademik Anda terlebih dahulu.');
            }
            $applications = $user->student->applications()->with('vacancy.company')->latest()->get();
            $studentSkillIds = $user->student->skills->pluck('id');
            
            $availableVacancies = Vacancy::with(['company', 'skills'])
                ->where('status', 'approved')
                ->where('batas_daftar', '>=', now()->toDateString())
                ->whereHas('skills', function($query) use ($studentSkillIds) {
                    $query->whereIn('skills.id', $studentSkillIds);
                })
                ->latest()
                ->get();

            return view('student.applications.index', compact('applications', 'availableVacancies'));
        } elseif ($user->role === 'perusahaan') {
            if (!$user->company) {
                return redirect()->route('company.profile.edit')->with('error', 'Lengkapi profil perusahaan Anda terlebih dahulu.');
            }
            // View all applications to this company's vacancies, BUT ONLY THOSE ACCEPTED BY ADMIN
            $vacancies = $user->company->vacancies()->with([
                'skills', 
                'applications' => function($query) {
                    $query->whereIn('status', ['accepted', 'completed']);
                },
                'applications.student.user', 
                'applications.student.skills'
            ])->latest()->get();
            return view('company.applications.index', compact('vacancies'));
        }
        
        abort(403);
    }

    public function reports(Request $request)
    {
        $user = $request->user();
        if ($user->role !== 'mahasiswa') abort(403);
        if (!$user->student) {
            return redirect()->route('student.profile.edit')->with('error', 'Lengkapi profil akademik Anda terlebih dahulu.');
        }

        $applications = $user->student->applications()
            ->whereIn('status', ['accepted', 'completed'])
            ->with('vacancy.company')
            ->latest()
            ->get();

        return view('student.reports.index', compact('applications'));
    }

    public function create(Request $request)
    {
        if ($request->user()->role !== 'mahasiswa') abort(403);
        
        $vacancyId = $request->query('vacancy_id');
        $vacancy = Vacancy::with('company')->findOrFail($vacancyId);

        return view('student.applications.create', compact('vacancy'));
    }

    public function store(Request $request)
    {
        if ($request->user()->role !== 'mahasiswa') abort(403);

        $validated = $request->validate([
            'vacancy_id' => 'required|exists:vacancies,id',
            'dokumen_khs' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'pembayaran_pdf' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'dokumen_khs.required' => 'Dokumen KHS wajib diunggah.',
            'dokumen_khs.mimes' => 'Dokumen KHS harus berupa file PDF atau Gambar (JPG/PNG).',
            'pembayaran_pdf.required' => 'Bukti Pembayaran Semester wajib diunggah.',
            'pembayaran_pdf.mimes' => 'Bukti Pembayaran Semester harus berupa file PDF atau Gambar (JPG/PNG).',
        ]);

        $student = $request->user()->student;

        if ($student->applications()->where('vacancy_id', $validated['vacancy_id'])->exists()) {
            return redirect()->route('student.applications.index')->with('error', 'Anda sudah melamar ke lowongan ini sebelumnya.');
        }

        if ($student->applications()->whereIn('status', ['accepted', 'completed'])->exists()) {
             return redirect()->route('student.applications.index')->with('error', 'Anda sudah diterima di tempat magang lain atau sudah selesai magang. Anda tidak bisa melamar lagi.');
        }

        $pendingCount = $student->applications()->whereIn('status', ['pending_admin', 'pending_company'])->count();
        if ($pendingCount >= 3) {
            return redirect()->route('student.applications.index')->with('error', 'Batas maksimal pengajuan tercapai. Anda hanya boleh memiliki maksimal 3 lamaran yang sedang diproses (pending).');
        }

        $khsPath = $request->file('dokumen_khs')->store('applications/documents', 'public');
        $pembayaranPath = $request->file('pembayaran_pdf')->store('applications/documents', 'public');
        
        $student->applications()->create([
            'vacancy_id' => $validated['vacancy_id'],
            'khs_pdf' => $khsPath,
            'pembayaran_pdf' => $pembayaranPath,
            'status' => 'pending_admin'
        ]);

        return redirect()->route('student.applications.index')->with('success', 'Lamaran magang berhasil dikirim! Silakan tunggu hasil verifikasi dari Admin.');
    }

    public function update(Request $request, Application $application)
    {
        if ($request->user()->role !== 'perusahaan') abort(403);

        if ($application->vacancy->company_id !== $request->user()->company->id) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:accepted,rejected'
        ]);

        $application->update(['status' => $validated['status']]);

        return back()->with('success', 'Status lamaran mahasiswa berhasil diperbarui.');
    }

    public function uploadReport(Request $request, Application $application)
    {
        if ($request->user()->role !== 'mahasiswa') abort(403);
        
        if ($application->student_id !== $request->user()->student->id) {
            abort(403);
        }

        if ($application->status !== 'accepted') {
            return back()->with('error', 'Hanya mahasiswa dengan status diterima yang dapat mengunggah laporan akhir.');
        }

        $request->validate([
            'laporan_akhir' => 'required|file|mimes:pdf|max:10240', // 10MB Max PDF
        ], [
            'laporan_akhir.required' => 'File laporan akhir wajib diunggah.',
            'laporan_akhir.mimes' => 'Laporan akhir harus berupa file PDF.',
            'laporan_akhir.max' => 'Ukuran file laporan maksimal 10MB.',
        ]);

        $path = $request->file('laporan_akhir')->store('applications/reports', 'public');
        
        $application->update([
            'laporan_akhir' => $path
        ]);

        return back()->with('success', 'Laporan akhir berhasil diunggah! Menunggu penilaian dan sertifikat dari Perusahaan.');
    }

    public function completeInternship(Request $request, Application $application)
    {
        if ($request->user()->role !== 'perusahaan') abort(403);

        if ($application->vacancy->company_id !== $request->user()->company->id) {
            abort(403);
        }

        if ($application->status !== 'accepted') {
            return back()->with('error', 'Status magang mahasiswa ini tidak sesuai.');
        }

        $request->validate([
            'sertifikat' => 'required|file|mimes:pdf|max:5120',
            'nilai' => 'required|string|max:10',
        ], [
            'sertifikat.required' => 'File sertifikat wajib diunggah.',
            'sertifikat.mimes' => 'Sertifikat harus berupa file PDF.',
            'nilai.required' => 'Nilai magang wajib diisi.',
        ]);

        $path = $request->file('sertifikat')->store('applications/certificates', 'public');

        $application->update([
            'sertifikat' => $path,
            'nilai' => $request->nilai,
            'status' => 'completed',
            'tgl_selesai_magang' => now(),
        ]);

        return back()->with('success', 'Magang telah diselesaikan! Sertifikat dan nilai berhasil diberikan kepada mahasiswa.');
    }
}
