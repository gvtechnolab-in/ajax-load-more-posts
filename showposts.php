<?php
/*
Template Name: Show Posts
Template Post Type: post, page, event
*/
// Page code here...

// https://developer.wordpress.org/reference/functions/get_posts/



get_header();

	/* Start the Loop */
	/*while ( have_posts() ) :
		the_post();
		get_template_part( 'template-parts/content/content-page' );

		// If comments are open or there is at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}
	endwhile; // End of the loop.*/
	?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="entry-content alignwide">
			<div id="postslist-container" data-page="1"></div>
			<div class="buttonContainer"><button type="button" class="loadmorepost">Load More</button></div>
		<?php
			echo 'hello from show posts template';
		?>
		</div>
	</article>
	<script type="text/javascript">
		function getPosts(){
			var page = jQuery('#postslist-container').attr('data-page');
			page = page ? page : 1;
			// start loading
			jQuery('#postslist-container').addClass('loading');
			jQuery('.loadmorepost').text('Loading...');
			// ajax call
			jQuery.ajax({
			    type: "post",
			    dataType: "json",
			    url: "<?php echo admin_url('admin-ajax.php'); ?>",
			    data: {action: 'themeprefix_showmoreposts', page: page},
			    success: function(response){
			        console.log(response);
			        // if get post add html to container
			        if(response.status == true){
			        	jQuery('#postslist-container').append(response.html);
				        if(response.haveMorePost == true){
				        	jQuery('#postslist-container').attr('data-page', parseInt(page) + 1);
				        }else{
				        	jQuery('.loadmorepost').hide();
				        }
			        }

			        // stop loading
			        jQuery('#postslist-container').removeClass('loading');
			        jQuery('.loadmorepost').text('Load More');
			    }
			});
		}
		jQuery(document).ready(function(){
			getPosts();
		});
		jQuery(document).on('click','.loadmorepost', function(){
			getPosts();
		})
	</script>
	<?php
get_footer();
