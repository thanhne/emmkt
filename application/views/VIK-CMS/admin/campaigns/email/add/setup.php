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
                                <ul class="creation-wizard">
                                <li class="creation-wizard-step active"><a href="/admin/campaign/email/add/setup/">Setup</a><i class="fa fa-chevron-right"></i></li>
                                <li class="creation-wizard-step"><a href="/admin/campaign/email/add/message-design/">Design</a><i class="fa fa-chevron-right"></i></li>
                                <li class="creation-wizard-step"><a href="/admin/campaign/email/add/recipients/">Recipients</a><i class="fa fa-chevron-right"></i></li>
                                <li class="creation-wizard-step"><a href="/admin/campaign/email/add/confirmation/">Confirmation</a><i class="fa fa-chevron-right"></i></li>
                                <!-- <li class="creation-wizard-step"><a href="/admin/campaign/email/add/schedule/">Schedule</a></li> -->
                            </ul>
                            </ul>
                        </div>
                        <div class="col-lg-4"><button type="submit" class="btn btn-success pull-right">Next Step <i class="fa fa-chevron-right"></i></button></div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Campaign Name</label>
                            <input class="form-control" type="text" id="campname" name="txtCampName" value="<?php echo set_value('txtCampName', isset($_setup['txtCampName']) ? $_setup['txtCampName'] : '') ?>" placeholder="Please enter the name of campaign" />
                            <p class="help-block">Give your campaign an internal name to help organize and locate it easily within your account. For example: 'Sale_October</p>
                        </div>
                        <div class="form-group">
                            <label>Subject</label>
                            <input class="form-control" type="text" id="subject" name="txtSubject" value="<?php echo set_value('txtSubject',isset($_setup['txtSubject']) ? $_setup['txtSubject'] : '') ?>" placeholder="Please enter the subject of campaign" />
                            <p class="help-block">Write a subject line that clearly describes your email content. It will be visible in your recipient's inbox and is the first content they will see. <br />For example: 'Private sale: 25% off our new collection</p>
                        </div>
                        <div class="form-group">
                            <label>From Email</label>
                            <select name="txtFromEmail" class="form-control">
                                <?php echo $from_mail ?>
                            </select>
                            <p class="help-block">
                                <span>Choose the email address to be shown in your recipients inbox when they receive your campaign or</span>
                               <a href="/admin/setting/#email-setting"><span>Edit From Mail</span></a>
                            </p>
                        </div>
                        <div class="form-group">
                            <label>From name</label>
                            <input class="form-control" type="text" id="fromname" name="txtFromName" value="<?php echo set_value('txtFromName', isset($_setup['txtFromName']) ? $_setup['txtFromName'] : '') ?>" placeholder="Please enter the From Name of campaign" />
                            <p class="help-block">Enter the email address where you want to receive replies from your contacts.</p>
                        </div>
                        <div class="form-group">
                            <label>Custom_reply to mail</label>
                            <input class="form-control" type="text" id="replyemail" name="txtReplyEmail" value="<?php echo set_value('txtReplyEmail', isset($_setup['txtReplyEmail']) ? $_setup['txtReplyEmail'] : '') ?>" placeholder="Please enter the Custom Email for Reply of campaign" />
                            <p class="help-block">Enter the email address where you want to receive replies from your contacts.</p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>