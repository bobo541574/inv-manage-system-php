$(document).ready(function () {
    /* Login Form */
    $("#login_form").on("submit", function () {
        let status = false;
        let email = $("#email");
        let password = $("#password");

        if (email.val() == "") {
            email.addClass("border-danger");
            $("#email_error").html(
                "<span class='text-danger'>Email Address is required.</span>"
            );
            status = false;
        } else {
            email.removeClass("border-danger");
            $("#email_error").html("");
            status = true;
        }

        if (password.val() == "") {
            password.addClass("border-danger");
            $("#password_error").html(
                "<span class='text-danger'>Password is required.</span>"
            );
            status = false;
        } else {
            password.removeClass("border-danger");
            $("#password_error").html("");
            status = true;
        }

        if (email.val() && password.val()) {
            $(".overlay").show();
            $.ajax({
                url: DOMAIN + "/includes/Auth.php",
                method: "POST",
                crossOrigin: true,
                data: $("#login_form").serialize(),
                success: function (data) {
                    if (data === "NOT_REGISTERED") {
                        $(".overlay").hide();
                        email.addClass("border-danger");
                        $("#email_error").html(
                            `<span class="text-danger">The specific <strong>Account</strong> is not registered</span>`
                        );
                        status = false;
                    } else if (data === "PASSWORD_NOT_MATCHED") {
                        $(".overlay").hide();
                        password.addClass("border-danger");
                        $("#password_error").html(
                            `<span class="text-danger">Password is not matched</span>`
                        );
                        status = false;
                    } else {
                        $(".overlay").hide();
                        email.removeClass("border-danger");
                        $("#email_error").html("");
                        password.removeClass("border-danger");
                        $("#password_error").html("");
                        status = true;

                        window.location.href = encodeURI(DOMAIN + "/dashboard.php");
                    }
                },
            });
        }
    });
});