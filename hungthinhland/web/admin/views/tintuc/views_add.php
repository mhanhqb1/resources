<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Thêm tin tức
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
            <form action="index.php?controller=tintuc&action=add" method="POST" enctype="multipart/form-data">
				<div class="form-group">
                    <label>Tiêu đề:</label>
                    <input type="text" class="form-control" name="txtTitle" />
                </div>
				<div class="form-label">
					<label>Hình ảnh:</label>
                    <input type="file" name="fImage">
                </div>
                <div class="form-group">
                    <label>Giới thiệu:</label>
                    <textarea name="txtDescription" class="form-control" rows="8"></textarea>
                </div>
				<div class="form-group">
                    <label>Nội dung:</label>
                    <textarea name="txtDetail" class="form-control" rows="15"></textarea>
                </div>
                <div class="form-group">
                    <label>Thể loại: </label>
                    <label class="radio-inline">
                        <input name="rdoTintuc" value="1" checked="" type="radio">Tin tức
                    </label>
                    <label class="radio-inline">
                        <input name="rdoTintuc" value="0" type="radio">Phong thủy
                    </label>
                </div>
                <div class="form-group">
                    <label>Nổi bật: </label>
                    <label class="radio-inline">
                        <input name="rdoFeatured" value="1" checked="" type="radio">Có
                    </label>
                    <label class="radio-inline">
                        <input name="rdoFeatured" value="0" type="radio">Không
                    </label>
                </div>
                <button type="submit" name="submit" class="btn btn-default">Thêm</button>
                <button type="reset" class="btn btn-default">Làm lại</button>
                <form>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
        <!-- /#page-wrapper -->