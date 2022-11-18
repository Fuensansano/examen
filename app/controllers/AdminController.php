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
                'isAdmin' => true,
            ];

            if(empty($user)) {
                array_push($errors, 'El usuario es requerido');
            }
            if(empty($password)) {
                array_push($errors, 'La contraseña es requerida');
            }

            if ( ! $errors ) {

                $errors = $this->model->verifyUser($dataForm);

                if ( ! $errors ) {

                    /*
                     * he casteado a objeto porque en el loginController lo que le llega es un objeto y
                     * en el adminController le llegaba un array y para poder unificarlo para entenderlo mejor, he
                     * realizado un casteo a objeto, únicamente para aclararme más
                     */
                    $this->session->login((object) $dataForm);
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
        $this->session->logout();
        header('location:' . ROOT);
    }
}