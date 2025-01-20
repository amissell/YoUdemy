<?php
namespace app\classes;
require_once __DIR__ . '/../../vendor/autoload.php';


use app\batabases\DBConnection; 
use PDO;
use PDOException;

class User
{
    // Private properties (encapsulated)
    private $db;
    private $id;
    private $email;
    // private $password;
    private $firstName;
    private $lastName;
    private $role;

    // Constructor to initialize the database connection
    public function __construct()
    {
        // Create a new instance of DBConnection
        $dbConnection = new DBConnection();
        $this->db = $dbConnection->getConnection(); // Get the PDO connection
    }

    // Public method to register a user
    public function register($email, $password, $firstName, $lastName, $role = 'student')
    {
        try {
            // Validate inputs
            if (empty($email) || empty($password) || empty($firstName) || empty($lastName)) {
                throw new \Exception("All fields are required.");
            }

            // Check if the email already exists
            $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                throw new \Exception("Email already exists.");
            }

            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Insert the new user into the database
            $stmt = $this->db->prepare("INSERT INTO users (email, password, first_name, last_name, role) VALUES (:email, :password, :first_name, :last_name, :role)");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':first_name', $firstName);
            $stmt->bindParam(':last_name', $lastName);
            $stmt->bindParam(':role', $role);
            $stmt->execute();

            return "Registration successful!";
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // Public method to log in a user
    public function login($email, $password)
    {
        try {
            // Fetch the user by email
            $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verify the password
            if ($user && password_verify($password, $user['password'])) {
                // Set private properties with user data
                $this->id = $user['id'];
                $this->email = $user['email'];
                $this->firstName = $user['first_name'];
                $this->lastName = $user['last_name'];
                $this->role = $user['role'];

                return $this->getUserData(); // Return user data
            } else {
                throw new \Exception("Invalid email or password.");
            }
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // Public method to get user data (encapsulated)
    public function getUserData()
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'role' => $this->role,
        ];
    }

    // Public method to update user profile
    public function updateProfile($id, $firstName, $lastName, $email)
    {
        try {
            // Validate inputs
            if (empty($firstName) || empty($lastName) || empty($email)) {
                throw new \Exception("All fields are required.");
            }

            // Update user data in the database
            $stmt = $this->db->prepare("UPDATE users SET first_name = :first_name, last_name = :last_name, email = :email WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':first_name', $firstName);
            $stmt->bindParam(':last_name', $lastName);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            return "Profile updated successfully!";
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
?>