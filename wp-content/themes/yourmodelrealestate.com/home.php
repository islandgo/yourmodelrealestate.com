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
	<div class="comp-quick-search-container container">
		<div class="quick-search-item site-title-primary">
			<span class="section-number">01</span>
			<div class="section-name">
				<h4>quick</h4>
				<h2>search</h2>
			</div>
		</div>
		<form class="quick-search-item comp-search-container" data-aos="fade-down" data-aos-delay="200" data-aos-duration="1000" data-aos-once="true" data-aos-id="trigger-counter">
			<div class="form-item zip-item">
				<select aria-label="zip code" class="site-select-primary">
					<option value="volvo">City or Zip Code</option>
					<option value="saab">Saab</option>
					<option value="mercedes">Mercedes</option>
					<option value="audi">Audi</option>
				</select>
			</div>
			<div class="form-item property-item">
				<select aria-label="property type" class="site-select-primary">
					<option value="volvo">Property Type</option>
					<option value="saab">Saab</option>
					<option value="mercedes">Mercedes</option>
					<option value="audi">Audi</option>
				</select>
			</div>
			<div class="form-item bed-item">
				<select aria-label="beds" class="site-select-primary">
					<option value="volvo">Bedrooms</option>
					<option value="saab">Saab</option>
					<option value="mercedes">Mercedes</option>
					<option value="audi">Audi</option>
				</select>
			</div>
			<div class="form-item bath-item">
				<select aria-label="baths" class="site-select-primary">
					<option value="volvo">Bathrooms</option>
					<option value="saab">Saab</option>
					<option value="mercedes">Mercedes</option>
					<option value="audi">Audi</option>
				</select>
			</div>
			<div class="form-item min-item">
				<input type="text" class="site-input-primary" aria-label="min $" placeholder="Min $">
			</div>
			<div class="form-item max-item">
				<input type="text" class="site-input-primary" aria-label="max $" placeholder="Max $">
			</div>
			<div class="form-item search-item">
				<a href="[blogurl]" class="search-btn-primary" aria-label="qs">search</a>
				
			</div>
			<div class="form-item advance-item">
				<input class="serch-btn-secondary" type="submit" value="advance" />
			</div>
		</form>
	</div>
</section>
<!-- Quick Search End -->

<!-- About -->
<section class="hp-about">
	<div class="comp-about-container container">
		<div class="about-img">
			<img alt="atela" class="img-atela" src="http://localhost/isd-projects/yourmodelrealestate.com/wp-content/themes/yourmodelrealestate.com/images/about-img.jpg">
		</div>
		<div class="about-item">
			<div class="site-title-primary about-title">
				<span class="section-number">02</span>
				<div class="section-name">
					<h4>about</h4>
					<h2>aleta c. saunders</h2>
				</div>
			</div>
			<div class="about-paragraph">				
				<p class="item-middle">Aleta C. Saunders bring both profession and sincerity to residential real estate. Passionate about her
					work. she makes sure her clients receive her full efforts throughout the entire precess. With
					un-paralleled determination, she works hard to secure a profitable and positive experience for those who
					trust her with thei real estate needs. You can be sure that when you choose to work with Aleta.</p>
				<p class="item-bottom">Being an equestrian herself, Aleta knows the needs of a horse owner, allowing her to locate the perfect
					property for each equestrian.</p>
				</div>
				<a class="site-btn-primary" href="[blogurl]" aria-label="btn">Read more +</a>
		</div>
	</div>
</section>
<!-- About End -->

