 
    <?php $this->load->view("template/header",array('title' => $title, 'description' => $description)); ?>
    <?php $this->load->view("template/side-bar"); ?>

    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <?php $this->load->view($main); ?>
        </div>
        <!-- END CONTENT BODY -->
    </div>
    <!-- END CONTENT -->

    <?php $this->load->view("template/footer"); ?>