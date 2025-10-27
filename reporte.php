<?php
require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Configuración de Dompdf
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);
$options->set('defaultFont', 'DejaVu Sans');
$options->setChroot(__DIR__);
$dompdf = new Dompdf($options);

// Verificar datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Fecha = htmlspecialchars($_POST["Fecha"]);
    $Sede = htmlspecialchars($_POST["Sede"]);
    $Equipo = htmlspecialchars($_POST["Equipo"]);
    $Marca = htmlspecialchars($_POST["Marca"]);
    $Modelo = htmlspecialchars($_POST["Modelo"]);
    $Serie = htmlspecialchars($_POST["Serie"]);
    $Activo_F = htmlspecialchars($_POST["Activo_F"]);
    $Ubicacion = htmlspecialchars($_POST["Ubicacion"]);
    $tipoSeleccionado = $_POST['tipo'] ?? []; 
        $check_preventivo  = in_array('Preventivo', $tipoSeleccionado)  ? 'X' : '';
        $check_correctivo  = in_array('Correctivo', $tipoSeleccionado)  ? 'X' : '';
        $check_diagnostico = in_array('Diagnóstico', $tipoSeleccionado) ? 'X' : '';
    $Q_REPORT = htmlspecialchars($_POST["Q_REPORT"]);
    $Diagnostico = htmlspecialchars($_POST["Diagnostico"]);
    $A_realizadas = htmlspecialchars($_POST["A_realizadas"]);
    $Observacion = htmlspecialchars($_POST["Observacion"]);

    $A_realizadas = wordwrap($A_realizadas, 115, "\n", true);
    $lineas = explode("\n", $A_realizadas);
    for ($i = 0; $i < 8; $i++) {
        if (!isset($lineas[$i])) $lineas[$i] = "";
    }

} else {
    echo "<h3>No se han recibido datos del formulario.</h3>";
    exit;
}
// Contenido HTML con HEREDOC
$html = <<<HTML
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<style>
        *{
            box-sizing: border-box;
            font-size: 11px; 
        }
        body{
            padding: 2px 5px;
            border:solid 3px
        }
        #header{
            text-align: center;
            font-size: 12px;
            color:#001F5F; 

        }
        #header td:nth-child(1){
            width: 10%;
            font-size:inherit; 
            border-color: black;
        }
        #header td:nth-child(2){
            width: 80%; 
            font-size:inherit; 
            border-color: black;
        }
        #header td:nth-child(3){
            width: 120px; 
            font-size:inherit; 
            border-color: black;
        }
        .SCO {
            width: 90px;
            height: auto;
        }
        .Datos{
            width: 100%;
            padding: 10px 0;
        }
        .Datos label{
            display: inline-block;
            width: 90px;
            color: white;
            background-color: #1F4E78;
            text-align: center; 
        }
        .Datos #input_Dat {
            display:inline-block;
            width: 120px;
            border-bottom:solid 1px; 
        }
        .Datos #input_Dat_1 {
            display:inline-block;
            width: 150px;
            border-bottom:solid 1px;

        }
        .Datos #SEDE {
            display:inline-block;
            width: 355px;
            border-bottom:solid 1px; 
        }
        .Datos div{
            padding: 5px 0;
        }
        .Datos_2 .Ticket{
            display: inline-block;
            width: 190px;
            color: white;
            background-color: #1F4E78;
            text-align: center;
            margin:5px; 
        }
        .Datos_2 #input_Dat {
            margin:0;
            display:inline-block;
            width: 120px;
            border-bottom:solid 1px; 
        }
        .Datos_2 .check {
            display:inline-block;
        }
        .Datos_2 .check table {
            border-collapse:collapse;
            border:solid 1px;
        }
        .Datos_2 .check table td {
            border:solid 1px;
        }
        .Datos_2 .check table td:nth-child(1) {
            background-color:#E1E1E1;
            width: 90px;
            height: 15px;
            text-align:center;
        }
        .Datos_2 .check table td:nth-child(2) {
            width: 15px;
            height: 15px;
            text-align:center;
        }
        #Lorem{
            height: 100px;
            word-wrap: break-word;
            white-space: pre-wrap;
        }
        .tabla{
            width: 100%;
            border-collapse: collapse;
            border: solid 1px;
        }
        .tabla td{
            border: solid 1px;
            text-align: center;
            height:20px;
        }
        .tabla th{
            border: black solid 1px;
            background-color: #1F4E78;
            color: white;
        }
        .tabla .ref{
            background-color: #E1E1E1;
            color: black;
        }
        .tabla #input_tb{
            Display:inline-block;
            width: 100%;
            height: 100%;
        }
        #Repuestos{
            height: 145px;
        }
        #Repuestos td:nth-child(1){
            width: 15%; 
        }
        #Repuestos td:nth-child(2){
            width: 15%; 
        }
        #Repuestos td:nth-child(3){
            width: 70%; 
        }
        .Firmas div{
            display: inline-block;
            width: 250px;
            height: 100px;
            margin:0 20px;
        }
        .Firmas div:nth-child(1){
            float: left;
        }
        .Firmas div:nth-child(2){
            float: right;
        }
        .tabla-firma{
            width:100%;
        }
        .tabla-firma th{
            background-color: #1F4E78;
            color: white;
        }
        .tabla-firma td{
            text-align: center;
            height:20px;
        }
        .tabla-firma td:nth-child(1){
            background-color:#E1E1E1;
        }
        .tabla-firma td:nth-child(2){
            border-bottom:solid 1px;
        }
        .tabla-firma .firma{
            background-color:white;
        }
