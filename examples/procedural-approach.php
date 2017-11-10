<?php
/**
 * Plugin Name:     The Dramatist Settings Api Test
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     PLUGIN DESCRIPTION HERE
 * Author:          YOUR NAME HERE
 * Author URI:      YOUR SITE HERE
 * Text Domain:     the-dramatist-settings-api-test
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         The_Dramatist_Settings_Api_Test
 */

/**
 * This page shows the procedural or functional example
 * This procedural approach is discouraged, cause it uses super globals.
 */

/**
 * Registers settings section and fields
 */
if ( ! function_exists( 'the_dramatist_admin_init' ) ) :
	function the_dramatist_admin_init() {

		$sections = [
			[
				'id'    => 'the_dramatist_basics',
				'title' => __( 'Basic Settings', 'the-dramatist' ),
			],
			[
				'id'    => 'the_dramatist_advanced',
				'title' => __( 'Advanced Settings', 'the-dramatist' ),
			],
			[
				'id'    => 'the_dramatist_others',
				'title' => __( 'Other Settings', 'wpuf' ),
			],
		];

		$fields = [
			'the_dramatist_basics'   => [
				[
					'name'    => 'text',
					'label'   => __( 'Text Input', 'the-dramatist' ),
					'desc'    => __(
						'Text input description',
						'the-dramatist'
					),
					'type'    => 'text',
					'default' => 'Title',
				],
				[
					'name'  => 'textarea',
					'label' => __( 'Textarea Input', 'the-dramatist' ),
					'desc'  => __( 'Textarea description', 'the-dramatist' ),
					'type'  => 'textarea',
				],
				[
					'name'  => 'checkbox',
					'label' => __( 'Checkbox', 'the-dramatist' ),
					'desc'  => __( 'Checkbox Label', 'the-dramatist' ),
					'type'  => 'checkbox',
				],
				[
					'name'    => 'radio',
					'label'   => __( 'Radio Button', 'the-dramatist' ),
					'desc'    => __( 'A radio button', 'the-dramatist' ),
					'type'    => 'radio',
					'options' => [
						'yes' => 'Yes',
						'no'  => 'No',
					],
				],
				[
					'name'    => 'multicheck',
					'label'   => __( 'Multile checkbox', 'the-dramatist' ),
					'desc'    => __(
						'Multi checkbox description',
						'the-dramatist'
					),
					'type'    => 'multicheck',
					'options' => [
						'one'   => 'One',
						'two'   => 'Two',
						'three' => 'Three',
						'four'  => 'Four',
					],
				],
				[
					'name'    => 'selectbox',
					'label'   => __( 'A Dropdown', 'the-dramatist' ),
					'desc'    => __( 'Dropdown description', 'the-dramatist' ),
					'type'    => 'select',
					'default' => 'no',
					'options' => [
						'yes' => 'Yes',
						'no'  => 'No',
					],
				],
				[
					'name'    => 'password',
					'label'   => __( 'Password', 'the-dramatist' ),
					'desc'    => __( 'Password description', 'the-dramatist' ),
					'type'    => 'password',
					'default' => '',
				],
				[
					'name'    => 'file',
					'label'   => __( 'File', 'the-dramatist' ),
					'desc'    => __( 'File description', 'the-dramatist' ),
					'type'    => 'file',
					'default' => '',
				],
				[
					'name'    => 'color',
					'label'   => __( 'Color', 'the-dramatist' ),
					'desc'    => __( 'Color description', 'the-dramatist' ),
					'type'    => 'color',
					'default' => '',
				],
			],
			'the_dramatist_advanced' => [
				[
					'name'    => 'text',
					'label'   => __( 'Text Input', 'the-dramatist' ),
					'desc'    => __(
						'Text input description',
						'the-dramatist'
					),
					'type'    => 'text',
					'default' => 'Title',
				],
				[
					'name'  => 'textarea',
					'label' => __( 'Textarea Input', 'the-dramatist' ),
					'desc'  => __( 'Textarea description', 'the-dramatist' ),
					'type'  => 'textarea',
				],
				[
					'name'  => 'checkbox',
					'label' => __( 'Checkbox', 'the-dramatist' ),
					'desc'  => __( 'Checkbox Label', 'the-dramatist' ),
					'type'  => 'checkbox',
				],
				[
					'name'    => 'radio',
					'label'   => __( 'Radio Button', 'the-dramatist' ),
					'desc'    => __( 'A radio button', 'the-dramatist' ),
					'type'    => 'radio',
					'default' => 'no',
					'options' => [
						'yes' => 'Yes',
						'no'  => 'No',
					],
				],
				[
					'name'    => 'multicheck',
					'label'   => __( 'Multile checkbox', 'the-dramatist' ),
					'desc'    => __(
						'Multi checkbox description',
						'the-dramatist'
					),
					'type'    => 'multicheck',
					'default' => [
						'one' => 'one',
						'four' => 'four',
					],
					'options' => [
						'one'   => 'One',
						'two'   => 'Two',
						'three' => 'Three',
						'four'  => 'Four',
					],
				],
				[
					'name'    => 'selectbox',
					'label'   => __( 'A Dropdown', 'the-dramatist' ),
					'desc'    => __( 'Dropdown description', 'the-dramatist' ),
					'type'    => 'select',
					'options' => [
						'yes' => 'Yes',
						'no'  => 'No',
					],
				],
				[
					'name'    => 'password',
					'label'   => __( 'Password', 'the-dramatist' ),
					'desc'    => __( 'Password description', 'the-dramatist' ),
					'type'    => 'password',
					'default' => '',
				],
				[
					'name'    => 'file',
					'label'   => __( 'File', 'the-dramatist' ),
					'desc'    => __( 'File description', 'the-dramatist' ),
					'type'    => 'file',
					'default' => '',
				],
				[
					'name'    => 'color',
					'label'   => __( 'Color', 'the-dramatist' ),
					'desc'    => __( 'Color description', 'the-dramatist' ),
					'type'    => 'color',
					'default' => '',
				],
			],
			'the_dramatist_others'   => [
				[
					'name'    => 'text',
					'label'   => __( 'Text Input', 'the-dramatist' ),
					'desc'    => __(
						'Text input description',
						'the-dramatist'
					),
					'type'    => 'text',
					'default' => 'Title',
				],
				[
					'name'  => 'textarea',
					'label' => __( 'Textarea Input', 'the-dramatist' ),
					'desc'  => __( 'Textarea description', 'the-dramatist' ),
					'type'  => 'textarea',
				],
				[
					'name'  => 'checkbox',
					'label' => __( 'Checkbox', 'the-dramatist' ),
					'desc'  => __( 'Checkbox Label', 'the-dramatist' ),
					'type'  => 'checkbox',
				],
				[
					'name'    => 'radio',
					'label'   => __( 'Radio Button', 'the-dramatist' ),
					'desc'    => __( 'A radio button', 'the-dramatist' ),
					'type'    => 'radio',
					'options' => [
						'yes' => 'Yes',
						'no'  => 'No',
					],
				],
				[
					'name'    => 'multicheck',
					'label'   => __( 'Multile checkbox', 'the-dramatist' ),
					'desc'    => __(
						'Multi checkbox description',
						'the-dramatist'
					),
					'type'    => 'multicheck',
					'options' => [
						'one'   => 'One',
						'two'   => 'Two',
						'three' => 'Three',
						'four'  => 'Four',
					],
				],
				[
					'name'    => 'selectbox',
					'label'   => __( 'A Dropdown', 'the-dramatist' ),
					'desc'    => __( 'Dropdown description', 'the-dramatist' ),
					'type'    => 'select',
					'options' => [
						'yes' => 'Yes',
						'no'  => 'No',
					],
				],
				[
					'name'    => 'password',
					'label'   => __( 'Password', 'the-dramatist' ),
					'desc'    => __( 'Password description', 'the-dramatist' ),
					'type'    => 'password',
					'default' => '',
				],
				[
					'name'    => 'file',
					'label'   => __( 'File', 'the-dramatist' ),
					'desc'    => __( 'File description', 'the-dramatist' ),
					'type'    => 'file',
					'default' => '',
				],
				[
					'name'    => 'color',
					'label'   => __( 'Color', 'the-dramatist' ),
					'desc'    => __( 'Color description', 'the-dramatist' ),
					'type'    => 'color',
					'default' => '',
				],
			],
		];

		$settings_api = new TheDramatist\SettingsAPI\SettingsAPI();

		//set sections and fields
		$settings_api->set_sections( $sections );
		$settings_api->set_fields( $fields );

		//initialize them
		$settings_api->admin_init();
		/**
		 * Needed to pass this to "the_dramatist_settings_page" function.
		 * Use another unique name here rather 'the_dramatist_settings_api'
		 * in $GLOBALS['the_dramatist_settings_api'].
		 */
		$GLOBALS['the_dramatist_settings_api'] = $settings_api;
	}
endif;
add_action( 'admin_init', 'the_dramatist_admin_init' );

if ( ! function_exists( 'the_dramatist_admin_menu' ) ) :
	/**
	 * Register the plugin page
	 */
	function the_dramatist_admin_menu() {
		add_options_page(
			__( 'TheDramatist Settings', 'the-dramatist' ),
			__( 'TheDramatist Settings', 'the-dramatist' ),
			'delete_posts',
			'the_dramatist_settings_api_test',
			'the_dramatist_settings_page'
		);
	}
endif;
add_action( 'admin_menu', 'the_dramatist_admin_menu' );

/**
 * Display the plugin settings options page
 */
if ( ! function_exists( 'the_dramatist_settings_page' ) ) :
	function the_dramatist_settings_page() {
		$settings_api = $GLOBALS['the_dramatist_settings_api'];
		echo '<div class="wrap">';
		settings_errors();
		$settings_api->show_navigation();
		$settings_api->show_forms();
		echo '</div>';
	}
endif;
