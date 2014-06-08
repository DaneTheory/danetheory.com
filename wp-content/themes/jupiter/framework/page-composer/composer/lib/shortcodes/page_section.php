<?php
/**
 * WPBakery Visual Composer shortcodes
 *
 * @package WPBakeryVisualComposer
 *
 */

class WPBakeryShortCode_mk_page_section extends WPBakeryShortCode {

   
    public function content( $atts, $content = null ) {

        $el_class = $width = $el_position = '';

        extract( shortcode_atts( array(
                    'el_class' => '',
                    'bg_color' => '',
                    'border_color' => '',
                    'bg_image' => '',
                    'bg_repeat' => 'repeat',
                    'predefined_bg' => '',
                    'section_layout' => '',
                    'sidebar' => '',
                    'bg_stretch' => '',
                    'attachment' => '',
                    'top_shadow' => '',
                    'bg_position' => 'left top',
                    'enable_3d' => 'false',
                    'speed_factor' => '',
                    'min_height' => 100,
                    'margin_bottom' => '10',
                    'padding_top' => '10',
                    'padding_bottom' => '10',
                    'last_page' => 'false',
                    'first_page' => 'false',
                    'el_position' => '',
                ), $atts ) );

        $output = $bg_stretch_class = $top_shadow_css = $first_page_css ='';

        $el_class = $this->getExtraClass( $el_class );
        $id = mt_rand(99,9999);
        global $post;
        
            if($bg_stretch == 'true') {
                $bg_stretch_class = 'mk-background-stretch ';
            }
            if($first_page == 'true') {
                $first_page_css = 'mk-page-section-frist ';
            }
            if($top_shadow == 'true') {
                $top_shadow_css = ' drop-top-shadow';
            }
            if(!empty($bg_image)) {
            $backgroud_image = !empty($bg_image) ? 'background-image:url('.$bg_image.'); ' : '';
                } else {
            $backgroud_image = !empty($predefined_bg) ? 'background-image:url('.THEME_IMAGES.'/pattern/'.$predefined_bg.'.png);' : '';
             }
            $border_css = (empty($bg_image) && !empty($border_color)) ? 'border:1px solid '.$border_color.';border-left:none;border-right:none;' : '';
            $output .= '<div class="clearboth"></div></div></div>';
            $output .= '<div id="full-width-'.$id.'" class="row-fluid '.$first_page_css.$bg_stretch_class.$top_shadow_css.' mk-page-section mk-blur-parent mk-shortcode '.$el_class.'">';
            if($section_layout == 'full') {
            $output .= '<div class="mk-grid row-fluid"><div class="mk-padding-wrapper">'.wpb_js_remove_wpautop( $content ).'</div><div class="clearboth"></div></div>';
            $output .= '<div class="clearboth"></div></div>';
            } else {
                $output .= '<div class="theme-page-wrapper '.$section_layout.'-layout mk-grid row-fluid">';
                $output .= '<div class="theme-content" style="padding-top:0;padding-bottom:0;">'.wpb_js_remove_wpautop( $content ).'<div class="clearboth"></div></div>';
                $output .= '<aside id="mk-sidebar" class="mk-builtin"><div class="sidebar-wrapper" style="padding-top:0;padding-bottom:0;">';
                ob_start();
                dynamic_sidebar($sidebar);
                $output .= ob_get_contents();
                ob_end_clean();
                $output .= '</div></aside>';
                $output .= '<div class="clearboth"></div></div></div>';
            }
            $output .= '<style type="text/css">
                   #full-width-'.$id.' {
                        min-height:'.$min_height.'px;
                        padding:'.$padding_top.'px 0 '.$padding_bottom.'px;
                        '. $backgroud_image.'
                        background-attachment:'.$attachment.';
                        '.($bg_color ? ('background-color:'.$bg_color.';') : '').'
                        background-position:'.$bg_position.';
                        background-repeat:'.$bg_repeat.';
                        margin-bottom:'.$margin_bottom.'px;
                        '.$border_css.'
                  }
                 #full-width-'.$id.' .mk-fancy-title span{
                        background-color: '.$bg_color.' !important;
                    }
                 </style>';
            if($enable_3d == 'true') {
                $output .= '<script type="text/javascript">
                    jQuery(document).ready(function() {
                        if(!is_touch_device()) {
                         jQuery("#full-width-'.$id.'").parallax("49%", '.$speed_factor.');
                        }
                    });
                 </script>';
            } 
            
            if($last_page == 'true') {
                $output .= '<div><div>';
            }   else {
            $layout = get_post_meta( $post->ID, '_layout', true );
            $output .= '<div class="theme-page-wrapper '.$layout.'-layout mk-grid row-fluid">';
            $output .= '<div class="theme-content">';
            }

            return $output;


    }

    public function contentAdmin( $atts, $content = null ) {
        $width = $el_class = '';
        extract( shortcode_atts( array(
                    'el_class' => '',
                    'bg_color' => '',
                    'sidebar' => '',
                    'section_layout'=> 'full',
                    'border_color' => '',
                    'predefined_bg' => '',
                    'bg_image' => '',
                    'bg_stretch' => '',
                    'top_shadow' => '',
                    'attachment' => '',
                    'bg_repeat' => 'repeat',
                    'enable_3d' => 'false',
                    'min_height' => 100,
                    'padding_top' => '10',
                    'padding_bottom' => '10',
                    'speed_factor' => '',
                    'bg_position' => '',
                    'margin_bottom' => '10',
                    'last_page' => '',
                    'first_page' => '',
                    'width' => 'column_12'
                ), $atts ) );

        $output = '';
        $width = 'span12';
        $column_controls = $this->getColumnControls( 'edit_popup_delete' );


        $output .= '<div data-element_type="'.$this->settings["base"].'" class="wpb_vc_column wpb_content_element wpb_sortable wpb_droppable '.$width.' not-column-inherit">';
        $output .= '<input type="hidden" class="wpb_vc_sc_base" name="element_name-'.$this->shortcode.'" value="'.$this->settings["base"].'" />';
        $output .= $column_controls;
        $output .= '<div class="wpb_element_wrapper">';
        $output .= '<div class="mk-shortcode-param-name">Page Section</div>';
        $output .= '<div class="row-fluid wpb_column_container wpb_sortable_container not-column-inherit">';
        $output .= do_shortcode( shortcode_unautop( $content ) );
        $output .= '</div>';
        if ( isset( $this->settings['params'] ) ) {
            $iner = '';
            foreach ( $this->settings['params'] as $param ) {
                $param_value = $$param['param_name'];
                //var_dump($param_value);
                if ( is_array( $param_value ) ) {
                    // Get first element from the array
                    reset( $param_value );
                    $first_key = key( $param_value );
                    $param_value = $param_value[$first_key];
                }
                $iner .= $this->singleParamHtmlHolder( $param, $param_value );
            }
            $output .= $iner;
        }
        $output .= '</div>';
        $output .= '</div>';


        return $output;
    }
}
