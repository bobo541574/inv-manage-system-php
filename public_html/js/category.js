/* Start - Fetch All Category */
if ($("#cat_list").data("value") == "List") {
    fetch_categories(1);
}

function fetch_categories(current_page) {
    $.ajax({
        url: DOMAIN + "/includes/CategoryController.php",
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
            let categories = respose["rows"];
            let table = "";
            let paginate = "";
            $.each(categories, function (i, v) {
                let category_id = categories[i].cat_id;
                let category_name = categories[i].category_name;
                let parent_cat_name = categories[i].parent_cat_name;
                let status = categories[i].status;
                let parent_cat_id = categories[i].parent_cat_id;

                table += `<tr>
                    <td>${(skip_records+i) + 1}</td>
                    <td>${category_name}</td>
                    <td>${parent_cat_name}</td>
                    <td>
                        <select class="custom-select custom-select-sm category_status" data-status="${status}" data-category_id="${category_id}">
                            <option value="0" ${
                              0 == status ? "selected" : ""
                            }>Off</option>
                            <option value="1" ${
                              1 == status ? "selected" : ""
                            }>On</option>
                        </select>
                    </td>
                    <td>
                        <a href="#" data-category_id="${category_id}" data-category_name="${category_name}" data-parent_cat_id="${parent_cat_id}" data-toggle="modal" data-target="#edit_category_modal"
                            class="btn btn-sm btn-warning category_edit" data-toggle="tooltip" title="Edit Category"><i class="fa fa-edit"></i> Edit
                        </a>
                    </td>
                    <td>
                        <a href="#" data-category_id="${category_id}" class="btn btn-sm btn-danger category_delete" data-toggle="modal" data-target="#delete_confirm" title="Delete Category"><i class="fa fa-trash"></i> Delete</a>
                    </td>
                    </tr>`;
                $("tbody").html(table);
            });

            if (total_pages > 1) {
                paginate += `
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-end mr-4 text-hover">'
                                <li class="page-item ${current_page > 1 ? "" : "disabled text-muted"}">
                                        <a class="page-link" href="#" aria-label="Previous" onclick="fetch_categories(${prev_page})">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>`;
                for (let i = 1; i <= total_pages; i++) {
                    paginate += `<li class="page-item"><a class="page-link ${current_page == i ? 'bg-primary text-light' : ''}" href="#" onclick="fetch_categories(${i})">${i}</a></li>`;
                }
                paginate += `
                                <li class="page-item ${next_page <= total_pages ? "" : "disabled text-muted"}">
                                    <a class="page-link" href="#" aria-label="Next" onclick="fetch_categories(${next_page})" style="">
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
/* End - Fetch All Category */

/* Start - Edit Category */
$("tbody").on("click", ".category_edit", function () {
    let category_id = $(this).data("category_id");
    let category_name = $(this).data("category_name");
    let parent_category_id = $(this).data("parent_cat_id");

    $("form #category_id").val(category_id);
    $("form #category_name").val(category_name);
    $("form #parent_cat_id").val(parent_category_id);
    $("form #edit").val("EDIT");
});
/* End - Edit Category */

/* Start - Delecte Category */
$("tbody").on("click", ".category_delete", function () {
    let category_id = $(this).data("category_id");

    $("#category_id").val(category_id);
});
$("#cat_delete").on("submit", function () {
    $(".overlay").show();
    $.ajax({
        url: DOMAIN + "/includes/CategoryController.php",
        method: "POST",
        data: $("#cat_delete").serialize(),
        success: function (data) {
            if (data == "CATEGORY_DELETED") {
                $(".overlay").hide();
                window.location.reload();
            }
        },
    });
});
/* End - Delecte Category */

/* Start - Category Status */
$("tbody").on("change", ".category_status", function () {
    let status = $(this).data("status");
    let category_id = $(this).data("category_id");
    $(".overlay").show();
    $.ajax({
        url: DOMAIN + "/includes/CategoryController.php",
        method: "POST",
        data: {
            category_id: category_id,
            category_status: status,
        },
        success: function (data) {
            console.log(data);
            $(".overlay").hide();
            if (data == "CATEGORY_STATUS") {
                // window.location.reload();
            }
        },
    });
});
/* End - Category Status */

/* Start - Category Validation, Create & Update */
$("#cat_modal").on("submit", function () {
    let status = false;
    let category_name = $("#category_name");
    let parent_cat_id = $("#parent_cat_id");
    let edit = $("#edit");
    console.log(edit.val())

    if (category_name.val() == "") {
        category_name.addClass("border-danger");
        $("#category_name_error").html(
            `<span class="text-danger">Category is required.</span>`
        );
        status = false;
    } else {
        category_name.removeClass("border-danger");
        $("#category_name_error").html("");
        status = true;
    }

    if (parent_cat_id.val() == "0") {
        parent_cat_id.addClass("border-danger");
        $("#parent_cat_id_error").html(
            `<span class="text-danger">Parent Category is required</span>`
        );
        status = false;
    } else {
        parent_cat_id.removeClass("border-danger");
        $("#parent_cat_id_error").html("");
        status = true;
    }

    if (
        category_name.val() &&
        parent_cat_id.val() != "0" &&
        edit.val() != "EDIT"
    ) {
        /* Add Category */
        console.log("!EDIT")
        $(".overlay").show();
        $.ajax({
            url: DOMAIN + "/includes/CategoryController.php",
            method: "POST",
            data: $("#cat_modal").serialize(),
            success: function (data) {
                if (data == "CATEGORY_ADDED") {
                    $(".overlay").hide();
                    $("#cat_modal")
                        .prepend(`<div class="alert alert-warning text-center" role="alert">
                                                    <small class="text text-success">Category is successfully add!!!</small>
                                                </div>`);
                    $("#category_name").html("");
                }
            },
        });
    } else if (
        category_name.val() &&
        parent_cat_id.val() != "0" &&
        edit.val() == "EDIT"
    ) {
        /* Category Update */
        $(".overlay").show();
        $.ajax({
            url: DOMAIN + "/includes/CategoryController.php",
            method: "POST",
            data: $("#cat_modal").serialize(),
            success: function (data) {
                if (data == "CATEGORY_UPDATED") {
                    $(".overlay").hide();
                    window.location.reload();
                }
            },
        });
    }
});
/* End - Category Validation, Create & Update */

// })