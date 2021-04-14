<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p class="mt-0"><span class="wpui-settings-title">Enqueue Libraries</span> Libraries will be enqueue on Front End</p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<div class="form-checkbox-group">

        <div class="form-toggle-switch">
          <div class="form-checkbox">
            <label>
              <input type="checkbox" name="aios-enqueue-cdn[bootstrap_no_components_css]" id="bootstrap_no_components_css" value="1" <?= $libraries['bootstrap_no_components_css'] ?? '' === 1 ? 'checked=checked' : '' ?>>
              <strong>CSS Bootstrap without Components</strong>
              <span class="form-group-description"><em>(handler: </em>aios-starter-theme-bootstrap<em>)</em> - This will have only common css such as Grid system Tables, Forms, Buttons, Responsive utilities</span>
            </label>
          </div>
        </div>

        <div class="form-toggle-switch">
          <div class="form-checkbox">
            <label>
              <input type="checkbox" name="aios-enqueue-cdn[utilities]" id="utilities" value="1" <?= $libraries['utilities'] ?? '' === 1 ? 'checked=checked' : '' ?>>
              Utilities
              <span class="form-group-description"><strong>CSS</strong> <em>(handler: </em>aios-utilities-style<em>)</em> - <a href="https://im-demo.agentimage.com/aios-utilities/" target="_blank">Demo</a></span>
            </label>
          </div>
        </div>

        <div class="form-toggle-switch">
          <div class="form-checkbox">
            <label>
              <input type="checkbox" name="aios-enqueue-cdn[autosize]" id="autosize" value="1" <?= $libraries['autosize'] ?? '' === 1 ? 'checked=checked' : '' ?>>
              Autosize
              <span class="form-group-description"><strong>JavaScript</strong> <em>(handler: </em>aios-autosize-script<em>)</em></span>
            </label>
          </div>
        </div>

        <div class="form-toggle-switch">
          <div class="form-checkbox">
            <label>
              <input type="checkbox" name="aios-enqueue-cdn[chainHight]" id="chainHight" value="1" <?= $libraries['chainHight'] ?? '' === 1 ? 'checked=checked' : '' ?>>
              Chain Height
              <span class="form-group-description"><strong>JavaScript</strong> <em>(handler: </em>aios-chain-height-script<em>)</em></span>
            </label>
          </div>
        </div>

        <div class="form-toggle-switch">
          <div class="form-checkbox">
            <label>
              <input type="checkbox" name="aios-enqueue-cdn[splitNav]" id="splitNav" value="1" <?= $libraries['splitNav'] ?? '' === 1 ? 'checked=checked' : '' ?>>
              Split Nav
              <span class="form-group-description"><strong>JavaScript</strong> <em>(handler: </em>aios-splitNav-script<em>)</em></span>
            </label>
          </div>
        </div>

        <div class="form-toggle-switch">
          <div class="form-checkbox">
            <label>
              <input type="checkbox" name="aios-enqueue-cdn[slick]" id="slick" value="1" <?= $libraries['slick'] ?? '' === 1 ? 'checked=checked' : '' ?>>
              Slick v1.9.0
              <span class="form-group-description"><strong>CSS & JavaScript</strong> <em>(handler: </em>aios-slick-style AND aios-slick-script<em>)</em> - <a href="http://kenwheeler.github.io/slick/" target="_blank">Demo</a></span>
            </label>
          </div>
        </div>

        <div class="form-toggle-switch">
          <div class="form-checkbox">
            <label>
              <input type="checkbox" name="aios-enqueue-cdn[swiper]" id="swiper" value="1" <?= $libraries['swiper'] ?? '' === 1 ? 'checked=checked' : '' ?>>
              Swiper 4.5.0
              <span class="form-group-description"><strong>CSS & JavaScript</strong> <em>(handler: </em>aios-swiper-style AND aios-swiper-script<em>)</em> - <a href="https://idangero.us/swiper/demos/" target="_blank">Demo</a></span>
            </label>
          </div>
        </div>

        <div class="form-toggle-switch">
          <div class="form-checkbox">
            <label>
              <input type="checkbox" name="aios-enqueue-cdn[simplebar]" id="simplebar" value="1" <?= $libraries['simplebar'] ?? '' === 1 ? 'checked=checked' : '' ?>>
              Simplebar v2.6.1
              <span class="form-group-description"><strong>CSS & JavaScript</strong> <em>(handler: </em>aios-simplebar-style AND aios-simplebar-script<em>)</em> - <a href="https://grsmto.github.io/simplebar/" target="_blank">Demo</a></span>
            </label>
          </div>
        </div>

        <div class="form-toggle-switch">
          <div class="form-checkbox">
            <label>
              <input type="checkbox" name="aios-enqueue-cdn[videoPlyr]" id="videoPlyr" value="1" <?= $libraries['videoPlyr'] ?? '' === 1 ? 'checked=checked' : '' ?>>
              Video Player
              <span class="form-group-description"><strong>JavaScript</strong> <em>(handler: </em>aios-videoPlyr-script<em>)</em></span>
            </label>
          </div>
        </div>

        <div class="form-toggle-switch">
          <div class="form-checkbox">
            <label>
              <input type="checkbox" name="aios-enqueue-cdn[sidebar_navigation]" id="sidebar_navigation" value="1" <?= $libraries['sidebar_navigation'] ?? '' === 1 ? 'checked=checked' : '' ?>>
              Sidebar Navigation v1.0.1
              <span class="form-group-description"><strong>JavaScript</strong> <em>(handler: </em>aios-sidebar-navigation-script<em>)</em></span>
            </label>
          </div>
        </div>

        <div class="form-toggle-switch">
          <div class="form-checkbox">
            <label>
              <input type="checkbox" name="aios-enqueue-cdn[aos]" id="aos" value="1" <?= $libraries['aos'] ?? '' === 1 ? 'checked=checked' : '' ?>>
              Animate On Scroll Library
              <span class="form-group-description"><strong>CSS & JavaScript</strong> <em>(handler: </em>aios-aos-style AND aios-aos-script<em>)</em> - <a href="https://michalsnik.github.io/aos/" target="_blank">Demo</a></span>
            </label>
          </div>
        </div>

        <hr class="mt-3">
        <p class="float-left w-100 mt-3 mb-3"><strong>Elementpeek is deprecated. Use the AOS plugin instead. </strong></p>

        <div class="form-toggle-switch">
          <div class="form-checkbox">
            <label>
              <input type="checkbox" name="aios-enqueue-cdn[animate]" id="animate" value="1" <?= $libraries['animate'] ?? '' === 1 ? 'checked=checked' : '' ?>>
              Animate(Deprecated)
              <span class="form-group-description"><strong>CSS</strong> <em>(handler: </em>aios-animate-style<em>)</em> - <a href="https://daneden.github.io/animate.css/" target="_blank">Demo</a></span>
            </label>
          </div>
        </div>

        <div class="form-toggle-switch">
          <div class="form-checkbox">
            <label>
              <input type="checkbox" name="aios-enqueue-cdn[elementpeek]" id="elementpeek" value="1" <?= $libraries['elementpeek'] ?? '' === 1 ? 'checked=checked' : '' ?> data-require="animate">
              ElementPeek
              <span class="form-group-description"><strong>JavaScript</strong> <em>(handler: </em>aios-elementpeek-script<em>)</em> - <a href="https://im-demo.agentimage.com/element-peek/" target="_blank">Demo</a></span>
            </label>
          </div>
        </div>

			</div>
		</div>
	</div>
