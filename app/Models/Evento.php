<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Evento extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'descricao',
        'data_evento',
        'hora_inicio',
        'hora_fim',
        'local',
        'status',
        'limite_participantes',
        'tipo_evento'
    ];

    protected $casts = [
        'data_evento' => 'date',
        'hora_inicio' => 'datetime:H:i',
        'hora_fim' => 'datetime:H:i',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relacionamento com participações
    public function participacoes(): HasMany
    {
        return $this->hasMany(Participacao::class);
    }

    // Relacionamento many-to-many com pessoas
    public function pessoas(): BelongsToMany
    {
        return $this->belongsToMany(Pessoa::class, 'participacoes')
                   ->withPivot(['data_inscricao', 'data_participacao', 'status', 'observacoes'])
                   ->withTimestamps();
    }

    // Pessoas que estiveram presentes
    public function participantesPresentes(): BelongsToMany
    {
        return $this->pessoas()->wherePivot('status', 'presente');
    }

    // Pessoas inscritas
    public function participantesInscritos(): BelongsToMany
    {
        return $this->pessoas()->wherePivot('status', 'inscrito');
    }

    // Accessors para contadores
    public function getTotalParticipantesAttribute()
    {
        return $this->participacoes()->count();
    }

    public function getTotalPresentesAttribute()
    {
        return $this->participacoes()->where('status', 'presente')->count();
    }

    public function getVagasDisponiveisAttribute()
    {
        if (!$this->limite_participantes) {
            return null;
        }
        return $this->limite_participantes - $this->total_participantes;
    }

    // Scopes para consultas
    public function scopeAtivos($query)
    {
        return $query->where('status', 'ativo');
    }

    public function scopeFinalizados($query)
    {
        return $query->where('status', 'finalizado');
    }

    public function scopePorPeriodo($query, $dataInicio, $dataFim)
    {
        return $query->whereBetween('data_evento', [$dataInicio, $dataFim]);
    }
}