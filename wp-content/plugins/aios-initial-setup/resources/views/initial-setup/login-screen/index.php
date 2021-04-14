<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p class="mt-0"><span class="wpui-settings-title">Select Theme</span> Change current login theme base on product type.</p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<div class="form-radio-group form-toggle-switch">
				<?php
					foreach ($productTypes as $product_type) {
						echo '<div class="form-radio">
							<label><input type="radio" name="aios_custom_login_screen" value="' . $product_type['id'] . '" ' . checked($loginScreen ?? '', $product_type['id'], false) . '> ' . $product_type['name'] . '</label>
						</div>';
					}
				?>
			</div>
		</div>
		<div class="setting-content setting-container setting-container-logo setting-container-parent" <?=($loginScreen != 'true-custom' ? 'style="display: none;"' : '');?>>
			<p><strong>Recommend Size: Max Width</strong> 380 x Max Height 82</p>
			<div class="setting-logo-preview setting-image-preview">
				<?= (! empty($loginScreenLogo)) ? '<img src="' . $loginScreenLogo . '">' : '<p>No image uploaded</p>' ?>
			</div>
			<input type="text" class="setting-image-input" name="aios_custom_login_screen_logo" id="aios_custom_login_screen_logo" value="<?=$loginScreenLogo?>" style="display: none;">
			<div class="setting-button">
				<input type="button" class="setting-upload wpui-secondary-button" value="Upload">
				<input type="button" class="setting-remove wpui-default-button" value="Remove">
			</div>
		</div>
	</div>
</div>
<!-- END: Row Box -->

<div class="wpui-row wpui-row-submit">
	<div class="wpui-col-md-12">
		<div class="form-group">
			<input type="submit" class="save-option-ajax wpui-secondary-button text-uppercase" value="Save Changes">
		</div>
	</div>
</div>
