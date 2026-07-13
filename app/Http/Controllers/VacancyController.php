<?php

namespace App\Http\Controllers;

use App\Models\Vacancy;
use Illuminate\Http\Request;

class VacancyController extends Controller
{
    public function index(Request $request)
    {
        $company = $request->user()->company;
        
        if (!$company) {
            return redirect()->route('company.profile.edit')->with('error', 'Lengkapi profil perusahaan Anda terlebih dahulu.');
        }

        $tab = $request->query('tab', 'active');
        $query = $company->vacancies()->latest();

        if ($tab === 'expired') {
            $query->where('batas_daftar', '<', now()->toDateString());
        } else {
            $query->where('batas_daftar', '>=', now()->toDateString());
        }

        $vacancies = $query->get();
        return view('company.vacancies.index', compact('vacancies', 'tab'));
    }

    public function create(Request $request)
    {
        if (!$request->user()->company) {
            return redirect()->route('company.profile.edit')->with('error', 'Lengkapi profil perusahaan Anda terlebih dahulu.');
        }

        $skills = \App\Models\Skill::all();
        return view('company.vacancies.create', compact('skills'));
    }

    public function store(Request $request)
    {
        // Validasi input form lowongan magang
        $validated = $request->validate([
            'posisi' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kualifikasi' => 'required|string',
            'kuota' => 'required|integer|min:1',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date|after:tgl_mulai',
            'batas_daftar' => 'required|date|before:tgl_mulai',
            'dokumen_pdf' => 'required|file|mimes:pdf|max:5120', // Maksimal 5MB PDF
            'skills' => 'required|array|min:1',
            'skills.*' => 'exists:skills,id',
        ], [
            'dokumen_pdf.required' => 'Dokumen KAK / Surat Penawaran Resmi wajib diunggah.',
            'dokumen_pdf.mimes' => 'Dokumen harus berformat PDF.',
            'skills.required' => 'Wajib memilih minimal 1 kriteria keahlian.',
            'skills.min' => 'Wajib memilih minimal 1 kriteria keahlian.',
        ]);

        $path = $request->file('dokumen_pdf')->store('vacancies/documents', 'public');
        $validated['dokumen_pdf'] = $path;
        $validated['status'] = 'pending'; // Status terkunci menjadi "Menunggu Persetujuan Admin"

        $vacancy = $request->user()->company->vacancies()->create($validated);
        $vacancy->skills()->sync($request->skills);

        return redirect()->route('company.vacancies.index')->with('success', 'Lowongan berhasil disubmit. Menunggu verifikasi dari Admin.');
    }

    public function show(Vacancy $vacancy)
    {
        // Pastikan hanya perusahaan pemilik yang bisa melihat detail lamaran di lowongan ini
        if ($vacancy->company_id !== auth()->user()->company->id) {
            abort(403);
        }
        
        // Load data pendaftar beserta profil mahasiswa dan keahliannya
        $vacancy->load(['skills', 'applications.student.user', 'applications.student.skills']);
        
        return view('company.vacancies.show', compact('vacancy'));
    }
}
