<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<title></title>

<style type="text/css">
	#g_table_content td{
		border: 1px solid #000000; 
		padding: 0in 0.05in;
		width:"273";
	}
	#g_table_content p {
		align:"justify";
		font-family: "Times New Roman", serif; font-size: 12pt;
	}
	#g_header p{
		font-family:"Verdana, sans-serif";
		font size: "font-size: 9pt";
	}

@media print {

	.noprint { display: none; }
}

@media screen {

	.nodisplay { display: none; }
}
	</style>
	<script type="text/javascript">
		window.print();
		function imprimir(){
		window.print();
		}
	</script>

</head>
<body>
<? 
use app\domain\Helper;
$datetime = new DateTime();
//echo "<pre>";
//print_r($beca);
?>
<!--input id="show" class="noprint" type="button" value="Mostrar impresion"/-->
<div class="noprint" align="center">
<input class="noprint" type="button" onClick="imprimir()" value="Imprimir Formulario"/>
</div>
<div class="nodisplay" id="g_print_container">

<div title="header" id="g_header">
	<p align="center"><img src="../img/print-logo.jpg" align="bottom" width="197" height="80" border="0">
	</p>
	<p align="center"><i>"2011,
	A&nacute;o del Bicentenario de la Declaraci&oacute;n de la Independencia de la Rep&uacute;blica Argentina"</i></p>
	<p align="center"><b>ANEXO II
	</b></p>
</div>
<p  align="center"><b>SISTEMA
DE BECAS DEL CENTRO DE FORMACIÓN JUDICIAL (Res. CACFJ Nº 25/11)</b>
</p>
<p align="center">
<b>FORMULARIO
DE SOLICITUD</b></p>
<p align="right">
<font size="2" style="font-size: 10pt">Buenos
Aires, <?=$datetime->format("d");?> de <?=$datetime->format("m");?> de <?=$datetime->format("Y");?></font></p>
</p>

<div id="g_table_content">
<table>
	<tr>
		<td>
			<?if($beca->tipo_beca_id == 1) echo "X";?>
		</td>
		<td>
			<font face="Verdana, sans-serif">
			<font size="2" style="font-size: 10pt">Acogimiento
			a beneficio convenio</font></font>
		</td>
	</tr>
	<tr>
		<td>
			<?if($beca->tipo_beca_id ==  2) echo "X";?>
			
		</td>
		<td>
			<font face="Verdana, sans-serif"><font size="2" style="font-size: 10pt">Acogimiento
			a beneficio convenio y beca</font></font>
		</td>
	</tr>
	<tr>
		<td>
			<?if($beca->tipo_beca_id ==  3) echo "X";?>
		</td>
		<td>
			<font face="Verdana, sans-serif">
			<font size="2" style="font-size: 10pt">Beca
			(sin convenio)</font></font>
		</td>
	</tr>
