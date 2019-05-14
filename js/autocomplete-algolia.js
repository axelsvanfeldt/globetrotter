/* 
Script to launch autoloader on input fields in "Planned Trips" and "Places Visited" if the user has selected the Algolia Places API.

Shorter JS files like this one is written in classic JS and does not require compiling.
*/

(function() {
    function initAutoComplete() {
        if (typeof algolia_data !== 'undefined') {
            if (algolia_data.app_id && algolia_data.api_key) {
                addAutoComplete('settings-map-center');
                addAutoComplete('trip-origin');
                addAutoComplete('trip-destination');
                addAutoComplete('place-location');
            }
        }
    }
    function addAutoComplete(id) {
        var input = document.getElementById(id);
        if (input) {  
            var placesAutocomplete = places({
                appId: algolia_data.app_id,
                apiKey: algolia_data.api_key,
                container: input
            });
            placesAutocomplete.on('change', function(e) {
                input.value = e.suggestion.value;
                document.getElementById(id + "-lat").value = e.suggestion.latlng.lat;
                document.getElementById(id + "-lng").value = e.suggestion.latlng.lng;
            });
            placesAutocomplete.on('clear', function() {
                input.value = '';
            });                   
        }
    }
    initAutoComplete();
})();