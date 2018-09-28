<?php


  date_default_timezone_set('America/Bogota');

 
  $data = file_get_contents("datos.json");
  $info = json_decode($data);
  if(isset($_POST['submit']))
  {
    $con_dep = $info->dependencias[(int)$_POST['dependencia']]->consecutivo;
    $con_subdep = $info->subdependencias[(int)$_POST['subdependencia']]->consecutivo;
  }

      
/*
if(isset($_GET['Q']))
{
    $q = $_GET['Q'];
    echo $info->dependencias[$q]->subdependencias[0]->nombre;
}*/


  //$dependencia = $info
  /*
  echo '<pre>';
  var_dump($info);
  echo '</pre>';

  echo '<pre>';
  var_dump($info->dependencias);
  echo '</pre>';

  foreach($info->dependencias as $dep)
  {
    echo $dep->nombre;
    echo '<br>--------------------<br>';    
  }
*/
  ?>

  <!DOCTYPE html>
  <html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title>Document</title>
  </head>
  <body>
      <h1>Ejemplo</h1>
      <div class="botom">
        <form action="index.php" method="post">
          
       
            <select name="dependencia" id="dependencia" >
                <option value="0">--Seleccione</option>
                <?php for($i = 0; $i < count($info->dependencias); $i++) {?>
                    <option value="<?=($i+1)?>"><?=$info->dependencias[$i]->nombre?></option>
                <?php }?>
            </select>

            <select id="subdependencias" name="subdependencia">
                <option value="0">--Seleccione</option>
            </select>
            <input type="submit" name="submit" value="Calcular">
      </form>
      </div>

      <script type="text/javascript" language="javascript">

var http_request = false;

function makeRequest(url) {

    http_request = false;

    if (window.XMLHttpRequest) { // Mozilla, Safari,...
        http_request = new XMLHttpRequest();
        if (http_request.overrideMimeType) {
            http_request.overrideMimeType('text/json');
            // Ver nota sobre esta linea al final
        }
    } else if (window.ActiveXObject) { // IE
        try {
            http_request = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try {
                http_request = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {}
        }
    }

    if (!http_request) {
        alert('Falla :( No es posible crear una instancia XMLHTTP');
        return false;
    }
    http_request.onreadystatechange = alertContents;
    http_request.open('GET', url, true);
    http_request.send();

}

function alertContents() {

    if (http_request.readyState == 4) {
        if (http_request.status == 200) {
            var respuesta = JSON.parse(http_request.responseText);
            var seleccionar = document.querySelector("#subdependencias");
            var html = '<option value="0">--Seleccione</option>';
            respuesta.forEach((e, i) => {
                html += '<option value="' + (i+1) + '">' + e.nombre + '</option>';
            });
            seleccionar.innerHTML = html;
        } else {
            alert('Hubo problemas con la petición.');
        }
    }

}

var x = document.querySelector("#dependencia");
x.addEventListener('change', function(evt){
    makeRequest('cargarDatos.php?Q='+x.value);
});
</script>
<span
style="cursor: pointer; text-decoration: underline"
onclick="makeRequest('index.php?Q=1')">
    Hacer una petición
</span>
          
  </body>
  </html>