</table>
<br>
<table>
	<tr>
		<td>
			<font face="Verdana, sans-serif">
			<font size="2" style="font-size: 10pt">APELLIDO y NOMBRE:</font></font>
		</td>
		<td width="273">
			<?=$beca->usi_nombre?>
		</td>
	</tr>
	<tr>
		<td>
			
			<font face="Verdana, sans-serif">
			<font size="2" style="font-size: 10pt">DNI
			Nº:</font></font>
		</td>
		<td width="273">
		<?=$beca->usi_dni?>			
		</td>
	</tr>
	<tr>
		<td>
			<font face="Verdana, sans-serif">
			<font size="2" style="font-size: 10pt">LEGAJO
			Nº:</font></font>
		</td>
		<td width="273">
		<?=$beca->usi_legajo?>
		</td>
	</tr>
	<tr>
		<td>
			<font face="Verdana, sans-serif"><font size="2" style="font-size: 10pt">DOMICILIO
			CONSTITUIDO (en el radio de CABA):</font></font>
		</td>
		<td width="273">
		<?=$beca->domicilio_constituido?>
		</td>
	</tr>
	<tr>
		<td>
			<font face="Verdana, sans-serif"><font size="2" style="font-size: 10pt">TEL.
			PARTICULAR:</font></font>
		</td>
		<td width="273">
		<?=$beca->telefono_particular?>
		</td>
	</tr>
	<tr>
		<td>
			<font face="Verdana, sans-serif"><font size="2" style="font-size: 10pt">TEL.
			LABORAL: </font></font>
			
		</td>
		<td width="273">
		<?=$beca->telefono_laboral?>
		</td>
	</tr>
	<tr>
		<td>
			<font face="Verdana, sans-serif"><font size="2" style="font-size: 10pt">CORREO
			ELECTRÓNICO OFICIAL: </font></font>
			
		</td>
		<td width="273">
		<?=$beca->usi_email?>
		</td>
	</tr>
	<tr>
		<td>
			<font face="Verdana, sans-serif"><font size="2" style="font-size: 10pt">FECHA
			DE INGRESO AL PJCABA:</font></font>
		</td>
		<td width="273">
		<?
		$date = date("d/m/Y", strtotime($beca->f_ingreso_caba));
	 	echo $date;
		?>
		</td>
	</tr>
	<tr>
		<td>
			<font face="Verdana, sans-serif"><font size="2" style="font-size: 10pt">CARGO
			ACTUAL:</font></font>
		</td>
		<td width="273">
		<?=$beca->car_nombre?>
		</td>
	</tr>
	<tr>
		<td>
			<font face="Verdana, sans-serif"><font size="2" style="font-size: 10pt">DEPENDENCIA:</font></font>
		</td>
		<td width="273">
		<?=$beca->dep_nombre?>
		</td>
	</tr>
	<tr>
		<td>
			<font face="Verdana, sans-serif"><font size="2" style="font-size: 10pt">TITULO
			DE GRADO: </font></font>
			
		</td>
		<td width="273">
		<?=$beca->titulo?>
		</td>
	</tr>
	<tr>
		<td>
			<font face="Verdana, sans-serif"><font size="2" style="font-size: 10pt">INSTITUCIÓN:</font></font>
		</td>
		<td width="273">
		<?=$beca->universidad?>	
		</td>
	</tr>
	<tr>
		<td>
			<font face="Verdana, sans-serif"><font size="2" style="font-size: 10pt">FACULTAD:</font></font>
		</td>
		<td width="273">
		<?=$beca->facultad?>	
		</td>
	</tr>
	<tr>
		<td>
			<font face="Verdana, sans-serif"><font size="2" style="font-size: 10pt">INSTITUCIÓN
			PROPUESTA PARA LA ACTIVIDAD:</font></font>
		</td>
		<td width="273">
			<?=Helper::getInstitucionPropuestaId($beca->institucion_propuesta);?>
		</td>
	</tr>
	<tr>
		<td>
			<font face="Verdana, sans-serif"><font size="2" style="font-size: 10pt">CARRERA/CURSO/ACTIVIDAD:</font></font>
		</td>
		<td width="273">
		<?=$beca->actividad_nombre?>	
		</td>
	</tr>
	<tr>
		<td>
			<font face="Verdana, sans-serif"><font size="2" style="font-size: 10pt">FECHA
			DE INICIO:</font></font>
		</td>
		<td width="273">
		<?
		$date = date("d/m/Y", strtotime($beca->fecha_inicio));
		echo $date;
		?>		
		</td>
	</tr>
	<tr>
		<td>
			<font face="Verdana, sans-serif"><font size="2" style="font-size: 10pt">FECHA
			DE FINALIZACIÓN: </font></font>
			
		</td>
		<td width="273">
		<?
		$date = date("d/m/Y", strtotime($beca->fecha_fin));
	 	echo $date;
		?>
		</td>
	</tr>
	<tr>
		<td>
			<font face="Verdana, sans-serif"><font size="2" style="font-size: 10pt">DURACIÓN
			TOTAL DE LA CARRERA/CURSO/ACTIVIDAD:</font></font>
		</td>
		<td width="273">
			<?=$beca->duracion?>
		</td>
	</tr>
	<tr>
		<td>
			<font face="Verdana, sans-serif"><font size="2" style="font-size: 10pt">COSTO
			TOTAL DE LA CARRERA/ CURSO/ACTIVIDAD</font></font><sup><font face="Verdana, sans-serif"><font size="2" style="font-size: 10pt"><a class="sdfootnoteanc" name="sdfootnote2anc" href="#sdfootnote2sym"><sup>2</sup></a></font></font></sup><font face="Verdana, sans-serif"><font size="2" style="font-size: 10pt">:
			: </font></font>
		</td>
		<td width="273">
			<?=$beca->costo?>
		</td>
	</tr>
	<tr>
		<td>
			<font face="Verdana, sans-serif"><font size="2" style="font-size: 10pt">MONTO
			SOLICITADO: </font></font>
		</td>
		<td width="273">
		<?=$beca->monto?>
		</td>
	</tr>
	<tr>
		<td>
			<font face="Verdana, sans-serif"><font size="2" style="font-size: 10pt">DICTAMEN
			EVALUATIVO SUSCRIPTO POR:</font></font>
		</td>
		<td width="273">
		<?=$beca->dictamen_por?>	
		</td>
	</tr>
	<tr>
		<td>
			<font face="Verdana, sans-serif"><font size="2" style="font-size: 10pt">SUPERPOSICIÓN
			HORARIA SI/NO:</font></font>
		</td>
		<td width="273">
			<?=($beca->sup_horaria == 0 )? 'NO' : 'SI'; ?>
		</td>
	</tr>
