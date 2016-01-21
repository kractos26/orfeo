
<html>
<head>
<title>Fundacion Del Quemado</title>
<link href="estilos.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
helpstat = false;
stprompt = true;
basic = false;

function thelp(swtch){
        if (swtch == 1){
                basic = false;
                stprompt = false;
                helpstat = true;
        }
        else if (swtch == 0) {
                helpstat = false;
                stprompt = false;
                basic = true;
        }
        else if (swtch == 2) {
                helpstat = false;
                basic = false;
                stprompt = true;
        }
}

function treset(){
        if (helpstat){
                alert("Clears the current editor.");
        }
        else {
        clear = prompt("Are you sure? (yes/no)",'');
        clear = clear.toLowerCase();
        if(clear == 'yes') {
                document.editor.reset();
                document.editor.value = "";
        }
        }
}

function start(){
        if (helpstat){
                alert("Elements that appear at the beginning of the document, including TITLE.");
        }
        else if (basic) {
        document.editor.descripcion.value = document.editor.descripcion.value + "<html>\n<head>\n<title></title>\n</head>\n<body>\n";
        }
        else if (stprompt) {

                for(;;){
                        twrite = prompt("Title?",'');
                        if (twrite != "" && twrite != null){
                                break;
                        }
                        else {
                                prompt("You must enter a title.",'Ok, sorry.');
                        }
                }
                document.editor.descripcion.value = document.editor.descripcion.value + "<html>\n<head>\n<title>" + twrite + "</title>\n</head>\n<body ";

                twrite = prompt("Background color? (blank if none)",'');
                if (twrite != "" && twrite != null){
                        twrite = '"' + twrite + '"';
                        document.editor.descripcion.value = document.editor.descripcion.value + "bgcolor=" + twrite + " ";
                }

                twrite = prompt("Background image? (blank if none)",'');
                if (twrite != "" && twrite != null){
                        twrite = '"' + twrite + '"';
                        document.editor.descripcion.value = document.editor.descripcion.value + "background=" + twrite + " ";
                }

                twrite = prompt("Text color? (blank if none)",'');
                if (twrite != "" && twrite != null){
                        twrite = '"' + twrite + '"';
                        document.editor.descripcion.value = document.editor.descripcion.value + "text=" + twrite + " ";
                }

                twrite = prompt("Link color? (blank if none)",'');
                if (twrite != "" && twrite != null){
                        twrite = '"' + twrite + '"';
                        document.editor.descripcion.value = document.editor.descripcion.value + "link=" + twrite + " ";
                }

                twrite = prompt("Visited link color? (blank if none)",'');
                if (twrite != "" && twrite != null){
                        twrite = '"' + twrite + '"';
                        document.editor.descripcion.value = document.editor.descripcion.value + "vlink=" + twrite + " ";
                }

                document.editor.descripcion.value = document.editor.descripcion.value + ">\n";
        }
}

function end(){
        if (helpstat){
                alert("Adds the the final elements to a document.");
        }
        else {
        document.editor.descripcion.value = document.editor.descripcion.value + "\n</body>\n</html>\n";
        }
}

function preview(){
        if (helpstat) {
                alert("Preview/save the document.");
        }
        else {
                temp = document.editor.descripcion.value;
                preWindow= open("", "preWindow","status=no,toolbar=no,menubar=yes");
                preWindow.document.open();
                preWindow.document.write(temp);
                preWindow.document.close();
        }
}

function bold() {
        if (helpstat) {
                alert("Bold text.");
        }
        else if (basic) {
                document.editor.descripcion.value = document.editor.descripcion.value + "<b></b>";
        }
        else if (stprompt) {
                twrite = prompt("Text?",'');
                if (twrite != null && twrite != ""){
                document.editor.descripcion.value = document.editor.descripcion.value + "<b>" + twrite + "</b>";
                }
        }
}

function italic() {
        if (helpstat) {
                alert("Italicizes text.");
        }
        else if (basic) {
                document.editor.descripcion.value = document.editor.descripcion.value + "<i></i>";
        }
        else if (stprompt) {
                twrite = prompt("Text?",'');
                if (twrite != null && twrite != ""){
                document.editor.descripcion.value = document.editor.descripcion.value + "<i>" + twrite + "</i>";
                }
        }
}

