<?php
$config  = array(
  'title' => sprintf( '%s Portfolio Options', THEME_NAME ),
  'id' => 'mk-metaboxes-tabs',
  'pages' => array(
    'portfolio'
  ),
  'callback' => '',
  'context' => 'normal',
  'priority' => 'core'
);
$options = array(


  array(
    "type" => "start_sub",
    "options" => array(
      "general" => __( "General Settings", 'mk_framework' ),
      "post-type" => __( "Post Type", 'mk_framework' ),
      "single-post-options" => __( "Single Post Options", 'mk_framework' ),
      "Backgrounds" => __('Backgrounds', 'mk_framework'),
      "slideshow" => __( "Slideshow", 'mk_framework' ),
    ),
  ),


  array(
    "type" => "start_sub_pane"
  ),

  array(
    "name" => __("General Settings", "mk_framework" ),
    "desc" => __( "", "mk_framework" ),
    "type" => "heading"
  ),
  array(
    "name" => __( "Layout", "mk_framework" ),
    "desc" => __( "Please choose this page's layout.", "mk_framework" ),
    "id" => "_layout",
    "default" => 'default',
    "option_structure" => 'sub',
    "divider" => true,
    "item_padding" => "0 30px 30px 0",
    "options" => array(
      "left" => 'page-layout-left',
      "right" => 'page-layout-right',
      "full" => 'page-layout-full',
      "default" => 'page-layout-default',
    ),
    "type" => "visual_selector"
  ),
      array(
    "name" => __( "Custom URL", "mk_framework" ),
    "desc" => __( "If you may choose to change the permalink to a page, post or external URL. If left empty the single post permalink will be used instead.", "mk_framework" ),
    "id" => "_portfolio_permalink",
    "default" => "",
    "option_structure" => 'sub',
    "divider" => true,
    "type" => "superlink"
  ),

array(
    "name" => __("Custom Sidebar", "mk_framework" ),
    "desc" => __( "You can create a custom sidebar, under Sidebar option then assign the custom sidebar here to this post.", "mk_framework" ),
    "id" => "_sidebar",
    "default" => '',
    "option_structure" => 'sub',
    "divider" => true,
    "options" => get_sidebar_options(),
    "type" => "chosen_select"
  ),



  array(
    "name" => __( "Page Title", "mk_framework" ),
    "desc" => __( "", "mk_framework" ),
    "id" => "_page_disable_title",
    "default" => 'true',
    "option_structure" => 'sub',
    "divider" => true,
    "type" => "toggle"
  ),
  array(
    "name" => __( "Breadcrumb", "mk_framework" ),
    "desc" => __( "You can disable Breadcrumb for this page using this option", "mk_framework" ),
    "id" => "_disable_breadcrumb",
    "default" => 'true',
    "option_structure" => 'sub',
    "divider" => true,
    "type" => "toggle"
  ),

 array(
    "name" => __("Page Title Align", "mk_framework" ),
    "desc" => __( "You can change title and subtitle text align.", "mk_framework" ),
    "id" => "_introduce_align",
    "default" => 'left',
    "options" => array(
      "left" => 'Left',
      "right" => 'Right',
      "center" => 'Center',
    ),
    "option_structure" => 'sub',
    "divider" => false,
    "type" => "chosen_select"
  ),

  array(
    "name" => __( "Custom Page Title", "mk_framework" ),
    "desc" => __( "If left Blank the global title which you defined in masterkey settings will be used. You can optionally use a different page title in banner section from this option.", "mk_framework" ),
    "id" => "_custom_page_title",
    "default" => "",
    "option_structure" => 'sub',
    "divider" => true,
    "type" => "text"
  ),
  array(
    "name" => __( "Page Heading Subtitle", "mk_framework" ),
    "id" => "_page_introduce_subtitle",
    "rows" => "3",
    "default" => "",
    "option_structure" => 'sub',
    "divider" => true,
    "type" => "textarea"
  ),



  array(
    "type"=>"end_sub_pane"
  ),
  /*****************************/


  /* Sub Pane one : Logo Option */
  array(
    "type" => "start_sub_pane"
  ),

  array(
    "name" => __( "Post Options", "mk_framework" ),
    "desc" => __( "", "mk_framework" ),
    "type" => "heading"
  ),

  array(
    "name" => __("Post Type", "mk_framework" ),
    "desc" => __( "", "mk_framework" ),
    "id" => "_single_post_type",
    "default" => 'image',
    "preview" => false,
    "options" => array(
      "image" => 'Image',
      "video" => 'Video',
    ),
    "option_structure" => 'sub',
    "divider" => true,
    "type" => "chosen_select"
  ),


  array(
    "name" => __( "Video Site", "mk_framework" ),
    "id" => "_single_video_site",
    "default" => 'youtube',
    "option_structure" => 'sub',
    "divider" => true,
    "options" => array(
      "vimeo" => 'Vimeo',
      "youtube" => 'Youtube',
      "dailymotion" => 'Daily Motion',
    ),
    "type" => "chosen_select"
  ),

  array(
    "name" => __( "Video Id", "mk_framework" ),
    "desc" => __( "Please fill this option with the required ID. you can find the ID from the link parameters as examplified below:<br /> http://www.youtube.com/watch?v=<strong>ID</strong><br />https://vimeo.com/<strong>ID</strong><br />http://www.dailymotion.com/embed/video/<strong>ID</strong>", "mk_framework" ),
    "id" => "_single_video_id",
    "size" => 20,
    "option_structure" => 'sub',
    "divider" => true,
    "type" => "text"
  ),


  array(
    "type"=>"end_sub_pane"
  ),
  /*****************************/


  /* Sub Pane one : Post Single Option */
  array(
    "type" => "start_sub_pane"
  ),


  array(
    "name" => __( "Featured Image (or Video in video post type)", "mk_framework" ),
    "desc" => __( "If you do not want to set a featured image inside single portfolio kindly disable it here.", "mk_framework" ),
    "id" => "_portfolio_featured_image",
    "default" => 'true',
    "option_structure" => 'sub',
    "divider" => true,
    "type" => "toggle"
  ),


  array(
    "name" => __( "Similiar Posts", "mk_framework" ),
    "desc" => __( "If you do not want to show similar posts section inside single portfolio kindly disable it here.", "mk_framework" ),
    "id" => "_portfolio_similar",
    "default" => 'true',
    "option_structure" => 'sub',
    "divider" => true,
    "type" => "toggle"
  ),


  array(
    "type"=>"end_sub_pane"
  ),
  /*****************************/








  array(
    "type"=>"end_sub"
  ),


);
new metaboxesGenerator( $config, $options );
