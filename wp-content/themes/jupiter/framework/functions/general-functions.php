<?php

global $theme_options;
function theme_option( $page, $name = NULL ) {
    global $theme_options;
    if ( $name == NULL ) {
        if ( isset( $theme_options[$page] ) ) {
            return $theme_options[$page];
        } else {
            return false;
        }
    } else {
        if ( isset( $theme_options[$page][$name] ) ) {
            return $theme_options[$page][$name];
        } else {
            return false;
        }
    }
}
/*-----------------*/

/* removes Contactform 7 styles */
remove_action( 'wp_enqueue_scripts', 'wpcf7_enqueue_styles' );


/* Safe way to remove autop tags inside shortcodes without touching wordpress filters and default behaviors. */
add_filter('the_content', 'shortcode_empty_paragraph_fix');

    function shortcode_empty_paragraph_fix($content)
    {   
        $array = array (
            '<p>[' => '[', 
            ']</p>' => ']', 
            ']<br />' => ']'
        );

        $content = strtr($content, $array);

        return $content;
    }
/*-----------------*/



if ( ! function_exists( 'mk_under_construction' ) ) {
    function mk_under_construction() {
                
    
        if ( theme_option( THEME_OPTIONS, 'enable_uc' ) == 'true' && !is_user_logged_in() && !is_admin() && basename($_SERVER['PHP_SELF']) != 'wp-login.php' && basename($_SERVER['PHP_SELF']) != 'skin.php'  )
        {
            get_template_part('under-construction');
            exit();
        }
        
    }
}

add_action('init', 'mk_under_construction',26);



/*
* Converts Hex value to RGBA if needed.
*/
function mk_color( $colour, $alpha ) {
    if(!empty($colour)) {
        if($alpha >= 0.95) {
            return $colour; // If alpha is equal 1 no need to convert to RGBA, so we are ok with it. :)
        } else {
            if ( $colour[0] == '#' ) {
                    $colour = substr( $colour, 1 );
            }
            if ( strlen( $colour ) == 6 ) {
                    list( $r, $g, $b ) = array( $colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5] );
            } elseif ( strlen( $colour ) == 3 ) {
                    list( $r, $g, $b ) = array( $colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2] );
            } else {
                    return false;
            }
            $r = hexdec( $r );
            $g = hexdec( $g );
            $b = hexdec( $b );
            $output =  array( 'red' => $r, 'green' => $g, 'blue' => $b );

            return 'rgba(' . implode($output, ',') . ',' . $alpha . ')';
        }
    }    
}

function mk_ago($time)
    {
       $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
       $lengths = array("60","60","24","7","4.35","12","10");

       $now = time();

           $difference     = $now - $time;
           $tense         = "ago";

       for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
           $difference /= $lengths[$j];
       }

       $difference = round($difference);

       if($difference != 1) {
           $periods[$j].= "s";
       }

       return "$difference $periods[$j] ago ";
    }

function hexDarker($hex,$factor = 30)
        {
        $new_hex = '';
        if($hex == '' || $factor == '') {
            return false;
        }

        $hex = str_replace('#', '', $hex);
        
        $base['R'] = hexdec($hex{0}.$hex{1});
        $base['G'] = hexdec($hex{2}.$hex{3});
        $base['B'] = hexdec($hex{4}.$hex{5});

        
        foreach ($base as $k => $v)
                {
                $amount = $v / 100;
                $amount = round($amount * $factor);
                $new_decimal = $v - $amount;
        
                $new_hex_component = dechex($new_decimal);
                if(strlen($new_hex_component) < 2)
                        { $new_hex_component = "0".$new_hex_component; }
                $new_hex .= $new_hex_component;
                }
                
        return '#'.$new_hex;        
        }


/*-----------------*/





function mk_get_skin_color() {
    if(isset($_GET['skin'])) {
        return $_GET['skin'];;
    } else {
        return theme_option( THEME_OPTIONS , 'skin_color');
    }
}




function add_sumtips_admin_bar_link() {
    global $wp_admin_bar;
    if ( !is_super_admin() || !is_admin_bar_showing() )
        return;
    $wp_admin_bar->add_menu( array(
    'id' => 'masterkey_setrtings',
    'title' => __( 'Masterkey Settings', 'mk_framework'),
    'href' =>  admin_url('admin.php?page=masterkey'),
    ) );
}
add_action('admin_bar_menu', 'add_sumtips_admin_bar_link',25);






