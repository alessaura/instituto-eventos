<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Participacao extends Model
{
    use HasFactory;

    protected $table = 'participacoes';

    protected $fillable = [
        'pessoa_id',
        'evento_id',
        'data_inscricao',
        'data_participacao',
        'status',
        'observacoes'
    ];

    protected $casts = [
        'data_inscricao' => 'datetime',
        'data_participacao' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relacionamentos
    public function pessoa(): BelongsTo
    {
        return $this->belongsTo(Pessoa::class);
    }

    public function evento(): BelongsTo
    {
        return $this->belongsTo(Evento::class);
    }

    // Métodos para alterar status
    public function marcarPresenca()
    {
        $this->update([
            'status' => 'presente',
            'data_participacao' => now()
        ]);
    }

    public function marcarAusencia()
    {
        $this->update([
            'status' => 'ausente',
            'data_participacao' => null
        ]);
    }

    // Scopes para filtros
    public function scopePresentes($query)
    {
        return $query->where('status', 'presente');
    }

    public function scopeAusentes($query)
    {
        return $query->where('status', 'ausente');
    }

    public function scopeInscritos($query)
    {
        return $query->where('status', 'inscrito');
    }
}