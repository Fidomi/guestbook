<?php

namespace App\Controller;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use function PHPUnit\Framework\throwException;
use \Exception;

class UserController extends AbstractFOSRestController
{
    private ManagerRegistry $managerRegistry;
    private JWTTokenManagerInterface $jwtManager;
    private TokenStorageInterface $tokenStorageInterface;

    public function __construct(ManagerRegistry $managerRegistry,JWTTokenManagerInterface $jwtManager,TokenStorageInterface $tokenStorageInterface )
    {
        $this->managerRegistry = $managerRegistry;
        $this->jwtManager = $jwtManager;
        $this->tokenStorageInterface = $tokenStorageInterface;
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

    #[Rest\Get('/api/users/{id}', name: 'user_id_show', requirements:['id'=>'\d'])]
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

    #[Rest\Get('/api/users/email/{email}', name: 'user_show')]
    #[Rest\View(serializerGroups: ['user_all_details'])]
    #[IsGranted('ROLE_USER')]
    public function showCurrentUser(User $user)
    {
        try {
            return $user;
        } catch (Exception $exception) {
            $view = $this->view($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
            return $this->handleView($view);
        }
    }

    #[Rest\Delete('/api/users/{id}', name: 'user_delete', requirements:['id'=>'\d+'])]
    #[Rest\View(statusCode: 204)]
    #[IsGranted('ROLE_ADMIN')]
    public function deletUser(User $user)
    {
        try {
            $entity_manager = $this->managerRegistry->getManager();
            $entity_manager->remove($user);
            $entity_manager->flush();
            $view = $this->view('User deleted with success');
        } catch (Exception $exception) {
            $view = $this->view($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $this->handleView($view);
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
             $user->setEmail($params->email);
             $user->setFirstname($params->firstname);
             $user->setLastname($params->lastname);
             $user->setBiography($params->biography);
             $this->managerRegistry->getRepository(User::class)->add($user,true);
             return $this->view(
                 $user,
                 Response::HTTP_CREATED,
                 [
                     'Location' => $this->generateUrl('user_id_show', ['id' => $user->getId()], UrlGeneratorInterface::ABSOLUTE_URL)
                 ],
             );
         } catch (Exception $exception) {
             $view = $this->view($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
             return $this->handleView($view);
         }
     }

    #[Rest\Put('/api/users/{id}', name:'user_update_role', requirements: ['id' => '\d+'], methods:["Put"])]
    #[Rest\View(statusCode: 204)]
    public function updateUser(User $user, UserPasswordHasherInterface $passwordHasher, Request $request)
    {
        try {
            $params = json_decode($request->getContent());
            if($this->isGranted("ROLE_ADMIN"))
            {
                if(strtolower($params->role) === "admin" )
                {
                    $user->setRoles(["ROLE_ADMIN"]);
                }  else {
                    $user->setRoles(["ROLE_USER"]);
                }
                $entity_manager = $this->managerRegistry->getManager();
                $entity_manager->flush();
                $view = $this->view('User role updated with success');
                return $this->handleView($view);
            } elseif ($this->isGranted("ROLE_USER"))
            {
                $decodedJwtToken = $this->jwtManager->decode($this->tokenStorageInterface->getToken());
                if($decodedJwtToken["username"] !== $user->getEmail())
                {
                    throw new Exception("You're not authorized to access this data.", 403);
                } else {
                    if(isset($params->plainPassword))
                    {
                        $hashedPassword = $passwordHasher->hashPassword(
                            $user,
                            $params->plainPassword);
                        $user->setPassword($hashedPassword);
                    }
                    foreach ($params as $key => $value){
                        $setterName = 'set'.ucfirst($key);
                        $user->$setterName($value);
                    }
                    $user->setRoles(["ROLE_USER"]);
                    $entity_manager = $this->managerRegistry->getManager();
                    $entity_manager->flush();
                    $view = $this->view('User updated with success');
                    return $this->handleView($view);
                }
            } else
            {
                throw new Exception("You're not authorized to access this data.", 403);
            }
        } catch (\Exception $exception)
        {
            $view = $this->view($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
            return $this->handleView($view);
        }
    }

    #[Rest\Get('/logout', name: 'app_logout')]
    public function logout()
    {
        // controller can be blank: it will never be called!
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }

}
