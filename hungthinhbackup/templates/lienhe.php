<?php
$mess = '';
if (isset($_POST['lienhesubmit'])) {
    $name = $_POST['tenkhachhang'];
    $phone = $_POST['sodienthoai'];
    $message = $_POST['noidunglienhe'];
    $postTime = date("Y-m-d H:i:s");
    $req = new REQUEST;
    $req->setName($name);
    $req->setPhone($phone);
    $req->setMessage($message);
    $req->setPostTime($postTime);
    $req->insert();
    $mess = "Cảm ơn <strong>$name</strong> đã liên hệ, chúng tôi sẽ trả lời tin nhắn của bạn sớm nhất có thể.";
}
?>
<div class="container chitietduan">
<div class="post-inner">
				<h1 class="name post-title entry-title" itemprop="itemReviewed" itemscope="" itemtype="http://schema.org/Thing"><span itemprop="name">Liên hệ</span></h1>
				<p class="post-meta"></p>
				<div class="clear"></div>
				<?php if($mess): ?>
			        <div class="alert alert-success">
			          <strong><?php echo $mess;?></strong> 
			        </div>
			    <?php endif;?>
				<div class="entry">
					
					<h3><span style="color: #008000;"><?php echo $contactData['name'];?></span></h3>
<p><span style="color: #0000ff;"><strong>Trụ sở chính :&nbsp;53 Trần Quốc Thảo, P7, Quận 3, TP.HCM</strong></span></p>
<p><span style="color: #0000ff;"><strong>Phòng giao dịch : <?php echo $contactData['address'];?></strong></span></p>
<p><span style="color: #0000ff;"><strong>Liên hệ Hotline Chủ đầu tư: <?php echo $contactData['phone'];?></strong></span></p>
<p><span style="color: #0000ff;"><strong>Email: <?php echo $contactData['email'];?></strong></span></p>
<h3></h3>
										
					
									</div><!-- .entry /-->	
				
								
			</div>
</div>