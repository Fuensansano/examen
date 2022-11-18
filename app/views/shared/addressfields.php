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
    <label for="zipcode">Código postal:</label>
    <input type="text" name="zipcode" id="zipcode" class="form-control"
           required placeholder="Escriba su código postal"
           value="<?= $data['data']->zipcode ?? '' ?>">
</div>
<div class="form-group text-left">
    <label for="country">País:</label>
    <input type="text" name="country" id="country" class="form-control"
           required placeholder="Escriba su país"
           value="<?= $data['data']->country ?? '' ?>">
</div>