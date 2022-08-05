<?php

namespace App\EventListener\EntityListener;

use App\Entity\User;
use Doctrine\ORM\Event\LifecycleEventArgs;


class UserEntityListener
{

    public function prePersist(User $user, LifecycleEventArgs $event)
    {
        $roles = $user->getRoles();
        // guarantee every user at least has ROLE_USER
        if(count($roles) < 1)
        {
            $roles[] = 'ROLE_USER';
        }
        $user->setRoles($roles);
    }

    public function preUpdate(User $user, LifecycleEventArgs $event)
    {

    }
}