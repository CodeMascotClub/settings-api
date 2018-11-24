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
 * @package         CodeMascot_Settings_Api_Test
 */

class CodeMascot_Settings_API_Test {

	private $settings_api;

	/**
	 * TheDramatist_Settings_API_Test constructor.
	 */
	public function __construct() {
		$this->settings_api = new CodeMascot\SettingsAPI\SettingsAPI();
	}

	/**
	 * Initialize plugin functionality.
	 *
	 * @return void
	 */
	public function init() {
		add_action( 'admin_init', [ $this, 'admin_init' ] );
		add_action( 'admin_menu', [ $this, 'admin_menu' ] );
	}

	/**
	 * Admin init functionality.
	 *
	 * @return void
	 */
	public function admin_init() {
		//set the settings
		$this->settings_api->set_sections( $this->get_settings_sections() );
		$this->settings_api->set_fields( $this->get_settings_fields() );
		//initialize settings
		$this->settings_api->admin_init();
	}

	/**
	 * Add menu to admin menu
	 *
	 * @return void
	 */
	public function admin_menu() {
		add_options_page(
			__( 'CodeMascot Settings', 'codemascot-settings-api-test' ),
			__( 'CodeMascot Settings', 'codemascot-settings-api-test' ),
			'delete_posts',
			'codemascot_settings_api_test',
			[ $this, 'settings_page' ]
		);
	}

	/**
	 * Settings array construction
	 *
	 * @return array
	 */
	public function get_settings_sections() {
		$sections = [
			[
				'id'    => 'codemascot_basics',
				'title' => __( 'Basic Settings', 'codemascot-settings-api-test' ),
				'desc'	=> __( 'Basic Settings Description', 'codemascot-settings-api-test' ),
			],
			[
				'id'    => 'codemascot_advanced',
				'title' => __( 'Advanced Settings', 'codemascot-settings-api-test' ),
				'desc'	=> __( 'Advanced Settings Description', 'codemascot-settings-api-test' ),
			],
		];
		return $sections;
	}

	/**
	 * Returns all the settings fields
	 *
	 * @return array settings fields
	 */
	public function get_settings_fields() {
		$settings_fields = [
			'codemascot_basics'   => [
				[
					'name'              => 'text_val',
					'label'             => __( 'Text Input', 'codemascot-settings-api-test' ),
					'desc'              => __(
						'Text input description',
						'codemascot-settings-api-test'
					),
					'placeholder'       => __(
						'Text Input placeholder',
						'codemascot-settings-api-test'
					),
					'type'              => 'text',
					'default'           => 'Title',
					'sanitize_callback' => 'sanitize_text_field',
				],
				[
					'name'              => 'number_input',
					'label'             => __( 'Number Input', 'codemascot-settings-api-test' ),
					'desc'              => __(
						'Number field with validation callback `floatval`',
						'codemascot-settings-api-test'
					),
					'placeholder'       => __( '1.99', 'codemascot-settings-api-test' ),
					'min'               => 0,
					'max'               => 100,
					'step'              => '0.01',
					'type'              => 'number',
					'default'           => 'Title',
					'sanitize_callback' => 'floatval',
				],
				[
					'name'        => 'textarea',
					'label'       => __( 'Textarea Input', 'codemascot-settings-api-test' ),
					'desc'        => __( 'Textarea description', 'codemascot-settings-api-test' ),
					'placeholder' => __( 'Textarea placeholder', 'codemascot-settings-api-test' ),
					'type'        => 'textarea',
				],
				[
					'name' => 'html',
					'desc' => __(
						'HTML area description. You can use any <strong>bold</strong> or other HTML elements.',
						'codemascot-settings-api-test'
					),
					'type' => 'html',
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
					'options' => [
						'button_label' => 'Choose Image',
					],
				],
			],
			'the_dramatist_advanced' => [
				[
					'name'    => 'color',
					'label'   => __( 'Color', 'the-dramatist' ),
					'desc'    => __( 'Color description', 'the-dramatist' ),
					'type'    => 'color',
					'default' => '',
				],
				[
					'name'    => 'password',
					'label'   => __( 'Password', 'the-dramatist' ),
					'desc'    => __( 'Password description', 'the-dramatist' ),
					'type'    => 'password',
					'default' => '',
				],
				[
					'name'    => 'wysiwyg',
					'label'   => __( 'Advanced Editor', 'the-dramatist' ),
					'desc'    => __( 'WP_Editor description', 'the-dramatist' ),
					'type'    => 'wysiwyg',
					'default' => '',
				],
				[
					'name'    => 'multicheck',
					'label'   => __( 'Multile checkbox', 'the-dramatist' ),
					'desc'    => __( 'Multi checkbox description', 'the-dramatist' ),
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
			],
		];
		return $settings_fields;
	}

	/**
	 * Rendering settings page
	 *
	 * @return void
	 */
	public function settings_page() {
		echo '<div class="wrap">';
		$this->settings_api->show_navigation();
		$this->settings_api->show_forms();
		echo '</div>';
	}

	/**
	 * Get all the pages
	 *
	 * @return array page names with key value pairs
	 */
	public function get_pages() {
		$pages         = get_pages();
		$pages_options = [];
		if ( $pages ) {
			foreach ( $pages as $page ) {
				$pages_options[ $page->ID ] = $page->post_title;
			}
		}
		return $pages_options;
	}
}

// Instantiating the class.
( new TheDramatist_Settings_API_Test() )->init();
