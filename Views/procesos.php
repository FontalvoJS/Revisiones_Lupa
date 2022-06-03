<?php
$resultado = array_values(array_unique($result, SORT_REGULAR));

$data_aux = [];
if ($_GET['llave'] == "Actuaciones.fechaActuacion") {
    $tipo = "Fecha de actuacion";
}
if ($_GET['llave'] == "Actuaciones.fechaInicial") {
    $tipo = "Fecha de inicio término";
}
if ($_GET['llave'] == "Actuaciones.fechaFinal") {
    $tipo = "Fecha final término";
}
if ($_GET['llave'] == "Actuaciones.fechaRegistro") {
    $tipo = "Fecha de registro";
}
if (!isset($_GET['act'])) {
    $act = "Sin actuación";
} else {
    $act = $_GET['act'];
}
if (!isset($_GET['anotaciones'])) {
    $anots = "Sin anotaciones";
} else {
    $anots = $_GET['anotaciones'];
}
if (!isset($_GET['codigo23'])) {
    $co23 = "Sin codigo23";
} else {
    $co23 = $_GET['codigo23'];
}

?>

<!doctype html>
<html lang="en">


<head>
    <!-- Required meta tags -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>

    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>


    <!-- Bootstrap CSS -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <title>Procesos filtrados | <?php echo $_GET['desde'] ?></title>
    <style>
        .detalles span b {
            font-weight: 500;
            font-size: 12px;
            color: #dc3545;
        }

        label {
            color: gray;
        }

        .list-group-item:hover {
            cursor: pointer;
            transition: 0.3s;
            border-radius: 3px;
            background-color: #dbdbdb;
            border-bottom: 2px solid #b3b3b3;
        }



        .detalles span {
            color: #8c8c8c;
            font-size: 11px;
            font-weight: 400;
        }

        #detall {
            background-color: white;
        }

        .detalles {
            border-bottom: 4px solid #e7e7e7;
            -webkit-box-shadow: 0px 5px 38px 0px rgba(230, 230, 230, 1);
            -moz-box-shadow: 0px 5px 38px 0px rgba(230, 230, 230, 1);
            box-shadow: 0px 5px 38px 0px rgba(230, 230, 230, 1);
            padding: 20px;
            border-radius: 5px;
            background-color: white;
        }

        @-webkit-keyframes spin {
            100% {
                transform: rotate(360deg);
            }
        }

        @-moz-keyframes spin {
            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes spin {
            100% {
                transform: rotate(360deg);
            }
        }

        #preloader {
            background-color: whitesmoke;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 9999;
        }

        #status {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            box-shadow: 0px 0px 0px 1px rgba(0, 0, 0, 0.1), 2px 1px 0px #333365;
            position: absolute;
            top: 50%;
            left: 50%;
            margin-top: -25px;
            margin-left: -25px;
            -webkit-animation: spin 0.9s linear infinite;
            -o-animation: spin 0.9s linear infinite;
            -o-animation: spin 0.9s linear infinite;
            animation: spin 0.9s linear infinite;
        }

        /* ======================= */
        body {
            font-family: 'Roboto', sans-serif !important;
            overflow: scroll !important;
        }

        .titulo {
            font-weight: 400;
            color: black;
            padding: 20px;
            border-radius: 10px;
        }

        #myTable_filter {
            margin-bottom: 3% !important;
        }

        .list-group-item {
            margin-bottom: 10px;
            background-color: #e9e9e9;
            color: #272a2d;
            font-size: 12px;
            font-weight: 600;
            border-left: 3px solid #198754 !important;
        }

        th {
            background-color: #ffffff !important;
            font-weight: 500 !important;
            color: black;
            text-transform: uppercase;
            font-size: 14px;
            margin-bottom: 3%;
        }

        .card {
            -webkit-box-shadow: 0px 5px 17px 0px rgba(214, 214, 214, 1);
            -moz-box-shadow: 0px 5px 17px 0px rgba(214, 214, 214, 1);
            box-shadow: 0px 5px 17px 0px rgba(214, 214, 214, 1);
            border: none !important;
        }



        td {
            text-transform: uppercase;
            font-size: 12px;
            color: #656565;
            border: none;

        }

        .jumbotron {
            padding: 20px;
            border-radius: 10px;
        }

        html {
            scroll-behavior: smooth;
        }

        label {
            font-size: 10px;
            color: black;
            font-weight: 500;
        }

        .demandante {
            font-style: italic;
        }

        .itemPrincipal {
            font-weight: 400;
            color: whitesmoke;
            background: #ff3838;
        }

        .angles {
            color: #bdbdbd;
            margin-left: 5px;
            font-size: 14px;
        }

        #totalDespachos {
            color: white;
            font-size: 14px;
            position: relative;
            top: -3px;
        }

        #totalDespachos2 {
            color: white;
            font-size: 14px;
            position: relative;
            top: -3px;
        }
    </style>

