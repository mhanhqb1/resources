<!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Danh sách sản phẩm
                        <a style="float:right" href="index.php?controller=product&action=add" class="btn btn-primary" role="button">Thêm mới</a>
                        </h1>
                    </div>
                    <!-- /.col-lg-12 -->
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr align="center">
                                <th>ID</th>
                                <th>Tên Sản phẩm</th>
                                <th>Hình ảnh</th>
                                <th>Giá</th>
								<th>Mô tả</th>
                                <th>Danh muc</th>
								<th>Sản phẩm nổi bật</th>
								<th>Hoạt động</th>
                                <th></th>
								<th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($data): ?>
                                <?php foreach ($data as $v): ?>
                            <tr class="odd gradeX" align="center">
                                <td><?php echo $v['products_id']; ?></td>
								<td><?php echo $v['name']; ?></td>
                                <td><img src="../media/images/products/<?php echo $v['image']; ?>" width="100"/></td>
                                <td><?php echo $v['price']; ?></td>
                                <td><?php echo $v['description']; ?></td>
                                <td><?php echo $v['cate_name']; ?></td>
								<td><?php if($v['is_featured'] == 1) echo 'Có'; else echo 'Không'; ?></td>
                                <td><?php if($v['is_actived'] == 1) echo 'Có'; else echo 'Không'; ?></td>
                                <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a onclick="return confirm('Bạn có muốn xóa sản phẩm này?')" href="index.php?controller=product&action=del&id=<?php echo $v['products_id'];?>">Xóa</a></td>
                                <td class="center"><i class="fa fa-pencil fa-fw"></i> <a href="index.php?controller=product&action=edit&id=<?php echo $v['products_id'];?>">Sửa</a></td>
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