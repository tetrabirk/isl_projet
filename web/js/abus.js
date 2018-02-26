$(document).ready(function () {
    //lorsqu'on clic sur le ptit drapeau
    $(".signaler-abus").click(function(e){
        //le ptit drapeau
        var target = e.target;
        //la div qui contient le commentaire
        var $container = $(target).parent().parent().parent().parent();
        //la div qui contient le form
        var prototype = $("#abus-prototype");
        //on récupère l'id dans 'value'
        var id_commentaire = ($($container).attr('id')).split('_').pop();

        //on affiche le form et le prépend au container
        $(prototype).removeAttr('hidden').detach().prependTo($container);
        //on ajoute l'id au hiddentype
        $(prototype).find("#appbundle_abus_commentaire_id").attr('value',id_commentaire);


    })

});