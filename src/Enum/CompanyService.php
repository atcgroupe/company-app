<?php

namespace App\Enum;

enum CompanyService: int implements AppEnumInterface
{
    case POSE = 1;
    case INFORMATIQUE = 2;
    case TELECOM = 3;

    use AppEnumTrait;

    public function getLabel(): string
    {
        return match($this)
        {
            CompanyService::POSE => 'POSE',
            CompanyService::INFORMATIQUE => 'INFORMATIQUE',
            CompanyService::TELECOM => 'TELECOM',
        };
    }
}
