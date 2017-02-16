<!-- right side [sidebar] -->
<div id="sidebar" class="sidebar col-xs-12">
	<div id="sidebar-content">

			<div id="masonry-sidebar" class="sidebar-inner-content">
				
					
					<?php 

					if(is_search() || is_archive()) :

							dynamic_sidebar('sidebar-404');

					else :
							if(get_post_meta(get_the_ID() , 'sidebar-404' , true) != '') {
							    dynamic_sidebar(get_post_meta(get_the_ID() , 'sidebar-404' , true));
							}else{
							    dynamic_sidebar('sidebar-404');
							}
					endif;
					?>



			</div>
		<!-- end sidebar inner -->
	</div>
	<!-- end sidebar content -->
</div><!-- end sidebar -->