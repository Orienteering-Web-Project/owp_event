<?php

namespace Owp\OwpEvent\Entity;

use Doctrine\ORM\Mapping as ORM;
use Owp\OwpCore\Model as OwpCommonTrait;
use Owp\OwpEvent\Model as OwpEventTrait;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Circuit
{
    use OwpCommonTrait\IdTrait;
    use OwpCommonTrait\LabelTrait;
    use OwpCommonTrait\AuthorTrait;

    use OwpEventTrait\EventReferenceTrait;

    /**
    * @ORM\ManyToOne(targetEntity="Event", inversedBy="circuits")
    * @ORM\JoinColumn(name="event_id", referencedColumnName="id")
    */
    protected $event;
}
