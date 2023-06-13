<?php

namespace App\Controller;
use App\Entity\Books;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Routing\Annotation\Route;

class PatientController extends AbstractController
{
    #[Route('/patient', name: 'app_patient')]
    public function index(Request $request, ValidatorInterface $validator): Response
    {
        $task = new Books();
        $form = $this->createFormBuilder($task)
            ->add('title', TextType::class, [
                'constraints' => [
                    new Length([
                        'min' => 5,
                        'max' => 50,
                        'minMessage' => 'EL titulo debe tener minimo {{ limit }}',
                        'maxMessage' => 'EL titulo debe tener maximo {{ limit }}',
                    ]),
                ],
            ])
            
            ->add('author', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Create book'])
            ->getForm();
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                    
            }
            return $this->render('patient/index.html.twig', [
                'controller_name' => 'PatientController',
                'form' => $form->createView(),
            ]);
    }
}