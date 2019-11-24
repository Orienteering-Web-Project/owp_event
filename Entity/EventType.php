<?php

namespace Owp\OwpEvent\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Owp\OwpCore\Model as OwpCoreTrait;

/**
 * @ORM\Entity(repositoryClass="Owp\OwpEvent\Repository\EventTypeRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class EventType
{
    use OwpCoreTrait\IdTrait;
    use OwpCoreTrait\LabelTrait;
    use OwpCoreTrait\AuthorTrait;
}
