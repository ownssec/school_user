<?php
require_once "db.php";

class Person extends DB {
    private $table = "student_table";
    public array $person_names = [];

    public function create($name, $age, $gender) {
        $stmt = $this->pdo->prepare("INSERT INTO {$this->table} (name, age, gender, created_at) VALUES (?, ?, ?, NOW())");
        return $stmt->execute([$name, $age, $gender]);
    }

    public function read() {
        $stmt = $this->pdo->query("SELECT * FROM {$this->table} ORDER BY id DESC");
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($data as $row) {
            $this->person_names[] = $row['name'];
        }
        return $data;
    }

    public function update($id, $name, $age, $gender) {
        $stmt = $this->pdo->prepare("UPDATE {$this->table} SET name = ?, age = ?, gender = ? WHERE id = ?");
        return $stmt->execute([$name, $age, $gender, $id]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function search($keyword) {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE name LIKE ?");
        $stmt->execute(["%$keyword%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
