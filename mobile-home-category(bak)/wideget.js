class MobileHomeCategoryClass extends elementorModules.frontend.handlers.Base {
    getDefaultSettings() {
        // console.log("getDefaultSettings");
        return {
            selectors: {
                // firstSelector: '.firstSelectorClass',
                // secondSelector: '.secondSelectorClass',
                image1: '.image1',
                image2: '.image2',
                image3: '.image3',
                swiper: '.swiper-container',
            },
        };
    }

    getDefaultElements() {
        // console.log("getDefaultElements");
        const selectors = this.getSettings('selectors');
        return {
            // $firstSelector: this.$element.find(selectors.firstSelector),
            // $secondSelector: this.$element.find(selectors.secondSelector),
            $image1: this.$element.find(selectors.image1),
            $image2: this.$element.find(selectors.image2),
            $image3: this.$element.find(selectors.image3),
            $swiper: this.$element.find(selectors.swiper),
        };
    }

    bindEvents() {
        console.log("bindEvents", this.elements.$image2, this.elements.$image3);
        this.elements.$image2.on('click', this.onImage2Click.bind(this));
        this.elements.$image3.on('click', this.onImage3Click.bind(this));
    }

    onImage2Click(event) {
        // console.log('onClick index:', this.swiper.activeIndex);
        this.swiper
        this.swiper.slideTo((this.swiper.activeIndex + 1) % this.swiper.slides.length, 1000, false);
        // console.log('after index:', this.swiper.activeIndex);
    }
    onImage3Click(event) {
        // console.log('onClick index:', this.swiper.activeIndex);
        this.swiper.slideTo((this.swiper.activeIndex + 2) % this.swiper.slides.length, 1000, false);
        // console.log('after index:', this.swiper.activeIndex);
    }

    onInit() {
        this.initElements();
        // this.bindEvents();

        // console.log("onInit mobile-home-category");
        const swiper = new Swiper(this.elements.$swiper, {
            // Optional parameters
            direction: 'horizontal',
            // loop: true,

            // If we need pagination
            pagination: {
                el: '.swiper-pagination',
                type: 'bullets',
            },

            // Navigation arrows
            // navigation: {
            //     nextEl: '.swiper-button-next',
            //     prevEl: '.swiper-button-prev',
            // },

            // And if we need scrollbar
            // scrollbar: {
            //     el: '.swiper-scrollbar',
            // },

            // preventClicks: false,
            // preventClicksPropagation: false,
        });
        this.swiper = swiper;
        this.bindEvents();
    }

}

jQuery(window).on('elementor/frontend/init', () => {
    // console.log("elementor/frontend/init mobile-home-category");

    const addHandler = ($element) => {
        elementorFrontend.elementsHandler.addHandler(MobileHomeCategoryClass, {
            $element,
        });
    };

    elementorFrontend.hooks.addAction('frontend/element_ready/mobile-home-category.default', addHandler);
});
