<?php 	
	$this->load->view('VIK-CMS/admin/_partials/header');
?>
<div id="wrapper">
<?php 
    $this->load->view('VIK-CMS/admin/_partials/navigation');
    /**
     * Load master layout
     */
    $this->load->view($subview); 
?>
</div>
<!-- /#wrapper -->
<?php
    $this->load->view('VIK-CMS/admin/_partials/footer');
?>