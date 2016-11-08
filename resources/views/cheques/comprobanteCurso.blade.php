<?php
//use App\domain\Utils;
?>
@inject('utils','App\domain\Utils')
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
.tg td{font-family:Arial, sans-serif;font-size:12px;padding:16px 16px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;}
.tg th{font-family:Arial, sans-serif;font-size:12px;font-weight:normal;padding:16px 16px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;}
.tg .tg-yw4l{vertical-align:top}
.tg .tg-9hbo{font-weight:bold;vertical-align:top}
.tg .tg-y5sk{font-size:9px;vertical-align:top}
.tg .tg-25al{font-size:9px;vertical-align:top}
.tg .tg-y5sl{font-size:9px;}

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
<span style="font-size:12px;"><b>PARA CFJ</b></span>
<span style="font-size:12px;margin-right:50px; float:right "><b>N°: {{$cheque->nro_recibo}}</b></span><br>
<span style="font-size:12px; float:right"><b>FECHA:</b>{{$utils::formatDate($cheque->fecha_retiro)}}</span>
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
    <td class="tg-yw4l">ACTIVIDAD<br><span class="tg-y5sk">(A la que corresponde)</span></td>
    <td class="tg-yw4l" colspan="3">{{$curso}}</td>
  </tr>
  <tr>
    <td ></td>
    <td class="tg-y5sk"></td>
    <td class="tg-y5sk"></td>
    <td class="tg-yw4l"></td>
  </tr>
  <tr>
    <td class="tg-yw4l">PAGO APROBADO<br><span class="tg-y5sk">POR DISP. SE-CFJ N°:</span></td>
    <td class="tg-yw4l">{{$cheque->nro_disp_aprueba}}</td>
    <td class="tg-yw4l">SOLICITUD DE PAGO:<br><span class="tg-y5sk">POR MEMO SE-CFJ N°:</span></td>
    <td class="tg-yw4l">{{$nro_memo}}</td>
  </tr>
  <tr>
    <td ></td>
    <td class="tg-y5sk"></td>
    <td class="tg-y5sk"></td>
    <td class="tg-yw4l"></td>
  </tr>
  <tr>
    <td class="tg-yw4l">N° DE EXPEDIENTE<span class="tg-y5sl">(TSJ):</span></td>
    <td class="tg-yw4l">{{$cheque->nro_expediente}}</td>
    <td class="tg-yw4l">N° ORDEN DE PAGO<span class="tg-y5sl">(TSJ):</span></td>
    <td class="tg-yw4l">{{$cheque->orden_pago}}</td>
  </tr>
  <tr>
    <td class="tg-yw4l">NRO CHEQUE:</td>
    <td class="tg-yw4l">{{$cheque->nro_cheque}}</td>
    <td class="tg-yw4l">FECHA DE EMISI&Oacute;N:</td>
    <td class="tg-yw4l">{{$utils::formatDateBis($cheque->fecha_emision)}}</td>
  </tr>
  <tr>
    <td class="tg-yw4l">IMPORTE:</td>
    <td class="tg-yw4l" colspan="2">${{$cheque->importe}}</td>
    <td class="tg-yw4l"></td>
  </tr>
  <tr>
    <td class="tg-yw4l"><b>BENEFICIARIO:</b><br><span class="tg-y5sk">(APELLIDO Y NOMBRE)</span></td>
    <td class="tg-yw4l" colspan="2">{{$docente}}</td>
    <td class="tg-yw4l"></td>
  </tr>
  <tr>
    <td class="tg-yw4l"><b>RETIRADO POR:</b><br><span class="tg-y5sk">(FIRMA,ACLARACI&Oacute;N,DNI)</span></td>
    <td class="tg-yw4l" colspan="2">{{$cheque->retirado_por}} {{$cheque->dni_retira}}</td>
    <td class="tg-yw4l"></td>
  </tr>
  <tr>
    <td class="tg-yw4l" colspan="2">ENTREGADO POR:</td>
    <td class="tg-yw4l" colspan="2">{{$entregado_por}}</td>
  </tr>
</table>
</div>
<div class="page-break"></div>

<div id="para_tsj_container" class="page">
<p align="center"><img src=" ../img/print-logo.jpg" align="bottom" width="197" height="80" border="0">
</p>
<span style="font-size:12px;"><b>PARA TSJ</b></span>
<span style="font-size:12px;margin-right:50px; float:right "><b>N°: {{$cheque->nro_recibo}}</b></span><br>
<span style="font-size:12px; float:right"><b>FECHA:</b>{{$utils::formatDate($cheque->fecha_retiro)}}</span>
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
    <td class="tg-yw4l">ACTIVIDAD<br><span class="tg-y5sk">(A la que corresponde)</span></td>
    <td class="tg-yw4l" colspan="3">{{$curso}}</td>
  </tr>
  <tr>
    <td ></td>
    <td class="tg-y5sk"></td>
    <td class="tg-y5sk"></td>
    <td class="tg-yw4l"></td>
  </tr>
  <tr>
    <td class="tg-yw4l">PAGO APROBADO<br><span class="tg-y5sk">POR DISP. SE-CFJ N°:</span></td>
    <td class="tg-yw4l">{{$cheque->nro_disp_aprueba}}</td>
    <td class="tg-yw4l">SOLICITUD DE PAGO:<br><span class="tg-y5sk">POR MEMO SE-CFJ N°:</span></td>
    <td class="tg-yw4l">{{$nro_memo}}</td>
  </tr>
  <tr>
    <td ></td>
    <td class="tg-y5sk"></td>
    <td class="tg-y5sk"></td>
    <td class="tg-yw4l"></td>
  </tr>
  <tr>
    <td class="tg-yw4l">N° DE EXPEDIENTE<span class="tg-y5sl">(TSJ):</span></td>
    <td class="tg-yw4l">{{$cheque->nro_expediente}}</td>
    <td class="tg-yw4l">N° ORDEN DE PAGO<span class="tg-y5sl">(TSJ):</span></td>
    <td class="tg-yw4l">{{$cheque->orden_pago}}</td>
  </tr>
  <tr>
    <td class="tg-yw4l">NRO CHEQUE:</td>
    <td class="tg-yw4l">{{$cheque->nro_cheque}}</td>
    <td class="tg-yw4l">FECHA DE EMISI&Oacute;N:</td>
    <td class="tg-yw4l">{{$utils::formatDateBis($cheque->fecha_emision)}}</td>
  </tr>
  <tr>
    <td class="tg-yw4l">IMPORTE:</td>
    <td class="tg-yw4l" colspan="2">${{$cheque->importe}}</td>
    <td class="tg-yw4l"></td>
  </tr>
  <tr>
    <td class="tg-yw4l"><b>BENEFICIARIO:</b><br><span class="tg-y5sk">(APELLIDO Y NOMBRE)</span></td>
    <td class="tg-yw4l" colspan="2">{{$docente}}</td>
    <td class="tg-yw4l"></td>
  </tr>
  <tr>
    <td class="tg-yw4l"><b>RETIRADO POR:</b><br><span class="tg-y5sk">(FIRMA,ACLARACI&Oacute;N,DNI)</span></td>
    <td class="tg-yw4l" colspan="2">{{$cheque->retirado_por}} {{$cheque->dni_retira}}</td>
    <td class="tg-yw4l"></td>
  </tr>
  <tr>
    <td class="tg-yw4l" colspan="2">ENTREGADO POR:</td>
    <td class="tg-yw4l" colspan="2">{{$entregado_por}}</td>
  </tr>
</table>
</div>
</body>
</html>