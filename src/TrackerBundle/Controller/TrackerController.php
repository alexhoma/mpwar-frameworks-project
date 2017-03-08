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
     * Insert registry
     * Handles ajax request with all user agent data
     * Persists this data into a record table
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function trackAction(Request $request)
    {
        $tracked = json_decode($request->getContent());

        $post = $this->getPostBySlug($tracked->postSlug);

        $record = new Record(
            $post,
            $tracked->device,
            $tracked->operatingSystem,
            $tracked->browser,
            $tracked->version,
            $tracked->language,
            $tracked->cookieEnabled,
            date_create(date("Y-m-d H:i:s"))
        );

        $entityManager = $this->get('doctrine.orm.default_entity_manager');
        $entityManager->persist($record);
        $entityManager->flush();

        $this->throwRecordTrackerEvent($record);

        return new JsonResponse(array('tracked' => true));;
    }

    /**
     * Returns a single post by the slug
     *
     * @param $slug
     * @return mixed
     */
    private function getPostBySlug($slug)
    {
        $entityManager = $this->get('doctrine.orm.default_entity_manager');
        $post = $entityManager
            ->getRepository('BlogBundle\Entity\Post')
            ->findOneBy(['slug' => $slug]);

        return $post;
    }

    /**
     * Throws an event when a record is
     *
     * @param $record
     */
    private function throwRecordTrackerEvent($record)
    {
        $recordTrackedEvent = new RecordTrackedEvent($record);
        $event = $this->get('event_dispatcher');

        $event->dispatch('record.tracked', $recordTrackedEvent);
    }
}
