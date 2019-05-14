/*
This script contains all major JS functionality for the site.

This file is written in modern JS and needs to be compiled to classic JS.
*/
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