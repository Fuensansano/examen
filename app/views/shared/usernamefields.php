<div class="form-group text-left">
    <label for="first_name">Nombre:</label>
    <input type="text" name="first_name" id="first_name" class="form-control"
           required placeholder="Escriba su nombre"
           value="<?php isset($data['dataForm']['firstName']) ? print $data['dataForm']['firstName'] : '' ?>"
    >
</div>
<div class="form-group text-left">
    <label for="last_name_1">Apellido 1:</label>
    <input type="text" name="last_name_1" id="last_name_1" class="form-control"
           required placeholder="Escriba su primer apellido"
           value="<?php isset($data['dataForm']['lastName1']) ? print $data['dataForm']['lastName1'] : '' ?>"
    >
</div>
<div class="form-group text-left">
    <label for="last_name_2">Apellido 2:</label>
    <input type="text" name="last_name_2" id="last_name_2" class="form-control"
           placeholder="Escriba su segundo apellido"
           value="<?php isset($data['dataForm']['lastName2']) ? print $data['dataForm']['lastName2'] : '' ?>"
    >
</div>
