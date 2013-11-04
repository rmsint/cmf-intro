<?php

namespace Acme\MainBundle\Admin;

use Sonata\AdminBundle\Datagrid\ListMapper;
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
}
