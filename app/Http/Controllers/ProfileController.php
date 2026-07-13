<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function studentEdit(Request $request): View
    {
        return view('student.profile', [
            'student' => $request->user()->student,
            'skills' => \App\Models\Skill::all(),
        ]);
    }

    public function studentUpdate(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nim' => ['required', 'string', 'max:255'],
            'prodi' => ['required', 'string', 'max:255'],
            'no_wa' => ['required', 'string', 'max:20'],
            'semester' => ['required', 'integer', 'min:1', 'max:14'],
            'jumlah_sks' => ['required', 'integer', 'min:0', 'max:160'],
            'foto_profil' => ['nullable', 'image', 'max:2048'],
            'skills' => ['required', 'array', 'min:3'],
            'skills.*' => ['exists:skills,id'],
        ], [
            'skills.required' => 'Anda wajib memilih minimal 3 keahlian.',
            'skills.min' => 'Anda wajib memilih minimal 3 keahlian.'
        ]);

        $user = $request->user();
        
        // Update user name
        $user->update(['name' => $validated['name']]);
        unset($validated['name']);

        if ($request->hasFile('foto_profil')) {
            $path = $request->file('foto_profil')->store('profiles', 'public');
            $validated['foto_profil'] = $path;
        }

        if ($user->student) {
            $user->student->update($validated);
            $student = $user->student;
        } else {
            $student = $user->student()->create($validated);
        }

        $student->skills()->sync($request->skills);

        return Redirect::route('dashboard')->with('status', 'profil-akademik-updated');
    }

    public function companyEdit(Request $request): View
    {
        return view('company.profile', [
            'company' => $request->user()->company,
        ]);
    }

    public function companyUpdate(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_resmi' => ['required', 'string', 'max:255'],
            'sektor' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string'],
            'kontak' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'logo' => ['nullable', 'image', 'max:2048'],
        ]);

        $user = $request->user();

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos', 'public');
            $validated['logo'] = $path;
        }

        if ($user->company) {
            $user->company->update($validated);
        } else {
            $user->company()->create($validated);
        }

        return Redirect::route('dashboard')->with('status', 'profil-perusahaan-updated');
    }
}
