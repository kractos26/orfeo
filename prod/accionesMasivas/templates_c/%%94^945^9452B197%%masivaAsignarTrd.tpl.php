<?php /* Smarty version 2.6.26, created on 2014-05-12 11:50:19
         compiled from masivaAsignarTrd.tpl */ ?>
<html>
<head>
<title>Asignar TRD de forma masiva</title>
<link rel="stylesheet" href="../estilos/orfeo38/orfeo.css" />
<script type="text/javascript" src="./libs/js/yahoo-dom-event.js"></script>
<script type="text/javascript" src="./libs/js/element-min.js"></script>
<script type="text/javascript" src="./libs/js/button-min.js"></script>
<script type="text/javascript" src="./libs/js/yahoo-min.js"></script>
<script type="text/javascript" src="./libs/js/event-min.js"></script>
<script type="text/javascript" src="./libs/js/connection-min.js"></script>

<!-- INICIO archivo js para manejar los eventos -->
<script type="text/javascript" src="./js/subserieMass.js"></script>		<!-- Cambia subserie al seleccionar serie-->
<script type="text/javascript" src="./js/tipoDocMass.js"></script>		<!-- Cambia tipo Documental al seleccionar SubSerie-->
<script type="text/javascript" src="./js/asignarTrdMass.js"></script>	<!-- Cambia tipo Documental al seleccionar SubSerie-->
<!-- FIN archivo js para manejar los eventos -->

</head>
<body class=" yui-skin-sam">
    <form id="masiva" method="POST">
		<input type="hidden" value="<?php echo $this->_tpl_vars['krd']; ?>
" 	name="krd">		
		<table id="tabMasivaIncluir" width="95%" align="center" margin="4">
        	
			<tr>
				<td  class="titulos4" colspan="2" align="center" valign="middle">
					<b>Asignar TRD de forma masiva</b>
				</td>
			</tr>
        	
			<!--INICIO  Seleccion de Serie-->	
			<tr height="40px" class="titulos2">
				<td>Serie:</td>
				<td>
					<select name="selectSerie" id="selectSerie" class="select_crearExp">
						<option value="0" selected="selected"> Seleccione una serie </option>
		                <?php $_from = $this->_tpl_vars['serieArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?><option value=<?php echo $this->_tpl_vars['key']; ?>
><?php echo $this->_tpl_vars['item']; ?>
</option>
		                <?php endforeach; endif; unset($_from); ?>
		            </select>
				</td>
			</tr>
			<!--FIN  Seleccion de Serie-->	
			
			
			<!--INICIO  Seleccion de SubSerie-->
			<tr height="40px" class="titulos2">
				<td>SubSerie:</td>
				<td>
					<select name="selectSubSerie" id="selectSubSerie" class="select_crearExp">
						<option value="0" selected="selected"> Seleccione una subSerie </option>                            
		            </select>
				</td>
			</tr>
			<!--FIN  Seleccion de SubSerie-->
			
			
			<!--INICIO  Seleccion de SubSerie-->
			<tr height="40px" class="titulos2">
				<td >Tipo documental:</td>
				<td>
					<select name="selectTipoDoc" id="selectTipoDoc" class="select_crearExp">
						<option value="0" selected="selected"> Seleccione un tipo documental </option>                            
		            </select>
				</td>
			</tr>			
			<!--FIN  Seleccion de SubSerie-->
			
			<!--INICIO mostrar radicados con y sin trd-->
			<?php if ($this->_tpl_vars['radSinTrd'] == ''): ?>
			   &nbsp;
			<?php else: ?>
				<tr height="40px">
					<td valign="top" class="titulos2">Radicados sin Trd:</td>
						<td class="titulos2">
							<textarea readonly="READONLY"  class="select_crearExp nombActuExp" name="radSinTrd" id="radSinTrd" wrap="soft"><?php echo $this->_tpl_vars['radSinTrd']; ?>
</textarea>
						</td>
					</td>
				</tr>
			<?php endif; ?>
			
			<?php if ($this->_tpl_vars['radConTrd'] == ''): ?>
			   &nbsp;
			<?php else: ?>
				<tr height="40px"  class="titulos2">
					<td valign="top" >Radicados con Trd:</td>
						<td>
							<textarea readonly="READONLY"  class="select_crearExp nombActuExp" name="radConTrd" id="radConTrd" wrap="soft"><?php echo $this->_tpl_vars['radConTrd']; ?>
</textarea>
							Cambiar la trd de los que ya tiene una asignada
							<input type="checkbox" name="cambExiTrd" value="111"> 
						</td>
					</td>
				</tr>
			<?php endif; ?>
			<!--FIN mostrar radicados con y sin trd-->
			
			<!--INICIO Botones-->
			<tr height="40px">		                
				<td colspan="2" valign="center" align="center">
					<button class="botones" type="button" id="modificarTrd"> Modificar </button>
					<button class="botones" type="button" id="cerrarTrd"> Cerrar </button>												                    
				</td>
		    </tr>	
			<!--FIN Botones-->
			
        </table>
    </form>
	
	
	<!--INICIO Respuesta -->
	<table id="respuestaTrdMass"  class="yui-hidden2"  width="100%" align="center" margin="4">
		<tr>
			<td  class="titulos4" colspan="2" align="center" valign="middle">
				<center><b>Se cambio la TRD con los siguientes datos<b></center>
			</td>
		</tr>
		<tr bordercolor="white" height="40px" class="titulos2">
			<td  valign="center" width="40%" align="left">
				<b>Nombre de la serie:</b><br/>
			</td>
			<td>
				<div id="serieResul"></div>
			</td>
		</tr>
		<tr height="40px" class="titulos2">
			<td valign="center" align="left">
				<b>Nombre de la subSerie:</b><br/>
			</td>
			<td>
				<div id="subSerResul"></div>
			</td>
		</tr>
		<tr height="40px" class="titulos2">
			<td valign="center" align="left">
				<b>Nombre del tipo Documental:</b><br/>
			</td>
			<td>
				<div id="tipoDocResul"></div>
			</td>
		</tr>		
		<tr height="40px" class="titulos2">
			<td valign="top" align="left">
				<b>Radicados:</b><br/>
			</td>
			<td>
				<textarea id="radicadosResulTex" readonly="READONLY"  class="select_crearExp nombActuExp" wrap="soft" class="tex_area2"></textarea>
			</td>
		</tr>
		<tr>
			<td>
				<button class="botones" type="button" id="cerrarTrd2"> Cerrar </button>		
			</td>
		</tr>	
	</table>
	<!--FIN Respuesta -->
	
	
</body>
</html>
