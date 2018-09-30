<?php
  $data = file_get_contents("datos.json");
  $info = json_decode($data);

if(isset($_GET['Q']))
{
    $q = $_GET['Q'];
    echo json_encode($info->dependencias[$q-1]->subdependencias);
}

?>
