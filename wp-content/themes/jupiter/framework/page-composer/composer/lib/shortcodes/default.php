<?php
/**
 */


function mk_get_fontfamily( $element_name, $id, $font_family, $font_type ) {
    $output = '';
    if ( $font_type == 'google' ) {
        if ( !function_exists( "my_strstr" ) ) {
            function my_strstr( $haystack, $needle, $before_needle = false ) {
                if ( !$before_needle ) return strstr( $haystack, $needle );
                else return substr( $haystack, 0, strpos( $haystack, $needle ) );
            }
        }
        wp_enqueue_style( $font_family, 'http://fonts.googleapis.com/css?family=' .$font_family , false, false, 'all' );
        $format_name = strpos( $font_family, ':' );
        if ( $format_name !== false ) {
            $google_font =  my_strstr( str_replace( '+', ' ', $font_family ), ':', true );
        } else {
            $google_font = str_replace( '+', ' ', $font_family );
        }
        $output .= '<style>'.$element_name.$id.' {font-family: "'.$google_font.'"}</style>';

    } else if ( $font_type == 'fontface' ) {

            $stylesheet = FONTFACE_DIR.'/fontface_stylesheet.css';
            $font_dir = FONTFACE_URI;
            if ( file_exists( $stylesheet ) ) {
                $file_content = file_get_contents( $stylesheet );
                if ( preg_match( "/@font-face\s*{[^}]*?font-family\s*:\s*('|\")$font_family\\1.*?}/is", $file_content, $match ) ) {
                    $fontface_style = preg_replace( "/url\s*\(\s*['|\"]\s*/is", "\\0$font_dir/", $match[0] )."\n";
                }
                $output = "\n<style>" . $fontface_style ."\n";
                $output .= $element_name.$id.' {font-family: "'.$font_family.'"}</style>';
            }

        } else if ( $font_type == 'safefont' ) {
            $output .= '<style>'.$element_name.$id.' {font-family: '.$font_family.' !important}</style>';
        }

    return $output;
}






class WPBakeryShortCode_VC_Column_text extends WPBakeryShortCode {

    public function content( $atts, $content = null ) {

        $el_class = $width = $el_position = '';

        extract( shortcode_atts( array(
                    'el_class' => '',
                    'title' => '',
                    'disable_pattern' => '',
                    'margin_bottom' => '',
                    'width' => '1/1',
                    'align' => 'left',
                    'animation' => '',
                    'el_position' => '',
                ), $atts ) );

        $output = '';

        $id = mt_rand( 99, 999 );
        $output = $animation_css ='';
        $disable_pattern = !empty( $disable_pattern ) ? $disable_pattern : 'true';
        $margin_style = '';
        if ( $margin_bottom != '' ) {
            $margin_style = ' margin-bottom:'.$margin_bottom.'px;';
        }
        $fancy_style = '';
        if ( $align == 'center' ) {
            $fancy_style = 'style="padding:0 5px;"';
        } else if ( $align == 'right' ) {
                $fancy_style = 'style="padding:0 0 0 5px;"';
            }

        $width = wpb_translateColumnWidthToSpan( $width );
        $el_position_css = '';
        if ( $el_position != '' ) {
            $el_position_css = $el_position.'-column';
        }
        if($animation != '') {
            $animation_css = ' mk-animate-element ' . $animation . ' ';
        }
        $output .= '<div id="mk-text-block-'.$id.'"  style="'.$margin_style.'text-align: '.$align.';" class="mk-text-block  '.$animation_css.$el_class.' '.$el_position_css.' '.$width.'">';
        if ( !empty( $title ) ) {
            $output .= '<h3 class="mk-shortcode mk-fancy-title pattern-style mk-shortcode-heading pattern-'.$disable_pattern.'"><span '.$fancy_style.'>'.$title.'</span></h3>';
        }
        $output .= wpb_js_remove_wpautop( $content );
        $output .= '<div class="clearboth"></div></div> ';

        return $output;
    }
}




class WPBakeryShortCode_mk_table extends WPBakeryShortCode {

    public function content( $atts, $content = null ) {

        $el_class = $width = $el_position = '';

        extract( shortcode_atts( array(
                    'el_class' => '',
                    'title' => '',
                    'style' => 'style1',
                    'width' => '1/1',
                    'el_position' => '',
                ), $atts ) );

        $output = '';

        $width = wpb_translateColumnWidthToSpan( $width );
        $el_position_css = '';
        if ( $el_position != '' ) {
            $el_position_css = $el_position.'-column';
        }
        $output .= "\n\t".'<div class=" '.$el_class.' '.$el_position_css.' '.$width.'"><div class="mk-fancy-table mk-shortcode table-'.$style.'">';
        if ( !empty( $title ) ) {
            $output .= '<h3 class="mk-shortcode mk-fancy-title pattern-style mk-shortcode-heading"><span>'.$title.'</span></h3>';
        }
        $output .= "\n\t\t\t".wpb_js_remove_wpautop( $content );
        $output .= "\n\t".'</div></div>';

        return $output;
    }
}



class WPBakeryShortCode_mk_icon_box extends WPBakeryShortCode {

    public function content( $atts, $content = null ) {

        $el_class = $width = $el_position = '';

        extract( shortcode_atts( array(
                    'el_class' => '',
                    'title' => '',
                    'style' => 'simple_minimal',
                    'icon' => '',
                    'icon_color' => '',
                    'icon_circle_color' => '', // for boxed and simple minimal style
                    'icon_circle_border_color' => '', // for boxed and simple minimal style
                    'box_blur' => '', // for boxed style
                    'circled' => 'false', // for simple minimal style
                    'icon_location' => 'left', // for simple ultimate and boxed style
                    'icon_size' => 'medium', // for simple ultimate style
                    'read_more_txt' => '',
                    'read_more_url' => '',
                    'text_size' => '18',
                    'font_weight' => 'inherit',
                    'margin' => '30',
                    'txt_color' => '',
                    'title_color' => '',
                    'animation' => '',
                    'width' => '1/1',
                    'el_position' => '',
                ), $atts ) );

        $output = '';
        $width = wpb_translateColumnWidthToSpan( $width );
        $el_position_css = $animation_css = $box_blur_css = $box_blur_wrapper_css = '';
        if ( $el_position != '' ) {
            $el_position_css = $el_position.'-column';
        }
        $id = mt_rand(99,999);
        $style_css = '<style type="text/css">';
        $style_css .= !empty($txt_color) ? ('#box-icon-'.$id.' p {color:'.$txt_color.';}') : '';
        if(empty($read_more_url)) {
            $style_css .= !empty($title_color) ? ('#box-icon-'.$id.' h4 {color:'.$title_color.';}') : '';
        } else {
            $style_css .= !empty($title_color) ? ('#box-icon-'.$id.' h4 a{color:'.$title_color.';}') : '';
        }
        $style_css .= '</style>';
        if($box_blur == 'true') {
                $box_blur_css = 'blured-box';
                $box_blur_wrapper_css = 'blured-box-wrapper';   
            }
        if($animation != '') {
            $animation_css = ' mk-animate-element ' . $animation . ' ';
        }
        $output .= '<div id="box-icon-'.$id.'" style="margin-bottom:'.$margin.'px;" class="'.$el_class.' '.$box_blur_wrapper_css.' '.$el_position_css.' '.$width.' '.$style.'-style mk-box-icon">';
        if ( $style == "simple_minimal" ) {
            if ( $circled == 'true' ) {
                $border_css =  !empty($icon_circle_border_color) ? ('border:1px solid '.$icon_circle_border_color.';') : '';
                $output .= '<h4 style="font-size:'.$text_size.'px;font-weight:'.$font_weight.';"><i class="mk-'.$icon.$animation_css.' circled-icon mk-main-ico" style="'.$border_css.'color:'.$icon_color.';background-color:'.$icon_circle_color.'"></i>';
                $output .= !empty($read_more_url) ? '<a href="'.$read_more_url.'">'.$title.'</a>' : $title;
                $output .= '</h4>';
            }   else {
                $output .= '<h4 style="font-size:'.$text_size.'px;font-weight:'.$font_weight.';"><i style="color:'.$icon_color.'" class="mk-'.$icon.$animation_css.' mk-main-ico"></i>';
                $output .= !empty($read_more_url) ? '<a href="'.$read_more_url.'">'.$title.'</a>' : $title;
                $output .= '</h4>';
            }

            $output .= wpb_js_remove_wpautop( $content );
            if ( $read_more_txt ) {
                $output .= '<div class="clearboth"></div><a class="icon-box-readmore" href="'.$read_more_url.'">'.$read_more_txt.'<i class="mk-icon-caret-right"></i></a>';
            }

        } else if( $style == "boxed" ) {
            
            $output .= '<div class="icon-box-boxed '.$box_blur_css.' '.$icon_location.'">';
            $border_css =  !empty($icon_circle_border_color) ? ('border:1px solid '.$icon_circle_border_color.';') : '';
            if(!empty($icon)) {
                $output .= '<i style="'.$border_css.'background-color:'.$icon_circle_color.';color:'.$icon_color.';" class="mk-'.$icon.$animation_css.' mk-main-ico"></i>';
            }
            $output .= '<h4 style="font-size:'.$text_size.'px;font-weight:'.$font_weight.';">';
            $output .= !empty($read_more_url) ? '<a href="'.$read_more_url.'">'.$title.'</a>' : $title;
            $output .= '</h4>';
            $output .= wpb_js_remove_wpautop( $content );
            if ( $read_more_txt ) {
                $output .= '<div class="clearboth"></div><a class="icon-box-readmore" href="'.$read_more_url.'">'.$read_more_txt.'<i class="mk-icon-caret-right"></i></a>';
            }
            $output .= '<div class="clearboth"></div></div>';
            

    } else if( $style == "simple_ultimate" ) {
            $output .= '<div class="'.$icon_location.'-side">';
            if(!empty($icon)) {
                $output .= '<i style="color:'.$icon_color.';" class="mk-'.$icon.$animation_css.' '.$icon_size.' mk-main-ico"></i>';
            }    
            $output .= '<div class="box-detail-wrapper '.$icon_size.'-size">';
            $output .= '<h4 style="font-size:'.$text_size.'px;font-weight:'.$font_weight.';">';
            $output .= !empty($read_more_url) ? '<a href="'.$read_more_url.'">'.$title.'</a>' : $title;
            $output .= '</h4>';
            $output .= wpb_js_remove_wpautop( $content );
            if ( $read_more_txt ) {
                $output .= '<div class="clearboth"></div><a class="icon-box-readmore" href="'.$read_more_url.'">'.$read_more_txt.'<i class="mk-icon-caret-right"></i></a>';
            }
            $output .= '</div><div class="clearboth"></div></div>';
        }
        $output .= '</div>' . $style_css;

        return $output;
    }
}



class WPBakeryShortCode_mk_mini_callout extends WPBakeryShortCode {

    public function content( $atts, $content = null ) {

        $el_class = $width = $el_position = '';

        extract( shortcode_atts( array(
                    'el_class' => '',
                    'title' => '',
                    'button_text' => '',
                    'button_url' => '',
                    'width' => '1/1',
                    'el_position' => '',
                ), $atts ) );

        $output = '';

        $width = wpb_translateColumnWidthToSpan( $width );
        $el_position_css = '';
        if ( $el_position != '' ) {
            $el_position_css = $el_position.'-column';
        }
        $output .= '<div class=" '.$el_class.' '.$el_position_css.' '.$width.'">';
        $output .= '<div class="mk-mini-callout">';
        $output .= '<span class="callout-title">'.$title.'</span>';
        $output .= '<span class="callout-desc">'.strip_tags( $content ) .'</span>';
        if ( $button_text ) {
            $output .= '<a href="'.$button_url.'">'.$button_text.'<i class="mk-icon-caret-right"></i></a>';
        }
        $output .= '</div>';
        $output .= '</div>';

        return $output;
    }
}


class WPBakeryShortCode_mk_custom_sidebar extends WPBakeryShortCode {

    public function content( $atts, $content = null ) {

        $el_class = $width = $el_position = '';

        extract( shortcode_atts( array(
                    'el_class' => '',
                    'sidebar' => '',
                    'width' => '1/1',
                    'el_position' => '',
                ), $atts ) );

        $output = '';

        $width = wpb_translateColumnWidthToSpan( $width );
        $el_position_css = '';
        if ( $el_position != '' ) {
            $el_position_css = $el_position.'-column';
        }
        $output .= '<div class=" '.$el_class.' '.$el_position_css.' '.$width.'">';
        $output .= '<aside id="mk-sidebar"><div class="sidebar-wrapper" style="padding:0;">';
        ob_start();
        dynamic_sidebar( $sidebar );
        $output .= ob_get_contents();
        ob_end_clean();
        $output .= '</div></aside>';
        $output .= '</div>';

        return $output;
    }
}






class WPBakeryShortCode_mk_social_networks extends WPBakeryShortCode {