<!-- Featured Properties -->
<section class="hp-featured-properties">
	<div class="comp-featured-properties-container ">
		<div class="properties-item property-content">
			<div class="site-title-primary">
				<span class="section-number">03</span>
				<div class="section-name">
					<h4>Featured</h4>
					<h2>Properties</h2>
				</div>
			</div>
			<p>It is with pleasure that Aleta welcome you to Atlanta, and to her website. with years of experience in
				the market.</p>
			<div class="slick-action">
				<button class="slick-prev">
					<span class="ai-font-arrow-b-p  slick-arrow"></span>
				</button>
				<button class="slick-next">
					<span class="ai-font-arrow-b-n  slick-arrow"></span>
				</button>
			</div>
			<a  class="site-btn-primary" href="[blogurl]" aria-label="btn">View all properties +</a>
		</div>

		<div class="featured-property-slick">

			<div class="slick-item">
				<img alt="properties" class="img-properties" src="http://localhost/isd-projects/yourmodelrealestate.com/wp-content/themes/yourmodelrealestate.com/images/fp-img1.jpg">
				<div class="content">
					<div class="content-bg">
						<h3>$3,520,000</h3>
						<p>1700 east walnut avenue, suite 400, atlanta, 90245</p>
						<a href="#" class="view-detail-link">view details +</a>
					</div>
				</div>
			</div>
			<div class="slick-item">
				<img alt="properties" class="img-properties" src="http://localhost/isd-projects/yourmodelrealestate.com/wp-content/themes/yourmodelrealestate.com/images/fp-img2.jpg">
				<div class="content">
					<div class="content-bg">
						<h3>$5,295,000</h3>
						<p>1700 east walnut avenue, suite 400, atlanta, 90245</p>
						<a href="#" class="view-detail-link">view details +</a>
					</div>
				</div>
			</div>
			<div class="slick-item">
				<img alt="properties" class="img-properties" src="http://localhost/isd-projects/yourmodelrealestate.com/wp-content/themes/yourmodelrealestate.com/images/fp-img3.jpg">
				<div class="content">
					<div class="content-bg">
						<h3>$7,920,000</h3>
						<p>1700 east walnut avenue, suite 400, atlanta, 90245</p>
						<a href="#" class="view-detail-link">view details +</a>
					</div>
				</div>
			</div>
			<div class="slick-item">
				<img alt="properties" class="img-properties" src="http://localhost/isd-projects/yourmodelrealestate.com/wp-content/themes/yourmodelrealestate.com/images/fp-img1.jpg">
				<div class="content">
					<div class="content-bg">
						<h3>$3,520,000</h3>
						<p>1700 east walnut avenue, suite 400, atlanta, 90245</p>
						<a href="#" class="view-detail-link">view details +</a>
					</div>
				</div>
			</div>
			<div class="slick-item">
				<img alt="properties" class="img-properties" src="http://localhost/isd-projects/yourmodelrealestate.com/wp-content/themes/yourmodelrealestate.com/images/fp-img2.jpg">
				<div class="content">
					<div class="content-bg">
						<h3>$5,295,000</h3>
						<p>1700 east walnut avenue, suite 400, atlanta, 90245</p>
						<a href="#" class="view-detail-link">view details +</a>
					</div>
				</div>
			</div>
			<div class="slick-item">
				<img alt="properties" class="img-properties" src="http://localhost/isd-projects/yourmodelrealestate.com/wp-content/themes/yourmodelrealestate.com/images/fp-img3.jpg">
				<div class="content">
					<div class="content-bg">
						<h3>$7,920,000</h3>
						<p>1700 east walnut avenue, suite 400, atlanta, 90245</p>
						<a href="#" class="view-detail-link">view details +</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Featured Properties End -->

