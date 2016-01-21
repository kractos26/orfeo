<?php
error_reporting(0);
	if(isset($var_filename))
	{
		if(!file_exists("../bodega/faxtmp/$var_filename"."pdf") or !file_exists("../bodega/faxtmp/$var_filename"."tif"))
		{
			$sshExec = "ssh -l orfeo 172.16.1.168 sudo chmod 775 /var/spool/hylafax/recvq/$var_filename"."tif";
			exec($sshExec,$execOutput,$execReturn);	
			$dirRaiz = str_replace("/fax/image.php","/bodega/faxtmp/",$PHP_SELF);
			$sshExec = "scp orfeo@172.16.1.168:/var/spool/hylafax/recvq/$var_filename"."tif  172.16.0.168:$dirRaiz".".";
			
			$sshExec = "scp orfeo@172.16.1.168:/var/spool/hylafax/recvq/$var_filename"."tif  ../bodega/faxtmp/.";
			exec($sshExec,$execOutput,$execReturn);	
			if($execReturn==0)
			{
			$sshExec = "/usr/bin/convert "." ../bodega/faxtmp/$var_filename"."tif ../bodega/faxtmp/$var_filename-%d".".jpg";
			exec($sshExec,$execOutput,$execReturn);	
				if($execReturn==0)
				{
				}
				else
				{
					echo "<script>alert('Convirtio Mal  --- $sshExec');</script>";
				}
			$sshExec = "/usr/bin/convert "."../bodega/faxtmp/$var_filename*.jpg ../bodega/faxtmp/$var_filename"."pdf";
			exec($sshExec,$execOutput,$execReturn);	
				if($execReturn==0)
				{
				}
				else
				{
					echo "<script>alert('Convirtio Mal  --- ');</script>";
				}
				$sshExec = "rm ../bodega/faxtmp/$var_filename*jpg";
				exec($sshExec,$execOutput,$execReturn);
			}else
			{
				echo "<script>alert('No pudo copiar la Imagen  --- ');</script>";
			}
		}else
		{
			exec("chmod 775 ../bodega/faxtmp/$var_filename"."tif");
		}
		header("Content-type: application/pdf");
		readfile("../bodega/faxtmp/$var_filename"."pdf");
	}
	else
	{
		print("<center><img src=\"warning.png\"><h1>No hay Imagen Cargada</h1></center>");
	}
?>
