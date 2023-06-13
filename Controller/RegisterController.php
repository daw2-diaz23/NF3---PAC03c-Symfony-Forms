<?php

namespace App\Controller;
use App\Entity\Books;
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

class RegisterController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function index(Request $request): Response
    {
        $book = new Books();
        $form = $this->createFormBuilder($book)
            ->add('title', TextType::class, [
                'constraints' => [
                    new Length([
                        'min' => 1,
                        'max' => 255,
                        'minMessage' => 'El título debe tener un mínimo de {{ limit }} caracteres',
                        'maxMessage' => 'El título debe tener un máximo de {{ limit }} caracteres',
                    ]),
                ],
            ])
            ->add('author', TextType::class, [
                'constraints' => [
                    new Length([
                        'min' => 1,
                        'max' => 255,
                        'minMessage' => 'El nombre del autor debe tener un mínimo de {{ limit }} caracteres',
                        'maxMessage' => 'El nombre del autor debe tener un máximo de {{ limit }} caracteres',
                    ]),
                ],
            ])
            ->add('published_date', DateType::class)
            ->add('isbn', TextType::class, [
                'constraints' => [
                    new Length([
                        'min' => 1,
                        'max' => 255,
                        'minMessage' => 'El ISBN debe tener un mínimo de {{ limit }} caracteres',
                        'maxMessage' => 'El ISBN debe tener un máximo de {{ limit }} caracteres',
                    ]),
                ],
            ])
            ->add('save', SubmitType::class, ['label' => 'Crear libro'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($book);
            $entityManager->flush();
    
            return $this->redirectToRoute('books');
        }

        return $this->render('register/index.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'RegisterController',
        ]);
    }
}
