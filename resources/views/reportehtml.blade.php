<html>
    <head>
        <style>
            body {
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
                font-size: 8pt;
            }
            table {
                font-size: 8pt;
            }
        </style>
    </head>
    <body>
        <img src="{{url('/images/logo128.png')}}" style="height:64px" >
        <table border='1' cellpadding='0' cellspacing='0' width="100%">
            <tr>
                <th width="2%">#</th>
                <th width="6%">Tipo de HR</th>
                <th width="7%">Nro de Control</th>
                <th width="7%">Nro de Reg. Interno</th>
                <th width="7%">Fecha recepción</th>
                <th width="13%">Referencia</th>
                <th width="7%">Fecha derivación</th>
                <th width="13%">Destinatario</th>
                <th width="13%">Procecendia</th>
                <th width="9%">Adjunto</th>
                <th>Estado</th>
                <th>Última Instrucción</th>
                @if($reporte->tipo_tarea === "UR")
                <th>Cant. Recibidos</th>
                <th>Cant. Atendidos</th>
                <th>Calificación</th>
                @endif
            </tr>
            @foreach($res as $row)
            <tr>
                <td>{{$row['num']}}</td>
                <td>{{App\Tarea::nombreTipoHR($row['tipo_hr'])}}</td>
                <td>{{$row['numero']}}</td>
                <td>{{$row['nro_clasificacion']}}</td>
                <td>{{$row['fecha_recepcion']}}</td>
                <td>{{$row['referencia']}}</td>
                <td>{{$row['derivacion_fecha']}}</td>
                <td>{{$row['destinatario']}}</td>
                <td>{{$row['procedencia']}}</td>
                <td>{{$row['anexo_hojas']}}</td>
                <td>{{$row['tar_estado']}}</td>
                <td>{{$row['instruccion']}}</td>
                @if($reporte->tipo_tarea === "UR")
                <td>{{$row['tar_recibidos']}}</td>
                <td>{{$row['tar_atendidos']}}</td>
                <td>{{$row['tar_calificacion']}}</td>
                @endif
            </tr>
            @endforeach
        </table>
    </body>
</html>