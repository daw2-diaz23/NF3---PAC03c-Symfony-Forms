<?php

namespace App\Controller;

use App\Entity\Reviews;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Routing\Annotation\Route;

class LogoutpauController extends AbstractController
{
    #[Route('/logoutpau', name: 'app_logoutpau')]
    public function index(Request $request): Response
    {
        $review = new Reviews();
        $form = $this->createFormBuilder($review)
            ->add('bookId', IntegerType::class, [
                'label' => 'Book Id'
            ])
            ->add('reviewerName', TextType::class, [
                'label' => 'Reviewer Name', 
                'constraints' => [
                    new Length([
                        'min' => 2,
                        'max' => 255,
                        'minMessage' => 'Reviewer name must have at least {{ limit }}',
                        'maxMessage' => 'Reviewer name cannot have more than {{ limit }}',
                    ]),
                ],
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Content'
            ])
            ->add('rating', IntegerType::class, [
                'label' => 'Rating'
            ])
            ->add('publishingDate', DateType::class, [
                'label' => 'Publishing Date',
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'datepicker'],
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Create Review'
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($review);
            $entityManager->flush();

            return $this->redirectToRoute('reviews');
        }

        return $this->render('logoutpau/index.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'LogoutpauController',
        ]);
    }
}