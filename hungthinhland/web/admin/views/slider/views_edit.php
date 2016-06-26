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
            <form action="index.php?controller=slider&action=edit&id=<?php echo $data['slider_id'];?>" method="POST" enctype="multipart/form-data">
                <div class="form-label">
					<label>Hình ảnh cũ:</label>
                    <img src="../media/images/sliders/<?php echo $data['image'];?>" width="200">
                </div>
                <div class="form-label">
                <label>Hình ảnh mới:</label>
                    <input type="file" name="fNewImage"/>
                </div>
                <div class="form-group">
                    <label>Link:</label>
                    <input type="text" class="form-control" name="txtLink" placeholder="Please Enter Link" value="<?php echo $data['link'];?>"/>
                </div>
                <div class="form-group">
                    <label>Vị trí:</label>
                    <input type="number" class="form-control" name="txtPosition" placeholder="Please Enter Position" value="<?php echo $data['position'];?>"/>
                </div>
                <div class="form-group">
                    <label>Hoạt động: </label>
                    <label class="radio-inline">
                        <input name="rdoActive" value="1" <?php if($data['is_actived'] == 1) echo 'Checked'; ?> type="radio">Có
                    </label>
                    <label class="radio-inline">
                        <input name="rdoActive" value="0" <?php if($data['is_actived'] == 0) echo 'Checked'; ?> type="radio">Không
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