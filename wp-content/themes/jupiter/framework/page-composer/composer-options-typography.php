<?php

wpb_map( array(
        "name"      => __( "Text block", "mk_framework" ),
        "base"      => "vc_column_text",
        "class"     => "mk-text-block-class",
        "params"    => array(

            array(
                "type" => "textarea_html",
                "holder" => "div",
                "class" => "",
                "heading" => __( "Text", "mk_framework" ),
                "param_name" => "content",
                "value" => __( "", "mk_framework" ),
                "description" => __( "Enter your content.", "mk_framework" )
            ),

            array(
                "type" => "textfield",
                "heading" => __( "Title", "mk_framework" ),
                "param_name" => "title",
                "value" => "",
                "description" => __( "You can optionally have readily made global style title for this text block. you can leave it blank if you dont need it. Moreover you can disable this heading title's pattern divider using below option.", "mk_framework" )
            ),
            array(
                "type" => "toggle",
                "heading" => __( "Disable Title Pattern?", "mk_framework" ),
                "param_name" => "disable_pattern",
                "value" => "true",
                "description" => __( "This option will give you the ability to disable fancy title pattern for this shortcode.", "mk_framework" )
            ),

            array(
                "type" => "dropdown",
                "heading" => __( "Text Align", "mk_framework" ),
                "param_name" => "align",
                "width" => 150,
                "value" => array( __( 'Left', "mk_framework" ) => "left", __( 'Right', "mk_framework" ) => "right", __( 'Center', "mk_framework" ) => "center" ),
                "description" => __( "", "mk_framework" )
            ),

            array(
                "type" => "range",
                "heading" => __( "Margin Bottom", "mk_framework" ),
                "param_name" => "margin_bottom",
                "value" => "0",
                "min" => "0",
                "max" => "200",
                "step" => "1",
                "unit" => 'px',
                "description" => __( "", "mk_framework" )
            ),
            array(
                "type" => "dropdown",
                "heading" => __( "Viewport Animation", "mk_framework" ),
                "param_name" => "animation",
                "value" => $css_animations,
                "description" => __( "Viewport animation will be triggered when this element is being viewed when you scroll page down. you only need to choose the animation style from this option. please note that this only works in moderns. We have disabled this feature in touch devices to increase browsing speed.", "mk_framework" )
            ),

            array(
                "type" => "textfield",
                "heading" => __( "Extra class name", "mk_framework" ),
                "param_name" => "el_class",
                "value" => "",
                "description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "mk_framework" )
            ),
        )
    ) );


