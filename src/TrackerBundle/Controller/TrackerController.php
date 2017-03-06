<?php

namespace TrackerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use TrackerBundle\Entity\Record;
use TrackerBundle\Event\RecordTrackedEvent;


class TrackerController extends Controller
{
    # Dashboard index / registry list
    public function dashboardAction()
    {
        $em      = $this->get('doctrine.orm.default_entity_manager');

        $records = $em->getRepository('TrackerBundle\Entity\Record')
            ->findAll();

        $posts = $em->getRepository('BlogBundle\Entity\Post')
            ->findAll();

        return $this->render('TrackerBundle:Tracker:dashboard.html.twig', array(
            'records' => $records,
            'posts' => $posts
        ));
    }

    # Show registry details
    public function recordDetailAction($recordId)
    {
        $em     = $this->get('doctrine.orm.default_entity_manager');
        $record = $em->getRepository('TrackerBundle\Entity\Record')
            ->findOneBy(['id' => $recordId]);

        if (!$record) {
            throw $this->createNotFoundException('Record not found!');
        }

        return $this->render('TrackerBundle:Tracker:recordDetail.html.twig', array(
            'record' => $record
        ));
    }

    # Show registry details
    public function postRecordsDetailAction($postId)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');

        // get post
        $post = $em->getRepository('BlogBundle\Entity\Post')
            ->findOneBy(['id' => $postId]);

        if (!$post) {
            throw $this->createNotFoundException('Post not found!');
        }

        // get records
        $records = $em->getRepository('TrackerBundle\Entity\Record')
            ->findBy(['post' => $post]);

        return $this->render('TrackerBundle:Tracker:postRecordsDetail.html.twig', array(
            'post' => $post,
            'records' => $records
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

        $this->throwRecordTrackerEvent($record);

        return new JsonResponse(array('tracked' => true));;
    }

    private function getPostBySlug($slug)
    {
        $em   = $this->get('doctrine.orm.default_entity_manager');
        $post = $em->getRepository('BlogBundle\Entity\Post')
            ->findOneBy(['slug' => $slug]);

        return $post;
    }

    private function throwRecordTrackerEvent($record)
    {
        $recordTrackedEvent = new RecordTrackedEvent($record);
        $event = $this->get('event_dispatcher');

        $event->dispatch('record.tracked', $recordTrackedEvent);
    }
}
