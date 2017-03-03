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
     * Many Records have One Post
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="records")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     */
    private $post;

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

    /**
     * Record constructor.
     * @param $post
     */
    public function __construct($post)
    {
        $this->post = $post;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @return mixed
     */
    public function getDevice()
    {
        return $this->device;
    }

    /**
     * @return mixed
     */
    public function getOperatingSystem()
    {
        return $this->operatingSystem;
    }

    /**
     * @return mixed
     */
    public function getBrowser()
    {
        return $this->browser;
    }

    /**
     * @return mixed
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @return mixed
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @return mixed
     */
    public function getCookieEnabled()
    {
        return $this->cookieEnabled;
    }

    /**
     * @return mixed
     */
    public function getDatetime()
    {
        return $this->datetime;
    }
}