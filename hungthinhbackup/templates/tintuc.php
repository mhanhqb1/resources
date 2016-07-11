<?php
$id = '';
$action = isset($_GET['action']) ? $_GET['action'] : 0;
$modelName = !empty($action) ? 'tintuc' : 'phongthuy';
$subModelName = !empty($action) ? 'tin-tuc-trang' : 'phong-thuy-trang';
$news = new NEWS;
?>
<?php if (isset($_GET['id'])): ?>
	<?php
		$id = $_GET['id'];
		$data = $news->listOne($id);
	?>
	<div class="container chitietduan">
	<h1><?php echo $data['title'];?></h1>
	<?php echo $data['detail'];?>

<?php else:?>
	<?php 
		$data = $news->listAll($action);
		// Pagination
		$totalData = count($data);
		$limit = PAGE_LIMIT;
		$totalPage = ceil($totalData/$limit);
		$start = 0;
		if(isset($_GET['page'])){
			$start = ($_GET['page'] - 1)*$limit;
		}
		$data = pagination($start, $limit, $data);
	?>
	<div class="container">
        <div class="title_sub">
        	<h1>
        		<a>Tin tức và sự kiện</a>
        	</h1>
        </div>
        <div class="menu_tintuc">
            <ul>
            	<?php foreach ($data as $v): ?>
            		<?php 
			          	$text = $v['title'];
			          	$text = convertURL($text);
			        ?>
	            	<li>
	            		<a href="<?php echo $modelName;?>-<?php echo $text.'-'.$v['news_id'];?>.html">
	            			<img src="media/images/news/<?php echo $v['image'];?>" width="149" height="98">
	            		</a>
	            		<a href="<?php echo $modelName;?>-<?php echo $text.'-'.$v['news_id'];?>.html"><?php echo $v['title'];?></a>
	            		<h3>Ngày đăng: <?php echo date('d-m-Y', strtotime($v['post_time']));?></h3>
	            		<?php echo $v['description'];?>
	            	</li>
            	<?php endforeach;?>
            </ul>
    </div>
    <div class="paging" style="width:100%; margin:auto; margin-top:0px; text-align:center; float:left">
    	<span class="pages">
    		<ul>
    			<li style="line-height: 26px; font-weight: bold;">Trang: </li>
    			<?php for ($i=1;$i<=$totalPage;$i++): ?>
	                <li>
	                	<a <?php if(isset($_GET['page']) && $_GET['page'] == $i) echo 'class="page_cur"';?> href="<?php echo $subModelName;?>-<?php echo $i;?>.html"><?php echo $i?></a>
	                </li>
	            <?php endfor; ?>
    		</ul>
    	</span>
    </div>
<?php endif?>
<!-- <p>&nbsp;</p>
<p>———————————————————————————<br>
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
<p>&nbsp;</p>-->
</div>