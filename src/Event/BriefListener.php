<?php

namespace App\Event;

use Doctrine\Persistence\Event\LifecycleEventArgs;
use App\Entity\Brief;
use App\Entity\User;

class BriefListener
{
    private $userEntity;

    public function __construct(User $userEntity)
    {
        $this->userEntity = $userEntity;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if ($entity instanceof Brief) {
            $user = $this->userEntity;
            $entity->setCreatedBy($user->getEmail());
            $entity->setCreatedAt(new \DateTime());
        }
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if ($entity instanceof Brief) {
            $user = $this->userEntity;
            $entity->setUpdatedBy($user->getEmail());
            $entity->setUpdatedAt(new \DateTime());
        }
    }
}
