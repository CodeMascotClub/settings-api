<?php # -*- coding: utf-8 -*-

namespace TheDramatist\SettingsAPI;

/**
 * Class SettingsAPI
 *
 * @version 1.0.0
 * @since 1.0.0
 *
 * @author Khan M Rashedun-Naby <naby88@gmail.com>
 * @package TheDramatist\SettingsAPI
 */
class SettingsAPI {

	/**
	 * settings sections array
	 *
	 * @var array
	 */
	protected $settings_sections = [];

	/**
	 * Settings fields array
	 *
	 * @var array
	 */
	protected $settings_fields = [];

	/**
	 * SettingsAPI constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action(
			'admin_enqueue_scripts',
			[ $this, 'admin_scripts' ]
		);
	}

	/**
	 * Enqueue scripts and styles
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function admin_scripts() {
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_media();
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_script( 'jquery' );
	}

	/**
	 * Set settings sections
	 *
	 * @since 1.0.0
	 *
	 * @param array $sections setting sections array
	 *
	 * @return $this
	 */
	public function set_sections( $sections ) {
		$this->settings_sections = $sections;
		return $this;
	}

	/**
	 * Add a single section
	 *
	 * @since 1.0.0
	 *
	 * @param array $section
	 *
	 * @return $this
	 */
	public function add_section( $section ) {
		$this->settings_sections[] = $section;
		return $this;
	}

	/**
	 * Set settings fields
	 *
	 * @since 1.0.0
	 *
	 * @param array $fields settings fields array
	 *
	 * @return $this
	 */
	public function set_fields( $fields ) {
		$this->settings_fields = $fields;
		return $this;
	}

	/**
	 * Add settings fields
	 *
	 * @since 1.0.0
	 *
	 * @param $section
	 * @param $field
	 *
	 * @return $this
	 */
	public function add_field( $section, $field ) {
		$defaults = [
			'name'  => '',
			'label' => '',
			'desc'  => '',
			'type'  => 'text',
		];
		$arg = wp_parse_args( $field, $defaults );
		$this->settings_fields[ $section ][] = $arg;
		return $this;
	}

	/**
	 * Initialize and registers the settings sections and fields to WordPress
	 *
	 * Usually this should be called at `admin_init` hook.
	 *
	 * This function gets the initiated settings sections and fields. Then
	 * registers them to WordPress and ready for use.
	 *
	 * @since 1.0.0
	 */
	public function admin_init() {
		//register settings sections
		foreach ( $this->settings_sections as $section ) {
			if ( false === get_option( $section['id'] ) ) {
				add_option( $section['id'] );
			}
			if (
				isset( $section['desc'] ) &&
				! empty( $section['desc'] )
			) {
				$section['desc'] = '<div class="inside">'
									. esc_html( $section['desc'] )
									. '</div>';
				$callback = create_function(
					'',
					'echo "' . str_replace(
						'"',
						'\"',
						esc_html( $section['desc'] )
					) . '";'
				);
			} elseif ( isset( $section['callback'] ) ) {
				$callback = $section['callback'];
			} else {
				$callback = null;
			}
			add_settings_section(
				$section['id'],
				$section['title'],
				$callback,
				$section['id']
			);
		}
		//register settings fields
		foreach ( $this->settings_fields as $section => $field ) {
			foreach ( $field as $option ) {
				$name     = $option['name'];
				$type     = isset( $option['type'] ) ? $option['type']
					: 'text';
				$label    = isset( $option['label'] ) ? $option['label']
					: '';
				$callback = isset( $option['callback'] )
					? $option['callback'] : [ $this, 'callback_' . $type ];
				$args = [
					'id'                => $name,
					'class'             => isset( $option['class'] )
						? $option['class'] : $name,
					'label_for'         => "{$section}[{$name}]",
					'desc'              => isset( $option['desc'] )
						? $option['desc'] : '',
					'name'              => $label,
					'section'           => $section,
					'size'              => isset( $option['size'] )
						? $option['size'] : null,
					'options'           => isset( $option['options'] )
						? $option['options'] : '',
					'std'               => isset( $option['default'] )
						? $option['default'] : '',
					'sanitize_callback' => isset( $option['sanitize_callback'] )
						? $option['sanitize_callback'] : '',
					'type'              => $type,
					'placeholder'       => isset( $option['placeholder'] )
						? $option['placeholder'] : '',
					'min'               => isset( $option['min'] )
						? $option['min'] : '',
					'max'               => isset( $option['max'] )
						? $option['max'] : '',
					'step'              => isset( $option['step'] )
						? $option['step'] : '',
				];
				add_settings_field(
					"{$section}[{$name}]",
					$label,
					$callback,
					$section,
					$section,
					$args
				);
			}
		}
		// creates our settings in the options table
		foreach ( $this->settings_sections as $section ) {
			register_setting(
				$section['id'],
				$section['id'],
				[ $this, 'sanitize_options' ]
			);
		}
	}

