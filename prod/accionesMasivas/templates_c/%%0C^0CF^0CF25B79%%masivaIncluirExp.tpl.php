<?php /* Smarty version 2.6.26, created on 2014-05-12 11:53:00
         compiled from masivaIncluirExp.tpl */ ?>
<html>
<head>
<title>Incluir Radicado en expediente</title>
<link rel="stylesheet" type="text/css" href="../estilos/orfeo38/orfeo.css" >
<link rel="stylesheet" type="text/css" href="../estilos/fonts-min.css" >
<link rel="stylesheet" type="text/css" href="../estilos/autocomplete.css">

<script type="text/javascript" src="./libs/js/yahoo-dom-event.js"></script>
<script type="text/javascript" src="./libs/js/datasource-min.js"></script>
<script type="text/javascript" src="./libs/js/connection-min.js"></script>
<script type="text/javascript" src="./libs/js/animation-min.js"></script>
<script type="text/javascript" src="./libs/js/autocomplete-min.js"></script>

<script type="text/javascript" src="./libs/js/element-min.js"></script>
<script type="text/javascript" src="./libs/js/yahoo-min.js"></script>
<script type="text/javascript" src="./libs/js/event-min.js"></script>


<!-- INICIO archivo js para manejar los eventos -->
<script type="text/javascript" src="./js/serieMass.js"></script>		<!-- Cambia serie al seleccionar dependencia-->
<script type="text/javascript" src="./js/subserieMass.js"></script>		<!-- Cambia subserie al seleccionar serie-->
<script type="text/javascript" src="./js/autocomMass.js"></script>		<!-- Cambia tipodoc al seleccionar subserie-->
<script type="text/javascript" src="./js/buscarExpMass.js"></script>	<!-- Busca el nombre del exp al pulsar-->
<script type="text/javascript" src="./js/incluirEnExpMass.js"></script>	<!-- Incluir radicados en Expediente-->
<!-- FIN archivo js para manejar los eventos -->

</head>
<body class=" yui-skin-sam">
    <form id="masiva" name="masiva"  method="POST">
    	<input type="hidden" value="<?php echo $this->_tpl_vars['krd']; ?>