</table>
</div>

<p  align="justify" style="margin-right: -0.1in; page-break-before: always">
<font face="Verdana, sans-serif"><font size="2" style="font-size: 10pt"><b>OBSERVACIONES:</b>
</font></font>
<br>
<?=$beca->observaciones;?>
<p  align="justify"><font face="Verdana, sans-serif"><font size="2" style="font-size: 10pt"><b>Detalle
sus objetivos profesionales y cómo cree Ud. que el curso o carrera
de posgrado influirá en ellos.</b></font></font>
<br>
<?=$beca->objetivo;?>
<p  align="justify"><font face="Verdana, sans-serif"><font size="2" style="font-size: 10pt"><b>Indique
cuáles son los elementos que vinculan su actividad en el Poder
Judicial de la CABA con los contenidos del curso o carrera de
posgrado y qué entiende que aportará el curso o carrera para su
función.</b></font></font>
<br>
<?=$beca->vinculacion;?>
<p  align="justify"><font face="Verdana, sans-serif"><font size="2" style="font-size: 10pt"><b>Manifiesto
en carácter de declaración jurada que los datos aportados son
completos y correctos y que conozco y acepto el régimen establecido
en la Res. CACFJ Nro   /11.</b></font></font>
<p  align="justify">
<br>
<p  align="justify"><br>

<p  align="center"><br>

<p  align="left"><font face="Verdana, sans-serif"><font size="2" style="font-size: 10pt">Firma:....................................</font></font>
<p  align="left"><br>

<p  align="left"><br>

<p  align="left"><font face="Verdana, sans-serif"><font size="2" style="font-size: 10pt">Aclaración:..............................</font></font>
<p  align="left"><br>

<p  align="left"><br>

<p  align="left"><font face="Verdana, sans-serif"><font size="2" style="font-size: 10pt">DNI
Nº:...................................</font></font>
<h4  class="western" align="left"></h4>
<!--div id="sdfootnote2">
	<p  class="sdfootnote-western"><a class="sdfootnotesym" name="sdfootnote2sym" href="#sdfootnote2anc">2</a><font face="Verdana, sans-serif"><font size="2" style="font-size: 9pt">
	</font></font><font face="Verdana, sans-serif"><font size="2" style="font-size: 9pt">En
	los casos de convenios académicos, indicar el monto resultante una
	vez efectuado el descuento.</font></font>
</div-->

<input class="noprint" type="button" onClick="imprimir()" value="Imprimir"/>

<!-- Don not display on screen Class -->
</div>

</body>
</html>


