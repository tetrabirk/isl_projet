<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Internaute
 *
 * @ORM\Table(name="internaute")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InternauteRepository")
 */
class Internaute extends Utilisateur
{

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255, nullable=true)
     */
    private $prenom;

    /**
     * @var bool
     *
     * @ORM\Column(name="newsletter", type="boolean")
     */
    private $newsletter;


    /**
     * un internaute à un avatar
     * @ORM\OneToOne(targetEntity="Image",cascade={"persist"})
     */
    private $avatar;

    /**
     * @return mixed
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @param mixed $avatar
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    }



    /**
     * bcp internaute ont bcp de favoris
     * @ORM\ManyToMany(targetEntity="Prestataire", inversedBy="internautesFavoris")
     * @ORM\JoinTable(name="favoris")
     */
    private $favoris;

    public function __construct()
    {
       $this->favoris = new ArrayCollection();
    }

    public function addFavoris(Prestataire $favoris)
    {
        $favoris->addInternauteFavoris($this);
        $this->favoris[]=$favoris;

    }

    /**
     * @return mixed
     */
    public function getFavoris()
    {
        return $this->favoris;
    }

    /**
     * @param mixed $favoris
     */
    public function setFavoris($favoris)
    {
        $this->favoris = $favoris;
    }




    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Internaute
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Internaute
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set newsletter
     *
     * @param boolean $newsletter
     *
     * @return Internaute
     */
    public function setNewsletter($newsletter)
    {
        $this->newsletter = $newsletter;

        return $this;
    }

    /**
     * Get newsletter
     *
     * @return bool
     */
    public function getNewsletter()
    {
        return $this->newsletter;
    }
}
