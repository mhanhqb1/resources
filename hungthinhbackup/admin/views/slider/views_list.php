<!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Danh sách hình ảnh
                        </h1>
                    </div>
                    <!-- /.col-lg-12 -->
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr align="center">
                                <th>ID</th>
                                <th>Hình ảnh</th>
                                <th>Vị trí</th>
                                <th>Hoạt động</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($data): ?>
                                <?php foreach ($data as $v): ?>
                            <tr class="odd gradeX" align="center">
                                <td><?php echo $v['slider_id']; ?></td>
                                <td><img src="../media/images/sliders/<?php echo $v['image']; ?>" width="100"/></td>
                                <td><?php echo $v['position']; ?></td>
                                <td><?php if($v['is_actived'] == 1) echo 'Có'; else echo 'Không'; ?></td>
                                <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a onclick="return confirm('Bạn có muốn xóa hình ảnh này?')" href="index.php?controller=slider&action=del&id=<?php echo $v['slider_id'];?>">Xóa</a></td>
                                <td class="center"><i class="fa fa-pencil fa-fw"></i> <a href="index.php?controller=slider&action=edit&id=<?php echo $v['slider_id'];?>">Sửa</a></td>
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