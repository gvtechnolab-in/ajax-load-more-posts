<?php

add_action( 'wp_ajax_themeprefix_showmoreposts', 'themeprefix_showmoreposts_content_callback' );
add_action( 'wp_ajax_nopriv_themeprefix_showmoreposts', 'themeprefix_showmoreposts_content_callback' );
function themeprefix_showmoreposts_content_callback(){
  $returnArray = array('status' => false);
  $posts_per_page = 10;
	global $wpdb;
	if($_POST['page'] != ''){
		$paged = $_POST['page'];
		$haveMorePost = false;
		$htmlstring = '';
		$get_posts_query = new WP_Query( array(
			'post_type'           => 'post',
			'post_status'           => 'publish',
			'posts_per_page'      => $posts_per_page,
			'paged'               => $paged,
			// 'tax_query' => array(
			// 		array (
			// 			'taxonomy' => 'gentry',
			// 			'field' => 'slug',
			// 			'terms' => 'gentries',
			// 		)
			// 	),
		) ); 
		ob_start();
		if($get_posts_query->found_posts >= $posts_per_page){
			$haveMorePost = true;
		}
		while ( $get_posts_query->have_posts() ) : $get_posts_query->the_post();
			echo '<div class="postItem" style="margin-bottom:10px;font-size:13px;">';
			echo '<h4 style="margin-bottom:10px">'.get_the_title().'</h4>';//get_template_part('template-parts/content', 'post', true);
			echo '<div class="postContent">'.get_the_excerpt().'</div>';
			echo '<a href="'.get_the_permalink().'" >View</a>';
			echo '</div>';
		endwhile;
	
		$htmlstring = ob_get_clean();
		$returnArray = array(
			'status' => true, 
			'html' => $htmlstring,
			'haveMorePost' => $haveMorePost
		);
	}else{
		$returnArray = array(
			'status' => false, 
			'message' => 'page paramter not found',
		);
	}
	wp_send_json($returnArray);
	exit;
}
