<?php

namespace Acme\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function homeAction()
    {
        $dm = $this->get('doctrine_phpcr.odm.document_manager');
        $homeDocument = $dm->find(null, '/cms/content/pages/home');

        $request = $this->getRequest();
        $request->attributes->set('contentDocument', $homeDocument);

        return $this->render('AcmeMainBundle:Page:home.html.twig', array(
            'cmfMainContent' => $homeDocument,
        ));
    }
}