    public function content( $atts, $content = null ) {

        $el_class ='';

        extract( shortcode_atts( array(
                    'el_class' => '',
                    'size' => 'medium',
                    'style' => '',
                    'align' => 'none',
                    'margin' => '',
                    'width' => '1/1',
                    'el_position' => '',
                    'icon_color' => '#ccc',
                    'facebook' => "",
                    'twitter' => "",
                    'rss' => "",
                    'dribbble' => "",
                    'digg' => "",
                    'pinterest' => "",
                    'flickr' => "",
                    'google_plus' => "",
                    'linkedin' => "",
                    'blogger' => "",
                    'youtube' => "",
                    'last_fm' => "",
                    'live_journal' => "",
                    'stumble_upon' => "",
                    'tumblr' => "",
                    'vimeo' => "",
                    'wordpress' => "",
                    'yelp' => "",
                    'reddit' => "",
                ), $atts ) );
        $id = mt_rand( 99, 999 );
        switch ( $style ) {
        case 'rounded' :
            $icon_style = 'socialico-square-';
            break;
        case 'simple' :
            $icon_style = 'mk-social-';
            break;
        case 'circle' :
            $icon_style = 'mk-socialci-';
            break;
        default :
            $icon_style = 'mk-socialci-';
        }

        $output = '';
        $width = wpb_translateColumnWidthToSpan( $width );
        $el_position_css = '';
        if ( $el_position != '' ) {
            $el_position_css = $el_position.'-column';
        }
        $output .= '<div class=" '.$el_class.' '.$el_position_css.' '.$width.'">';
        $output .= '<div id="social-networks-'.$id.'" class="mk-social-network-shortcode mk-shortcode social-align-'.$align.' '.$size.' '.$el_class.'">';
        $output .= '<ul>';
        $output .= !empty( $facebook )  ? '<li><a style="margin: '.$margin.'px;" target="_blank" class="facebook-hover" href="'.$facebook.'"><i style="color:'.$icon_color.'" class="'.$icon_style.'facebook"></i></a></li>' : '';
        $output .= !empty( $twitter )  ? '<li><a style="margin: '.$margin.'px;" target="_blank" class="twitter-hover" href="'.$twitter.'"><i style="color:'.$icon_color.'" class="'.$icon_style.'twitter"></i></a></li>' : '';
        $output .= !empty( $rss )  ? '<li><a style="margin: '.$margin.'px;" target="_blank" class="rss-hover" href="'.$rss.'"><i style="color:'.$icon_color.'" class="'.$icon_style.'rss"></i></a></li>' : '';
        $output .= !empty( $dribbble )  ? '<li><a style="margin: '.$margin.'px;" target="_blank" class="dribbble-hover" href="'.$dribbble.'"><i style="color:'.$icon_color.'" class="'.$icon_style.'dribbble"></i></a></li>' : '';
        $output .= !empty( $digg )  ? '<li><a style="margin: '.$margin.'px;" target="_blank" class="digg-hover" href="'.$digg.'"><i style="color:'.$icon_color.'" class="'.$icon_style.'digg"></i></a></li>' : '';
        $output .= !empty( $pinterest )  ? '<li><a style="margin: '.$margin.'px;" target="_blank" class="pinterest-hover" href="'.$pinterest.'"><i style="color:'.$icon_color.'" class="'.$icon_style.'pinterest"></i></a></li>' : '';
        $output .= !empty( $flickr )  ? '<li><a style="margin: '.$margin.'px;" target="_blank" class="flickr-hover" href="'.$flickr.'"><i style="color:'.$icon_color.'" class="'.$icon_style.'flickr"></i></a></li>' : '';
        $output .= !empty( $google_plus )  ? '<li><a style="margin: '.$margin.'px;" target="_blank" class="googleplus-hover" href="'.$google_plus.'"><i style="color:'.$icon_color.'" class="'.$icon_style.'googleplus"></i></a></li>' : '';
        $output .= !empty( $linkedin )  ? '<li><a style="margin: '.$margin.'px;" target="_blank" class="linkedin-hover" href="'.$linkedin.'"><i style="color:'.$icon_color.'" class="'.$icon_style.'linkedin"></i></a></li>' : '';
        $output .= !empty( $blogger )  ? '<li><a style="margin: '.$margin.'px;" target="_blank" class="blogger-hover" href="'.$blogger.'"><i style="color:'.$icon_color.'" class="'.$icon_style.'blogger"></i></a></li>' : '';
        $output .= !empty( $youtube )  ? '<li><a style="margin: '.$margin.'px;" target="_blank" class="youtube-hover" href="'.$youtube.'"><i style="color:'.$icon_color.'" class="'.$icon_style.'youtube"></i></a></li>' : '';
        $output .= !empty( $last_fm )  ? '<li><a style="margin: '.$margin.'px;" target="_blank" class="lastfm-hover" href="'.$last_fm.'"><i style="color:'.$icon_color.'" class="'.$icon_style.'lastfm"></i></a></li>' : '';
        $output .= !empty( $stumble_upon )  ? '<li><a style="margin: '.$margin.'px;" target="_blank" class="stumbleupon-hover" href="'.$stumble_upon.'"><i style="color:'.$icon_color.'" class="'.$icon_style.'stumbleupon"></i></a></li>' : '';
        $output .= !empty( $tumblr )  ? '<li><a style="margin: '.$margin.'px;" target="_blank" class="tumblr-hover" href="'.$tumblr.'"><i style="color:'.$icon_color.'" class="'.$icon_style.'tumblr"></i></a></li>' : '';
        $output .= !empty( $vimeo )  ? '<li><a style="margin: '.$margin.'px;" target="_blank" class="vimeo-hover" href="'.$vimeo.'"><i style="color:'.$icon_color.'" class="'.$icon_style.'vimeo"></i></a></li>' : '';
        $output .= !empty( $wordpress )  ? '<li><a style="margin: '.$margin.'px;" target="_blank" class="wordpress-hover" href="'.$wordpress.'"><i style="color:'.$icon_color.'" class="'.$icon_style.'wordpress"></i></a></li>' : '';
        $output .= !empty( $yelp )  ? '<li><a style="margin: '.$margin.'px;" target="_blank" class="yelp-hover" href="'.$yelp.'"><i style="color:'.$icon_color.'" class="'.$icon_style.'yelp"></i></a></li>' : '';
        $output .= !empty( $reddit )  ? '<li><a style="margin: '.$margin.'px;" target="_blank" class="reddit-hover" href="'.$reddit.'"><i style="color:'.$icon_color.'" class="'.$icon_style.'reddit"></i></a></li>' : '';
        $output .= '</ul>';
        $output .= '</div>';
        $output .= '</div>';
        return $output;
    }
}

class WPBakeryShortCode_mk_skype extends WPBakeryShortCode {
    protected function content( $atts, $content = null ) {
        extract( shortcode_atts( array(
                    'title' => '',
                    'number' => '',
                    'display_number' => '',
                    "el_class" => '',
                ), $atts ) );

        return '<a href="skype:'.$number.'?call" class="mk-skype-call mk-shortcode '.$el_class.'"><i class="mk-social-skype"></i>' . $display_number . '</a>';

    }
}
/*****************************************************/





class WPBakeryShortCode_mk_font_icons extends WPBakeryShortCode {

    public function content( $atts, $content = null ) {

        extract( shortcode_atts( array(
                    'size' => 'medium',
                    'icon' => '',
                    'padding_horizental' => 4,
                    'padding_vertical' => 4,
                    'color' => theme_option( THEME_OPTIONS, 'skin_color' ),
                    'circle' => 'false',
                    'circle_color' => '',
                    'align' => '',
                    'animation' => '',
                    'link' => '',
                    'el_class' => '',
                ), $atts ) );

        $color = !empty( $color ) ? ( 'color:' . $color .';' ) : '';

        $circle_class =  $circle_style = $animation_css = '';
        if ( $circle == 'true' ) {
            $circle_class = 'circle-enabled';
            $circle_style = 'background-color:'.$circle_color.';';
        }
        if($animation != '') {
            $animation_css = ' mk-animate-element ' . $animation . ' ';
        }

        $output = '<span class="mk-font-icons mk-shortcode icon-align-'.$align.' '.$animation_css.$el_class.'">';
        if ( $link ) {
            $output .= '<a href="'.$link.'">';
        }
        $output .= '<i style="'.$color.'margin:'.$padding_vertical.'px '.$padding_horizental.'px;'.$circle_style.'" class="mk-'.$icon.' '.$circle_class.' mk-size-'.$size.'"></i>';

        if ( $link ) {
            $output .= '</a>';
        }
        $output .= '</span>';

        return $output;
    }
}



/*
BLOCKQUOTE SHORTCODE
*/
class WPBakeryShortCode_mk_blockquote extends WPBakeryShortCode {

    protected function content( $atts, $content = null ) {
        extract( shortcode_atts( array(
                    'el_class' => '',
                    "style" => 'quote-style', //style1, style2
                    'width' => '1/1',
                    'el_position' => '',
                    "text_size" => '12',
                    "align" => 'left',
                    "font_family" => '',
                    'animation' => '',
                    "font_type" => '',
                ), $atts ) );
        $id = mt_rand( 99, 999 );
        $output = $animation_css ='';
        $output .= mk_get_fontfamily( "#blockquote-", $id, $font_family, $font_type );
        $width = wpb_translateColumnWidthToSpan( $width );
        $el_position_css = '';
        if ( $el_position != '' ) {
            $el_position_css = $el_position.'-column';
        }
        if($animation != '') {
            $animation_css = ' mk-animate-element ' . $animation . ' ';
        }
        $output .= '<div class="'.$width.' '.$animation_css.$el_position_css.'">';
        $output .= '<div style="font-size: '.$text_size.'px;" id="blockquote-'.$id.'" class="mk-shortcode mk-blockquote '.$style.' '.$el_class.'">' .wpb_js_remove_wpautop( strip_tags( $content ) ). '</div></div>';

        return $output;
    }
}




/*
MILESTONE SHORTCODE
*/
class WPBakeryShortCode_mk_milestone extends WPBakeryShortCode {

    protected function content( $atts, $content = null ) {
        extract( shortcode_atts( array(
                    "icon" => '',
                    "icon_size" => 'medium',
                    "icon_color" => '',
                    "start" => 0,
                    "stop" => 100,
                    "speed" => 2000,
                    "prefix" => '',
                    "suffix" => '',
                    "text" => '',
                    "text_color" => '',
                    'width' => '1/1',
                    'el_position' => '',
                    'el_class' => '',
                ), $atts ) );
        $id = mt_rand( 99, 999 );
        $output = '';
        $width = wpb_translateColumnWidthToSpan( $width );
        $el_position_css = '';
        if ( $el_position != '' ) {
            $el_position_css = $el_position.'-column';
        }

        $output .= '<div class="'.$width.' '.$el_position_css.' '.$el_class.'">';
        $output .= '<div class="mk-shortcode mk-milestone milestone-'.$icon_size.'" >';
        $output .= '<i style="color:'.$icon_color.'" class="mk-'.$icon.'"></i>';
        $output .= '<div class="milestone-top">';
        $output .= !empty($prefix) ? ('<span class="milestone-prefix">'.$prefix.'</span>') : '';
        $output .= '<span class="milestone-number" data-speed="'.$speed.'" data-stop="'.$stop.'">'.$start.'</span>';
        $output .= !empty($suffix) ? ('<span class="milestone-suffix">'.$suffix.'</span>') : '';
        $output .= '<div style="color:'.$text_color.'" class="milestone-text">'.$text.'</div>';
        $output .= '</div>';
        $output .= '<div class="clearboth"></div>';
        $output .= '</div>';
        $output .= '</div>';

        return $output;
    }
}



/*
DROP CAPS SHORTCODE
*/
class WPBakeryShortCode_mk_dropcaps extends WPBakeryShortCode {
    protected function content( $atts, $content = null ) {
        extract( shortcode_atts( array(
                    'style' => 'simple-style',
                    'el_class' => '',
                ), $atts ) );


        return '<span class="mk-dropcaps mk-shortcode '.$style.' '.$el_class.'">'.do_shortcode( strip_tags( $content ) ).'</span>';
    }
}
/*****************************************************/





/*
HIGHLIGHT SHORTCODE
*/
class WPBakeryShortCode_mk_highlight extends WPBakeryShortCode {
    protected function content( $atts, $content = null ) {
        extract( shortcode_atts( array(
                    'text' => '',
                    'bg_color' => '',
                    'text_color' => '',
                    'el_class' => '',
                ), $atts ) );


        $bg_color = !empty( $bg_color ) ? $bg_color : theme_option( THEME_OPTIONS, 'skin_color' );
        $text_color = !empty( $text_color ) ? $text_color : "#fff";

        return '<span style="background-color:'.$bg_color.';color:'.$text_color.'" class="mk-highlight mk-shortcode '.$el_class.'">'.$text.'</span>';

    }
}
/*****************************************************/





/*
TOOLTIP SHORTCODE
*/
class WPBakeryShortCode_mk_tooltip extends WPBakeryShortCode {
    protected function content( $atts, $content = null ) {
        extract( shortcode_atts( array(
                    'text' => '',
                    'tooltip_text' => '',
                    'href' => '#',
                    'el_class' => '',
                ), $atts ) );


        $bg_color = !empty( $bg_color ) ? $bg_color : theme_option( THEME_OPTIONS, 'skin_color' );
        $text_color = !empty( $text_color ) ? $text_color : "#fff";

        return '<span class="mk-tooltip mk-shortcode '.$el_class.'"><a href="'.$href.'" class="tooltip-init">'.$text.'</a><span class="tooltip-text">'.$tooltip_text.'</span></span>';

    }
}
/*****************************************************/




/*
SKILL METER SHORTCODE
*/
class WPBakeryShortCode_mk_skill_meter extends WPBakeryShortCode {
    protected function content( $atts, $content = null ) {
        extract( shortcode_atts( array(
                    'title' => '',
                    'color' => theme_option( THEME_OPTIONS, 'skin_color' ),
                    'width' => '1/1',
                    'el_position' => '',
                    'percent' => 50,
                    'el_class' => '',
                ), $atts ) );

        $width = wpb_translateColumnWidthToSpan( $width );
        $el_position_css = '';
        if ( $el_position != '' ) {
            $el_position_css = $el_position.'-column';
        }

        return '<div class="'.$width.' '.$el_position_css.'"><div class="mk-skill-meter mk-shortcode '.$el_class.'">
                    <div class="mk-skill-meter-title">'.$title.'</div>
                    <div class="mk-progress-bar">
                        <span class="progress-outer" data-width="'.$percent.'" style="background-color:'.$color.';">
                            <span class="progress-inner"></span>
                        </span>
                    </div>
                    <div class="clearboth"></div>
                    </div></div>';

    }
}
/*****************************************************/



/*
SKILL METER CHART SHORTCODE
*/
class WPBakeryShortCode_mk_skill_meter_chart extends WPBakeryShortCode {
    protected function content( $atts, $content = null ) {
        extract( shortcode_atts( array(
                    'title' => '',
                    'percent_1' => false,
                    'name_1' => false,
                    'color_1' => false,
                    'percent_2' => false,
                    'name_2' => false,
                    'color_2' => false,
                    'percent_3' => false,
                    'name_3' => false,
                    'color_3' => false,
                    'percent_4' => false,
                    'name_4' => false,
                    'color_4' => false,
                    'percent_5' => false,
                    'color_5' => false,
                    'name_5' => false,
                    'percent_6' => false,
                    'name_6' => false,
                    'color_6' => false,
                    'percent_7' => false,
                    'name_7' => false,
                    'color_7' => false,
                    'center_color' => '',
                    'default_text' => 'Skills',
                    'default_text_color' => '#fff',
                    'width' => '1/1',
                    'el_position' => '',
                    'animation' => '',                 
                    'el_class' => '',
                ), $atts ) );

        $width = wpb_translateColumnWidthToSpan( $width );
        $el_position_css = $output = $animation_css = '';
        if ( $el_position != '' ) {
            $el_position_css = $el_position.'-column';
        }
        $id = mt_rand(99,999);
        wp_enqueue_script( 'jquery-raphael');

        if($animation != '') {
            $animation_css = ' mk-animate-element ' . $animation . ' ';
        } 


        $output .= '<div class="'.$width.' '.$el_position_css.'"><div class="mk-skill-chart mk-shortcode '.$animation_css.$el_class.'">';
        $f = 0;
        for($i = 1; $i <= 7; $i++) {
            if(!empty(${'name_'.$i}) && ${'percent_'.$i} != 0) {
                $f++;
               $output .= '<div class="mk-meter-arch">
                               <input type="hidden" class="name" value="'.${'name_'.$i}.'" />
                               <input type="hidden" class="percent" value="'.${'percent_'.$i}.'" />
                               <input type="hidden" class="color" value="'.${'color_'.$i}.'" />
                           </div>';

            }
        }
        $diag_dimension = ($f * 56) + 190;
        $output .= '<div id="mk_skill_diagram" data-dimension="'.$diag_dimension.'" data-circle-color="'.$center_color.'" data-default-text-color="'.$default_text_color.'" data-default-text="'.$default_text.'"></div></div></div>



        ';
        return $output;

    }
}
/*****************************************************/



