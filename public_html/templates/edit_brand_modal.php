<div class="modal fade" id="edit_brand_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="brand_modal_label">Add Brand</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="bd_modal_alert"></div>
                <form id="bd_modal" onsubmit="return false" autocomplete="off">
                    <input type="hidden" name="edit" id="edit">
                    <input type="hidden" name="brand_id" id="brand_id" value="">
                    <div class="form-group">
                        <label for="brand_name">Enter Brand</label>
                        <input type="text" name="brand_name" id="brand_name" class="form-control"
                            placeholder="Enter Brand">
                        <small id="brand_name_error" class="form-text text-muted"></small>
                    </div>
                    <div class="form-group">
                        <label for="logo">Enter Brand</label>
                        <input type="text" name="logo" id="logo" class="form-control" value="BRAND_LOGO"
                            placeholder="Enter Brand">
                        <small id="logo_error" class="form-text text-muted"></small>
                    </div>
                    <div class="text-right my-2">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>