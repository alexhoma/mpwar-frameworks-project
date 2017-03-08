<?php

namespace TrackerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use TrackerBundle\Entity\Record;
use TrackerBundle\Event\RecordTrackedEvent;


class TrackerController extends Controller
{
    /**
     * Dashboard index / registry list
     */
    public function dashboardAction()
    {
        $entityManager = $this->get('doctrine.orm.default_entity_manager');
        $records       = $entityManager
            ->getRepository('TrackerBundle\Entity\Record')
            ->findAll();
        $posts         = $entityManager
            ->getRepository('BlogBundle\Entity\Post')
            ->findAll();

        return $this->render('TrackerBundle:Tracker:dashboard.html.twig', array(
            'records' => $records,
            'posts' => $posts
        ));
    }

    /**
     * Show single record details
     */
    public function recordDetailAction($recordId)
    {
        $entityManager = $this->get('doctrine.orm.default_entity_manager');
        $record        = $entityManager
            ->getRepository('TrackerBundle\Entity\Record')
            ->findOneBy(['id' => $recordId]);

        if (!$record) {
            throw $this->createNotFoundException('Record not found!');
        }

        return $this->render('TrackerBundle:Tracker:recordDetail.html.twig', array(
            'record' => $record
        ));
    }

    /**
     * Show single post records/visits
     */
    public function postRecordsDetailAction($postId)
    {
        $entityManager = $this->get('doctrine.orm.default_entity_manager');

        // get post
        $post = $entityManager
            ->getRepository('BlogBundle\Entity\Post')
            ->findOneBy(['id' => $postId]);

        if (!$post) {
            throw $this->createNotFoundException('Post not found!');
        }

        // get records
        $records = $entityManager
            ->getRepository('TrackerBundle\Entity\Record')
            ->findBy(['post' => $post]);

        return $this->render('TrackerBundle:Tracker:postRecordsDetail.html.twig', array(
            'post' => $post,
            'records' => $records
        ));
    }

    /**
     * Insert registry
     */
    public function trackAction(Request $request)
    {
        $record  = new Record();
        $tracked = json_decode($request->getContent());

        $post = $this->getPostBySlug($tracked->postSlug);

        // TODO: Tota aquesta shit per constructor!
        $record->setPost($post);
        $record->setDevice($tracked->device);
        $record->setOperatingSystem($tracked->operatingSystem);
        $record->setBrowser($tracked->browser);
        $record->setVersion($tracked->version);
        $record->setLanguage($tracked->language);
        $record->setCookieEnabled($tracked->cookieEnabled);
        $record->setDatetime(date_create(date("Y-m-d H:i:s")));

        $entityManager = $this->get('doctrine.orm.default_entity_manager');
        $entityManager->persist($record);
        $entityManager->flush();

        $this->throwRecordTrackerEvent($record);

        return new JsonResponse(array('tracked' => true));;
    }

    private function getPostBySlug($slug)
    {
        $entityManager = $this->get('doctrine.orm.default_entity_manager');
        $post          = $entityManager
            ->getRepository('BlogBundle\Entity\Post')
            ->findOneBy(['slug' => $slug]);

        return $post;
    }

    private function throwRecordTrackerEvent($record)
    {
        $recordTrackedEvent = new RecordTrackedEvent($record);
        $event              = $this->get('event_dispatcher');

        $event->dispatch('record.tracked', $recordTrackedEvent);
    }
}
