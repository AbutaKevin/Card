<?php

class Controller {
    public function __construct() {
        // Initialize controller
    }

    public function model($model) {
        require_once dirname(__DIR__) . '/models/' . $model . '.php';
        return new $model();
    }

    public function view($view, $data = []) {
        require_once dirname(__DIR__) . '/views/' . $view . '.php';
    }

    protected function requireAuth() {
        if (empty($_SESSION['user'])) {
            auth_redirect();
        }
    }

    protected function authorize($roles = []) {
        if (!empty($roles) && (!isset($_SESSION['user']['role']) || !in_array($_SESSION['user']['role'], $roles))) {
            header('Location: ' . APP_URL . '/dashboard');
            exit;
        }
    }
}
