<div class="modal fade" id="edit_product_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="product_modal_label">Add Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit_prod_modal" onsubmit="return false" autocomplete="off" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="hidden" name="edit" id="edit">
                            <input type="hidden" name="product_id" id="product_id">
                            <div class="form-group">
                                <input type="text" name="product_name" id="product_name" class="form-control"
                                    placeholder="Enter Category">
                                <small id="product_name_error" class="form-text text-muted"></small>
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="old_photo" id="old_photo">
                                <input type="file" name="photo" id="photo" onchange="loadFile()" class="form-file-input"
                                    placeholder="Enter Photo">
                                <small id="photo_error" class="form-text text-muted"></small>
                            </div>
                            <!-- <div class="form-group">
                                <div class="custom-file">
                                    <input type="file" name="photo" id="photo" onchange="loadFile()"
                                        class="custom-file-input" placeholder="Enter Photo">
                                    <label class="custom-file-label" for="photo">Choose file</label>
                                    <small id="photo_error" class="form-text text-muted"></small>
                                </div>
                            </div> -->
                            <div class="form-group">
                                <select class="custom-select" name="category_id" id="category_id">
                                </select>
                                <small id="category_id_error" class="form-text text-muted"></small>
                            </div>
                            <div class="form-group">
                                <select class="custom-select" name="brand_id" id="brand_id">
                                </select>
                                <small id="brand_id_error" class="form-text text-muted"></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" name="color" id="color" class="form-control"
                                    placeholder="Enter Color">
                                <small id="color_error" class="form-text text-muted"></small>
                            </div>
                            <div class="form-group">
                                <input type="text" name="size" id="size" class="form-control" placeholder="Enter Size">
                                <small id="size_error" class="form-text text-muted"></small>
                            </div>
                            <div class="form-group">
                                <input type="number" name="price" id="price" class="form-control"
                                    placeholder="Enter Price">
                                <small id="price_error" class="form-text text-muted"></small>
                            </div>
                            <div class="form-group">
                                <input type="text" name="quantity" id="quantity" class="form-control"
                                    placeholder="Enter Quantity">
                                <small id="quantity_error" class="form-text text-muted"></small>
                            </div>
                            <div class="text-right my-2">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>