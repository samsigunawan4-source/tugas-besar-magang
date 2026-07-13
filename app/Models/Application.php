<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\Fillable;

class Application extends Model
{
    protected $fillable = ['vacancy_id', 'student_id', 'khs_pdf', 'pembayaran_pdf', 'status', 'laporan_akhir', 'sertifikat', 'nilai', 'tgl_selesai_magang'];
    
    protected function casts(): array
    {
        return [
            'tgl_selesai_magang' => 'date',
        ];
    }

    public function vacancy(): BelongsTo
    {
        return $this->belongsTo(Vacancy::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function logbooks(): HasMany
    {
        return $this->hasMany(Logbook::class);
    }
}
