<?php
/**
 */

class WPBakeryShortCode_VC_Twitter extends WPBakeryShortCode {

    protected function content( $atts, $content = null ) {
        $el_class = $title = $twitter_name = $tweet_count = $el_position = $tweets_count = '';
        wp_enqueue_script( 'jquery-tweet' );
        //
        extract(shortcode_atts(array(
            'title' => '',
            'twitter_name' => 'twitter',
            'tweets_count' => 5,
            'el_position' => '',
            'width' => '1/1',
            'el_class' => ''
        ), $atts));
        $output = '';

        $consumer_key = theme_option( THEME_OPTIONS, 'twitter_consumer_key' );
        $consumer_secret = theme_option( THEME_OPTIONS,  'twitter_consumer_secret' );
        $access_token = theme_option( THEME_OPTIONS,  'twitter_access_token' );
        $access_token_secret = theme_option( THEME_OPTIONS,  'twitter_access_token_secret' );

        $el_class = $this->getExtraClass( $el_class );
        $id = mt_rand(99,999);
         $width = wpb_translateColumnWidthToSpan( $width );
        $el_position_css = '';
        if ( $el_position != '' ) {
            $el_position_css = $el_position.'-column';
        }
        $output .= '<div class="'.$width.' '.$el_position_css.'">';
        if(!empty($title)) {
        $output .= '<h3 class="mk-shortcode mk-fancy-title pattern-style mk-shortcode-heading"><span>'.$title.'</span></h3>';
            }
        $output .= '<div class="mk-shortcode '.$el_class.'">';
    if($consumer_key && $consumer_secret && $access_token && $access_token_secret && $tweets_count) { 

        $transName = 'list_tweets_'.$id;
        $cacheTime = 10;
        delete_transient($transName);
        if(false === ($twitterData = get_transient($transName))) {
             // require the twitter auth class
             @require_once THEME_WIDGETS . '/twitteroauth/twitteroauth.php';
             $twitterConnection = new TwitterOAuth(
                            $consumer_key,  // Consumer Key
                            $consumer_secret,       // Consumer secret
                            $access_token,       // Access token
                            $access_token_secret        // Access token secret
                            );
            $twitterData = $twitterConnection->get(
                              'statuses/user_timeline',
                              array(
                                'screen_name'     => $twitter_name,
                                'count'           => $tweets_count,
                                'exclude_replies' => false
                              )
                            );
             if($twitterConnection->http_code != 200)
             {
                  $twitterData = get_transient($transName);
             }

             // Save our new transient.
             set_transient($transName, $twitterData, 60 * $cacheTime);
        };
        $twitter = get_transient($transName);
        if($twitter && is_array($twitter)) {
        $output .='<div id="tweets_'.$id.'">';
        $output .='<ul class="mk-tweet-list mk-tweet-shortcode">';
                            foreach($twitter as $tweet):
                            $output .='<li><span class="tweet-text">';
                                $latestTweet = $tweet->text;
                                $latestTweet = preg_replace('/http:\/\/([a-z0-9_\.\-\+\&\!\#\~\/\,]+)/i', '&nbsp;<a href="http://$1" target="_blank">http://$1</a>&nbsp;', $latestTweet);
                                $latestTweet = preg_replace('/@([a-z0-9_]+)/i', '&nbsp;<a href="http://twitter.com/$1" target="_blank">@$1</a>&nbsp;', $latestTweet);
                                $output .= $latestTweet;
                                $output .= '</span>';
                                $twitterTime = strtotime($tweet->created_at);
                                $timeAgo = mk_ago($twitterTime);
                                $output .= '<a href="http://twitter.com/'.$tweet->user->screen_name.'/statuses/'.$tweet->id_str.'" class="tweet-time">'.$timeAgo.'</a>';
                            $output .= '</li>';
                           endforeach;
                        $output .='</ul>';
                    $output .= '</div>';
         }
     }
        $output .= '</div></div>';


        $output = $this->startRow($el_position) . $output . $this->endRow($el_position);
        return $output;
    }
}

class WPBakeryShortCode_VC_Facebook extends WPBakeryShortCode {

