<?php
// src/Security/PostVoter.php
namespace Owp\OwpEvent\Security;

use Owp\OwpEvent\Entity\Event;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class EventVoter extends Voter
{
    const VIEW = 'view';
    const REGISTER = 'register';

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, [self::REGISTER, self::VIEW])) {
            return false;
        }

        if (!$subject instanceof Event) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $event, TokenInterface $token)
    {
        $user = $token->getUser();

        switch ($attribute) {
            case self::REGISTER:
                return $this->canRegister($event, $user);
            case self::VIEW:
                return $this->canView($event, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canRegister(Event $event, $user)
    {
        if ($this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }

        if ($event->getAllowEntries() && $event->getDateEntries()->format('U') > date('U')) {
            return true;
        }

        return false;
    }

    private function canView(Event $event, $user)
    {
        if ($event->isPrivate() && !$this->security->isGranted('ROLE_MEMBER')) {
            return false;
        }

        return true;
    }
}
