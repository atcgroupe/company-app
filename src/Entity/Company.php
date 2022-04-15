<?php

namespace App\Entity;

use App\Enum\CompanyService;
use App\Repository\CompanyRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
#[UniqueEntity('name', message: 'Cette companie est déjà enregistrée !')]
class Company
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 100)]
    #[Assert\NotBlank(message: 'Le nom est obligatoire')]
    #[Assert\Length(
        min: 2,
        max: 100,
        minMessage: 'Le nom doit comporter au moins 2 caractères ',
        maxMessage: 'Le nom ne peut pas comporter plus de 100 caractères'
    )]
    private $name;

    #[ORM\Column(type: 'boolean')]
    private $isProvider;

    #[ORM\Column(type: 'boolean')]
    private $isManufacturer;

    #[ORM\Column(type: 'smallint')]
    #[Assert\NotBlank(message: 'Le service est obligatoire')]
    private $service;

    #[ORM\Column(type: 'boolean')]
    private $isActive;

    public function __construct()
    {
        $this->setDefaults();
    }

    public function setDefaults()
    {
        $this->isActive = true;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getIsProvider(): ?bool
    {
        return $this->isProvider;
    }

    public function setIsProvider(bool $isProvider): self
    {
        $this->isProvider = $isProvider;

        return $this;
    }

    public function getIsManufacturer(): ?bool
    {
        return $this->isManufacturer;
    }

    public function setIsManufacturer(bool $isManufacturer): self
    {
        $this->isManufacturer = $isManufacturer;

        return $this;
    }

    public function getService(): ?int
    {
        return $this->service;
    }

    public function getServiceLabel(): string
    {
        return CompanyService::from($this->getService())->getLabel();
    }

    public function setService(int $service): self
    {
        $this->service = $service;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }
}
