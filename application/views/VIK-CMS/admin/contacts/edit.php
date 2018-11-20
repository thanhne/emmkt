<div id="page-wrapper" style="min-height: 365px;">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?php echo $meta['title'] ?></h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <?php echo show_status_process($this->session->flashdata('_status'),'contact', validation_errors()) ?>
            <div class="row">
                <form role="form" method="POST">
                    <div class="col-lg-6">
                        <div class="form-group<?php echo is_error(validation_errors()); ?>">
                            <label>Email</label>
                            <input class="form-control" type="text" id="email" name="txtEmail" value="<?php echo set_value('txtEmail',$item['email']) ?>" placeholder="Please enter email" />
                        </div>
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input class="form-control" type="text" id="phone" name="txtPhone" value="<?php echo set_value('txtPhone',$item['phone']) ?>" placeholder="Please enter phone number" />
                        </div>
                        <div class="form-group">
                            <label>First Name</label>
                            <input class="form-control" type="text" id="fname" name="txtFname" value="<?php echo set_value('txtFname',$item['first_name']) ?>" placeholder="Please enter first name" />
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input class="form-control" type="text" id="lname" name="txtLname" value="<?php echo set_value('txtLname',$item['last_name']) ?>" placeholder="Please enter last name" />
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Import to the selected lists
                            </div>
                            <div class="panel-body pre-scrollable">
                                <div class="form-group">
                                    <?php echo $groups; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <button type="submit" class="btn btn-success">Submit</button>
                        <button type="reset" class="btn btn-danger">Reset</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>