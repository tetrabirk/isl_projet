<?php

namespace AppBundle\Entity;

use AppBundle\Form\CategorieDeServicesType;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Prestataire
 *
 * @ORM\Table(name="prestataire")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PrestataireRepository")

 */
class Prestataire extends Utilisateur
{

    /**
     * @var string
     * @Assert\NotBlank(
     *     message="Le nom ne peut pas être vide"
     * )
     * @Assert\Length(
     *     min=2,
     *     max=255,
     *     minMessage="le nom doit comporter au moins {{limit}} caractères ",
     *     maxMessage="le nom ne peut pas comprter plus de {{limit}} caractères "
     * )
     * @ORM\Column(name="nom", type="string", length=255)
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
     * @Assert\Url(
     *     message = "l'url '{{value}}' n'est pas une url valide"
     * )
     * @ORM\Column(name="site_internet", type="string", length=255, nullable=true)
     */
    private $siteInternet;

    /**
     * @var string
     * @Assert\Email(
     *     message="l'email '{{value}} n'est pas un email valide"
     * )
     * @ORM\Column(name="email_de_contact", type="string", length=255, nullable=true)
     */
    private $emailContact;

    /**
     * @var string
     * @ORM\Column(name="telephone", type="string", length=255, nullable=true)
     */
    private $telephone;

    /**
     * @var string
     * @Assert\Regex(
     *     pattern="/^(BE)\s?\d{9}$/",
     *     message="le numéro de TVA doit suivre le format BE123456789"
     * )
     * @ORM\Column(name="num_tva", type="string", length=255, nullable=true)
     */
    private $numTVA;

    /**
     * bcp de prestataires ont bcp de categories
     * @ORM\ManyToMany(targetEntity="CategorieDeServices", inversedBy="prestataires", cascade={"persist"})
     * @ORM\JoinTable(name="categories_des_prestataires")
     */
    private $categories;



    //attention c'est bien une one to many unidirectionnelle malgré le ManyToMany dans la fonction. J'ai respecté la doc de doctrine

    /**
     * 1 prestataires ont bcp de photos
     * @ORM\ManyToMany(targetEntity="Image",cascade={"persist"})
     * @ORM\JoinTable(name="photos_Prestataires",
     *     joinColumns={@ORM\JoinColumn(name="prestataire_id", referencedColumnName= "id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="image_id",referencedColumnName="id",unique=true)}
     *)
     */
    private $photos;


    /**
     * un prestataire à un logo
     * @ORM\OneToOne(targetEntity="Image",cascade={"persist", "remove"})
     */
    private $logo;

    /**
     *
     * @ORM\Column(name="moyenne_cote", type="decimal")
     */

    private $moyenneCote;

    /**
     * @return mixed
     */
    public function getMoyenneCote()
    {
        return $this->moyenneCote;
    }

    /**
     * @param mixed $moyenneCote
     */
    public function setMoyenneCote($moyenneCote): void
    {
        $this->moyenneCote = $moyenneCote;
    }



    /**
     * @return mixed
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @param mixed $logo
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
    }

    /**
     * @param CategorieDeServices $categ
     */
    public function addCategorie(CategorieDeServices $categ)
    {
        $categ->addPrestataires($this);
        $this->categories->add($categ);
    }

    /**
     * @param CategorieDeServicesType $categ
     */
    public function removeCategorie(CategorieDeServicesType $categ)
    {
        $this->categories->removeElement($categ);
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
    public function getInternautesFavoris()
    {
        return $this->internautesFavoris;
    }




    /**
     * @ORM\OneToMany(targetEntity="Stage",mappedBy="prestataire")
     */

    private $stages;

    /**
     * @ORM\OneToMany(targetEntity="Promotion",mappedBy="prestataire")
     */

    private $promotions;

    /**
     * Bcp de Prestataire ont bcp d'utilisateur qui les ont ajouté dans leurs favoris
     * @ORM\ManyToMAny(targetEntity="Internaute", mappedBy="favoris", cascade={"all"})
     */

    private $internautesFavoris;

    public function addInternauteFavoris(Internaute $IntFav)
    {
        $this->internautesFavoris[] = $IntFav;
    }

    /**
     * Remove internauteFavoris
     *
     * @param \AppBundle\Entity\Internaute $IntFav
     */
    public function removeInternauteFavoris(Internaute $IntFav)
    {
        $this->internautesFavoris->removeElement($IntFav);
    }


    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Prestataire
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
     * Set siteInternet
     *
     * @param string $siteInternet
     *
     * @return Prestataire
     */
    public function setSiteInternet($siteInternet)
    {
        $this->siteInternet = $siteInternet;

        return $this;
    }

    /**
     * Get siteInternet
     *
     * @return string
     */
    public function getSiteInternet()
    {
        return $this->siteInternet;
    }

    /**
     * Set emailContact
     *
     * @param string $emailContact
     *
     * @return Prestataire
     */
    public function setEmailContact($emailContact)
    {
        $this->emailContact = $emailContact;

        return $this;
    }

    /**
     * Get emailContact
     *
     * @return string
     */
    public function getEmailContact()
    {
        return $this->emailContact;
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     *
     * @return Prestataire
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set numTVA
     *
     * @param string $numTVA
     *
     * @return Prestataire
     */
    public function setNumTVA($numTVA)
    {
        $this->numTVA = $numTVA;

        return $this;
    }


    /**
     * Get numTVA
     *
     * @return string
     */
    public function getNumTVA()
    {
        return $this->numTVA;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->stages = new ArrayCollection();
        $this->promotions = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->internautesFavoris = new ArrayCollection();
        $this->photos = new ArrayCollection();
        $this->setNbEssaisInfructueux(0);
        $this->setBanni(false);
        $this->setConfInscription(true);
        $this->setMoyenneCote(0);

    }

    /**
     * Add stage
     *
     * @param \AppBundle\Entity\Stage $stage
     *
     * @return Prestataire
     */
    public function addStage(Stage $stage)
    {
        $this->stages[] = $stage;

        return $this;
    }

    /**
     * Remove stage
     *
     * @param \AppBundle\Entity\Stage $stage
     */
    public function removeStage(Stage $stage)
    {
        $this->stages->removeElement($stage);
    }

    /**
     * Get stages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStages()
    {
        return $this->stages;
    }

    /**
     * Add promotion
     *
     * @param \AppBundle\Entity\Promotion $promotion
     *
     * @return Prestataire
     */
    public function addPromotion(Promotion $promotion)
    {
        $this->promotions[] = $promotion;

        return $this;
    }

    /**
     * Remove promotion
     *
     * @param \AppBundle\Entity\Promotion $promotion
     */
    public function removePromotion(Promotion $promotion)
    {
        $this->promotions->removeElement($promotion);
    }

    /**
     * Get promotions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPromotions()
    {
        return $this->promotions;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Add photos
     *
     * @param \AppBundle\Entity\Image $image
     *
     * @return Prestataire
     */
    public function addPhoto(Image $image)
    {
        $this->photos[] = $image;

        return $this;
    }

    /**
     * Remove photo
     *
     * @param \AppBundle\Entity\Image $image
     */
    public function removePhoto(Image $image)
    {
        $this->photos->removeElement($image);
    }


    /**
     * Get photos
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPhotos()
    {
        return $this->photos;
    }


    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    public function __toString()
    {
        return $this->getNom();
    }

    /**
     * @param mixed $categories
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    /**
     * @param mixed $photos
     */
    public function setPhotos($photos)
    {
        $this->photos = $photos;
    }





}