</style>
</head>
<body class="contenedor">
    <div class="header">
        <table class="tabla" id="header">
            <tr><td rowspan="3"><<img src="SCO.png" class="SCO"></td><td><b>SISTEMA DE GESTION DOCUMENTAL</b></td><td> <b>PAGINA:</b> 1 DE 1</td></tr>
            <tr>                                                    <td><b>CODIGO:</b> GT-FO-51 </td>            <td> <b>VERSION:</b> 2</td></tr>
            <tr><td><b>TITULO:</b> FORMATO DE REGISTRO DE  MANTENIMIENTO DE EQUIPOS BIOMEDICOS</td><td> <b>FECHA:</b> 09/09/2025</td></tr>
        </table>
    <div class="Datos" >
        <div><label>FECHA:</label>  <span id="input_Dat_1">{$Fecha}</span></div>
        <div><label>SEDE:</label>   <span id="SEDE">{$Sede}</span></div>
        <div>
            <label>EQUIPO:</label>  <span id="input_Dat_1">{$Equipo}</span>
            <label>MARCA:</label>   <span id="input_Dat">{$Marca}</span>
            <label>MODELO:</label>  <span id="input_Dat">{$Modelo}</span>
        </div>
        <div>
            <label>SERIE:</label>       <span id="input_Dat_1">{$Serie}</span>
            <label>ACTIVO FIJO:</label> <span id="input_Dat">{$Activo_F}</span>
            <label>UBICACIÓN:</label>   <span id="input_Dat">{$Ubicacion}</span>
        </div>
    </div>
    <div class="Datos_2">
        <div>
            <h1>Marque con una "X" el tipo de mantenimiento:</h1>
            <label class="Ticket">TIPO DE MANTENIMIENTO:</label> 
            <div class="check"><table><tr><td>PREVENTIVO</td><td>$check_preventivo</td></tr></table></div>
            <div class="check"><table><tr><td>CORRECTIVO</td><td>$check_correctivo</td></tr></table></div>
            <div class="check"><table><tr><td>DIAGNOSTICO</td><td>$check_diagnostico</td></tr></table></div>
        </div>
        <label class="Ticket">QUIEN REPORTA:</label><span id="input_Dat">{$Q_REPORT}</span>
    </div>

    <div class="tablas">
        <table class="tabla">
            <tr><th>DAIGNOSTICO</th></tr>
            <tr>
                <td id="Lorem">{$Diagnostico}</td>
            </tr>
        </table>
        <table class="tabla">
            <tr><th>ACTIVIDADES REALIZADAS</th></tr>
            <tr><td>{$lineas[0]}</td></tr>
            <tr><td>{$lineas[1]}</td></tr>
            <tr><td>{$lineas[2]}</td></tr>
            <tr><td>{$lineas[3]}</td></tr>
            <tr><td>{$lineas[4]}</td></tr>
            <tr><td>{$lineas[5]}</td></tr>
            <tr><td>{$lineas[6]}</td></tr>
            <tr><td>{$lineas[7]}</td></tr>
        </table>
        <table class="tabla">
            <tr><th>OBSERVACIONES</th></tr>
            <tr><td id="Lorem">{$Observacion}</td>
            </tr>
        </table>
        <table class="tabla" id="Repuestos">
            <tr><th colspan="3">REPUESTOS USADOS</th></tr>
            <tr><th class="ref">CANT.</th><th class="ref">REF</th><th class="ref">DESCRIPCION</th></tr>
            <tr><td></td><td></td><td></td></tr>
            <tr><td></td><td></td><td></td></tr>
            <tr><td></td><td></td><td></td></tr>
            <tr><td></td><td></td><td></td></tr>
        </table>
        <div class="Firmas">
            <div>
                <table class="tabla-firma">
                    <tr><th colspan="2">REALIZADO</th></tr>
                    <tr><td colspan="2" class="firma"></td></tr>
                    <tr><td>NOMRE</td><td></td></tr>
                    <tr><td>CARGO</td><td></td></tr>
                </table>
            </div>
            <div>
                <table class="tabla-firma">
                    <tr><th colspan="2">REALIZADO</th></tr>
                    <tr><td colspan="2" class="firma"></td></tr>
                    <tr><td>NOMRE</td><td></td></tr>
                    <tr><td>CARGO</td><td></td></tr>
                </table>
            </div>
        </div>
        </div>
</body>
</html>
HTML;

// ← IMPORTANTE: la palabra HTML de cierre está SOLA, sin espacios antes

// Cargar el HTML en Dompdf
$dompdf->loadHtml($html);

// Configurar papel
$dompdf->setPaper('A4', 'portrait');

// Renderizar
$dompdf->render();

// Mostrar en navegador
$dompdf->stream("Reporte_Datos.pdf", ["Attachment" => false]);
exit;
?>
