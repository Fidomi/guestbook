<?php

namespace App\Controller;

use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Entity\Conference;
use \Exception;

class UserController extends AbstractFOSRestController
{
    private ManagerRegistry $managerRegistry;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    #[Rest\Get('/api/users', name: 'users_show_all')]
    #[Rest\View(serializerGroups: ['user_all_details'])]
    #[IsGranted('ROLE_ADMIN')]
    public function showAllUsers()
    {
        try {
            $users = $this->managerRegistry->getRepository(User::class)->findAll();
            return $users;
        } catch (Exception $exception) {
            $view = $this->view($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
            return $this->handleView($view);

        }
    }

    #[Rest\Get('/api/users/{id}', name: 'user_show', requirements:['id'=>'\d+'])]
    #[Rest\View(serializerGroups: ['user_all_details'])]
    #[IsGranted('ROLE_ADMIN')]
    public function showUser(User $user)
    {
        try {
            return $user;
        } catch (Exception $exception) {
            $view = $this->view($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
            return $this->handleView($view);
        }
    }

    #[Rest\Post('/users', name:'user_add', methods:["Post"])]
    #[ParamConverter('user', converter: 'fos_rest.request_body')]
    #[Rest\View(statusCode: 201)]
     public function createUser(User $user, UserPasswordHasherInterface $passwordHasher, Request $request)
     {
         try {
             $params = json_decode($request->getContent());
             $hashedPassword = $passwordHasher->hashPassword(
                 $user,
                 $params->plainPassword);
             $user->setPassword($hashedPassword);
             $user->setPicture($params->picture);
             $user->setRoles(["ROLE_USER"]);
             $this->managerRegistry->getRepository(User::class)->add($user,true);
             return $this->view(
                 $user,
                 Response::HTTP_CREATED,
                 [
                     'Location' => $this->generateUrl('user_show', ['id' => $user->getId()], UrlGeneratorInterface::ABSOLUTE_URL)
                 ],
             );
         } catch (Exception $exception) {
             $view = $this->view($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
             return $this->handleView($view);
         }

     }
}
