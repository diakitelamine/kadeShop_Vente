<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class SecurityController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/register", name="user_registration")
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {
        
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
        

        // Analyse de la requête par le formulaire
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $encoded = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encoded);
            $this->entityManager->persist($user);
            $this->entityManager->flush();


            return $this->redirectToRoute('user_login');
        }

        return $this->render(
            'security/register.html.twig',
            array('controller_name'=>'Inscription','form' => $form->createView())
        );
    }


   /**
     * @Route("/login", name="user_login")
     * 
     */
    public function login() : Response {

        return $this->render(
            'security/login.html.twig',
            array('controller_name'=>'Connexion')
        );
    }

    /**
     * @Route("/logout", name="user_logout")
     * 
     */
    public function logout() {

    }
}
