<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AttendanceIn
 *
 * @ORM\Table(name="attendance_in")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AttendanceInRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class AttendanceIn
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
     * @var int
     *
     * @ORM\Column(name="delay", type="integer")
     */
    private $delay;

    /**
     * @var int (0: nothing to say || 1: not justified || 2: justified)
     *
     * @ORM\Column(name="justified", type="integer")
     */
    private $justified;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * @var string
     *
     * @ORM\Column(name="comment_by_user", type="text", nullable=true)
     */
    private $commentByUser;

    /**
     * @var string
     *
     * @ORM\Column(name="comment_by_admin", type="text", nullable=true)
     */
    private $commentByAdmin;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="attendanceIn")
     */
    private $user;

    /**
     * AttendanceIn constructor.
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = $this->createdAt;
    }

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
     * Set delay
     *
     * @param integer $delay
     *
     * @return AttendanceIn
     */
    public function setDelay($delay)
    {
        $this->delay = $delay;

        return $this;
    }

    /**
     * Get delay
     *
     * @return int
     */
    public function getDelay()
    {
        return $this->delay;
    }

    /**
     * Set justified
     *
     * @param integer $justified
     *
     * @return AttendanceIn
     */
    public function setJustified($justified)
    {
        $this->justified = $justified;

        return $this;
    }

    /**
     * Get justified
     *
     * @return int
     */
    public function getJustified()
    {
        return $this->justified;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return AttendanceIn
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @ORM\PreUpdate()
     *
     * @return AttendanceIn
     */
    public function setUpdatedAt()
    {
        $this->updatedAt = new \DateTime();

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set commentByUser
     *
     * @param string $commentByUser
     *
     * @return AttendanceIn
     */
    public function setCommentByUser($commentByUser)
    {
        $this->commentByUser = $commentByUser;

        return $this;
    }

    /**
     * Get commentByUser
     *
     * @return string
     */
    public function getCommentByUser()
    {
        return $this->commentByUser;
    }

    /**
     * Set commentByAdmin
     *
     * @param string $commentByAdmin
     *
     * @return AttendanceIn
     */
    public function setCommentByAdmin($commentByAdmin)
    {
        $this->commentByAdmin = $commentByAdmin;

        return $this;
    }

    /**
     * Get commentByAdmin
     *
     * @return string
     */
    public function getCommentByAdmin()
    {
        return $this->commentByAdmin;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return AttendanceIn
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
}
