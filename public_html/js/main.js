$(document).ready(function () {
    // var DOMAIN = "http://localhost/projects/PHP/Inventory-Management-System/public_html";
    // $("#parent_cat_fetch").on("click", function () {
    //     $.ajax({
    //         url: DOMAIN + "/includes/Process.php",
    //         method: "POST",
    //         data: {
    //             getParentCategory: 1 /* To Check Server Side */
    //         },
    //         success: function (data) {
    //             let choose = "<option value='0'>Choose Parent Category</option>"
    //             $("#parent_cat_id").html(choose + data);
    //         }
    //     })
    // })

    /* Fetch All Parent Category */
    fetch_parent_categories();

    function fetch_parent_categories() {
        console.log("fetch_parent_categories");

        $.ajax({
            url: DOMAIN + "/includes/Process.php",
            method: "POST",
            data: {
                getParentCategory: 1 /* To Check Server Side */
            },
            success: function (data) {
                let choose = "<option value='0'>Choose Parent Category</option>"
                $("#parent_cat_id").html(choose + data);
            }
        })
    }

    /* Fetch All Category */
    if ($("#cat_list").data("value") == "List") {
        fetch_categories();
    }




    function fetch_categories() {
        $.ajax({
            url: DOMAIN + "/includes/Process.php",
            method: "POST",
            data: {
                getCategory: 1 /* To Check Server Side */
            },
            success: function (data) {
                let categories = JSON.parse(data);
                let table = "";
                $.each(categories, function (i, v) {
                    let category_id = categories[i].cat_id;
                    let category_name = categories[i].category_name;
                    let parent_cat_name = categories[i].parent_cat_name;
                    let parent_cat_id = categories[i].parent_cat_id;

                    table += `<tr>
                            <td>${i + 1}</td>
                            <td>${category_name}</td>
                            <td>${parent_cat_name}</td>
                            <td>
                                <a href="#" data-category_id="${category_id}" data-category_name="${category_name}" data-parent_cat_id="${parent_cat_id}" data-toggle="modal" data-target="#edit_category_modal"
                                    class="btn btn-sm btn-warning category_edit">Add
                                </a>
                                </td>
                                <td>
                                    <form action="">
                                        <button class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>`;
                    $("tbody").html(table);
                })
                // let choose = "<option value='0'>Choose Parent Category</option>"
                // $("#parent_cat_id").html(choose + data);
            }
        })
    }
    $("tbody").on("click", ".category_edit", function () {
        let category_id = $(this).data("category_id");
        let category_name = $(this).data("category_name");
        let parent_category_id = $(this).data("parent_cat_id");

        $("#category_id").val(category_id);
        $("#category_name").val(category_name);
        $("#parent_cat_id").val(parent_category_id);
    })

    /* Add Category */
    $("#cat_modal").on("submit", function () {
        let status = false;
        let category_name = $("#category_name");
        let parent_cat_id = $("#parent_cat_id");
        let edit = $("#edit");

        if (category_name.val() == "") {
            category_name.addClass("border-danger");
            $("#category_name_error").html(`<span class="text-danger">Category is required.</span>`);
            status = false;
        } else {
            category_name.removeClass("border-danger");
            $("#category_name_error").html("");
            status = true;
        }

        if (parent_cat_id.val() == "0") {
            parent_cat_id.addClass("border-danger");
            $("#parent_cat_id_error").html(`<span class="text-danger">Parent Category is required</span>`);
            status = false;
        } else {
            parent_cat_id.removeClass("border-danger");
            $("#parent_cat_id_error").html("");
            status = true;
        }

        if (category_name.val() && parent_cat_id.val() != "0" && edit.val() != "EDIT") {
            $(".overlay").show();
            $.ajax({
                url: DOMAIN + "/includes/Process.php",
                method: "POST",
                data: $("#cat_modal").serialize(),
                success: function (data) {
                    if (data == "CATEGORY_ADDED") {
                        $(".overlay").hide();
                        $("#cat_modal").prepend(`<div class="alert alert-warning text-center" role="alert">
                                                    <small class="text text-success">Category is successfully add!!!</small>
                                                </div>`);
                        $("#category_name").html("");
                    }
                }
            })
        } else if (category_name.val() && parent_cat_id.val() != "0" && edit.val() == "EDIT") {
            $(".overlay").show();
            $.ajax({
                url: DOMAIN + "/includes/Process.php",
                method: "POST",
                data: $("#cat_modal").serialize(),
                success: function (data) {
                    console.log(data)
                    if (data == "CATEGORY_EDIT") {
                        $(".overlay").hide();
                        $("#cat_modal").prepend(`<div class="alert alert-warning text-center" role="alert">
                                                    <small class="text text-success">Category is successfully add!!!</small>
                                                </div>`);
                        $("#category_name").html("");
                    }
                }

                // window.location.href = encodeURI(DOMAIN + "/dashboard.php");
            })
        }
    })

})