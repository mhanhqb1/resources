<?php
  $menuActived = isset($_GET['controller']) ? $_GET['controller'] : '';
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
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
  <title>Công ty cổ phần sàn giao dịch Bất Động Sản Hưng Thịnh</title>
  <link rel="shortcut icon" href="templates/images/Icon-SGD.png">
  <link href="templates/css/bootstrap-theme.css" rel="stylesheet" type="text/css">
  <link href="templates/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="//fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
  <link href="//fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
  <link href="//fonts.googleapis.com/css?family=Josefin Slab" rel="stylesheet" type="text/css">
  <link href="templates/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <link href="templates/css/generalnew2.css" rel="stylesheet" type="text/css">
  <link href="templates/css/menu.css" rel="stylesheet" type="text/css">
  <link href="templates/css/vertical_tabmenu.css" rel="stylesheet" type="text/css">
  <link href="templates/css/new_design.css" rel="stylesheet" type="text/css">

  <script type="text/javascript" src="templates/js/jquery-2.1.1.min.js"></script>
  <script type="text/javascript" src="templates/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="templates/js/jquery.easing.min.js"></script>
  <script type="text/javascript" src="templates/js/jquery.lavalamp.min.js"></script>
  <script type="text/javascript" src="templates/js/ddaccordion.js"></script>
  <script type="text/javascript">
   var jmenu = jQuery.noConflict();
   jmenu(function() {
    jmenu("#1, #2, #3").lavaLamp({
      fx: "backout", 
      speed: 700,
      click: function(event, menuItem) {
        return true;
      }
    });
  });
</script>
<script src="templates/js/jquery.min.js" type="text/javascript"></script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-78369809-1', 'auto');
  ga('send', 'pageview');
</script>
<script type="text/javascript" src="templates/js/scrolltop.js"></script>
<style type="text/css">
.submenu{display: none}
</style>
<script type="text/javascript">
  $(document).ready(function(){
    $(".menu-icon").click(function(){
        $(".menu-sp").slideToggle();
    });
  });
</script>

</head>
<body cz-shortcut-listen="true">﻿
  <div id="fb-root"></div>
  <script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.6&appId=1548784618756974";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));</script>
    
  <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <img class="banner-mobile" src="templates/images/banner.png">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li <?php if ($menuActived == '') echo "class='active'";?>><a href="trang-chu.html">Trang chủ</a></li>
              <li <?php if ($menuActived == 'gioithieu') echo "class='active'";?>><a href="gioi-thieu.html">Giới thiệu</a></li>
              <li <?php if ($menuActived == '1' || $menuActived == 'duan') echo "class='active'";?>><a href="du-an.html">Dự án</a></li>
              <li <?php if ($menuActived == 'tintuc') echo "class='active'";?>><a href="tin-tuc.html">Tin tức</a></li>
              <li <?php if ($menuActived == 'tuyendung') echo "class='active'";?>><a href="tuyen-dung.html">Tuyển dụng</a></li>
              <li <?php if ($menuActived == 'lienhe') echo "class='active'";?>><a href="lien-he.html">Liên hệ</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a style="color: red; font-size: 15px;"><span class="glyphicon glyphicon-earphone" style="color: green;"></span> 0919.889.333</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    
    <!-- <div class="header_middle"> 
          <div class="logo">
            <a href="trang-chu.html"><img src="templates/images/logo_HTL2.png"></a>
          </div>
          <div class="banner">
            <img src="templates/images/banner1.png">
          </div>
    </div> -->
        <div id="about" class="jumbotron text-center">
          <h1>HUNG THINH LAND</h1> 
          <p>Nơi nuôi dưỡng ước mơ</p> 
        </div>