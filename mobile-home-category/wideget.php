<?php
/**
 * Elementor oEmbed Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Mobile_Home_Category_Widget extends \Elementor\Widget_Base {

	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);
  
		wp_register_script( 'mobile-home-category-script', plugins_url( 'widget.js', __FILE__ ), [ 'elementor-frontend' ], '1.0.0', true );
		wp_register_style( 'mobile-home-category-style', plugins_url( 'widget.css', __FILE__ ));
	 }
  
	public function get_script_depends() {
	   return [ 'mobile-home-category-script' ];
	}

	public function get_style_depends() {
		return [ 'mobile-home-category-style' ];
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
		return 'mobile-home-category';
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
		return __( 'Mobile Home Category', 'plugin-name' );
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
		$this->start_controls_section(
			'style_section',
			[
				'label' => __( 'Style', 'plugin-name' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'category',
			[
				'label' => __( 'Category', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Default', 'plugin-domain' ),
				'placeholder' => __( 'Type your category here', 'plugin-domain' ),
			]
		);

		$this->end_controls_section();
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
		$category = $settings['category'];

		$slides = [];

		// The Query
		$the_query = new WP_Query( array( 'posts_per_page' => 12, 'category_name' => $category ) );

		// Built PostIDs
		$built_post_ids = [];
		
		// The Loop
		if ( $the_query->have_posts() ) {
			$post_ids = [];
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				$post_ids[] = $the_query->post->ID;
			}
			for ($i = 0; $i < count($post_ids); $i+=3) {
				$post_id = $post_ids[$i];
				$second_post_id = $post_ids[($i+1)%count($post_ids)];
				$third_post_id = $post_ids[($i+2)%count($post_ids)];

				// $category = "";
				// $categories = get_the_category($post_id);
 
				// if ( ! empty( $categories ) ) {
				// 	$category = $categories[0]->name;
				// }

				$image = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'full' );
				if ($image){
					$image_url = $image[0];
					$image1_html = '<img name="1" postid="' . $post_id .'" class="image1" src="' . $image_url . '" />';
				}else{
					$image1_html = '<img name="1" class="image1" postid="" />';
				}
				$image = wp_get_attachment_image_src( get_post_thumbnail_id($second_post_id), 'full' );
				if ($image && !in_array($second_post_id, $built_post_ids)){
					$image_url = $image[0];
					$image2_html = '<img name="2" postid="' . $second_post_id .'" class="image2" src="' . $image_url . '" />';
				}else{
					$image2_html = '<img name="2" class="image2" postid=""  />';
				}
				$image = wp_get_attachment_image_src( get_post_thumbnail_id($third_post_id), 'full' );
				if ($image && !in_array($third_post_id, $built_post_ids)){
					$image_url = $image[0];
					$image3_html = '<img name="3" postid="' . $third_post_id .'" class="image3" src="' . $image_url . '" />';
				}else{
					$image3_html = '<img name="3" class="image3" postid=""  />';
				}
				$image_html = 
					'<div class="image-wrapper"><div class="image-box"><div class="image-flexbox">' 
					. $image1_html . 
					'<div class="inner-image">' 
					. $image2_html . $image3_html . 
					'</div></div></div></div>';
				
				$title_html = '<div class="title"></div>';
				$title1_html = '<div class="title1" style="display:none"></div>';
				$title2_html = '<div class="title2" style="display:none"></div>';
				$title = get_the_title($post_id);
				if($title) {
					$title_html = '<div class="title" postid="' . $post_id . '">' . $title . '</div>';
				}
				$title = get_the_title($second_post_id);
				if($title && !in_array($second_post_id, $built_post_ids)) {
					$title1_html = '<div class="title1" style="display:none" postid="' . $second_post_id . '">' . $title . '</div>';
				}
				$title = get_the_title($third_post_id);
				if($title && !in_array($third_post_id, $built_post_ids)) {
					$title2_html = '<div class="title2" style="display:none" postid="' . $third_post_id . '">' . $title . '</div>';
				}

				$excerpt_html = '<div class="excerpt"></div>';
				$excerpt1_html = '<div class="excerpt1" style="display:none"></div>';
				$excerpt2_html = '<div class="excerpt2" style="display:none"></div>';
				$excerpt = get_the_excerpt($post_id);
				if($excerpt) {
					$excerpt_html = '<div class="excerpt" postid="' . $post_id . '">' . $excerpt . '</div>';
				}
				$excerpt = get_the_excerpt($second_post_id);
				if($excerpt && !in_array($second_post_id, $built_post_ids)) {
					$excerpt1_html = '<div class="excerpt1" style="display:none" postid="' . $second_post_id . '">' . $excerpt . '</div>';
				}
				$excerpt = get_the_excerpt($third_post_id);
				if($excerpt && !in_array($third_post_id, $built_post_ids)) {
					$excerpt2_html = '<div class="excerpt2" style="display:none" postid="' . $third_post_id . '">' . $excerpt . '</div>';
				}

				$readmore_html = '<div><a class="read-more" href=""></a></div>';
				$readmore1_html = '<div><a class="read-more1" href="" style="display:none"></a></div>';
				$readmore2_html = '<div><a class="read-more2" href="" style="display:none"></a></div>';
				$link = get_post_permalink($post_id);
				if($link) {
					$readmore_html = '<div><a class="read-more" href="' . $link . '" postid="' . $post_id . '">' . 'Read more...' . '</a></div>';
				}
				$link = get_post_permalink($second_post_id);
				if($link && !in_array($second_post_id, $built_post_ids)) {
					$readmore1_html = '<div><a class="read-more1" href="' . $link . '" style="display:none" postid="' . $second_post_id . '">' . 'Read more...' . '</a></div>';
				}
				$link = get_post_permalink($third_post_id);
				if($link && !in_array($third_post_id, $built_post_ids)) {
					$readmore2_html = '<div><a class="read-more2" href="' . $link . '" style="display:none" postid="' . $third_post_id . '">' . 'Read more...' . '</a></div>';
				}

				$row3 = '<div class="excerpt-readmore">' . $title_html . $title1_html . $title2_html . $excerpt_html . $excerpt1_html . $excerpt2_html . $readmore_html . $readmore1_html . $readmore2_html . '</div>';

				$slide_html = '<div class="slide ' . $category . '">' . $image_html . $row3 . '</div>';
				$slides[] = '<div class="swiper-slide">' . $slide_html . '</div>';

				array_push($built_post_ids, $post_id, $second_post_id, $third_post_id);
			}
		} else {
			// no posts found
		}
		/* Restore original Post Data */
		wp_reset_postdata();

		?>
		<div class="mobile-home-category-widget-container">
			<div class="<?php echo $category; ?>">
			<!-- Slider main container -->
			<div class="swiper-container">
			<!-- Additional required wrapper -->
				<div class="icon-wrapper">
					<div class="icon"></div>
				</div>
				<div class="swiper-pagination"></div>
				<div class="swiper-wrapper">
					<?php echo implode( '', $slides ); ?>
					<!-- Slides -->
				</div>
			
			</div>
			</div>
		</div>
		<?php
	}

}