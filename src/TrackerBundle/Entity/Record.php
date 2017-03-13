<?php


namespace TrackerBundle\Entity;

use BlogBundle\Entity\Post;
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
     * @ORM\ManyToOne(targetEntity="BlogBundle\Entity\Post")
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
     * @param $device
     * @param $operatingSystem
     * @param $browser
     * @param $version
     * @param $language
     * @param $cookieEnabled
     * @param $datetime
     */
    public function __construct(
        $post,
        $device,
        $operatingSystem,
        $browser,
        $version,
        $language,
        $cookieEnabled,
        $datetime
    ) {
        $this->post            = $post;
        $this->device          = $device;
        $this->operatingSystem = $operatingSystem;
        $this->browser         = $browser;
        $this->version         = $version;
        $this->language        = $language;
        $this->cookieEnabled   = $cookieEnabled;
        $this->datetime        = $datetime;
    }

    /**
     * @return mixed
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getPost(): Post
    {
        return $this->post;
    }

    /**
     * @return mixed
     */
    public function getDevice(): string
    {
        return $this->device;
    }

    /**
     * @return mixed
     */
    public function getOperatingSystem(): string
    {
        return $this->operatingSystem;
    }

    /**
     * @return mixed
     */
    public function getBrowser(): string
    {
        return $this->browser;
    }

    /**
     * @return mixed
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @return mixed
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * @return mixed
     */
    public function getCookieEnabled(): bool
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