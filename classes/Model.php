<?php
abstract class Model {
    protected $db;
    protected $table;
    protected $fillable = [];

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function findById($id) {
        $id = $this->db->real_escape_string($id);
        $query = "SELECT * FROM {$this->table} WHERE id = {$id} LIMIT 1";
        $result = $this->db->query($query);
        return $result ? $result->fetch_assoc() : null;
    }

    public function findAll($conditions = [], $orderBy = '') {
        $query = "SELECT * FROM {$this->table}";
        
        if (!empty($conditions)) {
            $whereClause = [];
            foreach ($conditions as $key => $value) {
                $key = $this->db->real_escape_string($key);
                $value = $this->db->real_escape_string($value);
                $whereClause[] = "{$key} = '{$value}'";
            }
            $query .= " WHERE " . implode(' AND ', $whereClause);
        }

        if (!empty($orderBy)) {
            $query .= " ORDER BY " . $this->db->real_escape_string($orderBy);
        }

        $result = $this->db->query($query);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function create($data) {
        $fields = [];
        $values = [];

        foreach ($this->fillable as $field) {
            if (isset($data[$field])) {
                $fields[] = $field;
                $values[] = "'" . $this->db->real_escape_string($data[$field]) . "'";
            }
        }

        $query = "INSERT INTO {$this->table} (" . implode(', ', $fields) . ") 
                 VALUES (" . implode(', ', $values) . ")";
        
        if ($this->db->query($query)) {
            return $this->db->insert_id;
        }
        return false;
    }

    public function update($id, $data) {
        $updates = [];
        foreach ($this->fillable as $field) {
            if (isset($data[$field])) {
                $value = $this->db->real_escape_string($data[$field]);
                $updates[] = "{$field} = '{$value}'";
            }
        }

        $id = $this->db->real_escape_string($id);
        $query = "UPDATE {$this->table} SET " . implode(', ', $updates) . 
                " WHERE id = {$id}";
        
        return $this->db->query($query);
    }

    public function delete($id) {
        $id = $this->db->real_escape_string($id);
        $query = "DELETE FROM {$this->table} WHERE id = {$id}";
        return $this->db->query($query);
    }
}
