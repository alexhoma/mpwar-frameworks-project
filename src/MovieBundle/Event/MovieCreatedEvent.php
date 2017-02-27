<?php

namespace MovieBundle\Event;

use MovieBundle\Entity\Movie;
use Symfony\Component\EventDispatcher\Event;


class MovieCreatedEvent extends Event
{
    private $movie;

    public function __construct(Movie $movie)
    {
        $this->movie = $movie;
    }

    public function getMovie()
    {
        return $this->movie;
    }
}