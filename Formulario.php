<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Datos</title>
    <link rel="stylesheet" href="Styles.css">
</head>
<body>
    <div class="form-container">
        <h2>REPORTE DE SERVICIO</h2>
        <form action="reporte.php" method="post">
            <div class="container">
                <label>FECHA:</label>
                <input type="date" id="Fecha" name="Fecha" required>

                <label>SEDE:</label>
                <input list="Sedes" id="Sede" name="Sede"  required>
            <datalist id="Sedes">
                <option value="Torre 97">
                <option value="Sede Bosque">
            </datalist>
            </div>
            <div class="container">
                <label>EQUIPO:</label>
                <input type="text" id="Equipo" name="Equipo"  required>

                <label>MARCA:</label>
                <input type="text" id="Marca" name="Marca"  required>
            </div>
            <div class="container">
                <label>MODELO:</label>
                <input type="text" id="Modelo" name="Modelo"  required>

                <label>SERIE:</label>
                <input type="text" id="Serie" name="Serie"  required>
            </div>
            <div class="container">
                <label>ACTIVO FIJO:</label>
                <input type="text"  name="Activo_F"  required>

                <label for="Ubicacion">UBICACION:</label>
                <input type="text"  name="Ubicacion"  required>
            </div>
            <div class="tipo-mantenimiento">
                <label class="L_L">TIPO DE MANTENIMIENTO:</label><br>
                <label><input type="checkbox" name="tipo[]" value="Preventivo"> Preventivo</label>
                <label><input type="checkbox" name="tipo[]" value="Correctivo"> Correctivo</label>
                <label><input type="checkbox" name="tipo[]" value="Diagnóstico"> Diagnóstico</label>
            </div>
            <div class="container">
                <label class="L_L">QUIEN REPORTA:</label>
                <input type="text"  name="Q_REPORT"  required>
            </div>
            <div>
                <label class="txt_tabla">DIAGNOSTICO:</label></br>
                <textarea class="Tabla" type="text"  name="Diagnostico"  required> </textarea>  
            </div>
            <div>
                <label class="txt_tabla">ACTIVIDADES REALIZADAS:</label></br>
                <textarea class="Tabla-datos" type="text"  name="A_realizadas" maxlength="500"  required> </textarea>  
            </div>
            <div>
            <div>
                <label class="txt_tabla">OBSERVACIONES:</label></br>
                <textarea class="Tabla" type="text"  name="Observacion" maxlength="300" required> </textarea>  
            </div>

            <button type="submit">Enviar</button>
        </form>

        <div class="footer">
            <p>Reporte de servicio tecnico</p>
        </div>
    </div>

</body>
</html>
