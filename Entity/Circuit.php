<?php

namespace Owp\OwpEvent\Entity;

use Doctrine\ORM\Mapping as ORM;
use Owp\OwpCore\Model as OwpCoreTrait;
use Owp\OwpEvent\Model as OwpEventTrait;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Circuit
{
    use OwpCoreTrait\IdTrait;
    use OwpCoreTrait\LabelTrait;
    use OwpCoreTrait\AuthorTrait;

    use OwpEventTrait\EventReferenceTrait;

    /**
    * @ORM\ManyToOne(targetEntity="Event", inversedBy="circuits")
    * @ORM\JoinColumn(name="event_id", referencedColumnName="id")
    */
    protected $event;
}
