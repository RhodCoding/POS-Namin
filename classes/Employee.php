<?php
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Model.php';

class Employee extends Model {
    protected $table = 'users';
    protected $fillable = ['username', 'password', 'name', 'role', 'status'];

    public function __construct() {
        parent::__construct();
    }

    public function create($data) {
        // Hash the password before saving
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        
        // Set role as employee
        $data['role'] = 'employee';
        
        // Set default status as active
        $data['status'] = 'active';
        
        return parent::create($data);
    }

    public function getAllEmployees() {
        $query = "SELECT id, username, name, status, created_at 
                 FROM {$this->table} 
                 WHERE role = 'employee'
                 ORDER BY created_at DESC";
        
        $result = $this->db->query($query);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function updateStatus($id, $status) {
        $id = $this->db->real_escape_string($id);
        $status = $this->db->real_escape_string($status);
        
        $query = "UPDATE {$this->table} 
                 SET status = '{$status}' 
                 WHERE id = {$id} AND role = 'employee'";
        
        return $this->db->query($query);
    }

    public function validateNewEmployee($data) {
        $errors = [];
        
        // Validate username
        if (empty($data['username'])) {
            $errors['username'] = 'Username is required';
        } else {
            // Check if username already exists
            $stmt = $this->db->prepare("SELECT id FROM {$this->table} WHERE username = ?");
            $stmt->bind_param('s', $data['username']);
            $stmt->execute();
            if ($stmt->get_result()->num_rows > 0) {
                $errors['username'] = 'Username already exists';
            }
        }
        
        // Validate name
        if (empty($data['name'])) {
            $errors['name'] = 'Name is required';
        }
        
        // Validate password
        if (empty($data['password'])) {
            $errors['password'] = 'Password is required';
        } elseif (strlen($data['password']) < 6) {
            $errors['password'] = 'Password must be at least 6 characters';
        }
        
        return $errors;
    }

    public function delete($id) {
        $id = $this->db->real_escape_string($id);
        $query = "DELETE FROM {$this->table} WHERE id = {$id} AND role = 'employee'";
        return $this->db->query($query);
    }

    public function update($id, $data) {
        $id = $this->db->real_escape_string($id);
        $updates = [];

        // Handle password separately
        if (!empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        } else {
            unset($data['password']); // Don't update password if not provided
        }

        foreach ($this->fillable as $field) {
            if (isset($data[$field])) {
                $value = $this->db->real_escape_string($data[$field]);
                $updates[] = "{$field} = '{$value}'";
            }
        }

        if (empty($updates)) {
            return false;
        }

        $query = "UPDATE {$this->table} 
                 SET " . implode(', ', $updates) . " 
                 WHERE id = {$id} AND role = 'employee'";
        
        return $this->db->query($query);
    }

    public function getById($id) {
        $id = $this->db->real_escape_string($id);
        $query = "SELECT id, username, name, status 
                 FROM {$this->table} 
                 WHERE id = {$id} AND role = 'employee'";
        
        $result = $this->db->query($query);
        return $result ? $result->fetch_assoc() : null;
    }
}
