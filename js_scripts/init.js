/**
 * Created by Stefan on 12.6.2015.
 */
var styles=[
   {
        "featureType":"administrative.country","elementType":"geometry","stylers":
            [
                {"weight": 4}
            ]
    },{
        "featureType":"road","elementType":"geometry","stylers":
            [
                {"weight":"0.3"}
            ]
    },{
        "featureType":"road","elementType":"labels.icon","stylers":
            [
                {"visibility":"off"}
            ]
    }
];
var styledMap = new google.maps.StyledMapType(styles,
    {name: "Styled Map"});
//make map
var mapOptions = {
    zoom: 8,
    minZoom: 6,
    disableDefaultUI: true,
    zoomControl: true,
    zoomControlOptions: {
        style:google.maps.ZoomControlStyle.DEFAULT
    }
};
var map = new google.maps.Map(document.getElementById('map-canvas'),
    mapOptions);
map.mapTypes.set('map_style', styledMap);
map.setMapTypeId('map_style');
//Geocoding: set center to Serbia
function centriraj () {
    var pos = new google.maps.LatLng("44.0777552", "21.2731361");
    map.setCenter(pos);
}
centriraj();

var oms = new OverlappingMarkerSpiderfier(map,
    {markersWontMove: true, markersWontHide: true, circleFootSeparation: 100,spiralLengthStart: 100, spiralFootSeparation: 60, spiralLengthFactor: 50, nearbyDistance: 20});
setTimeout(function() {
    var doc=document.getElementsByClassName("fb-like");
    doc[0].setAttribute("data-width","50px");
},2000);