<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
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
    /**
     * @var MailerInterface
     */
    private MailerInterface $mailer;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager, MailerInterface $mailer)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->entityManager = $entityManager;
        $this->mailer = $mailer;
    }

    /**
     * @Route("/register", name="register")
     */
    public function index(Request $request): Response
    {
        /**
         * @var User $user
         */
        $user = new User();
        $address = new \App\Entity\Address();
        $address->setShipping(true)
            ->setInvoice(true);
        $user->addAddress($address);
        $registerForm = $this->createForm(RegisterUserType::class, $user);

        $registerForm->handleRequest($request);
        if($registerForm->isSubmitted() && $registerForm->isValid()){
            $user = $registerForm->getData();
            $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));
            $user->setRoles(['USER']);

            $userRepository = $this->entityManager->getRepository(User::class);

            if(!$userRepository->userExists($user)){
                $this->entityManager->persist($user);
                $this->entityManager->persist($user->getAddress());
                $this->entityManager->flush();

                $email = (new Email())
                    ->to($user->getEmail())
                    ->subject("User registration")
                    ->text("Thank you for registration")
                    ->html('<h1>Thank you for registration</h1>');

                $this->mailer->send($email);

                return $this->redirectToRoute('startpage');
            }

            $this->addFlash('errors', sprintf('User %s already exists.', $user->getEmail()));
        }


        return $this->render('register_user/index.html.twig', [
            'controller_name' => 'RegisterUserController',
            'registerForm' => $registerForm->createView()
        ]);
    }
}