	/**
	 * Get field description for display
	 *
	 * @since 1.0.0
	 *
	 * @param array $args settings field args
	 *
	 * @return string
	 */
	public function get_field_description( $args ) {
		if ( ! empty( $args['desc'] ) ) {
			$desc = sprintf(
				'<p class="description">%s</p>',
				esc_html( $args['desc'] )
			);
		} else {
			$desc = '';
		}
		return $desc;
	}

	/**
	 * Displays a text field for a settings field
	 *
	 * @since 1.0.0
	 *
	 * @param array $args settings field args
	 *
	 * @return void
	 */
	public function callback_text( $args ) {
		$value       = esc_attr(
			$this->get_option(
				$args['id'], $args['section'], $args['std']
			)
		);
		$size        = isset( $args['size'] ) && ! is_null( $args['size'] )
			? $args['size'] : 'regular';
		$type        = isset( $args['type'] ) ? $args['type'] : 'text';
		$placeholder = empty( $args['placeholder'] ) ? ''
			: ' placeholder="' . $args['placeholder'] . '"';
		$html = sprintf(
			'<input type="%1$s"
			class="%2$s-text"
			id="%3$s[%4$s]"
			name="%3$s[%4$s]"
			value="%5$s"%6$s/>',
			esc_attr( $type ),
			esc_attr( $size ),
			esc_attr( $args['section'] ),
			esc_attr( $args['id'] ),
			esc_html( $value ),
			esc_attr( $placeholder )
		);
		$html .= $this->get_field_description( $args );
		echo $html;
	}

	/**
	 * Displays a url field for a settings field
	 *
	 * @param array $args settings field args
	 */
	public function callback_url( $args ) {
		$this->callback_text( $args );
	}

	/**
	 * Displays a number field for a settings field
	 *
	 * @param array $args settings field args
	 * @return void
	 */
	public function callback_number( $args ) {
		$value       = esc_attr(
			$this->get_option(
				$args['id'], $args['section'], $args['std']
			)
		);
		$size        = isset( $args['size'] ) && ! is_null( $args['size'] )
			? $args['size'] : 'regular';
		$type        = isset( $args['type'] ) ? $args['type'] : 'number';
		$placeholder = empty( $args['placeholder'] ) ? ''
			: ' placeholder="' . $args['placeholder'] . '"';
		$min         = empty( $args['min'] ) ? ''
			: ' min="' . $args['min'] . '"';
		$max         = empty( $args['max'] ) ? ''
			: ' max="' . $args['max'] . '"';
		$step        = empty( $args['max'] ) ? ''
			: ' step="' . $args['step'] . '"';
		$html = sprintf(
			'<input
			type="%1$s"
			class="%2$s-number"
			id="%3$s[%4$s]"
			name="%3$s[%4$s]"
			value="%5$s"%6$s%7$s%8$s%9$s/>',
			esc_attr( $type ),
			esc_attr( $size ),
			esc_attr( $args['section'] ),
			esc_attr( $args['id'] ),
			esc_html( $value ),
			esc_attr( $placeholder ),
			esc_attr( $min ),
			esc_attr( $max ),
			esc_attr( $step )
		);
		$html .= $this->get_field_description( $args );
		echo $html;
	}

