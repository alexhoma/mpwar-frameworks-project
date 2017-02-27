<?php

namespace TrackerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TestController extends Controller
{
    public function homeAction()
    {
        return $this->render('TrackerBundle:Test:home.html.twig', array(
            // ...
        ));
    }

    public function blogAction()
    {
        return $this->render('TrackerBundle:Test:blog.html.twig', array(
            // ...
        ));
    }

    public function faqAction()
    {
        return $this->render('TrackerBundle:Test:faq.html.twig', array(
            // ...
        ));
    }

}
