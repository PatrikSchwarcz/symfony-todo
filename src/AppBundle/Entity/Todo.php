<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Todo
 *
 * @ORM\Table(name="todo_todos")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TodoRepository")
 */
class Todo
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
     * @var User
     * 
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=60)
     * @Assert\NotBlank()
     * @Assert\Length(
     *  min = 5,  
     *  max = 60, 
     *  minMessage = "Name field must be at least {{ limit }} character long.",
     *  maxMessage = "Todo name should be shorter than {{ limit }} characters."
     * )
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(max = 255, maxMessage = "You are not writing a book. Limit is {{ limit }} characters.")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="priority", type="string", length=20)
     * @Assert\NotBlank()
     */
    private $priority;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dueDate", type="datetime")
     * @Assert\NotBlank()
     */
    private $dueDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createDate", type="datetime")
     */
    private $createDate;

    /**
     * @var \DateTime
     * 
     * @ORM\Column(name="updateDate", type="datetime")
     */
    private $updateDate;

    public function __construct()
    {
        $this->dueDate = new \DateTime('now');
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }


    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Todo
     */
    public function setName(string $name) : Todo
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName() : ?string
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Todo
     */
    public function setDescription(string $description) : Todo
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription() : ?string
    {
        return $this->description;
    }

    /**
     * Set priority
     *
     * @param string $priority
     *
     * @return Todo
     */
    public function setPriority(string $priority) : Todo
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Get priority
     *
     * @return string
     */
    public function getPriority() : ?string
    {
        return $this->priority;
    }

    /**
     * Set dueDate
     *
     * @param \DateTime $dueDate
     *
     * @return Todo
     */
    public function setDueDate(\DateTime $dueDate) : Todo
    {
        $this->dueDate = $dueDate;

        return $this;
    }

    /**
     * Get dueDate
     *
     * @return \DateTime
     */
    public function getDueDate() : \DateTime
    {
        return $this->dueDate;
    }

    /**
     * Set createDate
     *
     * @param \DateTime $createDate
     *
     * @return Todo
     */
    public function setCreateDate(\DateTime $createDate) : Todo
    {
        $this->createDate = $createDate;

        return $this;
    }

    /**
     * Get createDate
     *
     * @return \DateTime
     */
    public function getCreateDate() : \DateTime
    {
        return $this->createDate;
    }

    /**
     * Set updateDate
     * 
     * @param \DateTime $createDate
     * 
     * @return Todo
     */
    public function setUpdateDate(\DateTime $updateDate) : Todo
    {
        $this->updateDate = $updateDate;

        return $this;
    }

    /**
     * Get updateDate
     *
     * @return \DateTime
     */
    public function getUpdateDate() : \DateTime
    {
        return $this->updateDate;
    }
}

