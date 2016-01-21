<?php
//$ruta_raiz=".";
//include("$ruta_raiz/config.php"); 			// incluir configuracion.
////include($ADODB_PATH.'/adodb.inc.php');	// $ADODB_PATH configurada en config.php
//include($ruta_raiz.'/adodb/adodb.inc.php');	// $ADODB_PATH configurada en config.php
//$error = 0;
//$dsn = "oci8://usr_orfeo:pwd_orfeo@127.0.0.1/xe";
//$conn = NewADOConnection($dsn);
//if($conn){
//    echo "conec1tado";
//}
//else echo "no conectado";
//
//print "<HTML><PRE>";
//$db = "";
//
//$c1 = OCIlogon($usuario,$contrasena,"//127.0.0.1/xe");
//$c2 = OCIlogon($usuario,$contrasena,"//127.0.0.1/xe");
//
//function create_table($conn)
//{ $stmt = ociparse($conn,"create table scott_hallo (test varchar2(64))");
//  ociexecute($stmt);
//  echo $conn." created table\n\n";
//}
//
//function drop_table($conn)
//{ $stmt = ociparse($conn,"drop table scott_hallo");
//  ociexecute($stmt);
//  echo $conn." dropped table\n\n";
//}
//
//function insert_data($conn)
//{ $stmt = ociparse($conn,"insert into scott_hallo
//            values('$conn' || ' ' || to_char(sysdate,'DD_MON_YY HH24:MI:SS'))");
//  ociexecute($stmt,OCI_DEFAULT);
//  echo $conn." inserted hallo\n\n";
//}
//
//function delete_data($conn)
//{ $stmt = ociparse($conn,"delete from scott_hallo");
//  ociexecute($stmt,OCI_DEFAULT);
//  echo $conn." deleted hallo\n\n";
//}
//
//function commit($conn)
//{ ocicommit($conn);
//  echo $conn." commited\n\n";
//}
//
//function rollback($conn)
//{ ocirollback($conn);
//  echo $conn." rollback\n\n";
//}
//
//function select_data($conn)
//{ $stmt = ociparse($conn,"select * from scott_hallo");
//  ociexecute($stmt,OCI_DEFAULT);
//  echo $conn."____selecting\n\n";
//  while (ocifetch($stmt))
//    echo $conn." <".ociresult($stmt,"TEST").">\n\n";
//  echo $conn."____done\n\n";
//}
//
//create_table($c1);
//insert_data($c1);   // Insert a row using c1
//insert_data($c2);   // Insert a row using c2
//
//select_data($c1);   // Results of both inserts are returned
//select_data($c2);
//
//rollback($c1);      // Rollback using c1
//
//select_data($c1);   // Both inserts have been rolled back
//select_data($c2);
//
//insert_data($c2);   // Insert a row using c2
//commit($c2);        // commit using c2
//
//select_data($c1);   // result of c2 insert is returned
//
//delete_data($c1);   // delete all rows in table using c1
//select_data($c1);   // no rows returned
//select_data($c2);   // no rows returned
//commit($c1);        // commit using c1
//
//select_data($c1);   // no rows returned
//select_data($c2);   // no rows returned
//
//drop_table($c1);
//print "</PRE></HTML>";


var_dump(svn_status(realpath('wc')));


?>

