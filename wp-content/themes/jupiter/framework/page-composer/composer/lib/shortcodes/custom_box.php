<?php
/**
 * WPBakery Visual Composer shortcodes
 *
 * @package WPBakeryVisualComposer
 *
 */

class WPBakeryShortCode_mk_custom_box extends WPBakeryShortCode {

    public function content( $atts, $content = null ) {

        $el_class = $width = $el_position = '';

        extract(shortcode_atts(array(
            'el_class' => '',
            'border_color' => '',
            'bg_color' => '',
            'bg_image' => '',
            'bg_position' => 'center center',
            'bg_repeat' => 'repeat',
            'bg_stretch' => '',
            'predefined_bg' => '',
            'padding_horizental' => '20',
            'padding_vertical' => '20',
            'min_height' => '',
            'margin_bottom' => '10',
            'width' => '',
            'el_position' => '',
        ), $atts));

        $output = $bg_stretch_class = '';
        $id = mt_rand(99,999);

        if($bg_stretch == 'true') {
                $bg_stretch_class = 'mk-background-stretch';
            }

        if(!empty($bg_image)) {
            $backgroud_image = !empty($bg_image) ? 'background-image:url('.$bg_image.'); ' : '';
        } else {
            $backgroud_image = !empty($predefined_bg) ? 'background-image:url('.THEME_IMAGES.'/pattern/'.$predefined_bg.'.png);' : '';
        }
        $border = !empty($border_color) ? ('border:1px solid '.$border_color.';') : '';

         $width = wpb_translateColumnWidthToSpan( $width );
        $el_position_css = '';
        if ( $el_position != '' ) {
            $el_position_css = $el_position.'-column';
        }

        $output .= '<div class="'.$width.' '.$el_position_css.'">';
        $output .= '<div id="mk-custom-box-'.$id.'" class="mk-custom-boxed mk-blur-parent mk-shortcode '.$bg_stretch_class.' '.$el_class.'" style="margin-bottom:'.$margin_bottom.'px">';
        $output .= wpb_js_remove_wpautop($content);
        $output .= '<div class="clearboth"></div></div></div>';
        $output .= '<style type="text/css">
                   #mk-custom-box-'.$id.' {
                        min-height:'.$min_height.'px;
                        padding:'.$padding_vertical.'px '.$padding_horizental.'px;
                        '. $backgroud_image.'
                        background-attachment:scroll;
                        background-repeat:'.$bg_repeat.';
                        background-color:'.$bg_color.';
                        background-position:'.$bg_position.';
                        margin-bottom:'.$margin_bottom.'px;
                        '.$border.'
                        
                  }
                 #mk-custom-box-'.$id.' .mk-fancy-title.pattern-style span{
                        background-color: '.$bg_color.' !important;
                    }
                 </style>';


            return $output;

          
    }

    public function contentAdmin($atts, $content = null) {
        $width = $el_class = '';
        extract(shortcode_atts(array(
            'el_class' => '',
            'border_color' => '',
            'bg_color' => '',
            'bg_image' => '',
            'predefined_bg' => '',
            'bg_stretch' => '',
            'bg_position' => 'center center',
            'bg_repeat' => 'repeat',
            'padding_horizental' => '20',
             'padding_vertical' => '20',
            'min_height' => '',
            'margin_bottom' => '10',
            'el_position' => '',
            'width' => ''
        ), $atts));

        $output = '';
        
        $column_controls = $this->getColumnControls('full');


        if ( $width == 'column_14' || $width == '1/4' ) {
            $width = 'span3';
        }

        else if ( $width == '1/3' ) {
            $width = 'span4';
        }

        else if ( $width == '1/2' ) {
            $width = 'span6';
        }
        else if ( $width == '2/3' ) {
            $width = 'span8';
        }
        else if ( $width == '3/4' ) {
            $width = 'span9';
        }
        else if ( $width == '1/6' ) {
            $width = 'span2';
        }
        else {
            $width = 'span12';
        }


            $output .= '<div data-element_type="'.$this->settings["base"].'" class="wpb_vc_column wpb_content_element wpb_sortable wpb_droppable '.$width.' not-column-inherit">';
            $output .= '<input type="hidden" class="wpb_vc_sc_base" name="element_name-'.$this->shortcode.'" value="'.$this->settings["base"].'" />';
            $output .= str_replace("%column_size%", wpb_translateColumnWidthToFractional($width), $column_controls);
            $output .= '<div class="wpb_element_wrapper">';
            $output .= '<div class="mk-shortcode-param-name">Custom Box</div>';
            $output .= '<div class="row-fluid wpb_column_container wpb_sortable_container not-column-inherit">';
            $output .= do_shortcode( shortcode_unautop($content) );
            $output .= '</div>';
            if ( isset($this->settings['params']) ) {
                $iner = '';
                foreach ($this->settings['params'] as $param) {
                    $param_value = $$param['param_name'];
                    //var_dump($param_value);
                    if ( is_array($param_value)) {
                        // Get first element from the array
                        reset($param_value);
                        $first_key = key($param_value);
                        $param_value = $param_value[$first_key];
                    }
                    $iner .= $this->singleParamHtmlHolder($param, $param_value);
                }
                $output .= $iner;
            }
            $output .= '</div>';
            $output .= '</div>';


        return $output;
    }
}


