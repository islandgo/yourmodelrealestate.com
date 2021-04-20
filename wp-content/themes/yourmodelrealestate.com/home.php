<?php get_header(); ?>

<!-- your home html -->

<!-- Banner -->
<section class="hp-slideshow">
	<h2 class="hidden">hidden h2</h2>
	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Hp Slideshow") ) : ?><?php endif ?>
</section>
<!-- Banner End -->


<!-- Quick Search -->
<section class="hp-quick-search">
	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Hp Quick Search") ) : ?><?php endif ?>
</section>
<!-- Quick Search End -->


<!-- About -->
<section class="hp-about">
	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Hp About") ) : ?><?php endif ?>
</section>
<!-- About End -->


<!-- Featured Properties -->
<section class="hp-featured-properties" data-aos="fade-up" data-aos-delay="200" data-aos-duration="1000" data-aos-once="true" data-aos-id="trigger-counter">
	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Hp Featured Properties") ) : ?><?php endif ?>
</section>
<!-- Featured Properties End -->


<!-- Featured Areas -->
<section class="hp-featured-areas" data-aos="fade-down" data-aos-delay="200" data-aos-duration="1000" data-aos-once="true" data-aos-id="trigger-counter">
	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Hp Featured Areas") ) : ?><?php endif ?>
</section>
<!-- Featured Areas End -->


<!-- CTA -->
<section class="hp-cta">
	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Hp Cta") ) : ?><?php endif ?>
</section>
<!-- CTA End -->


<!-- Testimonials -->
<section class="hp-testimonials">
	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Hp Testimonials") ) : ?><?php endif ?>
</section>
<!-- Testimonials End -->


<!-- Featured Videos -->
<section class="hp-featured-videos" data-aos="fade-right" data-aos-delay="200" data-aos-duration="1000" data-aos-once="true" data-aos-id="trigger-counter">
	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Hp Featured Videos") ) : ?><?php endif ?>
</section>
<!-- Featured Videos End -->


<!-- Hp Footer -->
<section class="hp-footer">
	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Hp Footer") ) : ?><?php endif ?>
</section>
<!--Hp Footer end -->


<!-- your home html -->

<?php get_footer(); ?>