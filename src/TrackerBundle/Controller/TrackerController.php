<?php

namespace TrackerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use TrackerBundle\Entity\Record;


class TrackerController extends Controller
{
    # Dashboard index / registry list
    public function dashboardAction()
    {
        $em      = $this->get('doctrine.orm.default_entity_manager');
        $records = $em->getRepository('TrackerBundle\Entity\Record')
            ->findAll();

        return $this->render('TrackerBundle:Tracker:dashboard.html.twig', array(
            'records' => $records
        ));
    }

    # Show registry details
    public function recordDetailAction($recordId)
    {
        $em   = $this->get('doctrine.orm.default_entity_manager');
        $record = $em->getRepository('TrackerBundle\Entity\Record')
            ->findOneBy(['id' => $recordId]);

        return $this->render('TrackerBundle:Tracker:recordDetail.html.twig', array(
            'record' => $record
        ));
    }

    # Insert registry
    public function trackAction(Request $request)
    {
        $record  = new Record();
        $tracked = json_decode($request->getContent());

        $post = $this->getPostBySlug($tracked->postSlug);

        $record->setPost($post);
        $record->setDevice($tracked->device);
        $record->setOperatingSystem($tracked->operatingSystem);
        $record->setBrowser($tracked->browser);
        $record->setVersion($tracked->version);
        $record->setLanguage($tracked->language);
        $record->setCookieEnabled($tracked->cookieEnabled);
        $record->setDatetime(date_create(date("Y-m-d H:i:s")));

        $em = $this->get('doctrine.orm.default_entity_manager');
        $em->persist($record);
        $em->flush();

        return new JsonResponse(array('tracked' => true));;
    }

    private function getPostBySlug($slug)
    {
        $em   = $this->get('doctrine.orm.default_entity_manager');
        $page = $em->getRepository('BlogBundle\Entity\Post')
            ->findOneBy(['slug' => $slug]);

        return $page;
    }
}
