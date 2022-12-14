<?php

class Session
{
    private $login = false;
    private $user;
    private $admin;
    private $cartTotal;

    public function __construct()
    {
        if(!isset($_SESSION))
        {
            session_start();
        }

        if (isset($_SESSION['admin'])) {
            $this->admin = $_SESSION['admin'];
        } else {
            unset($this->admin);
        }

        if (isset($_SESSION['user'])) {
            $this->user = $_SESSION['user'];
            $this->login = true;
            $_SESSION['cartTotal'] = $this->cartTotal();
            $this->cartTotal = $_SESSION['cartTotal'];
        } else {
            unset($this->user);
            $this->login = false;
        }
    }

    public function login($user)
    {
        if ($user) {
            $this->user = $user;
            $_SESSION['user'] = $user;
            $this->login = true;
        }
    }

    public function logout()
    {
        unset($_SESSION['user']);
        unset($this->user);
        session_destroy();
        $this->login = false;
    }

    public function adminLogin($admin)
    {
        if ($admin) {
            $this->admin = $admin;
            $_SESSION['admin'] = $admin;
            $this->login = true;
        }
    }

    public function adminLogout()
    {
        unset($_SESSION['admin']);
        unset($this->admin);
        session_destroy();
        $this->login = false;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getUserId()
    {
        if (!isset($this->user, $this->user->id)) {
            return null;
        }
        return $this->user->id;
    }

    public function cartTotal()
    {
        if (!$this->getUserId()) {
            return 0;
        }

        $db = Mysqldb::getInstance()->getDatabase();

        $sql = 'SELECT sum(p.price * c.quantity) - sum(c.discount) + sum(c.send) as total
            FROM carts as c, products as p
            WHERE c.user_id=:user_id AND c.product_id=p.id AND c.state=0';
        $query = $db->prepare($sql);
        $query->execute([':user_id' => $this->getUserId()]);
        $data = $query->fetch(PDO::FETCH_OBJ);
        unset($db);

        return ($data->total ?? 0);
    }

    public function isAdmin(): bool
    {
        if (!isset($this->admin)) {
            return false;
        }
        return true;
    }
}