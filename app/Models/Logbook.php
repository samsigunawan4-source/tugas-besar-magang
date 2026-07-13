<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\Fillable;

class Logbook extends Model
{
    protected $fillable = ['application_id', 'tanggal', 'kegiatan', 'foto_bukti', 'status', 'feedback'];
    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
        ];
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }
}