function underline(){
        if (helpstat) {
                alert("Underlines text.");
        }
        else if (basic) {
                document.editor.descripcion.value = document.editor.descripcion.value + "<u></u>";
        }
        else if (stprompt) {
                twrite = prompt("Text?",'');
                if (twrite != null && twrite != ""){
                document.editor.descripcion.value = document.editor.descripcion.value + "<u>" + twrite + "</u>";
                }
        }
}

function pre(){
        if (helpstat) {
                alert("Sets text as preformatted.");
        }
        else if (basic) {
                document.editor.descripcion.value = document.editor.descripcion.value + "<pre></pre>";
        }
        else if (stprompt) {
                twrite = prompt("Text?",'');
                if (twrite != null && twrite != ""){
                document.editor.descripcion.value = document.editor.descripcion.value + "<pre>" + twrite + "</pre>";
                }
        }
}

function center(){
        if (helpstat) {
                alert("Centers text.");
        }
        else if (basic) {
                document.editor.descripcion.value = document.editor.descripcion.value + "<center></center>";
        }
        else if (stprompt) {
                twrite = prompt("Text?",'');
                if (twrite != null && twrite != ""){
                document.editor.descripcion.value = document.editor.descripcion.value + "<center>" + twrite + "</center>";
                }
        }
}

function hbar(){
        if (helpstat) {
                alert("Creates a horizontal bar.");
        }
        else {
                document.editor.descripcion.value = document.editor.descripcion.value + "<hr>\n";
        }
}

function lbreak(){
        if (helpstat) {
                alert("Makes a new line, the equivalent of return or enter.");
        }
        else {
                document.editor.descripcion.value = document.editor.descripcion.value + "<br>\n";
        }
}

function pbreak(){
        if (helpstat) {
                alert("Makes two new lines, the equivalent of two returns or enters.");
        }
        else {
                document.editor.descripcion.value = document.editor.descripcion.value + "<p>\n";
        }
}

function image(){
        if (helpstat) {
                alert("Inserts an image.");
        }
        else if (basic) {
                document.editor.descripcion.value = document.editor.descripcion.value + '<img src="">\n';
        }
        else if (stprompt) {
                twrite = prompt("Image location?",'');
                if (twrite != null && twrite != ""){
                twrite = '"' + twrite + '"';
                document.editor.descripcion.value = document.editor.descripcion.value + '<img src=' + twrite + '>\n';
                }
        }
}

function aleft(){
        if (helpstat) {
                alert("Inserts an image with align left.");
        }
        else if (basic) {
                document.editor.descripcion.value = document.editor.descripcion.value + '<img src="" align=left>\n';
        }
        else if (stprompt){
                twrite = prompt("Image location?",'');
                if (twrite != null && twrite != ""){
                twrite = '"' + twrite + '"';
                document.editor.descripcion.value = document.editor.descripcion.value + '<img src=' + twrite + ' align=left>\n';
                }
        }
}

function aright(){
        if (helpstat) {
                alert("Inserts an image with align right.");
        }
        else if (basic) {
                document.editor.descripcion.value = document.editor.descripcion.value + '<img src="" align=right>\n';
        }
        else if (stprompt) {
                twrite = prompt("Image location?",'');
                if (twrite != null && twrite != ""){
                twrite = '"' + twrite + '"';
                document.editor.descripcion.value = document.editor.descripcion.value + '<img src=' + twrite + ' align=right>\n';
                }
        }
}

function atop(){
        if (helpstat) {
                alert("Inserts an image with align top.");
        }
        else if (basic) {
                document.editor.descripcion.value = document.editor.descripcion.value + '<img src=""align=top>\n';
        }
        else if (stprompt) {
                twrite = prompt("Image location?",'');
                if (twrite != null && twrite != ""){
                twrite = '"' + twrite + '"';
                document.editor.descripcion.value = document.editor.descripcion.value + '<img src=' + twrite + ' align=top>\n';
                }
        }
}

