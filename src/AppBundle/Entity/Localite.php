<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Localite
 *
 * @ORM\Table(name="localite")
 * @ORM\Entity
 */
class Localite
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
     * @ORM\Column(name="localite", type="string", length=255)
     */
    private $localite;


    /**
     * @var string
     *
     * @ORM\Column(name="code_postal", type="string", length=255)
     */
    private $codePostal;

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
     * Set localite
     *
     * @param string $localite
     *
     * @return Localite
     */
    public function setLocalite($localite)
    {
        $this->localite = $localite;

        return $this;
    }

    /**
     * Get localite
     *
     * @return string
     */
    public function getLocalite()
    {
        return $this->localite;
    }

    /**
     * @return mixed
     */
    public function getCodePostal()
    {
        return $this->codePostal;
    }

    /**
     * @param mixed $codePostal
     */
    public function setCodePostal($codePostal)
    {
        $this->codePostal = $codePostal;
    }


    public function getNomAffichage()
    {
        $string = ($this->getCodePostal()).' - '.($this->getLocalite());
        return $string;

    }

    public function __toString()
    {
        return $this->getLocalite();
    }

}
