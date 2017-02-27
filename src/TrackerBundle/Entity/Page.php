<?php

namespace TrackerBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="page")
 */
class Page
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * One Page has Many Records.
     * @OneToMany(targetEntity="Record", mappedBy="page")
     */
    private $records;


    public function __construct() {
        $this->features = new ArrayCollection();
    }
}