function amid(){
        if (helpstat) {
                alert("Inserts an image with align middle.");
        }
        else if (basic) {
                document.editor.descripcion.value = document.editor.descripcion.value + '<img src="" align=middle>\n';
        }
        else if (stprompt) {
                twrite = prompt("Image location?",'');
                if (twrite != null && twrite != ""){
                twrite = '"' + twrite + '"';
                document.editor.descripcion.value = document.editor.descripcion.value + '<img src=' + twrite + ' align=middle>\n';
                }
        }
}

function abottom(){
        if (helpstat) {
                alert("Inserts an image with align bottom.");
        }
        else if (basic) {
                document.editor.descripcion.value = document.editor.descripcion.value + '<img src="" align=bottom>\n';
        }
        else if (stprompt) {
                twrite = prompt("Image location?",'');
                if (twrite != null && twrite != ""){
                twrite = '"' + twrite + '"';
                document.editor.descripcion.value = document.editor.descripcion.value + '<img src=' + twrite + ' align=bottom>\n';
                }
        }
}

function head1(){
        if (helpstat) {
                alert("Creates a header, size 1 (largest size).");
        }
        else if (basic) {
                document.editor.descripcion.value = document.editor.descripcion.value + "<h1></h1>\n";
        }
        else if (stprompt) {
                twrite = prompt("Text?",'');
                if (twrite != null && twrite != ""){
                document.editor.descripcion.value = document.editor.descripcion.value + "<h1>" + twrite + "</h1>\n";
                }
        }
}

function head2(){
        if (helpstat) {
                alert("Creates a header, size 2 (slightly smaller than 1).");
        }
        else if (basic) {
                document.editor.descripcion.value = document.editor.descripcion.value + "<h2></h2>\n";
        }
        else if (stprompt) {
                twrite = prompt("Text?",'');
                if (twrite != null && twrite != ""){
                document.editor.descripcion.value = document.editor.descripcion.value + "<h2>" + twrite + "</h2>\n";
                }
        }
}

function head3(){
        if (helpstat) {
                alert("Creates a header, size 3 (slightly smaller than 2).");
        }
        else if (basic) {
                document.editor.descripcion.value = document.editor.descripcion.value + "<h3></h3>\n";
        }
        else if (stprompt) {
                twrite = prompt("Text?",'');
                if (twrite != null && twrite != ""){
                document.editor.descripcion.value = document.editor.descripcion.value + "<h3>" + twrite + "</h3>\n";
                }
        }
}

function head4(){
        if (helpstat) {
                alert("Creates a header, size 4 (slightly smaller than 3).");
        }
        else if (basic) {
                document.editor.descripcion.value = document.editor.descripcion.value + "<h4></h4>\n";
        }
        else if (stprompt) {
                twrite = prompt("Text?",'');
                if (twrite != null && twrite != ""){
                document.editor.descripcion.value = document.editor.descripcion.value + "<h4>" + twrite + "</h4>\n";
                }
        }
}

function head5(){
        if (helpstat) {
                alert("Creates a header, size 5 (slightly smaller than 4).");
        }
        else if (basic) {
                document.editor.descripcion.value = document.editor.descripcion.value + "<h5></h5>\n";
        }
        else if (stprompt) {
                twrite = prompt("Text?",'');
                if (twrite != null && twrite != ""){
                document.editor.descripcion.value = document.editor.descripcion.value + "<h5>" + twrite + "</h5>\n";
                }
        }
}

function head6(){
        if (helpstat) {
                alert("Creates a header, size 6 (smallest size).");
        }
        else if (basic) {
                document.editor.descripcion.value = document.editor.descripcion.value + "<h6></h6>\n";
        }
        else if (stprompt) {
                twrite = prompt("Text?",'');
                if (twrite != null && twrite != ""){
                document.editor.descripcion.value = document.editor.descripcion.value + "<h6>" + twrite + "</h6>\n";
                }
        }
}

