<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterUserController extends AbstractController
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private UserPasswordEncoderInterface $passwordEncoder;
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/register", name="register")
     */
    public function index(Request $request): Response
    {
        $user = new User();
        $registerForm = $this->createForm(RegisterUserType::class, $user);

        $registerForm->handleRequest($request);
        if($registerForm->isSubmitted() && $registerForm->isValid()){
            $user= $registerForm->getData();
            $userRepository = $this->entityManager->getRepository(User::class);

            if(!$userRepository->userExists($user)){
                $this->entityManager->persist($user);
                $this->entityManager->flush();

                $this->redirectToRoute('startpage');
            }

            $this->addFlash('errors', sprintf('User %s already exists.', $user->getEmail()));
        }

        dump($registerForm->getErrors());

        return $this->render('register_user/index.html.twig', [
            'controller_name' => 'RegisterUserController',
            'registerForm' => $registerForm->createView()
        ]);
    }
}