    protected function content( $atts, $content = null ) {
        $type = $url = '';
        extract(shortcode_atts(array(
            'type' => 'standard',//standard, button_count, box_count
            'custom_url' => '',
            'el_position' => '',
            'width' => '1/1',
        ), $atts));
        if ( $custom_url == '') $custom_url = get_permalink();
        $width = wpb_translateColumnWidthToSpan( $width );
        $el_position_css = '';
                if ( $el_position != '' ) {
                    $el_position_css = $el_position.'-column';
                }
        $output = '<div class=" '.$el_position_css.' '.$width.'">';
        $output .= '<div class="wpb_fb_like fb_type_'.$type.'"><iframe src="http://www.facebook.com/plugins/like.php?href='.$custom_url.'&amp;layout='.$type.'&amp;show_faces=false&amp;action=like&amp;colorscheme=light" scrolling="no" frameborder="0" allowTransparency="true"></iframe></div>'.$this->endBlockComment('fb_like')."\n";
        $output .= '</div>';
        return $output;
    }
}

class WPBakeryShortCode_VC_TweetMeMe extends WPBakeryShortCode {

    protected function content($atts, $content = null) {
        $type = '';
        extract(shortcode_atts(array(
            'type' => 'horizontal'//horizontal, vertical, none
        ), $atts));
        $output = '<div class="wpb_tweetme"><a href="http://twitter.com/share" class="twitter-share-button" data-count="'.$type.'">'. __("Tweet", "mk_framework") .'</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>'.$this->endBlockComment('tweetmeme')."</div>\n";
        return $output;
    }
}

class WPBakeryShortCode_VC_GooglePlus extends WPBakeryShortCode {

    protected function content( $atts, $content = null ) {
        $type = $annotation = '';
        extract(shortcode_atts(array(
            'type' => '',
            'annotation' => ''
        ), $atts));
        wp_enqueue_script( 'jquery-googleplus', 'https://apis.google.com/js/plusone.js', array('jquery'), false);
        $params = '';
        $params .= ( $type != '' ) ? ' size="'.$type.'" ' : '';
        $params .= ( $annotation != '' ) ? ' annotation="'.$annotation.'"' : '';
        
        if ( $type == '' ) $type = 'standard';
        $output = '<div class="wpb_googleplus wpb_googleplus_type_'.$type.'"><g:plusone href="<?php echo get_permalink(); ?>" '.$params.'></g:plusone></div>';
        return $output;
    }
}

class WPBakeryShortCode_VC_Pinterest extends WPBakeryShortCode {

    protected function content($atts, $content = null) {
        $type = $annotation = '';

        $url = rawurlencode(get_permalink());
        if ( has_post_thumbnail() ) {
            $img_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );
            $media = ( is_array($img_url) ) ? '&amp;media='.rawurlencode($img_url[0]) : '';
        } else {
            $media = '';
        }
        $description = ( get_the_excerpt() != '' ) ? '&amp;description='.rawurlencode(strip_tags(get_the_excerpt())) : '';

        $output =  '<div class="wpb_pinterest wpb_pinterest_type_'.$type.'">';
        $output .= '<a href="http://pinterest.com/pin/create/button/?url='.$url.$media.$description.'" size="horizontal" class="pin-it-button" data-pin-do="buttonPin" data-pin-config="above"><img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" /></a>';
        $output .= '</div>'.$this->endBlockComment('wpb_pinterest')."\n";

        return $output;
    }
}



class WPBakeryShortCode_VC_flickr extends WPBakeryShortCode {

    protected function content($atts, $content = null) {

        extract(shortcode_atts(array(
            'title' => '',
            'el_position' => '',
            'el_class' => '',
            'flickr_id' => '95572727@N00',
            'count' => '6',
            'thumb_size' => 's',
            'type' => 'user',
            'display' => 'latest'
        ), $atts));

        $el_class = $this->getExtraClass( $el_class );

        $output = "\n\t".'<div class="mk-flickr-feeds-shortcode flickr-widget-wrapper '.$el_class.'">';
        if(!empty($title)) {
        $output .= '<h3 class="mk-shortcode mk-fancy-title pattern-style mk-shortcode-heading"><span>'.$title.'</span></h3>';
            }
        $output .= "\n\t\t\t".'<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count='. $count . '&amp;display='. $display .'&amp;size='.$thumb_size.'&amp;layout=x&amp;source='. $type .'&amp;'. $type .'='. $flickr_id .'"></script>';
        $output .= "\n\t\t\t".'<div class="flickr_stream_wrap"></div>';
        $output .= "\n\t".'</div>';

        $output = $this->startRow($el_position) . $output . $this->endRow($el_position);
        return $output;
    }
}
