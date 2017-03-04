<?php

namespace TrackerAlertBundle\EventListener;


use TrackerAlertBundle\Services\TrackerAlert;

class TrackerAlertEventListener
{
    private $trackerAlert;

    public function __construct(TrackerAlert $aTrackerAlert)
    {
        $this->trackerAlert = $aTrackerAlert;
    }

    public function callAlert($event)
    {
        $this
            ->trackerAlert
            ->shouldAlert(
                $event->getRecord()
            );
    }
}