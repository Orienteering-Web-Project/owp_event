<?php

// src/Admin/EventTypeAdmin.php

namespace Owp\OwpEvent\Admin;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class EventTypeAdmin extends AbstractEntityAdmin
{
    protected $baseRoutePattern  = 'type';
}
