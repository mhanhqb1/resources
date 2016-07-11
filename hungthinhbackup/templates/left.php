<div class="col-sm-12 col-md-3">

  <div class="box_sup_lienhe">
    <div class="support">
      <div class="title_support" style="color: red; font-weight: bold;">Hỗ trợ trực tuyến </div>
      <img src="templates/images/hotline12-4.gif" width="100%" height="152">
    </div>
    <div class="lienhe">
      <div class="title_1"><span>Liên hệ</span></div>
      <form action="lien-he.html" method="post">
        <input type="text" name="tenkhachhang" placeholder="Tên khách hàng" required="" />
        <input type="text" name="sodienthoai" placeholder="Số điện thoại" required="" />
        <textarea name="noidunglienhe" rows="7" placeholder="Nội dung liên hệ" required=""></textarea>
        <input class="btn btn-default" style="margin-bottom: 20px;" type="submit" name="lienhesubmit" value="Gửi"/>
      </form>
    </div>

  </div>
  <div class="box_right">
   <div class="box_right_top">
     <div class="title_1"><span>Tin tức và sự kiện</span><a href="tin-tuc.html"><img style="float:right;" src="templates/images/btn_xemhet_boxright.jpg" width="60" height="32"></a></div></div>

     <div class="content_tintuc">
      <ul>
        <?php
          $tintuc = new NEWS;
          $tinnoibat = $tintuc->getNewsFeatured();
          foreach ($tinnoibat as $v) :
        ?>
        <?php 
          $text = $v['title'];
          $text = convertURL($text);
        ?>
       <li style="display:inline"><a href="tintuc-<?php echo $text.'-'.$v['news_id'];?>.html"><?php echo $v['title'];?><span style="color: #666666;
         font-size: 11px;font-weight:normal;">(<?php echo date('d-m-Y', strtotime($v['post_time']));?>)</span></a> 
       </li>
     <?php endforeach; ?>
     </ul>
   </div>

 </div>
</div>
</div>
﻿


</div>