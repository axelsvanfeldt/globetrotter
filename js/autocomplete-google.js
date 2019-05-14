/*
Script to launch autoloader on input fields in "Planned Trips" and "Places Visited" if the user has selected the Google Places API.

Shorter JS files like this one is written in classic JS and does not require compiling.
*/

(function() {
    function addAutoComplete(id) {
        var input = document.getElementById(id);
        if (input) {  
            var autocomplete = new google.maps.places.Autocomplete(input, {
                types: ['geocode']
            });
            google.maps.event.addListener(autocomplete, 'place_changed', function () {
                var place = autocomplete.getPlace();
                document.getElementById(id + "-lat").value = place.geometry.location.lat();
                document.getElementById(id + "-lng").value = place.geometry.location.lng();
            });                   
        }
    }
    addAutoComplete('settings-map-center');
    addAutoComplete('trip-origin');
    addAutoComplete('trip-destination');
    addAutoComplete('place-location');
})();
