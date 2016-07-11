<!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Quản lý danh mục
						<a style="float:right" href="index.php?controller=cate&action=add" class="btn btn-primary" role="button">Thêm mới</a>
                        </h1>
                    </div>
                    <!-- /.col-lg-12 -->
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr align="center">
                                <th>ID</th>
                                <th>Tên danh mục</th>
                                <th></th>
								<th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($data): ?>
                                <?php foreach ($data as $v): ?>
                            <tr class="odd gradeX" align="center">
                                <td><?php echo $v['cate_id']; ?></td>
                                <td><?php echo $v['cate_name']; ?></td>
                                <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a onclick="return confirm('Bạn có muốn xóa thông tin này?')" href="index.php?controller=cate&action=del&id=<?php echo $v['cate_id'];?>">Xóa</a></td>
                                <td class="center"><i class="fa fa-pencil fa-fw"></i> <a href="index.php?controller=cate&action=edit&id=<?php echo $v['cate_id'];?>">Sửa</a></td>
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