/**
 * Created by Stefan on 12.6.2015.
 */
var News= function (tittle,link,city,lat,lng) {
    this.tittle=tittle;
    this.link=link;
    this.city=city;
    this.lat=lat;
    this.lng=lng
};
var m = [];  var n = [];
function uzmivesti(filt) {
    if (filt==undefined) {
        filt=""
    }
    $.post("ajax.takenews.php",
        {
            filter: filt
        },
        function (d, status) {
            if (status == "success") {

                var data = JSON.parse(d);
                for (var i = 0; i < data.length; i++) {
                    n[i] = new News(data[i]["tittle"], data[i]["link"], 'nema', data[i]["lat"], data[i]["lng"]);
                    m.forEach(function(entry) {
                        if(entry.position.lat()==n[i].lat && entry.position.lng()==n[i].lng) {
                            n[i].lat+=0.2;
                            n[i].lng+=0.2;
                            break;

                        }
                            });
                    var myLatlng = new google.maps.LatLng(n[i].lat, n[i].lng);
                    m[i] = new MarkerWithLabel({
                        position: myLatlng,
                        map: map,
                        labelContent: n[i].tittle,
                        labelAnchor: new google.maps.Point(22, 0),
                        labelClass: "labels", // the CSS class for the label
                        labelStyle: {opacity: 0.75},
                        icon: 'images/marker.png',
                        title: data[i]["tittle"]
                    });
                    m[i].fancyL=data[i]["link"];
                    m[i].idVesti=i;


                    oms.addMarker(m[i]);
                }
                oms.addListener('click', function (marker) {
                    var link=marker.fancyL;
                    var i=marker.idVesti;
                    var a = document.createElement("a");
                    a.setAttribute("class", "fancy");
                    a.setAttribute("href", link);
                    a.setAttribute("id", i);
                    a.setAttribute("style", "display:none");
                    var t = document.createTextNode("Link" + i);
                    a.appendChild(t);
                    var b = document.getElementsByTagName("body");
                    b[0].appendChild(a);
                    $('a#' + i).trigger('click');
                });
                podesi_labele();
            } else {
                alert("Doslo je do greske!")
            }
        });
}
$(".filter").change(function() {
    for(var k=0;k< m.length;k++) {
        m[k].setMap(null)
    }
    oms.clearMarkers();
    m=[];
    n=[];
    var vreme,kat;
    vreme=$('select[name=vreme]').val();
    kat=$('select[name=kategorija]').val();
var f={
    "vreme": vreme,
    "kategorije": kat
};

uzmivesti(JSON.stringify(f))
});
$('.fancy').fancybox({
    padding: 0,
    openEffect: 'elastic',
    type: "iframe"
});
function podesi_labele() {
    var nizm = oms.markersNearAnyOtherMarker();
    m.forEach(function (entry) {
        entry.labelVisible = true;
    });
    nizm.forEach(function (entry) {
        entry.labelVisible = false;
    });
}

map.addListener('zoom_changed',function() {
    var nizm=oms.markersNearAnyOtherMarker();
    m.forEach(function(entry){
        entry.labelVisible=true;
    });
    nizm.forEach(function(entry) {
        entry.labelVisible=false;
    });
});
uzmivesti();
podesi_labele();