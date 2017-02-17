<?php
/*
 * Single post template
 *
*/

get_header();
the_post();

global $numpages;

$thumbnail_id = get_post_thumbnail_id($post->ID);
$thumbnail_url = wp_get_attachment_url($thumbnail_id);
$comments_count = wp_count_comments(get_the_ID());

?>

<div id="main-content">
	<div class="container inner">
		<div class="col-md-8 blogs">
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<div class="entry-content" itemprop="text">
					<?php if ($thumbnail_url) : ?>
						<div class="post-thumbnail">
							<?php the_post_thumbnail(); ?>
						</div><!--end .post-thumbnail-->
					<?php endif; ?>
					<!--<img style="display:none;" itemprop="image" src="<?php echo the_post_thumbnail_url();?>">-->
					<h1 class="single-title entry-title" itemprop="headline" ><?php the_title(); ?></h1>
					<div class="post-meta">
					<span class="post-date updated base_clr_bg sticky-post-date" itemprop="datePublished">
						<?php $date = date_parse(get_the_date()); ?>
<?php echo strftime("%b", mktime(0, 0, 0, $date["month"])); ?>&nbsp;<?php echo $date["day"]; ?>,&nbsp;<?php echo $date["year"]; ?>
					</span>
					<span style="display: none;" itemprop="dateModified"><?php the_modified_date();?></span>
					<span class="post-author vcard author"><span class="fn"><i class="fa fa-user"></i> <?php echo get_the_author(); ?></span></span>
					<span class="post-cat"><i class="fa fa-folder-o"></i><?php echo get_the_category_list(", "); ?></span>
				</div>
					<?php the_content(); ?>
	
				</div>

				<?php
				if ($numpages > 1): ?>
					<div class="posts-links-box">
						<?php wp_link_pages(array(
								'before' => '<div class="page-link">' . '',
								'after' => '</div>',
								'link_before' => '<div class="page-link-num base_clr_brd">' . '',
								'link_after' => '</div>'
							));
						?>
					</div><!--end post links-->
				<?php endif; ?>
				
				<?php
					//for use in the loop, list 5 post titles related to first tag on current post
					$tags = wp_get_post_tags($post->ID);
					if ($tags) { ?>
					<div class="related-posts">
					<?php $rel_meg = '<h3>Related Posts</h3>';
					$first_tag = $tags[0]->term_id;
					$args=array(
					'tag__in' => array($first_tag),
					'post__not_in' => array($post->ID),
					'posts_per_page'=>4,
					'caller_get_posts'=>1
					);?>
					<div class="row">
						<?php $my_query = new WP_Query($args);
						if( $my_query->have_posts() ) {
							echo $rel_meg;
						while ($my_query->have_posts()) : $my_query->the_post(); ?>
						<div class="col-sm-3">
							<div class="rel-thumb"><?php echo get_the_post_thumbnail(); ?></div>
							<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
						</div>

						<?php
						endwhile;
						} ?> </div>
				
						<?php wp_reset_query(); ?>
						</div>
						<?php } ?>
					
				<div class="tags-box">
					<?php

						$tag_list = get_the_tag_list( '', __( ' ', 'vivaco' ) );
						if ( $tag_list ) { echo '<i class="icon icon-shopping-08"></i> <span class="tags-links">' . $tag_list . '</span>'; }

						$temp_post = get_next_post();
						$next_post_title = !empty( $temp_post ) ? $temp_post->post_title : '';

						$temp_post = get_previous_post();
						$prev_post_title = !empty( $temp_post ) ? $temp_post->post_title : '';

						if (strlen($next_post_title) > MAX_NAV_TITLE_LENGTH){
							$next_post_title = substr($next_post_title,0, MAX_NAV_TITLE_LENGTH)."...";
						};

						if (strlen($prev_post_title) > MAX_NAV_TITLE_LENGTH){
							$prev_post_title = substr($prev_post_title,0, MAX_NAV_TITLE_LENGTH)."...";
						};

					?>
				</div><!--end tags-->

				<div class="entry-navigation aligncenter">
					<?php previous_post_link('<div class="prev-post"><i class="icon icon-arrows-03"></i><strong>%link</strong></div>', $prev_post_title); ?>
						<div class="share-box">
							<p class="title">
								<a href="javascript:;" class="share facebook img-circle" onClick="FacebookShare()"><i class="fa fa-facebook"></i></a>
								<a href="javascript:;" class="share twitter img-circle" onClick="TwitterShare()"><i class="fa fa-twitter"></i></a>
								<a href="javascript:;" class="share google img-circle" onClick="GoogleShare()"><i class="fa fa-google-plus"></i></a>
								<a href="javascript:;" class="share linkedin img-circle" onClick="LinkedinShare()"><i class="fa fa-linkedin"></i></a>
								<a href="javascript:;" class="share pinterest img-circle" onClick="PinterestShare()"><i class="fa fa-pinterest"></i></a>
							</p>
						</div>
					<?php next_post_link('<div class="next-post"><strong>%link</strong><i class="icon icon-arrows-04"></i></div>', $next_post_title); ?>
				</div><!--end navigation & social sharing-->

				<div class="author-box">
					<div class="avatar-wrap"><span class="avatar rounded"><?php echo get_avatar( get_the_author_meta('email') , 100 ); ?></span></div>
						<span class="author name" itemprop="author" itemscope itemtype="http://schema.org/Person"><strong  itemprop="name"><?php echo get_the_author_meta('nickname'); ?></strong></span>
							<p>
								<?php echo get_the_author_meta('description'); ?>
							</p>
				</div><!--end author bio-->

				<h4 class="comments-count"><?php printf(__('This entry has %s replies','vivaco'), '<span class="comments-count base_clr_txt">' . $comments_count->approved . '</span>');?></h4>
				<?php comments_template(); ?>
				<!--end comments-->

				<!-- schema structured data -->
				<!--<meta itemprop="url" content="<?php get_permalink(); ?>">
				<span itemprop="publisher" itemscope itemtype="http://schema.org/Organization">
				<meta itemprop="name" content="be healthy today inc">
				<img style="display: none" itemscope itemprop="logo"  src="https://behealthy.today/wp-content/uploads/2016/11/rsz_1rsz_logo_03.png" />
					<meta itemprop="width" content="600">
					<meta itemprop="height" content="60">
				</span> -->
				<!-- end schema structured data-->

			</article>

			</div><!-- end col-sm-8 -->

		<?php get_sidebar(); ?>

	</div><!--end container-inner-->

</div><!--end main-content-->
</div>
<?php get_footer(); ?>
