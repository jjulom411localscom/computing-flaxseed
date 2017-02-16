<?php
/**
 * The Header
 * @version 2.2
 *
 */
?><!DOCTYPE html>
<!--[if IE 6]><html class="ie ie6 no-js" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 7]><html class="ie ie7 no-js" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 8]><html class="ie ie8 no-js" <?php language_attributes(); ?>><![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html class="no-js" <?php language_attributes(); ?>>
<head>
	<meta name="google-site-verification" content="lCBR5PjpwZWvmxTnCNPh0tcINGxXmmvR1UYv0hxbbqk" /> 
	<!-- WordPress header -->
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>">
	<?php if (!startuply_option('responsive_on')) : ?>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />
	<?php else: ?>
		<meta name="viewport" content="width=1200" />
	<?php endif; ?>

	<!-- Startuply favicon -->
	<?php
	$site_favicon = startuply_option('vivaco_favicon');
	if (!$site_favicon) {
		$site_favicon = get_template_directory_uri().'/images/favicon.ico';
	}
	if(!isset($is_home)) {$is_home = '';};
	$options = startuply_get_all_option();

	?>
	<link rel="shortcut icon" href="<?php echo esc_attr($site_favicon); ?>">
	<!-- Wordpress head functions -->
	<?php wp_head(); ?>
	


 <!--Start of Zopim Live Chat Script-->
 <!--
<script type="text/javascript">
window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute("charset","utf-8");
$.src="//v2.zopim.com/?3zZbqYoEAv7jEEvVsYO5iohgrF5Gt8N2";z.t=+new Date;$.
type="text/javascript";e.parentNode.insertBefore($,e)})(document,"script");
</script> -->
<!--End of Zopim Live Chat Script-->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-86037220-1', 'auto');
  ga('send', 'pageview');

</script>
</head>

