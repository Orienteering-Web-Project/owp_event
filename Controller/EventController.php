<?php

namespace Owp\OwpEvent\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Owp\OwpEvent\Service\EventService;

class EventController extends Controller
{
    public function list(EventService $eventService): Response
    {
        return $this->render('@OwpEvent/List/list.html.twig', [
            'events' => $eventService->getBy(),
        ]);
    }

    public function show(Request $request, string $slug, EventService $eventService): Response
    {
        $event = $eventService->get($slug);

        return $this->render('@OwpEvent/Page/show.html.twig', [
            'entry' => $this->has('service.people'),
            'event' => $event
        ]);
    }

    public function api(EventService $eventService): JsonResponse
    {
        return new JsonResponse($eventService->json());
    }
}
