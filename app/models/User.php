<?php
/**
 * User Model
 * Handles user database operations
 */

class User extends Model
{
    protected $table = 'users';

    /**
     * Find user by email
     */
    public function findByEmail($email)
    {
        $sql = "SELECT * FROM {$this->table} WHERE email = ?";
        $stmt = $this->query($sql, [$email]);
        return $stmt->fetch();
    }

    /**
     * Find user by username
     */
    public function findByUsername($username)
    {
        $sql = "SELECT * FROM {$this->table} WHERE username = ?";
        $stmt = $this->query($sql, [$username]);
        return $stmt->fetch();
    }

    /**
     * Check if email exists
     */
    public function emailExists($email)
    {
        return $this->findByEmail($email) !== false;
    }

    /**
     * Check if username exists
     */
    public function usernameExists($username)
    {
        return $this->findByUsername($username) !== false;
    }

    /**
     * Create new user with hashed password
     */
    public function register($username, $email, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        
        return $this->create([
            'username' => $username,
            'email' => $email,
            'password' => $hashedPassword,
            'role' => 'user'
        ]);
    }

    /**
     * Verify password against hash
     */
    public function verifyPassword($plainPassword, $hashedPassword)
    {
        return password_verify($plainPassword, $hashedPassword);
    }

    /**
     * Login user by username (returns user if credentials valid, false otherwise)
     */
    public function login($username, $password)
    {
        $user = $this->findByUsername($username);
        
        if ($user && $this->verifyPassword($password, $user['password'])) {
            return $user;
        }
        
        return false;
    }
}
?>
