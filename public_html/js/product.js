/* Start - Fetch All Product */
if ($("#product_list").data("value") == "Product_List") {
    fetch_products(1);
}

/* Start - Fetch All Product */
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
                let category_id = product[i].category_id;
                let category_name = product[i].category_name;
                let brand_id = product[i].brand_id;
                let brand_name = product[i].brand_name;
                let color = product[i].color;
                let size = product[i].size;
                let price = product[i].price;
                let quantity = product[i].quantity;
                let status = product[i].status;

                table += `<tr>
                    <td class="align-middle">${skip_records + i + 1}</td>
                    <td class="align-middle">
                        <img src="${DOMAIN}/images/products/${photo}" alt="product_image" />
                    </td>
                    <td class="align-middle">${product_name}</td>
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
                        <a href="javascript:void(0)" data-product_id="${product_id}" data-product_name="${product_name}"
                                    data-category_id="${category_id}" data-brand_id="${brand_id}"
                                    data-photo="${photo}" data-color="${color}" data-size="${size}" data-price="${price}" 
                                    data-quantity="${quantity}" data-toggle="modal" data-target="#edit_product_modal"
                            class="btn btn-sm btn-warning product_edit" title="Edit Product"><i class="fa fa-edit"></i>
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
                                    <li class="page-item ${
                                      current_page > 1
                                        ? ""
                                        : "disabled text-muted"
                                    }">
                                        <a class="page-link" href="javascript:void(0)" aria-label="Previous" onclick="fetch_products(${prev_page})">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>`;
                for (let i = 1; i <= total_pages; i++) {
                    paginate += `<li class="page-item"><a class="page-link ${
            current_page == i ? "bg-primary text-light" : ""
          }" href="javascript:void(0)" onclick="fetch_products(${i})">${i}</a></li>`;
                }
                paginate += `
                                    <li class="page-item ${
                                      next_page <= total_pages
                                        ? ""
                                        : "disabled text-muted"
                                    }">
                                        <a class="page-link" href="javascript:void(0)" aria-label="Next" onclick="fetch_products(${next_page})">
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
/* End - Fetch All Product */

/* Start - Edit Product */
$("tbody").on("click", ".product_edit", function () {
    let product_id = $(this).data("product_id");
    let product_name = $(this).data("product_name");
    let photo = $(this).data("photo");
    let category_id = $(this).data("category_id");
    let brand_id = $(this).data("brand_id");
    let color = $(this).data("color");
    let size = $(this).data("size");
    let price = $(this).data("price");
    let quantity = $(this).data("quantity");
    console.log(photo);

    $("#edit_prod_modal #product_id").val(product_id);
    $("#edit_prod_modal #product_name").val(product_name);
    $("#edit_prod_modal #old_photo").val(photo);
    // $("#edit_prod_modal #photo").val(photo);
    $("#edit_prod_modal #category_id").val(category_id);
    $("#edit_prod_modal #brand_id").val(brand_id);
    $("#edit_prod_modal #color").val(color);
    $("#edit_prod_modal #size").val(size);
    $("#edit_prod_modal #price").val(price);
    $("#edit_prod_modal #quantity").val(quantity);
    $("#edit_prod_modal #edit").val("EDIT");
});

$("#edit_prod_modal").on("submit", function () {
    let status = false;
    let product_name = $("#edit_prod_modal #product_name");
    let photo = $("#edit_prod_modal #photo");
    let old_photo = $("#edit_prod_modal #old_photo");
    let category_id = $("#edit_prod_modal #category_id");
    let brand_id = $("#edit_prod_modal #brand_id");
    let color = $("#edit_prod_modal #color");
    let size = $("#edit_prod_modal #size");
    let price = $("#edit_prod_modal #price");
    let quantity = $("#edit_prod_modal #quantity");
    let edit = "EDIT";

    validation(
        product_name,
        photo,
        old_photo,
        category_id,
        brand_id,
        color,
        size,
        price,
        quantity,
        edit
    );

    if (
        product_name.val() &&
        (photo.val() || old_photo.val()) &&
        category_id.val() &&
        brand_id.val() &&
        color.val() &&
        size.val() &&
        price.val() &&
        quantity.val()
    ) {
        /* Update Brand */
        // $(".overlay").show();
        $.ajax({
            url: DOMAIN + "/includes/ProductController.php",
            method: "POST",
            data: $("#edit_prod_modal").serialize(),
            success: function (data) {
                console.log(data)

                if (data == "PRODUCT_UPDATED") {
                    // $(".overlay").hide();
                    // fetch_products(1);
                    console.log(data)
                    // window.location.reload();
                }
            },
        });
    }
});
/* End - Edit Product */

/* Start - Product Status */
$("tbody").on("change", ".product_status", function () {
    let status = $(this).data("status");
    let product_id = $(this).data("product_id");
    $(".overlay").show();
    $.ajax({
        url: DOMAIN + "/includes/ProductController.php",
        method: "POST",
        data: {
            product_id: product_id,
            product_status: status,
        },
        success: function (data) {
            console.log(data);
            $(".overlay").hide();
            if (data == "PRODUCT_STATUS") {
                // window.location.reload();
            }
        },
    });
});
/* End - Product Status */

/* Start - Delect Product */
$("tbody").on("click", ".product_delete", function () {
    let product_id = $(this).data("product_id");

    $("#product_id").val(product_id);
});
$("#product_delete").on("submit", function () {
    $(".overlay").show();
    $.ajax({
        url: DOMAIN + "/includes/ProductController.php",
        method: "POST",
        data: $("#product_delete").serialize(),
        success: function (data) {
            if (data == "PRODUCT_DELETED") {
                fetch_products(1);
                $(".overlay").hide();
            }
        },
    });
});
/* End - Delect Product */

/* Start - Photo Upload */
let loadFile = function () {
    let formData = new FormData();
    let files = $("#photo")[0].files[0];
    formData.append("file", files);
    // console.log(formData)
    // $(".overlay").show();
    $.ajax({
        processData: false,
        contentType: false,
        url: DOMAIN + "/includes/ProductController.php",
        method: "POST",
        data: formData,
        success: function (data) {
            if (data == "PHOTO_UPLOADED") {
                // $(".overlay").hide();
            }
        },
    });
};
/* End - Photo Upload */

/* Start - From Validation */
function validation(
    product_name,
    photo = "",
    old_photo = "",
    category_id,
    brand_id,
    color,
    size,
    price,
    quantity,
    edit = null
) {
    //   console.log(photo.val() + "||" + old_photo.val());
    console.log(edit == "EDIT" ? "#edit_prod_modal" : "#prod_modal");
    if (product_name.val() == "") {
        product_name.addClass("is-invalid");
        $(`${edit == "EDIT" ? "#edit_prod_modal" : ""} #product_name_error`).html(
            `<span class="text-danger">Product Name is required.</span>`
        );
        status = false;
    } else {
        product_name.removeClass("is-invalid");
        $(
            `${
        edit == "EDIT" ? "#edit_prod_modal" : "#prod_modal"
      } #product_name_error`
        ).html("");
        status = true;
    }

    if (photo.val() == "" && old_photo.val() == "") {
        photo.addClass("is-invalid");
        $(
            `${edit == "EDIT" ? "#edit_prod_modal" : "#prod_modal"} #photo_error`
        ).html(`<span class="text-danger">Photo is required.</span>`);
        status = false;
    } else {
        var loadFile = function (event) {
            var image = document.getElementById("output");
            image.src = URL.createObjectURL(event.target.files[0]);
        };
        photo.removeClass("is-invalid");
        $(
            `${edit == "EDIT" ? "#edit_prod_modal" : "#prod_modal"} #photo_error`
        ).html("");
        status = true;
    }

    if (category_id.val() == "0") {
        category_id.addClass("is-invalid");
        $(
            `${
        edit == "EDIT" ? "#edit_prod_modal" : "#prod_modal"
      } #category_id_error`
        ).html(`<span class="text-danger">Category is required.</span>`);
        status = false;
    } else {
        category_id.removeClass("is-invalid");
        $(
            `${
        edit == "EDIT" ? "#edit_prod_modal" : "#prod_modal"
      } #category_id_error`
        ).html("");
        status = true;
    }

    if (brand_id.val() == "0") {
        brand_id.addClass("is-invalid");
        $(
            `${edit == "EDIT" ? "#edit_prod_modal" : "#prod_modal"} #brand_id_error`
        ).html(`<span class="text-danger">Brand is required.</span>`);
        status = false;
    } else {
        brand_id.removeClass("is-invalid");
        $(
            `${edit == "EDIT" ? "#edit_prod_modal" : "#prod_modal"} #brand_id_error`
        ).html("");
        status = true;
    }

    if (color.val() == "") {
        color.addClass("is-invalid");
        $(
            `${edit == "EDIT" ? "#edit_prod_modal" : "#prod_modal"} #color_error`
        ).html(`<span class="text-danger">Color is required.</span>`);
        status = false;
    } else {
        color.removeClass("is-invalid");
        $(
            `${edit == "EDIT" ? "#edit_prod_modal" : "#prod_modal"} #color_error`
        ).html("");
        status = true;
    }

    if (size.val() == "") {
        size.addClass("is-invalid");
        $(
            `${edit == "EDIT" ? "#edit_prod_modal" : "#prod_modal"} #size_error`
        ).html(`<span class="text-danger">Size is required.</span>`);
        status = false;
    } else {
        size.removeClass("is-invalid");
        $(
            `${edit == "EDIT" ? "#edit_prod_modal" : "#prod_modal"} #size_error`
        ).html("");
        status = true;
    }

    if (price.val() == "") {
        price.addClass("is-invalid");
        $(
            `${edit == "EDIT" ? "#edit_prod_modal" : "#prod_modal"} #price_error`
        ).html(`<span class="text-danger">Price is required.</span>`);
        status = false;
    } else {
        price.removeClass("is-invalid");
        $(
            `${edit == "EDIT" ? "#edit_prod_modal" : "#prod_modal"} #price_error`
        ).html("");
        status = true;
    }

    if (quantity.val() == "") {
        quantity.addClass("is-invalid");
        $(
            `${edit == "EDIT" ? "#edit_prod_modal" : "#prod_modal"} #quantity_error`
        ).html(`<span class="text-danger">Quantity is required.</span>`);
        status = false;
    } else {
        quantity.removeClass("is-invalid");
        $(
            `${edit == "EDIT" ? "#edit_prod_modal" : "#prod_modal"} #quantity_error`
        ).html("");
        status = true;
    }

    return;
}
/* End - From Validation */

