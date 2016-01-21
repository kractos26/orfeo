<?php
/**
 * Clase que construye un archivo XML a partir de un recodset ASOCIATIVO
 *
 * @author Grupo Iyunxi Ltda
 */
class RecodSetToXml
{
    var $rs;

    public function  __construct($rs=null)
    {
        if (is_null($rs)) return false;
        $this->rs=$rs;
        $this->rs->Move(0);
    }

    public function creaXml()
    {
        $writer = new XMLWriter();
        //$writer->setIndent(true);
        $csc=1;
        $writer->openMemory();
        $writer->startDocument();
        $writer->startElement("ROOT");
        while(!$this->rs->EOF)
        {	$writer->startElement("registro");
        	$writer->startElement("CSC");
        	$writer->text($csc);
        	$writer->endElement();
            for ($x=0; $x<$this->rs->FieldCount();$x++)
            {
                $fld = $this->rs->FetchField($x);
                $writer->startElement(strtoupper($fld->name));
                $writer->text($this->rs->fields[strtoupper($fld->name)]);
                $writer->endElement();
            }
            $writer->endElement();
            $this->rs->MoveNext();
            $csc++;
        }
        $writer->endElement();
        $writer->endDocument();
        $algo = $writer->outputMemory(true);
        return $algo;
    }
}
?>