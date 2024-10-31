<?php
	/**************************/
	/* www.phplivesupport.com */
	/**************************/
	CLASS phplive_widget EXTENDS WP_Widget
	{
		function __construct()
		{
			parent::__construct( 'phplive_widget', 'PHP Live!', array( 'classname' => 'phplive_widget', 'description' => 'Integrate PHP Live! with WordPress' ) ) ;
		}
		function form( $instance ){ }
		function widget( $args, $instance ) { phplive::get_instance()->widget_fetch_phplive_html_code() ; }
	}
?>