/*
SKILL METER SHORTCODE
*/
class WPBakeryShortCode_mk_chart extends WPBakeryShortCode {
    protected function content( $atts, $content = null ) {
        extract( shortcode_atts( array(
                    'desc' => '',
                    'percent' => '',
                    'bar_color' => '',
                    'track_color' => '',
                    'line_width' => '',
                    'bar_size' => '',
                    'content' => '',
                    'content_type' => '',
                    'icon' => '',
                    'custom_text' => '',
                    'el_class' => '',
                    'width'=> '1/1',
                    'animation' => '',
                    'el_position' => '',
                ), $atts ) );
        wp_enqueue_script( 'jquery-easychart' );

        $width = wpb_translateColumnWidthToSpan( $width );
        $el_position_css = $animation_css = '';
        if ( $el_position != '' ) {
            $el_position_css = $el_position.'-column';
        }
        $animation_css = '';
        if($animation != '') {
            $animation_css = ' mk-animate-element ' . $animation . ' ';
        } 

        $output = '<div class="'.$width.' '.$animation_css.$el_position_css.'">';
        $output .= '<div class="mk-chart" style="width:'.$bar_size.'px;height:'.$bar_size.'px;line-height:'.$bar_size.'px" data-percent="'.$percent.'" data-barColor="'.$bar_color.'" data-trackColor="'.$track_color.'" data-lineWidth="'.$line_width.'" data-barSize="'.$bar_size.'">';
        if ( $content_type == 'icon' ) {
            $icon_size = floor( $bar_size/3 );
            $output .= '<i style="line-height:'.$bar_size.'px; font-size:'.$icon_size.'px" class="mk-'.$icon.'"></i>';
        } elseif ( $content_type == 'custom_text' ) {
            $output .= '<span class="chart-custom-text">'.$custom_text.'</span>';
        } else {
            $output .= '<div class="chart-percent"><span>'.$percent.'</span>%</div>';
        }
        $output .= '</div>';
        $output .= '<div class="mk-chart-desc">'.$desc.'</div>';
        $output .= '</div>';
        return $output;
    }
}
/*****************************************************/






/*
PROCESS STEPS SHORTCODE
*/
class WPBakeryShortCode_mk_steps extends WPBakeryShortCode {
    protected function content( $atts, $content = null ) {
        extract( shortcode_atts( array(
                    'title' => '',
                    'step' => 4,
                    'hover_color' => theme_option( THEME_OPTIONS, 'skin_color' ),
                    'icon_1' => '',
                    'title_1' => '',
                    'desc_1' => '',
                    'url_1' => '',

                    'icon_2' => '',
                    'title_2' => '',
                    'desc_2' => '',
                    'url_2' => '',

                    'icon_3' => '',
                    'title_3' => '',
                    'desc_3' => '',
                    'url_3' => '',

                    'icon_4' => '',
                    'title_4' => '',
                    'desc_4' => '',
                    'url_4' => '',

                    'icon_5' => '',
                    'title_5' => '',
                    'desc_5' => '',
                    'url_5' => '',

                    'el_class' => '',
                    'width' => '1/1',
                    'animation' => '',
                    'el_position' => '',
                ), $atts ) );

        $width = wpb_translateColumnWidthToSpan( $width );
        $el_position_css = $animation_css = $output = '';
        if ( $el_position != '' ) {
            $el_position_css = $el_position.'-column';
        }
        $id = mt_rand( 99, 999 );

        if($animation != '') {
            $animation_css = ' mk-animate-element ' . $animation . ' ';
        } 
        $output .= '<div class="'.$width.' '.$el_position_css.'">';
        $output .= '<div id="mk-process-'.$id.'" class="mk-process-steps mk-shortcode process-steps-'.$step.' '.$el_class.'">';
        if ( !empty( $title ) ) {
            $output .= '<h3 class="mk-shortcode mk-fancy-title pattern-style mk-shortcode-heading" style="text-align:left;"><span>'.$title.'</span></h3>';
        }
        $output .= '<ul>' . "\n";
       for($i=1; $i <= $step; $i++) {
        $output .= '<li><span class="mk-process-icon'.$animation_css.'"><i class="mk-'.${'icon_'.$i}.'"></i></span>';
        $output .= '<div class="mk-process-detail">';
        $output .= !empty(${'url_'.$i}) ? ('<h3><a href="'.${'url_'.$i}.'">'.${'title_'.$i}.'</a></h3>') : ('<h3>'.${'title_'.$i}.'</h3>');
        $output .= '<p>'.${'desc_'.$i}.'</p>';
        $output .= '</div>';
        $output .= '</li>' . "\n";
       }

        $output .= '<div class="clearboth"></div></ul></div></div>' . "\n";
        $output .= '<style type="text/css">
                    #mk-process-'.$id.' ul li:hover .mk-process-icon {background-color:'.$hover_color.';}
                  </style>';

        return $output;

    }
}
/*****************************************************/


/*
LIST ICON SHORTCODE
*/
class WPBakeryShortCode_mk_custom_list extends WPBakeryShortCode {
    protected function content( $atts, $content = null ) {
        extract( shortcode_atts( array(
                    'el_class' => '',
                    'title' => '',
                    'width' => '1/1',
                    'el_position' => '',
                    'style' => 'f00c',
                    'icon_color'=> '',
                    'animation' => '',
                    'margin_bottom' => '',
                ), $atts ) );

        $id = mt_rand( 99, 999 );
        $width = wpb_translateColumnWidthToSpan( $width );
        $el_position_css = '';
        if ( $el_position != '' ) {
            $el_position_css = $el_position.'-column';
        }
        $output = $animation_css = '';
        if($animation != '') {
            $animation_css = ' mk-animate-element ' . $animation . ' ';
        } 

        if(substr($style, 0, 1) == 'f') {
            $font_family = 'FontAwesome';
        } else {
            $font_family = 'Icomoon';
        }

        $output .= '<div class="'.$width.' '.$el_position_css.'">';
        $output .= '<div id="list-style-'.$id.'" class="mk-list-styles mk-shortcode '.$animation_css.$el_class.'" style="margin-bottom:'.$margin_bottom.'px">';
        if ( !empty( $title ) ) {
            $output .= '<h3 class="mk-shortcode mk-fancy-title pattern-style mk-shortcode-heading"><span>'.$title.'</span></h3>';
        }
        $output .= strip_tags( do_shortcode( $content ), '<ul><li><strong><i><em><u><b><a><small>' );
        $output .= '</div></div>';
        $output .= '<style type="text/css">
                    #list-style-'.$id.' ul li:before {
                        font-family:'.$font_family.';    
                        content: "\\'.$style.'";
                        color:'.$icon_color.'
                    }
                </style>';

        return $output;

    }
}

/*****************************************************/











/*
MESSAGE BOXES SHORTCODE
*/
class WPBakeryShortCode_mk_message_box extends WPBakeryShortCode {
    protected function content( $atts, $content = null ) {
        extract( shortcode_atts( array(
                    'el_class' => '',
                    'width' => '1/1',
                    'el_position' => '',
                    'type' => 'confirm-message',
                ), $atts ) );
        $id = mt_rand( 99, 999 );


        $el_position_css = '';
        if ( $el_position != '' ) {
            $el_position_css = $el_position.'-column';
        }

        $output = '';
        $width = wpb_translateColumnWidthToSpan( $width );

        $output .= '<div class="'.$width.' '.$el_position_css.'">';
        $output .= '<div id="message-box-'.$id.'" class="mk-message-box mk-shortcode '.$el_class.' mk-'.$type.'-box">';
        $output .= '<a class="box-close-btn" href="#"><i class="mk-icon-remove"></i></a>';
        $output .= '<span>'.strip_tags( do_shortcode( $content ) ).'</span>';
        $output .= '<div class="clearboth"></div></div></div>';

        return $output;

    }
}
/*****************************************************/














/*
DIVIDER SHORTCODE
*/
class WPBakeryShortCode_mk_divider extends WPBakeryShortCode {
    protected function content( $atts, $content = null ) {
        extract( shortcode_atts( array(
                    'el_class' => '',
                    'el_position' => '',
                    'width' => '1/1',
                    'divider_width' => 'full',
                    'style' => 'double_dot',
                    'margin_top' => '20',
                    'margin_bottom' => '20',

                ), $atts ) );
        $output = '';
        global $post;
        $width = wpb_translateColumnWidthToSpan( $width );
        $el_position_css = '';
        if ( $el_position != '' ) {
            $el_position_css = $el_position.'-column';
        }
        if ( $divider_width == 'page_divider' ) {
            $output .= '</div></div>';
        }
        $output .= '<div class="'.$width.' '.$el_position_css.'"><div style="padding: '.$margin_top.'px 0 '.$margin_bottom.'px;" class="mk-divider mk-shortcode divider_'.$divider_width.' '.$style.' '.$el_class.'">';
        if ( $style == 'shadow_line' ) {
            $output .= '<div class="divider-inner"><span class="divider-shadow-left"></span><span class="divider-shadow-right"></span></div>';
        } elseif ( $style == 'go_top' || $style == 'go_top_thick' ) {
            $output .= '<div class="divider-inner"><a href="#" class="divider-go-top">'.__( 'Back to top', 'mk_framework' ).'<i class="mk-icon-arrow-up"></i><a></div>';
        } else {
            $output .= '<div class="divider-inner"></div>';
        }
        $output .= '</div></div><div class="clearboth"></div>';

        if ( $divider_width == 'page_divider' ) {
            $layout = get_post_meta( $post->ID, '_layout', true );
            $output .= '<div class="theme-page-wrapper '.$layout.'-layout mk-grid row-fluid">';
            $output .= '<div class="theme-content">';
        }
        return $output;

    }
}
/*****************************************************/

















/*
BUTTON SHORTCODE
*/
class WPBakeryShortCode_mk_button extends WPBakeryShortCode {
    protected function content( $atts, $content = null ) {
        extract( shortcode_atts( array(
                    'el_class' => '',
                    'id' => '',
                    'size' => 'medium',
                    'icon' => '',
                    'text_color' => '',
                    'bg_color' => '',
                    'dimension' => 'three_d',
                    'text_color' => 'light',
                    "url" => '',
                    "target" => '',
                    'margin_bottom' => 15,
                    'margin_top' => '',
                    'animation' => '',
                    'button' => '',
                    "align" => '',
                ), $atts ) );

        $animation_css = '';

        $text_color = !empty( $text_color ) ? $text_color : 'light';

        $style_id = mt_rand( 99, 999 );
        $style = '<style type="text/css">
        .button-'.$style_id.' {
                background-color:' . $bg_color . ';
                margin-bottom: '.$margin_bottom.'px;
                margin-top: '.$margin_top.'px;

        }
        .button-'.$style_id.':hover {
                background-color:' . hexDarker( $bg_color, 7 ). ';

        }
        .button-'.$style_id.'.three-dimension  {
             box-shadow: 0px 3px 0px 0px '.hexDarker( $bg_color, 20 ).';
        }
        .button-'.$style_id.'.three-dimension:active  {
             box-shadow: 0px 1px 0px 0px '.hexDarker( $bg_color, 20 ).';
        }
                </style>';

        if($animation != '') {
            $animation_css = ' mk-animate-element ' . $animation . ' ';
        }        
        $icon = !empty( $icon ) ? ( '<i class="mk-'.$icon.'"></i>' ) : '';
        $id = !empty( $id ) ? ( 'id="'.$id.'"' ) : '';
        $target = !empty( $target ) ? ( 'target="'.$target.'"' ) : '';

        $button = '<a href="'.$url.'" '.$target.' '.$id.' class="mk-button button-'.$style_id.' '.$animation_css.$text_color.'-color mk-shortcode '.$dimension.'-dimension '.$size.' '.$el_class.'">'.$icon.do_shortcode( strip_tags( $content ) ).'</a>';
        $output = ( !empty( $align ) ? '<div class="mk-button-align '.$align.'">' : '' ) . $button . ( !empty( $align ) ? '</div>' : '' );
        return $output . "\n\n" . $style;

    }
}

/*****************************************************/












class WPBakeryShortCode_mk_toggle extends WPBakeryShortCode {
    protected function content( $atts, $content = null ) {
        extract( shortcode_atts( array(
                    'title' => false,
                    'style' => 'simple',
                    'icon' => '',
                    'width' => '1/1',
                    'el_position' => '',
                    "el_class" => '',
                ), $atts ) );

        $id = mt_rand( 99, 999 );
        $output = '';
        $width = wpb_translateColumnWidthToSpan( $width );
        $el_position_css = '';
        if ( $el_position != '' ) {
            $el_position_css = $el_position.'-column';
        }

        $output .= '<div class="'.$width.' '.$el_position_css.'">';
        $output .= '<div id="mk-toggle-'.$id.'" class="mk-toggle mk-shortcode '.$style.'-style '.$el_class.'">';
        if ( $icon && $style != 'simple' ) {
            $output .= '<span class="mk-toggle-title"><i class="mk-' . $icon . '"></i>' .$title . '</span>';
        } else {
            $output .= '<span class="mk-toggle-title">' .$title . '</span>';
        }
        $output .= '<div class="mk-toggle-pane">' . wpb_js_remove_wpautop( do_shortcode( trim( $content ) ) ) . '</div></div></div>';
        return $output;
    }
}
/*****************************************************/







/*
FANCY TITLE SHORTCODE
*/
class WPBakeryShortCode_mk_fancy_title extends WPBakeryShortCode {
    protected function content( $atts, $content = null ) {
        extract( shortcode_atts( array(
                    'el_class' => '',
                    'width' => '1/1',
                    'el_position' => '',
                    'style' => 'true',
                    'color' => '#3d3d3d',
                    "size" => '30',
                    'font_weight' => 'normal',
                    'margin_bottom' => '20',
                    'margin_top' => '0',
                    "align" => 'left',
                    'animation' => '',
                    "font_family" => '',
                    'tag_name' => 'h2',
                    "font_type" => '',
                ), $atts ) );
        $id = mt_rand( 99, 999 );
        $output = '';
        $divider_css = $animation_css ='';
        $style = ( $style == 'true' ) ? 'pattern' : 'simple';
        $output .= mk_get_fontfamily( "#fancy-title-", $id, $font_family, $font_type );
        $width = wpb_translateColumnWidthToSpan( $width );
        if($animation != '') {
            $animation_css = ' mk-animate-element ' . $animation . ' ';
        }
        $span_padding = '';
        if ( $align == 'left' ) {$span_padding = 'padding-right:8px;';}
        else if ( $align == 'center' ) {$span_padding = 'padding:0 8px;';}
        else if ( $align == 'right' ) {$span_padding = 'padding-left:8px;';}
        $el_position_css = '';
        if ( $el_position != '' ) {
            $el_position_css = $el_position.'-column';
        }
        $output .= '<div class="'.$width.' '.$el_position_css.'">';
        $output .= '<'.$tag_name.' style="font-size: '.$size.'px;text-align:'.$align.';color: '.$color.';font-weight:'.$font_weight.';margin-top:'.$margin_top.'px;margin-bottom:'.$margin_bottom.'px; '.$divider_css.'" id="fancy-title-'.$id.'" class="mk-shortcode mk-fancy-title '.$animation_css.$style.'-style '.$el_class.'"><span style="'.$span_padding.'">' . strip_tags( do_shortcode( $content ), '<br /><br><br/><strong><i><u><b><a><small>' ). '</span></'.$tag_name.'><div class="clearboth"></div></div>';

        return $output;
    }
}
/*****************************************************/




