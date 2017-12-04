<?php

namespace AppBundle\Controller;

use AppBundle\Form\UserType;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class RegistrationController extends Controller
{
    /**
     * @Route("/register", name="user_registration")
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('home');
        }
        
        // Build the form
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        // Handle form submission (happens on POST request)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            // Encode the plain password
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            // Save user
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->loginAfterRegistration($user);

            // Maybe send a notification email

            $this->addFlash('notice', 'You have successfully registered!');
            
            return $this->redirectToRoute('home');
        }

        return $this->render(
            'security/register.html.twig',
            [
                'form' => $form->createView()
            ]
            );
    }

    private function loginAfterRegistration(User $user)
    {
        $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
        $this->get('security.token_storage')->setToken($token);
        $this->get('session')->set('_security_main', serialize($token));
    }
}