wpb_map( array(
        "name"      => __( "Fancy Title", "mk_framework" ),
        "base"      => "mk_fancy_title",
        "class"     => "mk-fancy-title-class",
        "params"    => array(

            array(
                "type" => "textarea",
                "rows" => 2,
                "holder" => "div",
                "heading" => __( "Content.", "mk_framework" ),
                "param_name" => "content",
                "value" => __( "", "mk_framework" ),
                "description" => __( "Allowed Tags [br] [strong] [i] [u] [b] [a] [small]. Please note that [p] tags will be striped out.", "mk_framework" )
            ),
            array(
                "type" => "dropdown",
                "heading" => __( "Tag Name", "mk_framework" ),
                "param_name" => "tag_name",
                "value" => array(
                    "h2" => "h2",
                    "h1" => "h1",
                    "h3" => "h3",
                    "h4" => "h4",
                    "h5" => "h5",
                    "h6" => "h6",
                ),
                "description" => __( "For SEO reasons you might need to define your titles tag names according to priority. For example if this title is the important select h1 or h2.", "mk_framework" )
            ),
            array(
                "type" => "toggle",
                "heading" => __( "Pattern?", "mk_framework" ),
                "param_name" => "style",
                "value" => "true",
                "description" => __( "", "mk_framework" )
            ),
            array(
                "type" => "color",
                "heading" => __( "Text Color", "mk_framework" ),
                "param_name" => "color",
                "value" => "#393836",
                "description" => __( "", "mk_framework" )
            ),
            array(
                "type" => "range",
                "heading" => __( "Font Size", "mk_framework" ),
                "param_name" => "size",
                "value" => "14",
                "min" => "12",
                "max" => "70",
                "step" => "1",
                "unit" => 'px',
                "description" => __( "", "mk_framework" )
            ),
            array(
                "type" => "dropdown",
                "heading" => __( "Font Weight", "mk_framework" ),
                "param_name" => "font_weight",
                "width" => 150,
                "value" => array( __( 'Default', "mk_framework" ) => "inhert", __( 'Bold', "mk_framework" ) => "bold", __( 'Bolder', "mk_framework" ) => "bolder",  __( 'Normal', "mk_framework" ) => "normal",  __( 'Light', "mk_framework" ) => "300", ),
                "description" => __( "", "mk_framework" )
            ),
            array(
                "type" => "range",
                "heading" => __( "Margin Top", "mk_framework" ),
                "param_name" => "margin_top",
                "value" => "0",
                "min" => "-40",
                "max" => "500",
                "step" => "1",
                "unit" => 'px',
                "description" => __( "In some occasions you may on need to define a top margin for this title.", "mk_framework" )
            ),
            array(
                "type" => "range",
                "heading" => __( "Margin Bottom", "mk_framework" ),
                "param_name" => "margin_bottom",
                "value" => "18",
                "min" => "0",
                "max" => "500",
                "step" => "1",
                "unit" => 'px',
                "description" => __( "", "mk_framework" )
            ),
            array(
                "type" => "fonts",
                "heading" => __( "Font Family", "mk_framework" ),
                "param_name" => "font_family",
                "value" => "",
                "description" => __( "You can choose a font for this shortcode, however using non-safe fonts can affect page load and performance.", "mk_framework" )
            ),
            array(
                "type" => "hidden_input",
                "param_name" => "font_type",
                "value" => "",
                "description" => __( "", "mk_framework" )
            ),


            array(
                "type" => "dropdown",
                "heading" => __( "Align", "mk_framework" ),
                "param_name" => "align",
                "width" => 150,
                "value" => array( __( 'Left', "mk_framework" ) => "left", __( 'Right', "mk_framework" ) => "right", __( 'Center', "mk_framework" ) => "center" ),
                "description" => __( "", "mk_framework" )
            ),
            array(
                "type" => "dropdown",
                "heading" => __( "Viewport Animation", "mk_framework" ),
                "param_name" => "animation",
                "value" => $css_animations,
                "description" => __( "Viewport animation will be triggered when this element is being viewed when you scroll page down. you only need to choose the animation style from this option. please note that this only works in moderns. We have disabled this feature in touch devices to increase browsing speed.", "mk_framework" )
            ),
            array(
                "type" => "textfield",
                "heading" => __( "Extra class name", "mk_framework" ),
                "param_name" => "el_class",
                "value" => "",
                "description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in Custom CSS Shortcode or Masterkey Custom CSS option.", "mk_framework" )
            )

        )
    )
);



