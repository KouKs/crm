<?php
/**
 * The main template file
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<form role="search" method="get" id="searchform" class="search" action="http://localhost/crm/">
				<div>
					<input type="text" name="s" id="s" placeholder="Search">
					<select name="column">
						<option value="_crm_last_name">In last names</option>
						<option value="_crm_company">In companies</option>
					</select>
					<button>Go</button>
				</div>
			</form>

			<?php if (have_posts()) : ?>



				<table id="clients" class="table-simple">
					<thead>
						<tr>
							<td class="sortable <?= get_order_class('_crm_last_name') ?>">
								<a href="<?= get_order_url('_crm_last_name') ?>">
									<span>Name</span>									
								</a>
							</td>
							<td class="sortable <?= get_order_class('_crm_company') ?>">
								<a href="<?= get_order_url('_crm_company') ?>">
									<span>Position</span>									
								</a>
							</td>
							<td>Contact</td>
							<td>Date</td>
						</tr>
					</thead>

					<tfoot>
						<tr>
							<td class="sortable <?= get_order_class('_crm_last_name') ?>">
								<a href="<?= get_order_url('_crm_last_name') ?>">
									<span>Name</span>									
								</a>
							</td>
							<td class="sortable <?= get_order_class('_crm_company') ?>">
								<a href="<?= get_order_url('_crm_company') ?>">
									<span>Position</span>									
								</a>
							</td>
							<td>Contact</td>
							<td>Date</td>
						</tr>
					</tfoot>

					<tbody>
						<?php while (have_posts()) : the_post();

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

				<div class="pagination">
					<?php previous_posts_link('<div class="prev">&laquo; Previous</div>') ?>
					<?php next_posts_link('<div class="next">More &raquo;</div>') ?>
				</div>

			<?php endif; ?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>
