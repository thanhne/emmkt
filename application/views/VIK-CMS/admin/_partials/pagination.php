<div class="row">
    <div class="col-sm-6">
        <div class="dataTables_info" id="dataTables-example_info" role="status" aria-live="polite">
            Showing <?php echo $pagination['start'] ?> to <?php echo $pagination['end'] ?> of <?php echo $pagination['total_rows'] ?> entries
        </div>
    </div>
    <div class="col-sm-6">
        <div class="dataTables_paginate paging_simple_numbers" id="dataTables-example_paginate">
            <?php echo $pagination['results'] ?>
        </div>
    </div>
</div>
<br /><br /><br /><br /><br />