wpb_map( array(
        "name"      => __( "Title Box", "mk_framework" ),
        "base"      => "mk_title_box",
        "class"     => "mk-title-box-class",
        "params"    => array(

            array(
                "type" => "textarea",
                "rows" => 2,
                "holder" => "div",
                "heading" => __( "Content.", "mk_framework" ),
                "param_name" => "content",
                "value" => __( "", "mk_framework" ),
                "description" => __( "Allowed Tags [br] [strong] [i] [u] [b] [a] [small]. Please note that [p] tags will be striped out.", "mk_framework" )
            ),
            array(
                "type" => "color",
                "heading" => __( "Text Color", "mk_framework" ),
                "param_name" => "color",
                "value" => "#393836",
                "description" => __( "", "mk_framework" )
            ),
            array(
                "type" => "color",
                "heading" => __( "Hightlight Background Color", "mk_framework" ),
                "param_name" => "highlight_color",
                "value" => "#000",
                "description" => __( "The Hightlight Background color. you can change color opacity from below option.", "mk_framework" )
            ),
            array(
                "type" => "range",
                "heading" => __( "Hightlight Color Opacity", "mk_framework" ),
                "param_name" => "highlight_opacity",
                "value" => "0.3",
                "min" => "0",
                "max" => "1",
                "step" => "0.01",
                "unit" => 'px',
                "description" => __( "The Opacity of the hightlight background", "mk_framework" )
            ),

            array(
                "type" => "range",
                "heading" => __( "Font Size", "mk_framework" ),
                "param_name" => "size",
                "value" => "18",
                "min" => "12",
                "max" => "70",
                "step" => "1",
                "unit" => 'px',
                "description" => __( "", "mk_framework" )
            ),
            array(
                "type" => "range",
                "heading" => __( "Line Height (Important)", "mk_framework" ),
                "param_name" => "line_height",
                "value" => "34",
                "min" => "12",
                "max" => "500",
                "step" => "1",
                "unit" => 'px',
                "description" => __( "Since every font family with differnt sizes need different line heights to get a nice looking highlighted titles you should set them manually. as a hint generally (font-size * 2) - 2 works in many cases, but you may need to give more space in between, so we opened your hands with this option. :) ", "mk_framework" )
            ),
            array(
                "type" => "dropdown",
                "heading" => __( "Font Weight", "mk_framework" ),
                "param_name" => "font_weight",
                "width" => 150,
                "value" => array( __( 'Default', "mk_framework" ) => "inhert", __( 'Bold', "mk_framework" ) => "bold", __( 'Bolder', "mk_framework" ) => "bolder",  __( 'Normal', "mk_framework" ) => "normal",  __( 'Light', "mk_framework" ) => "300", ),
                "description" => __( "", "mk_framework" )
            ),
            array(
                "type" => "range",
                "heading" => __( "Margin Top", "mk_framework" ),
                "param_name" => "margin_top",
                "value" => "0",
                "min" => "-40",
                "max" => "500",
                "step" => "1",
                "unit" => 'px',
                "description" => __( "In some ocasions you may on need to define a top margin for this title.", "mk_framework" )
            ),
            array(
                "type" => "range",
                "heading" => __( "Margin Button", "mk_framework" ),
                "param_name" => "margin_bottom",
                "value" => "18",
                "min" => "0",
                "max" => "500",
                "step" => "1",
                "unit" => 'px',
                "description" => __( "", "mk_framework" )
            ),
            array(
                "type" => "fonts",
                "heading" => __( "Font Family", "mk_framework" ),
                "param_name" => "font_family",
                "value" => "",
                "description" => __( "You can choose a font for this shortcode, however using non-safe fonts can affect page load and performance.", "mk_framework" )
            ),
            array(
                "type" => "hidden_input",
                "param_name" => "font_type",
                "value" => "",
                "description" => __( "", "mk_framework" )
            ),


            array(
                "type" => "dropdown",
                "heading" => __( "Align", "mk_framework" ),
                "param_name" => "align",
                "width" => 150,
                "value" => array( __( 'Left', "mk_framework" ) => "left", __( 'Right', "mk_framework" ) => "right", __( 'Center', "mk_framework" ) => "center" ),
                "description" => __( "", "mk_framework" )
            ),
            array(
                "type" => "dropdown",
                "heading" => __( "Viewport Animation", "mk_framework" ),
                "param_name" => "animation",
                "value" => $css_animations,
                "description" => __( "Viewport animation will be triggered when this element is being viewed when you scroll page down. you only need to choose the animation style from this option. please note that this only works in moderns. We have disabled this feature in touch devices to increase browsing speed.", "mk_framework" )
            ),
            array(
                "type" => "textfield",
                "heading" => __( "Extra class name", "mk_framework" ),
                "param_name" => "el_class",
                "value" => "",
                "description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in Custom CSS Shortcode or Masterkey Custom CSS option.", "mk_framework" )
            )

        )
    )
);