function the_excerpt_max_charlength( $charlength, $tail = true ) {
    $excerpt = get_the_excerpt();
    $charlength++;

    if ( mb_strlen( $excerpt ) > $charlength ) {
        $subex = mb_substr( $excerpt, 0, $charlength - 5 );
        $exwords = explode( ' ', $subex );
        $excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
        if ( $excut < 0 ) {
            echo mb_substr( $subex, 0, $excut );
        } else {
            echo $subex;
        }
        if ( $tail == true ) {
            echo '...';
        }
    } else {
        echo $excerpt;
    }
}




function comment_max_charlength( $charlength, $tail = true ) {
    $excerpt = get_the_excerpt();
    $charlength++;

    if ( mb_strlen( $excerpt ) > $charlength ) {
        $subex = mb_substr( $excerpt, 0, $charlength - 5 );
        $exwords = explode( ' ', $subex );
        $excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
        if ( $excut < 0 ) {
            echo mb_substr( $subex, 0, $excut );
        } else {
            echo $subex;
        }
        if ( $tail == true ) {
            echo '...';
        }
    } else {
        echo $excerpt;
    }
}




/*
* Converts unordered list navigation to a select box for mobile devices.
*/
class Walker_Nav_Menu_Dropdown extends Walker_Nav_Menu{
    var $to_depth = -1;
    function start_lvl( &$output, $depth = 0, $args = array()) {
        $output .= '</option>';
    }

    function end_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat( "\t", $depth ); // don't output children closing tag
    }

    function start_el( &$output, $item, $depth = 0, $args = array(), $current_object_id = 0) {

        $indent = ( $depth ) ? str_repeat( "&nbsp;", $depth * 4 ) : '';
        $class_names = $value = '';
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;

        $classes[] = 'menu-item-' . $item->ID;
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        $class_names = ' class="' . esc_attr( $class_names ) . '"';
        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
        $id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';
        $value = ' value="'. $item->url .'"';
        $output .= '<option'.$id.$value.$class_names.'>';
        $item_output = $args->before;
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        $output .= $indent.$item_output;
    }


    function end_el(&$output, $item, $depth = 0, $args = array()) {
        if ( substr( $output, -9 ) != '</option>' )
            $output .= "</option>";
    }

}
/*-----------------*/





/**
 * Fix the image src for MultiSite
 */
function get_image_src( $src ) {
        return $src;
}
/*-----------------*/






/*
 * Adds Extra
 */
