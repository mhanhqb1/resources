<div class="container banner_lienhe">
      <div id="supportTitle"><span>Tư vấn khách hàng</span></div>
            <div id="supportMan" class="row">
        <div class="col-xs-12">
        <?php if($phoneNumberData): foreach ($phoneNumberData as $v): ?>
          <div class="col-xs-6 item">
            <div class="supportTitle"><?php echo $v['name'];?></div>
            <div class="supportPhone"><?php echo $v['phone'];?></div>
          </div>
        <?php endforeach; endif;?>
        </div>
      </div>
            <div id="hotline247">Tổng đài hot:  <span><?php echo $contactData['tongdailienhe'];?></span></div>
</div>
<div class="clearfix"></div>
<div id="footer">
  <div id="footer-widget-area" class="footer-3c container">

    <div id="footer-first" class="footer-widgets-box col-sm-4">
      <div id="text-3" class="footer-widget widget_text"><div class="footer-widget-top"><h4>Thông tin</h4></div>
      <div class="footer-widget-container">     
        <div class="textwidget">- <?php echo $contactData['name'];?><br><br>
          - Trụ sở chính: 53 Trần Quốc Thảo, Phường 7, Quận 3, Tp. HCM
          <br><br>
          - Phòng giao dịch: <?php echo $contactData['address'];?>
          <br><br>- Liên hệ Hotline chủ đầu tư: <?php echo $contactData['phone'];?>
          <br><br>- Email: <?php echo $contactData['email'];?>
        </div>
      </div>
    </div> 
  </div>

  <div id="footer-second" class="footer-widgets-box col-sm-4">
    <div id="news-pic-widget-2" class="footer-widget news-pic">
      <div class="footer-widget-top">
        <h4>Dự án   </h4>
      </div>
      <?php
        $duan = new DUAN;
        $noithanh = $duan->getDuanNoiThanh();
      ?>
      <div class="footer-widget-container">  
      <?php foreach ($noithanh as $v) : ?>
          <?php 
            $text = $v['title'];
            $text = convertURL($text);
          ?>
        <div class="post-thumbnail">
          <a class="ttip" href="duan-<?php echo $text.'-'.$v['duan_id'];?>.html" original-title="<?php echo $v['title'];?>">
            <img width="55" height="55" src="media/images/duan/<?php echo $v['image'];?>" class="attachment-tie-small size-tie-small" alt="<?php echo $v['title'];?>" title="<?php echo $v['title'];?>" >
          </a>
        </div>
      <?php endforeach; ?>
      </div>
      <div class="clear"></div>
    </div>
  </div>


  <div id="footer-third" class="footer-widgets-box col-sm-4">
    <div id="text-4" class="footer-widget widget_text">
      <div class="footer-widget-top">
        <h4>Fanpage</h4>
      </div>
      <div class="footer-widget-container">     
        <div class="fb-page" data-href="<?php echo $contactData['facebook'];?>" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><div class="fb-xfbml-parse-ignore"><blockquote cite="<?php echo $contactData['facebook'];?>"><a href="<?php echo $contactData['facebook'];?>"></a></blockquote></div></div>
      </div>
    </div>
  </div>
  <a href="tel:0919889333" id="callnowbutton">&nbsp;</a>
  <div class="scroll-back-to-top-wrapper show">
    <span class="scroll-back-to-top-inner">
      <i class="fa fa-2x fa-arrow-circle-up" style="margin-top: 9px;"></i>
    </span>
  </div>


</div>
</div>

<div class="copyright-area">
    <span>Copyright &copy; 2013 HUNG THINH LAND. All rights reserved</span>
</div>

</div>
</body>
</html>