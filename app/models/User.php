<?php

class UserModel extends Model {
    public function __construct() {
        parent::__construct();
    }

    public function getByUsername($username) {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE username = :username LIMIT 1');
        $stmt->execute(['username' => $username]);
        return $stmt->fetch();
    }

    public function getById($id) {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function all() {
        $stmt = $this->db->prepare('SELECT * FROM users ORDER BY role, full_name');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function create($data) {
        $stmt = $this->db->prepare('INSERT INTO users (full_name, username, password, role, email, created_at) VALUES (:full_name, :username, :password, :role, :email, NOW())');
        return $stmt->execute($data);
    }

    public function getByEmail($email) {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    public function updateLogin($userId) {
        $stmt = $this->db->prepare('UPDATE users SET last_login = NOW() WHERE id = :id');
        return $stmt->execute(['id' => $userId]);
    }

    public function storeResetToken($userId, $token, $expiry) {
        $stmt = $this->db->prepare('UPDATE users SET reset_token = :token, reset_expiry = :expiry WHERE id = :id');
        return $stmt->execute([
            'token' => $token,
            'expiry' => $expiry,
            'id' => $userId
        ]);
    }

    public function getByResetToken($token) {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE reset_token = :token AND reset_expiry > NOW() LIMIT 1');
        $stmt->execute(['token' => $token]);
        return $stmt->fetch();
    }

    public function updatePassword($userId, $password) {
        $stmt = $this->db->prepare('UPDATE users SET password = :password, reset_token = NULL, reset_expiry = NULL WHERE id = :id');
        return $stmt->execute([
            'password' => $password,
            'id' => $userId
        ]);
    }

    public function clearResetToken($userId) {
        $stmt = $this->db->prepare('UPDATE users SET reset_token = NULL, reset_expiry = NULL WHERE id = :id');
        return $stmt->execute(['id' => $userId]);
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare('UPDATE users SET full_name = :full_name, username = :username, role = :role, email = :email WHERE id = :id');
        return $stmt->execute([
            'full_name' => $data['full_name'],
            'username' => $data['username'],
            'role' => $data['role'],
            'email' => $data['email'],
            'id' => $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare('DELETE FROM users WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }
}