/* Start - Create Product */
$("#prod_modal").on("submit", function () {
    let status = false;
    let product_name = $("#product_name");
    let photo = $("#photo");
    let old_photo = $("#photo");
    let category_id = $("#category_id");
    let brand_id = $("#brand_id");
    let color = $("#color");
    let size = $("#size");
    let price = $("#price");
    let quantity = $("#quantity");

    //   console.log(photo[0].files[0].name);
    //   console.log(photo.val());

    validation(
        product_name,
        photo,
        old_photo,
        category_id,
        brand_id,
        color,
        size,
        price,
        quantity
    );

    if (
        product_name.val() &&
        photo.val() &&
        category_id.val() &&
        brand_id.val() &&
        color.val() &&
        size.val() &&
        price.val() &&
        quantity.val()
    ) {
        /* Add Product */
        // $(".overlay").show();
        $.ajax({
            url: DOMAIN + "/includes/ProductController.php",
            method: "POST",
            data: $("#prod_modal").serialize() + `&photo=${photo[0].files[0].name}`,
            success: function (data) {
                if (data == "PRODUCT_ADDED") {
                    fetch_products(1);

                    // $(".overlay").hide();
                    // $("#prod_modal_alert")
                    //     .html(`<div class="alert alert-warning text-center" role="alert">
                    //                                 <small class="text text-success">Product is successfully add!!!</small>
                    //                             </div>`);
                    // $("#product_name").html("");
                    // $("#product_name").val("");
                }
            },
        });
    } else {}
});
/* End - Create Product */