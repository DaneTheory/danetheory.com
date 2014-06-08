<?php
class WPBakeryShortCode_mk_news extends WPBakeryShortCode {
	protected function content( $atts, $content = null ) {
		extract( shortcode_atts( array(
					'count' => 8,
					'offset' => 0,
					'cat' => '',
					'posts' => '',
					'author' => '',
					'image_height' => '250',
					'pagination' => 'true',
					'pagination_style' => '2',
					'orderby'=> 'date',
					'order'=> 'DESC',


				), $atts ) );

		$query = array(
			'posts_per_page' => (int)$count,
			'post_type'=>'news',
		);
		if ( $offset ) {
			$query['offset'] = $offset;
		}
		if ( $cat ) {
			$query['cat'] = $cat;
		}
		if ( $author ) {
			$query['author'] = $author;
		}
		if ( $posts ) {
			$query['post__in'] = explode( ',', $posts );
		}
		if ( $orderby ) {
			$query['orderby'] = $orderby;
		}
		if ( $order ) {
			$query['order'] = $order;
		}

		global $wp_version;
		if ( ( is_front_page() || is_home() ) && version_compare( $wp_version, "3.1", '>=' ) ) {//fix wordpress 3.1 paged query
			$paged = ( get_query_var( 'paged' ) ) ?get_query_var( 'paged' ) : ( ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1 );
		}else {
			$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		}
		$query['paged'] = $paged;

		$r = new WP_Query( $query );


		if ( is_singular() ) {
			global $post;
			$layout = get_post_meta( $post->ID, '_layout', true );
		}

		$atts = array(
			'layout' => $layout,
			'image_height' => $image_height,
		);

		wp_enqueue_script( 'jquery-isotope' );

		if ( $pagination_style == '2' ) {
			$paginaton_style_class = 'load-button-style';
			wp_enqueue_script( 'infinitescroll' );
		}
		else if ( $pagination_style == '3' ) {
				$paginaton_style_class = 'scroll-load-style';
				wp_enqueue_script( 'infinitescroll' );
			} else {
			$paginaton_style_class = 'page-nav-style';
		}
		$id = mt_rand( 100, 999 );

		$output = '<section id="mk-news-section-'.$id.'" class="mk-news-container mk-theme-loop isotop-enabled '.$paginaton_style_class.'" >' . "\n";


			if ( $r->have_posts() ):
				while ( $r->have_posts() ) :
					$r->the_post();
					$output .= mk_news_loop( $atts, 1 );
			endwhile;
			endif;


		$output .= '</section><div class="clearboth"></div>' . "\n\n";



		$output .= '<a class="mk-loadmore-button" style="display:none;" href="#"><i class="mk-icon-arrow-down mk-left"></i>'.__('Load More', 'mk_framework').'<i class="mk-icon-arrow-down mk-right"></i></a>';

		if ( $pagination == 'true'  ) {
			ob_start();
			theme_blog_pagenavi( '', '', $r, $paged );
			$output .= ob_get_clean();
		}
		wp_reset_postdata();

		return $output;
	}
}






