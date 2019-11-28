<?php

namespace Owp\OwpEvent\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Owp\OwpEvent\Repository\EventRepository;
use Owp\OwpEntry\Entity\People;
use Owp\OwpEvent\Entity\Event;
use Symfony\Component\HttpFoundation\Request;
use Owp\OwpEntry\Form\TeamType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Owp\OwpEvent\Service\EventService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

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
            'entry' => $this->has('service.entry'),
            'event' => $event
        ]);
    }

    public function api(EventService $eventService): JsonResponse
    {
        return new JsonResponse($eventService->json());
    }
}