<body id="landing-page" <?php body_class(); ?>>

	<!--<div id="mask">

	<?php if (empty($options['loading_gif'])) { ?>
		<div class="preloader"><div class="spin base_clr_brd"><div class="clip left"><div class="circle"></div></div><div class="gap"><div class="circle"></div></div><div class="clip right"><div class="circle"></div></div></div></div>
		<?php
		} else {
			$loading_gif = isset($options['loading_gif']) ? $options['loading_gif'] : '';
		?>
		<div id="custom_loader"><img src="<?php echo esc_attr($loading_gif); ?>" alt="loading"/></div>
	<?php } ?>

	</div>-->

	<header>

		<?php if (startuply_option('sub_menu_on') == '1') { ?>
		<div id="sub-menu" class="sub-menu">
			<div class="container">
				<div class="row">
				<?php

					$layout_sub_menu = array(6,6);
					$widget_number = 1;
					$class_prefix = 'col-sm-';
					$active_widgets = 0;
					foreach ($layout_sub_menu as $col) {
						echo '<div class="'.$class_prefix.$col.'">';

						if(is_active_sidebar("sidebar_sub_menu_$widget_number")) {
							dynamic_sidebar("sidebar_sub_menu_$widget_number");
							$active_widgets++;
						} else {
							echo "&nbsp;";
						}
						echo '</div>';
					$widget_number++;
					}
					if ($active_widgets < 1){
						echo '<div class=col-sm-12 text-center" style="margin-top:-20px;"><p class="text-center">Please assign some widgets to sub menu through Appearance -> Widgets or disable it</p></div>';
					}
					
					?>

				</div>


			</div>
		</div>
		<?php } ?>
		<nav class="navigation navigation-header <?php echo $is_home;?> <?php startuply_menu_style(get_the_ID());?>" role="navigation">
			<div class="container">
				<div class="navigation-brand">
					<div class="brand-logo">
						<a href="<?php echo home_url(); ?>" class="logo">
							<?php 
								//get theme or page logo
								//startuply_theme_logo(get_the_ID());
							?>
							<img src="https://behealthy.today/wp-content/uploads/2016/11/rsz_1rsz_logo_03.png">
							<img src="https://behealthy.today/wp-content/uploads/2016/11/rsz_1rsz_logo_03.png" width="606" height="93" alt="logo" class="retina" />
							<img src="https://behealthy.today/wp-content/uploads/2016/11/rsz_1rsz_logo_03.png" width="606" height="93" alt="logo" class="sticky-logo"/>
							<img src="https://behealthy.today/wp-content/uploads/2016/11/rsz_1rsz_logo_03.png" width="606" height="93" alt="logo" class="sticky-logo retina" />
						</a>
						<span class="sr-only"><?php echo bloginfo( 'name' ); ?></span>
					</div>
					<button class="navigation-toggle visible-xs" type="button" data-target=".navbar-collapse">
						<span class="icon-bar base_clr_bg"></span>
						<span class="icon-bar base_clr_bg"></span>
						<span class="icon-bar base_clr_bg"></span>
					</button>
				</div>
				<div class="navbar-collapse collapsed">
					<div class="menu-wrapper">
						<!-- Left menu -->
						<?php wp_nav_menu( array( 'theme_location' => 'left_menu', 'menu_class' => 'navigation-bar navigation-bar-left', 'fallback_cb' => 'startuply_default_menu', 'items_wrap' => startuply_edd_cart_wrap(), 'walker' => new wp_bootstrap_navwalker() ) ); ?>
						<!-- Right menu -->
						<div class="right-menu-wrap">
							<ul id="menu-demo-menu" class="navigation-bar ireg-menu">
						<?php if(is_user_logged_in() == FALSE){ ?>
								<li class="menu-item">
									<a class="login home-btn user-profile base_clr_txt" href="<?php echo get_permalink( get_page_by_title( 'Login' ) ); ?>"><?php _e('Login','vivaco'); ?></a>
								</li>
						<?php }?>
								<li class="menu-item cart-ic">
									<a class="cart-contents" href="<?php echo wc_get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>"><i class="fa fa-shopping-cart" aria-hidden="false"></i><?php echo sprintf ( _n( '%d ', '%d ', WC()->cart->get_cart_contents_count() ), WC()->cart->get_cart_contents_count() ); ?></a>

								</li>
							</ul>

						<?php $registration_instead_right_menu_on = startuply_option('registration_instead_right_menu_on', -1);
						if ( $registration_instead_right_menu_on != 1 && (!current_user_can('manage_options') && $user_ID ) ) : // Not register, or Super Admin or Administator only  ?>

							<ul id="menu-demo-menu" class="navigation-bar ireg-menu">
								<?php if( current_user_can('Affiliate')) {  ?> 
									<li class="menu-item featured acount-p-menu">
										<a class="user-profile dropdown-toggle base_clr_brd parent-dp"><?php _e('USER','vivaco'); ?><span class="caret base_clr_txt"></span></a>
										<ul role="menu" class=" dropdown-menu child-dp" style="display: block;">
										   <li class="menu-item">
												<a class=" dropdown-toggle base_clr_brd" href="<?php echo get_permalink( get_page_by_title( 'Affiliate Area' ) ); ?>"><?php _e('Account','vivaco'); ?></a>
											</li>
											<li class="menu-item">
												<?php wp_loginout(); ?>
											</li>
										</ul> 
									</li>
								<?php } else{ ?>
									<li class="menu-item featured acount-p-menu">
										<a class="user-profile dropdown-toggle base_clr_brd parent-dp"><?php _e('USER','vivaco'); ?><span class="caret base_clr_txt"></span></a>
										<ul role="menu" class=" dropdown-menu child-dp" style="display: block;">
										   <li class="menu-item">
												<a class=" dropdown-toggle base_clr_brd" href="<?php echo get_permalink( get_page_by_title( 'My Account' ) ); ?>"><?php _e('My Account','vivaco'); ?></a>
											</li>
											<li class="menu-item">
												<?php wp_loginout(); ?>
											</li>
										</ul> 
									</li>

								<?php } ?>
							</ul>

						<?php else: ?>

							<?php wp_nav_menu( array( 'theme_location' => 'right_menu', 'menu_class' => 'navigation-bar navigation-bar-right', 'fallback_cb' => false, 'walker' => new wp_bootstrap_navwalker() ) ); ?>

						<?php endif; ?>
						</div>
					</div>
				</div>
				<!--btn added-->
				<?php 
				$ord_cl;
				if(is_front_page()):
					$ord_cl = "no-bg"; ?>
				<?php else: 
					$ord_cl = "btn-red-bg"?>
				<?php endif;?>
				<a href="/product/daily-greens-1-item-gr/" class="btn btn-solid order-now <?php echo $ord_cl; ?>">Order now</a>

				<!--end btn add-->
			</div>
		</nav>
	</header>