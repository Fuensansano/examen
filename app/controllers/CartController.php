<?php

class CartController extends Controller
{
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = $this->model('Cart');
    }

    public function index($errors = [])
    {
        if ($this->session->getLogin()) {

            $user_id = $this->session->getUserId();
            $cart = $this->model->getCart($user_id);

            $data = [
                'titulo' => 'Carrito',
                'menu' => true,
                'user_id' => $user_id,
                'data' => $cart,
                'errors' => $errors
            ];

            $this->view('carts/index', $data);

        } else {
            header('location:' . ROOT);
        }
    }

    public function addProduct($product_id, $user_id)
    {
        $errors = [];

        if ($this->model->verifyProduct($product_id, $user_id) == false) {
            if ($this->model->addProduct($product_id, $user_id) == false) {
                array_push($errors, 'Error al insertar el producto en el carrito');
            }
        }
        $this->index($errors);
    }

    public function update()
    {
        if (isset($_POST['rows']) && isset($_POST['user_id'])) {
            $errors = [];
            $rows = $_POST['rows'];
            $user_id = $_POST['user_id'];

            for ($i = 0; $i < $rows; $i++) {
                $product_id = $_POST['i'.$i];
                $quantity = $_POST['c'.$i];
                if ( ! $this->model->update($user_id, $product_id, $quantity)) {
                    array_push($errors, 'Error al actualizar el producto');
                }
            }
            $this->index($errors);
        }
    }

    public function delete($product, $user)
    {
        $errors = [];

        if( ! $this->model->delete($product, $user)) {
            array_push($errors, 'Error al borrar el registro del carrito');
        }

        $this->index($errors);
    }

    public function checkout()
    {
        if (!$this->session->getLogin()) {
            header('Location:' . ROOT . 'login/index');
        }

        $user = $this->session->getUser();
        $addressController = $this->createAddressController();
        $address = $addressController->findAddressByUserId($user->id);

        $data = [
            'titulo' => 'Carrito | Datos de env??o',
            'subtitle' => 'Checkout | Verificar direcci??n de env??o',
            'menu' => true,
            'data' => $address,
        ];
        $this->view('address/index', $data);

    }

    public function paymentmode()
    {
        $data = [
            'titulo' => 'Carrito | Forma de pago',
            'subtitle' => 'Checkout | Forma de pago',
            'menu' => true,
        ];

        $this->view('carts/paymentmode', $data);
    }

    public function verify()
    {

        $user = $this->session->getUser();
        $cart = $this->model->getCart($user->id);
        $addressController = $this->createAddressController();
        $address = $addressController->findAddressByUserId($user->id);
        $payment = $_POST['payment'] ?? '';

        $data = [
            'titulo' => 'Carrito | Verificar los datos',
            'menu' => true,
            'payment' => $payment,
            'user' => $user,
            'address' => $address,
            'data' => $cart,
        ];

        $this->view('carts/verify', $data);
    }

    public function thanks()
    {
        $user = $this->session->getUser();

        if ($this->model->closeCart($user->id, 1)) {

            $data = [
                'titulo' => 'Carrito | Gracias por su compra',
                'data' => $user,
                'menu' => true,
            ];

            $this->view('carts/thanks', $data);

        } else {

            $data = [
                'titulo' => 'Error en la actualizaci??n del carrito',
                'menu' => false,
                'subtitle' => 'Error en la actualizaci??n de los productos del carrito',
                'text' => 'Existi?? un problema al actualizar el estado del carrito. Por favor, pruebe m??s tarde o comun??quese con nuestro servicio de soporte',
                'color' => 'alert-danger',
                'url' => 'login',
                'colorButton' => 'btn-danger',
                'textButton' => 'Regresar',
            ];

            $this->view('mensaje', $data);

        }
    }

    private function createAddressController()
    {
        require_once '../app/controllers/AddressController.php';
        return new AddressController();
    }
}