class WPBakeryShortCode_mk_title_box extends WPBakeryShortCode {
    protected function content( $atts, $content = null ) {
        extract( shortcode_atts( array(
                    'el_class' => '',
                    'width' => '1/1',
                    'el_position' => '',
                    'color' => '',
                    'highlight_color' => '#000',
                    'highlight_opacity' => 0.3,
                    "size" => '18',
                    'font_weight' => 'normal',
                    'margin_bottom' => '20',
                    'margin_top' => '0',
                    'line_height' => '34',
                    "align" => 'left',
                    'animation' => '',
                    "font_family" => '',
                    "font_type" => '',
                ), $atts ) );
        $id = mt_rand( 99, 999 );
        $output = '';
        $animation_css ='';
        $output .= mk_get_fontfamily( "#fancy-title-", $id, $font_family, $font_type );
        $width = wpb_translateColumnWidthToSpan( $width );
        if($animation != '') {
            $animation_css = ' mk-animate-element ' . $animation . ' ';
        }
        $el_position_css = '';
        if ( $el_position != '' ) {
            $el_position_css = $el_position.'-column';
        }
        $output .= '<div class="'.$width.' '.$el_position_css.'">';
        $output .= '<h3 style="font-size: '.$size.'px;text-align:'.$align.';color: '.$color.';font-weight:'.$font_weight.';margin-top:'.$margin_top.'px;margin-bottom:'.$margin_bottom.'px;" id="fancy-title-'.$id.'" class="mk-shortcode mk-title-box '.$animation_css.' '.$el_class.'"><span style="background-color:'.mk_color( $highlight_color, $highlight_opacity).'; box-shadow: 8px 0 0 '.mk_color( $highlight_color, $highlight_opacity).', -8px 0 0 '.mk_color( $highlight_color, $highlight_opacity).';line-height:'.$line_height.'px">' . strip_tags( do_shortcode( $content ), '<br /><br><br/><strong><i><u><b><a><small>' ). '</span></h3><div class="clearboth"></div></div>';

        return $output;
    }
}
/*****************************************************/







/*
IMAGE SHORTCODE
*/
class WPBakeryShortCode_mk_image extends WPBakeryShortCode {
    protected function content( $atts, $content = null ) {
        extract( shortcode_atts( array(
                    'heading_title' => '',
                    'image_width' => 770,
                    'image_height' => 350,
                    'lightbox' => 'true',
                    'custom_lightbox' => '',
                    'group' => '',
                    'width' => '1/1',
                    'el_position' => '',
                    'frame_style' => 'simple',
                    'src' => '',
                    'link' => '',
                    'target' => '',
                    'animation' => '',
                    'title'=> '',
                    'desc'=> '',
                    'align' => 'left',
                    'caption_location' => '',
                    'el_class' => '',
                ), $atts ) );


        $image_src  = theme_image_resize( $src, $image_width, $image_height);
        $width = wpb_translateColumnWidthToSpan( $width );

        $el_position_css = $animation_css =  $lightbox_enabled = '';
        if ( $el_position != '' ) {
            $el_position_css = $el_position.'-column';
        }
        $output = '<div class="'.$width.' '.$el_position_css.'">';
        if ( $lightbox == 'true' ) {
            $lightbox_enabled = 'lightbox-enabled';
            $custom_lightbox = !empty($custom_lightbox) ? ($src = $custom_lightbox) : '';
        }
        if($animation != '') {
            $animation_css = 'mk-animate-element ' . $animation . ' ';
        }

        $output .= '<div class="mk-image-shortcode mk-shortcode align-'.$align.' '.$animation_css.$frame_style.'-frame '.$caption_location.' '.$el_class.'" style="max-width: '.$image_width.'px">';
        if ( !empty( $heading_title ) ) {
            $output .= '<h3 class="mk-shortcode mk-fancy-title pattern-style mk-shortcode-heading"><span>'.$heading_title.'</span></h3>';
        }
        $output .= '<div class="mk-image-inner '.$lightbox_enabled.'">';
        $output .= '<img class="lightbox-'.$lightbox.' mk-blur" alt="'.$title.'" title="'.$title.'" src="'.$image_src['url'].'" />';
        if ( $lightbox == 'true' ) {
            $output .= '<div class="mk-image-overlay"></div>';
            $output .= '<a href="'.$src.'" rel="prettyPhoto['.$group.']" alt="'.$title.'" title="'.$title.'" class="mk-lightbox mk-image-shortcode-lightbox"><i class="mk-icon-zoom-in"></i></a>';
        }
        if ( $link ) {
            $output .= '<a href="'.$link.'" target="'.$target.'" class="mk-image-shortcode-link">&nbsp;</a>';
        }
        $output .= '</div>';
        if ( ( !empty( $title ) || !empty( $desc ) ) ) {
            $output .= '<div class="mk-image-caption">
                            <span class="mk-caption-title">'.$title.'</span>
                            <span class="mk-caption-desc">'.$desc.'</span>
                </div>';
        }
        $output .= '</div><div class="clearboth"></div></div>';

        return $output;


    }
}
/*****************************************************/








/*
IMAGE SHORTCODE
*/
class WPBakeryShortCode_mk_circle_image extends WPBakeryShortCode {
    protected function content( $atts, $content = null ) {
        extract( shortcode_atts( array(
                    'heading_title' => '',
                    'image_diameter' => 770,
                    'image_height' => 350,
                    'width' => '1/1',
                    'el_position' => '',
                    'src' => '',
                    'animation' => '',
                    'link' => '',
                    'el_class' => '',
                ), $atts ) );


        $image_src  = theme_image_resize( $src, $image_diameter, $image_diameter);
        $width = wpb_translateColumnWidthToSpan( $width );

        $el_position_css = $animation_css = '';
        if ( $el_position != '' ) {
            $el_position_css = $el_position.'-column';
        }
        if($animation != '') {
            $animation_css = 'mk-animate-element ' . $animation . ' ';
        } 
        $output = '<div class="'.$width.' '.$el_position_css.'">';

        $output .= '<div class="mk-circle-image  mk-shortcode '.$animation_css.$el_class.'"><span>';
        if ( !empty( $heading_title ) ) {
            $output .= '<h3 class="mk-shortcode mk-fancy-title pattern-style mk-shortcode-heading"><span>'.$heading_title.'</span></h3>';
        }
        if ( $link ) {
            $output .= '<a href="'.$link.'"><img alt="'.$heading_title.'" title="'.$heading_title.'" src="'.$image_src['url'].'" /></a>';
        } else {
            $output .= '<img alt="'.$heading_title.'" title="'.$heading_title.'" src="'.$image_src['url'].'" />';
        }

        $output .= '</span></div><div class="clearboth"></div></div>';

        return $output;


    }
}
/*****************************************************/




/*
GALLERY SHORTCODE
*/
class WPBakeryShortCode_mk_gallery extends WPBakeryShortCode {
    protected function content( $atts, $content = null ) {
        extract( shortcode_atts( array(
                    "images" => '',
                    'title' => '',
                    'collection_title'=>'',
                    "height" => 500,
                    "column" => 4,
                    "el_class" => '',
                    'custom_links'=> '',
                    'width' => '1/1',
                    'frame_style' => '',
                    'el_position' => '',
                ), $atts ) );


        if ( $images == '' ) return null;
        $id = mt_rand( 99, 9999 );

        if ( is_page() ) {
            global $post;
            $layout = get_post_meta( $post->ID, '_layout', true );
        }

        switch ( $column ) {
        case 1:
            if ( $layout == 'full' ) {
                $image_width =  1100;
                $height = !empty( $height ) ? $height : 450;
            } else {
                $image_width = 795;
                $height = !empty( $height ) ? $height : 350;
            }
            $column_css = 'gallery-one-column';
            break;
        case 2:
            if ( $layout == 'full' ) {
                $image_width = 528;
                $height = !empty( $height ) ? $height : 528;
            } else {
                $image_width = 500;
                $height = !empty( $height ) ? $height : 500;
            }
            $column_css = 'gallery-two-column';
            break;
        case 3:
            $image_width = 500;
            $height = !empty( $height ) ? $height : 500;
            $column_css = 'gallery-three-column';
            break;

        case 4:
            $image_width = 500;
            $height = !empty( $height ) ? $height : 500;
            $column_css = 'gallery-four-column';
            break;
        case 5:
            $image_width = 500;
            $height = !empty( $height ) ? $height : 500;
            $column_css = 'gallery-five-column';
            break;

        case 6:
            $image_width = 500;
            $height = !empty( $height ) ? $height : 500;
            $column_css = 'gallery-six-column';
            break;
        case 7:
            $image_width = 500;
            $height = !empty( $height ) ? $height : 500;
            $column_css = 'gallery-seven-column';
            break;
        case 8:
            $image_width = 500;
            $height = !empty( $height ) ? $height : 500;
            $column_css = 'gallery-eight-column';
         
        }

        $width = wpb_translateColumnWidthToSpan( $width );


        $output = $first_column ='';
        $images = explode( ',', $images );
        $custom_links = explode( ',', $custom_links);
        $i = -1;
        

        foreach ( $images as $attach_id ) {
            $i++;
            $image_src_array = wp_get_attachment_image_src( $attach_id, 'full', true );
            $image_src  = theme_image_resize( $image_src_array[ 0 ], $image_width, $height);            
            $output .= '<article class="'.$column_css.' '.$frame_style.'-frame">';
            $output .='<div class="image-hover-overlay"></div>';
            if(isset( $custom_links[$i] ) && $custom_links[$i] != '') {
                $output .= '<a href="'.$custom_links[$i].'" class="mk-image-shortcode-lightbox"><i class="mk-icon-link"></i></a>';
            } else {
                $output .='<a href="'.$image_src_array[ 0 ].'" rel="prettyPhoto[gallery_'.$id.']" alt="'.$collection_title.'" title="'.$collection_title.'" class="mk-lightbox mk-image-shortcode-lightbox"><i class="mk-icon-zoom-in"></i></a>';
            }
            
            $output .= '<span class="gallery-inner"><img alt="'.$collection_title.'" src="' . $image_src['url'] .'" /></span>';
            $output .= '</article>'. "\n\n";

        }
        $el_position_css = '';
        if ( $el_position != '' ) {
            $el_position_css = $el_position.'-column';
        }
        $final_output = '<div class="'.$width.' '.$el_position_css.'">';
        if ( !empty( $title ) ) {
            $final_output .= '<h3 class="mk-shortcode mk-fancy-title pattern-style mk-shortcode-heading"><span>'.$title.'</span></h3>';
        }
        $final_output .= '<div class="mk-gallery-shortcode mk-shortcode '.$el_class.'"><section>' . $output . '</section><div class="clearboth"></div></div></div>';

        return $final_output;
    }

}




/*
PRICING TABLE SHORTCODE
*/
class WPBakeryShortCode_mk_pricing_table extends WPBakeryShortCode {
    protected function content( $atts, $content = null ) {
        extract( shortcode_atts( array(
                    'style' => '',
                    'table_number' => 4,
                    'tables' => '',
                    'orderby'=> 'date',
                    'order'=> 'DESC',
                    'el_class' =>'',
                ), $atts ) );


        $query = array(
            'post_type'=>'pricing',
            'showposts' => $table_number,
        );

        if ( $tables ) {
            $query['post__in'] = explode( ',', $tables );
        }
        if ( $orderby ) {
            $query['orderby'] = $orderby;
        }
        if ( $order ) {
            $query['order'] = $order;
        }


        if ( $table_number == 4 ) {
            $table_css = 'four-table';
        } else if ( $table_number == 3 ) {
                $table_css = 'three-table';
            } else if ( $table_number == 2 ) {
                $table_css = 'two-table';
            } else if ( $table_number == 1 ) {
                $table_css = 'one-table';
            }
        $r = new WP_Query( $query );
        global $post;
        $pricing_offer_css = '';
        if ( strlen( $content ) < 5 ) {
            $pricing_offer_css = 'no-pricing-offer';
        }

        $output = '<div class="shortcode pricing-table '.$style.' '.$el_class.' '.$pricing_offer_css.'">';
        if ( strlen( $content ) > 5 ) {
            $output .= '<div class="pricing-offer-grid">';
            $output .= '<div class="offers">'.strip_tags( $content, '<ul><li><strong><i><u><b><a><small>' ).'</div>';
            $output .= '</div>';
        }
        $output .= '<ul class="pricing-cols">';
        while ( $r->have_posts() ) : $r->the_post();
        $heading_color = ( $style == 'multicolor' ) ? ( 'style="background-color:'.get_post_meta( $post->ID, 'skin', true ).'"' ) : '';
        $featured = get_post_meta( $post->ID, 'featured', true );

        $featured_css = '';
        if ( $featured == 'true' ) {
            $button_color = get_post_meta( $post->ID, 'skin', true );
            $featured_css = 'featured-plan';
            if ( $style == 'monocolor' ) {
                $button_color = theme_option( THEME_OPTIONS, 'skin_color' );
            }
        } else {
            if ( $style == 'monocolor' ) {
                $button_color = '#727272';
            } else {
                $button_color = '#969696';
            }
        }

        $output .= '<li class="pricing-col '.$table_css.' '.$featured_css.'">';
        $output .='<div class="pricing-heading" '.$heading_color.'>';
        if ( $featured == 'true' && $style == 'multicolor' ) {
            $output .= '<span class="premium-ribbon">'.get_post_meta( $post->ID, '_ribbon_txt', true ).'</span>';
        }
        $output .='<div class="pricing-plan">'.get_post_meta( $post->ID, '_plan', true ).'</div>';
        $output .='<div class="pricing-price">';

        $output .='<span><sup>'.get_post_meta( $post->ID, '_currency', true ).'</sup>'.get_post_meta( $post->ID, '_price', true ).'<sub>'.get_post_meta( $post->ID, '_period', true ).'</sub></span>';

        $output .='</div></div>';
        $output .='<div class="pricing-features">'.get_post_meta( $post->ID, '_features', true ).'</div>';
        $output .='<div class="pricing-button">
                        '.do_shortcode( '[mk_button dimension="three" size="medium" bg_color="'.$button_color.'" text_color="light" target="_self" align="center" url="'.get_post_meta( $post->ID, '_btn_url', true ).'"]'.get_post_meta( $post->ID, '_btn_text', true ).'[/mk_button]' ).'
                        <div class="clearboth"></div>
                  </div>';
        $output .='</li>';

        endwhile;
        $output .= '</ul></div>';

        wp_reset_query();
        return $output;
    }
}
/*****************************************************/













