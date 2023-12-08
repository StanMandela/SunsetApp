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
                            </span>Add Product Price</button>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Item Types Datatable</h4>
                    </div>
                    {{prices}}
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product Name</th>
                                        <th>Current Price</th>
                                        <th>Previous Price</th>
                                        <th>From Date</th>
                                        <th>Updated On</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="price,index in prices" :key="price.id">
                                        <td>{{ index+1 }}</td>
                                        <td>{{ price.product_name }}</td>
                                        <td>{{ price.current_price }}</td>
                                        <td>{{ price.previous_price }}</td>
                                        <td>{{ price.from_date }}</td>
                                        <td>{{ price.updated_on }}</td>
                                        <td> <button type="button" class="btn btn-rounded btn-info" data-toggle="modal"   @click="editItem(price)"><span class="btn-icon-left text-info">
                                                    <i class="fa fa-plus color-info"></i>
                                                </span>Edit</button></td>

                                    </tr>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Product Name</th>
                                        <th>Current Price</th>
                                        <th>Previous Price</th>
                                        <th>From Date</th>
                                        <th>Updated On</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
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
                        <h5 class="modal-title">Add Product Prices</h5>
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
                                <form @submit.prevent="submitForm">


                                    <div class="form-group row">
                                        <div class="col-sm-2">Product Name</div>
                                        <div class="col-sm-10">
                                            <select id="inputState" class="form-control" v-model="selectedProductId">
                                                <option value="" disabled selected>Choose item</option>
                                                <option v-for="product in products" :key="product.product_id" :value="product.product_id" :id="'option_' + product.product_id">
                                                    {{ product.product_name }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Price</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" placeholder="Kes 125.5" name="price" id="price" v-model="price">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="submitProductPrice">Add Item Type</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade bd-example-modal-lg1" tabindex="-1" role="dialog" aria-hidden="true" id="editModal">

            <div class="modal-dialog modal-lg">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Product Prices</h5>
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
                                    <input  type="text"  class="form-control" placeholder="product_id" name="selectedProductId" id="modalData.product_id" v-model="editselectedProductId" >    

                                        <div class="col-sm-2">Product Name</div>
                                        <div class="col-sm-10">
                                        <input type="text" v-model="modalData.product_name" class="form-control" placeholder="modalData.product_name" name="price" id="price" >
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="currentPrice"  class="col-sm-2 col-form-label">Price</label>
                                        <div class="col-sm-10">
                                            <input type="text"  class="form-control" placeholder="Kes 125.5" name="price" id="price" v-model="modalData.price">
                                        </div>
                                        
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="editProductPrice">Add Item Type</button>
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
<script type="text/javascript" src="../../assets/vue/productPrices.js"></script>
<?php include(APPPATH . 'Views/template/footer.php'); ?>