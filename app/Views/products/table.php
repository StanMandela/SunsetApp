<?php include(APPPATH . 'Views/template/header.php'); ?>
<?php include(APPPATH . 'Views/template/side-bar.php'); ?>

<!--**********************************
            Content body start
        ***********************************-->
<div id="app" class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>{{message}}</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Table</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Datatable</a></li>
                </ol>
            </div>
        </div>
        <!-- row -->
     

        <div class="row">
            <div   class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Products Datatable</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product Name</th>
                                        <th>Description</th>
                                        <th>Item Type</th>
                                        <th>Created At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <tr v-for="product,index in products" :key="product.id">
                                  <td>{{ index+1 }}</td>
                                  <td>{{ product.product_name }}</td>
                                  <td>{{ product.description }}</td>
                                  <td>{{ product.item_type }}</td>
                                  <td>{{ product.created_at }}</td>
                                  </tr>
                                  
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Product Name</th>
                                        <th>Description</th>
                                        <th>Item Type</th>
                                        <th>Created At</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
         
        </div>
    </div>
</div>
<!--**********************************
            Content body end
        ***********************************-->

 <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
<script type="text/javascript" src="../../assets/vue/appVue.js"></script>
<?php include(APPPATH . 'Views/template/footer.php'); ?>