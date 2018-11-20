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
            <?php echo show_status_process($this->session->flashdata('_status'),'Configuration', validation_errors()) ?>
            <div class="row">
                <form role="form" method="POST">
                    <div class="col-lg-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Email Setting
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label style="color: red">From Mail</label>
                                    <input type="text" name="txtSendFrom" class="form-control" value="<?php echo set_value('txtSendFrom',isset($item['mail_from']) ? $item['mail_from'] : '') ?>" placeholder="Please Enter Root Email" />
                                    <p class="help-block">This email will use in campaign example (<strong>marketing@domain.com</strong>) </p>
                                </div>

                                <div class="form-group">
                                    <label>Protocol</label>
                                    <input type="text" name="txtProtocol" class="form-control" value="<?php echo set_value('txtProtocol',isset($item['mail_protocol']) ? $item['mail_protocol'] : '') ?>" placeholder="The mail sending protocol." />
                                    <p class="help-block">Option: mail, sendmail, or smtp, (default: smtp)</p>
                                </div>
                                <div class="form-group">
                                    <label>Email Host</label>
                                    <div class="input-group-addon" style="width: 75%">
                                        <input type="text" name="txtEmailHost" class="form-control" value="<?php echo set_value('txtEmailHost',isset($item['mail_host']) ? $item['mail_host'] : '') ?>" placeholder="SMTP Server Address." />
                                    </div>
                                    <div class="input-group-addon" style="width: 25%">
                                        <input type="text" name="txtEmailPort" class="form-control" value="<?php echo set_value('txtEmailPort',isset($item['mail_port']) ? $item['mail_port'] : '') ?>" placeholder="PORT" />
                                    </div>
                                    <p class="help-block">Enter The Mail server address And Port Example: smtp.google.com and port: 465</p>
                                </div>
                                <div class="form-group">
                                    <label>Email Authentication</label>
                                    <div class="input-group-addon">
                                        <input type="text" name="txtEmailUsername" class="form-control" value="<?php echo set_value('txtEmailUsername',isset($item['mail_user']) ? $item['mail_user'] : '') ?>" placeholder="SMTP Username." />
                                    </div>
                                    <div class="input-group-addon">
                                        <input type="password" name="txtEmailPassword" class="form-control" value="<?php echo set_value('txtEmailPassword','') ?>" placeholder="**************" />
                                    </div>
                                    <p class="help-block">Enter Username and Password to authentication</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                API access (See Documentation)
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label>Request domain</label>
                                    <input type="text" name="txtRequestDomain" class="form-control" value="<?php echo set_value('txtRequestDomain',isset($item['api_domains']) ? $item['api_domains'] : '') ?>" placeholder="domain1.com,domain2.com" />
                                    <p class="help-block">Without http:// and www. example: bestprice.vn bestpricevn.com ..</p>
                                </div>
                                <div class="form-group">
                                    <label>Secret key</label>
                                    <input type="text" id="txtSecretKey" class="form-control disabledInput" value="<?php echo isset($item['api_secret']) ? $item['api_secret'] : '' ?>" disabled style="color: #f00" />
                                </div>
                                <div class="btn btn-success gen-secret-key">Generating a new Secret Key</div>
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