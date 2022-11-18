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
                <div class="form-group text-left">
                    <label for="address">Dirección:</label>
                    <input type="text" name="address" id="address" class="form-control"
                           required placeholder="Escriba su dirección"
                           value="<?= $data['data']->address ?? '' ?>">
                </div>
                <div class="form-group text-left">
                    <label for="city">Ciudad:</label>
                    <input type="text" name="city" id="city" class="form-control"
                           required placeholder="Escriba su ciudad"
                           value="<?= $data['data']->city ?? '' ?>">
                </div>
                <div class="form-group text-left">
                    <label for="state">Provincia:</label>
                    <input type="text" name="state" id="state" class="form-control"
                           required placeholder="Escriba su provincia"
                           value="<?= $data['data']->state ?? '' ?>">
                </div>
                <div class="form-group text-left">
                    <label for="postcode">Código postal:</label>
                    <input type="text" name="postcode" id="postcode" class="form-control"
                           required placeholder="Escriba su código postal"
                           value="<?= $data['data']->zipcode ?? '' ?>">
                </div>
                <div class="form-group text-left">
                    <label for="country">País:</label>
                    <input type="text" name="country" id="country" class="form-control"
                           required placeholder="Escriba su país"
                           value="<?= $data['data']->country ?? '' ?>">
                </div>
                <div class="form-group text-left">
                    <input type="submit" value="Cambiar dirección" class="btn btn-success" role="button">
                </div>
            </form>
        </div>

    </div>

<?php include_once(VIEWS . 'footer.php') ?>