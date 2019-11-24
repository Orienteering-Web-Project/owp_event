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
        if (empty($filters)) {
            $filters[] = [
                'name' => 'promote',
                'operator' => '=',
                'value' => true
            ];
        }

        if (!$this->security->isGranted('ROLE_MEMBER')) {
            $filters[] = [
                'name' => 'private',
                'operator' => '=',
                'value' => false
            ];
        }

        return $this->eventRepository->findFiltered($filters);
    }

    public function isAllowed(Event $event)
    {
        if (!$this->security->isGranted('view', $event)) {
            throw $this->createAccessDeniedException('Vous n\'êtes par autorisé à consulter cette page.');
        }
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
