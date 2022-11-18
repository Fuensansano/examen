<?php include_once(VIEWS . 'header.php') ?>
    <div class="card" id="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= ROOT . 'login/index' ?>">Iniciar sesión</a></li>
                <li class="breadcrumb-item">Datos de envío</li>
                <li class="breadcrumb-item"><a href="#">Forma de pago</a></li>
                <li class="breadcrumb-item"><a href="#">Verifica los datos</a></li>
            </ol>
        </nav>
        <div class="card-header">
            <h1>Datos de envío</h1>
            <p>Por favor, compruebe los datos de envío y cambie lo que considere necesario</p>
        </div>
        <div class="card-body">
            <form action="<?= ROOT ?>address/changeAddress/" method="POST">
                <?php include_once(VIEWS . 'shared/addressfields.php')?>
                <div class="form-group text-left">
                    <input type="submit" value="Cambiar dirección" class="btn btn-success" role="button">
                </div>
            </form>
        </div>

    </div>
<?php include_once(VIEWS . 'footer.php') ?>