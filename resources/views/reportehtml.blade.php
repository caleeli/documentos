<html>
    <head>
        <style>
            body {
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            }
        </style>
    </head>
    <body>
        <img src="{{url('/images/logo-banner.svg')}}" style="height:64px" >
        <table border='1' cellpadding='0' cellspacing='0'>
            <tr>
                <th width="4%">#</th>
                <th width="6%">Tipo</th>
                <th width="8%">Nro Control</th>
                <th width="10%">Fecha derivación</th>
                <th width="14%">Referencia</th>
                <th width="14%">Destinatario</th>
                <th width="14%">Procecendia</th>
                <th width="10%">Fecha recepción</th>
                <th width="10%">Conclusión</th>
                <th width="10%">Instrucción</th>
            </tr>
            @foreach($res as $row)
            <tr>
                <td>{{$row['num']}}</td>
                <td>{{$row['tipo_hr']}}</td>
                <td>{{$row['numero']}}</td>
                <td>{{$row['derivacion_fecha']}}</td>
                <td>{{$row['referencia']}}</td>
                <td>{{$row['destinatario']}}</td>
                <td>{{$row['procedencia']}}</td>
                <td>{{$row['fecha_recepcion']}}</td>
                <td>{{$row['fecha_conclusion']}}</td>
                <td>{{$row['instruccion']}}</td>
            </tr>
            @endforeach
        </table>
    </body>
</html>