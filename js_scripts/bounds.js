/**
 * Created by Stefan on 11.6.2015.
 */
// bounds of the desired area
var allowedBounds = new google.maps.LatLngBounds(
    new google.maps.LatLng(42.172944,19.2537083),
    new google.maps.LatLng(46.0944757,22.8964521)
);
var lastValidCenter = map.getCenter();

google.maps.event.addListener(map, 'center_changed', function() {
    if (allowedBounds.contains(map.getCenter())) {
        // still within valid bounds, so save the last valid position
        lastValidCenter = map.getCenter();
        return;
    }

    // not valid anymore => return to last valid position
    map.panTo(lastValidCenter);
});