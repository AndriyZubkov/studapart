<?php

namespace App\Controller;

use App\Entity\Forms\SignupForm;
use App\Form\Type\SignUpType;
use App\Service\UserRegistrationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class DefaultController extends AbstractController
{

    /**
     * Home page showing function
     *
     * @return Response
     */
    #[Route('/', name: 'home_page')]
    public function homePage() : Response
    {
        if ($user = $this->getUser()) {
            $userName = $user->getEmail();
        } else {
            $userName = 'GUEST';
        }
        return $this->render('defaults/homePageTemplate.html.twig', [
            'userName' => $userName,
        ]);
    }

    /**
     * Signup page function
     *
     * @param Request $request
     * @return Response
     */
    #[Route('/signup', name: 'signup_page')]
    public function signUp(Request $request, UserRegistrationService $userRegService) : Response
    {
        //TODO: Front-end dynamic catch for errors when filling out forms
        $newUser = new SignupForm();
        $form    = $this->createForm(SignUpType::class, $newUser);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($userRegService->addNewUserFromSignupForm($form->getData())) {
                $this->addFlash('success', 'Thanks for being awesome! Now you can log in.');
                return $this->redirectToRoute('home_page');
            }
        }
        return $this->renderForm('defaults/signUpPageTemplate.html.twig', ['form' => $form]);
    }

    /**
     * Login page function
     *
     * @param Request $request
     *
     * @return Response
     */
    #[Route('/login', name: 'login_page')]
    public function login(Request $request, AuthenticationUtils $authenticationUtils) : Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('home_page');
        }

        $error        = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('defaults/loginPageTemplate.html.twig', [
            'lastUsername'  => $lastUsername,
            'error'         => $error,
        ]);
    }

    /**
     * Logout function
     *
     * @return void
     */
    #[Route('/logout', name: 'app_logout', methods: ['GET'])]
    public function logout()
    {
    }
}
