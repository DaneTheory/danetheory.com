<?php
/**
 */
class WPBakeryShortCode_VC_Tab extends WPBakeryShortCode {
    public function content( $atts, $content = null ) {
        $title = $tab_id = '';
        extract(shortcode_atts(array(
            'title' => __("Tab", "mk_framework"),
            'icon' => '',
        ), $atts));
        $output = '';

        $output .= "\n\t\t\t" . '<div class="wpb_tab ui-tabs-panel ui-tabs-hide clearfix">';
        $output .= "\n\t\t\t\t" . wpb_js_remove_wpautop($content);
        $output .= "\n\t\t\t" . '</div> ' . $this->endBlockComment('.wpb_tab');
        return $output;
    }

    public function contentAdmin($atts, $content) {
       $title = '';
        $defaults = array( 'title' => __('Tab', 'mk_framework'), 'icon'=> '' );
        extract( shortcode_atts( $defaults, $atts ) );

        return '<div class="mk-tabs-group">
        <h3><i class="'.$icon.'"></i><a href="#">'.$title.'</a></h3>
        <div>
            <div class="row-fluid wpb_column_container not-column-inherit wpb_sortable_container">
                '. do_shortcode($content) . '
            </div>
        </div>
        </div>';
    }
}

class WPBakeryShortCode_VC_Tabs extends WPBakeryShortCode {

    public function __construct($settings) {
        parent::__construct($settings);
        WPBakeryVisualComposer::getInstance()->addShortCodePlugin( array( 'base' => 'vc_tab' ) );
    }

    public function contentAdmin( $atts, $content ) {
        $width = $custom_markup = '';
        $shortcode_attributes = array('width' => '1/1');
        foreach ( $this->settings['params'] as $param ) {
            if ( $param['param_name'] != 'content' ) {
                if ( is_string($param['value']) ) {
                    $shortcode_attributes[$param['param_name']] = __($param['value'], "mk_framework");
                } else {
                    $shortcode_attributes[$param['param_name']] = $param['value'];
                }
            } else if ( $param['param_name'] == 'content' && $content == NULL ) {
                $content = __($param['value'], "mk_framework");
            }
        }
        extract(shortcode_atts(
            $shortcode_attributes
            , $atts));

        $output = '';

        $elem = $this->getElementHolder($width);

        $iner = '';
        foreach ($this->settings['params'] as $param) {
            $param_value = '';
            $param_value = isset($$param['param_name']) ? $$param['param_name'] : '';

            if ( is_array($param_value)) {
                // Get first element from the array
                reset($param_value);
                $first_key = key($param_value);
                $param_value = $param_value[$first_key];
            }
            $iner .= $this->singleParamHtmlHolder($param, $param_value);
        }
        //$elem = str_ireplace('%wpb_element_content%', $iner, $elem);
        $tmp = '';
        if ( isset($this->settings["custom_markup"]) && $this->settings["custom_markup"] != '' ) {
            if ( $content != '' ) {
                $custom_markup = str_ireplace("%content%", $tmp.$content, $this->settings["custom_markup"]);
            } else if ( $content == '' && isset($this->settings["default_content"]) && $this->settings["default_content"] != '' ) {
                $custom_markup = str_ireplace("%content%", $this->settings["default_content"], $this->settings["custom_markup"]);
            }
            //$output .= do_shortcode($this->settings["custom_markup"]);
            $iner .= do_shortcode($custom_markup);
        }
        $elem = str_ireplace('%wpb_element_content%', $iner, $elem);
        $output = $elem;

        return $output;
    }

    public function content($atts, $content =null)
    {
        //
        $title  = $el_position = $el_class = '';
        extract(shortcode_atts(array(
            'heading_title' => '',
            'orientation' => 'horizental',
            'title' => '',
            "container_bg_color" => '#fff',
            'tab_location' => '',
            'el_position' => '',
            'el_class' => '',
            'width' => '1/1',
        ), $atts));
        $output = $tab_location_css = $el_position_css = '';

        $el_class = $this->getExtraClass($el_class);
        wp_enqueue_script('jquery-tools');
        $id = mt_rand(99,999);
        $width = wpb_translateColumnWidthToSpan($width);
    $id = mt_rand(99,999);
    if(!empty($heading_title)) {
        $heading_title = '<h3 class="mk-shortcode mk-fancy-title pattern-style mk-shortcode-heading"><span>'.$heading_title.'</span></h3>';
            }

    if ( !preg_match_all( "/(.?)\[(vc_tab)\b(.*?)(?:(\/))?\](?:(.+?)\[\/vc_tab\])?(.?)/s", $content, $matches ) ) {
        return do_shortcode( $content );
    }
    else {
        for ( $i = 0; $i < count( $matches[ 0 ] ); $i++ ) {
            $matches[ 3 ][ $i ] = shortcode_parse_atts( $matches[ 3 ][ $i ] );
        }
        $output = '<ul class="mk-tabs-tabs">';

        for ( $i = 0; $i < count( $matches[ 0 ] ); $i++ ) {
            $icon = $matches[ 3 ][ $i ][ 'icon' ];
            if($icon == '') {
                $output .= '<li><a href="#">' . $matches[ 3 ][ $i ][ 'title' ] . '</a></li>';
            } else {
                $output .= '<li class="tab-with-icon"><a href="#"><i class="' . $icon . '"></i>' . $matches[ 3 ][ $i ][ 'title' ] . '</a></li>';
            }
            
        }
        $output .= '<div class="clearboth"></div></ul>';
        $output .= '<div class="mk-tabs-panes">';
        for ( $i = 0; $i < count( $matches[ 0 ] ); $i++ ) {
            $output .= '<div class="mk-tabs-pane">' . do_shortcode( trim( $matches[ 5 ][ $i ] ) ) . '<div class="clearboth"></div></div>';
        }
        $output .= '<div class="clearboth"></div></div>';
            if($el_position != '') {
            $el_position_css = $el_position.'-column';
        }
        if($orientation == 'vertical') {
            $tab_location_css = ' vertical-'.$tab_location;
        }
        return '<div class="'.$width.' '.$el_position_css.'">'.$heading_title.'<div id="mk-tabs-'.$id.'" class="mk-shortcode mk-tabs'.$tab_location_css.' '.$orientation.'-style ' . $el_class . '">' . $output . '<div class="clearboth"></div></div></div>
        <style type="text/css">
                #mk-tabs-'.$id.' .mk-tabs-tabs li.current, #mk-tabs-'.$id.' .mk-tabs-panes, #mk-tabs-'.$id.' .mk-fancy-title span{
                    background-color: '.$container_bg_color.';
                }
        </style>
        ';
    }
        return $output;
    }
}