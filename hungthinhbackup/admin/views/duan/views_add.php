<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Thêm dự án
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
            <form action="index.php?controller=duan&action=add" method="POST" enctype="multipart/form-data">
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
                    <textarea name="txtDescription" class="form-control" rows="8">sadsa</textarea>
                </div>
				<div class="form-group" style="display:none">
                    <label>Nội dung:</label>
                    <textarea name="txtDetail" class="form-control" rows="15">sads</textarea>
                </div>
				<div class="form-group">
                    <label>Giá:</label>
                    <input type="text" class="form-control" name="txtPrice" />
                </div>
				<div class="form-group">
                    <label>Vị trí hiển thị ở trang chủ:</label>
                    <input type="number" class="form-control" name="txtVitrihienthi" />
                </div>
				<div class="form-group">
                    <label>Thông tin:</label>
                    <textarea name="txtThongtin" class="form-control" rows="10"></textarea>
                </div>
				<div class="form-group">
                    <label>Vị trí:</label>
                    <textarea name="txtVitri" class="form-control" rows="10"></textarea>
                </div>
				<div class="form-group">
                    <label>Tiện ích:</label>
                    <textarea name="txtTienich" class="form-control" rows="10"></textarea>
                </div>
				<div class="form-group">
                    <label>Mặt bằng:</label>
                    <textarea name="txtMatbang" class="form-control" rows="10"></textarea>
                </div>
				<div class="form-group">
                    <label>Tin tức:</label>
                    <textarea name="txtTintuc" class="form-control" rows="10"></textarea>
                </div>
				<div class="form-group">
                    <label>Hình ảnh:</label>
                    <textarea name="txtHinhanh" class="form-control" rows="10"></textarea>
                </div>
                <div class="form-group">
                    <label>Nội thành: </label>
                    <label class="radio-inline">
                        <input name="rdoFeatured" value="1" checked="" type="radio">Có
                    </label>
                    <label class="radio-inline">
                        <input name="rdoFeatured" value="0" type="radio">Không
                    </label>
                </div>
                <div class="form-group">
                    <label>Dự án đầu tư: </label>
                    <label class="radio-inline">
                        <input name="rdoDautu" value="1" checked="" type="radio">Có
                    </label>
                    <label class="radio-inline">
                        <input name="rdoDautu" value="0" type="radio">Không
                    </label>
                </div>
                <div class="form-group">
                    <label>Dự án giá tốt: </label>
                    <label class="radio-inline">
                        <input name="rdoGiatot" value="1" checked="" type="radio">Có
                    </label>
                    <label class="radio-inline">
                        <input name="rdoGiatot" value="0" type="radio">Không
                    </label>
                </div>
                <div class="form-group">
                    <label>Dự án mới: </label>
                    <label class="radio-inline">
                        <input name="rdoMoi" value="1" checked="" type="radio">Có
                    </label>
                    <label class="radio-inline">
                        <input name="rdoMoi" value="0" type="radio">Không
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