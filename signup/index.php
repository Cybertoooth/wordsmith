<?php
include "../lib/Utilities.php";

if (isset($_POST["submit"])) {
    //sanitize, validate and then check to see if the user exists, if not, add them to the db and redirect to homepage
    $fullname = validate_name_field(sanitize_field($_POST["fullname"]));
    $username = validate_username_field(sanitize_field($_POST["username"]));
    $email = validate_email(sanitize_field($_POST["email"]));
    $password = check_password(
        sanitize_field($_POST["password"]),
        sanitize_field($_POST["confirm_password"])
    );
    $result = compare_values(
        [
            "fullname" => $_POST["fullname"],
            "username" => $_POST["username"],
            "email" => $_POST["email"],
            "password" => $_POST["password"],
        ],
        [
            "fullname" => $fullname,
            "username" => $username,
            "email" => $email,
            "password" => $password,
        ]
    );

    print_r($result);
    //check_for_account($_POST["email"]);
} else {
    include "../templates/signup-form.php";
}

?>
