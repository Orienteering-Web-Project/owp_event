<?php

namespace Owp\OwpEvent\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Owp\OwpEvent\Repository\EventRepository;
use App\Entity\People;
use Owp\OwpEvent\Entity\Event;
use Symfony\Component\HttpFoundation\Request;
use App\Form\TeamType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use App\Service\EntryService;
use Owp\OwpEvent\Service\EventService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class EventController extends Controller
{
    public function list(EventService $eventService): Response
    {
        return $this->render('Event/list.html.twig', [
            'events' => $eventService->getBy(),
        ]);
    }

    public function show(Request $request, Event $event, EventService $eventService, EntryService $entryService): Response
    {
        $eventService->isAllowed('show', $news);

        return $this->render('Event/show.html.twig', [
            'form' => $this->isGranted('register', $event) ? $entryService->form($request, $event)->createView() : null,
            'event' => $event
        ]);
    }

    public function api(EventService $eventService): JsonResponse
    {
        return new JsonResponse($eventService->json());
    }
}
