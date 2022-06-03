<?php
session_start();
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Filtrar procesos</title>
    <style>
        body {
            background-color: whitesmoke;
        }

        .list-group-item {
            color: #c1c1c1;
            font-style: italic;
            font-size: 12px;
            font-weight: 500;
            background: #e9ecef;
            background: linear-gradient(to right, #f1f1f1, #f5f5f57a);
        }

        .tituloCard {
            text-align: left;
            font-weight: 500;
            color: #df0808;
            font-style: italic;
        }

        .btn-success {
            border: none;
            color: #fff;
            font-weight: 500;
            background-color: #de0303;
        }

        .btn-success:hover {
            border: none;
            color: #fff;
            font-weight: 500;
            background-color: #ec1414;
        }

        .tarjeta {
            background-color: white;
            border-radius: 5px;
            padding: 20px;
            border: 1px solid #e7e7e7de;
            display: block;
            margin-right: auto;
            box-shadow: 20px 20px 1px 1px #f0f0f0;
            margin-left: auto;

        }

        label {
            font-size: 12px;
            color: gray;
        }

        .form-label {
            font-size: 10px;
            color: rgb(196, 196, 196);
        }



        input {
            color: gray;
            font-size: 12px !important;
        }

        .date {
            color: gray;
            font-weight: 500;
        }

        .labelSwitch {
            color: rgb(199, 199, 199);
            float: right;
            font-size: 10px;
        }

        .labelSwitchChecked {
            color: #219c63;
            float: right;
            font-weight: 500;
            font-size: 10px;
        }

        .activ {

            color: #505458;
            cursor: pointer;

        }

        .activ:hover {
            color: whitesmoke;
            cursor: pointer;
            background: #de0303;
        }


        hr {
            background-color: rgb(198, 198, 198);
        }
    </style>
</head>

<body>
    <?php include("../librerias_2017/cabecera.php"); ?>

    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-xl-12 col-lg-12 mt-3 mb-3">
                <div class="tarjeta" style="width: 38rem;">
                    <button class="btn btn-primary mb-4">Cruzar</button>
                    <hr>
                    <form action="Controllers/filtroSeleccionado.php" autocomplete="on" method="GET">
                        <div class="form-check form-switch" style="position:relative;right:10px;float:right">
                            <label class="form-check-label" for="flexSwitchCheckChecked">Filtrar por actuaciones</label>
                            <input class="form-check-input" type="checkbox" name="ok" value="ok" id="flexSwitchCheckChecked">
                        </div>
                        <span class="tituloCard">Codigo23</span>
                        <input id="codigo23" class="form-control mb-4 mt-3" type="text" placeholder="Ingresa un codigo23" id="codigo23" name="cod23">


                        <span class="tituloCard">Anotaciones</span>
                        <input id="anotaciones" class="form-control mb-4 mt-3" type="text" placeholder="Ingresa palabras claves" name="anotaciones">

                        <div class="row">
                            <div class="col-sm-12 col-md-8 col-lg-6 col-xl-6">

                                <span class="tituloCard">Buscar por</span>
                                <div class="form-check mt-4">
                                    <input class="form-check-input" required type="radio" value="Actuaciones.fechaActuacion" checked name="llave" id="f_a">
                                    <label class="form-check-label" for="flexRadioDisabled1">
                                        Fecha de actuaciones
                                    </label>
                                </div>
                                <div class="dropdown-divider"></div>
                                <div class="form-check">
                                    <input class="form-check-input" required type="radio" value="Actuaciones.fechaInicial" name="llave" id="flexRadioCheckedDisabled2">
                                    <label class="form-check-label" for="flexRadioCheckedDisabled2">
                                        Fecha de inicio termino
                                    </label>
                                </div>
                                <div class="dropdown-divider"></div>

                                <div class="form-check">
                                    <input class="form-check-input" required type="radio" value="Actuaciones.fechaFinal" name="llave" id="flexRadioCheckedDisabled3">
                                    <label class="form-check-label" for="flexRadioCheckedDisabled3">
                                        Fecha de fin termino
                                    </label>
                                </div>
                                <div class="dropdown-divider"></div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" required value="Actuaciones.fechaRegistro" name="llave" id="flexRadioCheckedDisabled4">
                                    <label class="form-check-label" for="flexRadioCheckedDisabled4">
                                        Fecha de registro
                                    </label>
                                </div>
                                <div class="dropdown-divider mb-5 mt-4"></div>

                                <span class="tituloCard">Rango de fecha</span>
                                <div class="mb-3 mt-3">
                                    <label for="" class="form-label">Desde</label>
                                    <input class="form-control date" required name="desde" id="desde" type="date" placeholder="" aria-label="">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Hasta</label>
                                    <input required class="form-control date" name="hasta" id="hasta" type="date" placeholder="" aria-label="">
                                </div>
                                <div class="d-grid gap-2">
                                    <a type="button" onclick="sendFilter()" class="mt-2 btn btn-success">
                                        Buscar
                                    </a>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4 col-lg-6 col-xl-6">

                                <div id="cajonListas" class="mb-3" style="margin-left:10px" onclick="listPressed()">

                                    <span class="tituloCard">Actuaciones</span>
                                    <input class="form-control mt-3" name="act" oninput="validateKeywords()" id="clavesActuaciones" type="text" placeholder="Ingresa palabras claves" aria-label="">
                                    <ul class="list-group" id="palabrasEncontradas" style="overflow:scroll;height:auto;max-height:438px;">

                                    </ul>
                                </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="Js_Controllers/funciones.js"></script>
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js">
    </script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="sweetalert2.all.min.js"></script>

    <script>
        function sendFilter() {
            let desde = document.getElementById("desde").value;
            let codigo23 = document.getElementById("codigo23").value;
            let hasta = document.getElementById("hasta").value;
            let flexSwitchCheckChecked = document.getElementById("flexSwitchCheckChecked").checked;
            let anotaciones = document.getElementById("anotaciones").value;
            let anots = anotaciones;
            let act = document.getElementById("clavesActuaciones").value;
            let acts = act;
            let llave = document.querySelector('input[name="llave"]:checked').value;

            // desde - hasta - llave
            if (desde.length > 0 && hasta.length > 0 && llave.length > 0) {
                if (flexSwitchCheckChecked) {
                    if (anots.length <= 0 && acts.length <= 0 && codigo23.length <= 0) {
                        let url = "Controllers/filtroSeleccionado.php?ok=ok&desde=" + desde + "&hasta=" + hasta + "&llave=" +
                            llave;
                        window.open(url, '_blank');
                    }
                    // desde - hasta - llave - anotaciones
                    if (anots.length > 0 && acts.length <= 0 && codigo23.length <= 0) {
                        let url = "Controllers/filtroSeleccionado.php?ok=ok&desde=" + desde + "&hasta=" + hasta + "&llave=" +
                            llave +
                            "&anotaciones=" + anots;
                        window.open(url, '_blank');
                    }
                    // desde - hasta - llave - actuaciones
                    if (anots.length <= 0 && acts.length > 0 && codigo23.length <= 0) {
                        let url = "Controllers/filtroSeleccionado.php?ok=ok&desde=" + desde + "&hasta=" + hasta + "&llave=" +
                            llave +
                            "&act=" + acts;
                        window.open(url, '_blank');
                    }

                    // desde - hasta - llave - codigo23
                    if (anots.length <= 0 && acts.length <= 0 && codigo23.length > 0) {
                        let url = "Controllers/filtroSeleccionado.php?ok=ok&desde=" + desde + "&hasta=" + hasta + "&llave=" +
                            llave +
                            "&codigo23=" + codigo23;
                        window.open(url, '_blank');
                    }

                    // desde - hasta - llave - anotaciones - actuaciones
                    if (anots.length > 0 && acts.length > 0 && codigo23.length <= 0) {
                        let url = "Controllers/filtroSeleccionado.php?ok=ok&desde=" + desde + "&hasta=" + hasta +
                            "&llave=" +
                            llave +
                            "&anotaciones=" + anots + "&act=" + acts;
                        window.open(url, '_blank');
                    }
                } else {
                    if (anots.length <= 0 && acts.length <= 0 && codigo23.length <= 0) {
                        let url = "Controllers/filtroSeleccionado.php?desde=" + desde + "&hasta=" + hasta + "&llave=" +
                            llave;
                        window.open(url, '_blank');
                    }
                    // desde - hasta - llave - anotaciones
                    if (anots.length > 0 && acts.length <= 0 && codigo23.length <= 0) {
                        let url = "Controllers/filtroSeleccionado.php?desde=" + desde + "&hasta=" + hasta + "&llave=" +
                            llave +
                            "&anotaciones=" + anots;
                        window.open(url, '_blank');
                    }
                    // desde - hasta - llave - actuaciones
                    if (anots.length <= 0 && acts.length > 0 && codigo23.length <= 0) {
                        let url = "Controllers/filtroSeleccionado.php?desde=" + desde + "&hasta=" + hasta + "&llave=" +
                            llave +
                            "&act=" + acts;
                        window.open(url, '_blank');
                    }
                    // desde - hasta - llave - anotaciones - actuaciones
                    if (anots.length > 0 && acts.length > 0 && codigo23.length <= 0) {
                        let url = "Controllers/filtroSeleccionado.php?desde=" + desde + "&hasta=" + hasta + "&llave=" +
                            llave +
                            "&anotaciones=" + anots + "&act=" + acts;
                        window.open(url, '_blank');
                    }
                    // desde - hasta - llave - codigo23
                    if (anots.length <= 0 && acts.length <= 0 && codigo23.length > 0) {
                        let url = "Controllers/filtroSeleccionado.php?desde=" + desde + "&hasta=" + hasta + "&llave=" +
                            llave +
                            "&codigo23=" + codigo23;
                        window.open(url, '_blank');
                    }
                    // desde - hasta - llave - codigo23

                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Debes seleccionar un rango de fecha'
                });
            }
        }
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
</body>

</html>