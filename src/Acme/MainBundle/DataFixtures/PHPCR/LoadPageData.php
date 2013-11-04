<?php

namespace Acme\BasicCmsBundle\DataFixtures\PHPCR;

use Acme\MainBundle\Document\Page;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PHPCR\Util\NodeHelper;
use Symfony\Cmf\Bundle\MenuBundle\Doctrine\Phpcr\Menu;
use Symfony\Cmf\Bundle\MenuBundle\Doctrine\Phpcr\MenuNode;
use Symfony\Cmf\Bundle\RoutingBundle\Doctrine\Phpcr\Route;

class LoadPageData implements FixtureInterface
{
    public function load(ObjectManager $dm)
    {
        NodeHelper::createPath($dm->getPhpcrSession(), '/cms/content/pages');

        $parent = $dm->find(null, '/cms/content/pages');
        $parentMenu = $this->getMenu($dm);

        $page = new Page();
        $page->setName('home');
        $page->setTitle('Home');
        $page->setParent($parent);
        $page->setBody(<<<HERE
Welcome to the homepage.
HERE
        );

        $menuNode = $this->createMenuNode($parentMenu, $page);
        $menuNode->setRoute('acme_main_homepage');

        $dm->persist($menuNode);
        $dm->persist($page);

        foreach (array('about', 'contact') as $name) {
            $body = <<<HERE
<p>Integer malesuada mollis molestie. Nulla facilisi. Aliquam eleifend sem vel suscipit congue. Proin fermentum urna sit amet orci ultricies vestibulum sed vitae ante. Suspendisse et sagittis sem. Vivamus magna augue, mattis tristique consectetur et, sollicitudin in nulla. Interdum et malesuada fames ac ante ipsum primis in faucibus. In hac habitasse platea dictumst. Mauris imperdiet urna at vestibulum fermentum.</p>
<p>Vivamus ultrices fringilla ante vel facilisis. Phasellus laoreet in nisi et pellentesque. Nam ac ante sed ipsum aliquam aliquam. Etiam scelerisque sodales elit, vitae eleifend ligula pretium ut. Nam ac ipsum sed urna rhoncus facilisis vel ut felis. Nam sem urna, elementum rhoncus massa et, facilisis rutrum risus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Mauris eget arcu pellentesque, condimentum purus eu, commodo leo. Aenean at mollis orci. Suspendisse vitae neque lectus.</p>
<p>Nam vitae turpis et felis aliquet pretium. Cras congue neque quis sem bibendum, a rutrum sapien viverra. Vivamus dapibus nisi eget orci tempor dapibus. Morbi aliquet ipsum vitae risus molestie, at sodales justo porttitor. Fusce pulvinar sagittis enim vitae rhoncus. Mauris vitae turpis et erat ultrices sodales. Aliquam id blandit odio, eget consectetur eros. Vivamus dapibus ante purus, id lobortis justo elementum viverra. Morbi convallis consectetur risus, ac tristique metus fermentum pellentesque. Pellentesque non rhoncus dolor, vel consectetur augue. Duis nec mattis tellus.</p>
HERE;

            $page = new Page();
            $page->setName($name);
            $page->setTitle(sprintf('My %s Page', ucfirst($name)));
            $page->setParent($parent);
            $page->setBody($body);

            $menuNode = $this->createMenuNode($parentMenu, $page);

            $dm->persist($menuNode);
            $dm->persist($page);

            foreach (array('subpage1', 'subpage2', 'subpage3') as $subPageName) {
                $subPage = new Page();
                $subPage->setName($subPageName);
                $subPage->setTitle(sprintf('My %s Page', ucfirst($subPageName)));
                $subPage->setParent($page);
                $subPage->setBody($body);

                $subMenuNode = $this->createMenuNode($menuNode, $subPage);

                $dm->persist($subMenuNode);
                $dm->persist($subPage);
            }
        }

        $dm->flush();
    }

    protected function getMenu(ObjectManager $dm) {
        NodeHelper::createPath($dm->getPhpcrSession(), '/cms/menu');

        $parent = $dm->find(null, '/cms/menu');

        $menu = new Menu();
        $menu->setName('main');
        $menu->setLabel('Home');
        $menu->setRoute('acme_main_homepage');
        $menu->setParent($parent);

        $dm->persist($menu);

        return $menu;
    }

    protected function createMenuNode($parent, Page $page) {
        $menuNode = new MenuNode();
        $menuNode->setName($page->getName());
        $menuNode->setLabel($page->getTitle());
        $menuNode->setParent($parent);
        $menuNode->setContent($page);

        return $menuNode;
    }
}