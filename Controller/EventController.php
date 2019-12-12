<?php

namespace Owp\OwpEvent\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Owp\OwpEvent\Service\EventService;
use Owp\OwpEvent\Form\FilteringEventType;

class EventController extends Controller
{
    public function list(Request $request, EventService $eventService): Response
    {
        $form = $this->createForm(FilteringEventType::class, []);
        $form->handleRequest($request);

        $filters = [];
        if ($form->isSubmitted() && $form->isValid()) {
            $datas = $form->getData();
            foreach ($datas as $key => $value) {
                if (!empty($value)) {
                    $filters[] = [
                        'name' => $key,
                        'operator' => '=',
                        'value' => $value
                    ];
                }
            }
        }

        return $this->render('@OwpEvent/List/list.html.twig', [
            'form' => $form->createView(),
            'events' => $eventService->getBy($filters),
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
