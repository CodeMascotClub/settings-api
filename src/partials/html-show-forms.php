<div class="metabox-holder">
	<?php foreach ( $this->settings_sections as $form ) { ?>
		<div id="<?php echo esc_attr( $form['id'] ); ?>" class="group" style="display: none;">
			<form method="post" action="options.php">
				<?php
				do_action( 'wsa_form_top_' . $form['id'], $form );
				settings_fields( $form['id'] );
				do_settings_sections( $form['id'] );
				do_action( 'wsa_form_bottom_' . $form['id'], $form );
				if ( isset( $this->settings_fields[ $form['id'] ] ) ) :
					?>
					<div style="padding-left: 10px">
						<?php submit_button(); ?>
					</div>
				<?php endif; ?>
			</form>
		</div>
	<?php } ?>
</div>