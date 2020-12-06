<!doctype html>

<?php

setlocale(LC_TIME, "spanish.UTF-8");
include 'config/conexion.php';
include_once 'src/classes/consulta.php';
if(!isset($_COOKIE['codigo']))$_COOKIE['codigo']='';
?>
<html lang="es">

<head>

    <meta charset="utf-8" />

    <title>Demo Consultas SQL</title>

    <meta name="description" content="Demo consulta MSSQL" />

    <meta name="keywords" content="SQL" />

    <meta name="author" content="Moises Acedo" />

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="shortcut icon" href="assets/img/logo.jpg" />

    <!-- Bootstrap

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
     -->
    <link rel="stylesheet" href="css/bootstrap-43.css">

    <!-- Iconos de fontawesome-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

    <!-- Mi hoja de estilos-->
    <link rel="stylesheet" href="css/styles.css" />

    <link rel="stylesheet" href="css/stacktable.css" />

    <!-- Mi código Javascript-->
    <script src="js/main.js" type="application/javascript" defer></script>
</head>

<body>
    <header>

    </header>
    <nav>
        <!-- Image and text -->
        <nav class="navbar navbar-light bg-dark">
            <a class="navbar-brand text-light" href="#">
                <img src="assets/img/logo.jpg" width="30" height="30" class="d-inline-block align-top ml-3" alt="" loading="lazy">
                Demo consulta SQL
            </a>
        </nav>
    </nav>

    <aside>

    </aside>

    <main class="container">


        <form action="index.php" method="POST">
            <div class="row mt-3">

                <div class="col-md-3">
                    <div class="form-group mb-3">

                        <label class="h6" for="area">AREA</label>



                        <select class="custom-select" id="area" name="area">
                            <option disabled selected>Seleccione un area</option>

                            <?php


                            $consulta = new Consulta();
                            $consulta = $consulta->consultaArea();

                            while ($fila = sqlsrv_fetch_array($consulta)) {
                                echo '<option value="' . $fila['area'] . '">' . $fila['area'] . '</option>';
                            }
                            unset($consulta);
                            ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group mb-3">

                        <label class="h6" for="codigo">CÓDIGO</label>

                        <input class="form-control" type="text" name="codigo" id="codigo" value="<?php echo $_COOKIE['codigo'] ?>"
                        placeholder=" <?php echo $_COOKIE['codigo'] ?> " >
                    </div>
                </div>

                <div class="col-md-3">

                    <div class="form-group mb-3">

                        <label class="h6" for="desde">DESDE</label>

                        <input class="form-control" type="date" value="2020-02-01" name="desde" id="desde">

                    </div>
                </div>

                <div class="col-md-3">

                    <div class="form-group mb-3">

                        <label class="h6" for="hasta">HASTA</label>

                        <input class="form-control" type="date" value="" name="hasta" id="hasta">

                    </div>
                </div>



            </div>
            <div class="row">
                <div class="col-md-4"></div>


                <div class="col-md-4 text-center">
                    <button type="submit" class="btn btn-info">ENVIAR</button>
                </div>
                <div class="col-md-4"></div>

            </div>


        </form>
        <hr>

        <div class="row mt-3">
            <div class="col-12">
                <div class="text-center">
                    <h5>RESULTADOS DE LA CONSULTA</h5>
                </div>
                <?php
                if (
                    isset($_POST['area']) || isset($_POST['codigo']) ||
                    isset($_POST['desde']) || isset($_POST['hasta'])
                ) {




                    //echo var_dump($_POST);
                    if (!empty($_POST['area']) && $_POST['area'] != 'Seleccione un area') {
                        $area = $_POST['area'];
                    } else {
                        $area = '';
                    }
                    //echo $area;
                    if (!empty($_POST['codigo'])) {
                        $codigo = $_POST['codigo'];
                        $_COOKIE['codigo']=$codigo;
                    } else {
                        $codigo = '';
                    }
                    //echo $codigo;
                    if (!empty($_POST['desde'])) {
                        $inicio = $_POST['desde'];
                    } else {
                        $inicio = NULL;
                    }
                    //echo $inicio;
                    if (!empty($_POST['hasta'])) {
                        $fin = $_POST['hasta'];
                    } else {
                        $fin = NULL;
                    }
                    //echo $fin;





                    $consultaTabla = new Consulta();
                    $consultaTabla = $consultaTabla->consultaTabla($area, $codigo, $inicio, $fin);
                }
                var_dump($_COOKIE);
                ?>

                <table class="table table-dark">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">AREA</th>
                            <th scope="col">CODIGO</th>
                            <th scope="col">INICIO</th>
                            <th scope="col">FIN</th>
                        </tr>
                    </thead>
                    <tbody>


                        <?php
                        $filaTabla = [];
                        //var_dump($filaTabla);
                        if ($consultaTabla) {

                            //var_dump($consultaTabla);

                            while ($filaTabla = sqlsrv_fetch_array($consultaTabla)) {
                                echo '<tr>';
                                //echo $filaTabla['fin']->format('Y-m-d');
                                $tablaId = '<td>' . $filaTabla['id'] . '</td>';
                                $tablaArea = '<td>' . $filaTabla['area'] . '</td>';
                                $tablaCodigo = '<td>' . $filaTabla['codigo'] . '</td>';
                                if ($filaTabla['inicio'] == NULL) {
                                    $tablaInicio = '<td> - </td>';
                                } else {
                                    $tablaInicio = '<td>' . $filaTabla['inicio']->format('d-m-Y H:i:s') . '</td>';
                                }
                                if ($filaTabla['fin'] == NULL) {
                                    $tablaFin = '<td>--</td>';
                                } else {
                                    $tablaFin = '<td>' . $filaTabla['fin']->format('Y-m-d H:i:s') . '</td>';
                                }
                                echo $tablaId;
                                echo $tablaArea;
                                echo $tablaCodigo;
                                echo $tablaInicio;
                                echo $tablaFin;
                                echo '</tr>';
                            }
                        }

                        ?>



                    </tbody>
                </table>

            </div>




        </div>









    </main>

    <footer>

    </footer>

    <!-- BootStrap -->
    <script src="js/jquery.js">
    </script>
    <script src="js/popper.js">
    </script>
    <script src="js/bootstrap.js">
    </script>
    <script src="js/stacktable.js">
    </script>

    <script>
        $('table').stacktable();
    </script>

</body>

</html>