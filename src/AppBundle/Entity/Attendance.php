<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Attendance
 *
 * It is not abstract. Attendance instance is created at AttendanceController to show the Attendance Form
 *
 * @ORM\MappedSuperclass()
 * @ORM\HasLifecycleCallbacks()
 */
class Attendance
{
    /**
     * @var int
     *
     * @ORM\Column(name="delay", type="integer")
     */
    private $delay;

    /**
     * @var int (0: not handled || 1: not justified || 2: justified)
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
     * @var string
     *
     * @ORM\Column(name="day_of_week", type="string")
     */
    private $dayOfWeek;

    /**
     * @var \DateTime
     * @ORM\Column(name="schedule_time", type="time", nullable=true)
     */
    private $scheduleTime;

    protected $user;

    /**
     * Attendance constructor.
     */
    public function __construct()
    {
        $this->delay        = 0;
        $this->createdAt    = new \DateTime();
        $this->updatedAt    = $this->createdAt;
    }

    /**
     * Set delay
     *
     * @param integer $delay
     *
     * @return Attendance
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
     * @return Attendance
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
     * @return Attendance
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
     * @return Attendance
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
     * @return string
     */
    public function getDayOfWeek()
    {
        return $this->dayOfWeek;
    }

    /**
     * @param string $dayOfWeek
     * @return $this
     */
    public function setDayOfWeek($dayOfWeek)
    {
        $this->dayOfWeek = $dayOfWeek;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getScheduleTime()
    {
        return $this->scheduleTime;
    }

    /**
     * @param \DateTime $scheduleTime
     * @return $this
     */
    public function setScheduleTime($scheduleTime)
    {
        $this->scheduleTime = $scheduleTime;

        return $this;
    }

    /**
     * Set commentByUser
     *
     * @param string $commentByUser
     *
     * @return Attendance
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
     * @return Attendance
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
     * @return Attendance
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
