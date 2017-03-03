<?php

namespace TrackerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class TrackerController extends Controller
{
    # Dashboard index / registry list
    public function dashboardAction()
    {
        return $this->render('TrackerBundle:Dashboard:dashboard.html.twig');
    }

    # Insert registry
    public function trackAction(Request $request)
    {
//        $record = new Record();
        $trackerInfo = json_decode($request->getContent());
        dump($trackerInfo);
        die;

        $em = $this->get('doctrine.orm.default_entity_manager');
        $em->persist($record);
        $em->flush();
    }

    private function getPageId($slug)
    {
        $page = $this->get('doctrine.orm.default_entity_manager');
        return $page->findBy('slug');
    }

    # Show Registry details
}
