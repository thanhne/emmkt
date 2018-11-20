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
                        <div class="pull-right"><a href="/admin/contact/add/" type="button" class="btn btn-success">Add a Contact</a></div>
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
                                    <th rowspan="1" colspan="1" style="width: 3%;">
                                        <input type="checkbox" name="checks[]" />
                                    </th>
                                    <th class="sorting" colspan="1" style="width: 27%;">EMAIL</th>
                                    <th class="sorting" rowspan="1" colspan="1" style="width: 10%;">NAME</th>
                                    <th class="sorting" rowspan="1" colspan="1" style="width: 10%;">FTNAME</th>
                                    <th class="" rowspan="1" colspan="1" style="width: 10%;">STATUS</th>
                                    <th class="sorting" rowspan="1" colspan="1" style="width: 15%;">LAST CHANGED</th>
                                    <!-- <th class="sorting" rowspan="1" colspan="1" style="width: 15%;">DATE ADDED</th>  -->
                                    <th class="sorting" rowspan="1" colspan="1" style="width: 15%;">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php   
                                    if ($records) :
                                        foreach ($records as $item) :
                                ?>
                                            <tr class="gradeA odd" role="row">
                                                <td class="text-center"><input type="checkbox" name="checks[]" /></td>
                                                <td><a href="/admin/contact/edit/<?php echo $item->id ?>/"><?php echo $item->email ?></a></td>
                                                <td><?php echo $item->last_name ?></td>
                                                <td><?php echo $item->first_name ?></td>
                                                <td class="text-center">
                                                    <?php echo is_status($item->status) ?>
                                                </td>
                                                <td><?php echo $item->modified_date ?></td>
                                                <!-- <td><?php echo $item->create_date ?></td> -->
                                                <td class="text-center">
                                                    <a href="/admin/contact/edit/<?php echo $item->id ?>/" class="btn btn-primary btn-xs">Edit</a>
                                                    <a href="/admin/contact/delete/<?php echo $item->id ?>/" class="delete btn btn-danger btn-xs">Delete</a>
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