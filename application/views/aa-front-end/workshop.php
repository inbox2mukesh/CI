<!-- Main Slider -->
<section class="bg-lighter workshopslider">
	<div class="carousel slide" data-ride="carousel">
		<?php if (DEFAULT_COUNTRY == 13) { ?>
			<div class="owl-carousel-slider">
				<div class="carousel-item active">
					<img class="d-block w-100 desktop-slider lazyload" src="<?php echo base_url('resources-f/images/slider/Australia-IELTS-PTE-Workshop-Website-1902x802-_1_.webp'); ?>" alt="" loading="lazy">
					<img class="d-block w-100 mobile-slider lazyload" src="<?php echo base_url('resources-f/images/slider/Australia-IELTS-PTE-Workshop-Mobile-Website-_1_.webp'); ?>" alt="" loading="lazy">
				</div>

			</div>
		<?php } else if (DEFAULT_COUNTRY == 101) {
		?>

			<div class="owl-carousel-slider">
				<div class="carousel-item active">
					<img class="d-block w-100 desktop-slider" src="<?php echo base_url('resources-f/images/slider/online-desktop-slider-1.webp'); ?>" alt="">
					<img class="d-block w-100 mobile-slider" src="<?php echo base_url('resources-f/images/slider/online-mobile-slider-1.webp'); ?>" alt="">
				</div>

			</div>



		<?php
		} else { ?>
			<div class="owl-carousel-slider">
				<div class="carousel-item active">
					<img class="d-block w-100 desktop-slider lazyload" src="<?php echo base_url('resources-f/images/slider/desktop-slider-1.webp'); ?>" alt="" width="1920px" height="800px">
					<img class="d-block w-100 mobile-slider lazyload" src="<?php echo base_url('resources-f/images/slider/mobile-slider-1.webp'); ?>" alt="" width="1000px" height="665px">
					<img class="d-block w-100 small-mobile-slider lazyload" src="<?php echo base_url('resources-f/images/slider/small-mobile-slider-1.webp'); ?>" alt="" width="375px" height="249px">
				</div>
			</div>

		<?php } ?>
		<!-- <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
		</a>
		<a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
		</a> -->
		<!-- uick form -->

		<div class="container sld-form">
			<div class="sl-form">
				<div class="topFormpanel text-left clearfix">
					<?php //$this->load->view("aa-front-end/includes/enquiry_form",array("formType" => "workshop")); ?>
					<?php $formType = "workshop"; ?>
					<?php include('includes/enquiry_form.php');?>
				</div>
			</div>
		</div>
		<div>

</section>

<!-- End Main Slider -->

<script>
$( document ).ready(function() {
	$(".owl-carousel-slider").owlCarousel({
		items: 1,
		autoplay: false,
		nav: false,
		arrow : false,
		navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"]
	});
});
</script>