<?php

namespace TrackerBundle\Event;

use TrackerBundle\Entity\Record;
use Symfony\Component\EventDispatcher\Event;


class RecordTrackedEvent extends Event
{
    private $record;

    public function __construct(Record $aRecord)
    {
        $this->record = $aRecord;
    }

    public function getRecord()
    {
        die();

        return $this->record;
    }
}