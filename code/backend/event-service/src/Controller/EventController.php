<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Event;
use Symfony\Component\HttpFoundation\Request;
use App\Service\Token\TokenDecoder;
use App\Entity\EventType;
use App\Service\Requests\RequestService;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Crud\EventCrud;

//https://symfony.com/doc/current/service_container/request.html
class EventController extends AbstractController
{
    #[Route('/event/new', name: 'app_new_event')]
    public function postEvent(EntityManagerInterface $entityManager, Request $request, HttpClientInterface $client, EventCrud $event_crud): JsonResponse
    {
        $token_decoder = new TokenDecoder('secret');
        $token = $request->headers->get('token');
        if (!$token) {
            return $this->json([
                'message' => 'Unauthorized',
                'path' => 'src/Controller/EventController.php',
            ], 401);
        } else {
            $token = $token_decoder->token_verify($token);
            if (!$token) {
                return $this->json([
                    'message' => 'Unauthorized',
                    'path' => 'src/Controller/EventController.php',
                ], 401);
            } else {
                $request_params = json_decode($request->getContent(), true)['event'];
                return $event_crud->postEvent($request_params, $token['user_id'], $entityManager, $client);
            }
        }
    }

    #[Route('/events', name: 'app_get_events')]
    public function getEvents(EntityManagerInterface $entityManager, Request $request, HttpClientInterface $client, EventCrud $event_crud): JsonResponse
    {
        $token_decoder = new TokenDecoder('secret');
        $token = $request->headers->get('token');
        if (!$token) {
            return $this->json([
                'message' => 'Unauthorized',
                'path' => 'src/Controller/EventController.php',
            ], 401);
        } else {
            $token = $token_decoder->token_verify($token);
            if (!$token) {
                return $this->json([
                    'message' => 'Unauthorized',
                    'path' => 'src/Controller/EventController.php',
                ], 401);
            } else {
                $request_params = $request->query->all();
                return $event_crud->getEvent($request_params, $token['id'], $entityManager, $client);
            }
        }

    }
}
