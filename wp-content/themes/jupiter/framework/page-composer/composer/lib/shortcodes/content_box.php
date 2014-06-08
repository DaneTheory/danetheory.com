<?php
/**
 * WPBakery Visual Composer shortcodes
 *
 * @package WPBakeryVisualComposer
 *
 */

class WPBakeryShortCode_mk_content_box extends WPBakeryShortCode {

    public function content( $atts, $content = null ) {

        $el_class = $width = $el_position = '';

        extract(shortcode_atts(array(
            'el_class' => '',
            'heading' => '',
            'icon' => '',
            'width' => '',
            'el_position' => '',
        ), $atts));

        $output = '';

        $width = wpb_translateColumnWidthToSpan( $width );
        $el_position_css = '';
        if ( $el_position != '' ) {
            $el_position_css = $el_position.'-column';
        }

        $output .= '<div class="'.$width.' '.$el_position_css.'">';

        $output .= '<div class="mk-content-box mk-shortcode '.$el_class.'">';
        $output .= '<span class="content-box-heading"><i class="mk-'.$icon.'"></i> '.strip_tags($heading).'</span>';
        $output .= '<div class="content-box-content">'.wpb_js_remove_wpautop($content).'</div>';
        $output .= '<div class="clearboth"></div></div></div>';       
   
        return $output;
          
    }

    public function contentAdmin($atts, $content = null) {
        $width = $el_class = '';
        extract(shortcode_atts(array(
            'el_class' => '',
            'icon' => '',
            'heading' => '',
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
            $output .= '<div class="mk-shortcode-param-name">Content Box</div>';
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


