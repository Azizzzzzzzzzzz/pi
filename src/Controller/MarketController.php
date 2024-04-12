<?php

namespace App\Controller;

use App\Entity\Market;
use App\Form\MarketType;
use App\Repository\MarketRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/market')]
class MarketController extends AbstractController
{
    #[Route('/', name: 'app_market_index', methods: ['GET'])]
    public function index(MarketRepository $marketRepository): Response
    {
        return $this->render('Front/market/index.html.twig', [
            'markets' => $marketRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_market_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $market = new Market();
        $form = $this->createForm(MarketType::class, $market);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($market);
            $entityManager->flush();

            return $this->redirectToRoute('app_market_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Front/market/new.html.twig', [
            'market' => $market,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_market_show', methods: ['GET'])]
    public function show(Market $market): Response
    {
        return $this->render('Front/market/show.html.twig', [
            'market' => $market,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_market_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Market $market, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MarketType::class, $market);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_market_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Front/market/edit.html.twig', [
            'market' => $market,
            'form' => $form,
        ]);
    }

    // #[Route('/{id}', name: 'app_market_delete', methods: ['POST'])]
    // public function delete(Request $request, Market $market, EntityManagerInterface $entityManager): Response
    // {
    //     if ($this->isCsrfTokenValid('delete'.$market->getId(), $request->request->get('_token'))) {
    //         $entityManager->remove($market);
    //         $entityManager->flush();
    //     }

    //     return $this->redirectToRoute('app_market_index', [], Response::HTTP_SEE_OTHER);
    // }
}