/*
Employees SHORTCODE
*/
class WPBakeryShortCode_mk_employees extends WPBakeryShortCode {
    protected function content( $atts, $content = null ) {
        extract( shortcode_atts( array(
                    'width' => '1/1',
                    'el_position' => '',
                    'count'=> -1,
                    'column' => 3,
                    'style' => 'simple',
                    'box_blur' => 'false',
                    'employees' => '',
                    'animation' => '',
                    'el_class' => '',
                    'offset' => '',
                    'orderby'=> 'date',
                    'order'=> 'DESC',
                ), $atts ) );

        wp_enqueue_script( 'jquery-flexslider' );
        $width = wpb_translateColumnWidthToSpan( $width );
        $id = mt_rand( 99, 9999 );
        $output = $animation_css = '';
        $el_position_css = '';
        if ( $el_position != '' ) {
            $el_position_css = $el_position.'-column';
        }
        

        $query = array(
            'post_type' => 'employees',
            'showposts' => $count,
        );

        if ( $employees ) {
            $query['post__in'] = explode( ',', $employees );
        }
        if ( $offset ) {
            $query['offset'] = $offset;
        }
        if ( $orderby ) {
            $query['orderby'] = $orderby;
        }
        if ( $order ) {
            $query['order'] = $order;
        }
        if($animation != '') {
            $animation_css = ' mk-animate-element ' . $animation . ' ';
        } 

        $loop = new WP_Query( $query );
        $image_dimension = $column_css = $blur_css = $blur_item_css = '';
        switch($column) {
            case 1 :
            $image_dimension = 225;
            $column_css = 'one-column';
            break;
            case 2 :
            $image_dimension = 225;
            $column_css = 'two-column';
            break;
            case 3 :
            $image_dimension = 225;
            $column_css = 'three-column';
            break;
            case 4 :
            $image_dimension = 180;
            $column_css = 'four-column';
            break;
            case 5 :
            $image_dimension = 130;
            $column_css = 'five-column';
            break;
        }
        if($style == 'boxed') {
            $image_dimension = 90;
            if($box_blur == 'true') {
                $blur_css = 'employee-blur';
                $blur_item_css = 'employee-item-blur';
            }
        }

        $output .= '<div class="'.$width.' '.$el_position_css.'">';
        $output .= '<div class="mk-employees mk-shortcode '.$el_class.' '.$column_css.' '.$style.'-style '.$blur_css.'"><ul>';

        $i = 0;
        while ( $loop->have_posts() ):
            $loop->the_post();
        $i++;

        $facebook = get_post_meta( get_the_ID(), '_facebook', true );
        $linkedin = get_post_meta( get_the_ID(), '_linkedin', true );
        $twitter = get_post_meta( get_the_ID(), '_twitter', true );
        $email = get_post_meta( get_the_ID(), '_email', true );
        $googleplus = get_post_meta( get_the_ID(), '_googleplus', true );
        $image_src_array = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full', true );
        $image_src  = theme_image_resize( $image_src_array[ 0 ], $image_dimension, $image_dimension);

        $first_column = '';
        if(($i-1)%$column == 0) {
            $first_column = 'em-first-column';
        }

        $output .= '<li class="mk-employee-item '.$first_column.' '.$blur_item_css.'">';
        $output .= '<div style="width:'.$image_dimension.'px;height:'.$image_dimension.'px;" class="team-thumbnail '.$animation_css.'"><img alt="'.get_the_title().'" title="'.get_the_title().'" src="'.get_image_src( $image_src['url'] ).'" /></div>';
        $output .= '<div class="team-info-wrapper">';
        $output .= '<span class="team-member-name">'.get_the_title().'</span>';
        $output .= '<span class="team-member-position">'.get_post_meta( get_the_ID(), '_position', true ).'</span>';
        if($column < 4){
        $output .= '<span class="team-member-desc">'.get_post_meta( get_the_ID(), '_desc', true ).'</span>';
        }
        $output .= '<div class="clearboth"></div><ul class="mk-employeee-networks">';
        if ( !empty( $email ) ) {
            $output .= '<li><a href="mailto:'.antispambot($email).'" title="'.__( 'Get In Touch With', 'mk_framework' ).' '.get_the_title().'"><i class="mk-icon-envelope"></i></a></li>';
        }
        if ( !empty( $facebook ) ) {
            $output .= '<li><a href="'.$facebook.'" title="'.get_the_title().' '.__( 'On', 'mk_framework' ).' Facebook"><i class="mk-moon-facebook"></i></a></li>';
        }
        if ( !empty( $twitter ) ) {
            $output .= '<li><a href="'.$twitter.'" title="'.get_the_title().' '.__( 'On', 'mk_framework' ).' Twitter"><i class="mk-moon-twitter"></i></a></li>';
        }
        if ( !empty( $googleplus ) ) {
            $output .= '<li><a href="'.$googleplus.'" title="'.get_the_title().' '.__( 'On', 'mk_framework' ).' Google Plus"><i class="mk-moon-google-plus"></i></a></li>';
        }
        if ( !empty( $linkedin ) ) {
            $output .= '<li><a href="'.$linkedin.'" title="'.get_the_title().' '.__( 'On', 'mk_framework' ).' Linked In"><i class="mk-icon-linkedin"></i></a></li>';
        }
        $output .= '</ul>';
        $output .= '</div>';
        $output .= '</li>';

        if ( $i%$column == 0 ) {
            $output .= '<div class="clearboth"></div>';
        }
        endwhile;
        wp_reset_query();

        $output .= '</ul></div><div class="clearboth"></div></div>';


        return $output;
    }

}
/*****************************************************/









/*
CLIENTS SHORTCODE
*/
class WPBakeryShortCode_mk_clients extends WPBakeryShortCode {
    protected function content( $atts, $content = null ) {
        extract( shortcode_atts( array(
                    'title' => '',
                    'count'=> 10,
                    'bg_color' => '',
                    'border_color' => '',
                    'orderby'=> 'date',
                    'target' => '_self',
                    'clients' => '',
                    'height' => '',
                    'order'=> 'DESC',
                    'autoplay' => 'true',
                    'el_class' => '',
                    'el_position' => '',
                    'width' => '1/1',
                ), $atts ) );


        wp_enqueue_script( 'jquery-flexslider' );
        $query = array(
            'post_type' => 'clients',
            'showposts' => $count,
        );

        if ( $clients ) {
            $query['post__in'] = explode( ',', $clients );
        }
        if ( $orderby ) {
            $query['orderby'] = $orderby;
        }
        if ( $order ) {
            $query['order'] = $order;
        }

        $loop = new WP_Query( $query );

        $bg_color = !empty( $bg_color ) ? ( ' background-color:'.$bg_color.'; ' ) : '';
        $border_color = !empty( $border_color ) ? ( ' border-color:'.$border_color.'; ' ) : 'border-color:transparent;';
        $height = !empty( $height ) ? ( ' height:'.$height.'px; ' ) : ( ' height:110px; ' );

        $id = mt_rand( 99, 999 );
        $width = wpb_translateColumnWidthToSpan( $width );
        $directionNav = "false";
        $el_position_css = $output = '';
        if ( $el_position != '' ) {
            $el_position_css = $el_position.'-column';
        }
        $output .= '<div class="'.$width.' '.$el_position_css.'">';

        $output .= '<div id="clients-shortcode-'.$id.'" class="mk-clients-shortcode mk-flexslider mk-shortcode '.$el_class.'">';
        if ( !empty( $title ) ) {
            $output .= '<h3 class="mk-shortcode mk-fancy-title pattern-style mk-shortcode-heading"><span>'.$title.'</span></h3>';
            $directionNav = "true";
        }
        $output .= '<ul class="mk-flex-slides">';
        while ( $loop->have_posts() ):
            $loop->the_post();
        $url = get_post_meta( get_the_ID(), '_url', true );
        $image_src_array = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full', true );

        $output .= '<li>';
        $output .= !empty( $url ) ? '<a target="'.$target.'" href="'.$url.'">' : '';
        $output .= '<div title="'.get_the_title().'" class="client-logo" style="background-image:url('.get_image_src( $image_src_array[0] ).'); '.$height.$bg_color.$border_color.'"></div>';
        $output .= !empty( $url ) ? '</a>' : '';
        $output .= '</li>';

        endwhile;
        wp_reset_query();

        $output .= '</ul></div></div>';


        $output .= '<script type="text/javascript">

        jQuery(document).ready(function() {
            jQuery(window).on("load",function () {
                jQuery("#clients-shortcode-'.$id.'").flexslider({
                    selector: ".mk-flex-slides > li",
                    slideshow: '.$autoplay.',
                    animation: "slide",              //String: Select your animation type, "fade" or "slide"
                    smoothHeight: false,            //{NEW} Boolean: Allow height of the slider to animate smoothly in horizontal mode
                    slideshowSpeed: 4000,           //Integer: Set the speed of the slideshow cycling, in milliseconds
                    animationSpeed: 400,            //Integer: Set the speed of animations, in milliseconds
                    pauseOnHover: true,            //Boolean: Pause the slideshow when hovering over slider, then resume when no longer hovering
                    controlNav: false,               //Boolean: Create navigation for paging control of each clide? Note: Leave true for manualControls usage
                    directionNav:'.$directionNav.',
                    prevText: "",           //String: Set the text for the "previous" directionNav item
                    nextText: "",               //String: Set the text for the "next" directionNav item
                    itemWidth: 184,
                    itemMargin: 0,
                    minItems: 1,
                    move: 1,
                    maxItems: 6
                });
            });
        });
        </script>';



        return $output;

    }
}
/*****************************************************/










/*
CLIENTS SHORTCODE
*/
class WPBakeryShortCode_mk_testimonials extends WPBakeryShortCode {
    protected function content( $atts, $content = null ) {
        extract( shortcode_atts( array(
                    'title' => '',
                    'style' => 'boxed',
                    'count'=> 10,
                    'orderby'=> 'date',
                    'testimonials' => '',
                    'order'=> 'DESC',
                    "el_class"=> '',
                    'animation' => '',
                    'el_position' => '',
                    'width' => '1/1',
                ), $atts ) );


        wp_print_scripts( 'jquery-flexslider' );

        $id = mt_rand( 99, 9999 );
        $animation_css = '';
        if($animation != '') {
            $animation_css = ' mk-animate-element ' . $animation . ' ';
        }

        $width = wpb_translateColumnWidthToSpan( $width );
        $script_out = '<script type="text/javascript">

        jQuery(document).ready(function() {
            jQuery(window).on("load",function () {
                jQuery("#testimonial_'.$id.'").flexslider({
                    selector: ".mk-flex-slides > li",
                    slideshow: true,
                    animation: "fade",              //String: Select your animation type, "fade" or "slide"
                    smoothHeight: false,            //{NEW} Boolean: Allow height of the slider to animate smoothly in horizontal mode
                    slideshowSpeed: 5000,           //Integer: Set the speed of the slideshow cycling, in milliseconds
                    animationSpeed: 500,            //Integer: Set the speed of animations, in milliseconds
                    pauseOnHover: true,            //Boolean: Pause the slideshow when hovering over slider, then resume when no longer hovering
                    controlNav: false,               //Boolean: Create navigation for paging control of each clide? Note: Leave true for manualControls usage
                    directionNav:true,
                    prevText: "",           //String: Set the text for the "previous" directionNav item
                    nextText: ""               //String: Set the text for the "next" directionNav item
                });
            });
        });
        </script>';

        $query = array(
            'post_type' => 'testimonial',
            'showposts' => $count,
        );

        if ( $testimonials ) {
            $query['post__in'] = explode( ',', $testimonials );
        }
        if ( $orderby ) {
            $query['orderby'] = $orderby;
        }
        if ( $order ) {
            $query['order'] = $order;
        }

        $loop = new WP_Query( $query );
        $width = wpb_translateColumnWidthToSpan( $width );
        $el_position_css = '';
        if ( $el_position != '' ) {
            $el_position_css = $el_position.'-column';
        }
        $output = '';
        $heading_title = '';
        if ( !empty( $title ) ) {
            $heading_title = '<h3 class="mk-shortcode mk-fancy-title pattern-style mk-shortcode-heading"><span>'.$title.'</span></h3>';
        }
        while ( $loop->have_posts() ):
            $loop->the_post();
        $url = get_post_meta( get_the_ID(), '_url', true );
        $company = get_post_meta( get_the_ID(), '_company', true );
        if ( $style == 'boxed' ) {
            $image_src_array = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full', true );
            $image_src  = theme_image_resize( $image_src_array[ 0 ], 120, 120);
        }
        $output .= '<li>';
        $output .= '<div class="mk-testimonial-content">';
        $output .= '<p class="mk-testimonial-quote">'. strip_tags( get_post_meta( get_the_ID(), '_desc', true ), '<ul><li><br><br /><span><strong><i><em><u><b><a><small>' ).'</p>';
        $output .= '</div>';
        if ( $style == 'boxed' && !empty( $image_src['url'] ) ) {
            $output .= '<div class="mk-testimonial-image '.$animation_css.'"><img width="50" height="50" src="'.$image_src['url'].'" alt="'. strip_tags( get_post_meta( get_the_ID(), '_author', true ) ).'" /></div>';
        }
        $output .= '<span class="mk-testimonial-author">'. strip_tags( get_post_meta( get_the_ID(), '_author', true ) ).'</span>';
        $output .= !empty( $company ) ? ( '<a '.( !empty( $url ) ? ( 'href="'.$url.'"' ) : '' ).' class="mk-testimonial-company">'. strip_tags( $company ).'</a>' ) : '';
        $output .= '</li>'. "\n\n";
        endwhile;

        wp_reset_query();



        $final_output = '<div class="'.$width.' '.$el_position_css.'">'.$heading_title;
        $final_output .= '<div class="mk-testimonial '.$style.'-style mk-flexslider '.$el_class.'" id="testimonial_'.$id.'">';
        if ( $style == 'simple' ) {
            $output .= '<i class="mk-icon-quote-left"></i>';
            $output .= '<i class="mk-icon-quote-right"></i>';
        }
        $final_output .= '<ul class="mk-flex-slides">' . $output . '</ul></div></div>' . "\n\n\n\n" . $script_out;

        return $final_output;
    }
}
/*****************************************************/