	/**
	 * Displays a checkbox for a settings field
	 *
	 * @param array $args settings field args
	 */
	public function callback_checkbox( $args ) {
		$value = esc_attr(
			$this->get_option(
				$args['id'], $args['section'], $args['std']
			)
		);
		$html = '<fieldset>';
		$html .= sprintf(
			'<label for="wpuf-%1$s[%2$s]">',
			esc_attr( $args['section'] ),
			esc_attr( $args['id'] )
		);
		$html .= sprintf(
			'<input type="hidden"
			name="%1$s[%2$s]"
			value="off" />',
			esc_attr( $args['section'] ),
			esc_attr( $args['id'] )
		);
		$html .= sprintf(
			'<input type="checkbox"
			class="checkbox"
			id="wpuf-%1$s[%2$s]"
			name="%1$s[%2$s]"
			value="on" %3$s />',
			esc_attr( $args['section'] ),
			esc_attr( $args['id'] ),
			checked( $value, 'on', false )
		);
		$html .= sprintf( '%1$s</label>', esc_html( $args['desc'] ) );
		$html .= '</fieldset>';
		echo $html;
	}

	/**
	 * Displays a multi-checkbox for a settings field
	 *
	 * @since 1.0.0
	 * @param array $args settings field args
	 */
	public function callback_multicheck( $args ) {
		$value = $this->get_option(
			$args['id'], $args['section'], $args['std']
		);
		$html  = '<fieldset>';
		$html  .= sprintf(
			'<input type="hidden"
			name="%1$s[%2$s]"
			value="" />',
			esc_attr( $args['section'] ),
			esc_attr( $args['id'] )
		);
		foreach ( $args['options'] as $key => $label ) {
			$checked = isset( $value[ $key ] ) ? $value[ $key ] : '0';
			$html    .= sprintf(
				'<label for="wpuf-%1$s[%2$s][%3$s]">',
				esc_attr( $args['section'] ),
				esc_attr( $args['id'] ), esc_attr( $key )
			);
			$html    .= sprintf(
				'<input type="checkbox"
				class="checkbox"
				id="wpuf-%1$s[%2$s][%3$s]"
				name="%1$s[%2$s][%3$s]"
				value="%3$s" %4$s />',
				esc_attr( $args['section'] ),
				esc_attr( $args['id'] ), esc_attr( $key ),
				checked( $checked, $key, false )
			);
			$html    .= sprintf( '%1$s</label><br>', $label );
		}
		$html .= $this->get_field_description( $args );
		$html .= '</fieldset>';
		echo $html;
	}

	/**
	 * Displays a radio button for a settings field
	 *
	 * @since 1.0.0
	 * @param array $args settings field args
	 */
	public function callback_radio( $args ) {
		$value = $this->get_option(
			$args['id'], $args['section'], $args['std']
		);
		$html  = '<fieldset>';
		foreach ( $args['options'] as $key => $label ) {
			$html .= sprintf(
				'<label for="wpuf-%1$s[%2$s][%3$s]">',
				esc_attr( $args['section'] ),
				esc_attr( $args['id'] ), esc_attr( $key )
			);
			$html .= sprintf(
				'<input type="radio"
				class="radio"
				id="wpuf-%1$s[%2$s][%3$s]"
				name="%1$s[%2$s]"
				value="%3$s" %4$s />',
				esc_attr( $args['section'] ),
				esc_attr( $args['id'] ), esc_attr( $key ),
				checked( $value, $key, false )
			);
			$html .= sprintf( '%1$s</label><br>', $label );
		}
		$html .= $this->get_field_description( $args );
		$html .= '</fieldset>';
		echo $html;
	}

	/**
	 * Displays a selectbox for a settings field
	 *
	 * @since 1.0.0
	 * @param array $args settings field args
	 */
	public function callback_select( $args ) {
		$value = esc_attr(
			$this->get_option(
				$args['id'], $args['section'], $args['std']
			)
		);
		$size  = isset( $args['size'] ) && ! is_null( $args['size'] )
			? $args['size'] : 'regular';
		$html  = sprintf(
			'<select class="%1$s" name="%2$s[%3$s]" id="%2$s[%3$s]">',
			esc_attr( $size ), esc_attr( $args['section'] ),
		    esc_attr( $args['id'] )
		);
		foreach ( $args['options'] as $key => $label ) {
			$html .= sprintf(
				'<option value="%s"%s>%s</option>',
				esc_attr( $key ), selected( $value, $key, false ),
				esc_html( $label )
			);
		}
		$html .= sprintf( '</select>' );
		$html .= $this->get_field_description( $args );
		echo $html;
	}

