<div class="modal fade" id="edit_category_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="category_modal_label">Add Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="cat_modal" onsubmit="return false" autocomplete="off">
                    <input type="hidden" name="edit" id="edit">
                    <input type="hidden" name="category_id" id="category_id">
                    <div class="form-group">
                        <label for="category_name">Enter Category</label>
                        <input type="text" name="category_name" id="category_name" class="form-control"
                            placeholder="Enter Category">
                        <small id="category_name_error" class="form-text text-muted"></small>
                    </div>
                    <div class="form-group">
                        <label for="parent_cat_id">Parent Category</label>
                        <select class="custom-select" name="parent_cat_id" id="parent_cat_id">
                        </select>
                        <small id="parent_cat_id_error" class="form-text text-muted"></small>
                    </div>
                    <div class="text-right my-2">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div> -->
        </div>
    </div>
</div>