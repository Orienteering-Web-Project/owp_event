<?php

namespace Owp\OwpEvent\Block;

use Symfony\Component\HttpFoundation\Response;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\Service\AbstractBlockService;
use Sonata\BlockBundle\Mapper\FormMapper;
use Symfony\Component\Templating\EngineInterface;
use Twig\Environment;
use Owp\OwpEvent\Service\EventService;

final class UpcommingEventListBlock extends AbstractBlockService
{
    private $eventService;

    public function __construct(Environment $templatingOrDeprecatedName, EngineInterface $templating, EventService $eventService)
    {
        parent::__construct($templatingOrDeprecatedName, $templating);

        $this->eventService = $eventService;
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        return $this->renderResponse('@OwpEvent/Block/list_upcomming_events.html.twig', [
            'events'     => $this->eventService->getBy([]),
        ], $response);
    }
}
