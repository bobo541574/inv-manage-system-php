/* Start - Fetch All Category */
if ($("#parent_cat_list").data("value") == "Parent_List") {
    fetch_parent_categories(1);
}

/* Start - Fetch All Parent Category */
function fetch_parent_categories(current_page) {
    $.ajax({
        url: DOMAIN + "/includes/ParentCategoryController.php",
        method: "POST",
        data: {
            current_page: current_page /* To Check Server Side */ ,
        },
        success: function (data) {
            let respose = JSON.parse(data);
            let paginator = respose["paginate"];
            let total_pages = paginator["totalPages"];
            let prev_page = paginator["prev_page"];
            let next_page = paginator["next_page"];
            let parent_categories = respose["rows"];
            let table = "";
            let paginate = "";
            $.each(parent_categories, function (i, v) {
                let parent_cat_id = parent_categories[i].parent_cat_id;
                let parent_cat_name = parent_categories[i].parent_cat_name;

                table += `<tr>
                    <td>${i + 1}</td>
                    <td>${parent_cat_name}</td>
                    <td>
                        <a href="#" data-parent_cat_id="${parent_cat_id}" data-parent_cat_name="${parent_cat_name}" data-toggle="modal" data-target="#edit_parent_category_modal"
                            class="btn btn-sm btn-warning parent_category_edit" data-toggle="tooltip" title="Edit Parent Category"><i class="fa fa-edit"></i> Edit
                        </a>
                        </td>
                        <td>
                            <a href="#" data-parent_cat_id="${parent_cat_id}" class="btn btn-sm btn-danger parent_category_delete" data-toggle="modal" data-target="#delete_confirm" title="Delete Parent Category"><i class="fa fa-trash"></i> Delete</a>
                        </td>
                    </tr>`;
                $("tbody").html(table);
            });
            if (total_pages > 1) {
                paginate += `
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-end mr-4">
                                    <li class="page-item ${current_page > 1 ? "" : "disabled text-muted"}">
                                        <a class="page-link" href="#" aria-label="Previous" onclick="fetch_categories(${prev_page})">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>`;
                for (let i = 1; i <= total_pages; i++) {
                    paginate += `<li class="page-item"><a class="page-link" href="#" onclick="fetch_categories(${i})">${i}</a></li>`;
                }
                paginate += `
                                    <li class="page-item ${next_page <= total_pages ? "" : "disabled text-muted"}">
                                        <a class="page-link" href="#" aria-label="Next" onclick="fetch_categories(${next_page})">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                    `;
                $("#paginator").html(paginate);
            }

            // let choose = "<option value='0'>Choose Parent Category</option>"
            // $("#parent_cat_id").html(choose + data);
        },
    });
}
/* End - Fetch All Parent Category */

/* Start - Edit Category */
$("tbody").on("click", ".parent_category_edit", function () {
    let parent_category_id = $(this).data("parent_cat_id");
    let patent_category_name = $(this).data("parent_cat_name");

    $("#parent_cat_id").val(parent_category_id);
    $("#parent_category_name").val(patent_category_name);
});
/* End - Edit Category */

/* Start - Delecte Category */
$("tbody").on("click", ".parent_category_delete", function () {
    let parent_cat_id = $(this).data("parent_cat_id");

    $("#parent_cat_id").val(parent_cat_id);
});
$("#parent_cat_delete").on("submit", function () {
    $(".overlay").show();
    $.ajax({
        url: DOMAIN + "/includes/ParentCategoryController.php",
        method: "POST",
        data: $("#parent_cat_delete").serialize(),
        success: function (data) {
            if (data == "PARENT_CATEGORY_DELETED") {
                $(".overlay").hide();
                window.location.reload();
            }
        },
    });
});
/* End - Delecte Category */

$("#parent_cat_modal").on("submit", function () {
    let status = false;
    let parent_category_name = $("#parent_category_name");
    let edit = $("#edit");

    if (parent_category_name.val() == "") {
        parent_category_name.addClass("border-danger");
        $("#parent_category_name_error").html(
            `<span class="text-danger">Parent Category is required.</span>`
        );
        status = false;
    } else {
        parent_category_name.removeClass("border-danger");
        $("#parent_category_name_error").html("");
        status = true;
    }

    if (status && edit.val() != "EDIT") {
        /* Add Parent Category */
        $(".overlay").show();
        $.ajax({
            url: DOMAIN + "/includes/ParentCategoryController.php",
            method: "POST",
            data: $("#parent_cat_modal").serialize(),
            success: function (data) {
                if (data == "PARENT_CATEGORY_ADDED") {
                    $(".overlay").hide();
                    $("#parent_cat_modal")
                        .prepend(`<div class="alert alert-warning text-center" role="alert">
                                                    <small class="text text-success">Parent Category is successfully add!!!</small>
                                                </div>`);
                    $("#parent_category_name").html("");
                }
            },
        });
    } else if (status && edit.val() == "EDIT") {
        /* Update Parent Category */
        $(".overlay").show();
        $.ajax({
            url: DOMAIN + "/includes/ParentCategoryController.php",
            method: "POST",
            data: $("#parent_cat_modal").serialize(),
            success: function (data) {
                if (data == "PARENT_CATEGORY_UPDATED") {
                    $(".overlay").hide();
                    window.location.reload();
                }
            },
        });
    }
})