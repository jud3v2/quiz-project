<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LoginType;
use App\Form\RegisterFormType;
use App\Repository\UserRepository;
use App\Service\EmailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{
    #[Route(path: '/logout', name: 'app_logout')]
    public function logout()
    {
    }
    #[Route(path: '/account', name: 'account')]
    public function account()
    {
        if ($this->getUser()->hasRole('ROLE_USER')) {
            return $this->redirectToRoute('home');
        }
    }
    #[Route(path: '/login', name: 'post_login', methods: ['POST', 'GET'])]
    public function post_login(AuthenticationUtils $authenticationUtils, Request $request): Response
    {
       $form = $this->createForm(LoginType::class);
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        $this->redirectToRoute('home');
        return $this->render('user/login.html.twig', [
            'form' => $form->createView(),
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    #[Route(path: '/register-validate-email', name: 'register_validate_email')]
    public function register_validate_email(Request $request, UserRepository $userRepo)
    {

        $error = false;
        $email = $request->query->get('email');
        $token = $request->query->get('token');
        $user = $userRepo->findOneBy(array('email' => $email));

        if (!$user) {
            $this->addFlash('danger', "Votre adresse email ne correspond à aucun compte");
        } elseif ($user->getEmailConfirmation() == 1) {
            $this->addFlash('danger', "Votre compte a déjà été activé, vous pouvez vous connecter");
        } elseif ($token != $user->getToken()) {
            $this->addFlash('danger', "Une erreur est survenue. Contactez le service technique");
        } else {
            $user->setEmailConfirmation(1);
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash('success', "Votre compte a bien été validé, vous pouvez vous connecter");
            return $this->redirectToRoute('post_login');
        }
        return $this->render('security/register_validate_email.html.twig', [
            'error' => $error
        ]);
    }

    #[Route(path: '/register', name: 'post_register', methods: ['POST', 'GET'])]
    public function post_register(Request $request, UserPasswordEncoderInterface $passwordEncoder, EmailService $emailService): Response
    {

        $user = new User();
        $form = $this->createForm(RegisterFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setRoles(["ROLE_USER"])
                 ->setEmailConfirmation(0)
                 ->setToken($this->generateToken())
                 ->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $emailService->register($user);

            return $this->redirectToRoute('post_login', [
                'message' => $this->addFlash('success', 'Merci de valider votre inscription en cliquant sur le lien qui vous a été envoyé ')
            ]);
        }else{
            $form->addError(new FormError('Le formulaire est invalide'));
        }

       return $this->render('user/register.html.twig', [
           'form' => $form->createView()
       ]);
    }

    #[Route(path: '/forgot-password', name: 'forgot_password_page', methods: ['GET'])]
    public function forgot_password_page(): Response
    {
        return $this->render('user/forgot.html.twig');
    }

    #[Route(path: '/forgot-password', name: 'post_forgot_password', methods: ['POST'])]
    public function post_forgot_password_page(): Response
    {
        //
    }

    private function generateToken()
    {
        return substr(bin2hex(random_bytes(50)), 0, 32);
    }
}
