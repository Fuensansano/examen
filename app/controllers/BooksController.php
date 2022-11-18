<?php

class BooksController extends Controller
{
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = $this->model('Book');
    }

    public function index()
    {
        if ($this->session->getLogin()) {

            $books = $this->model->getBooks();

            $data = [
                'titulo' => 'Libros',
                'menu' => true,
                'active' => 'books',
                'data' => $books,
            ];

            $this->view('books/index', $data);

        } else {
            header('location:' . ROOT);
        }
    }
}