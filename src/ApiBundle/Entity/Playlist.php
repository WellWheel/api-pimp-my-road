<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Playlist
 *
 * @ORM\Table(name="playlist")
 * @ORM\Entity(repositoryClass="ApiBundle\Repository\PlaylistRepository")
 */
class Playlist
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=255, unique=true)
     */
    private $token;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var integer
     *
     * @ORM\Column(name="affected", type="integer")
     */
    private $affected;

    /**
     * @ORM\OneToMany(targetEntity="ApiBundle\Entity\JourneyPlaylist", mappedBy="playlist")
     */
    private $journeyplaylists;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set token
     *
     * @param string $token
     *
     * @return Playlist
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Playlist
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->journeyplaylists = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set affected
     *
     * @param integer $affected
     *
     * @return Playlist
     */
    public function setAffected($affected)
    {
        $this->affected = $affected;

        return $this;
    }

    /**
     * Get affected
     *
     * @return integer
     */
    public function getAffected()
    {
        return $this->affected;
    }

    /**
     * Add journeyplaylist
     *
     * @param \ApiBundle\Entity\JourneyPlaylist $journeyplaylist
     *
     * @return Playlist
     */
    public function addJourneyplaylist(\ApiBundle\Entity\JourneyPlaylist $journeyplaylist)
    {
        $this->journeyplaylist[] = $journeyplaylist;

        return $this;
    }

    /**
     * Remove journeyplaylist
     *
     * @param \ApiBundle\Entity\JourneyPlaylist $journeyplaylist
     */
    public function removeJourneyplaylist(\ApiBundle\Entity\JourneyPlaylist $journeyplaylist)
    {
        $this->journeyplaylist->removeElement($journeyplaylist);
    }

    /**
     * Get journeyplaylist
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getJourneyplaylists()
    {
        return $this->journeyplaylists;
    }
}
