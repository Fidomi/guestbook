<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Conference;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcherInterface;
use App\Repository\CommentRepository;
use App\Representation\Comments;
use PHPUnit\Util\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;



class CommentController extends AbstractFOSRestController
{
    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    #[Rest\Get('/comments/{id}', name:'comment_show', requirements:['id'=>'\d+'])]
    #[Rest\View]
    public function showComment(Comment $comment)
    {
        return $comment;
    }

    #[Rest\Get('/comments', name: 'comments_show_all')]
    #[Rest\QueryParam(name:'conf', requirements:'[\w\-]', nullable:false, description: 'The slug of the conference to search comments from')]
    #[Rest\QueryParam(name:'order', requirements:'asc|dsc', default:'asc', description: 'Sort order')]
    #[Rest\QueryParam(name:'limit', requirements:'[\d+]', default:15, description: 'Max number of comments per page')]
    #[Rest\QueryParam(name:'offset', requirements:'[\d+]', default:0, description: 'The pagination offset')]
    #[Rest\View]
    public function getCommentsByConference(CommentRepository $commentRepository, ParamFetcherInterface $paramFetcher)
    {
        $pager = $commentRepository->search(
            $paramFetcher->get('conf'),
            $paramFetcher->get('order'),
            $paramFetcher->get('limit'),
            $paramFetcher->get('offset')
        );
        return new Comments($pager);
    }

    #[Rest\Post('/api/comments', name:'comment_add', methods:["Post"])]
    #[IsGranted('ROLE_USER')]
    public function createComment(Request $request, ValidatorInterface $validation)
    {
        $params = json_decode($request->getContent());
        $comment = new Comment();
        $comment->setText($params->text);
        $entity_manager = $this->doctrine->getManager();
        $user = $entity_manager->getRepository(User::class)->find($params->user_id);
        if(!is_object($user)){
            throw new Exception("User not found");
        }
        $conference = $entity_manager->getRepository(Conference::class)->find($params->conference_id);
        if(!is_object($conference)){
            throw new Exception("Conference not found");
        }
        $comment->setUser($user);
        $comment->setConference($conference);
        $entity_manager->persist($comment);
        $entity_manager->flush();

        $errors = $validation->validate($comment);
        if(count($errors)){
            return $this->view($errors, Response::HTTP_BAD_REQUEST);
        }

        return $this->view("Success");
    }

    #[Rest\Delete('/api/comments/{id}', name:'comment_delete', requirements:['id'=>'\d+'])]
    #[IsGranted('ROLE_ADMIN')]
    public function deleteComment(Comment $comment, Request $request, ValidatorInterface $validation)
    {
        $entity_manager = $this->doctrine->getManager();
        $errors = $validation->validate($comment);
        if(count($errors)){
            return $this->view($errors, Response::HTTP_BAD_REQUEST);
        }
        $entity_manager->remove($comment);
        $entity_manager->flush();

        return $this->view("Success");
    }
}
