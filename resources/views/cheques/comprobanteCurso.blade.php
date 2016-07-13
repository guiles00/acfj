<?php
use App\domain\Utils;
?>
<!DOCTYPE HTML>
<html>
<head>
  <script type="text/javascript">
    window.print();
    function imprimir(){
    window.print();
    }
  </script>
<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:16px 16px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:16px 16px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;}
.tg .tg-yw4l{vertical-align:top}
.tg .tg-9hbo{font-weight:bold;vertical-align:top}
.tg .tg-y5sk{font-size:9px;vertical-align:top}
.tg .tg-25al{font-size:9px;vertical-align:top}

div.page
      {
        /*page-break-after: always;*/
        page-break-inside: avoid;
      }
</style>
</head>
<body>
<div id="para_cfj_container" class="page">
<p align="center"><img src=" ../img/print-logo.jpg" align="bottom" width="197" height="80" border="0">
</p>
<p style="margin-bottom: 0in; line-height: 100%"><br>
</p>
<p align="center" style="margin-bottom: 0in; line-height: 100%">RECIBO</p>
<p align="center" style="margin-bottom: 0in; line-height: 100%">DEPARTAMENTO
DE FORMACI&Oacute;N JUDICIAL Y ADMINISTRATIVO</p>
<p align="center" style="margin-bottom: 0in; line-height: 100%"><br>
</p>
<table class="tg">
  <tr>
    <th class="tg-yw4l"></th>
    <th class="tg-yw4l"></th>
    <th class="tg-yw4l"></th>
    <th class="tg-yw4l"></th>
  </tr>
  <tr>
    <td class="tg-9hbo">PARA CFJ</td>
    <td class="tg-yw4l"></td>
    <td class="tg-yw4l">N°</td>
    <td class="tg-yw4l"></td>
  </tr>
  <tr>
    <td class="tg-yw4l"></td>
    <td class="tg-yw4l"></td>
    <td class="tg-yw4l">Fecha:</td>
    <td class="tg-yw4l">{{Utils::formatDate(date("Y-d-m"))}}</td>
  </tr>
  <tr>
    <td class="tg-yw4l"><b>ACTIVIDAD</b></td>
    <td class="tg-yw4l">{{$curso}}</td>
    <td class="tg-yw4l"></td>
    <td class="tg-yw4l"></td>
  </tr>
  <tr>
    <td ></td>
    <td class="tg-y5sk"></td>
    <td class="tg-y5sk"></td>
    <td class="tg-yw4l"></td>
  </tr>
  <tr>
    <td class="tg-yw4l"><b>PAGO APROBADO</b><br><span class="tg-y5sk">POR DISP. SE-CFJ N°:</span></td>
    <td class="tg-yw4l">{{$cheque->nro_disp_aprueba}}</td>
    <td class="tg-yw4l"><b>SOLICITUD DE PAGO:</b><br><span class="tg-y5sk">POR MEMO SE-CFJ N°:</span></td>
    <td class="tg-yw4l">{{$nro_memo}}</td>
  </tr>
  <tr>
    <td ></td>
    <td class="tg-y5sk"></td>
    <td class="tg-y5sk"></td>
    <td class="tg-yw4l"></td>
  </tr>
  <tr>
    <td class="tg-yw4l"><b>N° DE EXPEDIENTE (TSJ):</b></td>
    <td class="tg-yw4l">{{$cheque->nro_expediente}}</td>
    <td class="tg-yw4l"><b>N° ORDEN DE PAGO(TSJ):</b></td>
    <td class="tg-yw4l">{{$cheque->orden_pago}}</td>
  </tr>
  <tr>
    <td class="tg-yw4l"><b>FECHA DE EMISI&Oacute;N:</b></td>
    <td class="tg-yw4l">{{Utils::formatDate($cheque->fecha_emision)}}</td>
    <td class="tg-yw4l"><b>IMPORTE:</b></td>
    <td class="tg-yw4l">{{$cheque->importe}}</td>
  </tr>
  <tr>
    <td class="tg-yw4l"><b>BENEFICIARIO:</b><br><span class="tg-y5sk">(APELLIDO Y NOMBRE)</span></td>
    <td class="tg-yw4l">{{$docente}}</td>
    <td class="tg-yw4l"></td>
    <td class="tg-yw4l"></td>
  </tr>
  <tr>
    <td class="tg-yw4l"><b>ENTREGADO POR:</b></td>
    <td class="tg-yw4l">{{$entregado_por}}</td>
    <td class="tg-yw4l"></td>
    <td class="tg-yw4l"></td>
  </tr>
