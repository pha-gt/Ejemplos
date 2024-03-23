<?php

    $mysqli = new mysqli("localhost", "root", "", "bd_fabrics");
    if (mysqli_connect_errno()) {
       printf("Connect failed: %s\n", mysqli_connect_error());
       exit();
    }
    printf("exito");

    $mysqli->close();


   
?>
