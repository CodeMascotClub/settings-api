<?php
/**
 * Plugin Name:     CodeMascot Settings Api Test
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     PLUGIN DESCRIPTION HERE
 * Author:          YOUR NAME HERE
 * Author URI:      YOUR SITE HERE
 * Text Domain:     codemascot-settings-api-test
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package        CodeMascot_Settings_Api_Test
 */

/**
 * This page shows the procedural or functional example
 * This procedural approach is discouraged, cause it uses super globals.
 */

/**
 * Registers settings section and fields
 */
if ( ! function_exists( 'codemascot_admin_init' ) ) :
	function codemascot_admin_init() {

		$sections = [
			[
				'id'    => 'codemascot_basics',
				'title' => __( 'Basic Settings', 'codemascot-settings-api-test' ),
				'desc' => __( 'Basic Settings Description', 'codemascot-settings-api-test' ),
			],
			[
				'id'    => 'codemascot_advanced',
				'title' => __( 'Advanced Settings', 'codemascot-settings-api-test' ),
				'desc' => __( 'Advanced Settings Description', 'codemascot-settings-api-test' ),
			],
			[
				'id'    => 'codemascot_others',
				'title' => __( 'Other Settings', 'codemascot-settings-api-test' ),
				'desc' => __( 'Other Settings Description', 'codemascot-settings-api-test' ),
			],
		];

		$fields = [
			'codemascot_basics'   => [
				[
					'name'    => 'text',
					'label'   => __( 'Text Input', 'codemascot-settings-api-test' ),
					'desc'    => __(
						'Text input description',
						'codemascot-settings-api-test'
					),
					'type'    => 'text',
					'default' => 'Title',
				],
				[
					'name'  => 'textarea',
					'label' => __( 'Textarea Input', 'codemascot-settings-api-test' ),
					'desc'  => __( 'Textarea description', 'codemascot-settings-api-test' ),
					'type'  => 'textarea',
				],
				[
					'name'  => 'checkbox',
					'label' => __( 'Checkbox', 'codemascot-settings-api-test' ),
					'desc'  => __( 'Checkbox Label', 'codemascot-settings-api-test' ),
					'type'  => 'checkbox',
				],
				[
					'name'    => 'radio',
					'label'   => __( 'Radio Button', 'codemascot-settings-api-test' ),
					'desc'    => __( 'A radio button', 'codemascot-settings-api-test' ),
					'type'    => 'radio',
					'options' => [
						'yes' => 'Yes',
						'no'  => 'No',
					],
				],
				[
					'name'    => 'multicheck',
					'label'   => __( 'Multile checkbox', 'codemascot-settings-api-test' ),
					'desc'    => __(
						'Multi checkbox description',
						'codemascot-settings-api-test'
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
					'label'   => __( 'A Dropdown', 'codemascot-settings-api-test' ),
					'desc'    => __( 'Dropdown description', 'codemascot-settings-api-test' ),
					'type'    => 'select',
					'default' => 'no',
					'options' => [
						'yes' => 'Yes',
						'no'  => 'No',
					],
				],
				[
					'name'    => 'password',
					'label'   => __( 'Password', 'codemascot-settings-api-test' ),
					'desc'    => __( 'Password description', 'codemascot-settings-api-test' ),
					'type'    => 'password',
					'default' => '',
				],
				[
					'name'    => 'file',
					'label'   => __( 'File', 'codemascot-settings-api-test' ),
					'desc'    => __( 'File description', 'codemascot-settings-api-test' ),
					'type'    => 'file',
					'default' => '',
				],
				[
					'name'    => 'color',
					'label'   => __( 'Color', 'codemascot-settings-api-test' ),
					'desc'    => __( 'Color description', 'codemascot-settings-api-test' ),
					'type'    => 'color',
					'default' => '',
				],
			],
			'codemascot_advanced' => [
				[
					'name'    => 'text',
					'label'   => __( 'Text Input', 'codemascot-settings-api-test' ),
					'desc'    => __(
						'Text input description',
						'codemascot-settings-api-test'
					),
					'type'    => 'text',
					'default' => 'Title',
				],
				[
					'name'  => 'textarea',
					'label' => __( 'Textarea Input', 'codemascot-settings-api-test' ),
					'desc'  => __( 'Textarea description', 'codemascot-settings-api-test' ),
					'type'  => 'textarea',
				],
				[
					'name'  => 'checkbox',
					'label' => __( 'Checkbox', 'codemascot-settings-api-test' ),
					'desc'  => __( 'Checkbox Label', 'codemascot-settings-api-test' ),
					'type'  => 'checkbox',
				],
				[
					'name'    => 'radio',
					'label'   => __( 'Radio Button', 'codemascot-settings-api-test' ),
					'desc'    => __( 'A radio button', 'codemascot-settings-api-test' ),
					'type'    => 'radio',
					'default' => 'no',
					'options' => [
						'yes' => 'Yes',
						'no'  => 'No',
					],
				],
				[
					'name'    => 'multicheck',
					'label'   => __( 'Multile checkbox', 'codemascot-settings-api-test' ),
					'desc'    => __(
						'Multi checkbox description',
						'codemascot-settings-api-test'
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
					'label'   => __( 'A Dropdown', 'codemascot-settings-api-test' ),
					'desc'    => __( 'Dropdown description', 'codemascot-settings-api-test' ),
					'type'    => 'select',
					'options' => [
						'yes' => 'Yes',
						'no'  => 'No',
					],
				],
				[
					'name'    => 'password',
					'label'   => __( 'Password', 'codemascot-settings-api-test' ),
					'desc'    => __( 'Password description', 'codemascot-settings-api-test' ),
					'type'    => 'password',
					'default' => '',
				],
				[
					'name'    => 'file',
					'label'   => __( 'File', 'codemascot-settings-api-test' ),
					'desc'    => __( 'File description', 'codemascot-settings-api-test' ),
					'type'    => 'file',
					'default' => '',
				],
				[
					'name'    => 'color',
					'label'   => __( 'Color', 'codemascot-settings-api-test' ),
					'desc'    => __( 'Color description', 'codemascot-settings-api-test' ),
					'type'    => 'color',
					'default' => '',
				],
			],
			'codemascot_others'   => [
				[
					'name'    => 'text',
					'label'   => __( 'Text Input', 'codemascot-settings-api-test' ),
					'desc'    => __(
						'Text input description',
						'codemascot-settings-api-test'
					),
					'type'    => 'text',
					'default' => 'Title',
				],
				[
					'name'  => 'textarea',
					'label' => __( 'Textarea Input', 'codemascot-settings-api-test' ),
					'desc'  => __( 'Textarea description', 'codemascot-settings-api-test' ),
					'type'  => 'textarea',
				],
				[
					'name'  => 'checkbox',
					'label' => __( 'Checkbox', 'codemascot-settings-api-test' ),
					'desc'  => __( 'Checkbox Label', 'codemascot-settings-api-test' ),
					'type'  => 'checkbox',
				],
				[
					'name'    => 'radio',
					'label'   => __( 'Radio Button', 'codemascot-settings-api-test' ),
					'desc'    => __( 'A radio button', 'codemascot-settings-api-test' ),
					'type'    => 'radio',
					'options' => [
						'yes' => 'Yes',
						'no'  => 'No',
					],
				],
				[
					'name'    => 'multicheck',
					'label'   => __( 'Multile checkbox', 'codemascot-settings-api-test' ),
					'desc'    => __(
						'Multi checkbox description',
						'codemascot-settings-api-test'
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
					'label'   => __( 'A Dropdown', 'codemascot-settings-api-test' ),
					'desc'    => __( 'Dropdown description', 'codemascot-settings-api-test' ),
					'type'    => 'select',
					'options' => [
						'yes' => 'Yes',
						'no'  => 'No',
					],
				],
				[
					'name'    => 'password',
					'label'   => __( 'Password', 'codemascot-settings-api-test' ),
					'desc'    => __( 'Password description', 'codemascot-settings-api-test' ),
					'type'    => 'password',
					'default' => '',
				],
				[
					'name'    => 'file',
					'label'   => __( 'File', 'codemascot-settings-api-test' ),
					'desc'    => __( 'File description', 'codemascot-settings-api-test' ),
					'type'    => 'file',
					'default' => '',
				],
				[
					'name'    => 'color',
					'label'   => __( 'Color', 'codemascot-settings-api-test' ),
					'desc'    => __( 'Color description', 'codemascot-settings-api-test' ),
					'type'    => 'color',
					'default' => '',
				],
			],
		];

		$settings_api = new CodeMascot\SettingsAPI\SettingsAPI();

		//set sections and fields
		$settings_api->set_sections( $sections );
		$settings_api->set_fields( $fields );

		//initialize them
		$settings_api->admin_init();
		/**
		 * Needed to pass this to "codemascot_settings_page" function.
		 * Use another unique name here rather 'codemascot_settings_api'
		 * in $GLOBALS['codemascot_settings_api'].
		 */
		$GLOBALS['codemascot_settings_api'] = $settings_api;
	}
endif;
add_action( 'admin_init', 'codemascot_admin_init' );

if ( ! function_exists( 'codemascot_admin_menu' ) ) :
	/**
	 * Register the plugin page
	 */
	function codemascot_admin_menu() {
		add_options_page(
			__( 'CodeMascot Settings', 'codemascot-settings-api-test' ),
			__( 'CodeMascot Settings', 'codemascot-settings-api-test' ),
			'delete_posts',
			'codemascot_settings_api_test',
			'codemascot_settings_page'
		);
	}
endif;
add_action( 'admin_menu', 'codemascot_admin_menu' );

/**
 * Display the plugin settings options page
 */
if ( ! function_exists( 'codemascot_settings_page' ) ) :
	function codemascot_settings_page() {
		$settings_api = $GLOBALS['codemascot_settings_api'];
		echo '<div class="wrap">';
		settings_errors();
		$settings_api->show_navigation();
		$settings_api->show_forms();
		echo '</div>';
	}
endif;
