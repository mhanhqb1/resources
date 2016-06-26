<?php
$id = $type = $title = $data = '';
$duan = new DUAN;
if (isset($_GET['id'])) {
	$id = $_GET['id'];
}
if (isset($_GET['type'])) {
	$type = $_GET['type'];
	if ($type == 'dautu') {
		$title = 'Dự án đầu tư';
		$data = $duan->getDuandautu();
		$url = 'du-an-dau-tu';
	}
	if ($type == 'giatot') {
		$title = 'Dự án giá tốt';
		$data = $duan->getDuangiatot();
		$url = 'du-an-gia-tot';
	}
	if ($type == 'moi') {
		$title = 'Dự án mới';
		$data = $duan->getDuanmoi();
		$url = 'du-an-moi';
	}
	if ($type == 'noithanh') {
		$title = 'Dự án tại TP Hồ Chí Minh';
		$data = $duan->getDuanNoiThanh();
		$url = 'du-an-tai-tp-hcm';
	}
	if ($type == 'ngoaithanh') {
		$title = 'Dự án các tỉnh khác';
		$data = $duan->getDuanNgoaiThanh();
		$url = 'du-an-ngoai-tp-hcm';
	}
}
?>



<?php if ($id): ?>
	<?php $data = $duan->listOne($id);?>
	<div class="container chitietduan">
		<h1><?php echo $data['title'];?></h1>
		<div class="tabscontainer">
			<script type="text/javascript" src="templates/js/jquery.min.js"></script>
			<script type="text/javascript">
				var jqdetal = jQuery.noConflict();
				jqdetal(function() {
					jqdetal(".tabs .tab[id^=tab_menu]").hover(function() {
						var curMenu=jqdetal(this);
						jqdetal(".tabs .tab[id^=tab_menu]").removeClass("selected");
						curMenu.addClass("selected");
					});

					jqdetal(".tabs .tab[id^=tab_menu]").click(function() {
						var curMenu=jqdetal(this);
						jqdetal(".tabs .tab[id^=tab_menu]").removeClass("selected");
						curMenu.addClass("selected");

						var index=curMenu.attr("id").split("tab_menu_")[1];
						jqdetal(".curvedContainer .tabcontent").css("display","none");
						jqdetal(".curvedContainer #tab_content_"+index).css("display","block");
						$(function() {
							$("#share-box").stop().css({
								marginTop: 15
							});
							var offset = $("#share-box").offset();
							var shareboxheight = $("#share-box").height();
							var offsetb = $("#register").offset();

							var khoangcachshare =$("#curvedContainer").height()-shareboxheight-30;


							var topPadding = 15;
							$(window).scroll(function() {
								if ($(window).scrollTop() > offset.top){
									if ($(window).scrollTop() < khoangcachshare+566){
										$("#share-box").stop().css({
											marginTop: $(window).scrollTop() - offset.top + topPadding
										});                    
									}else{
										$("#share-box").stop().css({
											marginTop: khoangcachshare-15
										});                     
									}
								}else {
									$("#share-box").stop().css({
										marginTop: 15
									});
								};
							});
						});
					});
	// jqdetal('.box_skitter_medium').css({width: 450, height: 289}).skitter({show_randomly: true, navigation: false, dots: true, interval: 3000});
		// Highlight
	// jqdetal('pre.code').highlight({source:1, zebra:1, indent:'space', list:'ol'});
});

</script>
</script>
<div class="tabs" id="share-box" style="margin-top: 15px;">
	<div class="tab first selected" id="tab_menu_1">
		<div class="link">Thông tin</div>
		<div class="arrow"></div>
	</div>
	<div class="tab" id="tab_menu_2">
		<div class="link">Vị trí</div>
		<div class="arrow"></div>
	</div>
	<div class="tab" id="tab_menu_3">
		<div class="link">Tiện ích</div>
		<div class="arrow"></div>
	</div>
	<div class="tab" id="tab_menu_4">
		<div class="link">Mặt bằng</div>
		<div class="arrow"></div>
	</div>
	<div class="tab" id="tab_menu_5">
		<div class="link">Tin tức</div>
		<div class="arrow"></div>
	</div>
	<div class="tab" id="tab_menu_6">
		<div class="link">Hình ảnh</div>
		<div class="arrow"></div>
	</div>
	<div class="tab" id="tab_menu_7">
		<div class="link">Giao dịch</div>
		<div class="arrow"></div>
	</div>
