<?php
/**
 * Test Theme Customizer
 *
 * @package Test
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function test_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'test_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'test_customize_partial_blogdescription',
		) );
	}
}
add_action( 'customize_register', 'test_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function test_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function test_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function test_customize_preview_js() {
	wp_enqueue_script( 'test-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'test_customize_preview_js' );

/**
 * Admin Enqueue scripts and styles.
 */
function admin_scripts() {
  	wp_enqueue_style('admin-styles', get_template_directory_uri().'/css/admin.css');
  	wp_enqueue_script( 'drag-drop_script', get_template_directory_uri() . '/js/drag-drop.js');
  	wp_enqueue_script( 'jquery-ui', 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js');
}
add_action('admin_enqueue_scripts', 'admin_scripts');

/**
 * Home Page Settings menu.
 */
add_action('admin_menu', 'homme_settings_menu_func');
function homme_settings_menu_func(){
    add_menu_page('Home Page Settings', 'Home Page Settings', 'manage_options', 'home_settings', 'home_page_settings_func' );
    add_menu_page('Home Page Settings', 'Home Page Settings', 'subscriber', 'user_home_settings', 'home_page_settings_func' );
}

function home_page_settings_func() {
	$home_page_settings = get_option('home_page_settings');
	if($home_page_settings == '' || empty($home_page_settings)) {
		$home_page_settings = $home_page_settings = array(
			'sections_settings' => array(
				'chartpage_01',
				'chartpage_02',
				'simpletext_01',
				'productpage_01',
				'chartpage_03',
				'productpage_02',
				'simpletext_02'
			),
			'product_display' => 3,
			'simple_text_1' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
			'simple_text_2' => 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using Content here, content here, making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for lorem ipsum will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like). '
		);
		update_option('home_page_settings', $home_page_settings);
	}
	$user = wp_get_current_user();
	if ( !in_array( 'administrator', (array) $user->roles ) ) {
		$user_settings = get_user_meta(get_current_user_id(), 'home_page_settings', true);
		if($user_settings != '' && !empty($user_settings)) {
			$home_page_settings = $user_settings;
		}
	}
	$sections = array(
			'chartpage_01' => '<div class="draghere" id="chartpage_01">ChartPage 01</div>',
			'chartpage_02' => '<div class="draghere" id="chartpage_02">ChartPage 02</div>',
			'simpletext_01' => '<div class="draghere" id="simpletext_01">SimpleText 01</div>',
			'productpage_01' => '<div class="draghere" id="productpage_01">ProductPage 01</div>',
			'chartpage_03' => '<div class="draghere" id="chartpage_03">ChartPage 03</div>',
			'productpage_02' => '<div class="draghere" id="productpage_02">ProductPage 02</div>',
			'simpletext_02' => '<div class="draghere" id="simpletext_02">SimpleText 02</div>',
		);
	?>
	<div class="wrap">
		<h1>Home page Settings</h1>
		<div class="sections-settings">
			<h3>Sections Oders</h3>
			<?php 
			foreach ($home_page_settings['sections_settings'] as $sections_s) {
				echo '<div class="drophere section-order">';
					echo $sections[$sections_s];
				echo '</div>';
			}
			?>
		</div>
		<div class="product-settings">
		  	<h3>Product Display per row</h3>
		  	<input type="number" name="product_display" id="product_display" value="<?php echo $home_page_settings['product_display']; ?>">
		</div>
		<div class="simple-text-1-settings">
			<h3>Simple Text 1</h3>
			<textarea class="simple-text" name="simple_text_1" id="simple_text_1"><?php echo $home_page_settings['simple_text_1']; ?></textarea>
		</div>
		<div class="simple-text-1-settings">
			<h3>Simple Text 2</h3>
			<textarea class="simple-text" name="simple_text_2" id="simple_text_2"><?php echo $home_page_settings['simple_text_2']; ?></textarea>
		</div>
		<input type="hidden" id="ajaxurl" value="<?php echo admin_url( 'admin-ajax.php' ); ?>">
		<a href="javascript:;" id="save_settings">Save</a>
	</div>
	<?php
}

/**
 * Save Home Page Settings.
 */
add_action("wp_ajax_save_home_page_settings", "save_home_page_settings_func");
function save_home_page_settings_func() {
	$sections_settings = explode(',', $_POST['sections_settings']);
	$product_display = $_POST['product_display'];
	$simple_text_1 = $_POST['simple_text_1'];
	$simple_text_2 = $_POST['simple_text_2'];
	$home_page_settings = array(
		'sections_settings' => $sections_settings,
		'product_display' => $product_display,
		'simple_text_1' => $simple_text_1,
		'simple_text_2' => $simple_text_2
		);
	$user = wp_get_current_user();
	if ( in_array( 'administrator', (array) $user->roles ) ) {
		update_option('home_page_settings', $home_page_settings);
	} else {
		update_user_meta(get_current_user_id(), 'home_page_settings', $home_page_settings);
	}
	exit;
}