<?php

namespace Owp\OwpEvent\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Owp\OwpCore\Model as OwpCommonTrait;

/**
 * @ORM\Entity(repositoryClass="Owp\OwpEvent\Repository\EventTypeRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class EventType
{
    use OwpCommonTrait\IdTrait;
    use OwpCommonTrait\LabelTrait;
    use OwpCommonTrait\AuthorTrait;
}
