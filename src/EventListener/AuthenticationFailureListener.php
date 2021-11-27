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

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationFailureEvent;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Authentication failure listener
 *
 * @package Authentication
 */
class AuthenticationFailureListener
{
    /**
     * On authentication failure response
     *
     * Customize Lexik JWT response on login failure.
     * Returns a 403 Forbidden instead of a 401.
     *
     * @param  AuthenticationFailureEvent $event
     * @return void
     */
    public function onAuthenticationFailureResponse(AuthenticationFailureEvent $event)
    {
        $data = [
            'status'  => '403 Forbidden',
            'message' => 'Bad credentials, please verify that your username/password are correctly set',
        ];

        $response = new JsonResponse($data, 403);

        $event->setResponse($response);
    }
}
