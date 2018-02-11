$(document).ready(function () {


    /**
     * gestion des categorie dans les formulaires
     */


    // On récupère la balise <div> en question qui contient l'attribut « data-prototype » qui nous intéresse.
    var $container = $('div#appbundle_prestataire_categories_container');

    // On définit un compteur unique pour nommer les champs qu'on va ajouter dynamiquement
    var index = ($container.find('.index-categ').length);



    // On ajoute un nouveau champ à chaque clic sur le lien d'ajout.
    $('#add_category').click(function (e) {
        addCategory($container);
        e.preventDefault(); // évite qu'un # apparaisse dans l'URL
        return false;
    });

    // // On ajoute un premier champ automatiquement s'il n'en existe pas déjà un (cas d'une nouvelle annonce par exemple).
    // //vu que j'ai ajouter un -1 à la ligne 8 j'ai du remplacer le index == 0 (et contrebalancer avec un index++)
    // if (index === 0) {
    //     addCategory($container);
    //     removeLabelFormRest();
    //
    //
    // } else {
    //     // S'il existe déjà des catégories, on ajoute un lien de suppression pour chacune d'entre elles
    //     $container.children('div').each(function () {
    //         addDeleteLink($(this));
    //     });
    // }

    // La fonction qui ajoute un formulaire CategoryType
    function addCategory($container) {
        console.log(index);

        // Dans le contenu de l'attribut « data-prototype », on remplace :
        // - le texte "__name__label__" qu'il contient par le label du champ
        // - le texte "__name__" qu'il contient par le numéro du champ
        var template = $container.attr('data-prototype')
            .replace(/__name__label__/g,(index+1))
            .replace(/__name__/g,index)
        ;

        // On crée un objet jquery qui contient ce template
        var $prototype = $(template);

        // On ajoute au prototype un lien pour pouvoir supprimer la catégorie
        addDeleteLink($prototype);

        // On ajoute le prototype modifié à la fin de la balise <div>
        $container.append($prototype);

        // Enfin, on incrémente le compteur pour que le prochain ajout se fasse avec un autre numéro
        index++;
    }

    // La fonction qui ajoute un lien de suppression d'une catégorie
    function addDeleteLink($prototype) {
        // Création du lien
        var $deleteLink = $('<a href="#" class="btn btn-danger btn-xs mb50 mt-50">Supprimer</a>');

        // Ajout du lien
        $prototype.append($deleteLink);

        // Ajout du listener sur le clic du lien pour effectivement supprimer la catégorie
        $deleteLink.click(function (e) {
            $prototype.remove();

            e.preventDefault(); // évite qu'un # apparaisse dans l'URL
            return false;
        });
    }

    $('select[data-select="true"]').select2();




});


