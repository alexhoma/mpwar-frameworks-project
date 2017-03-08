<?php

namespace TrackerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller
{
    /**
     * Dashboard index / registry list
     * Displays two lists:
     *  - Posts list
     *  - Records list
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function dashboardAction()
    {
        $entityManager = $this->get('doctrine.orm.default_entity_manager');
        $records = $entityManager
            ->getRepository('TrackerBundle\Entity\Record')
            ->findAll();
        $posts = $entityManager
            ->getRepository('BlogBundle\Entity\Post')
            ->findAll();

        return $this->render('TrackerBundle:Tracker:dashboard.html.twig', array(
            'records' => $records,
            'posts' => $posts
        ));
    }

    /**
     * Show single record details
     * Displays the user agent data of a single record
     *
     * @param $recordId
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function recordDetailAction($recordId)
    {
        $entityManager = $this->get('doctrine.orm.default_entity_manager');
        $record = $entityManager
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
     * Displays a list of records related to a single post
     *
     * @param $postId
     * @return \Symfony\Component\HttpFoundation\Response
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
}