<div class="wrap themeboy">
	<form method="post" id="mainform" action="" enctype="multipart/form-data">
		<div class="icon32 icon32-themeboy-settings" id="icon-themeboy"><br /></div><h2 class="nav-tab-wrapper tb-nav-tab-wrapper">
			<?php
				foreach ( $tabs as $name => $label )
					echo '<a href="' . admin_url( 'admin.php?page=themeboy&tab=' . $name ) . '" class="nav-tab ' . ( $current_tab == $name ? 'nav-tab-active' : '' ) . '">' . $label . '</a>';

				do_action( 'themeboy_settings_tabs' );
			?>
		</h2>

		<?php
			do_action( 'themeboy_sections_' . $current_tab );
			do_action( 'themeboy_settings_' . $current_tab );
			do_action( 'themeboy_settings_tabs_' . $current_tab ); // @deprecated hook
		?>

        <p class="submit">
        	<?php if ( ! isset( $GLOBALS['hide_save_button'] ) ) : ?>
        		<input name="save" class="button-primary" type="submit" value="<?php _e( 'Save changes', 'themeboy' ); ?>" />
        	<?php endif; ?>
        	<input type="hidden" name="subtab" id="last_tab" />
        	<?php wp_nonce_field( 'themeboy-settings' ); ?>
        </p>
	</form>
</div>