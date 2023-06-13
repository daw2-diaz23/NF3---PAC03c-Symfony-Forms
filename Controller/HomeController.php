<?php

namespace App\Controller;

use App\Entity\Checkouts;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class HomeController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/home', name: 'app_home')]
    public function index(Request $request): Response
    {
        $checkouts = new Checkouts();
        $form = $this->createFormBuilder($checkouts)
            ->add('user_id', TextType::class, [
                'constraints' => [
                    new Length([
                        'min' => 1,
                        'max' => 255,
                        'minMessage' => 'El ID de usuario debe tener mínimo {{ limit }}',
                        'maxMessage' => 'El ID de usuario debe tener máximo {{ limit }}',
                    ]),
                ],
            ])
            ->add('book_id', TextType::class, [
                'constraints' => [
                    new Length([
                        'min' => 1,
                        'max' => 255,
                        'minMessage' => 'El ID del libro debe tener mínimo {{ limit }}',
                        'maxMessage' => 'El ID del libro debe tener máximo {{ limit }}',
                    ]),
                ],
            ])

            ->add('checkout_date', TextareaType::class, [
                'label' => 'checkout_date'
            ])
            ->add('return_date', TextareaType::class, [
                'label' => 'return_date'
            ])
            ->add('save', SubmitType::class, ['label' => 'Crear checkout'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($checkouts);
            $entityManager->flush();

            return $this->redirectToRoute('checkouts');
        }

        return $this->render('home/index.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'HomeController',
        ]);
    }
}
