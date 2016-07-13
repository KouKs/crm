<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 *
 * @package WordPress
 * @subpackage BasicCRM
 */

?><!DOCTYPE html>
<html lang="en">
<head>
	<title>Basic CRM</title>

	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">

	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>

<div id="page" class="site">

	<header id="master" class="site-header" role="banner">

	</header>

	<div id="content" class="site-content">

		<main id="main" class="site-main" role="main">

			<?php if(have_posts()): ?>

				<?php

				while ( have_posts() ) : the_post();

					the_title( printf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );

				endwhile;

				// Pagination
				the_posts_pagination( array(
					'prev_text'          => __( 'Previous page', 'twentysixteen' ),
					'next_text'          => __( 'Next page', 'twentysixteen' ),
					'before_page_number' => '<span class="meta-nav screen-reader-text">Page</span>',
				) );

			// If no content, include the "No posts found" template.
			/*
			else :
				get_template_part( 'template-parts/content', 'none' );

			*/
			endif;
			?>
		</main>
	</div>
</div>

<?php wp_footer(); ?>

</body>
</html>