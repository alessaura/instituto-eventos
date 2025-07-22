<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Pessoa extends Model
{
    use HasFactory;

    protected $table = 'pessoas';

    protected $fillable = [
        'nome',
        'email',
        'telefone',
        'empresa',
        'cargo',
        'cidade',
        'estado',
        'observacoes'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relacionamento com participações
    public function participacoes(): HasMany
    {
        return $this->hasMany(Participacao::class);
    }

    // Relacionamento many-to-many com eventos
    public function eventos(): BelongsToMany
    {
        return $this->belongsToMany(Evento::class, 'participacoes')
                   ->withPivot(['data_inscricao', 'data_participacao', 'status', 'observacoes'])
                   ->withTimestamps();
    }

    // Eventos onde a pessoa esteve presente
    public function eventosPresentes(): BelongsToMany
    {
        return $this->eventos()->wherePivot('status', 'presente');
    }

    // Accessor para timeline de eventos
    public function getEventosTimelineAttribute()
    {
        return $this->participacoes()
                   ->with('evento')
                   ->orderBy('data_participacao', 'desc')
                   ->get()
                   ->map(function ($participacao) {
                       return [
                           'evento' => $participacao->evento->nome,
                           'data' => $participacao->data_participacao,
                           'status' => $participacao->status,
                           'observacoes' => $participacao->observacoes
                       ];
                   });
    }

    // Scopes para consultas
    public function scopeComEmail($query, $email)
    {
        return $query->where('email', $email);
    }

    public function scopeBuscar($query, $termo)
    {
        return $query->where(function ($q) use ($termo) {
            $q->where('nome', 'ILIKE', "%{$termo}%")
              ->orWhere('email', 'ILIKE', "%{$termo}%")
              ->orWhere('empresa', 'ILIKE', "%{$termo}%");
        });
    }
}