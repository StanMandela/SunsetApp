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
                            </span>Add Sales</button>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Sales Datatable</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product Name</th>
                                        <th>Description</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Amount</th>
                                        <th>Item Type</th>
                                        <th>Created At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="sale,index in sales" :key="sale.id">
                                        <td>{{ index+1 }}</td>
                                        <td>{{ sale.product_name }}</td>
                                        <td>{{ sale.description }}</td>
                                        <td>{{ sale.quantity }}</td>
                                        <td>{{ sale.price }}</td>
                                        <td>{{ sale.amount }}</td>
                                        <td>{{ sale.type_name }}</td>
                                        <td>{{ sale.created_at }}</td>
                                    </tr>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Product Name</th>
                                        <th>Description</th>
                                        <th>Quantity</th>
                                        <th>Amount</th>
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

        <!-- Large modal -->
        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">

            <div class="modal-dialog modal-lg">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Products</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>

                    <!-- <div id="responseDiv" style="display: none;" class="alert alert-success alert-dismissible alert-alt solid fade " id="alert" >
                        <button type="button" class="close h-100" onclick="hideResponseDiv()" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                        </button>
                        <p id="responseMessage"></p>
                    </div>
                    <div class="alert alert-success alert-dismissible alert-alt solid fade" id="alert" v-else hidden>
                        <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                        </button>
                        <strong>Success!</strong> Message has been sent.
                    </div> -->
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

                                        <div class="col-sm-2">Item Name</div>
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
                                        <label class="col-sm-2 col-form-label">Quantity</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" placeholder="1.5" name="name" id="name" v-model="saleQuantity">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="submitSale">Add Sale</button>
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
<script type="text/javascript" src="../../assets/vue/salesAppVue.js"></script>
<?php include(APPPATH . 'Views/template/footer.php'); ?>