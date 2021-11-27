<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\User;
use App\Exception\UserAlreadyExistException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Doctrine\ORM\EntityManagerInterface;

final class UserManager implements EventSubscriberInterface
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => ['checkUserAvailability', EventPriorities::PRE_VALIDATE],
        ];
    }

    public function checkUserAvailability(ViewEvent $event): void
    {
        $user = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$user instanceof User) {
            return;
        }else if(Request::METHOD_POST === $method
                || Request::METHOD_PUT === $method
                || Request::METHOD_PATCH === $method) {
            $repository = $this->entityManager->getRepository(User::class);
            $doctrineUser = $repository->findOneByEmail($user->getEmail());

            if ($doctrineUser) {
                if($doctrineUser->getId() !== $user->getId()){
                    throw new UserAlreadyExistException(sprintf('%s is already use.', $user->getEmail()));
                }
            }
        }
    }
}