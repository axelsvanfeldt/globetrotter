/* Script to launch autoloader on input fields in "Planned Trips" and "Places Visited" if the user has selected the Google Places API. */

(() => {
    'use strict';
    
    function addAutoComplete(id) {
        var input = document.getElementById(id);
        if (input) {  
            let autocomplete = new google.maps.places.Autocomplete(input, {
                types: ['geocode']
            });
            google.maps.event.addListener(autocomplete, 'place_changed', () => {
                let place = autocomplete.getPlace();
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