add_action( 'show_user_profile', 'my_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'my_show_extra_profile_fields' );

function my_show_extra_profile_fields( $user ) { ?>

    <h3>User Social Networks</h3>

    <table class="form-table">

        <tr>
            <th><label for="twitter">Twitter</label></th>

            <td>
                <input type="text" name="twitter" id="twitter" value="<?php echo esc_attr( get_the_author_meta( 'twitter', $user->ID ) ); ?>" class="regular-text" /><br />
                <span class="description">Please enter your Twitter Profile URL.</span>
            </td>
        </tr>

    </table>
<?php }


add_action( 'personal_options_update', 'my_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'my_save_extra_profile_fields' );

function my_save_extra_profile_fields( $user_id ) {

    if ( !current_user_can( 'edit_user', $user_id ) )
        return false;
    update_user_meta( $user_id, 'twitter', $_POST['twitter'] );
}
/*-----------------*/





/*
 * Removes wordpress default excerpt brakets from its endings
 */
function theme_excerpt_more( $excerpt ) {
    return str_replace( '[...]', '', $excerpt );
}
add_filter( 'wp_trim_excerpt', 'theme_excerpt_more' );
/*-----------------*/







/*
 * Remove Blog categories from category Feeds
 */
function theme_exclude_category_feed() {
    $exclude_cats = theme_option( THEME_OPTIONS, 'excluded_cats' );
    if ( is_array( $exclude_cats ) ) {
        foreach ( $exclude_cats as $key => $cat ) {
            $exclude_cats[$key] = -$cat;
        }
    }
    if ( is_feed() ) {
        set_query_var( "cat", implode( ",", $exclude_cats ) );
    }
}
add_filter( 'pre_get_posts', 'theme_exclude_category_feed' );
/*-----------------*/







/*
 * Remove Blog categories from category widget
 */
function theme_exclude_category_widget( $cat_args ) {
    $exclude_cats = theme_option( THEME_OPTIONS, 'excluded_cats' );

    if ( is_array( $exclude_cats ) ) {
        $cat_args['exclude'] = implode( ",", $exclude_cats );
    }
    return $cat_args;
}
add_filter( 'widget_categories_args', 'theme_exclude_category_widget' );
/*-----------------*/









/*
 * Removes extra space from widget title
 */
function theme_widget_title_remove_space( $return ) {
    $return = trim( $return );
    if ( '&nbsp;' == $return ) {
        return '';
    }else {
        return $return;
    }
}
add_filter( 'widget_title', 'theme_widget_title_remove_space' );
/*-----------------*/








/*
 * Gives the text widget capability of inserting shortcode.
 */
function theme_widget_text_shortcode( $content ) {
    $content = do_shortcode( $content );
    $new_content = '';
    $pattern_full = '{(\[raw\].*?\[/raw\])}is';
    $pattern_contents = '{\[raw\](.*?)\[/raw\]}is';
    $pieces = preg_split( $pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE );

    foreach ( $pieces as $piece ) {
        if ( preg_match( $pattern_contents, $piece, $matches ) ) {
            $new_content .= $matches[1];
        } else {
            $new_content .= do_shortcode( $piece );
        }
    }

    return $new_content;
}
add_filter( 'widget_text', 'theme_widget_text_shortcode' );
add_filter( 'widget_text', 'do_shortcode' );
/*-----------------*/




/* Blog & Portfolio Pagination */
function theme_blog_pagenavi($before = '', $after = '', $blog_query, $paged) {
    global $wpdb, $wp_query;
    
    if (is_single())
        return;
    
    $pagenavi_options = array(
        'pages_text' => '',
        'current_text' => '%PAGE_NUMBER%',
        'page_text' => '%PAGE_NUMBER%',
        'dotright_text' => __('...','mk_framework'),
        'dotleft_text' => __('...','mk_framework'),
        'num_pages' => 4,
        'always_show' => 0,
        'num_larger_page_numbers' => 3,
        'larger_page_numbers_multiple' => 10,
        'use_pagenavi_css' => 0,
    );
    if(is_archive() || is_search()) {
        $request = $wp_query->request;
    } else {
        $request = $blog_query->request;
    }
    
    $posts_per_page = intval(get_query_var('posts_per_page'));
    global $wp_version;
    if((is_front_page() || is_home() ) && version_compare($wp_version, "3.1", '>=')){//fix wordpress 3.1 paged query 
        $paged = (get_query_var('paged')) ?intval(get_query_var('paged')) : intval(get_query_var('page'));
    }else{
        $paged = intval(get_query_var('paged'));
    }
     if(is_archive() || is_search()) {
       $numposts = $wp_query->found_posts;
        $max_page = intval($wp_query->max_num_pages);
    } else {
        $numposts = $blog_query->found_posts;
        $max_page = intval($blog_query->max_num_pages);
    }
    
    
    if (empty($paged) || $paged == 0)
        $paged = 1;
    $pages_to_show = intval($pagenavi_options['num_pages']);
    $larger_page_to_show = intval($pagenavi_options['num_larger_page_numbers']);
    $larger_page_multiple = intval($pagenavi_options['larger_page_numbers_multiple']);
    $pages_to_show_minus_1 = $pages_to_show - 1;
    $half_page_start = floor($pages_to_show_minus_1 / 2);
    $half_page_end = ceil($pages_to_show_minus_1 / 2);
    $start_page = $paged - $half_page_start;
    
    if ($start_page <= 0)
        $start_page = 1;
    
    $end_page = $paged + $half_page_end;
    if (($end_page - $start_page) != $pages_to_show_minus_1) {
        $end_page = $start_page + $pages_to_show_minus_1;
    }
    
    if ($end_page > $max_page) {
        $start_page = $max_page - $pages_to_show_minus_1;
        $end_page = $max_page;
    }
    
    if ($start_page <= 0)
        $start_page = 1;
    
    $larger_pages_array = array();
    if ($larger_page_multiple)
        for($i = $larger_page_multiple; $i <= $max_page; $i += $larger_page_multiple)
            $larger_pages_array[] = $i;
    
    if ($max_page > 1 || intval($pagenavi_options['always_show'])) {
        $pages_text = str_replace("%CURRENT_PAGE%", number_format_i18n($paged), $pagenavi_options['pages_text']);
        $pages_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pages_text);

        echo '<div class="mk-pagination">' . "\n";
                echo '<div class="mk-pagination-previous">'; 
                previous_posts_link('');
                echo '</div>';
                echo '<div class="mk-pagination-inner">';
                if (! empty($pages_text)) {
                    echo '<span class="pages">' . $pages_text . '</span>';
                }

                $larger_page_start = 0;
                foreach($larger_pages_array as $larger_page) {
                    if ($larger_page < $start_page && $larger_page_start < $larger_page_to_show) {
                        $page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($larger_page), $pagenavi_options['page_text']);
                        echo '<a href="' . esc_url(get_pagenum_link($larger_page)) . '" class="page-number" title="' . $page_text . '">' . $page_text . '</a>';
                        $larger_page_start++;
                    }
                }
                
                for($i = $start_page; $i <= $end_page; $i++) {
                    if ($i == $paged) {
                        $current_page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['current_text']);
                        echo '<span class="current-page">' . $current_page_text . '</span>';
                    } else {
                        $page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['page_text']);
                        echo '<a href="' . esc_url(get_pagenum_link($i)) . '" class="page-number" title="' . $page_text . '">' . $page_text . '</a>';
                    }
                }
                
                $larger_page_end = 0;
                foreach($larger_pages_array as $larger_page) {
                    if ($larger_page > $end_page && $larger_page_end < $larger_page_to_show) {
                        $page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($larger_page), $pagenavi_options['page_text']);
                        echo '<a href="' . esc_url(get_pagenum_link($larger_page)) . '" class="page-number" title="' . $page_text . '">'.$page_text.'</a>';
                        $larger_page_end++;
                    }
                }

                echo '</div>';
        echo '<div class="mk-pagination-next">';
        next_posts_link('', $max_page);
        echo '</div>';
        echo '<div class="mk-total-pages">'.__('page', 'mk_framework').' '.$current_page_text.' of '.$max_page.'</div>';
        echo '</div>' . $after . "\n";
        
    }
}
/*****************************************************/





