<?php
/** @noinspection ALL */
declare(strict_types=1);

namespace App\Controller;

use App\Form\MyFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WhateverController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index(Request $request): Response
    {
        $formType = MyFormType::class;

        $defaultFormData = null;

        $formOptions = [
            'method' => Request::METHOD_GET,
        ];

        $form = $this->createForm($formType, $defaultFormData, $formOptions);

        $form = $this->container->get('form.factory')
            ->createBuilder($formType, $defaultFormData, $formOptions)
            ->getForm()
        ;

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();

            $this->redirectToRoute('app_whatever_index');
        }

        return $this->render('form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
