<!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">User
                            <small>Add</small>
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
                        <form action="index.php?controller=user&action=add" method="POST">
                            <div class="form-group">
                                <label>Email:</label>
                                <input type="email" class="form-control" name="txtEmail" placeholder="Please Enter Email" />
                            </div>
                            <div class="form-group">
                                <label>Password:</label>
                                <input type="password" class="form-control" name="txtPass" placeholder="Please Enter Password" />
                            </div>
                            <div class="form-group">
                                <label>First Name:</label>
                                <input type="text" class="form-control" name="txtFirstName" placeholder="Please Enter First Name" />
                            </div>
                            <div class="form-group">
                                <label>Last Name:</label>
                                <input type="text" class="form-control" name="txtLastName" placeholder="Please Enter Last Name" />
                            </div>
                            <div class="form-group">
                                <label>Phone:</label>
                                <input type="number" class="form-control" name="txtPhone" placeholder="Please Enter Phone" />
                            </div>
                            <div class="form-group">
                                <label>User Level: </label>
                                <label class="radio-inline">
                                    <input name="rdoLevel" value="1" checked="" type="radio">Member
                                </label>
                                <label class="radio-inline">
                                    <input name="rdoLevel" value="2" type="radio">Admin
                                </label>
                            </div>
                            <button type="submit" name="submit" class="btn btn-default">Add User</button>
                            <button type="reset" class="btn btn-default">Reset</button>
                        <form>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->