<!-- Featured Areas -->
<section class="hp-featured-areas">
	<div class="comp-featured-areas-container ">
		<div class="featured-areas-item areas">
			<div class="site-title-primary">
				<span class="section-number">04</span>
				<div class="section-name">
					<h4>Featured</h4>
					<h2>Areas</h2>
				</div>
			</div>
			<p>Click on each area for listings, resouces, information, and more and get to know all the information you need.</p>
				<a class="site-btn-primary" href="[blogurl]" aria-label="btn">View all Communities +</a>
		</div>
		<a href="" class="featured-areas-item atlanta">
			<div class="content">
				<h3>atlanta</h3>
				<button href="#" class="site-btn-secondary">view details +</button>
			</div>
			<img alt="atlanta" class="img-atlanta" src="http://localhost/isd-projects/yourmodelrealestate.com/wp-content/themes/yourmodelrealestate.com/images/fa-img1.jpg">
		</a>
		<a href="" class="featured-areas-item fulton">
			<div class="content">
				<h3>fulton</h3>
				<button href="#" class="site-btn-secondary">view details +</button>
			</div>
			<img alt="fulton" class="img-fulton" src="http://localhost/isd-projects/yourmodelrealestate.com/wp-content/themes/yourmodelrealestate.com/images/fa-img2.jpg">
		</a>
		<a href="" class="featured-areas-item cobb">
			<div class="content">
				<h3>cobb</h3>
				<button href="#" class="site-btn-secondary">view details +</button>
			</div>
			<img alt="cobb" class="img-cobb" src="http://localhost/isd-projects/yourmodelrealestate.com/wp-content/themes/yourmodelrealestate.com/images/fa-img3.jpg">
		</a>
		<a href="" class="featured-areas-item dekalb">
			<div class="content">
				<h3>dekalb</h3>
				<button href="#" class="site-btn-secondary">view details +</button>
			</div>
			<img alt="dekalb" class="img-dekalb" src="http://localhost/isd-projects/yourmodelrealestate.com/wp-content/themes/yourmodelrealestate.com/images/fa-img4.jpg">
		</a>
		<a href="" class="featured-areas-item gwinnett">
			<div class="content">
				<h3>gwinnett</h3>
				<button href="#" class="site-btn-secondary">view details +</button>
			</div>
			<img alt="gwinnett" class="img-gwinnett" src="http://localhost/isd-projects/yourmodelrealestate.com/wp-content/themes/yourmodelrealestate.com/images/fa-img5.jpg">
		</a>
		<a href="" class="featured-areas-item forsyth">
			<div class="content">
				<h3>forsyth</h3>
				<button href="#" class="site-btn-secondary">view details +</button>
			</div>
			<img alt="forsyth" class="img-forsyth" src="http://localhost/isd-projects/yourmodelrealestate.com/wp-content/themes/yourmodelrealestate.com/images/fa-img6.jpg">
		</a>
		<a href="" class="featured-areas-item fayette">
			<div class="content">
				<h3>fayette</h3>
				<button href="#" class="site-btn-secondary">view details +</button>
			</div>
			<img alt="fayette" class="img-fayette" src="http://localhost/isd-projects/yourmodelrealestate.com/wp-content/themes/yourmodelrealestate.com/images/fa-img7.jpg">
		</a>
		<a href="" class="featured-areas-item henry">
			<div class="content">
				<h3>henry</h3>
				<button href="#" class="site-btn-secondary">view details +</button>
			</div>
			<img alt="henry" class="img-henry" src="http://localhost/isd-projects/yourmodelrealestate.com/wp-content/themes/yourmodelrealestate.com/images/fa-img8.jpg">
		</a>
		<a href="" class="featured-areas-item rockdale">
			<div class="content">
				<h3>rockdale</h3>
				<button href="#" class="site-btn-secondary">view details +</button>
			</div>
			<img alt="rockdale" class="img-rockdale" src="http://localhost/isd-projects/yourmodelrealestate.com/wp-content/themes/yourmodelrealestate.com/images/fa-img9.jpg">
		</a>
		<a href="" class="featured-areas-item clayton">
			<div class="content">
				<h3>clayton</h3>
				<button href="#" class="site-btn-secondary">view details +</button>
			</div>
			<img alt="clayton" class="img-clayton" src="http://localhost/isd-projects/yourmodelrealestate.com/wp-content/themes/yourmodelrealestate.com/images/fa-img10.jpg">
		</a>
	</div>
</section>
<!-- Featured Areas End -->

