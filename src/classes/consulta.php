<?php

class Consulta
{

    public function consultaArea()
    {

        echo 'estoy en consulta';
        include "config/conexion.php";

        //hago consulta
        $consulta = "SELECT DISTINCT area FROM dbo.tabla1 ORDER BY area";
        //echo "<h4>$consulta</h4>";
        $this->resultado = sqlsrv_query($conn, $consulta);
        //echo ($this->resultado);

        //sqlsrv_free_stmt($this->resultado);

        return $this->resultado;
        //sqlsrv_close($conn);

    }

    public function consultaTabla($area, $codigo, $inicio, $fin)
    {
        $and="";
        //echo "FIN =" .$fin;
        if ($area == '') {
            $whereArea = "";

        } else {

            $whereArea = " area ='" .$area. "' ";
            $and="AND";
        }

        if ($codigo == '') {
            $whereBarcode = "";


        } else {


            $whereBarcode = $and. " codigo LIKE '%".$codigo. "%' ";
            $and="AND";
        }

        if ($inicio == NULL) {
            $whereInicio = "";

        } else {

            $whereInicio = $and." fin >= '".$inicio."' ";
            $and="AND";
        }


        if ($fin == NULL) {
            $whereFin = "";

        } else {


            $whereFin = $and." fin <= '".$fin."' ";

        }

        include "config/conexion.php";
        //hago consulta
        $consulta = "SELECT id, area, codigo, inicio, fin
        FROM dbo.tabla1 WHERE" .$whereArea . $whereBarcode.
        $whereInicio.$whereFin
        ;
       echo "<h4>$consulta</h4>";
        $this->resultado = sqlsrv_query($conn, $consulta);
        //var_dump($this->resultado);
        //var_dump(sqlsrv_error($this->resultado));


        //sqlsrv_free_stmt($this->resultado);
        //
        return $this->resultado;
        sqlsrv_close($conn);
    }
}