function linkopen(){

        if (helpstat) {
                alert("Escribe la direccion la p\xe1gina:");
        }
        else if (basic) {
                document.editor.descripcion.value = document.editor.descripcion.value + '<a href="">';
        }
        else if (stprompt) {
                twrite = prompt("Cual es la direcci\xf3n la p\xe1gina",'');
                if (twrite != null && twrite != ""){
                twrite = '"' + twrite + '"';
                document.editor.descripcion.value = document.editor.descripcion.value + '<a href=' + twrite + '>';
                for(;;){
                        twrite = prompt("Texto?",'');
                        if (twrite != "" && twrite != null){
                                break;
                        }
                        else {
                                prompt("Debe ingresar el texto de este link",'Obligatorio');
                        }
                        }
                document.editor.descripcion.value = document.editor.descripcion.value + twrite + '</a>\n';
                        }
        }
}

function linktext(){
        if (helpstat) {
                alert("Inserts the text for a link.");
        }
        else if (basic) {
                for(;;){
                        twrite = prompt("Text?",'');
                        if (twrite != "" && twrite != null){
                                break;
                        }
                        else {
                                prompt("You must enter the link text.",'Ok, sorry.');
                        }
                }
                document.editor.descripcion.value = document.editor.descripcion.value + twrite + '\n';
        }
        else if (stprompt) {
                alert("Not used in prompt mode.");
        }
}

function linkclose(){
        if (helpstat) {
                alert("Closes a link.");
        }
        else if (basic) {
                document.editor.descripcion.value = document.editor.descripcion.value + "</a>\n";
        }
        else if (stprompt) {
                alert("Not used in prompt mode.");
        }
}


function anchor(){
        if (helpstat) {
                alert("Sets an anchor (e.g. #here).");
        }
        else if (basic) {
                document.editor.descripcion.value = document.editor.descripcion.value + '<a name="">\n';
        }
        else if (stprompt) {
                twrite = prompt("Anchor name?",'');
                if (twrite != null && twrite != ""){
                twrite = '"' + twrite + '"';
                document.editor.descripcion.value = document.editor.descripcion.value + '<a name=' + twrite + '>\n';
                }
        }
}

function orderopen(){
        if (helpstat) {
                alert("Starts an ordered list.");
        }
        else if (basic) {
                document.editor.descripcion.value = document.editor.descripcion.value + "<ol>\n";
        }
        else if (stprompt) {
                for(i=1;;i++){
                        twrite = prompt("Item " + i + "? (Blank entry stops.)",'');
                        if (twrite == "" || twrite == null){
                                break;
                        }
                        if (i == 1){
                                document.editor.descripcion.value = document.editor.descripcion.value + "<ol>\n";
                                okeydokey = 1;
                        }
                        document.editor.descripcion.value = document.editor.descripcion.value + "<li>" + twrite + "\n";
                }
                if (okeydokey) {
                document.editor.descripcion.value = document.editor.descripcion.value + "</ol>\n";
                }
        }
}

function li(){
        if (helpstat) {
                alert("Creates an item in a list.");
        }
        else if (basic) {
                document.editor.descripcion.value = document.editor.descripcion.value + "<li>";
        }
        else if (stprompt) {
                alert("Not used in prompt mode.");
        }
}

function orderclose(){
        if (helpstat) {
                alert("Closes an ordered list.");
        }
        else if (basic) {
                document.editor.descripcion.value = document.editor.descripcion.value + "</ol>\n";
        }
        else if (stprompt) {
                alert("Not used in prompt mode.");
        }
}

function unorderopen(){
        if (helpstat) {
                alert("Starts an unordered list.");
        }
        else if (basic) {
                document.editor.descripcion.value = document.editor.descripcion.value + "<ul>";
        }
        else if (stprompt) {
                for(i=1;;i++){
                        twrite = prompt("Item " + i + "? (Blank entry stops.)",'');
                        if (twrite == "" || twrite == null){
                                break;
                        }
                        if (i == 1){
                                document.editor.descripcion.value = document.editor.descripcion.value + "<ul>\n";
                                okeydokey = 1;
                        }
                        document.editor.descripcion.value = document.editor.descripcion.value + "<li>" + twrite + "\n";
                }
                if (okeydokey) {
                document.editor.descripcion.value = document.editor.descripcion.value + "</ul>\n";
                }
        }
}