<!-- CTA -->
<section class="hp-cta">
	<div class="comp-cta-container">
		<div class="cta-item">
			<a href="#" aria-label="cta">
				<div class="cta-img">
					<span class="img-bottom-border"></span>
					<img alt="buyers" class="img-buyers" src="http://localhost/isd-projects/yourmodelrealestate.com/wp-content/themes/yourmodelrealestate.com/images/cta1.jpg">
					<div class="cta-line"></div>
				</div>
				<h3>buyers</h3>
			</a>
		</div>
		<div class="cta-item">
			<a href="#" aria-label="cta">
				<div class="cta-img">
					<span class="img-bottom-border"></span>
					<img alt="search" class="img-search" src="http://localhost/isd-projects/yourmodelrealestate.com/wp-content/themes/yourmodelrealestate.com/images/cta2.jpg">
					<div class="cta-line"></div>
				</div>
				<h3>search</h3>
			</a>
		</div>
		<div class="cta-item">
			<a href="#" aria-label="cta">
				<div class="cta-img">
					<span class="img-bottom-border"></span>
					<img alt="sellers" class="img-sellers" src="http://localhost/isd-projects/yourmodelrealestate.com/wp-content/themes/yourmodelrealestate.com/images/cta3.jpg">
					<div class="cta-line"></div>
				</div>
				<h3>sellers</h3>
			</a>
		</div>
		<div class="cta-item">
			<a href="#" aria-label="cta">
				<div class="cta-img">
					<span class="img-bottom-border"></span>
					<img alt="home" class="img-home" src="http://localhost/isd-projects/yourmodelrealestate.com/wp-content/themes/yourmodelrealestate.com/images/cta4.jpg">
					<div class="cta-line"></div>
				</div>
				<h3>home valuation</h3>
			</a>
		</div>
	</div>
</section>
<!-- CTA End -->