wpb_map( array(
        "name"      => __( "Blockquote", "mk_framework" ),
        "base"      => "mk_blockquote",
        "class"     => "mk-blockquote-class",
        "params"    => array(


            array(
                "type" => "textarea",
                "holder" => "div",
                "heading" => __( "Blockquote Message", "mk_framework" ),
                "param_name" => "content",
                "value" => __( "", "mk_framework" ),
                "description" => __( "", "mk_framework" )
            ),

            array(
                "type" => "dropdown",
                "heading" => __( "Style", "mk_framework" ),
                "param_name" => "style",
                "width" => 150,
                "value" => array( __( 'Quote Style', "mk_framework" ) => "quote-style", __( 'Line Style', "mk_framework" ) => "line-style" ),
                "description" => __( "Using this option you can choose blockquote style.", "mk_framework" )
            ),

            array(
                "type" => "fonts",
                "heading" => __( "Font Family", "mk_framework" ),
                "param_name" => "font_family",
                "value" => "",
                "description" => __( "You can choose a font for this shortcode, however using non-safe fonts can affect page load and performance.", "mk_framework" )
            ),
            array(
                "type" => "hidden_input",
                "param_name" => "font_type",
                "value" => "",
                "description" => __( "", "mk_framework" )
            ),
            array(
                "type" => "range",
                "heading" => __( "Text Size", "mk_framework" ),
                "param_name" => "text_size",
                "value" => "12",
                "min" => "12",
                "max" => "50",
                "step" => "1",
                "unit" => 'px',
                "description" => __( "You can set blockquote text size from the below option.", "mk_framework" )
            ),

            array(
                "type" => "dropdown",
                "heading" => __( "Align", "mk_framework" ),
                "param_name" => "align",
                "width" => 150,
                "value" => array( __( 'Left', "mk_framework" ) => "left", __( 'Right', "mk_framework" ) => "right", __( 'Center', "mk_framework" ) => "center" ),
                "description" => __( "", "mk_framework" )
            ),
            array(
                "type" => "dropdown",
                "heading" => __( "Viewport Animation", "mk_framework" ),
                "param_name" => "animation",
                "value" => $css_animations,
                "description" => __( "Viewport animation will be triggered when this element is being viewed when you scroll page down. you only need to choose the animation style from this option. please note that this only works in moderns. We have disabled this feature in touch devices to increase browsing speed.", "mk_framework" )
            ),
            array(
                "type" => "textfield",
                "heading" => __( "Extra class name", "mk_framework" ),
                "param_name" => "el_class",
                "value" => "",
                "description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in Custom CSS Shortcode or Masterkey Custom CSS option.", "mk_framework" )
            )

        )
    )
);

wpb_map( array(
        "name"      => __( "Dropcaps", "mk_framework" ),
        "base"      => "mk_dropcaps",
        "class"     => "mk-dropcaps-class",
        "controls"  => "edit_popup_delete",
        "params"    => array(

            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __( "Dropcaps Character", "mk_framework" ),
                "param_name" => "content",
                "value" => __( "", "mk_framework" ),
                "description" => __( "", "mk_framework" )
            ),

            array(
                "type" => "dropdown",
                "heading" => __( "Style", "mk_framework" ),
                "param_name" => "style",
                "width" => 150,
                "value" => array( __( 'Simple', "mk_framework" ) => "simple-style", __( 'Fancy', "mk_framework" ) => "fancy-style", ),
                "description" => __( "", "mk_framework" )
            ),

            array(
                "type" => "textfield",
                "heading" => __( "Extra class name", "mk_framework" ),
                "param_name" => "el_class",
                "value" => "",
                "description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in Custom CSS Shortcode or Masterkey Custom CSS option.", "mk_framework" )
            )

        )
    )
);

wpb_map( array(
        "name"      => __( "Highlight Text", "mk_framework" ),
        "base"      => "mk_highlight",
        "class"     => "mk-highlight-class",
        "controls"  => "edit_popup_delete",
        "params"    => array(

            array(
                "type" => "textfield",
                "heading" => __( "Highlight Text", "mk_framework" ),
                "param_name" => "text",
                "value" => "",
                "description" => __( "", "mk_framework" )
            ),

            array(
                "type" => "color",
                "heading" => __( "Text Color", "mk_framework" ),
                "param_name" => "text_color",
                "value" => "",
                "description" => __( "", "mk_framework" )
            ),

            array(
                "type" => "color",
                "heading" => __( "Background Color", "mk_framework" ),
                "param_name" => "bg_color",
                "value" => "",
                "description" => __( "", "mk_framework" )
            ),
            array(
                "type" => "fonts",
                "heading" => __( "Font Family", "mk_framework" ),
                "param_name" => "font_family",
                "value" => "",
                "description" => __( "You can choose a font for this shortcode, however using non-safe fonts can affect page load and performance.", "mk_framework" )
            ),
            array(
                "type" => "hidden_input",
                "param_name" => "font_type",
                "value" => "",
                "description" => __( "", "mk_framework" )
            ),
            array(
                "type" => "textfield",
                "heading" => __( "Extra class name", "mk_framework" ),
                "param_name" => "el_class",
                "value" => "",
                "description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in Custom CSS Shortcode or Masterkey Custom CSS option.", "mk_framework" )
            )

        )
    )
);