/**
 * Title         : Aqua Resizer
 * Description   : Resizes WordPress images on the fly
 * Version       : 1.1.7
 * Author        : Syamil MJ
 * Author URI    : http://aquagraphite.com
 * License       : WTFPL - http://sam.zoy.org/wtfpl/
 * Documentation : https://github.com/sy4mil/Aqua-Resizer/
 *
 * @param string  $url    - (required) must be uploaded using wp media uploader
 * @param int     $width  - (required)
 * @param int     $height - (optional)
 * @param bool    $crop   - (optional) default to soft crop
 * @param bool    $single - (optional) returns an array if false
 * @uses  wp_upload_dir()
 * @uses  image_resize_dimensions() | image_resize()
 * @uses  wp_get_image_editor()
 *
 * @return str|array
 */



function theme_image_resize($img_url, $width, $height, $crop = true, $single = false, $upscale = true ) {

    // Validate inputs.
    if ( ! $img_url || ( ! $width && ! $height ) ) return false;

    // Caipt'n, ready to hook.
    if ( true === $upscale ) add_filter( 'image_resize_dimensions', 'aq_upscale', 10, 6 );

    // Define upload path & dir.
    $upload_info = wp_upload_dir();
    $upload_dir = $upload_info['basedir'];
    $upload_url = $upload_info['baseurl'];

    $http_prefix = "http://";
    $https_prefix = "https://";

    /* if the $url scheme differs from $upload_url scheme, make them match 
       if the schemes differe, images don't show up. */
    if(!strncmp($img_url,$https_prefix,strlen($https_prefix))){ //if url begins with https:// make $upload_url begin with https:// as well
        $upload_url = str_replace($http_prefix,$https_prefix,$upload_url);
    }
    elseif(!strncmp($img_url,$http_prefix,strlen($http_prefix))){ //if url begins with http:// make $upload_url begin with http:// as well
        $upload_url = str_replace($https_prefix,$http_prefix,$upload_url);      
    }


    // Check if $img_url is local.
    if ( false === strpos( $img_url, $upload_url ) ) return false;

    // Define path of image.
    $rel_path = str_replace( $upload_url, '', $img_url );
    $img_path = $upload_dir . $rel_path;

    // Check if img path exists, and is an image indeed.
    if ( ! file_exists( $img_path ) or ! getimagesize( $img_path ) ) return false;

    // Get image info.
    $info = pathinfo( $img_path );
    $ext = $info['extension'];
    list( $orig_w, $orig_h ) = getimagesize( $img_path );

    // Get image size after cropping.
    $dims = image_resize_dimensions( $orig_w, $orig_h, $width, $height, $crop );
    $dst_w = $dims[4];
    $dst_h = $dims[5];

    // Return the original image only if it exactly fits the needed measures.
    if ( ! $dims && ( ( ( null === $height && $orig_w == $width ) xor ( null === $width && $orig_h == $height ) ) xor ( $height == $orig_h && $width == $orig_w ) ) ) {
        $img_url = $img_url;
        $dst_w = $orig_w;
        $dst_h = $orig_h;
    } else {
        // Use this to check if cropped image already exists, so we can return that instead.
        $suffix = "{$dst_w}x{$dst_h}";
        $dst_rel_path = str_replace( '.' . $ext, '', $rel_path );
        $destfilename = "{$upload_dir}{$dst_rel_path}-{$suffix}.{$ext}";

        if ( ! $dims || ( true == $crop && false == $upscale && ( $dst_w < $width || $dst_h < $height ) ) ) {
            // Can't resize, so return false saying that the action to do could not be processed as planned.
            return false;
        }
        // Else check if cache exists.
        elseif ( file_exists( $destfilename ) && getimagesize( $destfilename ) ) {
            $img_url = "{$upload_url}{$dst_rel_path}-{$suffix}.{$ext}";
        }
        // Else, we resize the image and return the new resized image url.
        else {

            // Note: This pre-3.5 fallback check will edited out in subsequent version.
            if ( function_exists( 'wp_get_image_editor' ) ) {

                $editor = wp_get_image_editor( $img_path );

                if ( is_wp_error( $editor ) || is_wp_error( $editor->resize( $width, $height, $crop ) ) )
                    return false;

                $resized_file = $editor->save();

                if ( ! is_wp_error( $resized_file ) ) {
                    $resized_rel_path = str_replace( $upload_dir, '', $resized_file['path'] );
                    $img_url = $upload_url . $resized_rel_path;
                } else {
                    return false;
                }

            } else {

                $resized_img_path = image_resize( $img_path, $width, $height, $crop ); // Fallback foo.
                if ( ! is_wp_error( $resized_img_path ) ) {
                    $resized_rel_path = str_replace( $upload_dir, '', $resized_img_path );
                    $img_url = $upload_url . $resized_rel_path;
                } else {
                    return false;
                }

            }

        }
    }

    // Okay, leave the ship.
    if ( true === $upscale ) remove_filter( 'image_resize_dimensions', 'aq_upscale' );

        // array return.
        $image = array (
            'url' => $img_url,
            'width' => $dst_w,
            'height' => $dst_h
        );

    return $image;
}


function aq_upscale( $default, $orig_w, $orig_h, $dest_w, $dest_h, $crop ) {
    if ( ! $crop ) return null; // Let the wordpress default function handle this.

    // Here is the point we allow to use larger image size than the original one.
    $aspect_ratio = $orig_w / $orig_h;
    $new_w = $dest_w;
    $new_h = $dest_h;

    if ( ! $new_w ) {
        $new_w = intval( $new_h * $aspect_ratio );
    }

    if ( ! $new_h ) {
        $new_h = intval( $new_w / $aspect_ratio );
    }

    $size_ratio = max( $new_w / $orig_w, $new_h / $orig_h );

    $crop_w = round( $new_w / $size_ratio );
    $crop_h = round( $new_h / $size_ratio );

    $s_x = floor( ( $orig_w - $crop_w ) / 2 );
    $s_y = floor( ( $orig_h - $crop_h ) / 2 );

    return array( 0, 0, (int) $s_x, (int) $s_y, (int) $new_w, (int) $new_h, (int) $crop_w, (int) $crop_h );
}