<!-- Testimonials -->
<section class="hp-testimonials">
	<div class="comp-testimonials-container container">
		<div class="testimonials-item testimonial">
			<div class="site-title-primary">
				<span class="section-number">05</span>
				<div class="section-name">
					<h4>what our clients</h4>
					<h2>are saying</h2>
				</div>
			</div>
			<div class="testimonial-slick">
				<div class="testimonial-slick-item">
					<div class="quote-wrapper">
						<img alt="atlanta" class="img-atlanta"
							src="http://localhost/isd-projects/yourmodelrealestate.com/wp-content/themes/yourmodelrealestate.com/images/testimonials-quote.jpg">
					</div>
					<p>We can't thank Aleta enough for helping us find our dream home in Atlanta. its exactly what we
						dreamed it
						would be - and we didn't go over our budget! Aleta's local market knowledge, expertise, and amazing
						dedication made the whole buying process truly enjoyable. Thank you so much, Atela!</p>
					<h5>Bill M.</h5>
					<h6>publisher, The O Magazine</h6>
	
				</div>
				<div class="testimonial-slick-item">
					<div class="quote-wrapper">
						<img alt="atlanta" class="img-atlanta"
							src="http://localhost/isd-projects/yourmodelrealestate.com/wp-content/themes/yourmodelrealestate.com/images/testimonials-quote.jpg">
					</div>
					<p>We can't thank Aleta enough for helping us find our dream home in Atlanta. its exactly what we
						dreamed it
						would be - and we didn't go over our budget! Aleta's local market knowledge, expertise, and amazing
						dedication made the whole buying process truly enjoyable. Thank you so much, Atela!</p>
					<h5>Bill M.</h5>
					<h6>publisher, The O Magazine</h6>
				</div>
				<div class="testimonial-slick-item">
					<div class="quote-wrapper">
						<img alt="atlanta" class="img-atlanta"
							src="http://localhost/isd-projects/yourmodelrealestate.com/wp-content/themes/yourmodelrealestate.com/images/testimonials-quote.jpg">
					</div>
					<p>We can't thank Aleta enough for helping us find our dream home in Atlanta. its exactly what we
						dreamed it
						would be - and we didn't go over our budget! Aleta's local market knowledge, expertise, and amazing
						dedication made the whole buying process truly enjoyable. Thank you so much, Atela!</p>
					<h5>Bill M.</h5>
					<h6>publisher, The O Magazine</h6>
				</div>
				<div class="testimonial-slick-item">
					<div class="quote-wrapper">
						<img alt="atlanta" class="img-atlanta"
							src="http://localhost/isd-projects/yourmodelrealestate.com/wp-content/themes/yourmodelrealestate.com/images/testimonials-quote.jpg">
					</div>
					<p>We can't thank Aleta enough for helping us find our dream home in Atlanta. its exactly what we
						dreamed it
						would be - and we didn't go over our budget! Aleta's local market knowledge, expertise, and amazing
						dedication made the whole buying process truly enjoyable. Thank you so much, Atela!</p>
					<h5>Bill M.</h5>
					<h6>publisher, The O Magazine</h6>
				</div>
				<div class="testimonial-slick-item">
					<div class="quote-wrapper">
						<img alt="atlanta" class="img-atlanta"
							src="http://localhost/isd-projects/yourmodelrealestate.com/wp-content/themes/yourmodelrealestate.com/images/testimonials-quote.jpg">
					</div>
					<p>We can't thank Aleta enough for helping us find our dream home in Atlanta. its exactly what we
						dreamed it
						would be - and we didn't go over our budget! Aleta's local market knowledge, expertise, and amazing
						dedication made the whole buying process truly enjoyable. Thank you so much, Atela!</p>
					<h5>Bill M.</h5>
					<h6>publisher, The O Magazine</h6>
				</div>
				<div class="testimonial-slick-item">
					<div class="quote-wrapper">
						<img alt="atlanta" class="img-atlanta"
							src="http://localhost/isd-projects/yourmodelrealestate.com/wp-content/themes/yourmodelrealestate.com/images/testimonials-quote.jpg">
					</div>
					<p>We can't thank Aleta enough for helping us find our dream home in Atlanta. its exactly what we
						dreamed it
						would be - and we didn't go over our budget! Aleta's local market knowledge, expertise, and amazing
						dedication made the whole buying process truly enjoyable. Thank you so much, Atela!</p>
					<h5>Bill M.</h5>
					<h6>publisher, The O Magazine</h6>
				</div>
				<div class="testimonial-slick-item">
					<div class="quote-wrapper">
						<img alt="atlanta" class="img-atlanta"
							src="http://localhost/isd-projects/yourmodelrealestate.com/wp-content/themes/yourmodelrealestate.com/images/testimonials-quote.jpg">
					</div>
					<p>We can't thank Aleta enough for helping us find our dream home in Atlanta. its exactly what we
						dreamed it
						would be - and we didn't go over our budget! Aleta's local market knowledge, expertise, and amazing
						dedication made the whole buying process truly enjoyable. Thank you so much, Atela!</p>
					<h5>Bill M.</h5>
					<h6>publisher, The O Magazine</h6>
				</div>
			</div>
	
			<a class="site-btn-primary" href="[blogurl]" aria-label="btn">View all testimonials +</a>
		</div>
		<div class="testimonials-item contact-form">
			<div class="site-title-primary">
				<span class="section-number">06</span>
				<div class="section-name">
					<h4>get in touch</h4>
					<h2>contact us</h2>
				</div>
			</div>
			<p>Keep up to date on the latest market trends and opportunities in our site.</p>
			<div class="git-form">
				<div class="form-md pad-top">
					<label for="git-name"></label>
					<input type="text" id="name" placeholder="Name">
				</div>
	
				<div class="form-md pad-left">
					<label for="git-email"></label>
					<input type="text" id="git-email" placeholder="Email">
				</div>
	
				<div class="form-md pad-right">
					<label for="git-phone"></label>
					<input type="text" id="git-phone" placeholder="Phone">
				</div>
	
				<div class="form-lg">
					<label for="git-message"></label>
					<textarea id="git-message" placeholder="Message"></textarea>
					<div class="form-btn">
						<input type="submit" value="Send" class="primary-btn">
					</div>
				</div>
			</div>
		</div>
	</div>

</section>
<!-- Testimonials End -->

