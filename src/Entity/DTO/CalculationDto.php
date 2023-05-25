<?php

declare(strict_types=1);

namespace App\Entity\DTO;

class CalculationDto
{
    private float $price;

    private float $vatRate;

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function getVatRate(): float
    {
        return $this->vatRate;
    }

    public function setVatRate(float $vatRate): void
    {
        $this->vatRate = $vatRate;
    }
}