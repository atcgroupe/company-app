<?php

namespace App\Twig;

use Symfony\Component\Uid\Uuid;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class UuidExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('uuid', [$this, 'generateUuid']),
        ];
    }

    public function generateUuid(): string
    {
        return Uuid::v4()->toBase58();
    }
}
