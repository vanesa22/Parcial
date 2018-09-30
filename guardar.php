<? php

    $fi=fopen("archivo.txt","a")
    or die("problema al crear archivo");

    fwrite($fi,"Nombre Dependencia: "):
    fwrite($fi," \n"):
    fwrite($fi,$_POST['Dependencia']):
    fwrite($fi," \n"):
    fwrite($fi,"Nombre subdependencia: "):
    fwrite($fi," \n"):
    fwrite($fi,$_POST['Subdependencia']):
    fwrite($fi," \n"):

    fclose($fi);
    echo "Solicitud hecha";


?>