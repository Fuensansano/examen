<?php

class AdminController extends Controller
{
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = $this->model('Admin');
    }

    public function index()
    {
        if ($this->session->getLogin() && $this->session->isAdmin()){
            header('Location: ' . ROOT . 'adminShop/index');
        }

        $data = [
            'titulo' => 'Administración',
            'menu' => false,
            'data' => [],
        ];

        $this->view('admin/index', $data);
    }

    public function verifyUser()
    {
        $errors = [];
        $dataForm = [];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $user = $_POST['user'] ?? '';
            $password = $_POST['password'] ?? '';

            $dataForm = [
                'user' => $user,
                'password' => $password,
            ];

            if(empty($user)) {
                $errors[] = 'El usuario es requerido';
            }
            if(empty($password)) {
                $errors[] = 'La contraseña es requerida';
            }

            if ( ! $errors ) {

                $errors = $this->model->verifyUser($dataForm);

                if ( ! $errors ) {
                    $admin = $this->model->getAdminByEmail($user);
                    $this->session->adminLogin($admin);
                    header("LOCATION:" . ROOT . 'AdminShop');
                }
            }
        }

        $data = [
            'titulo' => 'Administración - Inicio',
            'menu' => false,
            'admin' => false,
            'errors' => $errors,
            'data' => $dataForm,
        ];

        $this->view('admin/index', $data);
    }

    public function logout()
    {
        $this->session->adminLogout();
        header('location:' . ROOT);
    }
}