<?php
include 'authorization.php';

class UserInformation extends Dbh
{
    public function informationStore($username, $password, $role, $location)
    {
        $pdo = $this->connect();

        // Insert the user information into the database using a prepared statement
        $query = "INSERT INTO [dbo].[user] ([username], [password], [role], [location]) VALUES (:username, :password, :role, :location)";
        $stmt = $pdo->prepare($query);

        // Hash the password before storing it (recommended for security)
        $hashedPassword = md5($password); // You may use a stronger hashing method for security.

        // Bind the values to the prepared statement placeholders
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        $stmt->bindParam(':role', $role, PDO::PARAM_STR);
        $stmt->bindParam(':location', $location, PDO::PARAM_STR);

        // Execute the prepared statement
        try {
            if ($stmt->execute()) {
                // If the execution was successful, call a function here
                $u_id = $this->userId($username, $hashedPassword);
                if ($this->user_token($u_id)) {
                    header("Location: index.php?success=successfully registered");
                } else {
                    header("Location: index.php?success=failed to register");
                }
            } else {
                throw new Exception("Failed to execute the statement.");
            }
            // You can add any further actions or messages here upon successful insertion.
        } catch (PDOException $e) {
            throw new Exception("Failed to store information: " . $e->getMessage());
        }
    }

    private function userId($username, $hashedPassword)
    {
        $pdo = $this->connect();
        $query = "SELECT [u_id] FROM [dbo].[user] WHERE [username] = :username AND [password] = :password";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashedPassword);

        try {
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                $u_id = $result['u_id'];
                return $u_id;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            throw new Exception("Failed to fetch user ID: " . $e->getMessage());
        }
    }

    private function user_token($u_id)
    {
        $pdo = $this->connect();
        $query = "INSERT INTO [dbo].[user_token] ([u_id]) VALUES (:u_id)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':u_id', $u_id);
        $stmt->execute();

        return true;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_name = validateInput($_POST['username']);
    $password = validateInput($_POST['password']);
    $role = validateInput($_POST['userRole']);
    $location = validateInput($_POST['location']);

    if (empty($user_name) || empty($password) || empty($role) || empty($location)) {
        echo "All fields are required.";
    } elseif (strlen($password) < 8) {
        echo "Password must be at least 8 characters long.";
    } else {
        $obj = new UserInformation();
        $obj->informationStore($user_name, $password, $role, $location);
    }
}

function validateInput($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}
?>
