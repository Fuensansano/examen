<?php

class Validate
{
    const REGEX_NUMBER = '/[0-9]+/m';
    const MIN_LENGTH_NAME = 3;
    const MIN_VALUE_PRICE = 0;

    public static function number($string)
    {
        $search = [' ', '€', '$', ','];
        $replace = ['', '', '', ''];

        return str_replace($search, $replace, $string);
    }

    public static function date($string)
    {
        $date = explode('-', $string);

        if (count($date) == 1) {
            return false;
        }

        return checkdate($date[1], $date[2], $date[0]);
    }

    public static function dateDif($string)
    {
        $now = new DateTime();
        $date = new DateTime($string);

        return ($date > $now);
    }

    public static function file($string)
    {
        $search = [' ', '*', '!', '@', '?', 'á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú', 'ñ', 'Ñ', 'ü', 'Ü', '¿', '¡'];
        $replace = ['-', '', '', '', '', 'a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U', 'n', 'N', 'u', 'U', '', ''];
        $file = str_replace($search,$replace, $string);

        return $file;
    }

    public static function resizeImage($image, $newWidth)
    {
        $file = 'img/' . $image;

        $info = getimagesize($file);
        $width = $info[0];
        $height = $info[1];
        $type = $info['mime'];

        $factor = $newWidth / $width;
        $newHeight = round($factor * $height,0, PHP_ROUND_HALF_DOWN);


        if ($info[2] == IMAGETYPE_JPEG) {
            $image = imagecreatefromjpeg($file);
        } else {
            $image =imagecreatefrompng($file);
        }

        $canvas = imagecreatetruecolor($newWidth, $newHeight);

        imagecopyresampled($canvas, $image, 0,0,0,0,$newWidth, $newHeight,$width, $height);

        imagejpeg($canvas, $file, 80);
    }

    public static function text($string)
    {
        $search = ['^', 'delete', 'drop', 'truncate', 'exec', 'system'];
        $replace = ['-', 'dele*te', 'dr*op', 'trunca*te', 'ex*ec', 'syst*em'];
        $string = str_replace($search, $replace, $string);
        $string = addslashes(htmlentities($string));

        return $string;
    }

    public static function imageFile($file)
    {
        $imageArray = getimagesize($file);
        $imageType = $imageArray[2];

        return (bool)(in_array($imageType, [IMAGETYPE_JPEG, IMAGETYPE_PNG], true));
    }

    public static function validateName($name, $errors)
    {
        if (empty($name)) {
            $errors[] = 'este campo es requerido';
        }

        if (strlen($name) < self::MIN_LENGTH_NAME) {
            $errors[] = 'La longitud mínima del nombre tiene que ser de 3 caracteres';
        }
        return $errors;
    }

    public static function validateDescription($description, $errors)
    {
        if (empty($description)) {
            $errors[] = 'La description del producto es necesaria';
        }

        return $errors;
    }

    public static function validatePrice($price, $errors)
    {
        if (!is_numeric($price)) {
            $errors[] = 'El precio tiene que ser un valor numérico';
        }

        if ($price < self::MIN_VALUE_PRICE) {
            $errors[] = 'El precio no puede ser negativo';
        }

        return $errors;
    }

    public static function validateDiscount($discount, $errors)
    {
        if (!is_numeric($discount)) {
            $errors[] = 'El descuento del producto debe de ser un número';
        }
        if ($discount < self::MIN_VALUE_PRICE) {
            $errors[] = 'El descuento del producto o puede ser un número';
        }
        return $errors;
    }

    public static function validateSendPrice($send, $errors)
    {
        if (!is_numeric($send)) {
            $errors[] = 'Los gastos de envío del producto deben de ser numéricos';
        }
        return $errors;
    }

    public static function validateDiscountLowerThanPrice($discount, $price, $errors)
    {
        if (is_numeric($price) && is_numeric($discount) && $price < $discount) {
            $errors[] = 'El descuento no puede ser mayor que el precio';
        }
        return $errors;
    }

    public static function validatePublishedDate($published, $errors)
    {
        if (!Validate::date($published)) {
            $errors[] = 'La fecha o su formato no es correcto';
        } elseif (!Validate::dateDiff($published)) {
            $errors[] = 'La fecha de publicación no puede ser anterior a hoy';
        }
        return $errors;
    }

    public static function validateZipcode($zipcode,$errors)
    {
        if (strlen($zipcode) < 3 || strlen($zipcode) > 5) {
            $errors[] = 'longitud del codigo postal inadecuada';
        }
        if (!preg_match(self::REGEX_NUMBER, $zipcode)){
            $errors[] = 'El formato del código postal tiene que ser sólo numérico';
        }

        return $errors;
    }

    public static function validateInputWithoutNumbers($name, $errors, $fieldName)
    {
        if (preg_match(self::REGEX_NUMBER, $name)){
            $errors[] = "El campo $fieldName no puede contener número.";
        }

        return $errors;
    }

    public static function validateEmail($email,$errors)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Esta dirección de correo no es válida.";
        }

        return $errors;
    }

    public static function validatePassword1SameAsPassword2($password1, $password2, $errors)
    {
        if ($password1 !== $password2) {
            $errors[] = "Las contraseñas no coinciden.";
        }

        return $errors;
    }
}