<!DOCTYPE html>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>SINMAR - Contact</title>

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<!-- Font -->
		<link rel="stylesheet" href="css/font-awesome.min.css">
		<link rel="stylesheet" href="css/elegant-font.css">
	  	<!-- SCROLL BAR MOBILE MENU
  		================================================== --> 
	 	<link rel="stylesheet" href="css/jquery.mCustomScrollbar.css" />
		<!-- Main Style -->
		<link rel="stylesheet" href="style.css">
		  
		<!-- Favicons
		  ================================================== -->
	  	<link rel="shortcut icon" href="favicon.png">
	  	
	</head>
	<body>
	 	
		<?php include_once('includes/mobilemenu.php'); ?>

		<div class="modal fade modal-search" id="myModal" tabindex="-1" role="dialog"   aria-hidden="true">
		  	<button type="button" class="close" data-dismiss="modal">×</button>
		  	<div class="modal-dialog myModal-search">
            <!-- Modal content-->
            <div class="modal-content">                                        
                <div class="modal-body">
                    <form role="search" method="get" class="search-form"  >
                        <input class="search-field" placeholder="Search here..." value="" title="" type="search">
                        <button type="submit" class="search-submit"><i class="fa fa-search"></i></button>
                    </form>
                </div>
            </div>
          </div>
		</div>
		<!-- End Modal Search-->

	    <div id="page">
	    	<div id="skrollr-body">

				<?php include_once('includes/header.php'); ?>
				<!-- End  Header -->

				<section>
					<div class="sub-header sub-header-1 sub-header-contact fake-position">
						<div class="sub-header-content">
							<h2 class="text-cap white-text">Contact Us</h2>
							<ol class="breadcrumb breadcrumb-arc text-cap">
								<li>
									<a href="index.php">Home</a>
								</li>
								<li class="active">Contact Us</li>
							</ol>
						</div>
					</div>
				</section>
				<!-- End Section Sub Header -->

				<!-- Section form contact -->
				<section id="content" class="padding">
					<div class="container">
						<div class="row row-eq-height">
							<div class="contact-warp contact-warp-3">
								<div class="col-md-12">

									<main id="main" class="blog-list">
										<h1 class="text-cap">WE'RE HERE TO HELP</h1>
										<h3>Feel free to contact us with any questions you have.</h3>

										<div class="right-contact col-md-4">
											<h4 class="text-cap">Branch 1 Info</h4>
											<ul class="address">
												<li><p><i class="fa fa-home" aria-hidden="true"></i>
														&nbsp;&nbsp; Al Helaleiyh  Main Street -saïda , Lebanon
												</p></li>
												<li><p><i class="fa fa-phone" aria-hidden="true"></i>
														&nbsp;&nbsp; +961 7 735 048
												</p></li>
												<li><p><i class="fa fa-fax" aria-hidden="true"></i>
														&nbsp; +961 71 14 27 14
												</p></li>
												<li><p><i class="fa fa-envelope-o" aria-hidden="true"></i>
														&nbsp;&nbsp; info@sinmar-lb.com
												</p></li>
												<li><p><i class="fa fa-clock-o" aria-hidden="true"></i>
														&nbsp;&nbsp; Mon-Fri 09:00 - 17:00
												</p></li>
											</ul>
										</div>
										<!-- Section Google Map -->
										<div class="right-contact col-md-8">
											<iframe class="col-md-12" height="340" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/search?q=Hlaliyeh%2C%20South%20Governorate%2C%20Lebanon&key=AIzaSyA19fRd-oq-hPtBBnGwPw5_-_jMKm18w7w" allowfullscreen></iframe>
										</div>
										<!-- End Section -->

										<div class="clearfix">&emsp;</div>

										<div class="right-contact col-md-4">
											<h4 class="text-cap">Branch 2 Info</h4>
											<ul class="address">
												<li><p><i class="fa fa-home" aria-hidden="true"></i>
														&nbsp;&nbsp; Al Hara sakana street- saida, Lebanon
													</p></li>
												<li><p><i class="fa fa-phone" aria-hidden="true"></i>
														&nbsp;&nbsp; +961 7 735 048
													</p></li>
												<li><p><i class="fa fa-fax" aria-hidden="true"></i>
														&nbsp; +961 71 14 29 14
													</p></li>
												<li><p><i class="fa fa-envelope-o" aria-hidden="true"></i>
														&nbsp;&nbsp; info@sinmar-lb.com
													</p></li>
												<li><p><i class="fa fa-clock-o" aria-hidden="true"></i>
														&nbsp;&nbsp; Mon-Fri 09:00 - 17:00
													</p></li>
											</ul>
										</div>
										<!-- Section Google Map -->
										<div class="right-contact col-md-8">
											<iframe class="col-md-12" height="320" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/search?q=Haret%20Saida%2C%20South%20Governorate%2C%20Lebanon&key=AIzaSyA19fRd-oq-hPtBBnGwPw5_-_jMKm18w7w" allowfullscreen></iframe>
										</div>
										<!-- End Section -->

										<div class="clearfix">&emsp;</div>

										<div class="col-md-12 ">
											<div class="left-contact contact-form-1-cols">
												<h3 class="text-cap"> Send Us a Message</h3>
												<form class="form-inline form-contact-arc" name="contact" method="post" action="send_form_email.php">
													<div class="row">
														<div class="form-group col-md-4 ">
															<input type="text" class="form-control" name="yourName" id="yourName" placeholder="Your Name">
														</div>
														<div class="form-group col-md-4">
															<input type="email" class="form-control" name="yourEmail" id="yourEmail" placeholder="Your Email" >
														</div>
														<div class="form-group col-md-4">
															<input type="text" class="form-control" name="yourPhone" id="phoneNumber" placeholder="Phone Number" >
														</div>
													</div>
													<div class="input-content padding-top-20">
														<div class="form-group form-textarea">
															<textarea id="textarea" class="form-control" name="comments" rows="6" placeholder="Your Messages" ></textarea>
														</div>
													</div>
													<button  class="ot-btn btn-main-color btn-long text-cap btn-submit" type="submit" >Send Mail</button>
												</form> <!-- End Form -->
											</div> <!-- End col -->
										</div>

									</main>
								</div> <!-- End col -->
							</div>
						</div>
					</div>
				</section>
				<!-- End Section -->

				<?php include_once('includes/footer.php'); ?>
			</div>
		</div>
		<!-- End page -->
	     
		<a id="to-the-top"><i class="fa fa-angle-up"></i></a> 
		<!-- Back To Top -->
	<!-- SCRIPT -->
    <script src="js/vendor/jquery.min.js"></script>
    <script src="js/vendor/bootstrap.min.js"></script>
    <script src="js/plugins/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="js/plugins/wow.min.js"></script>
    <script type="text/javascript" src="js/plugins/skrollr.min.js"></script>
    
	 <!-- Mobile Menu
    ================================================== --> 
    <script src="js/plugins/jquery.mobile-menu.js"></script>
	<!-- Initializing Google Maps -->
	<script src='https://maps.googleapis.com/maps/api/js?key=&sensor=false&extension=.js'></script>
	<script src="js/plugins/maplace.js"></script>
	<!-- PreLoad
    ================================================== --> 
    <script type="text/javascript" src="js/plugins/royal_preloader.min.js"></script>
	<script type="text/javascript">
	(function($) { "use strict";
	            Royal_Preloader.config({
	                mode:           'logo', // 'number', "text" or "logo"
	                logo:           'http://placehold.it/119x29/ccc.jpg',
	                timeout:       1,
	                showInfo:       false,
	                opacity:        1,
	                background:     ['#FFFFFF']
	            });
	})(jQuery);
	</script>

 	<!-- Global Js
    ================================================== --> 
    <script src="js/plugins/custom.js"></script>

	</body>
</html>