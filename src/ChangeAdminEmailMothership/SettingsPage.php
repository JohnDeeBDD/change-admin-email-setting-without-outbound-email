<?php
wp_enqueue_script('jquery');
wp_enqueue_script('jquery-ui-core');
wp_enqueue_script('jquery-ui-datepicker');
wp_enqueue_style('jquery-ui-css', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');

?>
<style>
</style>
<div id = "wpbody" role = "main">
    <div id = "wpbody-content">
        <div class = "wrap">
            <h1>
                <?php _e('Mothership', ''); ?>
            </h1>
            <form method = "post" action = "/wp-admin/admin.php?page=mother-ship" id = "mother-ship-form">
            </form>
        </div>
        <!-- END: #wrap -->
    </div>
    <!-- END: #wpbody-content -->
</div>
<!-- END: #wpbody -->