</head>

<body style="overflow:scroll !important">
    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="detalles mt-3">
                    <span id="desd"><b>Desde:</b> <?php echo $_GET['desde'] ?></span> |
                    <span id="hast"><b>Hasta:</b> <?php echo $_GET['hasta'] ?></span> |
                    <span><b>Clave:</b> <?php echo $tipo; ?></span> |
                    <span><b>Actuación:</b> <?php echo $act; ?></span> |
                    <span><b>Anotación:</b> <?php echo $anots; ?></span> |
                    <span><b>Codigo23:</b> <?php echo $co23; ?></span>

                    <a type="button" style="float:right;position:relative;bottom:7px;margin-right:5px;" id="revision" onclick="revisionTrue()" class="btn btn-success"><i class="fas fa-registered"></i></a>
                    <a type="button" style="float:right;position:relative;bottom:7px;margin-right:5px;" id="procc" onclick="comprobarProcesos()" class="btn btn-success"><i class="fas fa-check"></i></a>
                </div>
            </div>

            <div class="col-sm-12 col-md-8 col-lg-8 col-xl-8">
                <div class="detalles mt-3 d-none" id="detall">
                    <h5 style="color:#313131;padding-left:20px">Despachos que publicaron <span id="totalDespachos" class="badge bg-success"></span> <span class="text-dark" style="float:right;cursor:pointer;font-weight:500" onclick="document.getElementById('detall').classList.add('d-none');">X</span></h4>
                        <hr style="background-color:gray">
                        <ul class="list-group  list-group-flush" style="padding:20px;height:400px;overflow:auto" id="procesos">
                        </ul>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <div class="detalles mt-3 d-none" id="detall2">
                    <h5 style="color:#313131;padding-left:20px">No existen en LUPA CPJ <span id="totalDespachos2" class="badge bg-danger"></span> <span class="text-dark " style="float:right;cursor:pointer;font-weight:500" onclick="document.getElementById('detall2').classList.add('d-none');">X</span></h5>
                    <hr style="background-color:gray">
                    <ul class="list-group  list-group-flush" style="padding:20px;height:400px;overflow:auto" id="procesosIgnorados">
                    </ul>
                </div>
            </div>

            <div class="col-12">
                <div class="card mt-4">
                    <div class="card-body">
                        <table class="table mt-5 table-striped" id="myTable">
                            <thead style="border-radius:3px">
                                <tr>
                                    <th scope="col">Codigo</th>
                                    <th scope="col" class="d-none" id="revisionesTH">Revision</th>
                                    <th scope="col">Demandante</th>
                                    <th scope="col">Demandado</th>
                                    <th scope="col">Despacho</th>
                                    <th scope="col">Departamento</th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                for ($i = 0; $i < count($resultado); $i++) {

                                    if (isset($resultado[$i]["Sujetos"])) {
                                        $dde = $ddo = [];
                                        foreach ($resultado[$i]["Sujetos"] as $v) {
                                            if (preg_match("/demandante|accionante/i", mb_strtolower(@$v["tipoSujeto"])))
                                                $dde[] = @$v["nombreRazonSocial"];
                                            if (preg_match("/demandado|indiciado|causante/i", mb_strtolower(@$v["tipoSujeto"])))
                                                $ddo[] = @$v["nombreRazonSocial"];
                                        }

                                        $data_aux["DEMANDANTES"] = implode(',', $dde);
                                        $data_aux["DEMANDADOS"]  = implode(',', $ddo);
                                    }

                                ?>

                                    <?php
                                    echo   '<tr>
                                            <td>' . $resultado[$i]['codigo23'] . '</td>
                                            <td class="enRevision d-none"></td>
                                            <td>' . $data_aux['DEMANDANTES'] . '</td>
                                            <td>' . $data_aux['DEMANDADOS'] . '</td>
                                            <td id="' . $resultado[$i]['Resumen']['despacho'] . '">' . $resultado[$i]['Resumen']['despacho'] . '</td>
                                            <td>' . $resultado[$i]['Resumen']['departamento'] . '</td>

                                            <td><a type="button" target="_blank" class="btn btn-outline-success" href="ctr_codigoSeleccionado.php?cod23=' . $resultado[$i]['codigo23'] . '"><i class="fas fa-eye"></i></a></td>
                                            <td><button  class="btn btn-outline-info" value="' . $resultado[$i]['codigo23'] . '" onclick="redireccionACPJ()"><i class="fas fa-save"></i></button></td>

                                        </tr>';


                                    ?>

                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                        <hr>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


    <script>
        function comprobarProcesos() {
            let tr = document.getElementsByTagName('tr');
            let desd = document.getElementById('desd').textContent;
            let hast = document.getElementById('hast').textContent;
            let procc = document.getElementById('procc');
            let procesosEncontrados = [];
            let listGroup = document.getElementsByClassName('despalist');
            let procesoshtml = document.getElementById('procesos');
            let procesosIgnorados = document.getElementById('procesosIgnorados');

            let procesosEncontrados2 = [];
            let totalDespachos = document.getElementById('totalDespachos');
            let totalDespachos2 = document.getElementById('totalDespachos2');
            let detall = document.getElementById('detall');
            let detall2 = document.getElementById('detall2');

            let td = "";
            for (let i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName('td');
                if (td.length > 0) {
                    let proceso = td[0].innerHTML;
                    let despacho = td[4].innerHTML;

                    if (proceso.length > 0) {
                        procesosEncontrados[i] = proceso;
                        procesosEncontrados2[i] = despacho;

                    }
                }
            }

            fetch('../Controllers/comprobarDespachos.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json;charset=utf-8',
                        'Accept': 'application/json, text/plain, */*'
                    },
                    body: JSON.stringify({
                        procesos: procesosEncontrados,
                        despachos: procesosEncontrados2,
                        desde: desd,
                        hasta: hast
                    })
                })
                .then(response => {
                    return response.json()
                })
                .then(res => {
                    detall.classList.remove('d-none');
                    let u = 1;
                    let x = 1;
                    procc.innerHTML = "<i class='fas fa-check-double'></i>";
                    if (res.length > 0) {
                        procesoshtml.innerHTML = "";
                        for (let i = 0; i < res.length; i++) {
                            totalDespachos.innerHTML = x++;
                            procesoshtml.innerHTML += '<li class="list-group-item despalist"><b style="color:#198754; margin-right:5px">' + u++ + ') </b> ' + res[i] + '</li>';
                        }
                        // if (listGroup.length <= 0 || listGroup == false || listGroup == undefined || listGroup == null) {
                        //     procesoshtml.innerHTML += '<li class="list-group-item">No se encontraron juzgados sin publicar</li>';
                        // }
                    } else {
                        procesoshtml.innerHTML = "";
                        totalDespachos.innerHTML = 0;
                        procesoshtml.innerHTML += '<li class="list-group-item">No se encontraron juzgados sin publicar</li>';

                    }
                })
            fetch('../Controllers/verificarProcesosEnCPJ.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json;charset=utf-8',
                        'Accept': 'application/json, text/plain, */*'
                    },
                    body: JSON.stringify({
                        procesos: procesosEncontrados,
                    })
                })
                .then(response => {
                    return response.json()
                })
                .then(res => {
                    detall2.classList.remove('d-none');
                    procesosIgnorados.innerHTML = "";
                    let v = 1;
                    if (res.length > 0) {
                        for (let i = 0; i < res.length; i++) {
                            totalDespachos2.innerHTML = v++;
                            procesosIgnorados.innerHTML += '<li class="list-group-item" style="border-left:3px solid #ff4f4f !important"><b style="color:#ff4f4f; margin-right:5px">' + (i + 1) + ') </b> ' + res[i] + '</li>';
                        }
                    } else {
                        totalDespachos2.innerHTML = 0;
                        procesosIgnorados.innerHTML += '<li class="list-group-item">Todos los procesos se encontraron en Lupa CPJ</li>';
                    }
                })


        }

        function revisionTrue() {
            let tr = document.getElementsByTagName('tr');
            let td = "";
            let procesosEncontrados = [];
            let enRevision = document.getElementsByClassName('enRevision');
            let revisionesTH = document.getElementById('revisionesTH');

            for (let i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName('td');
                if (td.length > 0) {
                    let proceso = td[0].innerHTML;
                    if (proceso.length > 0) {
                        procesosEncontrados[i] = proceso;
                    }
                }
            }

            fetch('../Controllers/revisionesTrue.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json;charset=utf-8',
                        'Accept': 'application/json, text/plain, */*'
                    },
                    body: JSON.stringify({
                        procesos: procesosEncontrados,
                    })
                })
                .then(response => {
                    return response.json()
                })
                .then(res => {
                    revisionesTH.classList.remove('d-none');
                    let k = 1;
                    if (res) {
                        for (let i = 0; i < enRevision.length; i++) {
                            enRevision[i].classList.remove('d-none');
                            enRevision[i].innerHTML = res[k];
                            k++;
                        }
                    }
                })
        }

        function redireccionACPJ() {
            const controller = new AbortController()
            const signal = controller.signal;
            let btn_info = document.getElementsByClassName('btn-outline-info');
            for (i = 0; i < btn_info.length; i++) {
                btn_info[i].setAttribute('disabled', '');
            }
            setTimeout(function() {
                for (i = 0; i < btn_info.length; i++) {
                    btn_info[i].removeAttribute('disabled');
                }
            }, 5000);
            fetch('../Controllers/redireccionACPJ.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json;charset=utf-8',
                        'Accept': 'application/json, text/plain, */*'
                    },
                    body: JSON.stringify({
                        procesos: event.target.value
                    })
                })
                .then(response => {
                    return response.text()
                })
                .then(res => {
                    if (res == 'false' || res == '' || res == null || res == undefined || res == false || res == ' ') {
                        controller.abort();
                        console.log(res);
                        alert("No se pudo redireccionar a Captura Despacho Virtual porque el ID no se encuentra registrado en Lupa Despacho");
                    } else {
                        window.open("https://www.lupajuridica.com.co/prueba_laboratorio/Cartelera_Rama/captura_despacho.php?despacho_id=" + res, "_blank");
                    }
                })
        }

        $(document).ready(function() {
            $('#myTable').DataTable({
                dom: 'Bfrtip',
                paging: false,
                responsive: true,
                buttons: [
                    'excel'
                ],
                unique: true

            });
        });

        jQuery(window).on('load', function() {
            jQuery('#status').fadeOut();
            jQuery('#preloader').delay(350).fadeOut('slow');
            jQuery('body').delay(350).css({
                'overflow': 'visible'
            });
        })
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
</body>

</html>