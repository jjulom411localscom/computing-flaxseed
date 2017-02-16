<?php
/*
 * Template name: Blog, sidebar right
 */

get_header();
$comments_count = wp_count_comments(get_the_ID());
?>
<header class="entry-header">
	<?php vivaco_ultimate_title(); ?>
</header><!-- .entry-header -->
<div id="main-content">
	<div class="container inner">
		<div class="col-md-8 col-sm-12 blogs">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php
					//the_title( '<header class="entry-header"><h2 class="entry-title">', '</h2></header><!-- .entry-header -->' );
				?>

				<div class="entry-content">
					<?php
						// Start the Loop.
						while ( have_posts() ) : the_post(); ?>
							<div class="post-meta"><span class="post-cat"><i class="fa fa-folder-o"></i><?php echo get_the_category_list(", "); ?></span></div>
							<div class="post-thumbnail"><?php the_post_thumbnail(); ?></div><!--end .post-thumbnail-->
							<h1><?php the_title(); ?></h1>
							<?php	the_content(); ?>
						<?php endwhile; ?>
				</div>

			</article>
			<?php if ( comments_open() ): ?>

				<h4 class="comments-count"><?php printf(__('This page has %s comments', 'vivaco'),'<span class="base_clr_txt">' . $comments_count->approved . '</span>'); ?></h4>
				<?php comments_template(); ?>
				<!--end comments-->
			<?php endif; ?>

		</div><!--end col-dm-8- blogs-->

		<?php get_sidebar(); ?>

	</div><!--end container -->
</div>

<?php get_footer(); ?>