<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Chỉnh sửa so dien thoai lien he
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
            <form action="index.php?controller=phonenumber&action=edit&id=<?php echo $data['id'];?>" method="POST" enctype="multipart/form-data">
				<div class="form-group">
                    <label>Tên lien he: </label>
                    <input name="txtName" type="text" class="form-control" value="<?php echo $data['name'];?>"/>
                </div>
				<div class="form-group">
                    <label>So dien thoai: </label>
                    <input name="txtPhone" type="text" class="form-control" value="<?php echo $data['phone'];?>"/>
                </div>
				<div class="form-group">
                    <label>Vi tri: </label>
                    <input name="txtVitri" type="text" class="form-control" value="<?php echo $data['vitri'];?>"/>
                </div>
                <div class="form-group">
                    <label>Hiển thị ở form liên hệ: </label>
                    <label class="radio-inline">
                        <input name="rdoLienhe" value="1" <?php if($data['is_lienhe'] == 1) echo 'Checked'; ?> type="radio">Có
                    </label>
                    <label class="radio-inline">
                        <input name="rdoLienhe" value="0" <?php if($data['is_lienhe'] == 0) echo 'Checked'; ?> type="radio">Không
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