" 	name="krd">				
		<table width="96%" align="center" margin="4">      
			<tr>
				<td  class="titulos4" colspan="2" align="center" valign="middle">
					<b>Incluir radicado en expediente</b>
				</td>
			</tr>
			
			<!-- INICIO dependencia-->
			<tr height="40px" class="titulos2">
				<td width="13%">* Dependencia: </td>
				<td width="87%">
					<select name="selectDepe" id="selectDepe" class="select_crearExp">								
		                <?php $_from = $this->_tpl_vars['depeArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
							<?php if ($this->_tpl_vars['depecodi'] == $this->_tpl_vars['key']): ?>
								<option selected value=<?php echo $this->_tpl_vars['key']; ?>
><?php echo $this->_tpl_vars['item']; ?>
</option>
							<?php else: ?>
							<option value=<?php echo $this->_tpl_vars['key']; ?>
><?php echo $this->_tpl_vars['item']; ?>
</option>
							<?php endif; ?>
		                <?php endforeach; endif; unset($_from); ?>
						<option value="0"> Todos las Dependencias</option>
		            </select>
				</td>
			</tr>
			<!-- FIN dependencia-->
        	
			<!-- INICIO Fecha para filtra la busqueda ano-->					
			<tr height="40px" class="titulos2">
				<td>* A&ntilde;o: </td>
				<td>													
					<select name="ano_busq" id="ano_busq" class="select_crearExp">								
		                <?php $_from = $this->_tpl_vars['anoArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>										
								<option value=<?php echo $this->_tpl_vars['key']; ?>
><?php echo $this->_tpl_vars['item']; ?>
</option>										
		                <?php endforeach; endif; unset($_from); ?>
						<option value="0"> Todos los a&ntilde;os</option>
		            </select>
				</td>
			</tr>					
			<!-- FIN Fecha para filtra la busqueda ano-->
						
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
				<td >SubSerie:</td>
				<td>
					<select name="selectSubSerie" id="selectSubSerie" class="select_crearExp">
						<option value="0" selected="selected"> Seleccione una subSerie </option>                            
		            </select>
				</td>
			</tr>
			<!--FIN  Seleccion de SubSerie-->
						
			<!-- INICIO Buscar Expediente -->					
			<tr height="40px" class="titulos2">
		        <td>* Expediente</td>
				<td>							
					<div class="searchNomAutoCom">								
						<input  type="text" name="nomb_Expe_search" class="select_crearExp"	id="nomb_Expe_search"/>
					    <div id="contnExpSearch"></div>
					</div>
					<div class="inpuNoExp"><button class="botones" type="button" id="buscNomExp"> Buscar </button></div>																					                    
				</td>
		    </tr>					
			<!-- FIN Buscar Expediente -->
						
			<!-- INICIO Nombre Actual del expediente -->
			<tr height="40px" class="titulos2">
		        <td valign="top">Nombre del Expediente:</td>
				<td valign="center" width="100%">
					<textarea readonly="READONLY"  class="select_crearExp nombActuExp" name="nombActuExp" id="nombActuExp"></textarea>																					                    
				</td>
		    </tr>
			<!-- FIN Nombre Actual del expediente -->			
			
			<!--INICIO Radicados seleccionados-->
			<tr height="40px" class="titulos2">
				<td valign="top" align="left">
					Radicados:<br/>
				</td>
				<td>
					<textarea name="radicados" id="radicados" readonly="READONLY"  class="select_crearExp nombActuExp"><?php echo $this->_tpl_vars['radicados']; ?>
</textarea>
				</td>
			</tr>
			<!--FIN Radicados seleccionados-->			
			
			<!--INICIO Radicados Hijos de los seleccionados-->
			<?php if ($this->_tpl_vars['rad_hijos'] == ''): ?>
			   &nbsp;
			<?php else: ?>
			<tr height="40px" class="titulos2">
				<td valign="top" align="left">
					Radicados hijos:<br/>
				</td>
				<td>
					<textarea id="rad_hijos"  name="rad_hijos" readonly="READONLY"  class="select_crearExp nombActuExp" ><?php echo $this->_tpl_vars['rad_hijos']; ?>
</textarea>
					Incluir los radicados hijos.
					<input type="checkbox" name="cambExiTrd" value="444"> 
				</td>
			</tr>
			<?php endif; ?>
			<!--FIN Radicados Hijos de los seleccionados-->			
			
			<!--INICIO Botones-->
			<tr height="40px" class="titulos2">		                
				<td colspan="2" valign="center" align="center">
					<button class="botones" type="button" id="incluirEnExpMass"> Incluir </button>
					<button class="botones" type="button" id="cerrarInc"> Cerrar </button>												                    
				</td>
		    </tr>	
			<!--FIN Botones-->			
        </table>
    </form>
	
	<!--INICIO Respuesta -->
	<table id="respuestaTrdMass"  class="yui-hidden2"  width="100%" align="center" margin="4">
		<tr>
			<td  class="titulos4" colspan="2" align="center" valign="middle">
				<center><b>Se incluyeron los siguientes radicados<b></center>
			</td>
		</tr>		
		<tr height="40px" class="titulos2">
			<td valign="center" align="left" width="40%">
				<b>Numero del Expediente:</b><br/>
			</td>
			<td>
				<div id="numExpResul"></div>
			</td>
		</tr>		
		<tr height="40px" class="titulos2">
			<td valign="top" align="left">
				<b>Radicados incluidos:</b><br/>
			</td>
			<td>
				<textarea id="radiIncluidos" readonly="READONLY"  class="select_crearExp nombActuExp"></textarea>
			</td>
		</tr>
		<tr height="40px" class="titulos2">
			<td valign="top" align="left">
				<b>Radicados No incluidos:</b><br/>
			</td>
			<td>
				<textarea id="radiNoIncluidos" readonly="READONLY"  class="select_crearExp nombActuExp"></textarea>
			</td>
		</tr>
		
		<tr>
			<td>
				<button class="botones" type="button" id="cerrarInc2"> Cerrar </button>		
			</td>
		</tr>	
	</table>
	<!--FIN Respuesta -->	
</body>
</html>
