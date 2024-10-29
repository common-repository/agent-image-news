<?php
/*
Plugin Name: Agent Image News
Version: 1.3
Plugin URI: http://www.agentimage.com
Description: Real estate web design and marketing news for agents and brokers from Agent Image - the real estate industry's award-winning, premier website design company.
Author: AgentImage
Author URI: http://www.agentimage.com
*/

/**
 * Agent Image Wordpress Plugin
 * Copyright (C) 2013, Agent Image <support@agentimage.com>
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

// let's only do admin
if ( is_admin() ) {
	// some constants
	define( 'AIN_BLOG_FEED', 'http://www.agentimage.com/blog/feed' );
	define( 'AIN_TWITTER_FEED', 'http://www.agentimage.com/twitter/API/ai_timeline.rss' );
	define( 'AIN_PLUGIN_NAME', basename( dirname( __FILE__ ) ) );
	define( 'AIN_PLUGIN_DIR',  dirname( __FILE__ ) );
	define( 'AIN_LIB_DIR',     AIN_PLUGIN_DIR . '/lib' );
	define( 'AIN_HTML_DIR',    AIN_PLUGIN_DIR . '/html' );

	// include class
	require_once( AIN_LIB_DIR . '/class.agent_image_news.php' );

	// instatiate class
	$agent_image_news = new Agent_Image_News();

	// add blog feed to the dashboard
	add_action( 'wp_dashboard_setup', array( $agent_image_news, 'doDashboardWidget' ) );

	// some cleaning (not really needed but here anyway)
	unset( $agent_image_news );
}
