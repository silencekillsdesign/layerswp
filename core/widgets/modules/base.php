<?php  /**
 * Layers Widget Class
 *
 * This file is used to register the base layers widget Class
 *
 * @package Layers
 * @since Layers 1.0
 */

if( !class_exists( 'Layers_Widget' ) ) {
	class Layers_Widget extends WP_Widget {

		/**
		* Check option with isset() and echo it out if it exists, if it does not exist, return false
		*
		* @param  	array		$widget 	Widget Object
		* @param  	varchar 	$option 	Widget option to check on
		* @param  	varchar 	$array_level_1 	Array level one to check for (optional)
		* @param  	varchar 	$array_level_2 	Array level two to check for (optional)
		* @return  	varchar 	false if not set, otherwise returns value
		*/

		function check_and_return( $widget = NULL , $option = NULL, $array_level_1 = NULL, $array_level_2 = NULL ){

			// If there is no widget object
			if( $widget == NULL ) return false;

			if( !isset( $widget[$option] ) ){
				return false;
			} else {
				$widget_option = $widget[$option];
			}

			if( NULL != $array_level_1 ){
				if( !isset( $widget_option[ $array_level_1 ] ) ){
					return false;
				} elseif( '' != $widget_option[ $array_level_1 ] ){
					if( NULL != $array_level_2 ){
						if( !isset( $widget_option[ $array_level_1 ][ $array_level_2 ] ) ){
							return false;
						} elseif( '' != $widget_option[ $array_level_1 ][ $array_level_2 ] ) {
							return $widget_option[ $array_level_1 ][ $array_level_2 ];
						}
					} elseif( '' != $widget_option[ $array_level_1 ] )  {
						return $widget_option[ $array_level_1 ];
					}
				}
			} elseif( '' != $widget_option ){
				return $widget_option;
			}

		}

		function get_widget_layout_class( $widget = NULL ){

			if( NULL == $widget ) return;

			// Setup the layout class for boxed/full width/full screen
			if( 'layout-boxed' == $this->check_and_return( $widget , 'design' , 'layout' ) ) {
				$layout_class = 'container';
			} elseif('layout-full-screen' == $this->check_and_return( $widget , 'design' , 'layout' ) ) {
				$layout_class = 'full-screen';
			} elseif( 'layout-full-width' == $this->check_and_return( $widget , 'design' , 'layout' ) ) {
				$layout_class = 'full-width';
			} else {
				$layout_class = '';
			}

			return $layout_class;
		}

		/**
		* Design Bar Class Instantiation, we'd rather have it done here than in each widget
		*
		* @return  	html 		Design bar HTML
		*/
		public function design_bar(  $type = 'side' , $widget = NULL, $instance = array(), $components = array( 'columns' , 'background' , 'imagealign' ) , $custom_components = array()  ) {

			// Instantiate design bar
			$design_bar = new Layers_Design_Controller( $type, $widget, $instance, $components, $custom_components );

			// Return design bar
			return $design_bar;

		}

		/**
		* Form Elements Class Instantiation, we'd rather have it done here than in each widget
		*
		* @return  	html 		Design bar HTML
		*/
		public function form_elements() {

			// Instantiate Widget Inputs
			$form_elements = new Layers_Form_Elements();

			// Return design bar
			return $form_elements;

		}

		/**
		* Widget sub-module input name generation, for example see Slider and Content Widgets
		*
		* @param  	object 		$widget_details 	Widget object to use
		* @param  	varchar 	$level1 	Level 1 name
		* @param  	varchar 	$level2 	Level 2 name
	 	* @param 	string 		$field_name Field name
	 	* @return 	string 		Name attribute for $field_name
		*/
		function get_custom_field_name( $widget_details = NULL, $level1 = '' , $level2 = '', $field_name = '' ) {

			// If there is no widget object then ignore
			if( NULL == $widget_details ) return;

			$final_field_name = 'widget-' . $widget_details->id_base . '[' . $widget_details->number . ']';

			// Add first level of input string
			if( '' != $level1 ) $final_field_name .= '[' . $level1 . ']';

			// Add second level of input string
			if( '' != $level2 ) $final_field_name .= '[' . $level2 . ']';

			// Add field name
			if( '' != $field_name ) $final_field_name .= '[' . $field_name . ']';

			return $final_field_name;
		}

		/**
		* Widget sub-module input id generation, for example see Slider and Content Widgets
		*
		* @param  	object 		$widget_details 	Widget object to use
		* @param  	varchar 	$level1 	Level 1 name
		* @param  	varchar 	$level2 	Level 2 name
	 	* @param 	string 		$field_name Field name
	 	* @return 	string 		Name attribute for $field_name
		*/
		function get_custom_field_id( $widget_details = NULL, $level1 = '' , $level2 = '', $field_id = '' ) {

			// If there is no widget object then ignore
			if( NULL == $widget_details ) return;

			$final_field_id = 'widget-' . $widget_details->id_base . '-' . $widget_details->number;

			// Add first level of input string
			if( '' != $level1 ) $final_field_id .= '-' . $level1;

			// Add second level of input string
			if( '' != $level2 ) $final_field_id .= '-' . $level2;

			// Add field name
			if( '' != $field_id ) $final_field_id .= '-' . $field_id;

			return $final_field_id;
		}

	}
}