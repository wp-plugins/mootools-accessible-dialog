<?php

/*
	Plugin Name: MooTools Accessible Dialog
	Plugin URI: http://wordpress.org/extend/plugins/mootools-accessible-dialog/
	Description: WAI-ARIA Enabled Sortable Dialog Plugin for Wordpress
	Version: 1.0
	Author: Votis Konstantinos
	Author URI: http://iti.gr/iti/people/Konstantinos_Votis.html
*/


/**
 * Widget Class
 */
class MootoolsAccessibleDialog extends WP_Widget
{    
    function __construct()
    {
		$widget_ops = array('classname' => 'widget_mootools_accessible_dialog', 'description' => __( 'Mootools accessible dialog' ) );
		parent::__construct('mootools-accessible-dialog', __('Mootools Accessible Dialog'), $widget_ops);
		$this->alt_option_name = 'widget_mootools_accessible_dialog';   
		
		if (is_active_widget(false, false, $this->id_base))
		{
			// styles
			wp_register_style('dialog_style', (get_bloginfo('wpurl') . '/wp-content/plugins/mootools-accessible-dialog/css/style.css'));
			wp_enqueue_style('dialog_style');
			
			// scripts
			wp_deregister_script('jquery');
			wp_register_script('jquery', (get_bloginfo('wpurl') .'/wp-includes/js/jquery/jquery.js'));
			wp_enqueue_script('jquery');

			wp_register_script('mootools-core', (get_bloginfo('wpurl') . '/wp-content/plugins/mootools-accessible-dialog/js/libs/mootools-core.js'));
			wp_enqueue_script('mootools-core');
			
			wp_register_script('dialog', (get_bloginfo('wpurl') . '/wp-content/plugins/mootools-accessible-dialog/js/libs/dialog.js'));
			wp_enqueue_script('dialog');

			wp_register_script('dialog_script', (get_bloginfo('wpurl') . '/wp-content/plugins/mootools-accessible-dialog/js/script.js'));
			wp_enqueue_script('dialog_script');
		}
	}

    /** @see WP_Widget::widget */
    function widget($args, $instance)
    {	
        extract( $args );
        
        // options
        $title = apply_filters('widget_title', $instance['title']);
        if(!$title)
		{
			$title = 'Mootools Accessible Dialog';
		}
        
        $twitter_screen_name = $instance['twitter_screen_name'];
        if(!$twitter_screen_name)
		{
			$twitter_screen_name = 'aegisproj';
		}
        
        $recent_tweets_count = $instance['recent_tweets_count'];
        if(!$recent_tweets_count)
		{
			$recent_tweets_count = '3';
		}
		
        echo $before_widget;
        
        // if the title is set
		if ( $title )
		{
			echo $before_title . $title . $after_title;
		}
		
		// content
		echo '<input class="button" id="dialogTrigger" type="button" value="View recent tweets" role="button"/>';
		echo '<div id="twitter_screen_name">@'.$twitter_screen_name.'</div>';
		echo '<div id="twitter_update_list">';
		echo '<script type="text/javascript" src="http://twitter.com/javascripts/blogger.js"></script>';
		echo '<script type="text/javascript" src="https://api.twitter.com/1/statuses/user_timeline.json?'
			.'callback=twitterCallback2&include_entities=true&include_rts=true'
			.'&screen_name='.$twitter_screen_name.'&count='.$recent_tweets_count.'"></script>';
		echo '</div>';
		
		echo $after_widget;
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance)
    {		
		$instance = $old_instance;
		
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['twitter_screen_name'] = strip_tags($new_instance['twitter_screen_name']);
		$instance['recent_tweets_count'] = strip_tags($new_instance['recent_tweets_count']);
		
        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance)
    {	
		$title = esc_attr($instance['title']);
		$twitter_screen_name = esc_attr($instance['twitter_screen_name']);
		$recent_tweets_count = esc_attr($instance['recent_tweets_count']);
		
		?>
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget title:'); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id('twitter_screen_name'); ?>"><?php _e('Twitter username:'); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('twitter_screen_name'); ?>" name="<?php echo $this->get_field_name('twitter_screen_name'); ?>" type="text" value="<?php echo $twitter_screen_name; ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('recent_tweets_count'); ?>"><?php _e('Number of recent tweets to show:'); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('recent_tweets_count'); ?>" name="<?php echo $this->get_field_name('recent_tweets_count'); ?>" type="number" min="1" max="200" value="<?php echo $recent_tweets_count; ?>" />
			</p>
		<?php
    }
} // Widget Class

// register widget
add_action('widgets_init', create_function('', 'register_widget("MootoolsAccessibleDialog");'));

?>
