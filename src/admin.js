/* Script to handle custom funcionality in the admin inferface. */

import '../sass/style-admin.scss';

(() => {
    'use strict';
    
    let $ = jQuery;
    
    const admin = {
        initialize: () => {
            admin.toggleAPI();
            $("select[name='settings-api']").on("change", admin.toggleAPI);
            $('.settings-input-color').wpColorPicker();  
            $("form").on('submit', admin.validateForm);           
        },
        toggleAPI: () => {
            let value = $("select[name='settings-api']").val();
            let enabledInputs = $(".settings-api-input-" + value);
            $(".settings-api-input").prop('disabled', true);
            $(".settings-api-input").prop('required', false);
            enabledInputs.prop('disabled', false);
            enabledInputs.prop('required', true);           
        },
        validateForm: (e) => {
            let selectors = [".settings-input-color", ".settings-input-number", ".settings-input-select", ".settings-input-text"];
            let form = $(e.target);
            selectors.forEach((value) => {
                admin.validateInputs(form, value);
            });
        },
        validateInputs: (form, selector) => {
            form.find(selector).each((index, el) => {
                let input = $(el);
                let td = input.closest("td");
                let alert = td.find(".settings-alert");
                let value = input.val();
                if (value) {
                    if (typeof value === "string") {
                        if (selector == ".settings-input-color") {
                            if  (admin.validateHexColor(value)) {
                                alert.removeClass("settings-alert-displayed");
                                return true;
                            }
                        }
                        else if (selector == ".settings-input-number") {
                            if (!isNaN(parseInt(value))) {
                                alert.removeClass("settings-alert-displayed");
                                return true;
                            }                            
                        }
                        else {
                            alert.removeClass("settings-alert-displayed");
                            return true;
                        }
                    }
                }
                event.preventDefault();
                alert.addClass("settings-alert-displayed");
                input.focus();
            });             
        },
        validateHexColor: (color) => {
            color = (color.charAt(0) === "#") ? color : "#" + color;
            return /(^#[0-9A-F]{6}$)|(^#[0-9A-F]{3}$)/i.test(color);                    
        },
    };

    $(document).ready(admin.initialize);

})(jQuery);