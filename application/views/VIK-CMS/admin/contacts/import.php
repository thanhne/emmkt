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
            <?php echo show_status_process($this->session->flashdata('_status'),'Import', $this->session->flashdata('flash_msg')) ?>
            <div class="row">
                <form role="form" method="POST" enctype="multipart/form-data">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>File input</label>
                            <input type="file" name="transfer_file" />
                            <p class="help-block">Select a file containing your contacts to import. .csv or .txt</p>
                            <p class="help-block"><i class="fa fa-question-circle"></i> <a class="m-r-sm res-popup" href="https://my.sendinblue.com/public/sample_csv/CSV_sample.csv">Download an example .csv file</a></p>
                            <p class="help-block"><i class="fa fa-question-circle"></i> <a class="m-r-sm res-popup" href="https://my.sendinblue.com/public/sample_csv/CSV_sample.csv">Download an example .txt file</a></p>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <button type="submit" name="submit" value="ok" class="btn btn-success">Submit</button>
                        <button type="reset" class="btn btn-danger">Reset</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>