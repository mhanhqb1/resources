<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Chỉnh sửa thông tin liên hệ
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
            <form action="index.php?controller=lienhe&action=edit&id=<?php echo $data['id'];?>" method="POST" enctype="multipart/form-data">
				<div class="form-group">
                    <label>Tên: </label>
                    <input name="name" type="text" class="form-control" value="<?php echo $data['name'];?>"/>
                </div>
				<div class="form-group">
                    <label>Email: </label>
                    <input name="email" type="email" class="form-control" value="<?php echo $data['email'];?>" />
                </div>
				<div class="form-group">
                    <label>Số điện thoại: </label>
                    <input name="phone" type="text" class="form-control" value="<?php echo $data['phone'];?>"/>
                </div>
                <div class="form-group">
                    <label>Tong dai lien he: </label>
                    <input name="tongdailienhe" type="text" class="form-control" value="<?php echo $data['tongdailienhe'];?>"/>
                </div>
				<div class="form-group">
                    <label>Địa chỉ: </label>
                    <input name="address" type="text" class="form-control" value="<?php echo $data['address'];?>"/>
                </div>
                <div class="form-group">
                    <label>Yahoo: </label>
                    <input name="yahoo" type="text" class="form-control" value="<?php echo $data['yahoo'];?>"/>
                </div>
                <div class="form-group">
                    <label>Skype: </label>
                    <input name="skype" type="text" class="form-control" value="<?php echo $data['skype'];?>"/>
                </div>
				<div class="form-group">
                    <label>Facebook: </label>
                    <input name="facebook" type="text" class="form-control" value="<?php echo $data['facebook'];?>"/>
                </div>
				<div class="form-group">
                    <label>Twitter: </label>
                    <input name="twitter" type="text" class="form-control" value="<?php echo $data['twitter'];?>"/>
                </div>
				<div class="form-group">
                    <label>Intagram: </label>
                    <input name="intagram" type="text" class="form-control" value="<?php echo $data['intagram'];?>"/>
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