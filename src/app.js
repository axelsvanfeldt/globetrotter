/* Script to handle main funcionality and load some resources. */

import '../sass/style.scss';
import 'normalize.css';
import * as $ from 'jquery';
import 'bootstrap';

(() => {
    'use strict';
    
    const app = {
        initialize: () => {
            app.attachGalleryLinks();
            $(window).on("scroll", app.toggleNavigation);            
        },
        lastScrollTop: 0,
        toggleNavigation: () => {
            const currentScroll = $(window).scrollTop();
            let menu = $("#top-menu");
            (currentScroll > 60) ? (currentScroll < app.lastScrollTop) ? menu.removeClass("top-menu-hidden") : menu.addClass("top-menu-hidden") : menu.removeClass("top-menu-hidden");
            app.lastScrollTop = currentScroll;
        },
        attachGalleryLinks: () => {
            let galleryItems = $(".blocks-gallery-item");
            if (galleryItems.length) {
                galleryItems.each((index, el) => {
                    let li = $(el);
                    let img = li.find("img");
                    if (img.length) {
                        let url = img.attr("data-link");
                        li.html(`<figure><a href="${url}">${img.prop('outerHTML')}</a></figure>`);
                    }
                });
            }
        }
    }
    
    $(document).ready(app.initialize);
    
})();