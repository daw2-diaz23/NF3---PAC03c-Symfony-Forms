<?php

namespace App\Controller;
use App\Entity\Addresses;
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

class DoctorController extends AbstractController
{
    #[Route('/doctor', name: 'app_doctor')]
    public function index(Request $request, ValidatorInterface $validator): Response
    {
        $address = new Addresses();
        $form = $this->createFormBuilder($address)
            ->add('street', TextType::class, [
                'constraints' => [
                    new Length([
                        'min' => 5,
                        'max' => 255,
                        'minMessage' => 'EL titulo debe tener minimo {{ limit }}',
                        'maxMessage' => 'EL titulo debe tener maximo {{ limit }}',
                    ]),
                ],
            ])
            ->add('city', TextType::class, [
                'constraints' => [
                    new Length([
                        'min' => 2,
                        'max' => 255,
                        'minMessage' => 'La ciudad debe tener minimo {{ limit }}',
                        'maxMessage' => 'La ciudad debe tener maximo {{ limit }}',
                    ]),
                ],
            ])
            ->add('state', TextType::class, [
                'constraints' => [
                    new Length([
                        'min' => 2,
                        'max' => 2,
                        'exactMessage' => 'El estado debe tener exactamente {{ limit }}'
                    ]),
                ],
            ])
            ->add('save', SubmitType::class, ['label' => 'Crear dirección'])
            ->getForm();

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($address);
                $entityManager->flush();
    
                return $this->redirectToRoute('addresses');
            }

        return $this->render('doctor/index.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'DoctorController',
        ]);
    }
}