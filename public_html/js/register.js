$(document).ready(function () {
    /* Register Form */
    $("#register_form").on("submit", function () {
        let status = false;
        let username = $("#username");
        let email = $("#email");
        let password = $("#password");
        let confirm_password = $("#confirm_password");
        let user_type = $("#user_type");
        let confirm = $("#confirm");
        // let name_pattern = new RegExp(/^[A-Za-z]+$/);
        // let email_pattern = new RegExp(/^[a-z0-9_-]+(\.[a-z0-9_-]+)*@[a-z0-9_-]+(\.[a-z0-9_-]+)*(\.[a-z]{2,4})$/);

        if (username.val() == "") {
            username.addClass("border-danger");
            $("#username_error").html("<span class='text-danger'>Username is required.</span>");
            status = false;
        } else {
            username.removeClass("border-danger");
            $("#username_error").html("");
            status = true;
        }

        if (email.val() == "") {
            email.addClass("border-danger");
            $("#email_error").html("<span class='text-danger'>Email Address is required.</span>");
            status = false;
        } else {
            email.removeClass("border-danger");
            $("#email_error").html("");
            status = true;
        }

        if (password.val() == "") {
            password.addClass("border-danger");
            $("#password_error").html("<span class='text-danger'>Password is required.</span>");
            status = false;
        } else {
            password.removeClass("border-danger");
            $("#password_error").html("");
            status = true;
        }

        if (confirm_password.val() == "") {
            confirm_password.addClass("border-danger");
            $("#confirm_password_error").html("<span class='text-danger'>Confirm Password is required.</span>");
            status = false;
        } else {
            confirm_password.removeClass("border-danger");
            $("#confirm_password_error").html("");
            status = true;
        }

        if (user_type.val() == "") {
            user_type.addClass("border-danger");
            $("#user_type_error").html("<span class='text-danger'>User Type is required.</span>");
            status = false;
        } else {
            user_type.removeClass("border-danger");
            $("#user_type_error").html("");
            status = true;
        }

        if (status == true && password.val() !== confirm_password.val()) {
            confirm.addClass("alert alert-warning");
            $("#confirm").html("<span class='text-danger'>Password is not matched!!!</span>");
            status = false;
        } else {
            $(".overlay").show();
            $.ajax({
                url: DOMAIN + "/includes/Auth.php",
                method: "POST",
                data: $("#register_form").serialize(),
                success: function (data) {
                    if (data === "EMAIL_ALREADY_EXISTS") {
                        $(".overlay").hide();
                    } else if (data === "SOME_ERROR") {
                        $(".overlay").hide();
                    } else {
                        $(".overlay").hide();
                        window.location.href = encodeURI(DOMAIN + "/index.php?msg=You are registered now you can Login");
                    }
                }
            })

            confirm.removeClass("alert alert-warning");
            $("#confirm").html("");
            status = true;
        }
    })
})