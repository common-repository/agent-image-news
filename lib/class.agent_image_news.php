<?php
/**
 * Agent_Image_News
 *
 * Quick and easy class. Displays html and css for the dashboard widget.
 */
class Agent_Image_News
{
	/**
	 * No constructor needed
	 */
	public function __construct() {}

	/**
	 * Adds our widget to WordPress and reorders the dashboard widgets.
	 */
	public function doDashboardWidget() {
		// widget name
		$agentimage_news_widget_name = 'agent_image_news-dashboard-widget';

		// add our agentimage widget
		wp_add_dashboard_widget(
			$agentimage_news_widget_name,
			'Agent Image News',
			array( $this, 'dashboardOutput' )
		);

		// reorder dashboard widgets to put us at top right (top of side section)
		$this->reorderDashWidgets( $agentimage_news_widget_name );
	}

	/**
	 * Outputs the HTML and CSS for the widget.
	 * 
	 * I tried to separate html and php as simple and best I could.
	 */
	public function dashboardOutput() {
		// set some variables for the template
		$plugin_url = plugins_url( AIN_PLUGIN_NAME );

		// need to use ob_start() to get wp_widget_rss_output()
		ob_start();
		wp_widget_rss_output(array(
        	'url' => AIN_BLOG_FEED,
        	'items' => 3,
        	'show_summary' => 1,
        	'show_author' => 0,
        	'show_date' => 1
   		));
   		$agentimage_blog_feed = ob_get_clean();

   		ob_start();
   		wp_widget_rss_output(array(
        	'url' => AIN_TWITTER_FEED,
        	'items' => 5,
        	'show_summary' => 0,
        	'show_author' => 0,
        	'show_date' => 1
   		));
   		$agentimage_twitter_feed = ob_get_clean();

		// include css
		include_once( AIN_HTML_DIR . '/css/agent_image_news.css.php' );

		// include html
		include_once( AIN_HTML_DIR . '/agent_image_news.html.php' );
	}

	/*
	 * re-order the widgets so we are on top
	 *
	 * Unfortunately, if the user has already altered the order of the widgets,
	 * this doesn't do anything. Oh well.
	 * 
	 * If you want to re-order it, the widgets are in 2 arrays: normal and side. 'Normal' is the left side, and
	 *  (left column is in a)
	 */
	private function reorderDashWidgets( $agentimage_news_widget_name ) {
		global $wp_meta_boxes;

		// save our plugin and the QuickPress one too (we are moving this under core)
		$our_plugin[$agentimage_news_widget_name] = $wp_meta_boxes['dashboard']['normal']['core'][$agentimage_news_widget_name];
		$quickpress['dashboard_quick_press'] = $wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press'];

		// remove our plugin from the core array and remove quickpress too
		unset( $wp_meta_boxes['dashboard']['normal']['core'][$agentimage_news_widget_name] );
		unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_quick_press'] );

		// place our plugin in the beginning of the side array
		$wp_meta_boxes['dashboard']['side']['core'] = array_merge( $our_plugin, $wp_meta_boxes['dashboard']['side']['core'] );

		// ok now we pop first element of core side...
		$temp_first_element = array_shift( $wp_meta_boxes['dashboard']['normal']['core'] );
		$first_element[$temp_first_element['id']] = $temp_first_element;

		// and now we merge them to put quick press in 2nd position of core side
		$wp_meta_boxes['dashboard']['normal']['core'] = array_merge( $first_element, $quickpress, $wp_meta_boxes['dashboard']['normal']['core'] );

		// Done!
	}
}