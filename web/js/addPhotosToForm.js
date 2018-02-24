$(document).ready(function () {

    // On récupère la balise <div> en question qui contient l'attribut « data-prototype » qui nous intéresse.
    var $container = $('div#appbundle_prestataire_photos');
    // $('div#appbundle_prestataire_photos > .form-group').remove();

    // On définit un compteur unique pour nommer les champs qu'on va ajouter dynamiquement
    var index = ($container.children().length);

    // On ajoute un nouveau champ à chaque clic sur le lien d'ajout.
    $('#add_photos').click(function (e) {
        addPhoto($container);

        e.preventDefault(); // évite qu'un # apparaisse dans l'URL
        return false;
    });


    //on ajoute un preview de la photo

    $container.children('div').each(function () {
        addPreviewImage($(this));
    });


    // S'il existe déjà des catégories, on ajoute un lien de suppression pour chacune d'entre elles
    $container.children('div').each(function () {
        addDeleteLink($(this));
    });

    // La fonction qui ajoute un formulaire PhotoType
    function addPhoto($container) {
        // Dans le contenu de l'attribut « data-prototype », on remplace :
        // - le texte "__name__label__" qu'il contient par le label du champ
        // - le texte "__name__" qu'il contient par le numéro du champ
        var templatebrut = "<div class=\"formphotos\"><div class=\"index-photos\"><div class=\"form-group\"><label class=\"control-label required\">__name__label__</label><div id=\"appbundle_prestataire_photos___name__\"><div class=\"form-group\"> <input type=\"file\" id=\"appbundle_prestataire_photos___name___file\" name=\"appbundle_prestataire[photos][__name__][file]\" required=\"required\" /></div></div></div></div></div>"
        var template = templatebrut
            .replace(/__name__label__/g, 'photo n°' + (index + 1))
            .replace(/__name__/g, index)
        ;

        // On crée un objet jquery qui contient ce template
        var $prototype = $(template);

        // On ajoute au prototype un lien pour pouvoir supprimer la photo
        addDeleteLink($prototype);

        // On ajoute le prototype modifié à la fin de la balise <div>
        $container.append($prototype);

        // Enfin, on incrémente le compteur pour que le prochain ajout se fasse avec un autre numéro
        index++;
    }

    // La fonction qui ajoute un lien de suppression d'une photo
    function addDeleteLink($prototype) {
        // Création du lien
        var $deleteLink = $('<a href="#" class="btn btn-danger btn-xs">Supprimer</a>');
        // Ajout du lien
        $prototype.append($deleteLink);

        // Ajout du listener sur le clic du lien pour effectivement supprimer la photo
        $deleteLink.click(function (e) {
            $prototype.remove();

            e.preventDefault(); // évite qu'un # apparaisse dans l'URL
            return false;
        });
    }

    function addPreviewImage($prototype){
        //creation du liens vers l'image
        var $imglink = $($prototype).find('input').attr('img-path');
        $($prototype).find('label').replaceWith("<img class ='photos-profil' src='"+getBaseUrl()+$imglink+"'>");
        $($prototype).find('input').hide();

    }

    function getBaseUrl(){
        //recupere l'adresse
        var re_url = new RegExp(/^.*\//);
        //recupere app_dev.php
        var re_appdev = new RegExp(/\/(app_dev\.php\/)$/);
        $adresse1= re_url.exec(window.location.href);

        if(re_appdev.exec($adresse1)){
            $adresse1[0] = $adresse1[0].substring(0,$adresse1[0].length-12);
        }
        return $adresse1;
    }
});