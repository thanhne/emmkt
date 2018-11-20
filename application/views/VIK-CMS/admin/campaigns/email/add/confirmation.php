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
            <?php echo show_status_process($this->session->flashdata('_status'),'Confirmation', validation_errors()) ?>
            <div class="row">
                <form role="form" method="POST">
                    <div class="campaign-header">
                        <div class="col-lg-8">
                            <ul class="creation-wizard">
                                <li class="creation-wizard-step done"><a href="/admin/campaign/email/add/setup/">Setup</a><i class="fa fa-chevron-right"></i></li>
                                <li class="creation-wizard-step done"><a href="/admin/campaign/email/add/message-design/">Design</a><i class="fa fa-chevron-right"></i></li>
                                <li class="creation-wizard-step done"><a href="/admin/campaign/email/add/recipients/">Recipients</a><i class="fa fa-chevron-right"></i></li>
                                 <li class="creation-wizard-step active"><a href="/admin/campaign/email/add/confirmation/">Confirmation</a><i class="fa fa-chevron-right"></i></li>
                               <!--  <li class="creation-wizard-step"><a href="/admin/campaign/email/add/schedule/">Schedule</a></li> -->
                            </ul>
                        </div>
                        <div class="col-lg-4">
                            <div class="pull-right"> 
                                <button type="submit" name="save_quit" value="true" class="btn btn-default pull-left" style="margin-right: 5px">Save & Quit <i class="fa fa-save"></i></button>
                                <button type="submit" name="save_send" value="true" class="btn btn-success pull-left" style="margin-right: 5px">Save & Send <i class="fa fa-send"></i></button>
                                <!-- <a  href="/admin/campaign/email/add/schedule/" class="btn btn-primary pull-left">Schedule <i class="fa fa-clock-o"></i></a> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 confirm">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="pull-left">
                                    <span class="btn btn-success btn-xs"><i class="fa fa-check"></i></span> <strong>Setup</strong>
                                </div>
                                <div class="pull-right">
                                    <a href="/admin/campaign/email/add/setup/">Return to this step</a>
                                </div>
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <p><strong>From: </strong>BestPrice Travel {thanhnb@bestprice.vn}</p> <!-- jusst test -->
                                <p><strong>Subject: </strong><?php echo isset($_SESSION['_setup']['txtSubject']) ? $_SESSION['_setup']['txtSubject'] : ''?></p>
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                               <div class="pull-left">
                                    <span class="btn btn-success btn-xs"><i class="fa fa-check"></i></span> <strong>Design</strong>
                                </div>
                                <div class="pull-right">
                                    <a href="/admin/campaign/email/add/message-design/">Return to this step</a>
                                </div>
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="col-lg-3">
                                    <div class="preview-thumbnail-box">
                                        <div class="thumbnail thumbnail-hover-white">
                                            <div style="background: #cccccc; height: 390px; width: 100%; text-align: center; font-weight: bold; font-size: 24px">
                                                <p style="line-height: 390px;">SCREENSHOTS</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <a href="#" class="btn btn-default pull-left disabled"><span>Send a test</span></a>
                                </div>
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="pull-left">
                                    <span class="btn btn-success btn-xs"><i class="fa fa-check"></i> </span> <strong>Recipients</strong>
                                </div>
                                <div class="pull-right">
                                    <a href="/admin/campaign/email/add/recipients/">Return to this step</a>
                                </div>
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <p>
                                    <label class="text-md"><span>Mailing lists: </span></label>
                                    <?php 
                                        if ($recipients_selected) {
                                            foreach ($recipients_selected as $item) {
                                                echo '<span class="text-md"><span>'. $item['name'] .'</span></span>, ';
                                            }
                                        }else {
                                            echo '<span class="text-md"><span>\'List(s)\' is missing</span></span>';
                                        }
                                    ?>
                                </p>
                            </div>
                            <!-- /.panel-body -->
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>