<!-- Featured Videos -->
<section class="hp-featured-videos">
	<div class="comp-featured-videos-container">
		<div class="featured-item video-item">
			<div class="site-title-primary">
				<span class="section-number">07</span>
				<div class="section-name">
					<h4>featured </h4>
					<h2>videos</h2>
				</div>
			</div>
			<a class="site-btn-primary" href="[blogurl]" aria-label="btn">View all videos +</a>
			<div class="feature-slick-video">
				<a class="video-item aios-video-popup" target="_blank" href="https://player.vimeo.com/video/346779867" aria-label="video"   tabindex="0">
					<canvas width="219" height="166" style="background-image: url(http://localhost/isd-projects/yourmodelrealestate.com/wp-content/themes/yourmodelrealestate.com/images/thumbnails1.jpg);"></canvas>
					
					<div class="gallery-btn">
                	<span class="ai-font-play-button-a"></span>
            		</div>
				</a>
				
				<a class="video-item aios-video-popup" target="_blank" href="https://player.vimeo.com/video/346779867" aria-label="video"   tabindex="0">
					<canvas width="219" height="166" style="background-image: url(http://localhost/isd-projects/yourmodelrealestate.com/wp-content/themes/yourmodelrealestate.com/images/thumbnails2.jpg);"></canvas>
					<div class="gallery-btn">
                	<span class="ai-font-play-button-a"></span>
            		</div>
				</a>

				<a class="video-item aios-video-popup" target="_blank" href="https://player.vimeo.com/video/346779867" aria-label="video"   tabindex="0">
					<canvas width="219" height="166" style="background-image: url(http://localhost/isd-projects/yourmodelrealestate.com/wp-content/themes/yourmodelrealestate.com/images/thumbnails3.jpg);"></canvas>
					<div class="gallery-btn">
                	<span class="ai-font-play-button-a"></span>
           			</div>
				</a>
				<a class="video-item aios-video-popup" target="_blank" href="https://player.vimeo.com/video/346779867" aria-label="video"   tabindex="0">
					<canvas width="219" height="166" style="background-image: url(http://localhost/isd-projects/yourmodelrealestate.com/wp-content/themes/yourmodelrealestate.com/images/thumbnails1.jpg);"></canvas>
					<div class="gallery-btn">
                	<span class="ai-font-play-button-a"></span>
            		</div>
				</a>
				
				<a class="video-item aios-video-popup" target="_blank" href="https://player.vimeo.com/video/346779867" aria-label="video"   tabindex="0">
					<canvas width="219" height="166" style="background-image: url(http://localhost/isd-projects/yourmodelrealestate.com/wp-content/themes/yourmodelrealestate.com/images/thumbnails2.jpg);"></canvas>
					<div class="gallery-btn">
                	<span class="ai-font-play-button-a"></span>
            		</div>
				</a>

				<a class="video-item aios-video-popup" target="_blank" href="https://player.vimeo.com/video/346779867" aria-label="video"   tabindex="0">
					<canvas width="219" height="166" style="background-image: url(http://localhost/isd-projects/yourmodelrealestate.com/wp-content/themes/yourmodelrealestate.com/images/thumbnails3.jpg);"></canvas>
					<div class="gallery-btn">
                		<span class="ai-font-play-button-a"></span>
            		</div>
				</a>
			
			</div>
		</div>
		<div class="main-video">
			<div class="feature-item main-slick-video">
			
				<div class="feature-slick-main-video">
					<a href="https://player.vimeo.com/video/346780215" class="fv-t-item aios-video-popup " tabindex="0">
						<canvas width="698" height="436" style="background-image: url(http://localhost/isd-projects/yourmodelrealestate.com/wp-content/themes/yourmodelrealestate.com/images/fv-img.jpg);"></canvas>
						<div class="gallery-btn">
							<span class="ai-font-play-button-a"></span>
						</div>
					</a>
				</div>
				<div class="feature-slick-main-video">
					<a href="https://player.vimeo.com/video/346780215" class="fv-t-item aios-video-popup " tabindex="0">
						<canvas width="698" height="436" style="background-image: url(http://localhost/isd-projects/yourmodelrealestate.com/wp-content/themes/yourmodelrealestate.com/images/fv-img.jpg);"></canvas>
						<div class="gallery-btn">
							<span class="ai-font-play-button-a"></span>
						</div>
					</a>
				</div>
				<div class="feature-slick-main-video">
					<a href="https://player.vimeo.com/video/346780215" class="fv-t-item aios-video-popup " tabindex="0">
						<canvas width="698" height="436" style="background-image: url(http://localhost/isd-projects/yourmodelrealestate.com/wp-content/themes/yourmodelrealestate.com/images/fv-img.jpg);"></canvas>
						<div class="gallery-btn">
							<span class="ai-font-play-button-a"></span>
						</div>
					</a>
				</div>
				<div class="feature-slick-main-video">
					<a href="https://player.vimeo.com/video/346780215" class="fv-t-item aios-video-popup " tabindex="0">
						<canvas width="698" height="436" style="background-image: url(http://localhost/isd-projects/yourmodelrealestate.com/wp-content/themes/yourmodelrealestate.com/images/fv-img.jpg);"></canvas>
						<div class="gallery-btn">
							<span class="ai-font-play-button-a"></span>
						</div>
					</a>
				</div>
				<div class="feature-slick-main-video">
					<a href="https://player.vimeo.com/video/346780215" class="fv-t-item aios-video-popup " tabindex="0">
						<canvas width="698" height="436" style="background-image: url(http://localhost/isd-projects/yourmodelrealestate.com/wp-content/themes/yourmodelrealestate.com/images/fv-img.jpg);"></canvas>
						<div class="gallery-btn">
							<span class="ai-font-play-button-a"></span>
						</div>
					</a>
				</div>
				<div class="feature-slick-main-video">
					<a href="https://player.vimeo.com/video/346780215" class="fv-t-item aios-video-popup " tabindex="0">
						<canvas width="698" height="436" style="background-image: url(http://localhost/isd-projects/yourmodelrealestate.com/wp-content/themes/yourmodelrealestate.com/images/fv-img.jpg);"></canvas>
						<div class="gallery-btn">
							<span class="ai-font-play-button-a"></span>
						</div>
					</a>
				</div>
			</div>

		</div>

		<div class="slick-action">
			<button class="slick-prev">
				<span class="ai-font-arrow-b-p  slick-arrow"></span>
			</button>
			<button class="slick-next">
				<span class="ai-font-arrow-b-n  slick-arrow"></span>
			</button>
		</div>
	</div>
