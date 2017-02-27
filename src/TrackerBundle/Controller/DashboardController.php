<?php

namespace TrackerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller
{
    # Dashboard index / registry list
    public function indexAction()
    {
        return $this->render('TrackerBundle:Dashboard:index.html.twig');
    }

    # Show Registry details
    # Insert registry
}
