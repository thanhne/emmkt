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
                    <div class="campaign-header">
                        <div class="col-lg-8">
                            <ul class="creation-wizard">
                                <li class="creation-wizard-step done"><a href="/admin/campaign/email/add/setup/">Setup</a><i class="fa fa-chevron-right"></i></li>
                                <li class="creation-wizard-step done"><a href="/admin/campaign/email/add/message-design/">Design</a><i class="fa fa-chevron-right"></i></li>
                                <li class="creation-wizard-step active"><a href="/admin/campaign/email/add/recipients/">Recipients</a><i class="fa fa-chevron-right"></i></li>
                                <li class="creation-wizard-step"><a href="/admin/campaign/email/add/confirmation/">Confirmation</a><i class="fa fa-chevron-right"></i></li>
                                <!-- <li class="creation-wizard-step"><a href="/admin/campaign/email/add/schedule/">Schedule</a></li> -->
                            </ul>
                        </div>
                        <div class="col-lg-4"><button type="submit" class="btn btn-success pull-right">Next Step <i class="fa fa-chevron-right"></i></button></div>
                    </div>
                    <div class="col-lg-12">
                        <p><strong><span id="num_select">0 </span>selected list</strong></p>
                        <div class="table-responsive table-bordered">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th width="5%"><input type="checkbox" name="group_ids[]" /></th>
                                        <th width="5%">ID</th>
                                        <th>Group Name</th>
                                        <th>No. Of Contacts</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php echo $checkbox; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>