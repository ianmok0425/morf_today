<?php
/**
 * Elementor oEmbed Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Mobile_Home_Top_Widget extends \Elementor\Widget_Base {

	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);
  
		wp_register_script( 'mobile-home-top-script', plugins_url( 'widget.js', __FILE__ ), [ 'elementor-frontend' ], '1.0.0', true );
		wp_register_style( 'mobile-home-top-style', plugins_url( 'widget.css', __FILE__ ));
	 }
  
	public function get_script_depends() {
	   return [ 'mobile-home-top-script' ];
	}

	public function get_style_depends() {
		return [ 'mobile-home-top-style' ];
	}

	/**
	 * Get widget name.
	 *
	 * Retrieve oEmbed widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'mobilehometop';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve oEmbed widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Mobile Home Top', 'plugin-name' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve oEmbed widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'fa fa-code';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the oEmbed widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'general' ];
	}

	/**
	 * Register oEmbed widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() {
	}

	/**
	 * Render oEmbed widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();

		// 		// Get image URL
		// 		echo '<img src="' . $item['list_image']['url'] . '">';
		// 		// Get image 'thumbnail' by ID
		// 		echo wp_get_attachment_image( $item['list_image']['id'], 'thumbnail' );
		// 		// Get image HTML
		// 		echo \Elementor\Group_Control_Image_Size::get_attachment_image_html( $item );


		$slides = [];

		// The Query
		$the_query = new WP_Query( array( 'posts_per_page' => 6 ) );
		
		// The Loop
		if ( $the_query->have_posts() ) {
			while ( $the_query->have_posts() ) {
				$the_query->the_post();

				$category = "";
				$categories = get_the_category();
 
				if ( ! empty( $categories ) ) {
					$category = $categories[0]->name;
				}

				$day_html = '<div class="day">' . date("d") . '</div>';
				$month_html = '<div class="month">' . date("M") . '</div>';

				$today_html = '<div class="today">' . $day_html . $month_html .  '</div>';
				$title_html = '<div class="title">' . get_the_title() . '</div>';

				$image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
				if ($image){
					$image_url = $image[0];
					$image_html = '<img class="swiper-slide-image" src="' . $image_url . '">';
				}else{
					$image_html = '<img class="swiper-slide-image" src="">';
				}
				$image_wrapper_html = '<div class="image-div"><div class="image-wrapper"><div>' . $image_html . '</div></div></div>';

				$bottom_image_html = '<div class="bottom-image">' . '</div>';
				$excerpt_html = '<div class="excerpt">' . get_the_excerpt() . '</div>';
				$link = get_post_permalink();
				$readmore_html = '<div><a class="read-more" href="' . $link . '">' . 'Read more...' . '</a></div>';

				$row1 = '<div class="row1">' . $today_html . $title_html . '</div>';

				
				$row3 = '<div class="row3">' . $bottom_image_html . '<div class="excerpt-readmore">' . $excerpt_html . $readmore_html . '</div>' .'</div>';
				$icon_html = '<div class="bottom-image icon">' . '</div>';

				$slide_html = '<div class="slide ' . $category . '">' . $row1 . $image_wrapper_html . $row3 . $icon_html . '</div>';
				$slides[] = '<div class="swiper-slide">' . $slide_html . '</div>';
			}
			// echo '</ul>';
		} else {
			// no posts found
		}
		/* Restore original Post Data */
		wp_reset_postdata();

		?>
		<div class="mobile-home-top-widget-container">
			<!-- Slider main container -->
			<div class="swiper-container">
			<!-- <div class=""> -->
			<!-- Additional required wrapper -->
			<div class="swiper-wrapper">
			<!-- <div class=""> -->
				<?php echo implode( '', $slides ); ?>
				<!-- Slides -->
				<!-- <div class="swiper-slide">Slide 1</div>
				<div class="swiper-slide">Slide 2</div>
				<div class="swiper-slide">Slide 3</div> -->
				<!-- ... -->
			</div>
			<!-- If we need pagination -->
			<div class="swiper-pagination"></div>
			
			<!-- If we need navigation buttons -->
			<!-- <div class="swiper-button-prev"></div> -->
			<!-- <div class="swiper-button-next"></div> -->
			
			<!-- If we need scrollbar -->
			<!-- <div class="swiper-scrollbar"></div> -->
			</div>
		</div>
		<?php
	}

}