/*
* Blog Classic Style
*/
function mk_news_loop( $atts, $current ) {
	global $post;
	extract( $atts );

	$post_style = get_post_meta( $post->ID, '_news_post_style', true );

	$terms = get_the_terms( get_the_id(), 'news_category' );
	$terms_slug = array();
	$terms_name = array();
	if ( is_array( $terms ) ) {
		foreach ( $terms as $term ) {
			$terms_slug[] = $term->slug;
			$terms_name[] = $term->name;
		}
	}

	switch($post_style) {

	case 'full-with-image' :
		if($layout == 'full') {
			$image_width = 1100;
		} else {
			$image_width = 800;
		}
	break;
	case 'full-without-image' :
		if($layout == 'full') {
			$image_width = 1100;
		} else {
			$image_width = 800;
		}
	break;
	case 'half-with-image' :
		$image_width = 550;
	break;
	case 'half-without-image' :
		$image_width = 550;
	break;
	case 'fourth-with-image' :
		$image_width = 275;
	break;
	case 'fourth-without-image' :
		$image_width = 275;
	default :




		}


	$output ='<article id="'.get_the_ID().'" style="height:'.$image_height.'px" class="mk-news-item mk-isotop-item news-'.$post_style.'">';
		
switch($post_style) {

	case 'full-with-image' :
		$image_src_array = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full', true );
		$image_src  = theme_image_resize( $image_src_array[ 0 ], $image_width, $image_height);
		if ( has_post_thumbnail() ) {
			$output .='<img alt="'.get_the_title().'" title="'.get_the_title().'" src="'.get_image_src( $image_src['url'] ).'" />';
		}
		$output .='<span class="news-date">'.get_the_time( 'Y/m/d' ).'</span>';
		$output .='<div class="news-meta-wrapper">';
		$output .='<div class="news-categories"><span>'. implode( ' ', $terms_name ) .'</span></div>';
		$output .='<div class="clearboth"></div>';
		$output .='<div class="news-the-title"><span><a href="'.get_permalink().'">'.get_the_title().'</a></span></div>';
		$output .= '</div>';
	break;

	case 'full-without-image' :
		$output .='<div class="news-meta-wrapper">';
		$output .='<div class="news-categories"><span>'. implode( ' ', $terms_name ) .'</span></div>';
		$output .='<div class="clearboth"></div>';
		$output .='<div class="news-the-title"><span><a href="'.get_permalink().'">'.get_the_title().'</a></span></div>';
		$output .='<span class="news-date">'.get_the_time( 'Y/m/d' ).'</span>';
		$output .= '</div>';
		$output .='<div class="the-excerpt">'.get_the_excerpt().'</div>';
		$output .= '<a href="'.get_permalink().'" class="mk-read-more">'.__('Read more' , 'mk_framework').'<i class="mk-icon-double-angle-right"></i></a>';
	break;


	case 'half-with-image' :
		$image_src_array = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full', true );
		$image_src  = theme_image_resize( $image_src_array[ 0 ], $image_width, $image_height);
		if ( has_post_thumbnail() ) {
			$output .='<img alt="'.get_the_title().'" title="'.get_the_title().'" src="'.get_image_src( $image_src['url'] ).'" />';
		}
		$output .='<span class="news-date">'.get_the_time( 'Y/m/d' ).'</span>';
		$output .='<div class="news-meta-wrapper">';
		$output .='<div class="news-categories"><span>'. implode( ' ', $terms_name ) .'</span></div>';
		$output .='<div class="clearboth"></div>';
		$output .='<div class="news-the-title"><span><a href="'.get_permalink().'">'.get_the_title().'</a></span></div>';
		$output .= '</div>';
	break;

	case 'half-without-image' :
		$output .='<div class="news-meta-wrapper">';
		$output .='<div class="news-categories"><span>'. implode( ' ', $terms_name ) .'</span></div>';
		$output .='<div class="clearboth"></div>';
		$output .='<div class="news-the-title"><span><a href="'.get_permalink().'">'.get_the_title().'</a></span></div>';
		$output .='<span class="news-date">'.get_the_time( 'Y/m/d' ).'</span>';
		$output .='<div class="clearboth"></div>';
		$output .= '</div>';
		$output .='<div class="the-excerpt">'.get_the_excerpt().'</div>';
		$output .= '<a href="'.get_permalink().'" class="mk-read-more">'.__('Read more' , 'mk_framework').'<i class="mk-icon-double-angle-right"></i></a>';
	break;


	case 'fourth-with-image' :
		$image_src_array = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full', true );
		$image_src  = theme_image_resize( $image_src_array[ 0 ], $image_width, $image_height);
		if ( has_post_thumbnail() ) {
			$output .='<img alt="'.get_the_title().'" title="'.get_the_title().'" src="'.get_image_src( $image_src['url'] ).'" />';
		}
		$output .='<span class="news-date">'.get_the_time( 'Y/m/d' ).'</span>';
		$output .='<div class="news-meta-wrapper">';
		$output .='<div class="news-categories"><span>'. implode( ' ', $terms_name ) .'</span></div>';
		$output .='<div class="clearboth"></div>';
		$output .='<div class="news-the-title"><span><a href="'.get_permalink().'">'.get_the_title().'</a></span></div>';
		$output .= '</div>';
	break;


	case 'fourth-without-image' :
		$output .='<div class="news-meta-wrapper">';
		$output .='<div class="news-categories"><span>'. implode( ' ', $terms_name ) .'</span></div>';
		$output .='<div class="clearboth"></div>';
		$output .='<div class="news-the-title"><span><a href="'.get_permalink().'">'.get_the_title().'</a></span></div>';
		$output .='<span class="news-date">'.get_the_time( 'Y/m/d' ).'</span>';
		$output .= '</div>';
		$output .='<div class="the-excerpt">'.get_the_excerpt().'</div>';
		$output .= '<a href="'.get_permalink().'" class="mk-read-more">'.__('Read more' , 'mk_framework').'<i class="mk-icon-double-angle-right"></i></a>';
	default :


		}
	


	$output .='</article>';



	return $output;

}
/*******************************************/







