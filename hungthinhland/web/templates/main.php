<?php 
$duan = new DUAN;
$noithanh = $duan->getDuanNoiThanh(9);
$ngoaithanh = $duan->getDuanNgoaiThanh(9);
?>
<div class="container text-center">
  <div class="slideanim slide">
    <h2>DỰ ÁN TẠI TP.HCM</h2>
    <!-- <h4>What we have created</h4> -->
  </div>
  <div class="row text-center">
    <?php $i = 0; foreach ($noithanh as $v) : ?>
      <?php 
        $text = $v['title'];
        $text = convertURL($text);
        $i++;
      ?>
      <div class="col-sm-6 col-lg-4 slideanim <?php if ($i <= 3) echo 'slide'; ?>">
        <div class="thumbnail">
          <div class="thumb-img">
            <a href="duan-<?php echo $text.'-'.$v['duan_id'];?>.html" target="_blank">
              <img src="media/images/duan/<?php echo $v['image']; ?>" alt="$v['image']">
            </a>
            <div class="description">
              <p><?php echo $v['description'];?></p>
              <a class="btn" href="duan-<?php echo $text.'-'.$v['duan_id'];?>.html" target="_blank">
                  Xem chi tiet
              </a>
            </div>
          </div>        
        <p><strong><a href="duan-<?php echo $text.'-'.$v['duan_id'];?>.html"><?php echo $v['title'];?></a></strong></p>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</div>

<div class="container text-center bg-grey">
  <div class="slideanim">
    <h2>CÁC TỈNH THÀNH KHÁC</h2>
    <!-- <h4>What we have created</h4> -->
  </div>
  <div class="row text-center">
    <?php foreach ($ngoaithanh as $v) : ?>
      <?php 
        $text = $v['title'];
        $text = convertURL($text);
      ?>
      <div class="col-sm-6 col-lg-4 slideanim">
        <div class="thumbnail">
          <div class="thumb-img">
            <a href="duan-<?php echo $text.'-'.$v['duan_id'];?>.html" target="_blank">
              <img src="media/images/duan/<?php echo $v['image']; ?>" alt="$v['image']">
            </a>
            <div class="description">
              <p><?php echo $v['description'];?></p>
              <a class="btn" href="duan-<?php echo $text.'-'.$v['duan_id'];?>.html" target="_blank">
                  Xem chi tiet
              </a>
            </div>
          </div>        
        <p><strong><a href="duan-<?php echo $text.'-'.$v['duan_id'];?>.html"><?php echo $v['title'];?></a></strong></p>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</div>

	