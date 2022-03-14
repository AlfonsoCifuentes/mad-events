<?php

namespace App\Controller;

use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{

    //Ruta para registro de nuevos usuarios
    #[Route(path: '/register', name: 'register')]
    public function newUser(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher)
    {
        $form=$this->createForm(UserType::class);
        $form->handleRequest($request);

        if($form -> isSubmitted() && $form->isValid()) {
            $user = $form -> getData();
            $user -> setPassword($passwordHasher -> hashPassword($user, $user->getPassword())); //Hasheo de contraseña
            $user->setRoles([ "ROLE_USER" ]); //Set del rol aquí, ya que no lo hacemos a mano en el form
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute("app_login");
        }
        return $this->renderForm("/users/createuser.html.twig", ["userForm" => $form]);
    }


    //Ruta para iniciar sesión
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
             return $this->redirectToRoute('myEvents'); //Redireccionamos a myEvents cuando se loguea, cuando hay usuario
         }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }



    //Ruta para cerrar sesión
    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
