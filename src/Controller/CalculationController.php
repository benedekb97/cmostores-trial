<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Calculation;
use App\Entity\DTO\CalculationDto;
use App\Form\CalculationType;
use App\Calculator\PricingCalculator;
use App\Repository\CalculationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CalculationController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly PricingCalculator $pricingCalculator,
        private readonly SerializerInterface $serializer
    ) {}

    #[Route('/', name: 'index')]
    public function indexAction(Request $request): Response
    {
        $calculationDto = new CalculationDto();

        $form = $this->createForm(CalculationType::class, $calculationDto);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pricingIncludingVat = $this->pricingCalculator->calculateIncludingVat($calculationDto);
            $pricingExcludingVat = $this->pricingCalculator->calculateExcludingVat($calculationDto);

            $this->entityManager->persist($pricingExcludingVat);
            $this->entityManager->persist($pricingIncludingVat);
            $this->entityManager->flush();
        }

        $repository = $this->entityManager->getRepository(Calculation::class);

        $previousCalculations = $repository->findBy(
            criteria: [],
            orderBy: ['id' => 'DESC']
        );

        return $this->render(
            'index.html.twig',
            [
                'previousCalculations' => $previousCalculations,
                'form' => $form,
            ]
        );
    }

    #[Route('clear/', name: 'clear')]
    public function clearAction(): Response
    {
        /** @var CalculationRepository $repository */
        $repository = $this->entityManager->getRepository(Calculation::class);

        $repository->deleteAll();

        return $this->redirectToRoute('index');
    }

    #[Route('export/', name: 'export')]
    public function exportAction(): Response
    {
        $repository = $this->getCalculationRepository();

        $result = $this->serializer->serialize($repository->findAll(), 'csv');

        $response = new Response($result);

        $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
        $response->headers->set(
            'Content-Disposition',
            'attachment; filename="' . $this->getCsvFileName() . '"'
        );

        return $response;
    }

    private function getCalculationRepository(): CalculationRepository
    {
        $repository = $this->entityManager->getRepository(Calculation::class);

        if (!$repository instanceof CalculationRepository) {
            throw new \Exception('Could not load CalculationRepository from EntityManager!');
        }

        return $repository;
    }

    private function getCsvFileName(): string
    {
        return sprintf('calculations_%s.csv', date('YmdHis'));
    }
}