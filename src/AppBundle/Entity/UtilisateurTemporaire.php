<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * UtilisateurTemporaire
 *
 * @ORM\Table(name="utilisateur_temporaire")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UtilisateurTemporaireRepository")
 */
class UtilisateurTemporaire
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
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="motDePasse", type="string", length=255)
     */
    private $motDePasse;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     */

    private $motDePasseNonCripte;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=255, unique=true)
     */
    private $token;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set email.
     *
     * @param string $email
     *
     * @return UtilisateurTemporaire
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set motDePasse.
     *
     * @param string $motDePasse
     *
     * @return UtilisateurTemporaire
     */
    public function setMotDePasse($motDePasse)
    {
        $this->motDePasse = $motDePasse;

        return $this;
    }

    /**
     * Get motDePasse.
     *
     * @return string
     */
    public function getMotDePasse()
    {
        return $this->motDePasse;
    }

    /**
     * Set date.
     *
     * @param \DateTime $date
     *
     * @return UtilisateurTemporaire
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date.
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return mixed
     */
    public function getMotDePasseNonCripte()
    {
        return $this->motDePasseNonCripte;
    }

    /**
     * @param mixed $motDePasseNonCripte
     */
    public function setMotDePasseNonCripte($motDePasseNonCripte)
    {
        $this->motDePasseNonCripte = $motDePasseNonCripte;
    }

    /**
     * Set token.
     *
     * @param string $token
     *
     * @return UtilisateurTemporaire
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token.
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

}