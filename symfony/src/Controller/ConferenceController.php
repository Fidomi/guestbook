<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Conference;
use \Exception;


class ConferenceController extends AbstractFOSRestController
{
    private ManagerRegistry $managerRegistry;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    #[Rest\Get('/conferences', name: 'conferences_show_all')]
    #[Rest\View(serializerGroups: ["details"])]
    public function showAllConferences()
    {
        try {
            $conferences = $this->managerRegistry->getRepository(Conference::class)->findAll();
            return $conferences;
        } catch (Exception $exception) {
            $view = $this->view($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
            return $this->handleView($view);

        }
    }

    #[Rest\Get('/conferences/{id}', name: 'conference_show', requirements: ['id' => '\d+'])]
    #[Rest\View(serializerGroups: ["details"])]
    public function showConference(Conference $conference)
    {
        try {
            return $conference;
        } catch (Exception $exception) {
            $view = $this->view($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
            return $this->handleView($view);
        }
    }

    #[Rest\Post('/api/conferences', name: 'conference_add')]
    #[ParamConverter('conference', converter: 'fos_rest.request_body')]
    #[Rest\View(statusCode: 201)]
    #[IsGranted('ROLE_ADMIN')]
    public function createConference(Conference $conference)
    {
        try {
            $entity_manager = $this->managerRegistry->getManager();
            $entity_manager->persist($conference);
            $entity_manager->flush();

            return $this->view(
                $conference,
                Response::HTTP_CREATED,
                [
                    'Location' => $this->generateUrl('conference_show', ['id' => $conference->getId()], UrlGeneratorInterface::ABSOLUTE_URL)
                ],
            );
        } catch (Exception $exception) {
            $view = $this->view($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
            return $this->handleView($view);
        }

    }

    #[Rest\Delete('/api/conferences/{id}', name: 'conference_delete', requirements: ['id' => '\d+'])]
    #[Rest\View(statusCode: 204)]
    #[IsGranted('ROLE_ADMIN')]
    public function deleteConference(Conference $conference)
    {
        try {
            $entity_manager = $this->managerRegistry->getManager();
            $entity_manager->remove($conference);
            $entity_manager->flush();
            $view = $this->view('Success');
        } catch (Exception $exception) {
            $view = $this->view($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $this->handleView($view);
    }

    #[Rest\Put('/api/conferences/{id}', name: 'conference_update', requirements: ['id' => '\d+'])]
    #[Rest\View(statusCode: 204)]
    #[IsGranted('ROLE_ADMIN')]
    public function updateConference(Conference $conference, Request $request)
    {
        try {
            $params = json_decode($request->getContent());
            $entity_manager = $this->managerRegistry->getManager();
            $conference->setCity($params->city);
            $conference->setName($params->name);
            $conference->setYear($params->year);
            $conference->setIsInternational($params->is_international);
            $entity_manager->flush();
            $view = $this->view('Success');
        } catch (Exception $exception) {
            $view = $this->view($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $this->handleView($view);
    }
}
