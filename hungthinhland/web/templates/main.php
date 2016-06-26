  <div class="col-sm-12 col-md-9">
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
    <?php 
        $duan = new DUAN;
        $noithanh = $duan->getDuanNoiThanh(9);
        $ngoaithanh = $duan->getDuanNgoaiThanh(9);
    ?>
    <div class="box-content">
      <div class="box-content-top">
        <div class="title"><span>DỰ ÁN TẠI TP.HCM</span> <a href="du-an-tai-tp-hcm.html"><img style="float:right;" src="templates/images/btn-xemhet.jpg" width="73" height="31"></a>
        </div>
      </div>
      <div class="box-content-inside">
        <ul>
        <?php foreach ($noithanh as $v) : ?>
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

  <div class="box-content">
      <div class="box-content-top">
        <div class="title"><span>CÁC TỈNH THÀNH KHÁC</span> <a href="du-an-ngoai-tp-hcm.html"><img style="float:right;" src="templates/images/btn-xemhet.jpg" width="73" height="31"></a>
        </div>
      </div>
      <div class="box-content-inside">
        <ul>
        <?php foreach ($ngoaithanh as $v) : ?>
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
        <div class="clear"></div>
      </ul>
    </div>
  </div>

</div>