</div>
<!-- END: Row Box -->
<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p class="mt-2"><span class="wpui-settings-title">Minified Resources</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<div class="form-checkbox-group">
        <div class="form-toggle-switch">
          <div class="form-checkbox">
            <label>
              <input type="checkbox" name="aios-enqueue-cdn[aios_minified_resources]" value="1" <?= $libraries['aios_minified_resources'] ?? '' === 1 ? 'checked=checked' : '' ?>>
              Enable Resources Minifier
            </label>
            <p>This will minify only files from resources cdn.</p>
          </div>
        </div>
			</div>
		</div>
		<?php
			echo AIOS_CREATE_FIELDS::select( [
				'row' => false,
				'name' => 'aios-enqueue-cdn[expiration]',
				'label' => true,
				'label_value' => 'Expiration',
				'options' => [
          '999' => 'No Expiration',
          WEEK_IN_SECONDS => '1 week',
          2 * WEEK_IN_SECONDS => '2 weeks',
          3 * WEEK_IN_SECONDS => '3 weeks',
          MONTH_IN_SECONDS => '1 months'
        ],
				'value' => $libraries['expiration'] ?? ''
			] );
		?>
		<input id="refresh-minified-resources" type="submit" class="wpui-default-button text-uppercase wpui-min-width-initial mt-3" value="Refresh Minified Resources">
	</div>
</div>
<!-- END: Row Box -->

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-submit">
	<div class="wpui-col-md-12">
		<div class="form-group">
			<input type="submit" class="save-option-ajax wpui-secondary-button text-uppercase" value="Save Changes">
		</div>
	</div>
</div>
<!-- END: Row Box -->
