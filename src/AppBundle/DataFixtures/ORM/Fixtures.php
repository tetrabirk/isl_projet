<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Abus;
use AppBundle\Entity\Bloc;
use AppBundle\Entity\CategorieDeServices;
use AppBundle\Entity\Commentaire;
use AppBundle\Entity\Image;
use AppBundle\Entity\Internaute;
use AppBundle\Entity\Newsletter;
use AppBundle\Entity\Prestataire;
use AppBundle\Entity\Promotion;
use AppBundle\Entity\Stage;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use Faker;

class Fixtures extends Fixture
{
    static $nbreCategorie = 8;
    static $nbrePrestataire = 20;
    static $nbreInternaute = 10;
    static $nbreCommentaire = 50;
    static $nbreNewsletter = 50;
    static $nbreAbus = 10;

    static $maxFavorisParInternaute = 10;
    static $maxCategoriesParPrestataire = 5;
    static $maxPhotosParPrestataire = 5;
    static $maxStagesParPrestataire = 5;
    static $maxPromotionsParPrestataire = 5;
    static $maxCategoriesParPromotion = 2;

    var $faker;


    public function __construct()
    {
        $this->faker = Faker\Factory::create('fr_BE');
    }

    public function load(ObjectManager $manager)
    {
//        generation des categories de services

        for($i = 0; $i < self::$nbreCategorie; $i++)
        {
            $categorie = $this->genCategorieDeServices($i);

            $manager->persist($categorie);

        }

//        generation des prestataires

        for($i = 0; $i < self::$nbrePrestataire; $i++)
        {
            $prestataire = $this->genPrestataires($i);

            $manager->persist($prestataire);
        }

//        generation des stages

        $randQuant = rand(0,self::$maxStagesParPrestataire);
        for($i = 0; $i < self::$nbrePrestataire; $i++)
        {
            for ($j = 0; $j < $randQuant; $j++)
            {
                $stage = $this->genStage($i,$j);
                $manager->persist($stage);
            }
        }

//        generation des promotions

        $randQuant = rand(0,self::$maxPromotionsParPrestataire);
        for($i = 0; $i < self::$nbrePrestataire; $i++)
        {
            for ($j = 0; $j < $randQuant; $j++)
            {
                $promotion = $this->genPromotion($i,$j);
                $manager->persist($promotion);
            }
        }

//        generation des internautes

        for($i = 0; $i < self::$nbreInternaute; $i++)
        {
            $internaute = $this->genInternaute($i);

            $manager->persist($internaute);
        }

//        generation des blocs (pas fini car p-e inutile)

        for ($j=0;$j<7;$j++)
        {
            $bloc = $this->genBloc($j);
            $manager->persist($bloc);
        }

//        generation des commentaires

        for ($i = 0; $i < self::$nbreCommentaire; $i++)
        {
            $commentaire = $this->genCommentaires($i);
            $manager->persist($commentaire);
        }

        $manager->flush();

//        generation des abus

        for ($i = 0; $i < self::$nbreAbus; $i++)
        {
            $abus = $this->genAbus();
            $manager->persist($abus);
        }

//        generation des newsletter

        for ($i = 0;$i<self::$nbreNewsletter; $i++)
        {
            $newsletter = $this->genNewsletter($i);
            $manager->persist($newsletter);
        }

        $manager->flush();
    }

    public function genCategorieDeServices($i)
    {
        $categorie = new CategorieDeServices();
        $categorie->setNom($this->faker->words(2,true));
        $categorie->setDescription($this->faker->sentences(20,true));
        $categorie->setEnAvant(false);
        $categorie->setValide(true);

//        ajout d'une image

        $image = $this->genImage('image',$i);
        $categorie->setImage($this->getReference('image'.$i));

        $this->addReference('categorie'.$i,$categorie);

        return $categorie;
    }

    public function genPrestataires($i)
    {

        $prestataire = new Prestataire();
        $prestataire->setEmail($this->uniqueEmail($i,'p'));
        $prestataire->setMotDePasse('password');
        $prestataire->setAdresseNum($this->faker->buildingNumber);
        $prestataire->setAdresseRue($this->faker->streetName);
//        $prestataire->setCodePostal($this->faker->postcode);
//        $prestataire->setLocalite($this->faker->city);
//        $prestataire->setCommune($this->faker->city);
        $prestataire->setInscription($this->faker->dateTimeThisDecade);
        $prestataire->setNbEssaisInfructueux(0);
        $prestataire->setBanni(false);
        $prestataire->setConfInscription(true);

        $prestataire->setNom($this->faker->words(2,true));
        $prestataire->setSiteInternet($this->faker->domainName);
        $prestataire->setEmailContact($this->faker->email);
        $prestataire->setTelephone($this->faker->phoneNumber);
        $prestataire->setNumTVA($this->faker->vat);

//        ajout de categories

        $randArray = $this->randomNumbersArray(rand(1,self::$maxCategoriesParPrestataire),0,self::$nbreCategorie-1);
        foreach ($randArray as $id){
            $prestataire->addCategorie($this->getReference('categorie'.$id));
        }

//        ajout d'un logo

        $logo = $this->genImage('logo',$i);
        $prestataire->setLogo($this->getReference('logo'.$i));

//        ajout des photos

        $randQuant = rand(0,self::$maxPhotosParPrestataire);

        for ($j=0;$j<$randQuant;$j++)
        {
            $photo = $this->genImage('photo',($i.$j));
            $prestataire->addPhoto($this->getReference('photo'.($i.$j)));
        }


        $this->addReference('prestataire'.$i,$prestataire);
        return $prestataire;
    }

