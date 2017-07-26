<?php

namespace UserBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @ApiResource(attributes={
 *     "normalization_context"={"groups"={"user", "user-read"}},
 *     "denormalization_context"={"groups"={"user", "user-write"}}
 * })
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Groups({"user"})
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user"})
     */
    protected $fullname;

    /**
     * @Groups({"user-write"})
     */
    protected $plainPassword;

    /**
     * @Groups({"user"})
     */
    protected $username;

    /**
     * @ORM\OneToMany(targetEntity="ApiBundle\Entity\Journey", mappedBy="user")
     */
    protected $journeys;

    public function setFullname($fullname)
    {
        $this->fullname = $fullname;

        return $this;
    }
    public function getFullname()
    {
        return $this->fullname;
    }

    public function isUser(UserInterface $user = null)
    {
        return $user instanceof self && $user->id === $this->id;
    }

    /**
     * Add journey
     *
     * @param \ApiBundle\Entity\Journey $journey
     *
     * @return User
     */
    public function addJourney(\ApiBundle\Entity\Journey $journey)
    {
        $this->journeys[] = $journey;

        return $this;
    }

    /**
     * Remove journey
     *
     * @param \ApiBundle\Entity\Journey $journey
     */
    public function removeJourney(\ApiBundle\Entity\Journey $journey)
    {
        $this->journeys->removeElement($journey);
    }

    /**
     * Get journeys
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getJourneys()
    {
        return $this->journeys;
    }
}
