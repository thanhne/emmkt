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
                                <li class="creation-wizard-step active"><a href="/admin/campaign/email/add/message-design/">Design</a><i class="fa fa-chevron-right"></i></li>
                                <li class="creation-wizard-step"><a href="/admin/campaign/email/add/recipients/">Recipients</a><i class="fa fa-chevron-right"></i></li>
                                <li class="creation-wizard-step"><a href="/admin/campaign/email/add/confirmation/">Confirmation</a><i class="fa fa-chevron-right"></i></li>
                                <!-- <li class="creation-wizard-step"><a href="/admin/campaign/email/add/schedule/">Schedule</a></li> -->
                            </ul>
                        </div>
                        <div class="col-lg-4"><button type="submit" class="btn btn-success pull-right">Next Step <i class="fa fa-chevron-right"></i></button></div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Choose message template</label>
                            <select class="form-control" name="txtTemplate">
                                <option value="">Default</option>
                                <?php echo $option; ?>
                            </select>
                            <p class="help-block">
                                <span>Choose the email address to be shown in your recipients inbox when they receive your campaign or</span>
                                <a href="#"><span>Add a new sender</span></a>
                            </p>
                        </div>
                        <div class="design-action">
                            <div class="pull-left">
                                <div class="device">
                                    <span class="btn btn-default disabled"><i class="fa fa-desktop"></i></span>
                                    <span class="btn btn-default disabled"><i class="fa fa-tablet"></i></span>
                                    <span class="btn btn-default disabled"><i class="fa fa-mobile"></i></span>
                                </div>
                                <div class="rotate">
                                    <span class="btn btn-default disabled"><i class="fa fa-rotate-left"></i> Rotate</span>
                                </div>
                            </div>
                            <div class="pull-right">
                                <div class="edit">
                                    <a href="#" class="btn btn-default" disabled>Edit the email content</a>
                                    <a href="#" class="btn btn-default" disabled onclick="vik.alert_msg('Coming soon')">Send a test</a>
                                </div>
                            </div>
                        </div>
                        <div class="preview">
                            <div class="meta-header">
                                <p><strong>From: </strong><?php echo isset($_setup['txtFromName']) ? $_setup['txtFromName'] : '' ?> {<?php echo isset($_setup['txtFromEmail']) ? $_setup['txtFromEmail'] : '' ?>}</p> <!-- jusst test -->
                                <p><strong>Subject: </strong><?php echo isset($_setup['txtSubject']) ? $_setup['txtSubject'] : '' ?></p>
                            </div>
                            <div class="content">
                                <h1>Coming Soon</h1>
                                <!-- <iframe id="previewContentIframe" frameborder="0" src="https://my.sendinblue.com/camp/showpreview/id/118" style="width: 100%; min-height: 300px; height: 1579px; display: block; margin: 0px auto;" __idm_frm__="2338"></iframe> -->
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>