wpb_map( array(
        "name"      => __( "Tooltip", "mk_framework" ),
        "base"      => "mk_tooltip",
        "class"     => "mk-highlight-class",
        "controls"  => "edit_popup_delete",
        "params"    => array(

            array(
                "type" => "textfield",
                "heading" => __( "Text", "mk_framework" ),
                "param_name" => "text",
                "value" => "",
                "description" => __( "", "mk_framework" )
            ),

            array(
                "type" => "textfield",
                "heading" => __( "Tooltip Text", "mk_framework" ),
                "param_name" => "tooltip_text",
                "value" => "",
                "description" => __( "", "mk_framework" )
            ),

            array(
                "type" => "textfield",
                "heading" => __( "Tooltip URL", "mk_framework" ),
                "param_name" => "href",
                "value" => "",
                "description" => __( "You can optionally link the tooltip text to a webpage.", "mk_framework" )
            ),

            array(
                "type" => "textfield",
                "heading" => __( "Extra class name", "mk_framework" ),
                "param_name" => "el_class",
                "value" => "",
                "description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in Custom CSS Shortcode or Masterkey Custom CSS option.", "mk_framework" )
            )

        )
    )
);


wpb_map( array(
        "name"      => __( "Custom List", "mk_framework" ),
        "base"      => "mk_custom_list",
        "class"     => "mk-list-styles-class",
        "params"    => array(
            array(
                "type" => "textfield",
                "heading" => __( "Title", "mk_framework" ),
                "param_name" => "title",
                "value" => "",
                "description" => __( "", "mk_framework" )
            ),

            array(
                "type" => "textarea_html",
                "holder" => "div",
                "heading" => __( "Add your unordered list into this textarea. Allowed Tags : [ul][li][strong][i][em][u][b][a][small]", "mk_framework" ),
                "param_name" => "content",
                "value" => "<ul><li>List Item</li></ul>",
                "description" => __( "", "mk_framework" )
            ),

            array(
                "type" => "awesome_icons",
                "heading" => __( "List Icons", "mk_framework" ),
                "param_name" => "style",
                "width" => 200,
                "value" => $mk_awesome_icons_list,
                "encoding" => "true",
                "description" => __( "", "mk_framework" )
            ),

            array(
                "type" => "color",
                "heading" => __( "Icons Color", "mk_framework" ),
                "param_name" => "icon_color",
                "value" => $skin_color,
                "description" => __( "", "mk_framework" )
            ),

            array(
                "type" => "range",
                "heading" => __( "Margin Button", "mk_framework" ),
                "param_name" => "margin_bottom",
                "value" => "30",
                "min" => "-30",
                "max" => "500",
                "step" => "1",
                "unit" => 'px',
                "description" => __( "", "mk_framework" )
            ),
            array(
                "type" => "dropdown",
                "heading" => __( "Viewport Animation", "mk_framework" ),
                "param_name" => "animation",
                "value" => $css_animations,
                "description" => __( "Viewport animation will be triggered when this element is being viewed when you scroll page down. you only need to choose the animation style from this option. please note that this only works in moderns. We have disabled this feature in touch devices to increase browsing speed.", "mk_framework" )
            ),

            array(
                "type" => "textfield",
                "heading" => __( "Extra class name", "mk_framework" ),
                "param_name" => "el_class",
                "value" => "",
                "description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in Custom CSS Shortcode or Masterkey Custom CSS option.", "mk_framework" )
            )

        )
    )
);


