<?php

$url ='http://localhost/fabrics/API/Telas.php';
$json = file_get_contents($url);
$array = json_decode($json,true);
print_r($array);

$opts = array(
    'http'=>array(
      'method'=>"",
      'header'=>"Accept-language: en\r\n" .
                "Cookie: foo=bar\r\n"
    )
  );


$nueva_tela=[
    "nombre"=>"FITOLACA",
    "pais"=>"Alemania"
];


$opts = array('http' =>
        array(
            'method'  => 'POST',
            'header'  => 'Content-type: application/x-www-form-urlencoded',
            'content' => json_encode($nueva_tela)
        )
);


  
//$result = file_get_contents( 'http://localhost/fabrics/API/Telas.php', true, stream_context_create($opts ) );
//echo $result;


$optsEliminar = array('http' =>
        array(
            'method'  => 'DELETE',
            'header'  => 'Content-type: application/x-www-form-urlencoded',
            'content' => json_encode(["tela"=>6])
        )
);
//$result = file_get_contents( 'http://localhost/fabrics/API/Telas.php', true, stream_context_create($optsEliminar ) );
//echo $result;


?>
