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
                title: '.title',
                title1: '.title1',
                title2: '.title2',
                excerpt: '.excerpt',
                excerpt1: '.excerpt1',
                excerpt2: '.excerpt2',
                readMore: '.read-more',
                readMore1: '.read-more1',
                readMore2: '.read-more2',
                imageWrapper: '.image-wrapper',
                swiper: '.swiper-container',
            }
        };
    }

    getDefaultElements() {
        const selectors = this.getSettings('selectors');
        return {
            // $firstSelector: this.$element.find(selectors.firstSelector),
            // $secondSelector: this.$element.find(selectors.secondSelector),
            $image1: this.$element.find(selectors.image1),
            $image2: this.$element.find(selectors.image2),
            $image3: this.$element.find(selectors.image3),
            $imageSrc1: this.$element.find(selectors.image1).attr("src"),
            $imageSrc2: this.$element.find(selectors.image2).attr("src"),
            $imageSrc3: this.$element.find(selectors.image3).attr("src"),
            $title: this.$element.find(selectors.title),
            $title1: this.$element.find(selectors.title1),
            $title2: this.$element.find(selectors.title2),
            $excerpt: this.$element.find(selectors.excerpt),
            $excerpt1: this.$element.find(selectors.excerpt1),
            $excerpt2: this.$element.find(selectors.excerpt2),
            $readMore: this.$element.find(selectors.readMore),
            $readMore1: this.$element.find(selectors.readMore1),
            $readMore2: this.$element.find(selectors.readMore2),
            $imageWrapper: this.$element.find(selectors.imageWrapper),
            $swiper: this.$element.find(selectors.swiper),
        };
    }

    bindEvents() {
        this.elements.$image2.on('click', this.onImage2Click.bind(this));
        this.elements.$image3.on('click', this.onImage3Click.bind(this));
        this.swiper.on('slideChangeTransitionStart', this.onSlideChangeTransitionStart.bind(this));
    }

    onImage2Click(event) {
		var target = jQuery(event.target).parents(".swiper-wrapper").find(".swiper-slide-active");
		
		var img1 = target.find(".image1");
		var img2 = target.find(".image2");
		
        var img1Index = img1.attr('name');
        var img2Index = img2.attr('name');
        var img1Src = img1.attr('src');
        var img2Src = img2.attr('src');
        if(img2Src) {
            img1.fadeTo("200", 0.1)
            img2.fadeTo("100", 0.1)

            if(img2Index == 2) {
                this.showPost2();
            }
            else if(img2Index == 3) {
                this.showPost3();
            }
            else {
                this.showPost1();
            }
            
            setTimeout(function () {
                img1.attr('name', img2Index)
                img1.attr('src', img2Src)
        
                img2.attr('name', img1Index)
                img2.attr('src', img1Src)
        
                img1.fadeTo("100", 1)
                img2.fadeTo("200", 1);
            }, 300);
        }
    }

    onImage3Click(event) {
        var target = jQuery(event.target).parents(".swiper-wrapper").find(".swiper-slide-active");
        
        var img1 = target.find(".image1");
        var img3 = target.find(".image3");
        
        var img1Index = img1.attr('name');
        var img3Index = img3.attr('name');
        var img1Src = img1.attr('src');
        var img3Src = img3.attr('src');

        if(img3Src) {
            img1.fadeTo("200", 0.1)
            img3.fadeTo("100", 0.1);

            if(img3Index == 2) {
                this.showPost2();
            }
            else if(img3Index == 3) {
                this.showPost3();
            }
            else {
                this.showPost1();
            }
    
            setTimeout(function () {
                img1.attr('name', img3Index)
                img1.attr('src', img3Src)
        
                img3.attr('name', img1Index)
                img3.attr('src', img1Src)
        
                img1.fadeTo("100", 1)
                img3.fadeTo("200", 1);
            }, 300);
        }
    }

    showPost1() {
        this.elements.$title.fadeIn('7000');
        this.elements.$excerpt.fadeIn('7000');
        this.elements.$readMore.fadeIn('7000');

        this.elements.$title1.hide();
        this.elements.$excerpt1.hide();
        this.elements.$readMore1.hide();

        this.elements.$title2.hide();
        this.elements.$excerpt2.hide();
        this.elements.$readMore2.hide();
    }

    showPost2() {
        this.elements.$title1.fadeIn('3000');
        this.elements.$excerpt1.fadeIn('3000');
        this.elements.$readMore1.fadeIn('3000');

        this.elements.$title.hide();
        this.elements.$excerpt.hide();
        this.elements.$readMore.hide();

        this.elements.$title2.hide();
        this.elements.$excerpt2.hide();
        this.elements.$readMore2.hide();
    }

    showPost3() {
        this.elements.$title2.fadeIn('slow');
        this.elements.$excerpt2.fadeIn('slow');
        this.elements.$readMore2.fadeIn('slow');

        this.elements.$title1.hide();
        this.elements.$excerpt1.hide();
        this.elements.$readMore1.hide();

        this.elements.$title.hide();
        this.elements.$excerpt.hide();
        this.elements.$readMore.hide();
    }

    onSlideChangeTransitionStart() {
        var target = this.elements.$swiper.find(".swiper-slide-active");

        var img1 = target.find(".image1");
        var img1Index = img1.attr('name');
        var img1Src = img1.attr('src');
        if(img1Src) {
            if(img1Index == 1) {
                this.showPost1();
            }
            else if(img1Index == 2) {
                this.showPost2();
            }
            else {
                this.showPost3();
            }
        }
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