wpb_map( array(
        "name"      => __( "Font icons", "mk_framework" ),
        "base"      => "mk_font_icons",
        "class"     => "mk-lifetime-icons-class",
        "controls"  => "edit_popup_delete",
        "params"    => array(

            array(
                "type" => "awesome_icons",
                "heading" => __( "Icon", "mk_framework" ),
                "param_name" => "icon",
                "width" => 200,
                "value" => $mk_awesome_icons_list,
                "encoding" => "false",
                "description" => __( "", "mk_framework" )
            ),
            array(
                "type" => "color",
                "heading" => __( "icon Color", "mk_framework" ),
                "param_name" => "color",
                "value" => "",
                "description" => __( "", "mk_framework" )
            ),
            array(
                "type" => "dropdown",
                "heading" => __( "Icon Size", "mk_framework" ),
                "param_name" => "size",
                "value" => array(
                    "16px" => "small",
                    "32px" => "medium",
                    "48px" => "large",
                    "64px" => "x-large",
                    "128px" => "xx-large",
                    "256px" => "xxx-large",

                ),
                "description" => __( "", "mk_framework" )
            ),


            array(
                "type" => "range",
                "heading" => __( "Horizontal Padding", "mk_framework" ),
                "param_name" => "padding_horizental",
                "value" => "4",
                "min" => "0",
                "max" => "50",
                "step" => "1",
                "unit" => 'px',
                "description" => __( "You can give padding to the icon. this padding will be applied to left and right side of the icon", "mk_framework" )
            ),
            array(
                "type" => "range",
                "heading" => __( "Vertical Padding", "mk_framework" ),
                "param_name" => "padding_vertical",
                "value" => "4",
                "min" => "0",
                "max" => "50",
                "step" => "1",
                "unit" => 'px',
                "description" => __( "You can give padding to the icon. this padding will be applied to top and bottom of them icon", "mk_framework" )
            ),
            array(
                "type" => "toggle",
                "heading" => __( "Circle Box?", "mk_framework" ),
                "param_name" => "circle",
                "value" => "false",
                "description" => __( "", "mk_framework" )
            ),
            array(
                "type" => "color",
                "heading" => __( "Circle Color", "mk_framework" ),
                "param_name" => "circle_color",
                "value" => "",
                "description" => __( "If Circle Enabled you can set the rounded box background color using this color picker.", "mk_framework" )
            ),
            array(
                "type" => "dropdown",
                "heading" => __( "Icon Align", "mk_framework" ),
                "param_name" => "align",
                "width" => 150,
                "value" => array( __( 'No Align', "mk_framework" ) => "none", __( 'Left', "mk_framework" ) => "left", __( 'Right', "mk_framework" ) => "right", __( 'Center', "mk_framework" ) => "center" ),
                "description" => __( "Please note that align left and right will make the icons to float, therefore in order to keep your page elements from wrapping into each other you should add a padding divider shortcode right after the last icon.", "mk_framework" )
            ),
            array(
                "type" => "textfield",
                "heading" => __( "Link", "mk_framework" ),
                "param_name" => "link",
                "value" => "",
                "description" => __( "You can optionally link your icon. please provide full URL including http://", "mk_framework" )
            ),
            array(
                "type" => "dropdown",
                "heading" => __( "Viewport Animation", "mk_framework" ),
                "param_name" => "animation",
                "value" => $css_animations,
                "description" => __( "Viewport animation will be triggered when this element is being viewed when you scroll page down. you only need to choose the animation style from this option. please note that this only works in moderns. We have disabled this feature in touch devices to increase browsing speed.", "mk_framework" )
            ),
            array(
                "type" => "textfield",
                "heading" => __( "Extra class name", "mk_framework" ),
                "param_name" => "el_class",
                "value" => "",
                "description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in Custom CSS Shortcode or Masterkey Custom CSS option.", "mk_framework" )
            )

        )
    )
);

