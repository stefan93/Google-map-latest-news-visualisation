$(document).ready(function() {
    mc=$("#map-canvas");
    var lat=mc.attr("lat");
    var lng=mc.attr("lng");
    var myLatlng = new google.maps.LatLng(lat, lng);
    var mapOptions = {
        zoom: 6
    };
    var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

     marker = new google.maps.Marker({
        position: myLatlng,
        map: map,
        draggable:true
    });
    //Geocoding: set center to Serbia
    var country = "Beograd";
    var geocoder = new google.maps.Geocoder();
    geocoder.geocode( {'address' : country}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            map.setCenter(results[0].geometry.location);
        }
    });
    //SEARCH
    $(document).on("click","[triger=potrazi-grad]",function() {
        var grad=$("input[name=search-box]").val();
        var geocoder = new google.maps.Geocoder();
        var ne = new google.maps.LatLng(46.1703157,21.2061569);
        var sw = new google.maps.LatLng(43.6421591,19.5289647);
        geocoder.geocode( {'address' : grad,'bounds':  new google.maps.LatLngBounds(sw, ne)}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                map.setCenter(results[0].geometry.location);
                marker.setPosition(results[0].geometry.location);
                $("input[name=naziv]").val(results[0].formatted_address);
            }
        });
    });


    //END SEARCH
    $(document).on("click","[triger=sacuvaj_grad]",function() {
        var p=marker.getPosition();
        var id=mc.attr('id_v');
        var naziv=$("input[name=naziv]").val();
        naziv=encodeURI(naziv);
        if (naziv=="")
            naziv="a";
        $('#kontrola').load("ajax.sacuvaj_grad.php?q="+id+"&lat="+ p.lat()+"&lng="+ p.lng() +"&naziv="+naziv);
    });
});
