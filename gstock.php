<?php
/*
Plugin Name: My GStock portfolio
Plugin URI: http://www.gstock.com/page.php?pg=wordpress
Author URI: http://www.gstock.com/
Description: Show your portfolio with your stocks, stocks' last price and current GStock BUY or SELL signal. After you activate this plugin please visit your widgets page (Presentation-> Widgets)  and drag the GStock widget to your desired location. <br>If you are new to GStock you can learn more on GStock <a href="http://www.gstock.com/">here</a>
Author:  The GStock Team
Version: 1.0
*/


function widget_gstock_init() {
	if ( !function_exists('register_sidebar_widget') )
		return;

	function widget_gstock($args) {
		extract($args);

		get_gstock_portfolio();


	}

	function widget_gstock_control() {
		$options = get_option('widget_gstock');
		if ( !is_array($options) )
			$options = array('gstock_email'=>'','gstock_password'=>'');
		if ( $_POST['gstock-submit'] ) {

			$options['gstock_email'] = strip_tags(stripslashes($_POST['gstock-gstock_email']));
			$options['gstock_password'] = strip_tags(stripslashes($_POST['gstock-gstock_password']));
			update_option('widget_gstock', $options);
		}

		$gstock_email = htmlspecialchars($options['gstock_email'], ENT_QUOTES);
		$gstock_password = htmlspecialchars($options['gstock_password'], ENT_QUOTES);
		
		echo '<p style="text-align:left;"><label>Display Your GStock portfolio</label></p>';
		echo '<p style="text-align:left;"><label>Your GStock username / email: <input style="width: 100%;" id="gstock-title" name="gstock-gstock_email" type="text" value="'.$gstock_email.'" /></label></p>';
		echo '<p style="text-align:left;"><label>Your GStock password: <input style="width: 100%;" id="gstock-title" name="gstock-gstock_password" type="text" value="'.$gstock_password.'" /></label></p>';
		echo '<input type="hidden" id="gstock-submit" name="gstock-submit" value="1" />';
	}
	
	register_sidebar_widget('GStock Portfolio', 'widget_gstock');

	register_widget_control('GStock Portfolio', 'widget_gstock_control', 300, 250);
}

function get_gstock_portfolio(){

	$options = get_option('widget_gstock');
	$email=$options['gstock_email'];
	$password=$options['gstock_password']; 
	
	$lines = file("http://www.gstock.com/wp_portfolio.php?email=$email&password=$password");

	foreach ($lines as $line_num => $line) {
	
	$part.= $line;

	}

		echo $part;


	
}
add_action('plugins_loaded', 'widget_gstock_init');
?>