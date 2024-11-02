<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CountCodes implements ValidationRule
{
    /**
     * @var int
     */
    protected $count = 0;

    /**
     * @var int
     */
    protected $maxCount;

    /**
     * Create a new rule instance.
     *
     * @param int $maxCount Número máximo de códigos permitidos
     */
    public function __construct(int $maxCount)
    {
        $this->maxCount = $maxCount;
    }

    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Regex para capturar códigos en el formato ra.XX.YYYY
        $pattern = '/^[a-zA-Z]{2}\.\d{2}\.\d{4}$/';

        // Buscar todos los códigos que coincidan con el patrón
        preg_match_all($pattern, $value, $matches);

        // Contar los códigos encontrados
        $this->count = count($matches[0]);

        // Verificar si la cantidad de códigos supera el límite
        if ($this->count > $this->maxCount) 
        {
            $fail("El campo {$attribute} no puede contener más de {$this->maxCount} códigos. Se encontraron {$this->count} códigos.");
        }
    }

    /**
     * Get the error message for the validation rule.
     *
     * @return string
     */
    public function message(): string
    {
        return "El campo no puede contener más de {$this->maxCount} códigos.";
    }
}
