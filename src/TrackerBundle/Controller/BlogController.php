<?php

namespace TrackerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlogController extends Controller
{
    public function blogAction()
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        $posts = $em->getRepository('TrackerBundle\Entity\Post')->findAll();

        return $this->render('TrackerBundle:Blog:blog.html.twig', array(
            'posts' => $posts,
        ));
    }

    public function postAction($postSlug)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        $post = $em->getRepository('TrackerBundle\Entity\Post')
            ->findOneBy(['slug' => $postSlug]);

        if (!$post) {
            throw $this->createNotFoundException(
                'No post found for this: ' . $slug
            );
        }

        return $this->render('TrackerBundle:Blog:post.html.twig', array(
            'post' => $post
        ));
    }
}
