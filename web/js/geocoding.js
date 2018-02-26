



var urlType = "https://maps.googleapis.com/maps/api/geocode/json?address=__adresse__&key=__API__";
var API = 'AIzaSyBSSiBIjO2oLHUPb7LL0FChkEYE1FC8ytE';
var localite = '4970 Stavelot';
var rue = "sol'camp";
var numero = '14';

var adresse= localite+' '+rue+' '+numero;
var adresseEncode = encodeURIComponent(adresse.replace(' ','+'));

var url = urlType.replace('__adresse__',adresseEncode).replace('__API__',API);


$(document).ready(function () {
    $.get(url,function(data){
        var geometry = data.results[0].geometry;
        var coordonnee = geometry.location;
        var lat = geometry.location.lat;
        var lng = geometry.location.lng;
        $("#listing-detail-map").attr('data-latitude',lat).attr('data-longitude',lng);
        $("#listing-detail-street-view").attr('data-latitude',lat).attr('data-longitude',lng);


        console.log(lat+' '+lng);
    })
});