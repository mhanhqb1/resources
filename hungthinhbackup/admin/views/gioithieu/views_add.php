<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Thêm trang giới thiệu
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
            <form action="index.php?controller=gioithieu&action=add" method="POST" enctype="multipart/form-data">
				<div class="form-group">
                    <label>Nội dung: </label>
                    <textarea name="content" class="form-control" rows="15"></textarea>
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