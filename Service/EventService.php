<?php

namespace Owp\OwpEvent\Service;

use Owp\OwpCore\Entity\Event;
use Symfony\Component\HttpFoundation\Request;
use Owp\OwpEvent\Repository\EventRepository;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Security;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Twig\Environment;
use Knp\Snappy\Pdf;

class EventService {

    private $eventRepository;
    private $session;
    private $security;
    private $twig;

    public function __construct(EventRepository $eventRepository, SessionInterface $session, Security $security, Environment $twig)
    {
        $this->eventRepository = $eventRepository;
        $this->session = $session;
        $this->security = $security;
        $this->twig = $twig;
    }

    public function getBy(array $filters = [], $order = ['updateAt' => 'DESC'])
    {
        if (!$this->security->isGranted('ROLE_MEMBER')) {
            $filters[] = [
                'name' => 'private',
                'operator' => '=',
                'value' => false
            ];
        }

        return $this->eventRepository->findFiltered($filters);
    }

    public function get(string $slug)
    {
        $entity = $this->eventRepository->findOneBySlug($slug);

        if (empty($entity)) {
            throw new NotFoundHttpException();
        }
        elseif (!$this->security->isGranted('view', $entity)) {
            throw new AccessDeniedException();
        }

        return $entity;
    }

    public function json()
    {
        $results = [];
        $events = $this->getBy();

        foreach ($events as $event) {
            $results[] = ['date' => $event->getDateBegin()->format('Y-m-d'), 'title' => $event->getTitle()];
        }

        return $results;
    }
}
