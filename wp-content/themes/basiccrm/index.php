<?php
/**
 * The main template file
 */
$orderby = @$_GET['orderby'] ? $_GET['orderby'] : '';
$order = @$_GET['order'] ? $_GET['order'] : '';

$loop = new WP_Query([
	'post_type' => 'client',
	'orderby' => $orderby,
	'order' => $order,
]);

$reverse = [ 'asc' => 'desc', 'desc' => 'asc' ];

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<?php if ($loop->have_posts()) : ?>

				<table id="clients" class="table-simple">
					<thead>
						<tr>
							<td class="sortable <?= $orderby == '_crm_last_name' ? $order : 'none' ?>">
								<a href="<?= esc_url(add_query_arg([ 'orderby' => '_crm_last_name', 'order' => $orderby == '_crm_last_name' ? $reverse[$order] : 'asc', ], $_SERVER['REQUEST_URI'])); ?>">
									<span>Name</span>									
								</a>
							</td>
							<td class="sortable <?= $orderby == '_crm_company' ? $order : 'none' ?>">
								<a href="<?= esc_url(add_query_arg([ 'orderby' => '_crm_company', 'order' => $orderby == '_crm_company' ? $reverse[$order] : 'asc', ], $_SERVER['REQUEST_URI'])); ?>">
									<span>Position</span>									
								</a>
							</td>
							<td>Contact</td>
							<td>Date</td>
						</tr>
					</thead>

					<tbody>
						<?php while ($loop->have_posts()) : $loop->the_post();

							$companies = get_the_terms($post, 'company');
							$positions = get_the_terms($post, 'position');
						?>
							<tr>
								<td>
									<?php printf('<strong>%s %s</strong>',
										esc_html(get_post_meta($post->ID, '_crm_first_name', true)),
										esc_html(get_post_meta($post->ID, '_crm_last_name', true))); ?>
								</td>
								<td>
									<?php printf('%s at <strong>%s</strong>',
										esc_html(@$positions[0]->name),
										esc_html(@$companies[0]->name)); ?>
								</td>
								<td>
									<?php printf('<strong>Phone:</strong> %s <br /> <strong>Email:</strong> %s',
										esc_html(get_post_meta($post->ID, '_crm_telephone', true)),
										esc_html(get_post_meta($post->ID, '_crm_email', true))); ?>
								</td>
								<td><?php printf('<strong>Created:</strong> %s <br /> <strong>Updated:</strong> %s',
										get_the_date(),
										get_the_modified_date()); ?>
								</td>
							</tr>
						<?php endwhile; ?>
					</tbody>

				</table>

			<?php endif; ?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>
