<!-- request Evento ajax-->
<script type="text/javascript" src="./js/soportes.js">
</script>

<!-- INICIO Crear nuevo comentario y cerrar ticket-->
<!--{if $mosCerrar gt 0}-->
<form id="coment_<!--{$ticket}-->" name="coment_<!--{$ticket}-->">
    <br/>
    <table class="fomatoCellRow" id="soporteComent" width="100%" align="center" margin="4">
        <input type="hidden" name="<!--{$sesNam}-->" value="<!--{$sessid}-->">
        <input type="hidden" name="ticket" value="<!--{$ticket}-->">
        
        <tr>
            <td>
                <b>Nuevo comentario</b>
            </td>
        </tr>
        
        
        <tr>
            <td width="90%">
                <textarea  class="texArea" name="comentario" wrap="soft"></textarea>
            </td>
            <td width="10%" align="right">
                <!--{if $mosCerrar gt 1}-->
                <INPUT class="botones" name="<!--{$ticket}-->_coment" TYPE=submit VALUE="Cerrar Ticket" />
                <br/>
                <!--{/if}-->                
                <INPUT class="botones" name="<!--{$ticket}-->_coment" TYPE=submit VALUE="Comentar" />                
            </td>
        </tr>
        
    </table>
    <!-- resultado de ajax al crear soporte -->
    <div id="outputCom_<!--{$ticket}-->"></div>    
</form>
<!--{/if}-->            
<!-- FIN Crear nuevo comentario y cerrar ticket-->

<!-- INICIO Mostrar comentarios existentes-->
<!--{section name=data loop=$coment}-->
<!--{strip}-->
    <table class="fomatoCellRow" width="100%" bgcolor="<!--{cycle values="#E3E8EC,#ffffff"}-->">
        <tr>
            <td width="150px" align="center" rowspan="2">
                <b>Fecha del comentario:</b> <!--{$coment[data].FECHACOMT}-->
            </td>
            <td>
                <b>Usuario: </b> <!--{$coment[data].USUARIO}-->
            </td>
        </tr>        
        <tr>
            <td>
                <!--{$coment[data].COMENTARIO}-->
            </td>
        </tr>
    </table>    
<!--{/strip}-->
<!--{/section}-->
<!-- FIN Mostrar comentarios existentes-->
