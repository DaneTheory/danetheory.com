<?php
/*
Template Name: Sitemap
*/


get_header(); ?>
<div id="theme-page">
	<div id="mk-page-id-<?php echo $post->ID; ?>" class="theme-page-wrapper mk-main-wrapper full-layout  mk-grid row-fluid">
		<div class="theme-content">
			<h4 id="pages"><?php _e("Authors", "mk_framework"); ?></h4>
			<ul>
				
				<?php
				wp_list_authors(
				  array(
				    'exclude_admin' => false,
				  )
				);
				?>
				</ul>
				<div style="padding: 20px 0 40px;" class="mk-divider mk-shortcode divider_full_width double_dot "><div class="divider-inner"></div></div>
				<h4 id="pages"><?php _e("Pages", "mk_framework"); ?></h4>
				<ul>
				<?php
				wp_list_pages(
				  array(
				    'exclude' => '',
				    'title_li' => '',
				  )
				);
				?>
				</ul>
				<div style="padding: 20px 0 40px;" class="mk-divider mk-shortcode divider_full_width double_dot "><div class="divider-inner"></div></div>
				<h4 id="posts"><?php _e("Posts", "mk_framework"); ?></h4>
			

				<?php
				$cats = get_categories('exclude=');
				foreach ($cats as $cat) {
				  echo "<h5>".$cat->cat_name."</h5>";
				  echo "<ul style='margin-bottom:25px;'>";
				  query_posts('posts_per_page=-1&cat='.$cat->cat_ID);
				  while(have_posts()) {
				    the_post();
				    $category = get_the_category();
				    // Only display a post link once, even if it's in multiple categories
				    if ($category[0]->cat_ID == $cat->cat_ID) {
				      echo '<li><a href="'.get_permalink().'">'.get_the_title().'</a></li>';
				    }
				  }
				  echo "</ul>";
				}
				?>
	
		</div>
	<div class="clearboth"></div>	
	</div>
	<div class="clearboth"></div>
</div>
<?php get_footer(); ?>