/* Start - Fetch All Brand */
if ($("#product_list").data("value") == "Product_List") {
    fetch_products(1);
}

/* Start - Fetch All Brand */
function fetch_products(current_page) {
    $.ajax({
        url: DOMAIN + "/includes/ProductController.php",
        method: "POST",
        data: {
            current_page: current_page /* To Check Server Side */ ,
        },
        success: function (data) {
            let respose = JSON.parse(data);
            let paginator = respose["paginate"];
            let total_pages = paginator["totalPages"];
            let skip_records = paginator["skipOfRecords"];
            let prev_page = paginator["prev_page"];
            let next_page = paginator["next_page"];
            let product = respose["rows"];
            let table = "";
            let paginate = "";
            $.each(product, function (i, v) {
                let product_id = product[i].product_id;
                let product_name = product[i].product_name;
                let photo = product[i].photo;
                let category_name = product[i].category_name;
                let brand_name = product[i].brand_name;
                let color = product[i].color;
                let size = product[i].size;
                let price = product[i].price;
                let quantity = product[i].quantity;
                let status = product[i].status;

                table += `<tr>
                    <td class="align-middle">${(skip_records + i) + 1}</td>
                    <td class="align-middle">${product_name}</td>
                    <td class="align-middle">
                        <img src="${DOMAIN}/${photo}" alt="product_image" />
                    </td>
                    <td class="align-middle">${category_name}</td>
                    <td class="align-middle">${brand_name}</td>
                    <td class="align-middle">${color}</td>
                    <td class="align-middle">${size == null ? "-" : size}</td>
                    <td class="align-middle">${price}</td>
                    <td class="align-middle">${quantity}</td>
                    <td class="align-middle">
                        <select class="custom-select custom-select-sm product_status" data-status="${status}" data-product_id="${product_id}">
                            <option value="0" ${
                              0 == status ? "selected" : ""
                            }>Off</option>
                            <option value="1" ${
                              1 == status ? "selected" : ""
                            }>On</option>
                        </select>
                    </td>
                    <td class="align-middle">
                        <a href="#" data-product_id="${product_id}" data-product_name="${product_name}" data-toggle="modal" data-target="#edit_product_modal"
                            class="btn btn-sm btn-warning product_edit" data-toggle="tooltip" title="Edit Product"><i class="fa fa-edit"></i>
                        </a>
                    </td>
                    <td class="align-middle">
                        <a href="#" data-product_id="${product_id}" class="btn btn-sm btn-danger product_delete" data-toggle="modal" data-target="#delete_confirm" title="Delete Product"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>`;
                $("tbody").html(table);
            });
            if (total_pages > 1) {
                paginate += `
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-end mr-4">
                                    <li class="page-item ${current_page > 1 ? "" : "disabled text-muted"}">
                                        <a class="page-link" href="#" aria-label="Previous" onclick="fetch_brands(${prev_page})">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>`;
                for (let i = 1; i <= total_pages; i++) {
                    paginate += `<li class="page-item"><a class="page-link ${current_page == i ? 'bg-primary text-light' : ''}" href="#" onclick="fetch_brands(${i})">${i}</a></li>`;
                }
                paginate += `
                                    <li class="page-item ${next_page <= total_pages ? "" : "disabled text-muted"}">
                                        <a class="page-link" href="#" aria-label="Next" onclick="fetch_brands(${next_page})">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                    `;
                $("#paginator").html(paginate);
            }
        },
    });
}
/* End - Fetch All Brand */

/* Start - Edit Brand */
$("tbody").on("click", ".brand_edit", function () {
    let brand_id = $(this).data("brand_id");
    let brand_name = $(this).data("brand_name");

    $("form #brand_id").val(brand_id);
    $("form #brand_name").val(brand_name);
    $("form #edit").val("EDIT");
});
/* End - Edit Brand */

/* Start - Delecte Brand */
$("tbody").on("click", ".brand_delete", function () {
    let brand_id = $(this).data("brand_id");

    $("#brand_id").val(brand_id);
});
$("#brand_delete").on("submit", function () {
    $(".overlay").show();
    $.ajax({
        url: DOMAIN + "/includes/ProductController.php",
        method: "POST",
        data: $("#brand_delete").serialize(),
        success: function (data) {
            if (data == "BRAND_DELETED") {
                fetch_brands(1);
                $(".overlay").hide();
            }
        },
    });
});
/* End - Delecte Brand */

// $("#bd_modal_alert").html("");
$("#bd_modal").on("submit", function () {
    let status = false;
    let brand_name = $("#brand_name");
    let logo = $("#logo");
    let edit = $("#edit");

    if (brand_name.val() == "") {
        brand_name.addClass("border-danger");
        $("#brand_name_error").html(
            `<span class="text-danger">Brand is required.</span>`
        );
        status = false;
    } else {
        brand_name.removeClass("border-danger");
        $("#brand_name_error").html("");
        status = true;
    }

    if (logo.val() == "") {
        logo.addClass("border-danger");
        $("#logo_error").html(
            `<span class="text-danger">Brand is required.</span>`
        );
        status = false;
    } else {
        logo.removeClass("border-danger");
        $("#logo_error").html("");
        status = true;
    }

    if (logo.val() && brand_name.val() && edit.val() != "EDIT") {
        /* Add Brand */
        $(".overlay").show();
        $.ajax({
            url: DOMAIN + "/includes/ProductController.php",
            method: "POST",
            data: $("#bd_modal").serialize(),
            success: function (data) {
                if (data == "BRAND_ADDED") {
                    $(".overlay").hide();
                    $("#bd_modal_alert")
                        .html(`<div class="alert alert-warning text-center" role="alert">
                                                    <small class="text text-success">Brand is successfully add!!!</small>
                                                </div>`);
                    $("#brand_name").html("");
                    $("#brand_name").val("");
                }
            },
        });
    } else if (logo.val() && brand_name.val() && edit.val() == "EDIT") {
        /* Update Brand */
        $(".overlay").show();
        $.ajax({
            url: DOMAIN + "/includes/ProductController.php",
            method: "POST",
            data: $("#bd_modal").serialize(),
            success: function (data) {
                if (data == "BRAND_UPDATED") {
                    $(".overlay").hide();
                    window.location.reload();
                }
            },
        });
    }
})