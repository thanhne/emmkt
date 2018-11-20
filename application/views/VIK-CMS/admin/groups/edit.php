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
            <?php echo show_status_process($this->session->flashdata('_status'),'Contact Groups', validation_errors()) ?>
            <div class="row">
                <form role="form" method="POST">
                    <div class="col-lg-6">
                        <div class="form-group<?php echo is_error(validation_errors()); ?>">
                            <label>Group Name</label>
                            <input class="form-control" type="text" name="txtName" value="<?php echo set_value('txtName',$item['name']) ?>" placeholder="Group name" />
                        </div>
                        <button type="submit" class="btn btn-primary">OK</button>
                        <button type="reset" class="btn btn-danger">Reset</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>