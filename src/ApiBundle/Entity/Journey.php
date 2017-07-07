<?php
namespace ApiBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Journey
 *
 * @ORM\Table(name="journey")
 * @ORM\Entity(repositoryClass="ApiBundle\Repository\JourneyRepository")
 */
class Journey
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
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="journeys")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=255)
     */
    private $token;

    /**
     * @var string
     *
     * @ORM\Column(name="start", type="string", length=255)
     */
    private $start;

    /**
     * @var string
     *
     * @ORM\Column(name="end", type="string", length=255)
     */
    private $end;

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
     * Set start
     *
     * @param string $start
     *
     * @return Journey
     */
    public function setStart($start)
    {
        $this->start = $start;
        return $this;
    }
    /**
     * Get start
     *
     * @return string
     */
    public function getStart()
    {
        return $this->start;
    }
    /**
     * Set end
     *
     * @param string $end
     *
     * @return Journey
     */
    public function setEnd($end)
    {
        $this->end = $end;
        return $this;
    }
    /**
     * Get end
     *
     * @return string
     */
    public function getEnd()
    {
        return $this->end;
    }
    /**
     * Set token
     *
     * @param string $token
     *
     * @return Journey
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
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return Journey
     */
    public function setUser(\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
