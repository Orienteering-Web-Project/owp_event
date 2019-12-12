<?php

namespace Owp\OwpEvent\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Owp\OwpEvent\Entity\EventType;

class FilteringEventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('eventType', EntityType::class, [
                'class' => EventType::class,
                'choice_label' => 'label',
                'required' => false
            ])
        ;
    }
}
