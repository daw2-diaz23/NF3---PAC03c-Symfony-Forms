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

class LoginController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/login', name: 'app_login')]
    public function index(Request $request): Response
    {
        $checkouts = new Checkouts();
        $form = $this->createFormBuilder($checkouts)
            ->add('user_id', TextType::class, [
                'constraints' => [
                    new Length([
                        'min' => 1,
                        'max' => 255,
                        'minMessage' => 'EL ID de usuario debe tener minimo {{ limit }}',
                        'maxMessage' => 'EL ID de usuario debe tener maximo {{ limit }}',
                    ]),
                ],
            ])
            ->add('book_id', TextType::class, [
                'constraints' => [
                    new Length([
                        'min' => 1,
                        'max' => 255,
                        'minMessage' => 'EL ID del libro debe tener minimo {{ limit }}',
                        'maxMessage' => 'EL ID debe del libro tener maximo {{ limit }}',
                    ]),
                ],
            ])
            ->add('save', SubmitType::class, ['label' => 'Crear checkout'])
            ->getForm();

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($address);
                $entityManager->flush();
    
                return $this->redirectToRoute('checkouts');
            }

        return $this->render('login/index.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'LoginController',
        ]);
    }
}