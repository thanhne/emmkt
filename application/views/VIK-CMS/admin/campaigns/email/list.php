<div id="page-wrapper" style="min-height: 365px;">
    <div class="row">
        <div class="col-lg-12">
            <h1><?php echo $meta['title'] ?></h1>
            <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="dataTables_length" id="dataTables-limit">
                            <?php is_selected($pagination['limit']); ?>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="pull-right"><a href="/admin/campaign/email/add/setup/" type="button" class="btn btn-success">Add an email campaign</a></div>
                        <!-- <div id="dataTables-example_filter" class="dataTables_filter">
                            <label>Search:<input type="search" class="form-control input-sm" placeholder="" aria-controls="dataTables-example"></label>
                        </div> -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                            <?php 
                                echo show_flashdata($this->session->flashdata('flash_msg'));
                            ?>
                            <thead>
                                <tr role="row">
                                    <th class="text-center" rowspan="1" colspan="1" style="width: 5%;">
                                        <input type="checkbox" name="checks[]" />
                                    </th>
                                    <th rowspan="1" colspan="1" style="width: 42%;">Campaigns</th>
                                    <th rowspan="1" colspan="1" style="width: 5%;">Status</th>
                                    <th rowspan="1" colspan="1" style="width: 12%;">Recipients</th>
                                    <th rowspan="1" colspan="1" style="width: 12%;">Openers</th>
                                    <th rowspan="1" colspan="1" style="width: 12%;">Clickers</th>
                                    <th rowspan="1" colspan="1" style="width: 12%;">Unsub</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php   
                                    if ($records) :
                                        foreach ($records as $item) :
                                ?>
                                            <tr class="gradeA odd" role="row">
                                                <td class="text-center"><input type="checkbox" name="checks[]" /></td>
                                                <td camp="id">
                                                    <p>
                                                        <a href="#"><?php echo $item->name ?></a>
                                                        <br />
                                                         <span class="text-muted"><?php echo '#'.$item->id ?> <strong>sent</strong> On 21 Nov 2018, 06:32 PM</span>
                                                    </p>
                                                   
                                                    <p class="start-stop">                                                        
                                                        <a camp_id="<?php echo $item->id ?>" class="btn btn-success btn-xs">Start</a>
                                                        <!-- <a class="btn btn-danger btn-xs">Stop</a> -->
                                                    </p>
                                                    <!-- <p> 
                                                        <a href="/admin/contact/edit/<?php echo $item->id ?>/" class="btn btn-outline btn-success btn-xs">Report</a>
                                                        <a href="/admin/contact/edit/<?php echo $item->id ?>/" class="btn btn-outline btn-primary btn-xs">Preview</a>
                                                        <a href="/admin/contact/edit/<?php echo $item->id ?>/" class="btn btn-outline btn-success btn-xs">Edit</a>
                                                        <a href="/admin/contact/edit/<?php echo $item->id ?>/" class="btn btn-outline btn-success btn-xs">Send a test</a>
                                                        <a href="/admin/contact/edit/<?php echo $item->id ?>/" class="btn btn-outline btn-success btn-xs">Duplicate</a>
                                                    </p> -->
                                                </td>
                                                <td class="text-center"><?php echo is_status($item->status) ?></td>
												<td>
													<p><b>16,423</b></p>
													<p>100%</p>
												</td>
												<td>
													<p style="color: #66d2dc"><b>364</b></p>
													<p>2.22%</p>
												</td>
												<td>
													<p style="color: #9cc980"><b>74</b></p>
													<p>0.45%</p>
												</td>
												<td>
													<p style="color: #f3bb94"><b>1</b></p>
													<p>0.01%</p>
												</td>
                                            </tr>
                                <?php 
                                        endforeach;
                                    endif;
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php 
                    $this->load->view( AD_THEME.'/_partials/pagination',$pagination); 
                    //$pagination is array from controller
                ?>
            </div>
            <!-- /.table-responsive -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>