</div>
<div class="curvedContainer" id="curvedContainer">
	<div class="tabcontent" id="tab_content_1" style="display: block;">
		<?php echo $data['thongtin'];?>
	</div>
	<div class="tabcontent" id="tab_content_2">
		<?php echo $data['vitri'];?>
	</div>
	<div class="tabcontent" id="tab_content_3">
		<?php echo $data['tienich'];?>
	</div>
	<div class="tabcontent" id="tab_content_4">
		<?php echo $data['matbang'];?>
	</div>
	<div class="tabcontent" id="tab_content_5">
		<?php echo $data['tintuc'];?>
	</div>
	<div class="tabcontent" id="tab_content_6">
		<?php echo $data['hinhanh'];?>
	</div>
	<div class="tabcontent" id="tab_content_7">
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


<?php 
// $text = $data['title'];
// $text = convertURL($text);
?>
<!-- <div class="fb-comments" data-href="duan-<?php echo $text.'-'.$data['duan_id'];?>.html" data-numposts="10" data-width="100%" data-colorscheme="light"></div> -->

<!-- Form dang ky -->
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
<!-- End Form dang ky -->

</div>
<?php endif;?>

<?php if ($type && $title && $data): ?>
	<?php
	$totalData = count($data);
	$limit = PAGE_LIMIT;
	$totalPage = ceil($totalData/$limit);
	$start = 0;
	if(isset($_GET['page'])){
		$start = ($_GET['page'] - 1)*$limit;
	}
	$data = pagination($start, $limit, $data);
	?>
	<div class="col-md-9">
		<div class="top_bds">
			<div class="col-xs-4"> 
				<a href="du-an-dau-tu.html"><img src="templates/images/bds_dacbiet.jpg">
				</a>
			</div>
			<div class="col-xs-4"> 
				<a href="du-an-gia-tot.html"><img src="templates/images/bds_giatot.png">
				</a>
			</div>
			<div class="col-xs-4"> 
				<a style="padding-right:0;" href="du-an-moi.html"><img src="templates/images/bds_moi.png">
				</a>
			</div>
		</div>
		<div class="box-content">
			<div class="box-content-top">
				<div class="title"><span><?php echo $title;?></span> <!-- <a href="du-an.html"><img style="float:right;" src="templates/images/btn-xemhet.jpg" width="73" height="31"></a> -->
				</div>
			</div>
			<div class="box-content-inside">
				<ul>
					<?php foreach ($data as $v) : ?>
						<?php 
						$text = $v['title'];
						$text = convertURL($text);
						?>
						<li class="col-xs-6 col-sm-4">
							<a href="duan-<?php echo $text.'-'.$v['duan_id'];?>.html">
								<?php if ($v['is_dautu'] == 1): ?>
									<img id="anhhot" src="templates/images/hot.gif">
								<?php endif;?>
								<img src="media/images/duan/<?php echo $v['image']; ?>">
							</a>
							<p class="giaduan">Giá: <span><?php echo $v['price'];?></span></p>
							<a href="duan-<?php echo $text.'-'.$v['duan_id'];?>.html"><?php echo $v['title'];?></a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
		<div class="paging" style="width:100%; margin:auto; margin-top:0px; text-align:center; float:left">
			<span class="pages">
				<ul>
					<li style="line-height: 26px; font-weight: bold;">Trang: </li>
					<?php for ($i=1;$i<=$totalPage;$i++): ?>
						<li>
							<a <?php if(isset($_GET['page']) && $_GET['page'] == $i) echo 'class="page_cur"';?> href="<?php echo $url; ?>-trang-<?php echo $i;?>.html"><?php echo $i?></a>
						</li>
					<?php endfor; ?>
				</ul>
			</span>
		</div>
	</div>
<?php endif;?>

<script type="text/javascript">
	$(function() {
		var offset = $("#share-box").offset();
		var shareboxheight = $("#share-box").height();
		var offsetb = $("#register").offset();
		var khoangcachshare =$("#curvedContainer").height()-shareboxheight;
		var topPadding = 15;

		$(window).scroll(function() {
			if ($(window).scrollTop() > offset.top){

				if ($(window).scrollTop() < (khoangcachshare+566)){
					$("#share-box").stop().css({
						marginTop: $(window).scrollTop() - offset.top + topPadding
					});                    
				}else{
					$("#share-box").stop().css({
						marginTop: khoangcachshare-15
					});                     
				}
			}else {
				$("#share-box").stop().css({
					marginTop: 15
				});
			};
		});
	});
</script>

