/* Start - Fetch All Brand */
if ($("#product_order").data("value") == "Product_Order") {
    fetch_products(1);
}
fetch_customer_order();

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
                let product_code = product[i].product_code;
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
                        <a href="javascript:void(0)" data-product_id="${product_id}" data-product_code="${product_code}" data-product_name="${product_name}" 
                                    data-price="${price}" data-quantity="${quantity}" class="btn btn-sm btn-info product_order" 
                            data-toggle="tooltip" title="Add To Order List"><i class="fa fa-shopping-bag"></i>
                        </a>
                    </td>
                    `;
                $("#ordering tbody").html(table);
            });
            if (total_pages > 1) {
                paginate += `
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-end mr-4">
                                    <li class="page-item ${current_page > 1 ? "" : "disabled text-muted"}">
                                        <a class="page-link" href="javascript:void(0)" aria-label="Previous" onclick="fetch_brands(${prev_page})">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>`;
                for (let i = 1; i <= total_pages; i++) {
                    paginate += `<li class="page-item"><a class="page-link ${current_page == i ? 'bg-primary text-light' : ''}" href="javascript:void(0)" onclick="fetch_brands(${i})">${i}</a></li>`;
                }
                paginate += `
                                    <li class="page-item ${next_page <= total_pages ? "" : "disabled text-muted"}">
                                        <a class="page-link" href="javascript:void(0)" aria-label="Next" onclick="fetch_brands(${next_page})">
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

/* Start - Order */
$("tbody").on("click", ".product_order", function () {
    let product_id = $(this).data("product_id");
    let product_code = $(this).data("product_code");
    let product_name = $(this).data("product_name");
    let price = $(this).data("price");
    let quantity = $(this).data("quantity");
    // console.log(product_id + " " + product_name + " " + product_code + " " + price + " " + quantity)

    var order = {
        product_id: product_id,
        product_code: product_code,
        product_name: product_name,
        price: price,
        quantity: 1,
    };
    let customer_order = localStorage.getItem("customer_order");
    if (!customer_order) {
        customer_order = `{"orderlist":[]}`;
    }
    customer_order_obj = JSON.parse(customer_order);
    var has_id = false;
    $.each(customer_order_obj.orderlist, function (i, v) {
        if (v) {
            if (v.product_id == product_id) {
                v.quantity++;
                has_id = true;
            }
        }
    })

    if (!has_id) {
        customer_order_obj.orderlist.push(order);
    }

    localStorage.setItem("customer_order", JSON.stringify(customer_order_obj));
    // console.log(customer_order_obj.orderlist)
    fetch_customer_order();
});

function fetch_customer_order() {
    let customer_order = localStorage.getItem("customer_order");
    if (customer_order) {
        let customer_order_obj = JSON.parse(customer_order);
        let table = "";

        $.each(customer_order_obj.orderlist, function (i, v) {
            let product_id = v.product_id;
            let product_code = v.product_code;
            let product_name = v.product_name;
            let price = v.price;
            let quantity = v.quantity;
            let status = v.status;

            table += `<tr>
                <td class="align-middle">${i + 1}</td>
                <td class="align-middle">${product_code}</td>
                <td class="align-middle">${product_name}</td>
                <td class="align-middle">${price}</td>
                <td class="align-middle">${quantity}</td>
                <td class="align-middle">${price * quantity}</td>
                <td class="align-middle">
                    <a href="javascript:void(0)" data-product_id="${product_id}" data-product_code="${product_code}" onclick="order_remove(${i})" class="btn btn-sm btn-warning order_remove" 
                        data-toggle="tooltip" title="Add To Order List"><i class="fa fa-minus-circle"></i>
                    </a>
                </td>
                `;
        });
        $("#customer_ordering tbody").html(table);
        price_calculate(customer_order_obj.orderlist);

    }
}

function order_remove(id) {
    let customer_order = localStorage.getItem("customer_order");
    if (customer_order) {
        let customer_order_obj = JSON.parse(customer_order);
        customer_order_obj.orderlist.splice(id, 1);
        localStorage.setItem("customer_order", JSON.stringify(customer_order_obj));
    }
    fetch_customer_order();
}

function price_calculate(orderlist) {
    let orderlist_obj = orderlist;
    let net_total = null;
    $.each(orderlist_obj, function (i, v) {
        let price = v.price;
        let quantity = v.quantity;
        net_total += price * quantity;
        console.log(net_total);
    })
    $("#net_total").val(net_total);
    $("#actual").val(net_total);
}

$("#discount").keyup(function () {
    let discount = $(this).val();
    let net_total = $("#net_total").val();
    let actual_price = net_total - discount;

    $("#actual").val(actual_price);
})

/* End - Order */

/* Start - Order Now  */
$(".jumbotron #order_now").click(function () {
    let name = $("#name");
    let phone = $("#phone");
    let email = $("#email");
    let address = $("#address");

    let net_total = $("#net_total");
    let discount = $("#discount");
    let actual = $("#actual");
    let payment = $("#payment");

    if (name.val() == "") {
        name.addClass("is-invalid");
        $("#name_error").html(
            `<span class="text-danger">Name is required.</span>`
        );
        status = false;
    } else {
        name.removeClass("is-invalid");
        $("#name_error").html("");
        status = true;
    }

    if (phone.val() == "") {
        phone.addClass("is-invalid");
        $("#phone_error").html(
            `<span class="text-danger">Phone is required.</span>`
        );
        status = false;
    } else {
        phone.removeClass("is-invalid");
        $("#phone_error").html("");
        status = true;
    }

    if (email.val() == "") {
        email.addClass("is-invalid");
        $("#email_error").html(
            `<span class="text-danger">Email is required.</span>`
        );
        status = false;
    } else {
        email.removeClass("is-invalid");
        $("#email_error").html("");
        status = true;
    }

    if (address.val() == "") {
        address.addClass("is-invalid");
        $("#address_error").html(
            `<span class="text-danger">Address is required.</span>`
        );
        status = false;
    } else {
        address.removeClass("is-invalid");
        $("#address_error").html("");
        status = true;
    }

    if (payment.val() == "0") {
        payment.addClass("is-invalid");
        $("#payment_error").html(
            `<span class="text-danger">Payment is required.</span>`
        );
        status = false;
    } else {
        payment.removeClass("is-invalid");
        $("#payment_error").html("");
        status = true;
    }

    if (name.val() && phone.val() && email.val() && address.val() && payment.val()) {
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
    }

})
/* End - Order Now  */

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