<?php

class WPBakeryShortCode_mk_portfolio extends WPBakeryShortCode {
    protected function content( $atts, $content = null ) {
	extract( shortcode_atts( array(
				'column' => 5,
				'count'=> 10,
				'disable_excerpt' => 'true',
				'disable_permalink' => 'true',
				"sortable" => 'true',
				'pagination' => 'true',
				'pagination_style' => '1',
				'height' => '',
				'cat' => '',
				'author' => '',
				'posts' => '',
				'offset' => 0,
				'order'=> 'DESC',
				'orderby'=> 'date',
				'target' => '_self',
				'el_position' => '',
                'width' => '1/1',
			), $atts ) );


	global $wp_version;
	if ( is_front_page() && version_compare( $wp_version, "3.1", '>=' ) ) {
		$paged = ( get_query_var( 'paged' ) ) ?get_query_var( 'paged' ) : ( ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1 );
	}else {
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
	}

	$query = array(
		'post_type' => 'portfolio',
		'posts_per_page' => (int)$count,
		'paged' => $paged
	);
	if ( $offset ) {
		$query['offset'] = $offset;
	}
	if ( $cat != '' ) {
		global $wp_version;
		if ( version_compare( $wp_version, "3.1", '>=' ) ) {
			$query['tax_query'] = array(
				array(
					'taxonomy' => 'portfolio_category',
					'field' => 'slug',
					'terms' => explode( ',', $cat )
				)
			);
		}else {
			$query['taxonomy'] = 'portfolio_category';
			$query['term'] = $cat;
		}
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

	$r = new WP_Query( $query );

	
	if ( is_page() ) {
			global $post;
			$layout = get_post_meta( $post->ID, '_layout', true );
		}
		else if ( is_search() ) {
				$layout = theme_option( THEME_OPTIONS, 'search_page_layout' );
			}
		else if ( is_archive() ) {
				$layout = theme_option( THEME_OPTIONS, 'archive_page_layout' );
			}


	$atts = array(
		'column' => $column,
		'layout' => $layout,
		'height' => $height,
		'disable_excerpt' => $disable_excerpt,
		'pagination' => $pagination,
		'target' => $target,
		'disable_permalink' => $disable_permalink
	);
	wp_enqueue_script( 'jquery-isotope' );
	$paginaton_style_class = '';
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
	$width = wpb_translateColumnWidthToSpan( $width );
    $output = '';
    $el_position_css = '';
    if ( $el_position != '' ) {
        $el_position_css = $el_position.'-column';
    }
    $output .= '<div class="'.$width.' '.$el_position_css.'">';

	$id = mt_rand( 100, 999 );
	if ( $sortable == 'true' && !is_archive()) {
		$output .= '<div class="clearboth"></div><header id="mk-filter-portfolio"><ul>';
		$terms = array();
		if ( $cat != '' ) {
			foreach ( explode( ',', $cat ) as $term_slug ) {
				$terms[] = get_term_by( 'slug', $term_slug, 'portfolio_category' );
			}
		} else {
			$terms = get_terms( 'portfolio_category', 'hide_empty=1' );
		}
		$output .= '<li><a class="current" data-filter="*" href="#">'.__( 'All', 'mk_framework' ).'</a></li>';
		foreach ( $terms as $term ) {
			$output .= '<li><a data-filter=".'.$term->slug . '" href="#">' . $term->name . '</a></li>';
		}
		
	$output .= '<div class="clearboth"></div></ul>';
	if($column != 1) : 
	$output .= '<div data-view="mk-portfolio-loop-'.$id.'" class="mk-portfolio-orientation">';
	$output .= '<a href="#" class="mk-grid-view current"></a>';
	$output .= '<a href="#" class="mk-list-view"></a>';
	$output .= '</div>';
	endif;
	$output .= '<div class="clearboth"></div></header>';
	}	

	$output .= '<section id="mk-portfolio-loop-'.$id.'" class="mk-portfolio-container mk-theme-loop isotop-enabled '.$paginaton_style_class.' " >' . "\n";

	if ( is_archive()) :
	if ( have_posts() ):
	while ( have_posts() ) :
		the_post();
	$output .= mk_portfolio_loop( $r, $atts, 1);
	endwhile;
	endif;
	else :
		if ( $r->have_posts() ):
		while ( $r->have_posts() ) :
		$r->the_post();
	$output .= mk_portfolio_loop( $r, $atts, 1);
	endwhile;
	endif;
	endif;
	

	$output .= '</section><div class="clearboth"></div>' . "\n\n";



	$output .= '<a class="mk-loadmore-button" href="#"><i class="mk-icon-arrow-down mk-left"></i>'.__('Load More', 'mk_framework').'<i class="mk-icon-arrow-down mk-right"></i></a>';
	

	if ( $pagination == 'true' ) {
		ob_start();
		theme_blog_pagenavi( '', '', $r, $paged );
		$output .= ob_get_clean();
	}
	wp_reset_postdata();
	$output .= '</div>';
	return $output;
}
}








/*
* Portfolio Newspaper Style
*/
function mk_portfolio_loop( &$r, $atts, $current) {
	global $post;
	extract( $atts );
	


	if($column > 6) {
		$column = 6;
	}

	switch ( $column ) {
	case 1:
		if($layout == 'full') {
			$width = 1100;
		} else {
			$width = 770;
		}
		$column_css = 'portfolio-one-column';
		break;
	case 2:
		if($layout == 'full') {
			$width = 528;
		} else {
			$width = 500;
		}
		$column_css = 'portfolio-two-column';
		break;
	case 3:
		$width = 500;
		$column_css = 'portfolio-three-column';
		break;

	case 4:
		$width = 500;
		$column_css = 'portfolio-four-column';
		break;	

	case 5:
		$width = 500;
		$column_css = 'portfolio-five-column';
		break;	

	case 6:
		$width = 500;
		$column_css = 'portfolio-six-column';
		break;			
	
	}

	if ( $layout == 'full' ) {
		$layout_class = 'portfolio-full-layout';
	} else {
		$layout_class = 'portfolio-with-sidebar';
	}

	


	$output = '';



	$terms = get_the_terms( get_the_id(), 'portfolio_category' );
	$terms_slug = array();
	$terms_name = array();
	if ( is_array( $terms ) ) {
		foreach ( $terms as $term ) {
			$terms_slug[] = $term->slug;
			$terms_name[] = '<a href="'.get_term_link($term->slug, 'portfolio_category').'">'.$term->name.'</a>';

		}
	}


	$height = !empty($height) ? $height : 600;

	$post_type = get_post_meta( $post->ID, '_single_post_type', true );
	$post_type = !empty($post_type) ? $post_type : 'image';

		$link_to = get_post_meta( get_the_ID(), '_portfolio_permalink', true );
		$permalink  = '';
		if ( !empty( $link_to ) ) {
			$link_array = explode( '||', $link_to );
			switch ( $link_array[ 0 ] ) {
			case 'page':
				$permalink = get_page_link( $link_array[ 1 ] );
				break;
			case 'cat':
				$permalink = get_category_link( $link_array[ 1 ] );
				break;
			case 'portfolio':
				$permalink = get_permalink( $link_array[ 1 ] );
				break;
			case 'post':
				$permalink = get_permalink( $link_array[ 1 ] );
				break;
			case 'manually':
				$permalink = $link_array[ 1 ];
				break;
			}
		}

	if(empty($permalink)) {
		$permalink = get_permalink();
	}


	$output .='<article id="'.get_the_ID().'" class="mk-portfolio-item mk-isotop-item '.$column_css.' '.$layout_class.' portfolio-'.$post_type.' ' . implode( ' ', $terms_slug ) . '">';

	$image_src_array = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full', true );
	$image_src  = theme_image_resize( $image_src_array[ 0 ], $width, $height);

	$lightbox = $single_hover_icon = '';
	if($disable_permalink == 'false') {
		$single_hover_icon = ' hover-single-icon';
	}

	if ( $post_type == 'image' || $post_type == '' ) {

		$lightbox ='<a rel="prettyPhoto[portfolio-loop]" title="'.get_the_title().'" class="zoom-badge mk-lightbox'.$single_hover_icon.'" href="'.$image_src_array[ 0 ].'"><i class="mk-icon-zoom-in"></i></a>';

	} else 	if ( $post_type == 'video') {
		$video_id = get_post_meta( $post->ID, '_single_video_id', true );
		$video_site  = get_post_meta( $post->ID, '_single_video_site', true );

		$video_url = '';
			// Vimeo Video post type
			if ( $video_site =='vimeo' ) {
				$video_url = 'http://vimeo.com/'.$video_id;
			// Youtube Video post type
			} elseif ( $video_site =='youtube' ) {
				$video_url = 'http://www.youtube.com/watch?v='.$video_id.'';

			// dailymotion Video post type
			} elseif ( $video_site =='dailymotion' ) {
				$video_url = 'http://www.dailymotion.com/embed/video/'.$video_id.'?logo=0';
			}
		   $lightbox ='<a rel="prettyPhoto[portfolio-loop]" title="'.get_the_title().'" class="video-badge mk-lightbox'.$single_hover_icon.'" href="'.$video_url.'"><i class="mk-icon-play"></i></a>';
		}	

		$output .='<div class="featured-image">';
		$output .='<img alt="'.get_the_title().'" title="'.get_the_title().'" src="'.get_image_src($image_src['url']).'"  />';
		$output .='<div class="image-hover-overlay"></div>';
		if($disable_permalink == 'true') {
			$output .='<a class="permalink-badge" target="'.$target.'" href="'.$permalink.'"><i class="mk-icon-link"></i></a>';
		}
		$output .= $lightbox;
		$output .='</div>';

		$output .='<div class="portfolio-meta-wrapper">';

		if($disable_permalink == 'true') {
			$output .='<h3 class="the-title"><a target="'.$target.'" href="'.$permalink.'">'.get_the_title().'</a></h3><div class="clearboth"></div>';
		} else {
			$output .='<h3 class="the-title">'.get_the_title().'</h3><div class="clearboth"></div>';
		}
		$output .='<div class="portfolio-categories">'. implode( ', ', $terms_name ) .' </div>';
		if($disable_excerpt == 'true') {
			$output .='<div class="the-excerpt">'.get_the_excerpt().'</div>';
		}
		$output .='</div>';
		



	$output .='<div class="clearboth"></div></article>' . "\n\n\n";


	return $output;

}
/*******************************************/






