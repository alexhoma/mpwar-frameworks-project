<?php

namespace LoggerBundle\EventListener;


use LoggerBundle\Services\MovieLogger;

class MovieLoggerEventListener
{
    private $movieLogger;

    public function __construct(MovieLogger $aMovieLogger)
    {
        $this->movieLogger = $aMovieLogger;
    }

    public function logNewMovie($event)
    {
        $this
            ->movieLogger
            ->logNewMovie(
                $event->getMovie()
            );
    }
}