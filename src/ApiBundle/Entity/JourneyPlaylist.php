<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JourneyPlaylist
 *
 * @ORM\Table(name="journey_playlist")
 * @ORM\Entity(repositoryClass="ApiBundle\Repository\JourneyPlaylistRepository")
 */
class JourneyPlaylist
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
     * @ORM\ManyToOne(targetEntity="ApiBundle\Entity\Journey", inversedBy="journeyplaylist")
     * @ORM\JoinColumn(nullable=false)
     */
    private $journey;

    /**
     * @ORM\ManyToOne(targetEntity="ApiBundle\Entity\Playlist", inversedBy="journeyplaylist")
     * @ORM\JoinColumn(nullable=false)
     */
    private $playlist;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set journey
     *
     * @param \ApiBundle\Entity\Journey $journey
     *
     * @return JourneyPlaylist
     */
    public function setJourney(\ApiBundle\Entity\Journey $journey)
    {
        $this->journey = $journey;

        return $this;
    }

    /**
     * Get journey
     *
     * @return \ApiBundle\Entity\Journey
     */
    public function getJourney()
    {
        return $this->journey;
    }

    /**
     * Set playlist
     *
     * @param \ApiBundle\Entity\Playlist $playlist
     *
     * @return JourneyPlaylist
     */
    public function setPlaylist(\ApiBundle\Entity\Playlist $playlist)
    {
        $this->playlist = $playlist;

        return $this;
    }

    /**
     * Get playlist
     *
     * @return \ApiBundle\Entity\Playlist
     */
    public function getPlaylist()
    {
        return $this->playlist;
    }
}
