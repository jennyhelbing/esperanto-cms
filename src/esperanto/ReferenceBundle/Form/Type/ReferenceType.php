<?php

namespace esperanto\ReferenceBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ReferenceType extends AbstractType
{
    /**
     * @var string
     */
    protected $dataClass;

    /**
     * @var Router
     */
    protected $router;

    /**
     * @var string
     */
    protected $route;

    public function __construct($dataClass, $route, RouterInterface $router)
    {
        $this->route = $route;
        $this->dataClass = $dataClass;
        $this->router = $router;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $router = $this->router;
        $builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) use ($router) {
            $reference = $event->getData();
            $form = $event->getForm();

            if (!empty($reference) && $reference->getId() && !empty($route)) {
                $url = $router->generate($this->route, array(
                    'id' => $reference->getId(),
                    'slug' => $reference->getSlug(),
                ), true);

                $form->add('url', 'text', array(
                    'mapped' => false,
                    'data' => $url,
                    'disabled' => true,
                    'label' => 'form.label.page_link'
                ));
            }
        });

        $builder->add('route', 'esperanto_route');

        $builder->add('title', 'text', array(
            'label' => 'form.label.title'
        ));

        $builder->add('slug', 'text', array(
            'label' => 'form.label.slug'
        ));

        $builder->add('priority', 'choice', array(
            'label' => 'form.label.priority',
            'choices'   => array(
                '0.1' => '1',
                '0.2' => '2',
                '0.3' => '3',
                '0.4' => '4',
                '0.5' => '5',
                '0.6' => '6',
                '0.7' => '7',
                '0.8' => '8',
                '0.9' => '9',
                '1' => '10'
            ),
            'expanded' => false,
            'multiple' => false
        ));

        $builder->add('change_frequency', 'choice', array(
            'label' => 'form.label.change_frequency',
            'choices'   => array(
                'always' => 'Immer',
                'hourly' => 'Stündlich',
                'daily' => 'Täglich',
                'weekly' => 'Wöchentlich',
                'monthly' => 'Monatlich',
                'yearly' => 'Jährlich',
                'never' => 'Nie',
            ),
            'expanded' => false,
            'multiple' => false
        ));

        $builder->add('teaser', 'textarea', array(
            'label' => 'form.label.teaser'
        ));

        $builder->add('slug', 'text', array(
            'label' => 'form.label.slug'
        ));

        $builder->add('meta_description', 'textarea', array(
            'label' => 'form.label.meta_description'
        ));

        $builder->add('page_title', 'text', array(
            'label' => 'form.label.page_title'
        ));

        $builder->add('social_media', 'choice', array(
            'label' => 'form.label.social_media',
            'choices'   => array(
                '1' => 'label.yes',
                '0' => 'label.no'
            ),
            'expanded' => true,
            'multiple' => false
        ));

        $builder->add('public', 'choice', array(
            'label' => 'form.label.public',
            'choices'   => array(
                '1' => 'label.yes',
                '0' => 'label.no'
            ),
            'expanded' => true,
            'multiple' => false
        ));

        $builder->add('content', 'esperanto_content', array(
            'label' => 'form.label.content'
        ));

        $builder->add('images', 'esperanto_files', array(
            'label' => 'form.label.homepage_picture'
        ));

        $builder->add('preview_picture', 'esperanto_files', array(
            'label' => 'form.label.preview_picture'
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->dataClass
        ));
    }

    public function getName()
    {
        return 'esperanto_reference_reference';
    }
}