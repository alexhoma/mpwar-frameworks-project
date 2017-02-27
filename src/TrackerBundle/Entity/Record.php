<?php


namespace TrackerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="record")
 */
class Record
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Many Records have One Page
     * @ORM\ManyToOne(targetEntity="Page", inversedBy="records")
     * @ORM\JoinColumn(name="page_id", referencedColumnName="id")
     */
    private $page;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $device;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $operatingSystem;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $browser;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $version;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $language;

    /**
     * @ORM\Column(type="boolean")
     */
    private $cookieEnabled;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datetime;
}