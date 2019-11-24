<?php

namespace Owp\OwpEvent\Service;

use Owp\OwpCore\Entity\Event;
use Symfony\Component\HttpFoundation\Request;
use Owp\OwpEvent\EventRepository;
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
            $filters['promote'] = true;
        }

        if (!$this->security->isGranted('ROLE_MEMBER')) {
            $filters['private'] = false;
        }

        return $this->eventRepository->findBy($filters, $order);
    }

    public function view(Event $event)
    {

    }
}
