<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function index()
    {
        $skills = Skill::latest()->get();
        return view('admin.skills.index', compact('skills'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:skills'
        ]);

        Skill::create($validated);

        return back()->with('success', 'Kategori skill berhasil ditambahkan.');
    }

    public function destroy(Skill $skill)
    {
        $skill->delete();
        return back()->with('success', 'Kategori skill berhasil dihapus.');
    }
}
