<table class="tabla">
    <tr class="cabetabla">
        <td colspan="6">
            <p>
                ADMINISTRADOR
            </p>
            
        </td>
        <td colspan="7">
            <p>ADMINISTRADOR WEB </p>   
        </td>
    </tr>
    <tr class="cabetabla">
    <td>
        CAMPO
    </td>
    <td>
        NOMBRE ASIGNADO ETIQUETA
    </td>
    <td>
        ACTIVO
    </td>
    <td>
        PUBLICO
    </td>
    <td>
        OBLIGATORIO
    </td>
    <td>
        AYUDA
    </td>
    <td>
        DESPLEGABLE
    </td>
    <td>
        OCULTO
    </td>
    <td>
              TIPO CAMPO
            </td>
    <td>
        TAMA&Ntilde;O
    </td>
    
            <td>
               TABLA
            </td>
            <td>
               VALUE
            </td>
            <td>
              OPCION
            </td>
    </tr>
         <?php
    
    $ids;
      while(!$resultado->EOF)
      {  
         $ids.=$resultado->fields['ID'].",";
         ?>
            
        <tr>
            <td>
                <?=$resultado->fields["NOMBRE"]?>
            </td>
            <td>
                <input type="text" name="etiqueta_<?=$resultado->fields['ID']?>" value="<?=$resultado->fields['ETIQUETA']?>" width="200px">
            </td>
            <td>
               <p><input type="checkbox" name="activo_<?=$resultado->fields['ID']?>" <?=($resultado->fields['ACTIVO'])?"checked":""?> value="1" > </p>
            </td>
            <td>
               <p><input type="checkbox" name="publico_<?=$resultado->fields['ID']?>" <?=($resultado->fields['PUBLICO'])?"checked":""?> value="1">  </p>
            </td>
            <td>
               <p><input type="checkbox" name="obligatorio_<?=$resultado->fields['ID']?>" <?=($resultado->fields['OBLIGATORIO'])?"checked":""?> value="1"> </p>
            </td>
            <td>
                <textarea name="ayuda_<?=$resultado->fields['ID']?>"><?=utf8_decode($resultado->fields['AYUDA'])?></textarea>
            </td>
            <td>
              <p><input type="checkbox" name="desplegable_<?=$resultado->fields['ID']?>" id = "desplegable_<?=$resultado->fields['ID']?>" <?=($resultado->fields['TIPOCAMPO']==2)?"checked":""?> value="2" onclick="desplegable(<?=$resultado->fields['ID']?>);" > </p>
 
            </td>
            <td>
              <p><input type="checkbox" name="oculto_<?=$resultado->fields['ID']?>" id="oculto_<?=$resultado->fields['ID']?>" <?=($resultado->fields['TIPOCAMPO']==6)?"checked":""?> value="6" onclick="oculto(<?=$resultado->fields['ID']?>);"> </p>
            </td>
            <td>
                     <p>
                        
                         <select name="tipocampo_<?=$resultado->fields['ID']?>" id="tipocampo_<?=$resultado->fields['ID']?>" title="" onchange="tipocampo(<?=$resultado->fields['ID']?>)">
                             <option value="0"> Selecione un tipo de  campo</option>
                             <option <?=($resultado->fields['TIPOCAMPO']==1)?'selected':"" ?>  value="1">
                                 Alfanumerico
                             </option>
                             <option <?=($resultado->fields['TIPOCAMPO']==3)?'selected':""?> value="3">
                                 chulo
                             </option>
                             <option <?=($resultado->fields['TIPOCAMPO']==4)?'selected':""?> value="4">
                                 Alfanumerico multi lienea
                             </option>
                             <option <?=($resultado->fields['TIPOCAMPO']==7)?'selected':""?> value="7">
                                 numeros
                             </option>
                             <option <?=($resultado->fields['TIPOCAMPO']==8)?'selected':""?> value="8">
                                 video
                             </option>
                             <option <?=($resultado->fields['TIPOCAMPO']==9)?'selected':""?> value="9">
                                 Adjunto
                             </option>
                             <option <?=($resultado->fields['TIPOCAMPO']==10)?'selected':""?> value="10">
                                 Correo
                             </option>
                             <option <?=($resultado->fields['TIPOCAMPO']==11)?'selected':""?> value="11">
                                 Catcha
                             </option>
                             <option <?=($resultado->fields['TIPOCAMPO']==12)?'selected':""?> value="12">
                                 Telefono
                             </option>
                         </select>
                         
                     </p>
            </td>
            <td>
                <p><input type="number"  name="tamano_<?=$resultado->fields['ID']?>" id="tamano_<?=$resultado->fields['ID']?>" value="<?=$resultado->fields['TAMANO']?>"  style="width: 40px;"> </p>
            </td>
           
            <td>
               <p><input type="text" name="tabla_<?=$resultado->fields['ID']?>" value="<?=$resultado->fields['TABLA']?>"  title="Nombre de la tabla de la base de datos" style="width: 200px;">  </p>
            </td>
            <td>
               <p><input type="text" name="value_<?=$resultado->fields['ID']?>" value="<?=$resultado->fields['VALUE']?>"  title="En campo valor de la base de datos o contenido de variable" style="width: 200px;">  </p>
            </td>
            <td>
               <p><input type="text" name="option_<?=$resultado->fields['ID']?>" value="<?=$resultado->fields['OPCION']?>"  title="Opciones select" style="width: 200px;">  </p>
            </td>
             
        </tr>
    <?php
       $resultado->MoveNext();
      }
    ?>
       
</table>