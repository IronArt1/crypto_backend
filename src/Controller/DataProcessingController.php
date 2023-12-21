<?php

namespace App\Controller;

use App\Entity\RequestEntity;
use App\Form\RequestFormType;
use App\Service\CryptoService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DataProcessingController extends AbstractController
{
    #[Route('/data/processing', methods: ['POST', 'OPTIONS'], name: 'app_data_processing')]
    public function index(
        Request $request,
        EntityManagerInterface $entityManager,
        CryptoService $cryptoService
    ): Response
    {
        $requestEntity = new RequestEntity();
        $requestForm = $this->createForm(RequestFormType::class, $requestEntity);

        $requestForm->handleRequest($request);

        // a form validation is not specifically required by the task, so I am skipping it...
        // moreover here should be applied custom Validators
        //var_dump($requestForm->isValid());
        if ($request->isMethod('POST')) {
            $data = json_decode($request->getContent(), true);
            $requestForm->submit($data);

            /** @var RequestEntity $requestEntity */
            $requestEntity = $requestForm->getData();
            // we do not need persist here since it is brand new and UnitOfWork knows it
            $entityManager->flush();

            $this->addFlash('success', 'A new request is saved!');

            $cryptoService->callCrypto($requestEntity);

            // here we would access a relation One-To-One of $requestEntity
            // that would consist data about stored in $cryptoService transactions matter
            // it will be passed to UI
        }

        $response = new Response();
        $response->setContent(json_encode([
            'tx' => 123,
            'average' => 456
        ]));

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
