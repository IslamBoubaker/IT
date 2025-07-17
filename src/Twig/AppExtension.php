<?php

namespace App\Twig;

use App\Repository\AlerteRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    private AlerteRepository $alerteRepository;

    public function __construct(AlerteRepository $alerteRepository)
    {
        $this->alerteRepository = $alerteRepository;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('nombre_alertes', [$this, 'getNombreAlertes']),
        ];
    }

    public function getNombreAlertes(): int
    {
        return count($this->alerteRepository->findAll());
    }
}
