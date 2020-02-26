<?php

// src/Admin/EventTypeAdmin.php

namespace Owp\OwpEvent\Admin;

use Owp\OwpCore\Admin\AbstractNodeAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Owp\OwpEvent\Entity\EventType;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\AdminBundle\Route\RouteCollection;
use Vich\UploaderBundle\Form\Type\VichImageType;

final class EventAdmin extends AbstractNodeAdmin
{
    protected $baseRoutePattern  = 'event';

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Informations générales', ['class' => 'text-bold col-12 col-lg-9'])
                ->add(self::LABEL, TextType::class)
                ->add('content', CKEditorType::class, ['config_name' => 'default', 'required' => false])
                ->add('dateBegin', DateTimeType::class, array(
                    'widget' => 'single_text',
                    'attr' => [
                        'class' => 'form-control input-inline datetimepicker',
                        'data-provide' => 'datetimepicker',
                        'html5' => false,
                    ],
                ))
                ->add('dateEnd', DateTimeType::class, array(
                    'required' => false,
                    'widget' => 'single_text',
                    'attr' => [
                        'class' => 'form-control input-inline datetimepicker',
                        'data-provide' => 'datetimepicker',
                        'html5' => false,
                    ],
                ))
                ->add('eventType', EntityType::class, [
                    'class' => EventType::class,
                    'choice_label' => 'label',
                ])
                ->add('organizer', TextType::class, ['required' => false])
                ->add('website', TextType::class, ['required' => false])
                ->add('private', CheckboxType::class, [
                    'required' => false,
                    'label' => 'Rendre cette événement privé, visible uniquement par les licenciés du club'
                ])
                ->add('imageFile', VichImageType::class, [
                    'required' => false,
                    'allow_delete' => true,
                    'download_uri' => true,
                    'image_uri' => true,
                    'asset_helper' => true,
                ])
            ->end()
        ;

        parent::configureFormFields($formMapper);

        $formMapper
            ->with('Emplacement', ['class' => 'text-bold col-12 col-lg-9'])
                ->add('locationTitle', TextType::class, ['required' => false])
                ->add('locationInformation', CKEditorType::class, ['config_name' => 'default', 'required' => false])
                ->add('latitude', NumberType::class, [
                    'required' => false,
                    'scale' => 6
                ])
                ->add('longitude', NumberType::class, [
                    'required' => false,
                    'scale' => 6
                ])
            ->end()
        ;

        $formMapper
            ->with('Inscriptions', ['class' => 'text-bold col-12 col-lg-9'])
                ->add('allowEntries', CheckboxType::class, ['required' => false])
                ->add('dateEntries', DateTimeType::class, array(
                    'required' => false,
                    'widget' => 'single_text',
                    'attr' => [
                        'class' => 'form-control input-inline datetimepicker',
                        'data-provide' => 'datetimepicker',
                        'html5' => false,
                    ],
                ))
                ->add('numberPeopleByEntries', IntegerType::class, ['required' => false])
            ->end()
        ;

        $formMapper
            ->with('Sections', ['class' => 'text-bold col-12 col-lg-9'])
            ->add('sections', ModelType::class, [
                'property' => 'title',
                'required' => false,
                'multiple' => true,
                'class' => 'Owp\OwpNews\Entity\News',
            ])
            ->end()
        ;

        $formMapper
            ->with('Fichiers', ['class' => 'text-bold col-12 col-lg-9'])
            ->add('files')
            ->end()
        ;
    }
}