</section>
<!-- Featured Videos End -->


<!-- Hp Footer -->
<section class="hp-footer">
	
	<div class="container">
		<div class="comp-footer-logo">
			<img alt="logo" class="img-responsive pad-upper" src="http://localhost/isd-projects/yourmodelrealestate.com/wp-content/themes/yourmodelrealestate.com/images/logo1.png">

			<img alt="logo" class="img-responsive pad-middle" src="http://localhost/isd-projects/yourmodelrealestate.com/wp-content/themes/yourmodelrealestate.com/images/logo2.png">
		</div>
			
		<div class="footer-info">
			<div class="footer-phone">
				<img alt="smi" class="-img-smi" src="http://localhost/isd-projects/yourmodelrealestate.com/wp-content/themes/yourmodelrealestate.com/images/if-phone.png">
				<a href="+1.678-849-6920">678-849-6920</a>
			</div>
			<div class="footer-email">
				<img alt="smi" class="-img-smi" src="http://localhost/isd-projects/yourmodelrealestate.com/wp-content/themes/yourmodelrealestate.com/images/email.png">
				<a class="asis-mailto-obfuscated-email" data-value="aleta(at)yourmodelrealestate(dotted)com" href="mailto:aleta@yourmodelrealestate.com">aleta@yourmodelrealestate.com</a>
			</div>
		
			<div class="footer-smi">
				<a href="[ai_client_facebook]" aria-label="facebook" target="_blank">
					<img alt="smi" class="-img-smi" src="http://localhost/isd-projects/yourmodelrealestate.com/wp-content/themes/yourmodelrealestate.com/images/smi-fb.png">
				</a>
				<a href="[ai_client_instagram]" aria-label="instagram" target="_blank">
					<img alt="smi" class="-img-smi" src="http://localhost/isd-projects/yourmodelrealestate.com/wp-content/themes/yourmodelrealestate.com/images/smi-insta.png">
				</a>
				<a href="[ai_client_youtube]" aria-label="youtube" target="_blank">
					<img alt="smi" class="-img-smi" src="http://localhost/isd-projects/yourmodelrealestate.com/wp-content/themes/yourmodelrealestate.com/images/smi-in.png">
				</a>
				<a href="[ai_client_yelp]" aria-label="yelp" target="_blank">
					<img alt="smi" class="-img-smi" src="http://localhost/isd-projects/yourmodelrealestate.com/wp-content/themes/yourmodelrealestate.com/images/smi-twitter.png">
				</a>
			</div>
		</div>
	</div>
</section>
<!--Hp Footer end -->


<!-- your home html -->

<?php get_footer(); ?>