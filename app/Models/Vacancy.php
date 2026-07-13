<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['company_id', 'posisi', 'deskripsi', 'kualifikasi', 'kuota', 'tgl_mulai', 'tgl_selesai', 'batas_daftar', 'dokumen_pdf', 'status'])]
class Vacancy extends Model
{
    protected function casts(): array
    {
        return [
            'tgl_mulai' => 'date',
            'tgl_selesai' => 'date',
            'batas_daftar' => 'date',
        ];
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function skills(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Skill::class);
    }
}
