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
            <?php echo show_status_process($this->session->flashdata('_status'),'Template', validation_errors()) ?>
            <div class="row">
                <form role="form" method="POST">
                    <div class="col-lg-6">
                        <div class="form-group<?php echo is_error(validation_errors()); ?>">
                            <label>Name</label>
                            <input class="form-control" type="text" id="name" name="txtName" value="<?php echo set_value('txtName') ?>" placeholder="Please enter the name of template" />
                        </div>
                        <div class="form-group">
                            <label>Preview</label>
                            <p>
                                <span class="btn btn-default disabled"><i class="fa fa-desktop"></i></span>
                                <span class="btn btn-default disabled"><i class="fa fa-tablet"></i></span>
                                <span class="btn btn-default disabled"><i class="fa fa-mobile"></i></span>
                        </div>
                    </div>
                    <div class="col-lg-6">                        
                        <div class="form-group">
                            <label>Status</label>
                            <span class="help-block">(If status is <span class="btn btn-success btn-xs">Active</span> In the campaigns can see this template)</span>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="txtStatus" value="1" <?php echo  set_radio('txtStatus', '1', TRUE); ?>><span class="btn btn-success btn-xs">Active</span>
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="txtStatus" value="0" <?php echo  set_radio('txtStatus', '0'); ?>><span class="btn btn-danger btn-xs">Disable</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Content</label>
                            <textarea id="myeditor" class="form-control" name="txtContent" rows="12"><?php echo set_value('txtContent') ?></textarea>
                            <!-- creating a CKEditor instance called myeditor -->
                            <script type="text/javascript">
                                CKEDITOR.replace('myeditor');
                            </script>
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