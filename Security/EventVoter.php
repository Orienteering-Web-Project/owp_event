<?php
// src/Security/PostVoter.php
namespace Owp\OwpEvent\Security;

use Owp\OwpEvent\Entity\Event;
use Owp\OwpCore\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class EventVoter extends Voter
{
    const VIEW = 'view';
    const REGISTER = 'register';
    const REGISTER_OPEN = 'register_open';
    const REGISTER_TEAM = 'register_team';
    const REGISTER_CLUB = 'register_club';

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, [self::REGISTER, self::VIEW, self::REGISTER_OPEN, self::REGISTER_TEAM, self::REGISTER_CLUB])) {
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
            case self::REGISTER_OPEN:
            case self::REGISTER_CLUB:
                return $this->canRegisterIndividual($event, $user);
            case self::REGISTER_TEAM:
                return $this->canRegisterTeam($event, $user);
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

    private function canRegisterIndividual(Event $event, $user)
    {
        return $this->canRegister($event, $user) && $event->getNumberPeopleByEntries() === 1;
    }

    private function canRegisterTeam(Event $event, $user)
    {
        return $this->canRegister($event, $user) && $event->getNumberPeopleByEntries() > 1;
    }

    private function canView(Event $event, $user)
    {
        if ($event->isPrivate() && !$this->security->isGranted('ROLE_MEMBER')) {
            return false;
        }

        return true;
    }
}
