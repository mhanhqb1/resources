<!DOCTYPE html>
<html lang="vi">
<head>
  	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<meta charset="utf-8">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  	<meta name="description" content="Hung Thinh Land thành viên của Hung Thinh Corporation, Căn hộ Thanh Đa View, căn hộ 8X Plus, Căn hộ 8X Thái An, Dự Án tại ">
  	<meta name="robots" content="index, follow">
  	<meta name="keywords" content="Hung Thinh Land thành viên của Hung Thinh Corporation, Căn hộ Thanh Đa View, căn hộ 8X Plus, Căn hộ 8X Thái An">
  	<meta name="page-topic" content="Dự Án tại sàn giao dịch bất động sản Hưng Thịnh">
  	<meta name="copyright" content="Hung Thinh Land">
  	<meta name="author" content="Tap doan Hung Thinh">
  	<title><?php echo $data['title'];?></title>
  	<link rel="shortcut icon" href="templates/images/Icon-SGD.png">
  	<link href="templates/css/bootstrap-theme.css" rel="stylesheet" type="text/css">
  	<link href="templates/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  	<link href="//fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
  	<link href="//fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
  	<link href="//fonts.googleapis.com/css?family=Josefin Slab" rel="stylesheet" type="text/css">
  	<link href="templates/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  	<link href="templates/css/generalnew2.css" rel="stylesheet" type="text/css">
  	<link rel="stylesheet" href="templates/css/style_duan.css">
  	<script type="text/javascript" src="templates/js/jquery-2.1.1.min.js"></script>
  	<script type="text/javascript" src="templates/js/bootstrap.min.js"></script>
  	<script src="templates/js/scrolling.js"></script>
  	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
	  ga('create', 'UA-78369809-1', 'auto');
	  ga('send', 'pageview');
	</script>
</head>
<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">

<!-- FB Content Start -->
<div id="fb-root"></div>
<script>
	(function(d, s, id) {
	    var js, fjs = d.getElementsByTagName(s)[0];
	    if (d.getElementById(id)) return;
	    js = d.createElement(s); js.id = id;
	    js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.6&appId=1548784618756974";
	    fjs.parentNode.insertBefore(js, fjs);
  	}(document, 'script', 'facebook-jssdk'));
</script>
<!-- FB Content End -->
<!-- Navbar Start -->
<nav class="navbar navbar-default navbar-fixed-top">
  	<div class="container">
	    <div class="navbar-header">
	      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span> 
	      </button>
	      <a class="navbar-brand" href="trang-chu.html">Quay lại trang chủ</a>
	    </div>
	    <div class="collapse navbar-collapse" id="myNavbar">
	      <ul class="nav navbar-nav navbar-right">
	        <li><a href="#thongtin">Thông tin</a></li>
	        <li><a href="#vitri">Vị trí</a></li>
	        <li><a href="#tienich">Tiện ích</a></li>
	        <li><a href="#matbang">Mặt bằng</a></li>
	        <li><a href="#hinhanh">Hình ảnh</a></li>
	        <li><a href="#giaodich">Giao dịch</a></li>
	        <li><a href="#dangkyxemnha">Đăng ký</a></li>
	      </ul>
	    </div>
  	</div>
</nav>
<!-- Navbar End -->
<!-- Jumbotron Start -->
<div class="jumbotron text-center">
	<h1><?php echo $data['title'];?></h1> 
	<p>Not your house, It’s your home</p> 
</div>
<div id="thongtin" class="container">
	<h1>Thông tin</h1> 
	<div class="duan_box">
		<?php echo $data['thongtin'];?>
	</div> 
</div>
<div id="vitri" class="container">
	<h1>Vị trí</h1> 
	<div class="duan_box">
		<?php echo $data['vitri'];?>
	</div>
</div>
<div id="tienich" class="container">
	<h1>Tiện ích</h1> 
	<div class="duan_box">
		<?php echo $data['tienich'];?>
	</div> 
