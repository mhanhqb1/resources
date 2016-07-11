<!DOCTYPE html>
<html>
    <head>
    <?= $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>
        <?= $this->fetch('title') ?>
        </title>
        <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
            function hideURLbar(){ window.scrollTo(0,1); } </script>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('bootstrap.css') ?>
    <?= $this->Html->css('style.css') ?>
    <?= $this->Html->css('flexslider.css') ?>
    <?= $this->Html->script('jquery-1.11.1.min.js'); ?>
    <?= $this->Html->script('modernizr.custom.js'); ?>
    <?= $this->Html->script('simpleCart.min.js'); ?>
        <!--web-fonts-->
        <link href='//fonts.googleapis.com/css?family=Raleway:400,100,100italic,200,200italic,300,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic' rel='stylesheet' type='text/css'><link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
        <link href='//fonts.googleapis.com/css?family=Pompiere' rel='stylesheet' type='text/css'>
        <link href='//fonts.googleapis.com/css?family=Fascinate' rel='stylesheet' type='text/css'>
        <!--web-fonts--> 
        <!--animation-effect-->
    <?= $this->Html->css('animate.min.css') ?>
    <?= $this->Html->script('wow.min.js'); ?>
<!--        <script>
            new WOW().init();
        </script>-->
        <!--//animation-effect-->

        <!--start-smooth-scrolling-->
        <?= $this->Html->script('move-top.js'); ?>
        <?= $this->Html->script('easing.js'); ?>
        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                $(".scroll").click(function (event) {
                    event.preventDefault();
                    $('html,body').animate({scrollTop: $(this.hash).offset().top}, 1000);
                });
            });
        </script>
        <!--//end-smooth-scrolling-->

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>


    </head>
    <body>
        <!----------------- Header start -------------------->
        <div class="header">
            <div class="header-two navbar navbar-default"><!--header-two-->
                <div class="container">
                    <div class="nav navbar-nav header-two-left">
                        <ul>
                            <li><i class="glyphicon glyphicon-earphone" aria-hidden="true"></i>+1234 567 892</li>
                            <li><i class="glyphicon glyphicon-envelope" aria-hidden="true"></i><a href="mailto:info@example.com">mail@example.com</a></li>			
                        </ul>
                    </div>
                    <div class="nav navbar-nav logo wow zoomIn animated" data-wow-delay=".7s">
                        <h1><a href="index.html">Modern <b>Shoppe</b><span class="tag">Everything for Kids world </span> </a></h1>
                    </div>
                    <div class="nav navbar-nav navbar-right header-two-right">
                        <div class="header-right my-account">
                            <a href="contact.html"><span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span> CONTACT US</a>						
                        </div>
                        <div class="header-right cart">
                            <a href="#"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span></a>
                            <h4><a href="checkout.html">
                                    <span class="simpleCart_total"> $0.00 </span> (<span id="simpleCart_quantity" class="simpleCart_quantity"> 0 </span>) 
                                </a></h4>
                            <div class="cart-box">
                                <p><a href="javascript:;" class="simpleCart_empty">Empty cart</a></p>
                                <div class="clearfix"> </div>
                            </div>
                        </div>
                        <div class="clearfix"> </div>
                    </div>
                    <div class="clearfix"> </div>
                </div>
            </div>
            <div class="top-nav navbar navbar-default"><!--header-three-->
                <div class="container">
                    <nav class="navbar" role="navigation">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        <!--navbar-header-->
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                            <ul class="nav navbar-nav top-nav-info">
                                <li><a href="index.html" class="active">Home</a></li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Baby<b class="caret"></b></a>
                                    <ul class="dropdown-menu multi-column multi-column1">
                                        <div class="row">
                                            <div class="col-sm-4 menu-grids menulist1">
                                                <h4>Bath & Care</h4>
                                                <ul class="multi-column-dropdown ">
                                                    <li><a class="list" href="products.html">Diapering</a></li>
                                                    <li><a class="list" href="products.html">Baby Wipes</a></li>
                                                    <li><a class="list" href="products.html">Baby Soaps</a></li>
                                                    <li><a class="list" href="products.html">Lotions & Oils </a></li>
                                                    <li><a class="list" href="products.html">Powders</a></li>
                                                    <li><a class="list" href="products.html">Shampoos</a></li>
                                                </ul>
                                                <ul class="multi-column-dropdown">
                                                    <li><a class="list" href="products.html">Body Wash</a></li>
                                                    <li><a class="list" href="products.html">Cloth Diapers</a></li>
                                                    <li><a class="list" href="products.html">Baby Nappies</a></li>
                                                    <li><a class="list" href="products.html">Medical Care</a></li>
                                                    <li><a class="list" href="products.html">Grooming</a></li>
                                                    <li><h6><a class="list" href="products.html">Combo Packs</a></h6></li>
                                                </ul>
                                            </div>																		
                                            <div class="col-sm-2 menu-grids">
                                                <h4>Baby Clothes</h4>
                                                <ul class="multi-column-dropdown">
                                                    <li><a class="list" href="products.html">Onesies & Rompers</a></li>
                                                    <li><a class="list" href="products.html">Frocks</a></li>
                                                    <li><a class="list" href="products.html">Socks & Tights</a></li>
                                                    <li><a class="list" href="products.html">Sweaters & Caps</a></li>
                                                    <li><a class="list" href="products.html">Night Wear</a></li>
                                                    <li><a class="list" href="products.html">Quilts & Wraps</a></li>
                                                </ul>
                                            </div>
                                            <div class="col-sm-3 menu-grids">
                                                <ul class="multi-column-dropdown">
                                                    <li><a class="list" href="products.html">Blankets</a></li>
                                                    <li><a class="list" href="products.html">Gloves & Mittens</a></li>
                                                    <h4>Shop by Age</h4>
                                                    <li><a class="list" href="products.html">New Born (0 - 5 M)</a></li>
                                                    <li><a class="list" href="products.html">5 - 10 Months</a></li>
                                                    <li><a class="list" href="products.html">10 - 15 Months</a></li>
                                                    <li><a class="list" href="products.html">15 Months Above</a></li>
                                                </ul>
                                            </div>
                                            <div class="col-sm-3 menu-grids">
                                                <ul class="multi-column-dropdown">
                                                    <li><h6><a class="list" href="products.html">Feeding & Nursing</a></h6></li>
                                                    <h4>Baby Gear</h4>
                                                    <li><a class="list" href="products.html">Baby Walkers</a></li>
                                                    <li><a class="list" href="products.html">Strollers</a></li>
                                                    <li><a class="list" href="products.html">Prams & Toys</a></li>
                                                    <li><a class="list" href="products.html">Cribs & Cradles</a></li>
                                                    <li><a class="list" href="products.html">Booster Seats</a></li>
                                                </ul>
                                            </div>
                                            <div class="clearfix"> </div>
                                        </div>
                                    </ul>
                                </li>
                            </ul> 
                            <div class="clearfix"> </div>
                            <!--//navbar-collapse-->
                            <header class="cd-main-header">
                                <ul class="cd-header-buttons">
                                    <li><a class="cd-search-trigger" href="#cd-search"> <span></span></a></li>
                                </ul> <!-- cd-header-buttons -->
                            </header>
                        </div>
                        <!--//navbar-header-->
                    </nav>
                    <div id="cd-search" class="cd-search">
                        <form>
                            <input type="search" placeholder="Search...">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!----------------- Header end   -------------------->

    <?= $this->Flash->render() ?>

        <!----------------- Content start -------------------->
    <?= $this->fetch('content') ?>
        <!----------------- Content end   -------------------->

        <!----------------- Footer start -------------------->
        <div class="footer">
            <div class="container">
                <div class="footer-info">
                    <div class="col-md-4 footer-grids wow fadeInUp animated" data-wow-delay=".5s">
                        <h4 class="footer-logo"><a href="index.html">Modern <b>Shoppe</b> <span class="tag">Everything for Kids world </span> </a></h4>
                        <p>© 2016 Modern Shoppe . All rights reserved | Design by <a href="http://w3layouts.com" target="_blank">W3layouts</a></p>
                    </div>
                    <div class="col-md-4 footer-grids wow fadeInUp animated" data-wow-delay=".7s">
                        <h3>Popular</h3>
                        <ul>
                            <li><a href="about.html">About Us</a></li>
                            <li><a href="products.html">new</a></li>
                            <li><a href="contact.html">Contact Us</a></li>
                            <li><a href="faq.html">FAQ</a></li>
                            <li><a href="checkout.html">Wishlist</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4 footer-grids wow fadeInUp animated" data-wow-delay=".9s">
                        <h3>Subscribe</h3>
                        <p>Sign Up Now For More Information <br> About Our Company </p>
                        <form>
                            <input type="text" placeholder="Enter Your Email" required="">
                            <input type="submit" value="Go">
                        </form>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <!----------------- Footer end   -------------------->
        <!--search jQuery-->
	<?= $this->Html->script('main.js'); ?>
	<!--//search jQuery-->
	<!--smooth-scrolling-of-move-up-->
	<script type="text/javascript">
		$(document).ready(function() {
		
			var defaults = {
				containerID: 'toTop', // fading element id
				containerHoverID: 'toTopHover', // fading element hover id
				scrollSpeed: 1200,
				easingType: 'linear' 
			};
			
			$().UItoTop({ easingType: 'easeOutQuart' });
			
		});
	</script>
	<!--//smooth-scrolling-of-move-up-->
	<!--Bootstrap core JavaScript
    ================================================== -->
    <!--Placed at the end of the document so the pages load faster -->
    <?= $this->Html->script('bootstrap.js'); ?>
    </body>
</html>