function unorderclose(){
        if (helpstat) {
                alert("Closes an unordered list.");
        }
        else if (basic) {
                document.editor.descripcion.value = document.editor.descripcion.value + "</ul>\n";
        }
        else if (stprompt) {
                alert("Not used in prompt mode.");
        }
}

function defopen(){
        if (helpstat) {
                alert("Starts a definition list.");
        }
        else if (basic) {
                document.editor.descripcion.value = document.editor.descripcion.value + "<dl>";
        }
        else if (stprompt) {
                for(i=1;;i++){
                        twrite = prompt("Term " + i + "? (Blank entry stops.)",'');
                        if (twrite == "" || twrite == null){
                                break;
                        }
                        if (i == 1) {
                                document.editor.descripcion.value = document.editor.descripcion.value + "<dl>\n";
                                okeydokey = 1;
                        }
                        document.editor.descripcion.value = document.editor.descripcion.value + "<dt>" + twrite + "</dt>\n";
                        twrite = prompt("Definition" + i + "? (Blank entry stops.)",'');
                        if (twrite == "" || twrite == null){
                                break;
                        }
                        document.editor.descripcion.value = document.editor.descripcion.value + "<dd>" + twrite + "<dd>\n";
                }
                if (okeydokey){
                document.editor.descripcion.value = document.editor.descripcion.value + "</dl>\n";
                }
        }
}

function defterm(){
        if (helpstat) {
                alert("Creates the term in a definition.");
        }
        else if (basic) {
                document.editor.descripcion.value = document.editor.descripcion.value + "<dt>";
        }
        else if (stprompt) {
                alert("Not used in prompt mode.");
        }
}

function define(){
        if (helpstat) {
                alert("Creates the definition.");
        }
        else if (basic) {
                document.editor.descripcion.value = document.editor.descripcion.value + "<dd>";
        }
        else if (stprompt) {
                alert("Not used in prompt mode.");
        }
}

function defclose(){
        if (helpstat) {
                alert("Closes a defeinition list.");
        }
        else if (basic) {
                document.editor.descripcion.value = document.editor.descripcion.value + "</dt>";
        }
        else if (stprompt) {
                alert("Not used in prompt mode.");
        }
}

function font(){
        if (helpstat) {
                alert("Sets the font.");
        }
        else if (basic) {
                document.editor.descripcion.value = document.editor.descripcion.value + '<font face="">';
        }
        else if (stprompt) {
                twrite = prompt("Font?",'');
                if (twrite != null && twrite != "") {
                twrite = '"' + twrite + '"';
                document.editor.descripcion.value = document.editor.descripcion.value + '<font face=' + twrite + '>';
                }
        }
}

function fontcolor(){
        if (helpstat) {
                alert("Sets the font color.");
        }
        else if (basic) {
                document.editor.descripcion.value = document.editor.descripcion.value + '<font color="">';
        }
        else if (stprompt) {
                twrite = prompt("Color? (hex or name)",'');
                if (twrite != null && twrite != "") {
                twrite = '"' + twrite + '"';
                document.editor.descripcion.value = document.editor.descripcion.value + '<font color=' + twrite + '>';
        }
        }
}


function fontsize(){
        if (helpstat) {
                alert("Sets the font size (a number 1-7, or +2, -3, etc.).");
        }
        else if (basic) {
                document.editor.descripcion.value = document.editor.descripcion.value + "font size=>";
        }
        else if (stprompt) {
                twrite = prompt("Size? (e.g. 1, +5, -2, etc.)",'');
                if (twrite != null && twrite != "") {
                document.editor.descripcion.value = document.editor.descripcion.value + "<font size=" + twrite + ">";
        }
        }
}

