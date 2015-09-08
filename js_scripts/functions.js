/**
 * Created by Stefan on 11.6.2015.
 */

function givemecords(address,fn) {
    geocoder = new google.maps.Geocoder();
    var a;
    geocoder.geocode(
        {
            'address': address,
            componentRestrictions: {
                country: 'RS',
                locality: 'locality'
            }
        },
        function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                fn(results[0].geometry.location);
            } else {
                alert("Nije nasao");
            }
        });
}