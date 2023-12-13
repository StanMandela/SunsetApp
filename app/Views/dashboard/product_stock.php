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
        <!-- Toastr -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <button type="button" class="btn btn-rounded btn-info" data-toggle="modal" data-target=".bd-example-modal-lg"><span class="btn-icon-left text-info">
                                <i class="fa fa-plus color-info"></i>
                            </span>Add Product Stock</button>
                            <button type="button" class="btn btn-rounded btn-info"  @click="calculateStock"><span class="btn-icon-left text-info">
                                <i class="fa fa-plus color-info"></i>
                            </span>Calculate Stock Value</button>
                            <button type="button" class="btn btn-rounded btn-info" data-toggle="modal" data-target="#uploadRecipt" ><span class="btn-icon-left text-info">
                                <i class="fa fa-plus color-info"></i>
                            </span>Upload Receipts</button>
                    </div>
                </div>
            </div>
        </div>
    
   
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Products Stock</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                        <table id="example2" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product Name</th>
                                        <th>Quantity</th>
                                        <th>Latest Action</th>
                                        <th>Updated At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="product,index in productsItems" :key="product.id">
                                        <td>{{ index+1 }}</td>
                                        <td>{{ product.product_name }}</td>
                                        <td>{{ product.quantity }}</td>
                                        <td>{{ product.latest_action }}</td>
                                        <td>{{ product.updated_on }}</td>
                                        <td> <button type="button" class="btn btn-rounded btn-info" data-toggle="modal" @click="editItem(product)"><span class="btn-icon-left text-info">
                                                    <i class="fa fa-plus color-info"></i>
                                                </span>Edit Stock</button></td>
                                    </tr>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Product Name</th>
                                        <th>Quantity</th>
                                        <th>Latest Action</th>
                                        <th>Updated At</th>
                                        <th>Actions</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Stock Value</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                        <table id="example" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Mpesa  Balance</th>
                                        <th>Stock Value</th>
                                        <th>Day's Purchases</th>
                                        <th>Lodging</th>
                                        <th>Total Value</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="stock,index in stockValue" :key="stock.id">
                                        <td>{{ index+1 }}</td>
                                        <td>{{ stock.mpesa_balance }}</td>
                                        <td>{{ stock.stock_value }}</td>
                                        <td>{{ stock.purchases }}</td>
                                        <td>{{ stock.lodging }}</td>
                                        <td>{{ parseInt(stock.mpesa_balance) + parseInt(stock.stock_value)}}</td>
                                        <td>{{ stock.updated_on }}</td>
                                        <td> <button type="button" class="btn btn-rounded btn-info" data-toggle="modal" @click="editStockValueModal(stock)"><span class="btn-icon-left text-info">
                                                    <i class="fa fa-plus color-info"></i>
                                                </span>Edit Stock</button></td>
                                    </tr>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Mpesa  Balance</th>
                                        <th>Stock Value</th>
                                        <th>Day's Purchases</th>
                                        <th>Lodging</th>
                                        <th>Total Value</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


        <!-- Large modal -->
        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">

            <div class="modal-dialog modal-lg">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Stock</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <div id="responseDiv" style="display: none;" class="alert alert-success alert-dismissible alert-alt solid fade show">
                        <button type="button" class="close" onclick="hideResponseDiv()" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <p id="responseMessage"></p>
                    </div>

                    <div class="modal-body">
                        <div class="card">
                            <div class="basic-form">
                                <form @submit.prevent="submitForm" enctype="multipart/form-data" method="post">

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Product Name</label>
                                        <div class="col-sm-10">
                                            <select id="inputState" class="form-control" v-model="selectedProductId">
                                                <option value="" disabled selected>Choose item</option>
                                                <option v-for="product in productsItems" :key="product.product_id" :value="product.product_id" :id="'option_' + product.product_id">
                                                    {{ product.product_name }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Stock</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" placeholder="100" name="description" id="description" v-model="stock">
                                        </div>
                                        
                                    </div>
                                    
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="submitProductStock">Add Item Type</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade bd-example-modal-lg1" tabindex="-1" role="dialog" aria-hidden="true" id="editModal">

            <div class="modal-dialog modal-lg">

                <div class="modal-content">
                    <div class="modal-header">

                        <h5 class="modal-title">Edit Product Stock</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>

                    <div id="responseDiv" style="display: none;" class="alert alert-success alert-dismissible alert-alt solid fade show">
                        <button type="button" class="close" onclick="hideResponseDiv()" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <p id="responseMessage"></p>
                    </div>

                    <div class="modal-body" v-if="modalData">
                        <div class="card">
                            <div class="basic-form">
                                <form @submit.prevent="submitForm">

                                    <div class="form-group row">
                                        <input type="text" v-model="modalData.product_id" class="form-control" placeholder="modalData.product_id" name="product_id" id="product_id" hidden>

                                        <div class="col-sm-2">Product Name</div>
                                        <div class="col-sm-10">
                                            <input type="text" v-model="modalData.product_name" class="form-control" placeholder="modalData.product_name" name="product_name" id="product_name">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="currentPrice" class="col-sm-2 col-form-label">Current Stock</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" placeholder="Kes 125.5" name="current_stock" id="current_stock" v-model="modalData.current_stock">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="currentPrice" class="col-sm-2 col-form-label">New Stock</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" placeholder="25" name="new_stock" id="new_stock" v-model="modalData.new_stock">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="editProductStock">Add Item Type</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade bd-example-modal-lg1" tabindex="-1" role="dialog" aria-hidden="true" id="editStockModal">

            <div class="modal-dialog modal-lg">

                <div class="modal-content">
                    <div class="modal-header">

                        <h5 class="modal-title">Edit Stock Details</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>

                    <div id="responseDiv" style="display: none;" class="alert alert-success alert-dismissible alert-alt solid fade show">
                        <button type="button" class="close" onclick="hideResponseDiv()" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <p id="responseMessage"></p>
                    </div>

                    <div class="modal-body" v-if="stockModalData">
                        <div class="card">
                            <div class="basic-form">
                                <form @submit.prevent="submitForm">

                                    <div class="form-group row">
                                        <input type="text" v-model="stockModalData.date" class="form-control" placeholder="stockModalData.date" name="date" id="date" >

                                        <div class="col-sm-2">Lodging</div>
                                        <div class="col-sm-10">
                                            <input type="text" v-model="stockModalData.lodging" class="form-control" placeholder="300 kes" name="lodging" id="lodging">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="currentPrice" class="col-sm-2 col-form-label">MPesa Balance</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" placeholder="Kes 125.5" name="mpesa_balance" id="mpesa_balance" v-model="stockModalData.mpesa_balance">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="currentPrice" class="col-sm-2 col-form-label">Purchases</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" placeholder="25" name="purchases" id="purchases" v-model="stockModalData.purchases">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="editStockValues">Add Finances</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade bd-example-modal-lg1" tabindex="-1" role="dialog" aria-hidden="true" id="uploadRecipt">

            <div class="modal-dialog modal-lg">

                <div class="modal-content">
                    <div class="modal-header">

                        <h5 class="modal-title">Purchases Receipts</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>

                    <div id="responseDiv" style="display: none;" class="alert alert-success alert-dismissible alert-alt solid fade show">
                        <button type="button" class="close" onclick="hideResponseDiv()" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <p id="responseMessage"></p>
                    </div>

                    <div class="modal-body" >
                        <div class="card">
                            <div class="basic-form">
                            <?php $validation = \Config\Services::validation(); ?>

                            <form method="post" action="<?=site_url('/quantities/fileUpload')?>" enctype="multipart/form-data">
                            <?= csrf_field(); ?>

                            <div class="form-group">
                             <label for="file">File:</label>

                             <input type="file" class="form-control" id="file" name="file" />
                             <!-- Error -->
                             <?php if( $validation->getError('file') ) {?>
                             <div class='alert alert-danger mt-2'>
                                  <?= $validation->getError('file'); ?>
                             </div>
                             <?php }?>

                        </div>
                        <input type="submit" class="btn btn-primary"  name="submit" value="Upload" @click="uploadRecipt">
  
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary"  >Add Receipts</button>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</div>
<!--**********************************
            Content body end
        ***********************************-->

<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
<script type="text/javascript" src="../../assets/vue/prodcutsStock.js"></script>
<?php include(APPPATH . 'Views/template/footer.php'); ?>