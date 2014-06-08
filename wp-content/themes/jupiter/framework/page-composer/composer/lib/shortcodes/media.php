<?php
/**
 */

class WPBakeryShortCode_VC_Video extends WPBakeryShortCode {

    protected function content( $atts, $content = null ) {
        $title = $link = $size = $el_position = $width = $el_class = '';
        extract(shortcode_atts(array(
            'title' => '',
            'link' => '',
            'el_position' => '',
            'width' => '1/1',
            'el_class' => '',
            'animation' => '',
            'el_position' => '',
        ), $atts));
        $output = $animation_css ='';

        if ( $link == '' ) { return null; }
        $el_class = $this->getExtraClass($el_class);
        $width = wpb_translateColumnWidthToSpan($width);
        
        $el_position_css = '';
        if ( $el_position != '' ) {
            $el_position_css = $el_position.'-column';
        }
        if($animation != '') {
            $animation_css = ' mk-animate-element ' . $animation . ' ';
        } 
        global $wp_embed;
        $embed = $wp_embed->run_shortcode('[embed width="1140" height="641"]'.$link.'[/embed]');

        $output .= "\n\t".'<div class="wpb_video_widget '.$animation_css.$width.$el_class.' '.$el_position_css.'">';
        $output .= "\n\t\t".'<div class="wpb_wrapper">';
        if(!empty($title)) {
        $output .= '<h3 class="mk-shortcode mk-fancy-title pattern-style mk-shortcode-heading"><span>'.$title.'</span></h3>';
            }
        $output .= '<div class="video-container">' . $embed . '</div>';
        $output .= "\n\t\t".'</div> '.$this->endBlockComment('.wpb_wrapper');
        $output .= "\n\t".'</div> '.$this->endBlockComment($width);

        $output = $this->startRow($el_position) . $output . $this->endRow($el_position);
        return $output;
    }
}
class WPBakeryShortCode_VC_Gmaps extends WPBakeryShortCode {

    protected function content( $atts, $content = null ) {

        $title = $link = $size = $zoom = $type = $el_position = $el_class = '';
        extract(shortcode_atts(array(
            'title' => '',
            'link' => '',
            'size' => 200,
            'zoom' => 14,
            'type' => 'm',
            'frame_style' => '',
            'width' => '',
            'el_position' => '',
            'el_class' => ''
        ), $atts));
        $output = '';

        if ( $link == '' ) { return null; }

       $width = wpb_translateColumnWidthToSpan( $width );
        $el_position_css = '';
        if ( $el_position != '' ) {
            $el_position_css = $el_position.'-column';
        }
        $output = '';
        $output .= '<div class="'.$width.' '.$el_position_css.'">';
        $output .= '<div class="wpb_gmaps_widget '.$el_class.'">';
        if(!empty($title)) {
            $output .= '<h3 class="mk-shortcode mk-fancy-title pattern-style mk-shortcode-heading" style="text-align:left;"><span>'.$title.'</span></h3>';
        }
        $output .= '<div class="wpb_map_wraper '.$frame_style.'-frame"><iframe width="100%" height="'.$size.'" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="'.$link.'&amp;t='.$type.'&amp;z='.$zoom.'&amp;output=embed"></iframe></div>';
        $output .= '</div> </div>';

        return $output;
    }
}