/*
SLIDESHOW SHORTCODE
*/
class WPBakeryShortCode_mk_flexslider extends WPBakeryShortCode {
    protected function content( $atts, $content = null ) {
        extract( shortcode_atts( array(
                    'title' => '',
                    'count'=> 10,
                    'orderby'=> 'date',
                    'slides' => '',
                    'order'=> 'DESC',
                    "image_width" => 770,
                    "image_height" => 350,
                    "effect" => 'fade',
                    "animation_speed" => 700,
                    "slideshow_speed" => 7000,
                    "pause_on_hover" => "false",
                    "smooth_height" => "true",
                    "direction_nav" => "true",
                    "caption_bg_color" => "",
                    "caption_color" => "#fff",
                    "caption_bg_opacity" => 0.8,
                    "el_class" => '',
                    'width' => '1/1',
                    'el_position' => '',
                ), $atts ) );


        wp_enqueue_scripts( 'jquery-flexslider' );

        $id = mt_rand( 99, 9999 );

        $width = wpb_translateColumnWidthToSpan( $width );

        $caption_bg_color = !empty( $caption_bg_color ) ? $caption_bg_color : theme_option( THEME_OPTIONS, 'skin_color' );

        $script_out = '<script type="text/javascript">

        jQuery(document).ready(function() {
            jQuery(window).on("load",function () {
                jQuery("#flexslider_'.$id.'").flexslider({
                    selector: ".mk-flex-slides > li",
                    slideshow: true,
                    animation: "'.$effect.'",              //String: Select your animation type, "fade" or "slide"
                    smoothHeight: '.$smooth_height.',            //{NEW} Boolean: Allow height of the slider to animate smoothly in horizontal mode
                    slideshowSpeed: '.$slideshow_speed.',           //Integer: Set the speed of the slideshow cycling, in milliseconds
                    animationSpeed: '.$animation_speed.',            //Integer: Set the speed of animations, in milliseconds
                    pauseOnHover: '.$pause_on_hover.',            //Boolean: Pause the slideshow when hovering over slider, then resume when no longer hovering
                    controlNav: false,               //Boolean: Create navigation for paging control of each clide? Note: Leave true for manualControls usage
                    directionNav:'.$direction_nav.',
                    prevText: "",           //String: Set the text for the "previous" directionNav item
                    nextText: ""               //String: Set the text for the "next" directionNav item
                });
            });
        });
        </script>
';

        $query = array(
            'post_type' => 'slideshow',
            'showposts' => $count,
        );

        if ( $slides ) {
            $query['post__in'] = explode( ',', $slides );
        }
        if ( $orderby ) {
            $query['orderby'] = $orderby;
        }
        if ( $order ) {
            $query['order'] = $order;
        }
        $heading_title = '';
        if ( !empty( $title ) ) {
            $heading_title = '<h3 class="mk-shortcode mk-fancy-title pattern-style mk-shortcode-heading"><span>'.$title.'</span></h3>';
        }

        $loop = new WP_Query( $query );

        $output = '';
        while ( $loop->have_posts() ):
            $loop->the_post();
        $url = get_post_meta( get_the_ID(), '_link_to', true );
        $caption = get_post_meta( get_the_ID(), '_title', true );
        $image_src_array = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full', true );
        $image_src  = theme_image_resize( $image_src_array[0], $image_width, $image_height);


        $output .= '<li>';
        $output .= !empty( $url ) ? '<a href="'.$url.'">' : '' ;
        $output .= '<img alt="'.$caption.'" src="' . $image_src['url'] .'" />';
        $output .= !empty( $url ) ? '</a>' : '' ;
        $output .= !empty( $caption ) ?  '<div class="mk-flex-caption">
                    <div style="background-color:'.$caption_bg_color.'; -webkit-opacity: '.$caption_bg_opacity.';-moz-opacity: '.$caption_bg_opacity.';-o-opacity: '.$caption_bg_opacity.';filter: alpha(opacity='.( $caption_bg_opacity * 100 ).');opacity: '.$caption_bg_opacity.';" class="color-mask"></div>
                    <span style="color:'.$caption_color.'">'.$caption.'</span>
                    </div>' : '';

        $output .= '</li>'. "\n\n";
        endwhile;
        wp_reset_query();
        $el_position_css = '';
        if ( $el_position != '' ) {
            $el_position_css = $el_position.'-column';
        }
        return '<div class="'.$width.' '.$el_position_css.'">'.$heading_title.'<div style="max-width:' . $image_width . 'px;" class="mk-slideshow-shortcode mk-flexslider '.$el_class.'" id="flexslider_'.$id.'"><ul class="mk-flex-slides">' . $output . '</ul></div></div>' . "\n\n\n\n" . $script_out;
    }

}
/*****************************************************/



/*
LAYER SHORTCODE
*/
class WPBakeryShortCode_mk_layerslider extends WPBakeryShortCode {
    protected function content( $atts, $content = null ) {
        extract( shortcode_atts( array(
                    'id' => '',
                ), $atts ) );

        if ( !empty( $id ) ) {
            return do_shortcode( '[layerslider id="'.$id.'"]' );
        }
    }

}
/*****************************************************/

/*
REVOLUTION SHORTCODE
*/
class WPBakeryShortCode_mk_revslider extends WPBakeryShortCode {
    protected function content( $atts, $content = null ) {
        extract( shortcode_atts( array(
                    'id' => '',
                ), $atts ) );

        if ( !empty( $id ) ) {
            return do_shortcode( '[rev_slider '.$id.']' );
        }
    }

}
/*****************************************************/



/*
LAYER SHORTCODE
*/
class WPBakeryShortCode_mk_woocommerce_recent_carousel extends WPBakeryShortCode {
    protected function content( $atts, $content = null ) {
        extract( shortcode_atts( array(
                    'title' => '',
                    'per_page' => -1,
                    'featured' => 'false',
                    'order'=> 'DESC',
                    'orderby'=> 'date',
                    'width' => '1/1',
                    'el_position' => '',
                ), $atts ) );
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
        wp_enqueue_scripts( 'jquery-flexslider' );
        $width = wpb_translateColumnWidthToSpan( $width );
        $output = '';
        $id = mt_rand(99,999);
        $el_position_css = '';
        if ( $el_position != '' ) {
            $el_position_css = $el_position.'-column';
        }
        $output .= '<div class="'.$width.' '.$el_position_css.'">';
        $output .= '<div class="mk-shortcode mk-woocommerce-carousel">';
        $output .= '<h3 class="mk-shortcode mk-fancy-title pattern-style"><span>'.$title.'</span>';
        $output .= '<a href="'.get_permalink( woocommerce_get_page_id( 'shop' ) ).'" class="mk-woo-view-all">'.__( 'VIEW ALL', 'mk_framework' ).'</a></h3>';
        $output .= '<div id="mk-woocommerce-carousel-'.$id.'" class="mk-flexslider">';  
        if($featured == 'false') {
            $output .= do_shortcode( '[recent_products per_page="'.$per_page.'" orderby="'.$orderby.'" order="'.$order.'"]' );
        } else {
            $output .= do_shortcode( '[featured_products per_page="'.$per_page.'" orderby="'.$orderby.'" order="'.$order.'"]' );
        }
        
        

        $output .= '</div><div class="clearboth"></div></div></div>';


        $output .= '<script type="text/javascript">
        jQuery(document).ready(function() {
                jQuery("#mk-woocommerce-carousel-'.$id.'").flexslider({
                    selector: ".mk-products > li",
                    slideshow: true,
                    animation: "slide",              //String: Select your animation type, "fade" or "slide"
                    smoothHeight: false,            //{NEW} Boolean: Allow height of the slider to animate smoothly in horizontal mode
                    slideshowSpeed: 6000,           //Integer: Set the speed of the slideshow cycling, in milliseconds
                    animationSpeed: 400,            //Integer: Set the speed of animations, in milliseconds
                    pauseOnHover: true,            //Boolean: Pause the slideshow when hovering over slider, then resume when no longer hovering
                    controlNav: false,               //Boolean: Create navigation for paging control of each clide? Note: Leave true for manualControls usage
                    directionNav:true,
                    prevText: "",           //String: Set the text for the "previous" directionNav item
                    nextText: "",               //String: Set the text for the "next" directionNav item
                    itemWidth: 260,
                    itemMargin: 0,
                    maxItems: 4,
                    minItems: 1,
                    move: 1
                });
        });
        </script>';
        return $output;
        }
       
    }

}
/*****************************************************/




/*
SIMPLE SLIDESHOW SHORTCODE
*/
class WPBakeryShortCode_mk_image_slideshow extends WPBakeryShortCode {
    protected function content( $atts, $content = null ) {
        extract( shortcode_atts( array(
                    'title' => '',
                    "images" => '',
                    "image_width" => 770,
                    "image_height" => 350,
                    "effect" => 'fade',
                    "animation_speed" => 700,
                    "slideshow_speed" => 7000,
                    "pause_on_hover" => "false",
                    "smooth_height" => "true",
                    "direction_nav" => "true",
                    "el_class" => '',
                    'width' => '1/1',
                    'el_position' => '',
                ), $atts ) );


        wp_enqueue_scripts( 'jquery-flexslider' );
        if ( $images == '' ) return null;
        $id = mt_rand( 99, 9999 );

        $width = wpb_translateColumnWidthToSpan( $width );
        $heading_title = '';
        if ( !empty( $title ) ) {
            $heading_title = '<h3 class="mk-shortcode mk-fancy-title pattern-style mk-shortcode-heading"><span>'.$title.'</span></h3>';
        }

        $script_out = '<script type="text/javascript">

        jQuery(document).ready(function() {
            jQuery(window).on("load",function () {
                jQuery("#flexslider_'.$id.'").flexslider({
                    selector: ".mk-flex-slides > li",
                    slideshow: true,
                    animation: "'.$effect.'",              //String: Select your animation type, "fade" or "slide"
                    smoothHeight: '.$smooth_height.',            //{NEW} Boolean: Allow height of the slider to animate smoothly in horizontal mode
                    slideshowSpeed: '.$slideshow_speed.',           //Integer: Set the speed of the slideshow cycling, in milliseconds
                    animationSpeed: '.$animation_speed.',            //Integer: Set the speed of animations, in milliseconds
                    pauseOnHover: '.$pause_on_hover.',            //Boolean: Pause the slideshow when hovering over slider, then resume when no longer hovering
                    controlNav: true,               //Boolean: Create navigation for paging control of each clide? Note: Leave true for manualControls usage
                    directionNav:'.$direction_nav.',
                    prevText: "",           //String: Set the text for the "previous" directionNav item
                    nextText: ""               //String: Set the text for the "next" directionNav item
                });
            });
        });
        </script>';



        $output = '';
        $images = explode( ',', $images );
        $i = -1;

        foreach ( $images as $attach_id ) {
            $i++;
            $image_src_array = wp_get_attachment_image_src( $attach_id, 'full', true );
            $image_src  = theme_image_resize( $image_src_array[ 0 ], $image_width, $image_height);


            $output .= '<li>';
            $output .= '<img alt="" src="' . $image_src['url'] .'" />';
            $output .= '</li>'. "\n\n";

        }
        $el_position_css = '';
        if ( $el_position != '' ) {
            $el_position_css = $el_position.'-column';
        }
        return '<div class="'.$width.' '.$el_position_css.'">'.$heading_title.'<div style="max-width:' . $image_width . 'px;" class="mk-slideshow-shortcode mk-flexslider '.$el_class.'" id="flexslider_'.$id.'"><ul class="mk-flex-slides">' . $output . '</ul></div></div>' . "\n\n\n\n" . $script_out;
    }

}
/*****************************************************/








/*
FULL WIDTH SLIDESHOW SHORTCODE
*/
class WPBakeryShortCode_mk_fullwidth_slideshow extends WPBakeryShortCode {
    protected function content( $atts, $content = null ) {
        extract( shortcode_atts( array(
                    "images" => '',
                    "effect" => 'fade',
                    "animation_speed" => 700,
                    "slideshow_speed" => 7000,
                    "pause_on_hover" => "false",
                    "smooth_height" => "true",
                    "direction_nav" => "true",
                    'bg_color' => '',
                    'attachment' => 'scroll',
                    'bg_position' => 'left top',
                    'border_color' => '#eaeaea',
                    'bg_image' => '',
                    'enable_3d' => 'false',
                    'speed_factor' => '',
                    "el_class" => '',
                ), $atts ) );


        wp_enqueue_scripts( 'jquery-flexslider' );
        if ( $images == '' ) return null;
        $id = mt_rand( 99, 9999 );

        $script_out = '';
        if ( $enable_3d == 'true' ) {
            $script_out .= '
                <script type="text/javascript">
                    jQuery(document).ready(function() {
                        if(!is_touch_device()) {
                         jQuery("#flexslider_'.$id.'").parallax("50%", '.$speed_factor.');
                        }
                    });
                 </script>';
        }


        $script_out .= '<script type="text/javascript">

        jQuery(document).ready(function() {
            jQuery(window).on("load",function () {
                jQuery("#flexslider_'.$id.'").flexslider({
                    selector: ".mk-flex-slides > li",
                    slideshow: true,
                    animation: "'.$effect.'",              //String: Select your animation type, "fade" or "slide"
                    smoothHeight: '.$smooth_height.',            //{NEW} Boolean: Allow height of the slider to animate smoothly in horizontal mode
                    slideshowSpeed: '.$slideshow_speed.',           //Integer: Set the speed of the slideshow cycling, in milliseconds
                    animationSpeed: '.$animation_speed.',            //Integer: Set the speed of animations, in milliseconds
                    pauseOnHover: '.$pause_on_hover.',            //Boolean: Pause the slideshow when hovering over slider, then resume when no longer hovering
                    controlNav: false,               //Boolean: Create navigation for paging control of each clide? Note: Leave true for manualControls usage
                    directionNav:'.$direction_nav.',
                    prevText: "",           //String: Set the text for the "previous" directionNav item
                    nextText: ""               //String: Set the text for the "next" directionNav item
                });
            });
        });
        </script>';



        $output = '';
        $images = explode( ',', $images );
        $i = -1;

        foreach ( $images as $attach_id ) {
            $i++;
            $image_src  = wp_get_attachment_image_src( $attach_id, 'full' );


            $output .= '<li>';
            $output .= '<img alt="" src="' . $image_src[0] .'" />';
            $output .= '</li>'. "\n\n";

        }

        $backgroud_image = !empty( $bg_image ) ? 'background-image:url('.$bg_image.'); ' : '';
        return '</div></div>
            <div class="mk-fullwidth-slideshow mk-shortcode mk-flexslider '.$el_class.'" id="flexslider_'.$id.'" style="'. $backgroud_image.'background-color:'.$bg_color.'; background-position:'.$bg_position.';background-attachment:'.$attachment.';border:1px solid '.$border_color.';border-left:none;border-right:none;">
            <ul class="mk-flex-slides">' . $output . '</ul>
            </div><div class="clearboth"></div>
            <div class="theme-page-wrapper full-layout mk-grid row-fluid">
            <div class="theme-content">' . $script_out;
    }

}
/*****************************************************/




