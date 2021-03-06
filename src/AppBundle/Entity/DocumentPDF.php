<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DocumentPDF
 *
 * @ORM\Table(name="document_p_d_f")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */


class DocumentPDF
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
     * @ORM\Column(name="url", type="string",length=255)
     */
    private $url;

    /**
     * @var UploadedFile $file
     * @Assert\File(mimeTypes={"application/pdf"},
     *     mimeTypesMessage="Merci de choisir un fichier .pdf valide")
     */
    private $file;

    private $tempFilename;

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;

        // On vérifie si on avait déjà un fichier pour cette entité
        if (null !== $this->url) {
            // On sauvegarde l'extension du fichier pour le supprimer plus tard
            $this->tempFilename = $this->url;


            // On réinitialise les valeurs des attributs url et alt
            $this->url = null;
        }

    }

    public function __toString()
    {
        return $this->getId().'.'.$this->getUrl();
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id =$id;
    }

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
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url)
    {
        $this->url = $url;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {

        // Si jamais il n'y a pas de fichier (champ facultatif), on ne fait rien
        if (null === $this->file) {
            return;
        }

        // Le nom du fichier est son id, on doit juste stocker également son extension
        // Pour faire propre, on devrait renommer cet attribut en « extension », plutôt que « url »

        $this->url = $this->file->guessExtension();

    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        // Si jamais il n'y a pas de fichier (champ facultatif), on ne fait rien
        if (null === $this->file) {
            return;
        }

        // Si on avait un ancien fichier, on le supprime
        if (null !== $this->tempFilename) {
            $oldFile = $this->getUploadRootDir().'/'.$this->id.'.'.$this->tempFilename;
            if (file_exists($oldFile)) {
                unlink($oldFile);
            }
        }

        // On déplace le fichier envoyé dans le répertoire de notre choix
        $this->file->move(
            $this->getUploadRootDir(), // Le répertoire de destination
            $this->id.'.'.$this->url   // Le nom du fichier à créer, ici « id.extension »
        );
    }

    public function getUploadDir()
    {
        // On retourne le chemin relatif vers l'image pour un navigateur (relatif au répertoire /web donc)
        return 'uploads/pdf';
    }

    protected function getUploadRootDir()
    {
        // On retourne le chemin relatif vers l'image pour notre code PHP
        $test =  __DIR__.'/../../../web/'.$this->getUploadDir();
        return $test;
    }


    public function getWebPath()
    {
        //TODO retirer après la phase dev
        $patternFixturesFiles = '/(newsletter\.pdf)/';

        if(preg_match($patternFixturesFiles,$this->getUrl())){
            return $this->getUploadDir().'/'.'newsletter.pdf';
        }else{
            return $this->getUploadDir().'/'.$this->getId().'.'.$this->getUrl();

        }
    }

}
