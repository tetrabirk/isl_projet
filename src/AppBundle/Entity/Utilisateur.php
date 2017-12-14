<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Utilisateur
 *
 * @ORM\Table(name="utilisateur")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UtilisateurRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type_utilisateur", type="string")
 * @ORM\DiscriminatorMap({"utilisateur" = "Utilisateur", "internaute" = "Internaute", "prestataire" = "Prestataire"})
 */
class Utilisateur
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="mot_de_passe", type="string", length=255)
     */
    private $motDePasse;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse_num", type="string", length=10, nullable=true)
     */
    private $adresseNum;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse_rue", type="string", length=255, nullable=true)
     */
    private $adresseRue;

    /**
     *
     * @ORM\OneToOne(targetEntity="CodePostal")
     * @ORM\JoinColumn(name="code_postal_id", referencedColumnName="id")
     */
    private $codePostal;

    /**
     * @ORM\OneToOne(targetEntity="Localite")
     * @ORM\JoinColumn(name="localite_id", referencedColumnName="id")
     */
    private $localite;

     /**
     * @return mixed
     */
    public function getLocalite()
    {
        return $this->localite;
    }

    /**
     * @param mixed $localite
     */
    public function setLocalite($localite)
    {
        $this->localite = $localite;
    }

    /**
     * @return mixed
     */
    public function getCommune()
    {
        return $this->commune;
    }

    /**
     * @param mixed $commune
     */
    public function setCommune($commune)
    {
        $this->commune = $commune;
    }

    /**
     *
     * @ORM\OneToOne(targetEntity="Commune")
     * @ORM\JoinColumn(name="commune_id", referencedColumnName="id")
     */
    private $commune;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="inscription", type="datetime")
     */
    private $inscription;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_essais_infructueux", type="integer")
     */
    private $nbEssaisInfructueux;

    /**
     * @var bool
     *
     * @ORM\Column(name="banni", type="boolean")
     */
    private $banni;

    /**
     * @var bool
     *
     * @ORM\Column(name="conf_inscription", type="boolean")
     */
    private $confInscription;


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
     * Set email
     *
     * @param string $email
     *
     * @return Utilisateur
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set motDePasse
     *
     * @param string $motDePasse
     *
     * @return Utilisateur
     */
    public function setMotDePasse($motDePasse)
    {
        $this->motDePasse = $motDePasse;

        return $this;
    }

    /**
     * Get motDePasse
     *
     * @return string
     */
    public function getMotDePasse()
    {
        return $this->motDePasse;
    }

    /**
     * Set adresseNum
     *
     * @param string $adresseNum
     *
     * @return Utilisateur
     */
    public function setAdresseNum($adresseNum)
    {
        $this->adresseNum = $adresseNum;

        return $this;
    }

    /**
     * Get adresseNum
     *
     * @return string
     */
    public function getAdresseNum()
    {
        return $this->adresseNum;
    }

    /**
     * Set adresseRue
     *
     * @param string $adresseRue
     *
     * @return Utilisateur
     */
    public function setAdresseRue($adresseRue)
    {
        $this->adresseRue = $adresseRue;

        return $this;
    }

    /**
     * Get adresseRue
     *
     * @return string
     */
    public function getAdresseRue()
    {
        return $this->adresseRue;
    }

    /**
     * Set codePostal
     *
     * @param string $codePostal
     *
     * @return Utilisateur
     */
    public function setCodePostal($codePostal)
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * Get codePostal
     *
     * @return string
     */
    public function getCodePostal()
    {
        return $this->codePostal;
    }

    /**
     * Set inscription
     *
     * @param \DateTime $inscription
     *
     * @return Utilisateur
     */
    public function setInscription($inscription)
    {
        $this->inscription = $inscription;

        return $this;
    }

    /**
     * Get inscription
     *
     * @return \DateTime
     */
    public function getInscription()
    {
        return $this->inscription;
    }

    /**
     * Set nbEssaisInfructueux
     *
     * @param integer $nbEssaisInfructueux
     *
     * @return Utilisateur
     */
    public function setNbEssaisInfructueux($nbEssaisInfructueux)
    {
        $this->nbEssaisInfructueux = $nbEssaisInfructueux;

        return $this;
    }

    /**
     * Get nbEssaisInfructueux
     *
     * @return int
     */
    public function getNbEssaisInfructueux()
    {
        return $this->nbEssaisInfructueux;
    }

    /**
     * Set banni
     *
     * @param boolean $banni
     *
     * @return Utilisateur
     */
    public function setBanni($banni)
    {
        $this->banni = $banni;

        return $this;
    }

    /**
     * Get banni
     *
     * @return bool
     */
    public function getBanni()
    {
        return $this->banni;
    }

    /**
     * Set confInscription
     *
     * @param boolean $confInscription
     *
     * @return Utilisateur
     */
    public function setConfInscription($confInscription)
    {
        $this->confInscription = $confInscription;

        return $this;
    }

    /**
     * Get confInscription
     *
     * @return bool
     */
    public function getConfInscription()
    {
        return $this->confInscription;
    }

    public function getType(){
        $userClassFull = explode('\\',get_class($this));
        return end($userClassFull);
    }

}