/*
Laptop SLIDESHOW SHORTCODE
*/
class WPBakeryShortCode_mk_Laptop_slideshow extends WPBakeryShortCode {
    protected function content( $atts, $content = null ) {
        extract( shortcode_atts( array(
                    "title" => '',
                    "images" => '',
                    "size" => 'full',
                    "animation_speed" => 700,
                    "slideshow_speed" => 7000,
                    "pause_on_hover" => "false",
                    "el_class" => '',
                    'animation' => '',
                    'width' => '1/1',
                    'el_position' => '',
                ), $atts ) );


        wp_enqueue_scripts( 'jquery-flexslider' );
        if ( $images == '' ) return null;
        $id = mt_rand( 99, 9999 );

        $animation_css = '';
        if($animation != '') {
            $animation_css = ' mk-animate-element ' . $animation . ' ';
        }

        $width = wpb_translateColumnWidthToSpan( $width );

        $script_out = '<script type="text/javascript">

        jQuery(document).ready(function() {
            jQuery(window).on("load",function () {
                jQuery("#flexslider_'.$id.'").flexslider({
                    selector: ".mk-flex-slides > li",
                    slideshow: true,
                    animation: "fade",
                    smoothHeight: false,
                    slideshowSpeed: '.$slideshow_speed.',
                    animationSpeed: '.$animation_speed.',
                    pauseOnHover: '.$pause_on_hover.',
                    controlNav: false,
                    directionNav:true,
                    prevText: "",
                    nextText: ""
                }).find(".mk-laptop-image").fadeIn();;
            });
        });
        </script>';

        $heading_title = '';
        if ( !empty( $title ) ) {
            $heading_title = '<h3 class="mk-shortcode mk-fancy-title pattern-style mk-shortcode-heading"><span>'.$title.'</span></h3>';
        }

        $output = '';
        $images = explode( ',', $images );
        $i = -1;

        switch ( $size ) {
        case 'full' :
            $image_width = 682;
            $image_height = 467;
            $container_width = 988;
            $container_height = 523;
            $laptop_image = 'full';
            break;

        case 'one-half' :
            $image_width = 487;
            $image_height = 327;
            $container_width = 701;
            $container_height = 372;
            $laptop_image = 'one-half';
            break;

        case 'one-third' :
            $image_width = 280;
            $image_height = 170;
            $container_width = 330;
            $container_height = 200;
            $laptop_image = 'one-half';
            break;

        case 'one-fourth' :
            $image_width = 185;
            $image_height = 123;
            $container_width = 267;
            $container_height = 142;
            $laptop_image = 'one-fourth';
        }

        foreach ( $images as $attach_id ) {
            $i++;
            $image_src_array = wp_get_attachment_image_src( $attach_id, 'full', true );
            $image_src  = theme_image_resize( $image_src_array[ 0 ], $image_width, $image_height);

            $output .= '<li>';
            $output .= '<img alt="" src="' . $image_src['url'] .'" />';
            $output .= '</li>'. "\n\n";

        }
        $el_position_css = '';
        if ( $el_position != '' ) {
            $el_position_css = $el_position.'-column';
        }
        return '<div class="'.$width.' '.$el_position_css.'">'.$heading_title.'<div style="max-height:'.$container_height.'px;max-width:'.$container_width.'px;" class="mk-laptop-slideshow-shortcode '.$animation_css.$size.'-laptop mk-flexslider '.$el_class.'" id="flexslider_'.$id.'"><img style="display:none" class="mk-laptop-image" src="'.THEME_IMAGES.'/laptop-'.$laptop_image.'.png" alt="" /><ul class="mk-flex-slides" style="max-width:'.$image_width.'px;max-height:'.$image_height.'px;">' . $output . '</ul></div></div>' . "\n\n\n\n" . $script_out;
    }

}
/*****************************************************/



/*
Laptop SLIDESHOW SHORTCODE
*/
class WPBakeryShortCode_mk_lcd_slideshow extends WPBakeryShortCode {
    protected function content( $atts, $content = null ) {
        extract( shortcode_atts( array(
                    'title' => '',
                    "images" => '',
                    "animation_speed" => 700,
                    "slideshow_speed" => 7000,
                    "pause_on_hover" => "false",
                    'animation' => '',
                    'width' => '1/1',
                    'el_position' => '',
                    "el_class" => '',
                ), $atts ) );


        wp_enqueue_scripts( 'jquery-flexslider' );
        if ( $images == '' ) return null;
        $id = mt_rand( 99, 9999 );
        $animation_css = '';
        if($animation != '') {
            $animation_css = ' mk-animate-element ' . $animation . ' ';
        }


        $script_out = '<script type="text/javascript">

        jQuery(document).ready(function() {
            jQuery(window).on("load",function () {
                jQuery("#flexslider_'.$id.'").flexslider({
                    selector: ".mk-flex-slides > li",
                    slideshow: true,
                    animation: "fade",
                    smoothHeight: false,
                    slideshowSpeed: '.$slideshow_speed.',
                    animationSpeed: '.$animation_speed.',
                    pauseOnHover: '.$pause_on_hover.',
                    controlNav: false,
                    directionNav:true,
                    prevText: "",
                    nextText: ""
                }).find(".mk-lcd-image").fadeIn();
                
            });
        });
        </script>';
        $width = wpb_translateColumnWidthToSpan( $width );
        $el_position_css = $heading_title = '';
        if ( $el_position != '' ) {
            $el_position_css = $el_position.'-column';
        }
        $final_output = '<div class="'.$el_position_css.' '.$width.'">';

        if ( !empty( $title ) ) {
            $heading_title = '<h3 class="mk-shortcode mk-fancy-title pattern-style mk-shortcode-heading"><span>'.$title.'</span></h3>';
        }

        $output = '';
        $images = explode( ',', $images );
        $i = -1;


        foreach ( $images as $attach_id ) {
            $i++;
            $image_src_array = wp_get_attachment_image_src( $attach_id, 'full', true );
            $image_src  = theme_image_resize( $image_src_array[ 0 ], 872, 506);

            $output .= '<li>';
            $output .= '<img alt="" src="' . $image_src['url'] .'" />';
            $output .= '</li>'. "\n\n";

        }

        $final_output .= $heading_title.'<div style="max-width:872px;" class="mk-lcd-slideshow mk-flexslider '.$animation_css.$el_class.'" id="flexslider_'.$id.'"><img style="display:none" class="mk-lcd-image" src="'.THEME_IMAGES.'/lcd-slideshow.png" alt="" /><ul class="mk-flex-slides" style="max-width:838px;max-height:506px;">' . $output . '</ul></div></div>' . "\n\n\n\n" . $script_out;
        return $final_output;
    }

}
/*****************************************************/





class WPBakeryShortCode_mk_padding_divider extends WPBakeryShortCode {
    protected function content( $atts, $content = null ) {
        extract( shortcode_atts( array(
                    'size' => '40',
                    'width' => '1/1',
                    'el_position' => '',
                ), $atts ) );
        $output = '';
        $width = wpb_translateColumnWidthToSpan( $width );
        $el_position_css = '';
        if ( $el_position != '' ) {
            $el_position_css = $el_position.'-column';
        }
        $output .= '<div class="clearboth"></div><div class="'.$el_position_css.' '.$width.'">';
        $output .= '<div class="mk-shortcode mk-padding-shortcode" style="height:'.$size.'px"></div><div class="clearboth"></div>';
        $output .= '</div>';
        return $output;
    }
}
/*****************************************************/









class WPBakeryShortCode_mk_contact_form extends WPBakeryShortCode {
    protected function content( $atts, $content = null ) {

        extract( shortcode_atts( array(
                    'title' => '',
                    'email' => get_bloginfo( 'admin_email' ),
                    'el_class' => '',
                    'el_position' => '',
                    'width' => '1/1',
                ), $atts ) );
        $id = mt_rand( 99, 999 );
        $file_path = THEME_DIR_URI;
        $tabindex_1 = $id;
        $tabindex_2 = $id + 1;
        $tabindex_3 = $id + 2;
        $tabindex_4 = $id + 3;
        $name_str = __( 'Name', 'mk_framework' );
        $email_str = __( 'Email', 'mk_framework' );
        $submit_str = __( 'Submit', 'mk_framework' );
        $content_str = __( 'Your message', 'mk_framework' );
        $width = wpb_translateColumnWidthToSpan( $width );
        $el_position_css = '';
        if ( $el_position != '' ) {
            $el_position_css = $el_position.'-column';
        }
        $fancy_title = '';
        if ( !empty( $title ) ) {
            $fancy_title = '<h3 class="mk-shortcode mk-fancy-title pattern-style mk-shortcode-heading"><span>'.$title.'</span></h3>';
        }
        return <<<HTML
    <div class="{$width} {$el_position_css}">
{$fancy_title}
<div class="mk-contact-form-shortcode mk-shortcode {$el_class}">
    <form class="mk-contact-form" action="{$file_path}/sendmail.php" method="post" novalidate="novalidate">
        <div class="mk-form-row"><i class="mk-icon-user"></i><input placeholder="{$name_str}" type="text" required="required" id="contact_name" name="contact_name" class="text-input watermark-input" value="" tabindex="{$tabindex_1}" /></div>
        <div class="mk-form-row"><i class="mk-icon-envelope"></i><input placeholder="{$email_str}" type="email" required="required" id="contact_email" name="contact_email" class="text-input watermark-input" value="" tabindex="{$tabindex_2}" /></div>
        <div class="mk-form-row"><i class="mk-icon-pencil"></i><textarea required="required" placeholder="{$content_str}" name="contact_content" id="contact_content" class="mk-textarea" tabindex="{$tabindex_3}"></textarea></div>
        <div class="mk-form-row" style="float:left;"><button tabindex="{$tabindex_4}" class="mk-button mk-skin-button three-dimension contact-form-button medium">{$submit_str}</button></div>
        <i class="mk-contact-loading mk-icon-spinner mk-icon-spin"></i>
        <i class="mk-contact-success mk-icon-ok-sign"></i>
        <input type="hidden" value="{$email}" name="contact_to"/>
    </form>
    <div class="clearboth"></div>

</div>
</div>
HTML;

    }
}
/*****************************************************/






class WPBakeryShortCode_mk_faq extends WPBakeryShortCode {
    protected function content( $atts, $content = null ) {
        extract( shortcode_atts( array(
                    "sortable" => 'true',
                    'order'=> 'DESC',
                    'count' => -1,
                    'style'=> 'fancy',
                    'offset' => '',
                    'orderby'=> 'date',

                ), $atts ) );

        $query = array(
            'post_type' => 'faq',
            'posts_per_page' => (int)$count,
        );

        if ( $orderby ) {
            $query['orderby'] = $orderby;
        }
        if ( $order ) {
            $query['order'] = $order;
        }
        if ( $offset ) {
            $query['offset'] = $offset;
        }

        $r = new WP_Query( $query );


        $output = '';
        if ( $sortable == 'true' ) {
            $output .= '<header class="filter-faq"><ul>';
            $terms = array();

            $terms = get_terms( 'faq_category', 'hide_empty=1' );
            $output .= '<li><a class="current" data-filter="" href="#">'.__( 'All', 'mk_framework' ).'</a></li>';
            foreach ( $terms as $term ) {
                $output .= '<li><a data-filter="'.$term->slug . '" href="#">' . $term->name . '</a></li>';
            }
            $output .= '<div class="clearboth"></div></ul></header><div class="clearboth"></div>';
        }

        $output .= '<section class="mk-faq-container '.$style.'-style-wrapper" >';

        if ( $r->have_posts() ):
            while ( $r->have_posts() ) :
                $r->the_post();

            $terms = get_the_terms( get_the_id(), 'faq_category' );
        $terms_slug = array();
        $terms_name = array();
        if ( is_array( $terms ) ) {
            foreach ( $terms as $term ) {
                $terms_slug[] = $term->slug;
                $terms_name[] = $term->name;
            }
        }
        $output .= '<div class="mk-toggle '.$style.'-style mk-faq-toggle ' . implode( ' ', $terms_slug ) . '">';
        $output .= '<span class="mk-toggle-title"><i class="mk-icon-question-sign"></i>'.get_the_title().'</span>';
        $output .= '<div class="mk-toggle-pane">'.get_the_content().'</div>';
        $output .= '</div>';
        endwhile;
        endif;

        $output .= '<div class="clearboth"></div></section><div class="clearboth"></div>';


        wp_reset_query();

        return $output;
    }
}








class WPBakeryShortCode_mk_contact_info extends WPBakeryShortCode {
    protected function content( $atts, $content = null ) {

        extract( shortcode_atts( array(
                    'title' => '',
                    'phone' => '',
                    'fax' => '',
                    'email' => '',
                    'address' => '',
                    'website' => '',
                    'company' => '',
                    'person' => '',
                    'skype' => '',
                    'width' => '1/1',
                    'el_position' => '',
                    'el_class' => ''
                ), $atts ) );
        $width = wpb_translateColumnWidthToSpan( $width );
        $output = '';
        $el_position_css = '';
        if ( $el_position != '' ) {
            $el_position_css = $el_position.'-column';
        }
        $output .= '<div class="'.$width.' '.$el_position_css.'">';
        $output .= '<div class="widget_contact_info mk-contactinfo-shortcode">';
        if ( !empty( $title ) ) {
            $output .= '<h3 class="mk-shortcode mk-fancy-title pattern-style mk-shortcode-heading"><span>'.$title.'</span></h3>';
        }
        $output .= '<ul>';
        $output .= !empty( $person )  ? '<li><i class="mk-moon-user-7"></i><span>'.$person.'</span></li>' : '';
        $output .= !empty( $company )  ? '<li><i class="mk-moon-office"></i><span>'.$company.'</span></li>' : '';        
        $output .= !empty( $address )  ? '<li><i class="mk-icon-home"></i><span>'.$address.'</span></li>' : '';
        $output .= !empty( $phone )  ? '<li><i class="mk-icon-phone"></i><span>'.$phone.'</span></li>' : '';
        $output .= !empty( $fax )  ? '<li><i class="mk-icon-print"></i><span>'.$fax.'</li></span>' : '';
        $output .= !empty( $email )  ? '<li><i class="mk-icon-envelope-alt"></i><span><a href="mailto:'.antispambot($email).'">'.antispambot($email).'</a></span></li>' : '';
        $output .= !empty( $website )  ? '<li><i class="mk-icon-globe"></i><span><a href="'.$website.'">'.str_replace('http://', '', $website).'</a></span></li>' : '';
        $output .= !empty( $skype )  ? '<li><i class="mk-moon-skype"></i><span><a href="skype:'.$skype.'?call">'.$skype.'</a></span></li>' : '';
        $output .= '</ul>';
        $output .= '</div></div>';

        return $output;

    }
}
/*****************************************************/









class WPBakeryShortCode_mk_portfolio_carousel extends WPBakeryShortCode {

