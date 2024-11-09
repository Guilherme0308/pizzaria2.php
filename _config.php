<?php

/**
 * _config.php
 * Global configuration file for the website.
 */

// Set UTF-8 content type:
header('Content-Type: text/html; charset=utf-8');

// Set application timezone:
date_default_timezone_set('America/Sao_Paulo');

/**********************
 * Website Variables: *
 **********************/

$site_name = "Xero Pizzaria";
$site_slogan = "A melhor pizzaria!";
$site_logo = "/src/img/logo_pizzaria.png";
$page_article = '';

/**
 * Password Validation Regex:
 * 
 * Rules for password security:
 * - Between 7 and 25 characters.
 * - At least one lowercase letter.
 * - At least one uppercase letter.
 * - At least one digit.
 **/
$rgpass = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{7,25}$/";

/********************************
 * Database Connection *
 ********************************/

// Parse database configuration file
$db = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/_config.ini', true);

foreach ($db as $server => $values) :
    if ($server == $_SERVER['SERVER_NAME']) :
        // Connect to the database with server-specific credentials:
        $conn = new mysqli($values['hostname'], $values['username'], $values['password'], $values['database']);
        if ($conn->connect_error) die("Database connection failed: " . $conn->connect_error);

        // Set charset to UTF-8 for compatibility
        $conn->set_charset("utf8mb4");

        // Set MySQL/MariaDB to Brazilian Portuguese for time formatting
        $conn->query('SET GLOBAL lc_time_names = pt_BR');
        $conn->query('SET lc_time_names = pt_BR');
    endif;
endforeach;

// Check for existing user cookie
if (isset($_COOKIE["{$site_name}_user"])) :
    $user = json_decode($_COOKIE["{$site_name}_user"], true);
else :
    $user = false;
endif;

/************************
 * General-use Functions *
 ************************/

/**
 * Sanitizes form fields from POST requests
 **/
function post_clean($post_field, $type = 'string')
{
    switch ($type):
        case 'string':
            $post_value = htmlspecialchars($_POST[$post_field]);
            break;
        case 'email':
            $post_value = filter_input(INPUT_POST, $post_field, FILTER_SANITIZE_EMAIL);
            break;
        case 'int':
            $post_value = filter_input(INPUT_POST, $post_field, FILTER_SANITIZE_NUMBER_INT);
            break;
        case 'url':
            $post_value = filter_input(INPUT_POST, $post_field, FILTER_SANITIZE_URL);
            break;
        default:
            $post_value = htmlspecialchars($_POST[$post_field]);
    endswitch;

    // Trim, remove dangerous quotes, and return sanitized value
    return stripslashes(trim($post_value));
}
// Inicia a sessão se não estiver iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
/**
 * Calculates age from birthdate
 */
function get_age($birthdate)
{
    $birth_date = date('Y-m-d', strtotime($birthdate));
    list($byear, $bmonth, $bday) = explode('-', $birth_date);
    $age = date("Y") - $byear;
    if (date("m") < $bmonth || (date("m") == $bmonth && date("d") < $bday)) $age--;
    return $age;
}

/**
 * Debugging function (restricted to non-production environments)
 */
function debug($element, $pre = true, $stop = true)
{
    if ($_SERVER['APP_ENV'] !== 'production') {
        if ($pre) echo '<pre>';
        print_r($element);
        if ($pre) echo '</pre>';
        if ($stop) exit;
    }
}

?>
