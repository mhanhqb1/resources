<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Thêm thông tin liên hệ
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
            <form action="index.php?controller=lienhe&action=add" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Tên: </label>
                    <input name="name" type="text" class="form-control" />
                </div>
				<div class="form-group">
                    <label>Email: </label>
                    <input name="email" type="email" class="form-control" />
                </div>
				<div class="form-group">
                    <label>Số điện thoại: </label>
                    <input name="phone" type="text" class="form-control" />
                </div>
                <div class="form-group">
                    <label>Tong dai lien he: </label>
                    <input name="tongdailienhe" type="text" class="form-control" />
                </div>
				<div class="form-group">
                    <label>Địa chỉ: </label>
                    <input name="address" type="text" class="form-control" />
                </div>
                <div class="form-group">
                    <label>Yahoo: </label>
                    <input name="yahoo" type="text" class="form-control" />
                </div>
                <div class="form-group">
                    <label>Skype: </label>
                    <input name="skype" type="text" class="form-control" />
                </div>
				<div class="form-group">
                    <label>Facebook: </label>
                    <input name="facebook" type="text" class="form-control" />
                </div>
				<div class="form-group">
                    <label>Twitter: </label>
                    <input name="twitter" type="text" class="form-control" />
                </div>
				<div class="form-group">
                    <label>Intagram: </label>
                    <input name="intagram" type="text" class="form-control" />
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