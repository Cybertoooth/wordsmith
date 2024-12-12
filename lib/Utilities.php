<?php

#include "../lib/User.php";
#include "../lib/Database.php";

require __DIR__ . "/User.php";
require __DIR__ . "/Database.php";

function sanitize_field($field)
{
    return trim(stripslashes(htmlspecialchars($field)));
}

function check_password($password, $confirm_password)
{
    if ($password === $confirm_password) {
        return $password;
    } else {
        return "Password does not match";
    }
}

function validate_email($email)
{
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return $email;
    } else {
        return "Invalid email address";
    }
}

function validate_name_field($field)
{
    if (preg_match('/^[a-zA-Z ]*$/', $field)) {
        return $field;
    } else {
        return "Invalid name, please use letters and whitespace";
    }
}

function validate_username_field($field)
{
    if (preg_match('/^[a-zA-Z0-9-_]*$/', $field)) {
        return $field;
    } else {
        return "Username can only contain letters, numbers, dash and underscore";
    }
}

function compare_values($form_data, $validated_data)
{
    /*
     ** compare sanitized, validated values to the form. If the values are the same
     ** they are considered valid and will be saved to the database
     */
    foreach ($form_data as $index => $field) {
        if ($field == $validated_data[$index]) {
            //return $validated_data;
            if ($index == "email") {
                check_for_account(
                    $validated_data,
                    //$validated_data[$index],
                    new SQLite3(
                        "../data/wordsmith.sqlite",
                        SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE
                    )
                );
            }
        } else {
            echo $validated_data[$index];
            break;
        }
    }
}

?>
