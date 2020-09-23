// $(document).ready(function () {
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
      getParentCategory: 1 /* To Check Server Side */,
    },
    success: function (data) {
      let choose = "<option value='0'>Choose Parent Category</option>";
      $("#parent_cat_id").html(choose + data);
    },
  });
}

/* Start - Fetch All Category */
if ($("#cat_list").data("value") == "List") {
  fetch_categories(1);
}

function fetch_categories(current_page) {
  console.log(current_page);
  $.ajax({
    url: DOMAIN + "/includes/Process.php",
    method: "POST",
    data: {
      current_page: current_page /* To Check Server Side */,
    },
    success: function (data) {
      let respose = JSON.parse(data);
      let paginator = respose["paginate"];
      let total_pages = paginator["totalPages"];
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
                    <td>${i + 1}</td>
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

      paginate += `
                            <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-end mr-4">
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Previous" onclick="fetch_categories(${prev_page})">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>`;
      for (let i = 1; i <= total_pages; i++) {
        paginate += `<li class="page-item"><a class="page-link" href="#" onclick="fetch_categories(${i})">${i}</a></li>`;
      }
      paginate += `
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Next" onclick="fetch_categories(${next_page})">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                `;
      $("#paginator").html(paginate);

      // let choose = "<option value='0'>Choose Parent Category</option>"
      // $("#parent_cat_id").html(choose + data);
    },
  });
}

$("tbody").on("click", ".category_edit", function () {
  let category_id = $(this).data("category_id");
  let category_name = $(this).data("category_name");
  let parent_category_id = $(this).data("parent_cat_id");

  $("#category_id").val(category_id);
  $("#category_name").val(category_name);
  $("#parent_cat_id").val(parent_category_id);
});
/* End - Fetch All Category */

/* Start - Delect Category */
$("tbody").on("click", ".category_delete", function () {
  let category_id = $(this).data("category_id");

  $("#category_id").val(category_id);
});
$("#cat_delete").on("submit", function () {
  $(".overlay").show();
  $.ajax({
    url: DOMAIN + "/includes/Process.php",
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
/* End - Delect Category */

/* Start - Category Status */
$("tbody").on("change", ".category_status", function () {
  let status = $(this).data("status");
  let category_id = $(this).data("category_id");
  $(".overlay").show();
  $.ajax({
    url: DOMAIN + "/includes/Process.php",
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
    $(".overlay").show();
    $.ajax({
      url: DOMAIN + "/includes/Process.php",
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
      url: DOMAIN + "/includes/Process.php",
      method: "POST",
      data: $("#cat_modal").serialize(),
      success: function (data) {
        console.log(data);
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
