<?php
  date_default_timezone_set('America/Bogota');

  $data = file_get_contents("datos.json");
  $info = json_decode($data);
  if(isset($_POST['submit']))
  {
    $con_dep = $info->dependencias[(int)$_POST['dependencia']-1]->consecutivo;
    $con_subdep = $info->subdependencias[(int)$_POST['subdependencia']-1]->consecutivo;
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="css/estilos.css"> 
    <title>Universidad del Cauca</title>
  </head>
  <body onLoad="cambiarContenido()">
    <header id="cabecera">
      <h1>Universidad del Cauca
      <br>Dependencias</h1>
    </header>
    <main id="_contenido">
      <form id="form" action="index.php" method="post">
        <table>
          <tr>
            <td>
              <select name="dependencia" id="dependencia">
                <option value="0" >--Seleccione</option>                  
                <?php for($i = 0; $i < count($info->dependencias); $i++) {?>
                <option value="<?=($i+1)?>"><?=$info->dependencias[$i]->nombre?></option><?php }?>
                </select>
            </td>
            <td>
              <select id="subdependencias" name="subdependencia">
                <option value="0">--Seleccione</option>
              </select>
            </td>
            <td>
              <input type="submit" name="btnCalcular" value="Calcular">
            </td>
          </tr>
        </table>            
      </form>
      <hr>
      <section>
        <h2 id="titulo"></h2>
        <p id="texto"></p>
        <div id="codigo"></div>
      </section>
    </main>
    <footer id="pie">
        <p>Todos los derechos reservados - 2018© </p>
    </footer>

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

        function cambiarContenido(){
            $valor = $_POST["dependencia"];
            var dependencia = document.getElementById("dependencia").value;
            if(dependencia == 1){
              document.getElementById("titulo").innerHTML = "Decanatura";
              document.getElementById("texto").innerHTML = "Decanatura";
              document.getElementById("codigo").innerHTML = "1.";
              document.getElementById("codigo").style.backgroundColor = "blue";
            } else if(dependencia == 2){
              document.getElementById("titulo").innerHTML = "Departamento de sistemas";
              document.getElementById("texto").innerHTML = "Decanatura";
              document.getElementById("codigo").style.backgroundColor = "yellow";
            } else if(dependencia == 3){
              document.getElementById("titulo").innerHTML = "Departamento de electrónica";
              document.getElementById("texto").innerHTML = "Decanatura";
              document.getElementById("codigo").style.backgroundColor = "green";
            } else {
              document.getElementById("titulo").innerHTML = "Dependencias de la Universidad del Cauca";
              document.getElementById("texto").innerHTML = "Seleccione la dependencia y la subdependencia, luego presione el botón Calcular. La aplicación despliega el nombre de la dependencia, una breve descripción y el número consecutivo.";
            }
        }

        var x = document.querySelector("#dependencia");
        x.addEventListener('change', function(evt){
            makeRequest('cargarDatos.php?Q='+x.value);
        });
    </script>
    <span style="cursor: pstyle="cursor: pointer; text-decoration: underline" onclick="makeRequest('index.php?Q=1')">
        Hacer una petición
    </span>
          
  </body>
  </html>