wpb_map( array(
        "name"      => __( "Toggle", "mk_framework" ),
        "base"      => "mk_toggle",
        "class"     => "mk-toggle-class",
        "params"    => array(
            array(
                "type" => "dropdown",
                "heading" => __( "Style", "mk_framework" ),
                "param_name" => "style",
                "width" => 150,
                "value" => array( __( 'Simple', "mk_framework" ) => "simple", __( 'Fancy', "mk_framework" ) => "fancy" ),
                "description" => __( "", "mk_framework" )
            ),
            array(
                "type" => "textfield",
                "heading" => __( "Toggle Title", "mk_framework" ),
                "param_name" => "title",
                "value" => "",
            ),
            array(
                "type" => "awesome_icons",
                "heading" => __( "Choose Icon For title", "mk_framework" ),
                "param_name" => "icon",
                "value" => $mk_awesome_icons_list,
                "encoding" => "false",
                "description" => __( "Please note that this icon only works for fancy style of this shortcode.", "mk_framework" )
            ),
            array(
                "type" => "textarea_html",
                "holder" => "div",
                "heading" => __( "Toggle Content.", "mk_framework" ),
                "param_name" => "content",
                "value" => __( "", "mk_framework" ),
            ),

            array(
                "type" => "textfield",
                "heading" => __( "Extra class name", "mk_framework" ),
                "param_name" => "el_class",
                "value" => "",
                "description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in Custom CSS Shortcode or Masterkey Custom CSS option.", "mk_framework" )
            )

        )
    )
);



wpb_map( array(
        "name"      => __( "Accordion", "mk_framework" ),
        "base"      => "vc_accordions",
        "class"     => "wpb_accordion mk-tabs-class",
        "params"    => array(
            array(
                "type" => "textfield",
                "heading" => __( "Title", "mk_framework" ),
                "param_name" => "heading_title",
                "value" => "",
                "description" => __( "", "mk_framework" )
            ),
            array(
                "type" => "dropdown",
                "heading" => __( "Style", "mk_framework" ),
                "param_name" => "style",
                "width" => 150,
                "value" => array(  __( 'Fancy', "mk_framework" ) => "fancy-style", __( 'Simple', "mk_framework" ) => "simple-style" ),
                "description" => __( "", "mk_framework" )
            ),
            array(
                "type" => "dropdown",
                "heading" => __( "Action Style", "mk_framework" ),
                "param_name" => "action_style",
                "width" => 400,
                "value" => array(  __( 'One Toggle Open At A Time', "mk_framework" ) => "accordion-action", __( 'Multiple Toggles Open At A Time', "mk_framework" ) => "toggle-action" ),
                "description" => __( "", "mk_framework" )
            ),
            array(
                "type" => "range",
                "heading" => __( "Initial Index", "mk_framework" ),
                "param_name" => "open_toggle",
                "value" => "0",
                "min" => "-1",
                "max" => "50",
                "step" => "1",
                "unit" => 'index',
                "description" => __( "Specify which toggle to be open by default when The page loads. please note that this value is zero based therefore zero is the first item. this option works when you have chosen [One Toggle Open At A Time] option from above setting. -1 will close all accordions on page load.", "mk_framework" )
            ),
            array(
                "type" => "color",
                "heading" => __( "Container Background Color", "mk_framework" ),
                "param_name" => "container_bg_color",
                "value" => "#fff",
                "description" => __( "", "mk_framework" )
            ),

            array(
                "type" => "textfield",
                "heading" => __( "Extra class name", "mk_framework" ),
                "param_name" => "el_class",
                "value" => "",
                "description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "mk_framework" )
            )
        ),
        "custom_markup" => '
    <div class="tab_controls">
        <a href="#" class="add_tab add_accordion_shortcode mk-tab-button"><i class="mk-icon-plus-sign"></i>'.__( "Add section", "mk_framework" ).'</a>
        <a href="#" class="edit_tab mk-tab-button"><i class="mk-icon-pencil"></i>'.__( "Edit current section title", "mk_framework" ).'</a>
        <a href="#TB_inline=false?width=1200&height=700&inlineId=mk-icon-holder-container" class="add_icon thickbox mk-tab-button"><i class="mk-icon-rocket"></i>'.__( "Add Icon to current Tab", "mk_framework" ).'</a>
        <a href="#" class="delete_tab mk-delete-accordion mk-tab-button"><i class="mk-icon-remove"></i>'.__( "Delete current section", "mk_framework" ).'</a>
    </div>

    <div class="wpb_accordion_holder clearfix">
        %content%
    </div>',
        'default_content' => '
    <div class="mk-accordion-group">
        <h3><i class=""></i><a href="#">'.__( 'Section 1', "mk_framework" ).'</a></h3>
        <div>
            <div class="row-fluid wpb_column_container wpb_sortable_container not-column-inherit">
                [vc_column_text width="1/1"] '.__( 'I am text block. Click edit button to change this text.', "mk_framework" ).' [/vc_column_text]
            </div>
        </div>
    </div>
    <div class="mk-accordion-group">
        <h3><i class=""></i><a href="#">'.__( 'Section 2', "mk_framework" ).'</a></h3>
        <div>
            <div class="row-fluid wpb_column_container wpb_sortable_container not-column-inherit">
                [vc_column_text width="1/1"] '.__( 'I am text block. Click edit button to change this text.', "mk_framework" ).' [/vc_column_text]
            </div>
        </div>
    </div>',
        "js_callback" => array( "init" => "wpbAccordionInitCallBack", "shortcode" => "wpbAccordionGenerateShortcodeCallBack" )
    ) );



