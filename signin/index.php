<?php
include "../lib/Utilities.php";

if (isset($_POST["submit"])) {
    $user_data = [
        "email_username" => $_POST["email_username"],
        "password" => sanitize_field($_POST["password"]),
    ];
    signin(
        $user_data,
        new SQLite3(
            "../data/wordsmith.sqlite",
            SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE
        )
    );
} else {
    include "../templates/signin-form.php";
}

?>
