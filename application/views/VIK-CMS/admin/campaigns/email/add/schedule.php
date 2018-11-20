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
            <?php echo show_status_process($this->session->flashdata('_status'),'Schedule', validation_errors()) ?>
            <div class="row">
                <form role="form" method="POST">
                    <div class="campaign-header">
                        <div class="col-lg-8">
                            <ul class="creation-wizard">
                                <li class="creation-wizard-step done"><a href="/admin/campaign/email/add/setup/">Setup</a><i class="fa fa-chevron-right"></i></li>
                                <li class="creation-wizard-step done"><a href="/admin/campaign/email/add/message-design/">Design</a><i class="fa fa-chevron-right"></i></li>
                                <li class="creation-wizard-step done"><a href="/admin/campaign/email/add/recipients/">Recipients</a><i class="fa fa-chevron-right"></i></li>
                                <li class="creation-wizard-step done"><a href="/admin/campaign/email/add/confirmation/">Confirmation</a><i class="fa fa-chevron-right"></i></li>
                                <li class="creation-wizard-step active"><a href="/admin/campaign/email/add/schedule/">Schedule</a></li>
                            </ul>
                        </div>
                        <div class="col-lg-4">
                            <div class="pull-right"> 
                                <button type="submit" name="schedule" value="true" class="btn btn-primary pull-left">Schedule <i class="fa fa-clock-o"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="panel panel-default">
                            <div class="panel-heading text-center">
                                <h2>Schedule Campaign</h2>
                                <p class="help-block">Send your campaign now or schedule it in advance</p>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="schedule_type" value="now" checked="" /><strong>Send it now</strong>
                                        </label>
                                        <p class="help-block">Send your campaign now.</p>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="schedule_type" value="feature" disabled="" /><strong>Schedule for a specific time</strong>
                                        </label>
                                        <p class="help-block">Schedule your campaign to be sent in the future</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6"></div>
                </form>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>