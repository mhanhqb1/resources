<!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Quản lý thông tin liên hệ
						<a style="float:right" href="index.php?controller=lienhe&action=add" class="btn btn-primary" role="button">Thêm mới</a>
                        </h1>
                    </div>
                    <!-- /.col-lg-12 -->
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr align="center">
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
								<th>Số điện thoại</th>
                                <th>Địa chỉ</th>
                                <th>Facebook</th>
                                <th>Tong dai lien he</th>
								<th>Hoạt động</th>
                                <th></th>
								<th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($data): ?>
                                <?php foreach ($data as $v): ?>
                            <tr class="odd gradeX" align="center">
                                <td><?php echo $v['id']; ?></td>
                                <td><?php echo $v['name']; ?></td>
                                <td><?php echo $v['email']; ?></td>
								<td><?php echo $v['phone']; ?></td>
								<td><?php echo $v['address']; ?></td>
                                <td><?php echo $v['facebook']; ?></td>
                                <td><?php echo $v['tongdailienhe']; ?></td>
                                <td><?php if($v['is_actived'] == 1) echo 'Có'; else echo 'Không'; ?></td>
                                <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a onclick="return confirm('Bạn có muốn xóa thông tin này?')" href="index.php?controller=lienhe&action=del&id=<?php echo $v['id'];?>">Xóa</a></td>
                                <td class="center"><i class="fa fa-pencil fa-fw"></i> <a href="index.php?controller=lienhe&action=edit&id=<?php echo $v['id'];?>">Sửa</a></td>
                            </tr>
                                <?php endforeach;?>
                            <?php endif;?>
                        </tbody>
                    </table>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->