function fontclose(){
        if (helpstat) {
                alert("Closes the font changes.");
        }
        else if (basic) {
                document.editor.descripcion.value = document.editor.descripcion.value + "</font>";
        }
        else if (stprompt) {
                document.editor.descripcion.value = document.editor.descripcion.value + "</font>";
        }
}
</script>
</head>
<body bgcolor="#ffffff" background="img/fondo_base.gif" text="#000000" link="#FFFFFF" vlink="#FFFFFF" topmargin="0">
           
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td rowspan="4" valign="top"><div align="center"> 
        <textarea name="descripcion" cols=120 rows=12 wrap=physical class="ecajas">
                  </textarea>
      </div></td>
    <td class="etexto_tabla_mostrar_datosCopy_cabezote"><div align="center"><b>Modo 
        De Edici&oacute;n</b></div></td>
  </tr>
  <tr> 
    <td class="etexto_tabla"><input type="radio" name="mode" value="help" onClick="thelp(1)"> 
      <span class="etexto1">AYUDA</span><br> <span class="etexto2"><i><small>&nbsp;&nbsp;&nbsp;&nbsp;Click 
      sobre el boton para ver la ayuda</small></i>.</span><br> </td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td class="etexto_tabla"><small class="etexto_tabla"> 
      <input name="mode" type="radio" onClick="thelp(0)" value="basic">
      <span class="etexto1">MODO AVANZADO</span><br>
      <span class="etexto1"><i>&nbsp;&nbsp;&nbsp;&nbsp;</i></span><span class="etexto2"><i>La 
      informaci&oacute;n que ingreses la eyiquetas en el &aacute;rea &nbsp;&nbsp;&nbsp;&nbsp;de 
      trabajo</i></span></small></td>
  </tr>
  <tr class="etexto_tabla_mostrar_datos"> 
    <td><div align="center"> 
        <p class="etexto_tabla_mostrar_datos"><b> 
          <input name="button2" type="button" class="ebotones" onClick="preview()" value="Vista Previa">
          <input name="button" type="button" class="ebotones" onClick="treset()" value=" Borrar">
          </b></p>
      </div></td>
    <td>&nbsp; </td>
  </tr>
</table>
           <div align="center"></div>
           <div></div>
           <table width="540" border="0" align="center" cellpadding="1" cellspacing="2">
             <tr class="etexto_tabla">
               <td colspan="2"><div align="center"> FORMATO</div>
               </td>
             </tr>
             <tr>
               <td colspan="2"><div align="center">
                 <p class="etexto_tabla_mostrar_datos">
                   <input name="button5" type="button" class="ebotones" onClick="bold()" value="Negrilla">
                   <input name="button7" type="button" class="ebotones" onClick="pbreak()" value="Nuevo Parrafo">
                   <input name="button8" type="button" class="ebotones" onClick="lbreak()" value="Linea Nueva">
                 </p>
               </div>
               </td>
             </tr>
             <tr class="etexto_tabla">
               <td><div align="center">IMAGEN</div>
               </td>
               <td><div align="center">LINKS</div>
               </td>
             </tr>
             <tr class="etexto_tabla_mostrar_datos">
               <td>
                 <div align="center">
                   <p align="center">
                     <input name="button14" type="button" class="ebotones"onClick="aleft()" value="Imagen">
                   </p>
                 </div>
               </td>
               <td><div align="center">
                   <p align="center">
                     <input name="button21" type="button" class="ebotones" onClick="linkopen()" value="Vinculo">
                   </p>
                 </div>
               </td>
             </tr>
           </table>
           <div align="center"></div>
           <div></div>
           <div align="center"></div>
           <div align="center"></div>
           <div></div>
           <p>
             <input name="fecha" type="hidden" id="fecha" value="<? echo $fecha; ?>">
             <input name="Submit" type="submit" class="ebotones" value="Publicar">
           </p>

           <input type="hidden" name="MM_insert" value="editor">
           </form>
           <p>&nbsp;               </p>
           </td>
         </tr>
       </table>
         </td>
     </tr>
   </table></td>
   <td><img src="imgspacer.gif" width="1" height="14" border="0" alt=""></td>
  </tr>
  <tr>
   <td colspan="13"><img name="index_r10_c1" src="img/index_r10_c1.gif" width="760" height="20" border="0" alt=""></td>
   <td><img src="imgspacer.gif" width="1" height="20" border="0" alt=""></td>
  </tr>
</table>
</body>
</html>


