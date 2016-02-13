<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use JMS\Serializer\Annotation as JMS;

/**
 * Vote
 *
 * @ORM\Table(name="vote")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VoteRepository")
 * @UniqueEntity( fields={"user", "proposal"} )
 *
 * @JMS\ExclusionPolicy("all")
 */
class Vote
{
    const YES = 1;
    const MAYBE = 0;
    const NO = -1;
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @JMS\Expose()
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="vote", type="smallint")
     *
     *
     * @JMS\Accessor(getter="getHumanVote")
     * @JMS\Type("string")
     * @JMS\Expose
     */
    private $vote;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="votes")
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="Proposal", inversedBy="votes")
     *
     * @JMS\Expose()
     */
    protected $proposal;

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
     * Set vote
     *
     * @param integer $vote
     *
     * @return Vote
     */
    public function setVote($vote)
    {
        $this->vote = $vote;

        return $this;
    }

    /**
     * Get vote
     *
     * @return int
     */
    public function getVote()
    {
        return $this->vote;
    }

    /**
     * Set vote
     *
     * @param string $vote
     *
     * @return Vote
     */
    public function setHumanVote($vote)
    {
        $map = array(
            'yes' => self::YES,
            'maybe' => self::MAYBE,
            'no' => self::NO
        );

        return $this->setVote($map[$vote]);
    }

    /**
     * Get vote
     *
     * @return string
     */
    public function getHumanVote()
    {
        $map = array(
            self::YES => 'yes',
            self::MAYBE => 'maybe',
            self::NO => 'no'
        );
        return $map[$this->getVote()];
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Vote
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set proposal
     *
     * @param \AppBundle\Entity\Proposal $proposal
     *
     * @return Vote
     */
    public function setProposal(\AppBundle\Entity\Proposal $proposal = null)
    {
        $this->proposal = $proposal;

        return $this;
    }

    /**
     * Get proposal
     *
     * @return \AppBundle\Entity\Proposal
     */
    public function getProposal()
    {
        return $this->proposal;
    }
}
