<?php
  date_default_timezone_set('America/Bogota');

  $data = file_get_contents("datos.json");
  $info = json_decode($data);
  if(isset($_POST['submit']))
  {
    $con_dep = $info->dependencias[(int)$_POST['dependencia']-1]->consecutivo;
    $con_subdep = $info->subdependencias[(int)$_POST['subdependencia']-1]->consecutivo;
   /* $num_documento = $info->num_documento;*/
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
            <form action= "guardar.php" method="post" name="frm"> 
              <select name="dependencia" id="dependencia">
                <option value="0" >--Seleccione</option>                  
                <?php for($i = 0; $i < count($info->dependencias); $i++) {?>
                <option value="<?=($i+1)?>"><?=$info->dependencias[$i]->nombre?></option><?php }?>
                </select>
            </td>
            <td>
              <select name="subdependencia" id="subdependencias" onload="alertContents()">
                <option value="0">--Seleccione</option>
              </select>
            </td>
            <td>
              <input type="button" name="btnCalcular" value="Calcular Código" onClick="cambiarContenido()">
            </td>
          </tr>
        </table>  
        </form>          
      </form>
         
      <hr>
      <section>
        <h2 id="titulo"></h2>
        <p id="texto"></p>
        <div id="codigo" class="codigo"></div>
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
            var dependencia = document.getElementById("dependencia").value;
            var subDependencia = document.getElementById("subdependencias").value;
            var dep, subDep = "", codigo, num = "0";
            if(dependencia == 1){
              dep = "8.1."
              if(subDependencia == 1){
                subDep = "1/";
              } else if(subDependencia == 2){
                subDep = "2/";
              }
              codigo = dep.concat(subDep)
              document.getElementById("titulo").innerHTML = "Decanatura";
              document.getElementById("texto").style.backgroundColor = " #d5dbdb ";
              document.getElementById("texto").innerHTML = "La Decanatura es la oficina responsable de la dirección académica y administrativa de una facultad universitaria. La principal autoridad en ella es el Decano. ";
              document.getElementById("codigo").innerHTML = codigo;
              document.getElementById("codigo").style.backgroundColor = "gray";
            } else if(dependencia == 2){
              dep = "8.4."
              if(subDependencia == 1){
                subDep = "1/";
              } else if(subDependencia == 2){
                subDep = "2/";
              }
              codigo = dep.concat(subDep).concat(num);
              document.getElementById("titulo").innerHTML = "Departamento de sistemas";
              document.getElementById("texto").style.backgroundColor = "#49d5d5";
              document.getElementById("texto").innerHTML = "El Programa de Ingeniería de Sistemas pertenece a la Facultad de Ingeniería Electrónica y Telecomunicaciones de la Universidad del Cauca y fue creado mediante el Acuerdo Nº 030 de mayo de 1998, expedido por el Consejo Superior.";
              document.getElementById("codigo").innerHTML = codigo;
              document.getElementById("codigo").style.backgroundColor = "yellow";
            } else if(dependencia == 3){
              dep = "8.5."
              if(subDependencia == 1){
                subDep = "1/";
              } else if(subDependencia == 2){
                subDep = "2/";
              }
               codigo = dep.concat(subDep);
              document.getElementById("titulo").innerHTML = "Departamento de electrónica";
              document.getElementById("texto").style.backgroundColor = "#49d57e";
              document.getElementById("texto").innerHTML = "La Facultad de Ingeniería Electrónica y Telecomunicaciones de la Universidad del Cauca fue creada mediante Acuerdo No.40 del 17 de Diciembre de 1960, emanado del Comité Administrativo de la Asociación Colombiana de Universidades y el Fondo Universitario Nacional y refrendado por el Ministerio de Educación Nacional el 19 de Diciembre de 1960.";
              document.getElementById("codigo").innerHTML = codigo;
              document.getElementById("codigo").style.backgroundColor = "green";
            } else {
              document.getElementById("titulo").innerHTML = "Dependencias de la Universidad del Cauca";
              document.getElementById("texto").innerHTML = "Seleccione la dependencia y la subdependencia, luego presione el botón Calcular. La aplicación despliega el nombre de la dependencia, una breve descripción y el número consecutivo.";
              document.getElementById("codigo").innerHTML = "";
            }
        }

        var x = document.querySelector("#dependencia");
        x.addEventListener('change', function(evt){
            makeRequest('cargarDatos.php?Q='+x.value);
        });
    </script>
    
          
  </body>
  </html>