    public function content( $atts, $content = null ) {

        extract( shortcode_atts( array(
                    'title' => '',
                    'view_all' => '',
                    'count'=> 10,
                    'author' => '',
                    'posts' => '',
                    'offset' => 0,
                    'cat' => '',
                    'order'=> 'DESC',
                    'orderby'=> 'date',
                    'el_class' => '',
                    'el_position' => '',
                    'width' => '1/1',
                ), $atts ) );
        wp_enqueue_script( 'jquery-flexslider' );
        $id = mt_rand( 99, 999 );
        $query = array(
            'post_type' => 'portfolio',
            'posts_per_page' => (int)$count,
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


        $width = wpb_translateColumnWidthToSpan( $width );
        $output = '';
        $el_position_css = '';
        if ( $el_position != '' ) {
            $el_position_css = $el_position.'-column';
        }
        $output .= '<div class="'.$width.' '.$el_position_css.'">';
        $output .= '<div class="mk-shortcode mk-portfolio-carousel '.$el_class.'">';
        $output .= '<h3 class="mk-shortcode mk-fancy-title pattern-style"><span>'.$title.'</span>';
        $output .= '<a href="'.get_permalink( $view_all ).'" class="mk-portfolio-view-all">'.__( 'VIEW ALL', 'mk_framework' ).'</a></h3>';

        $output .= '<div id="mk-portfolio-carousel-'.$id.'" class="mk-flexslider"><ul class="mk-flex-slides">';

        if ( $r->have_posts() ):
            while ( $r->have_posts() ) :
                $r->the_post();

            $terms = get_the_terms( get_the_id(), 'portfolio_category' );
        $terms_slug = array();
        $terms_name = array();
        if ( is_array( $terms ) ) {
            foreach ( $terms as $term ) {
                $terms_slug[] = $term->slug;
                $terms_name[] = $term->name;
            }
        }

        $image_src_array = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full', true );
        $image_src  = theme_image_resize( $image_src_array[ 0 ], 260, 180);

        $output .= '<li>';
        $output .= '<div class="mk-portfolio-carousel-thumb"><img width="260" height="180" src="'.$image_src['url'].'" alt="'.get_the_title().'" title="'.get_the_title().'" />';
        $output .= '<div class="portfolio-carousel-overlay"></div>';
        $output .= '<a class="mk-lightbox portfolio-carousel-lightbox" alt="'.get_the_title().'" title="'.get_the_title().'" rel="prettyPhoto[p-c-'.$id.']" href="'.$image_src_array[0].'"><i class="mk-icon-zoom-in"></i></a>';
        $output .= '<a class="portfolio-carousel-permalink" href="'.get_permalink().'"><i class="mk-icon-link"></i></a>';
        $output .= '</div>';
        $output .= '<div class="portfolio-carousel-extra-info">';
        $output .= '<a class="portfolio-carousel-title" href="'.get_permalink().'">'.get_the_title().'</a><div class="clearboth"></div>';
        $output .= '<div class="portfolio-carousel-cats">'.implode( ' ', $terms_name ).'</div>';
        $output .= '</div>';

        $output .= '</li>';

        endwhile;
        endif;
        wp_reset_query();

        $output .= '</ul></div><div class="clearboth"></div></div></div>';


        $output .= '<script type="text/javascript">
        jQuery(document).ready(function() {
            jQuery(window).on("load",function () {
                jQuery("#mk-portfolio-carousel-'.$id.'").flexslider({
                    selector: ".mk-flex-slides > li",
                    slideshow: true,
                    animation: "slide",              //String: Select your animation type, "fade" or "slide"
                    smoothHeight: true,            //{NEW} Boolean: Allow height of the slider to animate smoothly in horizontal mode
                    slideshowSpeed: 6000,           //Integer: Set the speed of the slideshow cycling, in milliseconds
                    animationSpeed: 400,            //Integer: Set the speed of animations, in milliseconds
                    pauseOnHover: true,            //Boolean: Pause the slideshow when hovering over slider, then resume when no longer hovering
                    controlNav: false,               //Boolean: Create navigation for paging control of each clide? Note: Leave true for manualControls usage
                    directionNav:true,
                    prevText: "",           //String: Set the text for the "previous" directionNav item
                    nextText: "",               //String: Set the text for the "next" directionNav item
                    itemWidth: 275,
                    itemMargin: 0,
                    maxItems: 4,
                    minItems: 1,
                    move: 1
                });
            });
        });
        </script>';
        return $output;
    }
}





class WPBakeryShortCode_mk_blog_carousel extends WPBakeryShortCode {

    public function content( $atts, $content = null ) {

        extract( shortcode_atts( array(
                    'title' => '',
                    'view_all' => '',
                    'count'=> 10,
                    'author' => '',
                    'posts' => '',
                    'offset' => 0,
                    'cat' => '',
                    'order'=> 'DESC',
                    'orderby'=> 'date',
                    'el_class' => '',
                    'enable_excerpt' => 'false',
                    'el_position' => '',
                    'width' => '1/1',
                ), $atts ) );
        global $post;
        wp_enqueue_script( 'jquery-flexslider' );
        $id = mt_rand( 99, 999 );
        $query = array(
            'post_type' => 'post',
            'posts_per_page' => (int)$count,
        );
        if ( $offset ) {
            $query['offset'] = $offset;
        }
        if ( $cat ) {
            $query['cat'] = $cat;
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


        $width = wpb_translateColumnWidthToSpan( $width );
        $output = '';
        $el_position_css = '';
        if ( $el_position != '' ) {
            $el_position_css = $el_position.'-column';
        }
        $output .= '<div class="'.$width.' '.$el_position_css.'">';
        $output .= '<div class="mk-shortcode mk-blog-carousel '.$el_class.'">';
        if(!empty($title)) {
        $output .= '<h3 class="mk-shortcode mk-fancy-title pattern-style"><span>'.$title.'</span>';
        $output .= '<a href="'.get_permalink( $view_all ).'" class="mk-blog-view-all">'.__( 'VIEW ALL', 'mk_framework' ).'</a></h3>';
        }
        $output .= '<div id="mk-blog-carousel-'.$id.'" class="mk-flexslider"><ul class="mk-flex-slides">';

        if ( $r->have_posts() ):
            while ( $r->have_posts() ) :
                $r->the_post();
        $post_type = get_post_meta( $post->ID, '_single_post_type', true );
        if($post_type != 'audio') {
        
        if($post_type == '') {
            $post_type = 'image';
        }
        $image_src_array = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full', true );
        

        $output .= '<li><div><div class="blog-carousel-thumb">';
        
        if(has_post_thumbnail()) {
        $image_src  = theme_image_resize( $image_src_array[ 0 ], 245, 180);
        } else {
        $image_src  = theme_image_resize(THEME_IMAGES . '/empty-thumb.png', 245, 180);    
        }
        $output .= '<img src="'.$image_src['url'].'" alt="'.get_the_title().'" title="'.get_the_title().'" />';
        $output .= '<div class="blog-carousel-overlay"></div>';
        $output .='<a class="post-type-badge '.$post_type.'-icon" href="'.get_permalink().'"><span></span></a>';
        $output .= '</div>';
        $output .='<h5 class="blog-carousel-title"><a href="'.get_permalink().'">'.get_the_title().'</a></h5>';
        if($enable_excerpt == 'true') {
            $output .='<p class="blog-carousel-excerpt">'.get_the_excerpt().'</p>';
        }
        $output .= '</div></li>';
        }
        endwhile;
        endif;
        wp_reset_query();

        $output .= '</ul></div><div class="clearboth"></div></div></div>';


        $output .= '<script type="text/javascript">
        jQuery(document).ready(function() {
            jQuery(window).on("load",function () {
                jQuery("#mk-blog-carousel-'.$id.'").flexslider({
                    selector: ".mk-flex-slides > li",
                    slideshow: true,
                    animation: "slide",              //String: Select your animation type, "fade" or "slide"
                    smoothHeight: false,            //{NEW} Boolean: Allow height of the slider to animate smoothly in horizontal mode
                    slideshowSpeed: 6000,           //Integer: Set the speed of the slideshow cycling, in milliseconds
                    animationSpeed: 400,            //Integer: Set the speed of animations, in milliseconds
                    pauseOnHover: true,            //Boolean: Pause the slideshow when hovering over slider, then resume when no longer hovering
                    controlNav: false,               //Boolean: Create navigation for paging control of each clide? Note: Leave true for manualControls usage
                    directionNav:true,
                    prevText: "",           //String: Set the text for the "previous" directionNav item
                    nextText: "",               //String: Set the text for the "next" directionNav item
                    itemWidth: 275,
                    itemMargin: 0,
                    maxItems: 4,
                    minItems: 1,
                    move: 1
                });
            });
        });
        </script>';
        return $output;
    }
}


class WPBakeryShortCode_mk_blog_showcase extends WPBakeryShortCode {

    public function content( $atts, $content = null ) {

        extract( shortcode_atts( array(
                    'author' => '',
                    'posts' => '',
                    'cat' => '',
                    'offset' => '',
                    'order'=> 'DESC',
                    'orderby'=> 'date',
                    'el_class' => '',
                ), $atts ) );
        $output = '';
        $id = mt_rand( 99, 999 );
        $query = array(
            'post_type' => 'post',
            'posts_per_page' => 3,
            'ignore_sticky_posts' => 1
        );
        if ( $cat ) {
            $query['cat'] = $cat;
        }
        if ( $author ) {
            $query['author'] = $author;
        }
        if ( $offset ) {
            $query['offset'] = $offset;
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


        $output .= '<div class="mk-shortcode mk-blog-showcase '.$el_class.'">';
        $output .= '<ul>';

        $i = 0;
        if ( $r->have_posts() ):
            while ( $r->have_posts() ) :
                $r->the_post();
            $i++;

        $image_src_array = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full', true );
        $image_src  = theme_image_resize( $image_src_array[ 0 ], 260, 180);

        $first_el_class = $i == 1 ? 'mk-blog-first-el' : '';

        $output .= '<li class="'.$first_el_class.'">';
        $output .= '<div class="mk-blog-showcase-thumb"><div class="showcase-blog-overlay"></div><a href="'.get_permalink().'"><i class="mk-icon-plus"></i></a><img src="'.$image_src['url'].'" alt="'.get_the_title().'" title="'.get_the_title().'" /></div>';
        $output .= '<div class="blog-showcase-extra-info">';
        $output .='<time datetime="'.get_the_time( 'F jS, Y' ).'">';
        $output .='<a href="'.get_month_link( get_the_time( "Y" ), get_the_time( "m" ) ).'">'.get_the_time( 'F jS, Y' ).'</a>';
        $output .='</time>';
        $output .= '<a class="blog-showcase-title" href="'.get_permalink().'">'.get_the_title().'</a><div class="clearboth"></div>';
        $output .='<div class="the-excerpt">'.get_the_excerpt().'</div>';
        $output .='<a href="'.get_permalink().'" class="blog-showcase-more">'.__( 'Read more' , 'mk_framework' ).'<i class="mk-icon-double-angle-right"></i></a>';
        $output .= '</div>';

        $output .= '</li>';

        endwhile;
        wp_reset_query();
        endif;
        

        $output .= '<div class="clearboth"></div></ul></div>';
        return $output;
    }
}





class WPBakeryShortCode_mk_audio extends WPBakeryShortCode {

    public function content( $atts, $content = null ) {

        extract( shortcode_atts( array(
                    'mp3_file' => '',
                    'ogg_file' => '',
                    'audio_author' => '',
                    'thumb'=> '',
                    'el_class' => '',
                    'el_position' => '',
                    'width' => '1/1',
                ), $atts ) );
                wp_enqueue_script( 'jquery-jplayer' );
                $output = '';
                $audio_id = mt_rand( 99, 999 );                
                $image_src  = theme_image_resize( $thumb, 50, 50);
                $width = wpb_translateColumnWidthToSpan( $width );
                $el_position_css = '';
                if ( $el_position != '' ) {
                    $el_position_css = $el_position.'-column';
                }
                $output .= '<div class=" '.$el_class.' '.$el_position_css.' '.$width.'">';
                $output .= '<div class="mk-single-audio mk-shortcode '.$el_class.'">';
                if ( $thumb ) {
                    $output .= '<img alt="'.get_the_title().'" title="'.get_the_title().'" src="'.get_image_src( $image_src['url'] ).'" />';
                }
                if($audio_author) {
                    $output .= '<span class="mk-audio-author">'.$audio_author.'</span>';
                }
            $output .= '<script type="">

        jQuery(document).ready(function($) {

                jQuery("#jquery_jplayer_'.$audio_id.'").jPlayer({
                    ready: function () {
                        $(this).jPlayer("setMedia", {';
            if ( $mp3_file ) {
                $output .= 'mp3: "'.$mp3_file.'",';
            }
            if ( $ogg_file ) {
                $output .= 'ogg: "'.$ogg_file.'",';
            }

            $output .= ' });
                    },
                    play: function() { // To avoid both jPlayers playing together.
                        $(this).jPlayer("pauseOthers");
                    },
                    swfPath: "'.THEME_JS.'",
                    supplied: "mp3, ogg",
                    cssSelectorAncestor: "#jp_container_'.$audio_id.'",
                    wmode: "window"
                });

        })

        </script>
        <div id="jquery_jplayer_'.$audio_id.'" class="jp-jplayer"></div>
        <div id="jp_container_'.$audio_id.'" class="jp-audio">
            <div class="jp-type-single">
                    <div class="jp-gui jp-interface">
                        <div class="jp-time-holder">
                            <div class="jp-current-time"></div> /
                            <div class="jp-duration"></div>
                        </div>
                        
                        <div class="jp-progress">
                            <div class="jp-seek-bar">
                                <div class="jp-play-bar"></div>
                            </div>
                        </div>
                        <div class="jp-volume-bar">
                            <i class="mk-icon-volume-off"></i><div class="inner-value-adjust"><div class="jp-volume-bar-value"></div></div>
                        </div>
                        <ul class="jp-controls">
                            <li><a href="javascript:;" class="jp-play" tabindex="1"><i class="mk-icon-play"></i></a></li>
                            <li><a href="javascript:;" class="jp-pause" tabindex="1"><i class="mk-icon-pause"></i></a></li>
                        </ul>
                    </div>
                    <div class="jp-no-solution">
                        <span>Update Required</span>
                        To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
                    </div>
                </div>
            </div></div></div>';
        return $output;
    }
}




class WPBakeryShortCode_mk_countdown extends WPBakeryShortCode {

    public function content( $atts, $content = null ) {

        extract( shortcode_atts( array(
                    'title' => '',
                    'year' => '',
                    'month' => '',
                    'hour' => '',
                    'day' => '',
                    'minute' => '',
                    'el_position' => '',
                    'width' => '1/1',
                    'el_class' => '',
                ), $atts ) );
        $output = $el_position_css = '';
        $id = mt_rand(99,999);
        wp_enqueue_script('jquery-countdown', THEME_JS. '/jquery.countdown.js', array('jquery'), false, true);
        $width = wpb_translateColumnWidthToSpan( $width );
        if ( $el_position != '' ) {
            $el_position_css = $el_position.'-column';
        }
        $output .= '<div class=" '.$el_class.' '.$el_position_css.' '.$width.' mk-event-countdown">';
        if ( !empty( $title ) ) {
            $output .= '<div class="mk-event-title">'.$title.'</div>';
        }
        $output .= '<ul id="mk-uc-countdown" class="event-countdown-'.$id.'">
                        <li>
                            <span class="days timestamp">00</span>
                            <span class="timeRef">'.__('days', 'mk_framework').'</span>
                        </li>
                        <li>
                            <span class="hours timestamp">00</span>
                            <span class="timeRef">'.__('hours', 'mk_framework').'</span>
                        </li>
                        <li>
                            <span class="minutes timestamp">00</span>
                            <span class="timeRef">'.__('minutes', 'mk_framework').'</span>
                        </li>
                        <li>
                            <span class="seconds timestamp">00</span>
                            <span class="timeRef">'.__('seconds', 'mk_framework').'</span>
                        </li>
                    </ul>
            <script>
                jQuery(document).ready(function(){
                    jQuery(".event-countdown-'.$id.'").countdown({
                        date: "'.$day.' '.$month.' '.$year.' '.$hour.':'.$minute.':00",
                        format: "on"
                    });
                });
            </script>';
            $output .= '</div>';
        return $output;
    }
}


class WPBakeryShortCode_mk_clearboth extends WPBakeryShortCode {
    public function content( $atts, $content = null ) {
        return '<div class="clearboth"></div>';
    }
}        

function mk_clearboth( $atts, $content = null, $code ) {
    return '<div class="clearboth"></div>';
}

add_shortcode( 'clearboth', 'mk_clearboth' );
