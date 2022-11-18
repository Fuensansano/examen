<?php

class AddressController extends Controller
{
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = $this->model('Address');
    }

    public function showChangeAddressForm()
    {

        $user = $this->session->getUser();

        $data = [
            'titulo' => 'Datos para el envío',
            'menu' => true,
            'admin' => false,
            'errors' => [],
            'data' => [],
        ];

        $this->view('address/update', $data);
    }

    public function changeAddress()
    {
        $errors = [];

        $dataForm = [
            'user_id' => $this->session->getUserId(),
            'address' => $_POST['address'] ?? '',
            'city' => $_POST['city'] ?? '',
            'state' => $_POST['state'] ?? '',
            'zipcode' => $_POST['zipcode'] ?? '',
            'country' => $_POST['country'] ?? ''
        ];

        $errors = $this->validateAddress();

        if (count($errors)) {
            $this->showErrorsChangingAddress($dataForm, $errors);
            return;
        }

        $errors = $this->createAddress($dataForm);

        if (count($errors)) {
            $this->showErrorsChangingAddress($dataForm, $errors);
            return;
        }

        $data = [
            'titulo' => 'Forma de pago'
        ];

        $this->view('carts/paymentmode', $data);
    }

    public function createAddress($addressDTO)
    {
        $errors = [];

        if (!$this->model->createAddress($addressDTO)) {
            $errors[] = 'Error en la creación de la dirección';
        }

        return $errors;
    }

    public function validateAddress()
    {
        $errors = [];

        $address = $_POST['address'] ?? '';
        $city = $_POST['city'] ?? '';
        $state = $_POST['state'] ?? '';
        $zipcode = $_POST['zipcode'] ?? '';
        $country = $_POST['country'] ?? '';

        $errors = Validate::validateName($address,$errors);
        $errors =Validate::validateInputWithoutNumbers($city,$errors, 'Ciudad');
        $errors = Validate::validateName($city,$errors);
        $errors = Validate::validateName($state,$errors);
        $errors =Validate::validateInputWithoutNumbers($state,$errors, 'Provincia');
        $errors = Validate::validateName($country,$errors);
        $errors =Validate::validateInputWithoutNumbers($country, $errors, 'País');
        $errors = Validate::validateZipcode($zipcode,$errors);

        return $errors;
    }

    public function showErrorsChangingAddress($dataForm = [], $errors = []){
        $data = [
            'titulo' => 'Cambiar dirección',
            'menu'   => true,
            'errors' => $errors,
            'dataForm' => $dataForm
        ];

        $this->view('address/update', $data);
    }

    public function findAddressByUserId($userId)
    {
        return $this->model->findAddressByUserId($userId);
    }
}