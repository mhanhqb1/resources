<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Chỉnh sửa tin tuc
                </h1>
            </div>
            <?php if($err): ?>
               <div class="clearfix"></div>
               <?php foreach ($err as $value): ?>
                <div class="alert alert-danger">
                    <?php echo $value; ?>
                </div>
            <?php endforeach; ?>

        <?php endif;?>
        <!-- /.col-lg-12 -->
        <div class="col-lg-7" style="padding-bottom:120px">
            <form action="index.php?controller=tintuc&action=edit&id=<?php echo $data['news_id'];?>" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Tiêu đề:</label>
                    <input type="text" class="form-control" name="txtTitle" value="<?php echo $data['title'];?>"/>
                </div>
				<div class="form-label">
					<label>Hình ảnh cũ:</label>
                    <img src="../media/images/news/<?php echo $data['image'];?>" width="200">
                </div>
                <div class="form-label">
					<label>Hình ảnh mới:</label>
                    <input type="file" name="fNewImage"/>
                </div>
				<div class="form-group">
                    <label>Giới thiệu:</label>
                    <textarea name="txtDescription" class="form-control" rows="8"><?php echo $data['description'];?></textarea>
                </div>
				<div class="form-group">
                    <label>Nội dung:</label>
                    <textarea name="txtDetail" class="form-control" rows="15"><?php echo $data['detail'];?></textarea>
                </div>
                <div class="form-group">
                    <label>The loai: </label>
                    <label class="radio-inline">
                        <input name="rdoTintuc" value="1" <?php if($data['is_tintuc'] == 1) echo 'Checked'; ?> type="radio">Tin tuc
                    </label>
                    <label class="radio-inline">
                        <input name="rdoTintuc" value="0" <?php if($data['is_tintuc'] == 0) echo 'Checked'; ?> type="radio">Phong thuy
                    </label>
                </div>
                <div class="form-group">
                    <label>Nổi bật: </label>
                    <label class="radio-inline">
                        <input name="rdoFeatured" value="1" <?php if($data['is_featured'] == 1) echo 'Checked'; ?> type="radio">Có
                    </label>
                    <label class="radio-inline">
                        <input name="rdoFeatured" value="0" <?php if($data['is_featured'] == 0) echo 'Checked'; ?> type="radio">Không
                    </label>
                </div>
                <button type="submit" name="submit" class="btn btn-default">Chỉnh sửa</button>
                <button type="reset" class="btn btn-default">Làm lại</button>
                <form>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
        <!-- /#page-wrapper -->