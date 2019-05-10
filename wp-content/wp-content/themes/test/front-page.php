<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Test
 */

get_header();
?>
	<style>
	canvas{
		-moz-user-select: none;
		-webkit-user-select: none;
		-ms-user-select: none;
	}
	</style>
	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php
			$home_page_settings = get_option('home_page_settings');
			$user = wp_get_current_user();
			if ( !in_array( 'administrator', (array) $user->roles ) ) {
				$user_settings = get_user_meta(get_current_user_id(), 'home_page_settings', true);
				if($user_settings != '' && !empty($user_settings)) {
					$home_page_settings = $user_settings;
				}
			}

			$chartpage_01 = '<div style="width:100%;"><canvas id="chartpage_01_chart"></canvas></div>';
			$chartpage_02 = '<div style="width:100%;"><canvas id="chartpage_02_chart"></canvas></div>';
			$chartpage_03 = '<div style="width:100%;"><canvas id="chartpage_03_chart"></canvas></div>';
			$simpletext_01 = $home_page_settings['simple_text_1'];
			$simpletext_02 = $home_page_settings['simple_text_2'];
			$productpage_01 = '<div class="products">'. do_shortcode('[products per_page="'. $home_page_settings['product_display'] .'"]') .'</div>';
			$productpage_02 = '<div class="products">'. do_shortcode('[products_offset per_page="'. $home_page_settings['product_display'] .'" offset="'. $home_page_settings['product_display'] .'"]') .'</div>';
			$sections = array(
				'chartpage_01' => '<div class="page-section" id="chartpage_01">' . $chartpage_01 . '</div>',
				'chartpage_02' => '<div class="page-section" id="chartpage_02">' . $chartpage_02 . '</div>',
				'simpletext_01' => '<div class="page-section" id="simpletext_01">' . $simpletext_01 . '</div>',
				'productpage_01' => '<div class="page-section" id="productpage_01">' . $productpage_01 . '</div>',
				'chartpage_03' => '<div class="page-section" id="chartpage_03">' . $chartpage_03 . '</div>',
				'productpage_02' => '<div class="page-section" id="productpage_02">' . $productpage_02 . '</div>',
				'simpletext_02' => '<div class="page-section" id="simpletext_02">' . $simpletext_02 . '</div>',
			);

			foreach ($home_page_settings['sections_settings'] as $sections_s) {
				echo $sections[$sections_s];
			}
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
