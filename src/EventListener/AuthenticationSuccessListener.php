<?php

/*
 * This file is part of FAme.
 *
 * Participants :
 *     - Simon Baconnais <simon@fitness-academie.fr>
 *
 * Creation : 27/04/2021
 * Last update : 29/04/2021
 *
 * (c) Fitness Académie 2021
 */

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\UserRepository;

/**
 * Authentication success listener
 *
 * @package Authentication
 */
class AuthenticationSuccessListener
{
    /**
     * User repository
     *
     * @var UserRepository Repository of the user
     */
    private UserRepository $userRepository;

    /**
     * Constructor
     *
     * @param  ManagerRegistry $mr
     * @return void
     */
    public function __construct(ManagerRegistry $mr)
    {
        $this->userRepository = new UserRepository($mr);
    }

    /**
     * On authentication success response
     *
     * Customize Lexik JWT response on login success.
     * Add User object to the response.
     *
     * @param  AuthenticationSuccessEvent $event
     * @return void
     */
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();

        /**
         * @todo Find why getUsername returns email and kinf of fix it. It's confusing cause username doesn't exists on User entity.
         */
        if (!$user instanceof User) {
            $user = $this->userRepository->findOneByEmail($user->getUserIdentifier());

            if ($user === null) {
                return;
            }
        }

        $role = in_array('admin', $user->getRoles()) ? 'admin' : 'user';
        $profilePicture = $user->profilePicture == null ? null : $user->profilePicture->contentUrl;
        
        $data['user'] = [
            'uuid' => $user->getId(),
            "role" => $role,
            'data' => [
                "email" => $user->getEmail(),
                "displayName" => $user->getFirstName()." ".$user->getLastName(),
                "firstName" => $user->getFirstName(),
                "lastName" =>$user->getLastName(),
                "photoURL" => $profilePicture,
                "settings" => []
            ]
        ];

        $event->setData($data);
    }
}