</div>
<div id="matbang" class="container">
	<h1>Mặt bằng</h1> 
	<div class="duan_box">
		<?php echo $data['matbang'];?>
	</div>
</div>
<div id="hinhanh" class="container">
	<h1>Hình ảnh</h1> 
	<div class="duan_box">
		<?php echo $data['hinhanh'];?>
	</div> 
</div>
<div id="giaodich" class="container">
	<h1>Giao dịch</h1>
	<div class="duan_box">
		<p>&nbsp;</p>
		<p>——————————————————<br>
			Một sản phẩm của Hung Thinh Corporation</p>
			<p>Not your house, It’s your home</p>
			<p>
				<h4><span style="color: #008000;"><?php echo $contactData['name'];?></span></h4>
			</p>
			<p><span style="color: #0000ff;"><strong>Trụ sở chính :&nbsp;53 Trần Quốc Thảo, P7, Quận 3, TP.HCM</strong></span></p>
			<p><span style="color: #0000ff;"><strong>Phòng giao dịch : <?php echo $contactData['address'];?></strong></span></p>
			<p><span style="color: #0000ff;"><strong>Liên hệ Hotline Chủ đầu tư: <?php echo $contactData['phone'];?></strong></span></p>
			<p><span style="color: #0000ff;"><strong>Email: <?php echo $contactData['email'];?></strong></span></p>
			<p>&nbsp;</p>
			<p>&nbsp;</p>
		</div>
	</div> 
</div>
<div class="container">
	<h1>ĐĂNG KÝ NHẬN BẢNG GIÁ CĂN HỘ</h1>
	<div id="dangkyxemnha" class="showtext">
			<h3>Quý khách có nhu cầu tìm hiểu thêm thông tin về sản phẩm, vui lòng cung cấp nội dung theo form bên dưới, chúng tôi sẽ phản hồi trong thời gian sớm nhất. Chân thành cảm ơn quý khách.</h3>
			<div>
				<div class="row">
					<div class="col-xs-12">
						<form method="post" action="lien-he.html" enctype="multipart/form-data" class="form-horizontal col-xs-8 col-xs-offset-1">
							<div class="form-group">
								<label for="tenkhachhang" class="col-xs-3 control-label">Họ và tên *</label>
								<div class="col-xs-9">
									<input name="tenkhachhang" type="text" class="form-control" placeholder="Họ và tên *" required="">
								</div>
							</div>
							<div class="form-group">
								<label for="sodienthoai" class="col-xs-3 control-label">Điện thoại *</label>
								<div class="col-xs-9">
									<input name="sodienthoai" type="text" class="form-control" placeholder="Điện thoại *" required="">
								</div>
							</div>
							<div class="form-group">
								<label for="email" class="col-xs-3 control-label">Email *</label>
								<div class="col-xs-9">
									<input name="email" id="email" type="email" class="form-control" placeholder="Email *" required="">
								</div>
							</div>
							<div class="form-group">
								<label for="noidunglienhe" class="col-xs-3 control-label">Lời nhắn *</label>
								<div class="col-xs-9">
									<textarea class="form-control" rows="5" name="noidunglienhe" required=""></textarea>
								</div>
							</div>

							<div class="form-group">
								<div class="col-xs-offset-3 col-xs-9">
									<input class="frmbutton" type="submit" name="lienhesubmit" value="Gửi"/>
								</div>
							</div>
			        	</form>
			        	<div id="frm_hotline" class="col-xs-3">
			        		<p><strong>Hotline: </strong></p>
			        		<p class="text-danger">
			        		<?php foreach ($phoneNumberData as $v): ?>
			        			<?php if ($v['is_lienhe'] == 1): ?>
			        			<?php echo $v['phone']; ?><br>
			        		<?php endif; endforeach; ?>
			        		</p>
			        	</div>
					</div>
				</div>
			</div>
		</div>
	</div>