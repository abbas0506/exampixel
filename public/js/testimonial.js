(function () {
    /**
     * Testimonials slider
     */

    new Swiper(".testimonials-carousel", {
        speed: 400,
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        pagination: {
            el: ".swiper-pagination",
            type: "bullets",
            clickable: true,
        },
    });
})();
