<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>

var DOMAIN = window.location.origin;
var BaseURL = window.location.origin;


// /* Fetch All Parent Category */
// fetch_parent_categories();

// function fetch_parent_categories() {
//     $.ajax({
//         url: DOMAIN + "/includes/CategoryController.php",
//         method: "POST",
//         data: {
//             getParentCategory: 1 /* To Check Server Side */ ,
//         },
//         success: function(data) {
//             let choose = "<option value='0'>Choose Parent Category</option>";
//             $("form #parent_cat_id").html(choose + data);
//         },
//     });
// }

// fetch_brands();

// function fetch_brands() {
//     $.ajax({
//         url: DOMAIN + "/includes/BrandController.php",
//         method: "POST",
//         data: {
//             getBrand: 1 /* To Check Server Side */ ,
//         },
//         success: function(data) {
//             let choose = "<option value='0'>Choose Brand</option>";
//             $("#brand_id").html(choose + data);
//             $("#edit_prod_modal #brand_id").html(choose + data);
//         },
//     });
// }
</script>



<!-- <script src="./js/validation.js"></script> -->