	/**
	 * Displays a textarea for a settings field
	 *
	 * @since 1.0.0
	 * @param array $args settings field args
	 *
	 * @return void
	 */
	public function callback_textarea( $args ) {
		$value       = esc_textarea(
			$this->get_option( $args['id'], $args['section'], $args['std'] )
		);
		$size        = isset( $args['size'] ) && ! is_null( $args['size'] )
			? $args['size'] : 'regular';
		$placeholder = empty( $args['placeholder'] ) ? ''
			: ' placeholder="' . $args['placeholder'] . '"';
		$html = sprintf(
			'<textarea rows="5" cols="55"
			class="%1$s-text"
			id="%2$s[%3$s]"
			name="%2$s[%3$s]"%4$s>%5$s
			</textarea>',
			esc_attr( $size ), esc_attr( $args['section'] ),
			esc_attr( $args['id'] ), esc_attr( $placeholder ),
			esc_html( $value )
		);
		$html .= $this->get_field_description( $args );
		echo $html;
	}

	/**
	 * Displays the html for a settings field
	 *
	 * @since 1.0.0
	 * @param array $args settings field args
	 *
	 * @return void
	 */
	public function callback_html( $args ) {
		echo $this->get_field_description( $args );
	}

	/**
	 * Displays a rich text textarea for a settings field
	 *
	 * @since 1.0.0
	 * @param array $args settings field args
	 *
	 * @return void
	 */
	public function callback_wysiwyg( $args ) {
		$value = esc_html(
			$this->get_option( $args['id'], $args['section'], $args['std'] )
		);
		$size  = isset( $args['size'] ) && ! is_null( $args['size'] )
			? $args['size'] : '500px';
		echo '<div style="max-width: ' . $size . ';">';
		$editor_settings = [
			'teeny'         => true,
			'textarea_name' => esc_attr( $args['section'] )
			                   . '[' . esc_attr( $args['id'] ) . ']',
			'textarea_rows' => 10,
		];

		if (
			isset( $args['options'] ) &&
			is_array( $args['options'] )
		) {
			$editor_settings = array_merge(
				$editor_settings, $args['options']
			);
		}
		wp_editor(
			$value,
			esc_attr(
				$args['section']
			) . '-' . esc_attr(
				$args['id']
			),
			$editor_settings
		);
		echo '</div>';
		echo $this->get_field_description( $args );
	}

	/**
	 * Displays a file upload field for a settings field
	 *
	 * @since 1.0.0
	 *
	 * @param array $args settings field args
	 *
	 * @return void
	 */
	public function callback_file( $args ) {
		$value = esc_attr(
			$this->get_option( $args['id'], $args['section'], $args['std'] )
		);
		$size  = isset( $args['size'] ) && ! is_null( $args['size'] )
			? $args['size'] : 'regular';
		$id    = esc_attr( $args['section'] )
		         . '[' . esc_attr( $args['id'] ) . ']';
		$label = isset( $args['options']['button_label'] )
			? $args['options']['button_label'] : __( 'Choose File' );

		$html = sprintf(
			'<input type="text"
			class="%1$s-text wpsa-url"
			id="%2$s[%3$s]"
			name="%2$s[%3$s]"
			value="%4$s"/>',
			esc_attr( $size ),
			esc_attr( $args['section'] ),
			esc_attr( $args['id'] ),
			esc_html( $value )
		);
		$html .= '<input type="button" class="button wpsa-browse" value="'
		         . $label . '" />';
		$html .= $this->get_field_description( $args );

		echo $html;
	}

	/**
	 * Displays a password field for a settings field
	 *
	 * @since 1.0.0
	 *
	 * @param array $args settings field args
	 *
	 * @return void
	 */
	public function callback_password( $args ) {
		$value = esc_attr(
			$this->get_option( $args['id'], $args['section'], $args['std'] )
		);
		$size  = isset( $args['size'] ) && ! is_null( $args['size'] )
			? $args['size'] : 'regular';
		$html = sprintf(
			'<input
			type="password"
			class="%1$s-text"
			id="%2$s[%3$s]"
			name="%2$s[%3$s]"
			value="%4$s"/>',
			esc_attr( $size ), esc_attr( $args['section'] ),
			esc_attr( $args['id'] ), esc_html( $value )
		);
		$html .= $this->get_field_description( $args );
		echo $html;
	}

