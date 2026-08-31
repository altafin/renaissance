<?php

namespace App\Enums;

enum PersonType: int
{
    case Física = 1;
    case Jurídica = 2;

    public function label(): string
    {
        return match($this) {
            self::Física => 'Pessoa Física',
            self::Jurídica => 'Pessoa Jurídica',
        };
    }
}
