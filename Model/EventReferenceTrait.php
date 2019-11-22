<?php

namespace Owp\OwpEvent\Model\Event;

use Owp\OwpEvent\Entity\Event;

Trait EventReferenceTrait
{
    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(Event $event): self
    {
        $this->event = $event;

        return $this;
    }
}
