<?php

namespace App\Enums;

enum PruningType: string
{
    case FORMATION_OR_DIRECTED = 'formation_or_directed';
    case ORNAMENTAL = 'ornamental';
    case THINNING = 'thinning';
    case FLOWERING = 'flowering';
    case REGENERATION_OR_RIGOROUS = 'regeneration_or_rigurous';
    case BALANCED = 'balanced';
    case SANITARY = 'sanitary';
    case EMERGENCY = 'emergency';

    public function label(): string
    {
        return match($this) {
            self::FORMATION_OR_DIRECTED => 'De Formación o dirigida',
            self::ORNAMENTAL => 'Ornamental',
            self::THINNING => 'De Raleo',
            self::FLOWERING => 'De Floración',
            self::REGENERATION_OR_RIGOROUS=> 'De Regeneración o Rigurosa',
            self::BALANCED => 'Equilibrada',
            self::SANITARY => 'Sanitaria',
            self::EMERGENCY => 'Poda de Emergencia',
        };
    }
}