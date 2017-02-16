<?php 
/*
*Template name: Loginerri
*/
get_header();
$comments_count = wp_count_comments(get_the_ID());
?>
<header class="entry-header">
	<?php vivaco_ultimate_title(); ?>
</header><!-- .entry-header -->
<div id="main-content">
	<div class="container-fluid log-page">
			<?php
				// Start the Loop.
				while ( have_posts() ) : the_post();
					// Include the page content template.
					the_content();
				endwhile;
			?>
			<div class="container">
				<?php 
					$args = array(
						'echo'           => true,
						'remember'       => true,
						'redirect'       => ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
						'form_id'        => 'loginform',
						'id_username'    => 'user_login',
						'id_password'    => 'user_pass',
						'id_remember'    => 'rememberme',
						'id_submit'      => 'wp-submit',
						'label_username' => __( 'Username' ),
						'label_password' => __( 'Password' ),
						'label_remember' => __( 'Remember Me' ),
						'label_log_in'   => __( 'Log In' ),
						'value_username' => '',
						'value_remember' => false
						);

				 if(is_user_logged_in()){ ?>
					<h2 class="login message">User already Logged in.</h2>

				<?php }else{ ?>
					<h2 style="text-align: left;" class="login text">Login</h2>
					<?php wp_login_form($args);
				} ?>
				


			</div>


	</div><!--end container -->
</div>

<?php get_footer(); ?>