<?php

class AdminShopController extends Controller
{
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = $this->model('AdminShop');
    }

    public function index()
    {
        if ($this->session->isAdmin()) {
            $data = [
                'titulo' => 'Bienvenid@ a la administración de la tienda',
                'menu' => false,
                'admin' => true,
                'subtitle' => 'Administración de la tienda',
            ];
            $this->view('admin/shop/index', $data);
        } else {
            header('LOCATION:' . ROOT . 'admin');
        }
    }
}