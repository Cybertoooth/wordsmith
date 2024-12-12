<?php
require __DIR__ . "/Database.php";

date_default_timezone_set("America/Los_Angeles");

function register_user($user_data, $db)
{
    //take user data and save to database
    $stmt = $db->prepare(
        'INSERT INTO "user_account"("name", "username", "email", "password", "date_added", "last_active") VALUES(:name, :username, :email, :password, :date_added, :last_active)'
    );
    $stmt->bindValue(":name", $user_data["fullname"]);
    $stmt->bindValue(":username", $user_data["username"]);
    $stmt->bindValue(":email", $user_data["email"]);
    $stmt->bindValue(":password", hash_user_password($user_data["password"]));
    $stmt->bindValue(":date_added", date("d-m-Y h:i:sa"));
    $stmt->bindValue(":last_active", date("d-m-Y h:i:sa"));
    $stmt->execute();
    header("Location: ../index.php");
}

function check_for_account($user_data, $db)
{
    //check to see if user already exist
    $stmt = $db->prepare('SELECT * FROM "user_account" WHERE "email" = ?');
    $stmt->bindValue(1, $user_data["email"]);
    $result = $stmt->execute();
    if ($result->fetchArray(SQLITE3_NUM) < 1) {
        register_user($user_data, $db);
    } else {
        $_SESSION["message"] = "Account already exists";
        header("Location: ../signin/");
        exit();
    }
}

function signin($user_data, $db)
{
    //sign user in
    $email_username = email_or_username(
        sanitize_field($user_data["email_username"]),
        $db
    );
    verify_account_password($user_data["password"], $email_username, $db);
}

function email_or_username($field, $db)
{
    /*  email_or_username($arg1, $arg2) - determine if the field value is email or username and return the appropriate prepared statement
     **
     **
     */
    $result = "";
    if (validate_email($field) !== "Invalid email address") {
        $stmt = $db->prepare(
            'SELECT email, password  FROM "user_account" WHERE "email" = ?'
        );
        $stmt->bindValue(1, $field);
    } else {
        $stmt = $db->prepare(
            'SELECT username, password FROM "user_account" WHERE "username" = ?'
        );
        $stmt->bindValue(1, $field);
    }
    $result = $stmt->execute();
    return $result->fetchArray();
}

function verify_account_password($password, $field, $db)
{
    $hashed_password = $field["password"];
    if (password_verify($password, $hashed_password)) {
        $_SESSION["username"] = $field["username"];
        header("Location: ../index.php");
        exit();
    } else {
        $_SESSION["message"] = "Password  does not match";
        header("Location: ../signin/");
        exit();
    }
}

function signout()
{
    //sign user out and destroy all the session variables and redirect user to sign in
    session_destroy();
    header("Location: ../signin/");
    exit();
}

function hash_user_password($password)
{
    //hash the users password
    return password_hash($password, PASSWORD_BCRYPT, ["cost" => 12]);
}

?>
