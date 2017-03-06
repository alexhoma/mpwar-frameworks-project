<?php

namespace AlertBundle\EventListener;


use AlertBundle\Services\Alert;

class AlertEventListener
{
    private $alert;

    public function __construct(Alert $anAlert)
    {
        $this->alert = $anAlert;
    }

    public function callAlert($event)
    {
        $this
            ->alert
            ->shouldAlert($event->getRecord());
    }
}