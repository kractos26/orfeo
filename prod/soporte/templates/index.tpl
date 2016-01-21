<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Lista de soportes</title>
        <link rel="stylesheet" type="text/css" href="../estilos/orfeo.css">
        <script type="text/javascript" src="../js/jquery-1.4.2.min.js">
        </script>
        <script type="text/javascript" src="../js/jquery.charcounter.js">
        </script>       
        <script type="text/javascript" src="../js/jquery.form.js">
        </script>
        <script type="text/javascript" src="./js/soportes.js">
        </script>       
    </head>
    <body>
        <form id="creSoporte" name="creSoporte">
            
            <table class="borde_tab" id="soporte" width="100%" align="center" margin="4">
                <input type="hidden" name="<!--{$sesNam}-->" value="<!--{$sessid}-->">
                <tr>
                    <td class="titulos4">
                        <b>Crear nuevo ticket</b>
                    </td>               
                    <td class="titulos3"> 
                        <span id="contador"></span>     
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Comentario</b>
                    </td>
                    <td>
                        <b>Tipo de soportes</b>
                    </td>
                </tr>

                <!--INICIO  Seleccion de Tipo documento-->
                <tr>
                    <td rowspan="2">
                        <textarea class="texArea" name="come_sop" id="come_sop" wrap="soft"></textarea>
                    </td>
                    <td align="left" width="15%">
                        <select name="selectTipSop" id="selectTipSop">
                            <!--{foreach key=key item=item from=$tipoSop}--><option value=<!--{$key}-->><!--{$item}--></option>
                            <!--{/foreach}-->
                        </select>
                    </td>
                </tr>
                <!--FIN  Seleccion de Tipo documento-->
                
                <tr>
                    <td align="left">
                        <INPUT class="botones" TYPE=submit VALUE="Crear"/>
                    </td>
                </tr>
                
            </table>
            
            <!-- resultado de ajax al crear soporte --> 
            <div id="output1"></div>
            
        </form>
        
        
       <!--INICIO Mostrar friltros de busqueda-->
       <form id="ordSopor" name="ordSopor" action="index.php" method="post">
           <input type="hidden" name="<!--{$sesNam}-->" value="<!--{$sessid}-->">
            <table class="titulos3b">
                <tr>
                   <td align="left">
                       No Ticket
                   </td> 
                   <td align="left">
                       Tipo de soporte
                   </td>
                   <td align="left">
                       Usuario
                   </td>
                   <td align="left">
                       Estado
                   </td>
                    <td align="left">
                       Responsable
                   </td>
                    <td>
                   </td>
                   <td>
                   </td>
                </tr>
                <tr>
                    <td align="left">
                        <input type="text" name="noTicket" value="<!--{$noTicket}-->"  size="5" maxlength="5" />                     
                    </td>
                    <td align="left">
                        <select name="selectTipSop">
                                <option value="">-- </option>
                                <!--{foreach key=key item=item from=$tipoSop}-->
                                    <!--{if $selectTipSop eq $key}-->
                                        <option selected value=<!--{$key}-->><!--{$item}--></option>
                                    <!--{else}-->
                                        <option value=<!--{$key}-->><!--{$item}--></option>
                                    <!--{/if}-->                                    
                                <!--{/foreach}-->                            
                         </select>                     
                    </td>
                    <td align="left">
                        <select name="usuExte">
                                <option value="">-- </option>
                                <!--{foreach key=key item=item from=$usuExteArr}-->
                                    <!--{if $usuExte eq $key}-->
                                        <option selected value=<!--{$key}-->><!--{$item}--></option>
                                    <!--{else}-->
                                        <option value=<!--{$key}-->><!--{$item}--></option>
                                    <!--{/if}-->   
                                <!--{/foreach}-->
                            </select>
                    </td>
                    <td align="left">
                        <select name="respons">                            
                                <option value="">-- </option>
                                <!--{foreach key=key item=item from=$ticRespon}-->
                                    <!--{if $respons eq $key}-->
                                        <option selected value=<!--{$key}-->><!--{$item}--></option>
                                    <!--{else}-->
                                        <option value=<!--{$key}-->><!--{$item}--></option>
                                    <!--{/if}-->   
                                <!--{/foreach}-->                                   
                        </select>                     
                    </td>        
                    <td align="left">
                        <select name="estadoTick">                            
                                <!--{foreach key=key item=item from=$ticEstado}-->
                                    <!--{if $estadoTick eq $key}-->
                                        <option selected value=<!--{$key}-->><!--{$item}--></option>
                                    <!--{else}-->
                                        <option value=<!--{$key}-->><!--{$item}--></option>
                                    <!--{/if}-->   
                                <!--{/foreach}-->                                   
                        </select>                     
                    </td> 
                    <td align="right">
                        <input class="botones" type="submit"  name="filtros" value="Enviar" />                                             
                    </td>               
                    <td align="right">
                            <input class="botones" name="actualizar" value="Actualizar"/>
                    </td>      
                </tr>
                <tr>
                   <td colspan="5">
                   </td>
                   <td>
                        Datos por pagina
                   </td>
                   <td>
                        Pangina Numero
                   </td>
                </tr>
                <tr>
                   <td colspan="5">
                   </td>
                    <td align="center">
                        <input type="text" name="cantidad" value="<!--{$cantidad}-->"  size="5" maxlength="10000" />                     
                        <input class="botones_2" value=".."/>
                    </td>
                    <td align="center">
                        <select name="pagNo">                            
                            <!--{section name=numero loop=$numPag}-->
                                <option  value="<!--{$numPag[numero]}-->" 
                                    <!--{if $pagNo eq $numPag[numero]}-->selected="selected"<!--{/if}-->>
                                    <!--{$numPag[numero]}-->
                                </option>
                            <!--{/section}-->
                        </select>
                    </td>
                </tr>
            </table>
        </form>
        <!--FIN Mostrar friltros de busqueda-->        
        
         <!--INICIO Mostrar ticket existentes-->
        <!--{section name=data loop=$sopor}-->
        <!--{strip}-->
        <form id="<!--{$sopor[data].TICKET}-->">
            <input type="hidden" name="<!--{$sesNam}-->" value="<!--{$sessid}-->" />
            <table class="fomatoCellRow" width="100%" bgcolor="<!--{cycle values="#a8bac6, #ffffff"}-->">
                <tr>
                    <td width="12%">
                        <b></>No.Ticket</b>
                    </td>
                    <td>                        
                        <input readonly="readonly" name="ticket" type="text" value="<!--{$sopor[data].TICKET}-->" />
                    </td>                    
                    <td width="100%">
                        <b>Nombre del usuario</b> : <!--{$sopor[data].NOMBRE}-->                        
                    </td>                
                </tr>
                <tr>
                    <td>
                        <b>Tipo de soporte</b>
                    </td>     
                    <td>
                        <!--{$sopor[data].TIPO}-->
                    </td>
                    <td rowspan="3">                        
                        <!--{$sopor[data].COMENT}-->
                    </td>                           
                </tr>
                <tr>
                    <td>
                        <b>Fecha de inicio</b>
                    </td>
                    <td>                        
                        <!--{$sopor[data].FECHAINI}-->
                    </td>
                </tr>                
                <tr>
                    <td>
                        <b>Fecha de cierre</b>
                    </td>
                    <td>
                        <!--{$sopor[data].FECHAFIN}-->
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Responsable actual</b>
                    </td>
                    <td>
                        <!--{$sopor[data].RESPON}-->
                    </td>
                </tr>
                <tr>         
                    <td colspan="5" align="right">
                        <input class="botones" name="<!--{$sopor[data].TICKET}-->_ticket" type="submit" value="Comentarios >" />
                    </td>                                   
                </tr>                
            </table>
            
            <!-- resultado de ajax al consultar comentario -->
            <div class="subForm" id="<!--{$sopor[data].TICKET}-->_resul"></div>
            
        </form>         
        <!--{/strip}-->        
        <!--{/section}-->        
        <!--FIN Mostrar ticket existentes-->
        
                
    </body>
</html>
