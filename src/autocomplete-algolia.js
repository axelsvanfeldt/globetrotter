/* Script to launch autoloader on input fields in "Planned Trips" and "Places Visited" if the user has selected the Algolia Places API. */

let places = require('places.js');

(() => {
    'use strict';
    
    const autocomplete = {
        initialize: () => {
            if (typeof algolia_data !== 'undefined') {
                if (algolia_data.app_id && algolia_data.api_key) {
                    autocomplete.addListener('settings-map-center');
                    autocomplete.addListener('trip-origin');
                    autocomplete.addListener('trip-destination');
                    autocomplete.addListener('place-location');
                }
            }            
        },
        addListener: (id) => {
            let input = document.getElementById(id);
            if (input) {  
                let placesAutocomplete = places({
                    appId: algolia_data.app_id,
                    apiKey: algolia_data.api_key,
                    container: input
                });
                placesAutocomplete.on('change', (e) => {
                    input.value = e.suggestion.value;
                    document.getElementById(id + "-lat").value = e.suggestion.latlng.lat;
                    document.getElementById(id + "-lng").value = e.suggestion.latlng.lng;
                });
                placesAutocomplete.on('clear', () => {
                    input.value = '';
                });                   
            }            
        }
    };
    
    autocomplete.initialize();
    
})();