</table>
</div>
<div class="page-break"></div>

<div id="para_tsj_container" class="page">
<p align="center"><img src=" ../img/print-logo.jpg" align="bottom" width="197" height="80" border="0">
</p>
<p style="margin-bottom: 0in; line-height: 100%"><br>
</p>
<p align="center" style="margin-bottom: 0in; line-height: 100%">RECIBO</p>
<p align="center" style="margin-bottom: 0in; line-height: 100%">DEPARTAMENTO
DE FORMACI&Oacute;N JUDICIAL Y ADMINISTRATIVO</p>
<p align="center" style="margin-bottom: 0in; line-height: 100%"><br>
</p>
<table class="tg">
  <tr>
    <th class="tg-yw4l"></th>
    <th class="tg-yw4l"></th>
    <th class="tg-yw4l"></th>
    <th class="tg-yw4l"></th>
  </tr>
  <tr>
    <td class="tg-9hbo">PARA CFJ</td>
    <td class="tg-yw4l"></td>
    <td class="tg-yw4l">N°</td>
    <td class="tg-yw4l"></td>
  </tr>
  <tr>
    <td class="tg-yw4l"></td>
    <td class="tg-yw4l"></td>
    <td class="tg-yw4l">Fecha:</td>
    <td class="tg-yw4l">{{Utils::formatDate(date("Y-d-m"))}}</td>
  </tr>
  <tr>
    <td class="tg-yw4l"><b>ACTIVIDAD</b></td>
    <td class="tg-yw4l">{{$curso}}</td>
    <td class="tg-yw4l"></td>
    <td class="tg-yw4l"></td>
  </tr>
  <tr>
    <td ></td>
    <td class="tg-y5sk"></td>
    <td class="tg-y5sk"></td>
    <td class="tg-yw4l"></td>
  </tr>
  <tr>
    <td class="tg-yw4l"><b>PAGO APROBADO</b><br><span class="tg-y5sk">POR DISP. SE-CFJ N°:</span></td>
    <td class="tg-yw4l">{{$cheque->nro_disp_aprueba}}</td>
    <td class="tg-yw4l"><b>SOLICITUD DE PAGO:</b><br><span class="tg-y5sk">POR MEMO SE-CFJ N°:</span></td>
    <td class="tg-yw4l">{{$nro_memo}}</td>
  </tr>
  <tr>
    <td ></td>
    <td class="tg-y5sk"></td>
    <td class="tg-y5sk"></td>
    <td class="tg-yw4l"></td>
  </tr>
  <tr>
    <td class="tg-yw4l"><b>N° DE EXPEDIENTE (TSJ):</b></td>
    <td class="tg-yw4l">{{$cheque->nro_expediente}}</td>
    <td class="tg-yw4l"><b>N° ORDEN DE PAGO(TSJ):</b></td>
    <td class="tg-yw4l">{{$cheque->orden_pago}}</td>
  </tr>
  <tr>
    <td class="tg-yw4l"><b>FECHA DE EMISI&Oacute;N:</b></td>
    <td class="tg-yw4l">{{Utils::formatDate($cheque->fecha_emision)}}</td>
    <td class="tg-yw4l"><b>IMPORTE:</b></td>
    <td class="tg-yw4l">{{$cheque->importe}}</td>
  </tr>
  <tr>
    <td class="tg-yw4l"><b>BENEFICIARIO:</b><br><span class="tg-y5sk">(APELLIDO Y NOMBRE)</span></td>
    <td class="tg-yw4l">{{$docente}}</td>
    <td class="tg-yw4l"></td>
    <td class="tg-yw4l"></td>
  </tr>
  <tr>
    <td class="tg-yw4l"><b>ENTREGADO POR:</b></td>
    <td class="tg-yw4l">{{$entregado_por}}</td>
    <td class="tg-yw4l"></td>
    <td class="tg-yw4l"></td>
  </tr>
</table>
</div>
</body>
</html>