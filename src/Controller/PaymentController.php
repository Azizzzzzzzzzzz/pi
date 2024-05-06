<?php

namespace App\Controller;

use App\Entity\Payment;
use App\Services\MessageService;
use App\Form\PaymentType;
use App\Repository\PaymentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Stripe\Stripe;
use Stripe\Checkout\Session;




#[Route('/payment')]
class PaymentController extends AbstractController
{

        /**
     * @param Request $request
     * @param MessageService $messageService
     * @return Response
     */


    #[Route('/', name: 'app_payment_index', methods: ['GET'])]
    public function index(PaymentRepository $paymentRepository): Response
    {
        return $this->render('payment/index.html.twig', [
            'payments' => $paymentRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_payment_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, MessageService $messageService): Response
    {
        $payment = new Payment();
        $form = $this->createForm(PaymentType::class, $payment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($payment);
            $entityManager->flush();
            
            $messageService->addSuccess('votre paiement a bien été effectuer');

            return $this->redirectToRoute('app_payment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('payment/new.html.twig', [
            'payment' => $payment,
            'form' => $form,
        ]);
        
    }

    #[Route('/{id}', name: 'app_payment_show', methods: ['GET'])]
    public function show(Payment $payment): Response
    {
        return $this->render('payment/show.html.twig', [
            'payment' => $payment,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_payment_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Payment $payment, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PaymentType::class, $payment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_payment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('payment/edit.html.twig', [
            'payment' => $payment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_payment_delete', methods: ['POST'])]
    public function delete(Request $request, Payment $payment, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$payment->getid(), $request->request->get('_token'))) {
            $entityManager->remove($payment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_payment_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/checkout', name: 'checkout', methods: ['POST'])]
    public function checkout(): Response
    {
        Stripe::setApikey('sk_test_51OqTrEEaWYX0heznje37lNEgsaxJcg2psikIXrp24gx1091xVaUzwVT0eifCeK9FFSB2xeDVT3kg9zCaXti5989y00XE5fBddu');

        // Create a checkout session
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'USD',
                    'product_data' => [
                        'name' => 'ethereumm',
                    ],
                    'unit_amount' => 100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url'  => $this->generateUrl('success_url', [],UrlGeneratorInterface::ABSOLUTE_URL),           
            'cancel_url'  => $this->generateUrl('cancel_url', [],UrlGeneratorInterface::ABSOLUTE_URL),

        ]);
        

        return $this->redirect($session->url, 303);
    
    }

    #[Route('/success-url', name: 'success_url')]
    public function successUrl(): Response
    {
        
        return $this->render('payment/show.html.twig');
    
    }

    #[Route('/cancel-url', name: 'cancel_url')]
    public function cancelUrl(): Response
    {
        
        return $this->render('cancel.html.twig');
        
    
    }


}
