<?php

namespace App\EventListener\EntityListener;

use App\Entity\Comment;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class CommentEntityListener
{

    public function prePersist(Comment $comment, LifecycleEventArgs $event): void
    {
        $comment->setCreatedAt(new \DateTime());

    }

    public function preUpdate(Comment $comment, LifecycleEventArgs $event): void
    {
        $comment->setCreatedAt(new \DateTime());
    }
};