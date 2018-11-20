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
                        <div class="pull-right"><a href="/admin/contact/group/add/" type="button" class="btn btn-success">Add a Group</a></div>
                        <!-- <div id="dataTables-example_filter" class="dataTables_filter">
                            <label>Search:<input type="search" class="form-control input-sm" placeholder="" /></label>
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
                                    <th class="sorting_asc" rowspan="1" colspan="1" style="width: 10%;">ID</th>
                                    <th class="sorting" rowspan="1" colspan="1" style="width: 50%;">NAME</th>
                                    <th class="sorting" rowspan="1" colspan="1" style="width: 15%;">TOTAL CONTACTS</th>
                                    <th class="sorting" rowspan="1" colspan="1" style="width: 15%;">MODIFIED DATE</th>
                                    <th rowspan="1" colspan="1" style="width: 15%;">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php   
                                if ($records) :
                                    foreach ($records as $item) :
                                ?>
                                    <tr class="gradeA odd" role="row">
                                        <td><?php echo '#'.$item->id ?></td>
                                        <td><a href="/admin/contact/group/edit/<?php echo $item->id ?>/"><?php echo $item->name ?></a></td>
                                        <td><a href="#"><?php echo total_contacts_by_group_id($item->id); ?></a></td>
                                        <td><?php echo $item->modified_date ?></td>
                                        <td class="text-center">
                                            <a href="/admin/contact/group/edit/<?php echo $item->id ?>/" class="btn btn-primary btn-xs">Edit</a>
                                            <a href="/admin/contact/group/delete/<?php echo $item->id ?>/" class="delete btn btn-danger btn-xs">Delete</a>
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
                <?php $this->load->view( AD_THEME.'/_partials/pagination',$pagination); ?>
            </div>
            <!-- /.table-responsive -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>