class WPBakeryShortCode_mk_news_tab extends WPBakeryShortCode {

    public function content( $atts, $content = null ) {

        $el_class = $width = $el_position = '';

        extract( shortcode_atts( array(
                    'el_class' => '',
                    'widget_title' => '',
                    'tab_title' => '',
                    'width' => '1/1',
                    'el_position' => '',
                ), $atts ) );

        $output = '';
        wp_enqueue_script('jquery-tools');

        $width = wpb_translateColumnWidthToSpan( $width );
        $el_position_css = '';
        if ( $el_position != '' ) {
            $el_position_css = $el_position.'-column';
        }

        if(!empty($widget_title)) {
            $output .= '<h3 class="mk-shortcode mk-fancy-title pattern-style mk-shortcode-heading"><span>'.$widget_title.'</span></h3>';
        }

        $output .= '<div class="mk-news-tab '.$el_class.' '.$el_position_css.' '.$width.'">';
        

		$cat_terms = array();
		$cat_terms = get_terms( 'news_category', 'hide_empty=1' );
		$output .= '<div class="mk-news-tab-heading">';
		$output .= '<span class="mk-news-tab-title">'.$tab_title.'</span>';
		$output .= '<ul class="mk-tabs-tabs">';
		
		foreach ( $cat_terms as $cat_term ) {
			$output .= '<li><a href="#">' . $cat_term->name . '</a></li>';
		}
		$output .= '<div class="clearboth"></div></ul>';
		$output .= '<div class="clearboth"></div></div>';
		$output .= '<div class="mk-tabs-panes">';

		foreach ( $cat_terms as $cat_term ) {
			$output .= '<div class="mk-tabs-pane">';
			$query = array(
				'post_type'=>'news',
				'posts_per_page' => 3,
				'offset' => 0
			);

			global $wp_version;
				$query['tax_query'] = array(
					array(
						'taxonomy' => 'news_category',
						'field' => 'slug',
						'terms' => $cat_term->slug
					)
				);


			$r = new WP_Query( $query );
			$i = 0;
			if ( $r->have_posts() ):
			while ( $r->have_posts() ) :
				$r->the_post();
			$i++;

			$terms = get_the_terms( get_the_id(), 'news_category' );
			$terms_slug = array();
			$terms_name = array();
			if ( is_array( $terms ) ) {
				foreach ( $terms as $term ) {
					$terms_slug[] = $term->slug;
					$terms_name[] = $term->name;
				}
			}
			if($i == 1) {
			$output .='<div class="news-tab-wrapper left-side">';
			
				$image_src_array = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full', true );
				$image_src  = theme_image_resize( $image_src_array[ 0 ], 500, 340);
				if ( has_post_thumbnail() ) {
					$output .='<a href="'.get_permalink().'" class="news-tab-thumb"><img alt="'.get_the_title().'" title="'.get_the_title().'" src="'.get_image_src( $image_src['url'] ).'" /></a>';
				}
			$output .='<h3 class="the-title"><a href="'.get_permalink().'">'.get_the_title().'</a></h3>';
			$output .='<div class="the-excerpt">'.get_the_excerpt().'</div>';
			$output .='<a class="new-tab-readmore" href="'.get_permalink().'">'.__('Read More', 'mk_framework').'<i class="mk-icon-caret-right"></i></a>';
			$output .= '</div>';

			} else {
				$output .='<div class="news-tab-wrapper">';
				$output .='<h3 class="the-title"><a href="'.get_permalink().'">'.get_the_title().'</a></h3>';
				$output .='<div class="the-excerpt">'.get_the_excerpt().'</div>';
				$output .='<a class="new-tab-readmore" href="'.get_permalink().'">'.__('Read More', 'mk_framework').'<i class="mk-icon-caret-right"></i></a>';
				$output .= '</div>';	
			}
			endwhile;
			wp_reset_query();
			endif;
			$output .='<div class="clearboth"></div></div>';
		}	


		


		
		$output .= '</div>';
        $output .= '</div> ';

        return $output;
    }
}











