<?php

declare(strict_types=1);

namespace App\Calculator;

use App\Entity\DTO\CalculationDto;
use App\Entity\Calculation;

class PricingCalculator
{
    public function calculateIncludingVat(CalculationDto $calculationDto): Calculation
    {
        $pricing = new Calculation();

        $pricing->setGrossPrice($calculationDto->getPrice());
        $pricing->setTaxRate($calculationDto->getVatRate());

        $pricing->setNetPrice(
            $calculationDto->getPrice() / (1 + $calculationDto->getVatRate())
        );

        return $pricing;
    }

    public function calculateExcludingVat(CalculationDto $calculationDto): Calculation
    {
        $pricing = new Calculation();

        $pricing->setNetPrice($calculationDto->getPrice());
        $pricing->setTaxRate($calculationDto->getVatRate());

        $pricing->setGrossPrice(
            $calculationDto->getPrice() * (1 + $calculationDto->getVatRate())
        );

        return $pricing;
    }
}