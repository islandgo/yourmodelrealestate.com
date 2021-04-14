
<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Name</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<input type="text" name="aiis_ci[partner-name]" id="aiis_ci[partner-name]"
			value="<?php echo isset($options['partner-name']) ? $options['partner-name'] : ''; ?>"
			placeholder="Agent Image">
		</div>
	</div>
</div>
<!-- END: Row Box -->
<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">DRE License</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<input type="text" name="aiis_ci[partner-license]" id="aiis_ci[partner-license]"
			value="<?php echo isset($options['partner-license']) ? $options['partner-license'] : ''; ?>"
			placeholder="Agent Image">
		</div>
	</div>
</div>
<!-- END: Row Box -->
<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Address</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<input type="text" name="aiis_ci[partner-address]" id="aiis_ci[partner-address]"
			value="<?php echo isset($options['partner-address']) ? $options['partner-address'] : ''; ?>"
			placeholder="1700 E. Walnut Avenue, Suite 400, El Segundo, CA 90245">
		</div>
	</div>
</div>
<!-- END: Row Box -->
<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Email Address</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<input type="text" name="aiis_ci[partner-email]" id="aiis_ci[partner-email]"
			value="<?php echo isset($options['partner-email']) ? $options['partner-email'] : ''; ?>"
			placeholder="info@agentimage.com">
		</div>
	</div>
</div>
<!-- END: Row Box -->
<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Phone Number</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group form-phone">
			<div class="wpui-flex">
				<div class="wpui-col-md">
					<?=constant_select_element('aiis_ci[partner-country-code-phone]', 'partner-country-code-phone', $options['partner-country-code-phone'] ?? '')?>
				</div>
				<div class="wpui-col-md flex-grow">
					<div class="form-checkbox-group">
						<div class="form-checkbox">
							<label>
								<input type="checkbox" name="aiis_ci[partner-country-code-phone-show]" id="aiis_ci[partner-country-code-phone-show]" class="wpuikit-country-code-show" value="yes" <?=checked($options['partner-country-code-phone-show'] ?? '', 'yes', false)?>> Show Country Code
							</label>
						</div>
					</div>
				</div>
			</div>

			<input type="text" name="aiis_ci[partner-phone]" id="aiis_ci[partner-phone]" class="wpuikit-phone-number mt-3"
				value="<?php echo isset($options['partner-phone']) ? $options['partner-phone'] : '' ?>"
				placeholder="800.979.5799">
		</div>
	</div>
</div>
<!-- END: Row Box -->
<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Cell Number</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group form-phone">
			<div class="wpui-flex">
				<div class="wpui-col-md">
					<?=constant_select_element('aiis_ci[partner-country-code-cell]', 'partner-country-code-cell', $options['partner-country-code-cell']  ?? '')?>
				</div>
				<div class="wpui-col-md flex-grow">
					<div class="form-checkbox-group">
						<div class="form-checkbox">
							<label>
								<input type="checkbox" name="aiis_ci[partner-country-code-cell-show]" id="aiis_ci[partner-country-code-cell-show]" class="wpuikit-country-code-show" value="yes" <?=checked($options['partner-country-code-cell-show'] ?? '', 'yes', false)?>> Show Country Code
							</label>
						</div>
					</div>
				</div>
			</div>

			<input type="text" name="aiis_ci[partner-cell]" id="aiis_ci[partner-cell]" class="wpuikit-phone-number mt-3"
				value="<?php echo isset($options['partner-cell']) ? $options['partner-cell'] : '' ?>"
				placeholder="800.979.5799">
		</div>
	</div>
</div>
<!-- END: Row Box -->
<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Fax Number</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group form-phone">
			<div class="wpui-flex">
				<div class="wpui-col-md">
					<?=constant_select_element('aiis_ci[partner-country-code-fax]', 'partner-country-code-fax', $options['partner-country-code-fax']  ?? '')?>
				</div>
				<div class="wpui-col-md flex-grow">
					<div class="form-checkbox-group">
						<div class="form-checkbox">
							<label>
								<input type="checkbox" name="aiis_ci[partner-country-code-fax-show]" id="aiis_ci[partner-country-code-fax-show]" class="wpuikit-country-code-show" value="yes" <?=checked($options['partner-country-code-fax-show'] ?? '', 'yes', false)?>> Show Country Code
							</label>
						</div>
					</div>
				</div>
			</div>

			<input type="text" name="aiis_ci[partner-fax]" id="aiis_ci[partner-fax]" class="wpuikit-phone-number mt-3"
				value="<?php echo isset($options['partner-fax']) ? $options['partner-fax'] : '' ?>"
				placeholder="800.979.5799">
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
