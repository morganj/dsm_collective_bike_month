<?php 

class Ebor_Customize_Textarea_Control extends WP_Customize_Control {
    public $type = 'textarea';
    public function render_content() {
        ?>
        <label>
        <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
        <textarea rows="3" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
        </label>
        <?php
    }
}

class Ebor_Customizer_Number_Control extends WP_Customize_Control {

	public $type = 'number';
	
	public function render_content() {
	?>
		<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<input type="number" <?php $this->link(); ?> value="<?php echo intval( $this->value() ); ?>" />
		</label>
	<?php
	}
	
}

class Demo_Import_control extends WP_Customize_Control {

	public $type = 'number';
	
	public function render_content() {
	?>
		<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<style>
				.btn {
					color: #fff !important;
					background: #3f8dbf;
					margin-bottom: 10px;
					margin-right: 5px;
					padding: 11px 20px 10px 20px;
					font-weight: 800;
					font-size: 13px;
					text-shadow: none;
					border: none;
					text-transform: uppercase;
					-webkit-transition: all 200ms ease-in;
					-o-transition: all 200ms ease-in;
					-moz-transition: all 200ms ease-in;
					-webkit-border-radius: 3px;
					border-radius: 3px;
					-webkit-box-shadow: none;
					-moz-box-shadow: none;
					box-shadow: none;
					display: inline-block;
					letter-spacing: 1px;
				}
				.btn.disabled {
				  cursor: not-allowed;
				  pointer-events: none;
				  opacity: 0.65;
				  filter: alpha(opacity=65);
				  -webkit-box-shadow: none;
				  box-shadow: none;
				}
			</style>
			<script type="text/javascript">
				jQuery(document).ready(function($){
					$('#demo-import').click(function(){
						
						activate = confirm('Have you installed all required plugins? Before installing demo data be sure to do a full backup incase anything goes wrong, or data is overwritten. Proceed if you have done this.')
						if(activate == false) return false;
						
						$.ajax({
							type: "POST",
							url: ajaxurl,
							data: {
								action: 'ebor_ajax_import_data'
							},
							beforeSend: function() {
								//show loader
								$('.btn').addClass('disabled').text('Loading, Please Wait.');
							},
							error: function() {
								//script error occured
								$('body').alert( 'Importing didnt work! <br/> You might want to try reloading the page and then try again' );
								$('.btn').removeClass('disabled');
								
							},
							success: function(response) {
								if(response.match('ebor_import')) {
									alert('Demo Data Imported. Have Fun and read the documentation.');
								}
								else {
									alert('Demo Data Not Imported! ' + response);
								}
							},
							complete: function(response) {	
								$('.btn').text('All Data Imported, Have Fun!');
							}
						});
								
						return false;
					});
				});
			</script>
			<p>This will import all demo data. If this is not a fresh WordPress install (existing content) please make site & database backups before importing demo content.</p>
			<p><strong>The import process will take up to 15 minutes depening on your server, start it & go grab a cup of tea!<br />Do not leave this page until you have confirmation of the import.</strong></p>
			<a href="#" id="demo-import" class="btn">Import Demo Data</a>
		</label>
	<?php
	}
	
}

/**
 * Extends the WordPress background image customize control class, which allows a theme to register
 * multiple default backgrounds for the user to choose from.  To use this, the theme author 
 * should remove the 'background_image' control and add this control in its place.
 *
 * @since     0.1.0
 * @author    Justin Tadlock <justin@justintadlock.com>
 * @copyright Copyright (c) 2013, Justin Tadlock
 * @link      http://justintadlock.com/archives/2013/10/13/registering-multiple-default-backgrounds
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

class JT_Customize_Control_Background_Image extends WP_Customize_Background_Image_Control {

	/**
	 * Array of default backgrounds.
	 *
	 * @since  0.1.0
	 * @access public
	 * @var    array
	 */
	public $jt_default_backgrounds = array();

	/**
	 * Set up our control.
	 *
	 * @since  0.1.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	 */
	public function __construct( $manager ) {

		/* Let WP handle this. */
		parent::__construct( $manager );

		/* Allow themes to register custom backgrounds. */
		$this->jt_default_backgrounds = apply_filters( 'jt_default_backgrounds', $this->jt_default_backgrounds );

		/* WordPress will only output the 'default' tab if there's a default image. Make sure it gets added. */
		if ( !$this->setting->default && !empty( $this->jt_default_backgrounds ) )
			$this->add_tab( 'default', __( 'Default', 'jt' ), array( $this, 'tab_default_background' ) );
	}

	/**
	 * Displays the 'default' tab for selecting a background image.  This method plays nicely with the 
	 * 'default-image' argument for 'custom-background' as well as our custom backgrounds.
	 *
	 * @since  0.1.0
	 * @access public
	 * @return void
	 */
	public function tab_default_background() {

		/* If the theme added a 'default-image', make sure to output it. */
		if ( $this->setting->default )
			$this->print_tab_image( $this->setting->default );

		/* Check if the theme added an array of default backgrounds. */
		if ( !empty( $this->jt_default_backgrounds ) ) {

			/* Get the template and stylesheet directory URIs. */
			$template   = get_template_directory_uri();
			$stylesheet = get_stylesheet_directory_uri();

			/* Loop through the backgrounds and print them. */
			foreach ( $this->jt_default_backgrounds as $background ) {

				/* If no thumbnail was given, use the original. */
				if ( !isset( $background['thumbnail_url'] ) )
					$background['thumbnail_url'] = $background['url'];

				/* Use '%s' for parent themes and '%2$s' for child themes. */
				$url       = sprintf( $background['url'],           $template, $stylesheet );
				$thumb_url = sprintf( $background['thumbnail_url'], $template, $stylesheet );

				/* Print the image. */
				$this->print_tab_image( $url, $thumb_url );
			}
		}
	}
}