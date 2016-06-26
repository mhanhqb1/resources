<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Thêm sản phẩm
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
            <form action="index.php?controller=product&action=add" method="POST" enctype="multipart/form-data">
				<div class="form-group">
                    <label>Tên sản phẩm:</label>
                    <input type="text" class="form-control" name="txtName" />
                </div>
                <div class="form-group">
                <label>Hình ảnh:</label>
                    <input type="file" name="fImage">
                </div>
                <div class="form-group">
                    <label>Giá:</label>
                    <input type="text" class="form-control" name="txtPrice" />
                </div>
				<div class="form-group">
                    <label>Giới thiệu</label>
                    <textarea name="txtDescription" class="form-control" rows="3"></textarea>
                </div>
				<div class="form-group">
                    <label>Thông tin chi tiết</label>
                    <textarea name="txtDetail" class="form-control" rows="10"></textarea>
                </div>
                <div class="form-group">
                    <label>Danh muc:</label>
                    <select name="cate" class="form-control">
                        <?php foreach ($cateData as $v): ?>
                            <option value="<?php echo $v['cate_id'];?>"><?php echo $v['cate_name'];?></option>
                        <?php endforeach;?>
                    </select>
                </div>
				<div class="form-group">
                    <label>Sản phẩm nổi bật: </label>
                    <label class="radio-inline">
                        <input name="rdoFeatured" value="1" checked="" type="radio">Có
                    </label>
                    <label class="radio-inline">
                        <input name="rdoFeatured" value="0" type="radio">Không
                    </label>
                </div>
                <div class="form-group">
                    <label>Hoạt động: </label>
                    <label class="radio-inline">
                        <input name="rdoActived" value="1" checked="" type="radio">Có
                    </label>
                    <label class="radio-inline">
                        <input name="rdoActived" value="0" type="radio">Không
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