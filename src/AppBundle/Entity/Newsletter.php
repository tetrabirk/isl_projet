<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Newsletter
 *
 * @ORM\Table(name="newsletter")
 * @ORM\Entity
 */
class Newsletter
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
     * @ORM\Column(name="titre", type="string", length=255)
     * @Assert\NotBlank(
     *     message="Le titre ne peut pas être vide"
     * )
     * @Assert\Length(
     *     min=2,
     *     max=255,
     *     minMessage="le titre doit comporter au moins {{limit}} caractères ",
     *     maxMessage="le titre ne peut pas comprter plus de {{limit}} caractères "
     * )
     */
    private $titre;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="publication", type="datetime")
     */
    private $publication;

    /**
     * @var string
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\DocumentPDF",cascade={"persist","remove"})
     */
    private $documentPDF;


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
     * Set titre
     *
     * @param string $titre
     *
     * @return Newsletter
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set publication
     *
     * @param \DateTime $publication
     *
     * @return Newsletter
     */
    public function setPublication($publication)
    {
        $this->publication = $publication;

        return $this;
    }

    /**
     * Get publication
     *
     * @return \DateTime
     */
    public function getPublication()
    {
        return $this->publication;
    }

    /**
     * Set documentPDF
     *
     * @param string $documentPDF
     *
     * @return Newsletter
     */
    public function setDocumentPDF($documentPDF)
    {
        $this->documentPDF = $documentPDF;

        return $this;
    }

    /**
     * Get documentPDF
     *
     * @return string
     */
    public function getDocumentPDF()
    {
        return $this->documentPDF;
    }
}
