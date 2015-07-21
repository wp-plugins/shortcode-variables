<?php

defined('ABSPATH') or die('Jog on!');


function sh_cd_admin_menu() {
	add_options_page( SH_CD_PLUGIN_NAME . ' Options', SH_CD_PLUGIN_NAME, 'manage_options', 'sh-cd-admin-page', 'sh_cd_admin_page' );
}

function sh_cd_admin_page() {
	
	wp_enqueue_style('sh-cd-style', plugins_url( 'css/sh-cd.css', __FILE__ ));

	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	echo '<h1>' . SH_CD_PLUGIN_NAME . '</h1>';


	$this_page = get_permalink();

	$action = (isset($_GET['action']) ? $_GET['action'] : 'view-all');


	if ($action == 'save')
	{
		$slug = (isset($_POST['slug']) ? $_POST['slug'] : '');
		$value = (isset($_POST['value']) ? $_POST['value'] : '');
		$id = ((isset($_POST['existing-id']) && is_numeric($_POST['existing-id'])) ? $_POST['existing-id'] : false);

		if(sh_cd_save_shortcode($slug, $value, $id))
		{
			sh_cd_display_message('Shortcode has been saved'); 
		}
		else
		{
			sh_cd_display_message('There was an error saving your shortcode', true);
	 	}
	}
	elseif($action == 'delete')
	{
		if(sh_cd_delete_shortcode($_GET['id']))
		{
			sh_cd_display_message('Shortcode has been deleted!'); 
		}
		else
		{
			sh_cd_display_message('There was an error deleting your shortcode', true);
	 	}	
	}	

	?>

	<div class="wrap">

	<div id="icon-options-general" class="icon32"></div>
	
	<div id="poststuff">

		<div id="post-body" class="metabox-holder columns-3">

			<!-- main content -->
			<div id="post-body-content">

				<div class="meta-box-sortables ui-sortable">
					
					<?php 

					if ($action == 'add' || $action == 'edit')
					{
					

						$title = 'Add Shortcode';
						$slug = '';
						$value = '';
						$button_text = 'Add';
						$existing_id = false;

						if ($action == 'edit')
						{
							$title = 'Edit Shortcode';
							$button_text = 'Save';
							$existing_id = $_GET['id'];

							// Get Shortcode from DB
							$shortcode = sh_cd_get_shortcode($existing_id);
							$slug = $shortcode->slug;
							$value = stripslashes($shortcode->data);
						}

						$settings = array( 'textarea_name' => 'value' );
						

						?>
						<a class="button-secondary" href="<?php echo admin_url('options-general.php?page=sh-cd-admin-page'); ?>"><?php esc_attr_e( 'Cancel' ); ?></a>
						<br /><br />
						<div class="postbox">
							<h3 class="hndle"><span><?php echo _e($title); ?> </span></h3>
							<div style="padding: 0px 15px 0px 15px">
								
								<form method="post" action="<?php echo admin_url('options-general.php?page=sh-cd-admin-page&action=save'); ?>">
									<input type="hidden" id="existing-id" name="existing-id" value="<?php echo ((!empty($existing_id)) ? $existing_id : ''); ?>" />
									<p>Slug:</p>
									<input type="text" class="regular-text" size="100" id="slug" name="slug" <?php echo (('edit' == $action) ? ' disabled' : ''); ?> placeholder="<?php echo __('Slug'); ?>" <?php echo ((!empty($slug)) ? "value=\"$slug\"" : ""); ?>/>
									<?php if ('edit' == $action): ?>
										<p><small><?php echo __('Note: You can not edit a slug name. Editing a slug name may cause issues throughout your site. Please delete this shortcode and create another.'); ?></small></p>
									<?php endif; ?>
									<p>Shortcode data / Value:</p>
									<!--<textarea id="value" name="value" cols="80" rows="10" class="large-text"><?php echo $value; ?></textarea><br>-->
									<?php wp_editor( $value, 'value', $settings ); ?>
									
									<?php echo submit_button( $button_text . __(' Shortcode') ); ?>
									
								</form>
							</div>
						</div>

					<?php
					}
					else
					{?>
						<a class="button-primary" href="<?php echo admin_url('options-general.php?page=sh-cd-admin-page&action=add'); ?>"><?php esc_attr_e( 'Add a new Shortcode' ); ?></a>
						<br /><br />
					
						
								<div class="postbox">
									<h3 class="hndle"><span><?php _e( 'Existing Shortcodes' ); ?> </span></h3>
									<div style="padding: 0px 15px 0px 15px">
										<br />
										<table class="widefat" width="100%">
											<tr class="row-title">
												<th class="row-title" width="15%"><?php echo __('Slug'); ?></th>
												<th width="20%"><?php echo __('Shortcode to embed'); ?></th>
												<th width="*"><?php echo __('Shortcode Value'); ?></th>
												<th width="15%"><?php echo __('Options'); ?></th>
											</tr>
											<?php

											$current_shortcodes = sh_cd_get_all_shortcodes();

											if ($current_shortcodes)
											{
												
												$class = '';
											
												foreach ($current_shortcodes as $shortcode): 

													$class = ($class == 'alternate') ? '' : 'alternate';

													$edit_link = admin_url('options-general.php?page=sh-cd-admin-page&action=edit&id=' . $shortcode->id);
													$delete_link = admin_url('options-general.php?page=sh-cd-admin-page&action=delete&id=' . $shortcode->id);
											?>
												<tr class="<?php echo $class; ?>">
													<td><a href="<?php echo $edit_link; ?>"><?php echo $shortcode->slug; ?></a></td>
													<td>[<?php echo SH_CD_SHORTCODE; ?> slug="<?php echo $shortcode->slug; ?>"]</td>
													<td><textarea class="large-text"><?php echo esc_html(stripslashes($shortcode->data)); ?></textarea></td>
													<td>
														<a class="button button-small" href="<?php echo $edit_link; ?>"><?php echo __('Edit'); ?></a>
														<a class="button button-small" href="<?php echo $delete_link; ?>" class="remove-confirm" ><?php echo __('Delete'); ?></a>
													</td>
												</tr>
											<?php endforeach; 

											}
											else
											{?>
												<tr>
													<td colspan="4" align="center"><?php echo __('You haven\'t created any shortcodes yet. <a href="' . admin_url('options-general.php?page=sh-cd-admin-page&action=add') . '">Add one now!</a>'); ?></td>
												</tr>	
											<?php
											}
											?>
										</table>
										<br />
									</div>
								</div>
						<?php
							
															
						
					}
?>
					

				</div>
				<!-- .meta-box-sortables .ui-sortable -->

			</div>
			<!-- post-body-content -->

		</div>
		<!-- #post-body .metabox-holder .columns-2 -->

		<br class="clear">
	</div>
	<!-- #poststuff -->

</div> <?php

	sh_cd_create_dialog_jquery_code(__('Are you sure?'), __('Are you sure you wish to delete this shortcode?'), 'remove-confirm');

}