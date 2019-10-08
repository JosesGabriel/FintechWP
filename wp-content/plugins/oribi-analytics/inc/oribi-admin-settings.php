<?php
function oribi_register_settings() {
    add_option( 'oribi_snippet');
    register_setting( 'oribi_options_group', 'oribi_snippet' );
}
add_action( 'admin_init', 'oribi_register_settings' );


function oribi_register_options_page() {
    add_options_page( 'Oribi Analytics Settings', 'Oribi Analytics', 'manage_options', 'oribi', 'oribi_options_page_html' );
}
add_action( 'admin_menu', 'oribi_register_options_page' );


function oribi_options_page_html(){
	?>
	<div class="wrap">
		<h2><?php esc_html_e( 'Oribi Analytics for WordPress', 'oribi' ); ?></h2>
		
		<form method="post" action="options.php">
            <?php settings_fields( 'oribi_options_group' ); ?>

			<h4>
                <strong style="font-weight: 700;"><?php esc_html_e( 'Paste your Oribi tracking code below.', 'oribi' );?> </strong>
                <p style="font-weight: 300; color: #848383;">
                    <?php esc_html_e( 'Don’t have your personal Oribi tracking code? ', 'oribi' );?> <?php esc_html_e( 'Click','oribi' ); ?> <a href="https://oribi.io/login" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'here','oribi' );?></a>.
                </p>
            </h4>
			<textarea id="oribi_snippet" name="oribi_snippet" style="width: 600px; max-width: 100%; height: 200px;"><?php echo get_option( 'oribi_snippet' ); ?></textarea>
	
			<?php  submit_button(); ?>
		</form>
    </div>
	<?php
}