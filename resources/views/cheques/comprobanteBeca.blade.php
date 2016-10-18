<?php
//8use App\domain\Utils;
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
.tg td{font-family:Arial, sans-serif;font-size:10px;padding:16px 16px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;}
.tg th{font-family:Arial, sans-serif;font-size:10px;font-weight:normal;padding:16px 16px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;}
.tg .tg-yw4l{vertical-align:top}
.tg .tg-9hbo{font-weight:bold;vertical-align:top}
.tg .tg-y5sk{font-size:9px;vertical-align:top}
.tg .tg-25al{font-size:9px;vertical-align:top}

div.page
      {
        /*page-break-after: always;*/
       /* page-break-inside: avoid;*/
      }
</style>
</head>
<body>
<div id="para_tsj_container" >
<p align="center"><img src=" ../img/print-logo.jpg" align="bottom" width="180" height="60" border="0">
</p>
<span style="font-size:12px;"><b>PARA TSJ</b></span>
<span style="font-size:12px;margin-right:50px; float:right "><b>N°:</b></span><br>
<span style="font-size:12px; float:right"><b>FECHA:</b>{{$utils::formatDate($cheque->fecha_retiro)}}</span>
<p align="center" style="font-size:14px;margin-bottom: 0in; line-height: 100%">REINTEGRO DE BECA</p>
<p align="center" style="font-size:14px;margin-bottom: 0in; line-height: 100%">CONSTANCIA DE RECEPCI&Oacute;N</p>
<table class="tg">
  <tr>
    <td class="tg-yw4l"><b>BENEFICIARIO:</b><br><span class="tg-y5sk">(NOMBRE,APELLIDO,DNI)</span></td>
    <td class="tg-yw4l">{{$beneficiario}}</td>
    <td class="tg-yw4l"><b>RETIRADO POR:</b><br><span class="tg-y5sk">(FIRMA,ACLARACI&Oacute;N,DNI)</span></td>
    <td class="tg-yw4l">{{$cheque->retirado_por}}<br>{{$cheque->dni_retira}}</td>
  </tr>
  <tr>
    <td class="tg-yw4l">N° de CHEQUE:</td>
    <td class="tg-yw4l">{{$cheque->nro_cheque}}</td>
    <td class="tg-yw4l">MONTO:</td>
    <td class="tg-yw4l">{{$cheque->importe}}</td>
  </tr>
  <tr>
    <td class="tg-yw4l">N° DE EXPEDIENTE:<br><span class="tg-y5sk">(TSJ)</span></td>
    <td class="tg-yw4l">{{$cheque->nro_expediente}}</td>
    <td class="tg-yw4l">N° DE ORDEN DE PAGO:<br><span class="tg-y5sk">(TSJ)</span></td>
    <td class="tg-yw4l">{{$cheque->orden_pago}}</td>
  </tr>
  <tr>
    <td class="tg-yw4l">BECA OTORGADA:<br><span class="tg-y5sk">(POR DISP. SE-CFJ N°)</span></td>
    <td class="tg-yw4l">{{$cheque->nro_disp_otorga}}</td>
    <td class="tg-yw4l">REINTEGRO AUTORIZADO:<br><span class="tg-y5sk">(POR DISP. SE-CFJ N°)</span></td>
    <td class="tg-yw4l">{{$cheque->nro_disp_aprueba}}</td>
  </tr>
  <tr>
    <td class="tg-yw4l">REINTEGRO SOLICITADO:<br><span class="tg-y5sk">(POR MEMO CFJ N°)</span></td>
    <td class="tg-yw4l">{{$nro_memo}}</td>
    <td class="tg-yw4l" colspan="2"></td>
  </tr>
  <tr>
    <td class="tg-yw4l" colspan="4"><span>&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;</span></td>
  </tr>
</table>
</div>
<div id="para_cfj_container">
<p align="center"><img src=" ../img/print-logo.jpg" align="bottom" width="180" height="60" border="0">
</p>
<span style="font-size:12px;"><b>PARA CFJ</b></span>
<span style="font-size:12px;margin-left:30px; float:right"><b>N°</b></span>
<span style="font-size:12px;margin-left:30px; float:right"><b>FECHA</b></span>
<p align="center" style="font-size:14px;margin-bottom: 0in; line-height: 100%">REINTEGRO DE BECA</p>
<p align="center" style="font-size:14px;margin-bottom: 0in; line-height: 100%">CONSTANCIA DE RECEPCI&Oacute;N</p>
<table class="tg">
  <tr>
    <td class="tg-yw4l"><b>BENEFICIARIO:</b><br><span class="tg-y5sk">(NOMBRE,APELLIDO,DNI)</span></td>
    <td class="tg-yw4l">{{$beneficiario}}</td>
    <td class="tg-yw4l"><b>RETIRADO POR:</b><br><span class="tg-y5sk">(FIRMA,ACLARACI&Oacute;N,DNI)</span></td>
    <td class="tg-yw4l">{{$cheque->retirado_por}}<br>{{$cheque->dni_retira}}</td>
  </tr>
  <tr>
    <td class="tg-yw4l">N° de CHEQUE:</td>
    <td class="tg-yw4l">{{$cheque->nro_cheque}}</td>
    <td class="tg-yw4l">MONTO:</td>
    <td class="tg-yw4l">{{$cheque->importe}}</td>
  </tr>
  <tr>
    <td class="tg-yw4l">N° DE EXPEDIENTE:<br><span class="tg-y5sk">(TSJ)</span></td>
    <td class="tg-yw4l">{{$cheque->nro_expediente}}</td>
    <td class="tg-yw4l">N° DE ORDEN DE PAGO:<br><span class="tg-y5sk">(TSJ)</span></td>
    <td class="tg-yw4l">{{$cheque->orden_pago}}</td>
  </tr>
  <tr>
    <td class="tg-yw4l">BECA OTORGADA:<br><span class="tg-y5sk">(POR DISP. SE-CFJ N°)</span></td>
    <td class="tg-yw4l">{{$cheque->nro_disp_otorga}}</td>
    <td class="tg-yw4l">REINTEGRO AUTORIZADO:<br><span class="tg-y5sk">(POR DISP. SE-CFJ N°)</span></td>
    <td class="tg-yw4l">{{$cheque->nro_disp_aprueba}}</td>
  </tr>
  <tr>
    <td class="tg-yw4l">REINTEGRO SOLICITADO:<br><span class="tg-y5sk">(POR MEMO CFJ N°)</span></td>
    <td class="tg-yw4l">{{$nro_memo}}</td>
    <td class="tg-yw4l" colspan="2"></td>
  </tr>
</table>
</div>
</body>
</html>