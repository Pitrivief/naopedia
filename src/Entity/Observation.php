<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ObservationRepository")
 */
class Observation {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User",cascade={"persist"})
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Bird",cascade={"persist"});
     */
    private $bird;

    /**
     * @ORM\Column(type="array")
     */
    private $geoloc;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $searchDate;

    /**
     * @Assert\Valid
     * @ORM\OneToOne(targetEntity="App\Entity\Image",cascade={"persist"})
     */
    private $image;

    /**
     *
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $refuseMessage;

    /**
     * @ORM\Column(type="boolean")
     */
    private $valid;

    public function __construct() {
        $this->setDate(new \DateTime());
        $this->valid = false;
    }

    /**
     * Get the value of Id
     *
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set the value of Id
     *
     * @param mixed id
     *
     * @return self
     */
    public function setId($id) {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of User
     *
     * @return mixed
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * Set the value of User
     *
     * @param mixed user
     *
     * @return self
     */
    public function setUser(User $user) {
        $this->user = $user;

        return $this;
    }

    /**
     * Set the value of User
     *
     * @param mixed user
     *
     * @return self
     */
    public function getAuthor() {

        return $this->user;
    }
    
    /**
     * Set the value of User
     *
     * @param mixed user
     *
     * @return self
     */
    public function setAuthor(User $user) {
        $this->user = $user;

        return $this;
    }

    /**
     * Get the value of Bird
     *
     * @return mixed
     */
    public function getBird() {
        return $this->bird;
    }

    /**
     * Set the value of Bird
     *
     * @param mixed bird
     *
     * @return self
     */
    public function setBird($bird) {
        $this->bird = $bird;

        return $this;
    }

    /**
     * Get the value of Geoloc
     *
     * @return mixed
     */
    public function getGeoloc($value = null) {
        if (is_null($value))
            return $this->geoloc;
        if ($value == "lat")
            return $this->geoloc[0];
        if ($value == "lng")
            return $this->geoloc[1];
        return null;
    }

    /**
     * Set the value of Geoloc
     *
     * @param mixed geoloc
     *
     * @return self
     */
    public function setGeoloc($geoloc) {
        $this->geoloc = $geoloc;

        return $this;
    }

    /**
     * Get the value of Date
     *
     * @return mixed
     */
    public function getDate() {
        return $this->date;
    }

    /**
     * Set the value of Date
     *
     * @param mixed date
     *
     * @return self
     */
    public function setDate($date) {
        $this->date = $date;
        $this->searchDate = $date->format("Ym");
        return $this;
    }

    /**
     *
     * @return type
     */
    public function getSearchDate() {
        return $this->searchDate;
    }

    /**
     * Get the value of Image
     *
     * @return mixed
     */
    public function getImage() {
        return $this->image;
    }

    /**
     * Set the value of Image
     *
     * @param mixed image
     *
     * @return self
     */
    public function setImage($image) {
        $this->image = $image;

        return $this;
    }

    /**
     * Get the value of Valid
     *
     * @return mixed
     */
    public function getValid() {
        return $this->valid;
    }

    /**
     * Set the value of Valid
     *
     * @param mixed valid
     *
     * @return self
     */
    public function setValid($valid) {
        $this->valid = $valid;

        return $this;
    }

    /**
     * Get the value of Refuse Message
     *
     * @return mixed
     */
    public function getRefuseMessage() {
        return $this->refuseMessage;
    }

    /**
     * Set the value of Refuse Message
     *
     * @param mixed refuseMessage
     *
     * @return self
     */
    public function setRefuseMessage($refuseMessage) {
        $this->refuseMessage = $refuseMessage;

        return $this;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

}
