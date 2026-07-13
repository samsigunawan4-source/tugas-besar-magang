<?php

namespace App\Http\Controllers;

use App\Models\Logbook;
use App\Models\Application;
use Illuminate\Http\Request;

class LogbookController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->role === 'mahasiswa') {
            if (!$user->student) abort(403);
            
            $application = $user->student->applications()->where('status', 'accepted')->first();
            
            if (!$application) {
                return redirect()->route('dashboard')->with('error', 'Anda belum memiliki lamaran magang yang disetujui, sehingga belum bisa mengisi logbook.');
            }

            $logbooks = $application->logbooks()->latest('tanggal')->get();
            return view('student.logbooks.index', compact('logbooks', 'application'));
            
        } elseif ($user->role === 'admin') {
            $applications = Application::with(['student.user', 'vacancy.company', 'logbooks'])->where('status', 'accepted')->get();
            return view('admin.logbooks.index', compact('applications'));
            
        } elseif ($user->role === 'perusahaan') {
            if (!$user->company) abort(403);
            $vacancies = $user->company->vacancies()->with(['applications' => function($q) {
                $q->where('status', 'accepted')->with(['student.user', 'logbooks' => function($q) {
                    $q->latest('tanggal');
                }]);
            }])->get();
            return view('company.logbooks.index', compact('vacancies'));
        }

        abort(403);
    }

    public function store(Request $request)
    {
        if ($request->user()->role !== 'mahasiswa') abort(403);
        
        $application = $request->user()->student->applications()->where('status', 'accepted')->firstOrFail();

        $validated = $request->validate([
            'tanggal' => 'required|date',
            'kegiatan' => 'required|string',
            'foto_bukti' => 'required|image|max:2048'
        ], [
            'foto_bukti.required' => 'Foto bukti kegiatan wajib diunggah!',
            'foto_bukti.image' => 'File harus berupa gambar (JPG, PNG).',
            'tanggal.required' => 'Tanggal kegiatan wajib diisi!'
        ]);

        $path = $request->file('foto_bukti')->store('logbooks/photos', 'public');

        $application->logbooks()->create([
            'tanggal' => $validated['tanggal'],
            'kegiatan' => $validated['kegiatan'],
            'foto_bukti' => $path
        ]);

        return back()->with('success', 'Logbook harian berhasil disimpan!');
    }

    public function updateStatus(Request $request, Logbook $logbook)
    {
        if ($request->user()->role !== 'perusahaan') abort(403);
        
        if ($logbook->application->vacancy->company_id !== $request->user()->company->id) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:approved,rejected',
            'feedback' => 'nullable|string'
        ]);

        $logbook->update([
            'status' => $validated['status'],
            'feedback' => $validated['feedback']
        ]);

        return back()->with('success', 'Status logbook berhasil diperbarui.');
    }
}
