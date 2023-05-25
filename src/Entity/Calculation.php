<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CalculationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[Entity(repositoryClass: CalculationRepository::class)]
class Calculation
{
    #[Id]
    #[Column(type: Types::INTEGER)]
    #[GeneratedValue]
    #[Ignore] // Ignore when serializing
    private ?int $id = null;

    #[Column(type: Types::FLOAT, nullable: true)]
    #[SerializedName('Price (inc. VAT)')]
    private ?float $grossPrice = null;

    #[Column(type: Types::FLOAT, nullable: true)]
    #[SerializedName('Price (ex. VAT)')]
    private ?float $netPrice = null;

    #[Column(type: Types::FLOAT, nullable: true)]
    #[SerializedName('VAT rate')]
    private ?float $taxRate = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGrossPrice(): ?float
    {
        return $this->grossPrice;
    }

    public function setGrossPrice(?float $grossPrice): void
    {
        $this->grossPrice = $grossPrice;
    }

    public function getNetPrice(): ?float
    {
        return $this->netPrice;
    }

    public function setNetPrice(?float $netPrice): void
    {
        $this->netPrice = $netPrice;
    }

    public function getTaxRate(): ?float
    {
        return $this->taxRate;
    }

    public function setTaxRate(?float $taxRate): void
    {
        $this->taxRate = $taxRate;
    }
}