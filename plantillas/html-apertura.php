<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php
        if (!isset($titulo_documento) && empty($titulo_documento)) {
            $titulo_documento = "RSMgmt - El Cangrejo Dorado || Sistema de gestión El Cangrejo Dorado";
        }
        ?>
        <title><?php echo $titulo_documento; ?></title>
        <link rel="shortcut icon" href="<?php echo RUTA_IMG; ?>iconoLogo.png">
        <link rel="stylesheet" href="<?php echo RUTA_CSS; ?>all.min.css">
        <link rel="stylesheet" href="<?php echo RUTA_CSS; ?>estructura-principal.css">
        <link rel="stylesheet" href="<?php echo RUTA_CSS; ?>subelementos-bem.css">
        <!-- Agreado por el problema de conector de netbeans -->
        <link rel="shortcut icon" href="#" />
    </head>
    <body>
        <div class="cont_principal click_collapse">
