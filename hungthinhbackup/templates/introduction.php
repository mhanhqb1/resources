<div id="breadcrumb">
    <div class="container">	
        <div class="breadcrumb">							
            <li><a href="index.php">Trang chủ</a></li>
            <li>Giới thiệu</li>			
        </div>		
    </div>	
</div>
<div class="container lienhe">
	<div class="row">
		<div class="col-xs-12">
			<?php 
				$intro = new INTRODUCTION;
				echo $intro->getIntroContent();
			?>
		</div>
	</div>
</div>