wpb_map( array(
        "name"      => __( "Tabs", "mk_framework" ),
        "base"      => "vc_tabs",
        "class"     => "wpb_accordion mk-tabs-class ",
        "params"    => array(
            array(
                "type" => "textfield",
                "heading" => __( "Title", "mk_framework" ),
                "param_name" => "heading_title",
                "value" => "",
                "description" => __( "", "mk_framework" )
            ),
            array(
                "type" => "dropdown",
                "heading" => __( "Orientation", "mk_framework" ),
                "param_name" => "orientation",
                "value" => array(
                    "Horizontal" => "horizental",
                    "Vertical" => "vertical",
                ),
                "description" => __( "Please Choose the style of the line of divider.", "mk_framework" )
            ),
             array(
                "type" => "dropdown",
                "heading" => __( "Tab location", "mk_framework" ),
                "param_name" => "tab_location",
                "value" => array(
                    "Left" => "left",
                    "Right" => "right",
                ),
                "description" => __( "Which side would you like the tabs list appear?", "mk_framework" ),
                "dependency" => array( 'element' => "orientation", 'value' => array( 'vertical' ) )
            ),
            array(
                "type" => "color",
                "heading" => __( "Container Background Color", "mk_framework" ),
                "param_name" => "container_bg_color",
                "value" => "#fff",
                "description" => __( "", "mk_framework" )
            ),

            array(
                "type" => "textfield",
                "heading" => __( "Extra class name", "mk_framework" ),
                "param_name" => "el_class",
                "value" => "",
                "description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "mk_framework" )
            )
        ),
        "custom_markup" => '
    <div class="tab_controls">
        <a href="#" class="add_tab add_tab_shortcode mk-tab-button"><i class="mk-icon-plus-sign"></i>'.__( "Add Tab", "mk_framework" ).'</a>
        <a href="#" class="edit_tab mk-tab-button"><i class="mk-icon-pencil"></i>'.__( "Edit current Tab title", "mk_framework" ).'</a>
        <a href="#TB_inline=false?width=1900&height=700&inlineId=mk-icon-holder-container" class="add_icon thickbox mk-tab-button"><i class="mk-icon-rocket"></i>'.__( "Add Icon to current Tab", "mk_framework" ).'</a>
        <a href="#" class="delete_tab mk-delete-tabs mk-tab-button"><i class="mk-icon-remove"></i>'.__( "Delete current Tab", "mk_framework" ).'</a>
    </div>

    <div class="wpb_accordion_holder clearfix">
        %content%
    </div>',
        'default_content' => '
    <div class="mk-tabs-group">
        <h3><i class=""></i><a href="#">'.__( 'Tab 1', "mk_framework" ).'</a></h3>
        <div>
            <div class="row-fluid wpb_column_container wpb_sortable_container not-column-inherit">
                [vc_column_text width="1/1"] '.__( 'I am text block. Click edit button to change this text.', "mk_framework" ).' [/vc_column_text]
            </div>
        </div>
    </div>
    <div class="mk-tabs-group">
        <h3><i class=""></i><a href="#">'.__( 'Tab 2', "mk_framework" ).'</a></h3>
        <div>
            <div class="row-fluid wpb_column_container wpb_sortable_container not-column-inherit">
                [vc_column_text width="1/1"] '.__( 'I am text block. Click edit button to change this text.', "mk_framework" ).' [/vc_column_text]
            </div>
        </div>
    </div>',
        "js_callback" => array( "init" => "wpbAccordionInitCallBack", "shortcode" => "wpbTabsGenerateShortcodeCallBack" )
    ) );
