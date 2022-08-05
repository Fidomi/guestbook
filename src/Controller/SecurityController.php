<?php

namespace App\Controller;

use App\Entity\User;
use FOS\RestBundle\Request\ParamFetcher;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

class UserController extends AbstractFOSRestController
{
    #[Route('/api/users', name: 'add_user')]
    public function createUser(UserPasswordHasherInterface $passwordHasher, ManagerRegistry $doctrine, User $user)
    {
        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $paramFetcher->get('plainPassword')
        );
        $user->setPassword($hashedPassword);

        $entity_manager = $doctrine->getManager();
        $entity_manager->persist($user);
        $entity_manager->flush();

        return $user;
    }


//    #[Route(name:'api_login',path:'/api/login_check')]
//    public function api_login(): JsonResponse
//    {
//        $user = $this->getUser();
//
//        return new JsonResponse([
//            'username' => $user->getUserName(),
//            'is_admin' => $user->isIsadmin()
//        ]);
//    }

//    #[Route(name:'app_login',path:'/login')]
//    public function login(AuthenticationUtils $authenticationUtils): Response
//    {
//        // get the login error if there is one
//        $error = $authenticationUtils->getLastAuthenticationError();
//        // last username entered by the user
//        $lastUsername = $authenticationUtils->getLastUsername();
//
//        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
//    }

    /**
     * @Route("/logout", name="app_logout", methods={"GET"})
     */
    public function logout()
    {
        // controller can be blank: it will never be executed!
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }
}
