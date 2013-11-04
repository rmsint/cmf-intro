<?php

namespace Acme\MainBundle\Admin;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Cmf\Bundle\ContentBundle\Admin\StaticContentAdmin;

class PageAdmin extends StaticContentAdmin
{
    protected $translationDomain = 'AcmeMainBundle';

    protected function configureListFields(ListMapper $listMapper)
    {
        parent::configureListFields($listMapper);

        $listMapper
            ->add('updatedAt', null, array('format' => 'Y-m-d H:i'))
        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        parent::configureFormFields($formMapper);

        $formMapper
            ->with('form.group_general')
                ->add('body', 'ckeditor', array('required' => false))
            ->end()
        ;
    }
}
