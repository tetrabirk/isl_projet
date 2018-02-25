<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Utilisateur
 *
 * @ORM\Table(name="utilisateur")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UtilisateurRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type_utilisateur", type="string")
 * @ORM\DiscriminatorMap({"utilisateur" = "Utilisateur", "internaute" = "Internaute", "prestataire" = "Prestataire", "admin" = "Admin"})
 */
class Utilisateur implements UserInterface, \Serializable
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
     * @Assert\Email(
     *     message="l'email '{{value}} n'est pas un email valide"
     * )
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     * @Assert\NotBlank()
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
     * @ORM\Column(name="adresse_num", type="string", length=255, nullable=true)
     */
    private $adresseNum;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse_rue", type="string", length=255, nullable=true)
     */
    private $adresseRue;

    /**
     * bcp d'utilisateur ont un code postal
     * @ORM\ManyToOne(targetEntity="Localite")
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

    public function getUsername()
    {
        return $this->getEmail();
    }

    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    public function getPassword()
    {
        return $this->getMotDePasse();
    }

    public function getRoles()
    {
        return array('ROLE_USER');
    }

    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->getEmail(),
            $this->getMotDePasse(),
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized);
    }



    public function __toString()
    {
        return $this->getEmail();
    }


}
