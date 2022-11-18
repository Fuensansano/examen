<?php include_once(VIEWS . 'header.php') ?>
    <div class="card p-4 bg-light">
        <div class="card-header">
            <h1 class="text-center"><?php $data['titulo'] ?></h1>
        </div>
        <div class="card-body">
            Dirección: <?= $data['data']->address ?><br>
            Ciudad:	<?= $data['data']->city ?><br>
            Estado: <?= $data['data'] -> state ?><br>
            Código Postal: <?= $data['data']-> zipcode ?><br>
            País: <?= $data['data']-> country ?><br>
        </div>
        <div class="card-footer">
            <a href="<?= ROOT ?>address/showChangeAddressForm" class="btn btn-success" role="button">
                Cambiar Dirección
            </a>
            <a href="<?= ROOT ?>cart/paymentmode" class="btn btn-info" role="button">
                Continuar
            </a>
        </div>
    </div>
<?php include_once(VIEWS . 'footer.php') ?>