	/**
	 * Displays a color picker field for a settings field
	 *
	 * @since 1.0.0
	 *
	 * @param array $args settings field args
	 *
	 * @return void
	 */
	public function callback_color( $args ) {
		$value = esc_attr(
			$this->get_option( $args['id'], $args['section'], $args['std'] )
		);
		$size  = isset( $args['size'] ) && ! is_null( $args['size'] )
			? $args['size'] : 'regular';
		$html = sprintf(
			'<input type="text"
			class="%1$s-text wp-color-picker-field"
			id="%2$s[%3$s]"
			name="%2$s[%3$s]"
			value="%4$s"
			data-default-color="%5$s" />',
			esc_attr( $size ), esc_attr( $args['section'] ),
			esc_attr( $args['id'] ), esc_html( $value ),
			esc_attr( $args['std'] )
		);
		$html .= $this->get_field_description( $args );
		echo $html;
	}

	/**
	 * Displays a select box for creating the pages select box
	 *
	 * @since 1.0.0
	 *
	 * @param array $args settings field args
	 *
	 * @return void
	 */
	public function callback_pages( $args ) {
		$dropdown_args = [
			'selected' => esc_attr(
				$this->get_option( $args['id'], $args['section'], $args['std'] )
			),
			'name'     => esc_attr( $args['section'] )
			              . '[' . esc_attr( $args['id'] ) . ']',
			'id'       => esc_attr( $args['section'] )
			              . '[' . esc_attr( $args['id'] ) . ']',
			'echo'     => 0,
		];
		$html          = wp_dropdown_pages( $dropdown_args );
		echo $html;
	}

	/**
	 * Sanitize callback for Settings API
	 *
	 * @since 1.0.0
	 *
	 * @param array $options
	 *
	 * @return array
	 */
	public function sanitize_options( $options ) {
		if ( ! $options ) {
			return $options;
		}
		foreach ( $options as $option_slug => $option_value ) {
			$sanitize_callback = $this->get_sanitize_callback( $option_slug );
			// If callback is set, call it
			if ( $sanitize_callback ) {
				$options[ $option_slug ] = call_user_func(
					$sanitize_callback, $option_value
				);
				continue;
			}
		}
		return $options;
	}

	/**
	 * Get sanitization callback for given option slug
	 *
	 * @since 1.0.0
	 *
	 * @param string $slug option slug
	 *
	 * @return mixed string or bool false
	 */
	public function get_sanitize_callback( $slug = '' ) {
		if ( empty( $slug ) ) {
			return false;
		}
		// Iterate over registered fields and see if we can find proper callback
		foreach ( $this->settings_fields as $section => $options ) {
			foreach ( $options as $option ) {
				if ( $option['name'] !== $slug ) {
					continue;
				}
				// Return the callback name
				return isset( $option['sanitize_callback'] ) &&
				       is_callable( $option['sanitize_callback'] ) ?
					$option['sanitize_callback'] : false;
			}
		}
		return false;
	}

	/**
	 * Get the value of a settings field
	 *
	 * @since 1.0.0
	 *
	 * @param string $option settings field name
	 * @param string $section the section name this field belongs to
	 * @param string $default default text if it's not found
	 *
	 * @return string
	 */
	public function get_option( $option, $section, $default = '' ) {
		$options = get_option( $section );
		if ( isset( $options[ $option ] ) ) {
			return $options[ $option ];
		}
		return $default;
	}

	/**
	 * Show navigation(s) as tab
	 *
	 * Shows all the settings section labels as tab
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function show_navigation() {
		$html = '<h2 class="nav-tab-wrapper">';
		$count = count( $this->settings_sections );
		// don't show the navigation if only one section exists
		if ( 1 === $count ) {
			return;
		}
		foreach ( $this->settings_sections as $tab ) {
			$html .= sprintf(
				'<a href="#%1$s" class="nav-tab" id="%1$s-tab">%2$s</a>',
				esc_attr( $tab[ 'id' ] ),
				esc_html( $tab[ 'title' ] )
			);
		}
		$html .= '</h2>';
		echo $html;
	}

	/**
	 * Show the section settings forms
	 *
	 * This function displays every sections in a different form
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function show_forms() {
		global $wp_version;
		// Rendering show forms.
		include_once 'partials/html-show-forms.php';
		// Tabbable JavaScript codes & Initiate Color Picker
		// This code uses local storage for displaying active tabs
		include_once 'assets/js/settings-api-js.php';
		// Form style fix if WP version is less than 3.8
		if ( version_compare( $wp_version, '3.8', '<=' ) ) {
			include_once 'assets/css/settings-api-css.php';
		}
	}

}
