<html>
<head>
<title>Untitled Document</title>
<script>
function esconder()
{
  document.getElementById('mover2').style.display = 'none';
  document.getElementById('reasignar2').style.display = 'none';
  document.getElementById('mover1').style.display = '';
  document.getElementById('reasignar1').style.display = '';
  
}
function selMover()
{
  esconder();
  document.getElementById('mover2').style.display = '';
  document.getElementById('mover1').style.display = 'none';
}
function selReasignar()
{
  esconder();
  document.getElementById('reasignar2').style.display = '';
  document.getElementById('reasignar1').style.display = 'none';
}
</script>
</head>

<body onLoad="esconder();">
<img src=./imagenes/moverA.gif id=mover1 onClick="selMover();">
<img src=./imagenes/moverA_R.gif id=mover2>
<img src=./imagenes/reasignar.gif id=reasignar1 onClick="selReasignar();">
<img src=./imagenes/reasignar_R.gif id=reasignar2> 
<p></p>
<select name=selDep>
<option value="1">Opcion 1</option>
<option value="2">Opcion 2</option>
<option value="3">Opcion 3</option>
</select>
</body>

</html>
