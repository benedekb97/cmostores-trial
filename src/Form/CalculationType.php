<?php

declare(strict_types=1);

namespace App\Form;

use App\Enum\VatInclusionTypes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class CalculationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'price',
                MoneyType::class,
                [
                    'currency' => 'GBP',
                    'required' => true,
                    ]
            )
            ->add('vatRate', PercentType::class, ['required' => true])
            ->add('submit', SubmitType::class)
            ->add('reset', ResetType::class);
    }
}