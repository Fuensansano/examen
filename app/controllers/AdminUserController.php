<?php

class AdminUserController extends Controller
{
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = $this->model('AdminUser');
    }

    public function index()
    {

        if ($this->session->isAdminLogin()) {

            $users = $this->model->getUsers();

            $data = [
                'titulo' => 'Administración de Usuarios',
                'menu' => false,
                'admin' => true,
                'users' => $users,
            ];

            $this->view('admin/users/index', $data);
        } else {
            header('LOCATION:' . ROOT . 'admin');
        }

    }

    public function update($id)
    {
        $errors = [];

        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $password2 = $_POST['password2'] ?? '';
        $status = $_POST['status'] ?? '';

        if ($name == '') {
            array_push($errors, 'El nombre del usuario es requerido');
        }
        if ($email == '') {
            array_push($errors, 'El email es requerido');
        }
        if ($status == '') {
            array_push($errors, 'Selecciona un estado para el usuario');
        }
        if ( ! empty($password) || ! empty($password2)) {
            if ($password != $password2) {
                array_push($errors, 'Las contraseñas no coinciden');
            }
        }

        if ( ! $errors ) {
            $data = [
                'id' => $id,
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'status' => $status,
            ];
            $errors = $this->model->setUser($data);
            if ( ! $errors ) {
                header("location:" . ROOT . 'adminUser');
            }
        }

        $user = $this->model->getUserById($id);
        $status = $this->model->getConfig('adminStatus');

        $data = [
            'titulo' => 'Administración de Usuarios - Editar',
            'menu' => false,
            'admin' => true,
            'data' => $user,
            'status' => $status,
            'errors' => $errors,
        ];

        $this->view('admin/users/update', $data);

    }

    public function destroy($id)
    {
        //$errors = [];

        $errors = $this->model->delete($id);

        if ( ! $errors ) {
            header('location:' . ROOT . 'adminUser');
        }

        $user = $this->model->getUserById($id);
        $status = $this->model->getConfig('adminStatus');

        $data = [
            'titulo' => 'Administración de Usuarios - Eliminación',
            'menu' => false,
            'admin' => true,
            'data' => $user,
            'status' => $status,
            'errors' => $errors,
        ];

        $this->view('admin/users/delete', $data);

    }

    public function create(): void
    {
        $data = [
            'titulo' => 'Administración de Usuarios - Alta',
            'menu' => false,
            'admin' => true,
            'data' => [],
        ];

        $this->view('admin/users/create', $data);
    }

    public function store()
    {
        $errorsNewAdmin = [];
        $firstName = $_POST['first_name'] ?? '';
        $lastName1 = $_POST['last_name_1'] ?? '';
        $lastName2 = $_POST['last_name_2'] ?? '';
        $name = "$firstName $lastName1 $lastName2";
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $password2 = $_POST['password2'] ?? '';

        $dataFormAdmin = [
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ];

        $dataFormLogin = [
            'firstName' => $_POST['first_name'] ?? '',
            'lastName1' => $_POST['last_name_1'] ?? '',
            'lastName2' => $_POST['last_name_2'] ?? '',
            'email' => $_POST['email'] ?? '',
            'password' => $_POST['password'] ?? '',
            'password2' => $_POST['password2'] ?? '',
            'address' => $_POST['address'] ?? '',
            'city' => $_POST['city'] ?? '',
            'state' => $_POST['state'] ?? '',
            'zipcode' => $_POST['zipcode'] ?? '',
            'country' => $_POST['country'] ?? ''
        ];

        $dataForm = array_merge($dataFormAdmin, $dataFormLogin);

        if (empty($name)) {
            array_push($errorsNewAdmin, 'El nombre de usuario es requerido');
        }
        if (empty($email)) {
            array_push($errorsNewAdmin, 'El correo electrónico de usuario es requerido');
        }
        if (empty($password)) {
            array_push($errorsNewAdmin, 'La clave de acceso es requerida');
        }
        if (empty($password2)) {
            array_push($errorsNewAdmin, 'La verificación de clave es requerida');
        }
        if ($password !== $password2) {
            array_push($errorsNewAdmin, 'Las claves no coinciden');
        }
        $loginController = $this->createLoginController();
        $errors = array_merge($errorsNewAdmin, $loginController->validateRegisterFormWithAddressInfo());

        if ($errors) {
            $data = [
                'titulo' => 'Administración de Usuarios - Alta',
                'menu' => false,
                'admin' => true,
                'errors' => $errors,
                'data' => $dataForm,
            ];

            $this->view('admin/users/create', $data);
            return;
        }

        if (! $this->model->createAdminUser($dataFormAdmin)) {
            $data = [
                'titulo' => 'Error en la creación de un usuario administrador',
                'menu' => false,
                'errors' => [],
                'subtitle' => 'Error al crear un nuevo usuario administrador',
                'text' => 'Se ha producido un error durante el proceso de creación de un usuario administrador',
                'color' => 'alert-danger',
                'url' => 'adminUser',
                'colorButton' => 'btn-danger',
                'textButton' => 'Volver',
            ];
            $this->view('mensaje', $data);
            return;
        }

        if (!$loginController->createUser($dataFormLogin)){
            return;
        }

        $admin = $this->model->getUserByEmail($dataForm['email']);
        $this->session->adminLogin($admin);

        header("location:" . ROOT . 'adminUser');

    }

    public function edit($id): void
    {
        $user = $this->model->getUserById($id);
        $status = $this->model->getConfig('adminStatus');

        $data = [
            'titulo' => 'Administración de Usuarios - Editar',
            'menu' => false,
            'admin' => true,
            'data' => $user,
            'status' => $status,
            'errors' => [],
        ];

        $this->view('admin/users/update', $data);
    }

    public function delete($id): void
    {
        $user = $this->model->getUserById($id);
        $status = $this->model->getConfig('adminStatus');

        $data = [
            'titulo' => 'Administración de Usuarios - Eliminación',
            'menu' => false,
            'admin' => true,
            'data' => $user,
            'status' => $status,
            'errors' => [],
        ];

        $this->view('admin/users/delete', $data);
    }

    private function createLoginController()
    {
        require_once '../app/controllers/LoginController.php';
        return new LoginController();
    }
}