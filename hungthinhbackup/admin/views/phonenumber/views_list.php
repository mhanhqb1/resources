<!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Quản lý so dien thoai lien he
						<a style="float:right" href="index.php?controller=phonenumber&action=add" class="btn btn-primary" role="button">Thêm mới</a>
                        </h1>
                    </div>
                    <!-- /.col-lg-12 -->
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr align="center">
                                <th>ID</th>
                                <th>Tên lien he</th>
								<th>So dien thoai</th>
								<th>Vi tri</th>
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
								<td><?php echo $v['phone']; ?></td>
								<td><?php echo $v['vitri']; ?></td>
                                <td><?php if($v['is_actived'] == 1) echo 'Có'; else echo 'Không'; ?></td>
                                <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a onclick="return confirm('Bạn có muốn xóa thông tin này?')" href="index.php?controller=phonenumber&action=del&id=<?php echo $v['id'];?>">Xóa</a></td>
                                <td class="center"><i class="fa fa-pencil fa-fw"></i> <a href="index.php?controller=phonenumber&action=edit&id=<?php echo $v['id'];?>">Sửa</a></td>
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