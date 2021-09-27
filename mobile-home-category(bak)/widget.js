class MobileHomeTopClass extends elementorModules.frontend.handlers.Base {
    getDefaultSettings() {
        // console.log("getDefaultSettings");
        return {
            selectors: {
                // firstSelector: '.firstSelectorClass',
                // secondSelector: '.secondSelectorClass',
                // articleContainer: '.article-container',
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
            // $articleContainer: this.$element.find(selectors.articleContainer),
            $swiper: this.$element.find(selectors.swiper),
        };
    }

    bindEvents() {
        // console.log("bindEvents");
        // this.elements.$firstSelector.on('click', this.onFirstSelectorClick.bind(this));
        // this.elements.$articleContainer.on('scroll', this.onArticleScroll.bind(this));
    }

    onInit() {
        this.initElements();
        this.bindEvents();

        // console.log("onInit mobile-home-top");
        const swiper = new Swiper(this.elements.$swiper, {
            // Optional parameters
            direction: 'horizontal',
            loop: true,

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
        });
        this.swiper = swiper;
    }

}

jQuery(window).on('elementor/frontend/init', () => {
    // console.log("elementor/frontend/init mobile-home-top");

    const addHandler = ($element) => {
        elementorFrontend.elementsHandler.addHandler(MobileHomeTopClass, {
            $element,
        });
    };

    elementorFrontend.hooks.addAction('frontend/element_ready/mobilehometop.default', addHandler);
});
