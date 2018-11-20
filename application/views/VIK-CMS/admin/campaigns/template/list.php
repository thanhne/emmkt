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
                        <div class="pull-right"><a href="/admin/campaign/template/add/" type="button" class="btn btn-success">Add a Template</a></div>
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
                                    <th class="text-center" style="width: 5%">ID</th>
                                    <th class="sorting" rowspan="1" colspan="1" style="width: 40%;">NAME</th>
                                    <th class="" rowspan="1" colspan="1" style="width: 10%;">STATUS</th>
                                    <th rowspan="1" colspan="1" style="width: 20%;">LAST CHANGED</th>
                                    <th rowspan="1" colspan="1" style="width: 20%;">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php   
                                    if ($records) :
                                        foreach ($records as $item) :
                                ?>
                                            <tr class="gradeA odd" role="row">
                                                <td class="text-center"><input type="checkbox" name="checks[]" /></td>
                                                <td class="text-center"><?php echo $item->id ?></td>
                                                <td><a href="/admin/campaign/template/edit/<?php echo $item->id ?>/"><?php echo $item->name ?></a></td>
                                                <td class="text-center"><?php echo is_status($item->status) ?></td>
                                                <td><?php echo $item->date ?></td>
                                                <td class="text-center">
                                                    <a href="/admin/campaign/template/edit/<?php echo $item->id ?>/" class="btn btn-primary btn-xs">Edit</a>
                                                    <a href="/admin/campaign/template/delete/<?php echo $item->id ?>/" class="delete btn btn-danger btn-xs">Delete</a>
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