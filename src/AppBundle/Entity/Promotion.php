<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * Promotion
 *
 * @ORM\Table(name="promotion")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PromotionRepository")
 */
class Promotion
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
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;


    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="document_pdf", type="string", length=255, nullable=true)
     */
    private $documentPDF;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="debut", type="date")
     */
    private $debut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fin", type="date")
     */
    private $fin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="affichage_de", type="date")
     */
    private $affichageDe;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="affichage_jusque", type="date")
     */
    private $affichageJusque;

    /**
     * Bcp de Promotion concerne un prestataire
     * @ORM\ManyToOne(targetEntity="Prestataire", inversedBy="promotions")
     * @ORM\JoinColumn(name="prestataire", referencedColumnName="id")
     */
    private $prestataire;

    /**
     * bcp de promotions concerne bcp de categories
     * @ORM\ManyToMany(targetEntity="CategorieDeServices", inversedBy="promotions")
     * @ORM\JoinTable(name="categories_des_promotions")
     */
    private $categories;

    public function addCategorie(CategorieDeServices $categ)
    {
        $categ->addPromotions($this);
        $this->categories[]= $categ;
    }

    /**
     * @return mixed
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @return mixed
     */
    public function getPrestataire()
    {
        return $this->prestataire;
    }

    /**
     * @param mixed $prestataire
     */
    public function setPrestataire($prestataire)
    {
        $this->prestataire = $prestataire;
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
     * Set description
     *
     * @param string $description
     *
     * @return Promotion
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set documentPDF
     *
     * @param string $documentPDF
     *
     * @return Promotion
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

    /**
     * Set debut
     *
     * @param \DateTime $debut
     *
     * @return Promotion
     */
    public function setDebut($debut)
    {
        $this->debut = $debut;

        return $this;
    }

    /**
     * Get debut
     *
     * @return \DateTime
     */
    public function getDebut()
    {
        return $this->debut;
    }

    /**
     * Set fin
     *
     * @param \DateTime $fin
     *
     * @return Promotion
     */
    public function setFin($fin)
    {
        $this->fin = $fin;

        return $this;
    }

    /**
     * Get fin
     *
     * @return \DateTime
     */
    public function getFin()
    {
        return $this->fin;
    }

    /**
     * Set affichageDe
     *
     * @param \DateTime $affichageDe
     *
     * @return Promotion
     */
    public function setAffichageDe($affichageDe)
    {
        $this->affichageDe = $affichageDe;

        return $this;
    }

    /**
     * Get affichageDe
     *
     * @return \DateTime
     */
    public function getAffichageDe()
    {
        return $this->affichageDe;
    }

    /**
     * Set affichageJusque
     *
     * @param \DateTime $affichageJusque
     *
     * @return Promotion
     */
    public function setAffichageJusque($affichageJusque)
    {
        $this->affichageJusque = $affichageJusque;

        return $this;
    }

    /**
     * Get affichageJusque
     *
     * @return \DateTime
     */
    public function getAffichageJusque()
    {
        return $this->affichageJusque;
    }

    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }

}
