<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
// LDAP server settings
$ldap_server = "ldap://hoplun.com";
$ldap_port = 389;
$ldap_user_base_dn = "ou=users,dc=hoplun,dc=com";

// Get username and password from the login form
$username = $_POST['email'];
$password = $_POST['password'];

// Attempt to connect to the LDAP server
$ldap_conn = ldap_connect($ldap_server, $ldap_port);

if ($ldap_conn) {
    // Bind to the LDAP server with the provided username and password
    $ldap_bind = ldap_bind($ldap_conn, $username, $password);

    if ($ldap_bind) {
        // Authentication successful

        // Generate a random token (you may want to implement a more secure method)
        $token = bin2hex(random_bytes(16));

        // Store the token in a session or database, depending on your application
        session_start();
        //$_SESSION['token'] = $token;

        // Close the LDAP connection
        ldap_close($ldap_conn);

        echo "You are logged in.";

        // Redirect to the success page with the token
        header("Location: login.php?email=$username");
        exit();
    } else {
        // Authentication failed
        header("Location:index.php?error=Invalid username or password");
    }
} else {
    // Unable to connect to the LDAP server
    echo "Unable to connect to the LDAP server.";
}
?>


</body>
</html>