    public function genInternaute($i)
    {
        $internaute = new Internaute();
        $internaute->setEmail($this->uniqueEmail($i,'i'));
        $internaute->setMotDePasse('password');
        $internaute->setAdresseNum($this->faker->buildingNumber);
        $internaute->setAdresseRue($this->faker->streetName);
//        $internaute->setCodePostal($this->faker->postcode);
//        $internaute->setLocalite($this->faker->city);
//        $internaute->setCommune($this->faker->city);
        $internaute->setInscription($this->faker->dateTimeThisDecade);
        $internaute->setNbEssaisInfructueux(0);
        $internaute->setBanni(false);
        $internaute->setConfInscription(true);

        $internaute->setNom($this->faker->lastName);
        $internaute->setPrenom($this->faker->firstName);
        $internaute->setNewsletter($this->faker->boolean);

//        ajout d'un avatar

        $avatar = $this->genImage('avatar',$i);
        $internaute->setAvatar($this->getReference('avatar'.$i));


//        ajout des favoris

        $randArray = $this->randomNumbersArray(rand(1,self::$maxFavorisParInternaute),0,self::$nbrePrestataire-1);
        foreach ($randArray as $id){
            $internaute->addFavoris($this->getReference('prestataire'.$id));
        }

        $this->addReference('internaute'.$i,$internaute);
        return $internaute;
    }

    public function genImage($type,$i)
    {
        $img = new Image();
        $img->setNom($type."_".$i.".jpg");
        $this->addReference($type.$i,$img);

    }

    public function genCommentaires($i)
    {
        $commentaire = new Commentaire();
        $randInternauteId = rand(0,self::$nbreInternaute-1);
        $commentaire->setAuteurCommentaire($this->getReference('internaute'.$randInternauteId));
        $randPrestataireId = rand(0,self::$nbrePrestataire-1);
        $commentaire->setCibleCommentaire($this->getReference('prestataire'.$randPrestataireId));
        $commentaire->setCote($this->faker->numberBetween(1,5));
        $commentaire->setTitre($this->faker->sentence());
        $commentaire->setContenu($this->faker->sentences(5,true));
        $commentaire->setEncodage($this->faker->dateTimeThisMonth);
        $this->addReference('commentaire'.$i,$commentaire);
        return $commentaire;
    }

    public function genAbus()
    {
        $abus = new Abus();
        $abus->setDescription($this->faker->sentences(2,true));
        $abus->setEncodage($this->faker->dateTimeBetween('-1weeks','now'));
        $randCommentaireId = rand(0,self::$nbreCommentaire-1);
        $abus->setCommentaire($this->getReference('commentaire'.$randCommentaireId));

        return $abus;
    }

    public function genNewsletter($i)
    {
        $newsletter = new Newsletter();
        $newsletter->setTitre($this->faker->sentence());
        $newsletter->setPublication($this->faker->dateTimeThisYear);
        $newsletter->setDocumentPDF('newsletter'.$i.'.pdf');

        return $newsletter;
    }

    public function genBloc($i)
    {
        $bloc = new Bloc();
        $bloc->setNom($this->faker->word);
        $bloc->setDescription($this->faker->word);
        $bloc->setOrdre($this->faker->numberBetween(1,7));

        return $bloc;
    }

    public function genStage($i,$j)
    {
        $stage = new Stage();
        $stage->setNom($this->faker->words(5,true));
        $stage->setDescription($this->faker->sentences(4,true));
        $stage->setTarif(($this->faker->numberBetween(6,90))*5);
        $stage->setInfoComplementaire($this->faker->sentences(2,true));
        $stage->setDebut($this->faker->dateTimeBetween('-1weeks','3weeks'));
        $datedebut = $stage->getDebut();
        $stage->setFin($this->faker->dateTimeBetween($datedebut,'4weeks'));
        $stage->setAffichageDe($this->faker->dateTimeBetween('-6weeks',$datedebut));
        $stage->setAffichageJusque($stage->getFin());

        $stage->setPrestataire($this->getReference('prestataire'.$i));

        $this->addReference('stage'.$i.$j,$stage);
        return $stage;
    }

    public function genPromotion($i,$j)
    {
        $promotion = new Promotion();
        $promotion->setNom($this->faker->words(5,true));
        $promotion->setDescription($this->faker->sentences(4,true));
        $promotion->setDocumentPDF('promotion'.$i.$j.'.pdf');
        $promotion->setDebut($this->faker->dateTimeBetween('-1weeks','3weeks'));
        $datedebut = $promotion->getDebut();
        $promotion->setFin($this->faker->dateTimeBetween($datedebut,'4weeks'));
        $promotion->setAffichageDe($this->faker->dateTimeBetween('-6weeks',$datedebut));
        $promotion->setAffichageJusque($promotion->getFin());

        $promotion->setPrestataire($this->getReference('prestataire'.$i));
        //        ajout de categories

        $randArray = $this->randomNumbersArray(rand(1,self::$maxCategoriesParPromotion),0,self::$nbreCategorie-1);
        foreach ($randArray as $id){
            $promotion->addCategorie($this->getReference('categorie'.$id));
        }

        $this->addReference('promotion'.$i.$j,$promotion);
        return $promotion;
    }

    public function uniqueEmail($i,$type)
    {
        $email = $type.$i.($this->faker->email);

        return $email;

    }

    //fonction piquée tel quelle sur stackOverflow
    //Generating UNIQUE Random Numbers within a range - PHP
    public function randomNumbersArray($count,$min, $max)
    {
        if ($count > (($max - $min)+1))
        {
            return false;
        }
        $values = range($min, $max);
        shuffle($values);
        return array_slice($values,0, $count);
    }

}
