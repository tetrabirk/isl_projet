<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * CategorieDeServices
 *
 * @ORM\Table(name="categorie_de_services")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategorieDeServicesRepository")
 */
class CategorieDeServices
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
     * @ORM\Column(name="nom", type="string", length=255, unique=true)
     */
    private $nom;

    /**
     * @var string
     * @Gedmo\Slug(fields={"nom"})
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;


    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var bool
     *
     * @ORM\Column(name="en_avant", type="boolean")
     */
    private $enAvant;

    /**
     * @var bool
     *
     * @ORM\Column(name="valide", type="boolean")
     */
    private $valide;

    /**
     * Bcp de CategorieDeServices ont bcp de Prestataire
     * @ORM\ManyToMany(targetEntity="Prestataire", mappedBy="categories")
     */
    private $prestataires;

    /**
     * Bcp de CategorieDeServices ont bcp de Promotions
     * @ORM\ManyToMany(targetEntity="Promotion", mappedBy="categories")
     */
    private $promotions;


    /**
     * une categorie à une image
     * @ORM\OneToOne(targetEntity="Image",cascade={"persist"})
     */
    private $image;

    /**
     * Constructor
     */

    public function __construct()
    {
        $this->prestataires = new ArrayCollection();
        $this->promotions = new ArrayCollection();
    }

    public function addPrestataires(Prestataire $prestataire)
    {
        $this->prestataires[] = $prestataire;
    }

    public function addPromotions(Promotion $promotion)
    {
        $this->promotions[] = $promotion;
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
     * @return CategorieDeServices
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
     * Set enAvant
     *
     * @param boolean $enAvant
     *
     * @return CategorieDeServices
     */
    public function setEnAvant($enAvant)
    {
        $this->enAvant = $enAvant;

        return $this;
    }

    /**
     * Get enAvant
     *
     * @return bool
     */
    public function getEnAvant()
    {
        return $this->enAvant;
    }

    /**
     * Set valide
     *
     * @param boolean $valide
     *
     * @return CategorieDeServices
     */
    public function setValide($valide)
    {
        $this->valide = $valide;

        return $this;
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

    /**
     * Get valide
     *
     * @return bool
     */
    public function getValide()
    {
        return $this->valide;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

}
