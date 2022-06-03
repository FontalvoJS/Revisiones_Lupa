<?php

$cod = $_GET['cod23'];
if (isset($result[0]["Sujetos"])) {
    $dde = $ddo = [];
    foreach ($result[0]["Sujetos"] as $v) {
        if (preg_match("/demandante|accionante/i", mb_strtolower(@$v["tipoSujeto"])))
            $dde[] = @$v["nombreRazonSocial"];
        if (preg_match("/demandado|indiciado|causante/i", mb_strtolower(@$v["tipoSujeto"])))
            $ddo[] = @$v["nombreRazonSocial"];
    }

    $data_aux["Demandantes"] = implode(',', $dde);
    $data_aux["Demandados"]  = implode(',', $ddo);

    if (!isset($data_aux['Demandantes']) || empty($data_aux['Demandantes']) || $data_aux['Demandantes'] == null || !$data_aux['Demandantes']) {
        $data_aux['Demandantes'] = "No disponible";
    }
    if (!isset($data_aux['Demandados']) || empty($data_aux['Demandados']) || $data_aux['Demandados'] == null || !$data_aux['Demandantes']) {
        $data_aux['Demandados'] = "No disponible";
    }
} else {
    $data_aux['Demandantes'] = "<span style='color:#d6d6d6'>No disponible</span>";
    $data_aux['Demandados'] = "<span style='color:#d6d6d6'>No disponible</span>";
}

$actuaciones = $result;
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
    <link href="//cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <title>Filtro | Revisiones diarias</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif !important;
        }

        .titulo {
            font-weight: 400;
            color: black;
            padding: 20px;
            border-radius: 10px;
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
            border: 1px solid #343a402e !important;
        }


        td {
            text-transform: uppercase;
            font-size: 12px;
            color: gray;
            border: none;
        }

        .jumbotron {
            padding: 20px;
            border-radius: 10px;
        }

        label {
            font-size: 10px;
            color: #ff5656;
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
    </style>

</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                <div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title d-inline-block"><?php echo $result[0]['Resumen']['departamento']; ?>
                        </h5>

                        <hr style="background-color:#bcbcbc" />
                        <p style="font-weight:400;font-style:italic"> <span style="color:red;position:relative"># </span>
                            <?php if (isset($cod) && !empty($cod)) {
                                echo $cod;
                            } ?>
                        </p>
                        <label>Demandantes</label>
                        <p class="demandante text-capitalize"><?php echo strtolower($data_aux['Demandantes']); ?></p>
                        <label>Demandados</label>
                        <p class="demandante text-capitalize"><?php echo strtolower($data_aux['Demandados']); ?></p>
                        <label>Despacho</label>
                        <p class="demandante text-capitalize"><?php echo strtolower($result[0]['Resumen']['despacho']); ?></p>
                        <hr>
                        <table class="table mt-5 table-striped" id="myTable">
                            <thead style="border-radius:3px">
                                <tr>
                                    <th scope="col">F. Actuacion</th>
                                    <th scope="col">Actuación</th>
                                    <th scope="col">Anotación</th>
                                    <th scope="col">F. inicio término</th>
                                    <th scope="col">F. final término</th>
                                    <th scope="col">F. registro</th>

                                </tr>
                            </thead>
                            <tbody>


                                <?php
                                $act = [];
                                if (isset($result[0]['Actuaciones']) && !empty($result[0]['Actuaciones'])) {
                                    for ($i = 0; $i < count($result[0]['Actuaciones']); $i++) {
                                        if (
                                            !isset($actuaciones[0]['Actuaciones'][$i]['anotacion'])  ||
                                            empty($actuaciones[0]['Actuaciones'][$i]['anotacion'])
                                        ) {
                                            $actuaciones[0]['Actuaciones'][$i]['anotacion'] = '<span style="color:#bababa" class="text-capitalize">No disponible</span>';
                                        }
                                        if (!isset($actuaciones[0]['Actuaciones'][$i]['fechaRegistro'])) {
                                            $actuaciones[0]['Actuaciones'][$i]['fechaRegistro'] = '<span style="color:#bababa" class="text-capitalize">No disponible</span>  &&||&&||-';
                                        }
                                        if (!isset($actuaciones[0]['Actuaciones'][$i]['fechaInicial'])) {
                                            $actuaciones[0]['Actuaciones'][$i]['fechaInicial'] = '<span style="color:#bababa" class="text-capitalize">No disponible</span>  &&||&&||-';
                                        }
                                        if (!isset($actuaciones[0]['Actuaciones'][$i]['fechaFinal'])) {
                                            $actuaciones[0]['Actuaciones'][$i]['fechaFinal'] = '<span style="color:#bababa" class="text-capitalize">No disponible</span>  &&||&&||-';
                                        }
                                        if (!isset($actuaciones[0]['Actuaciones'][$i]['actuacion'])) {
                                            $actuaciones[0]['Actuaciones'][$i]['actuacion'] = '<span style="color:#bababa" class="text-capitalize">No disponible</span>';
                                        }



                                ?>
                                        <?php
                                        echo  '<tr><td>' .  substr($actuaciones[0]['Actuaciones'][$i]['fechaActuacion'], 0, -9) . '</td>
                                            <td>' . $actuaciones[0]['Actuaciones'][$i]['actuacion'] . '</td>
                                            <td>' . $actuaciones[0]['Actuaciones'][$i]['anotacion'] . '</td>
                                            <td>' . substr($actuaciones[0]['Actuaciones'][$i]['fechaInicial'], 0, -9) . '</td>
                                            <td>' . substr($actuaciones[0]['Actuaciones'][$i]['fechaFinal'], 0, -9) . '</td>
                                            <td>' . substr($actuaciones[0]['Actuaciones'][$i]['fechaRegistro'], 0, -9) . '</td>
                                            </tr>';

                                        ?>

                                <?php
                                    }
                                } else {
                                    echo '<tr><td colspan="6" class="text-center">No hay actuaciones</td></tr>';
                                }
                                ?>



                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                "order": [
                    [0, "desc"]
                ]
            });

        });
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
</body>

</html>