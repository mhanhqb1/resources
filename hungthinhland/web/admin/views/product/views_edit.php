<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Chỉnh sửa hình ảnh
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
            <form action="index.php?controller=product&action=edit&id=<?php echo $data['products_id'];?>" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Tên sản phẩm:</label>
                    <input type="text" class="form-control" name="txtName" value="<?php echo $data['name'];?>"/>
                </div>
				<div class="form-label">
                <label>Hình ảnh cũ:</label>
                    <img src="../media/images/products/<?php echo $data['image'];?>" width="200">
                </div>
                <div class="form-label">
                <label>Hình ảnh mới:</label>
                    <input type="file" name="fNewImage"/>
                </div>
                <div class="form-group">
                    <label>Giá:</label>
                    <input type="text" class="form-control" name="txtPrice" value="<?php echo $data['price'];?>"/>
                </div>
				<div class="form-group">
                    <label>Giới thiệu</label>
                    <textarea name="txtDescription" class="form-control" rows="3"><?php echo $data['description'];?></textarea>
                </div>
				<div class="form-group">
                    <label>Thông tin chi tiết</label>
                    <textarea name="txtDetail" class="form-control" rows="10"><?php echo $data['detail'];?></textarea>
                </div>
                <div class="form-group">
                    <label>Danh muc:</label>
                    <select name="cate" class="form-control">
                        <?php foreach ($cateData as $v): ?>
                            <?php if($data['cate_id'] == $v['cate_id']):?>
                                <option value="<?php echo $v['cate_id'];?>" selected><?php echo $v['cate_name'];?></option>
                            <?php else:?>
                                <option value="<?php echo $v['cate_id'];?>"><?php echo $v['cate_name'];?></option>
                            <?php endif;?>
                        <?php endforeach;?>
                    </select>
                </div>
				<div class="form-group">
                    <label>Sản phẩm nổi bật: </label>
                    <label class="radio-inline">
                        <input name="rdoFeatured" value="1" <?php if($data['is_featured'] == 1) echo 'Checked'; ?> type="radio">Có
                    </label>
                    <label class="radio-inline">
                        <input name="rdoFeatured" value="0" <?php if($data['is_featured'] == 0) echo 'Checked'; ?> type="radio">Không
                    </label>
                </div>
                <div class="form-group">
                    <label>Hoạt động: </label>
                    <label class="radio-inline">
                        <input name="rdoActived" value="1" <?php if($data['is_actived'] == 1) echo 'Checked'; ?> type="radio">Có
                    </label>
                    <label class="radio-inline">
                        <input name="rdoActived" value="0" <?php if($data['is_actived'] == 0) echo 'Checked'; ?> type="radio">Không
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