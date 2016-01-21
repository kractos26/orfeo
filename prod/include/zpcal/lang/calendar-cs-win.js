/* 
	calendar-cs-win.js
	language: Czech
	encoding: windows-1250
	author: Lubos Jerabek (xnet@seznam.cz)
	        Jan Uhlir (espinosa@centrum.cz)
*/

// ** I18N
Zapatec.Calendar._DN  = new Array('Ned�le','Pond�l�','�ter�','St�eda','�tvrtek','P�tek','Sobota','Ned�le');
Zapatec.Calendar._SDN = new Array('Ne','Po','�t','St','�t','P�','So','Ne');
Zapatec.Calendar._MN  = new Array('Leden','�nor','B�ezen','Duben','Kv�ten','�erven','�ervenec','Srpen','Z���','��jen','Listopad','Prosinec');
Zapatec.Calendar._SMN = new Array('Led','�no','B�e','Dub','Kv�','�rv','�vc','Srp','Z��','��j','Lis','Pro');

// tooltips
Zapatec.Calendar._TT_cs = Zapatec.Calendar._TT = {};
Zapatec.Calendar._TT["INFO"] = "O komponent� kalend��";
Zapatec.Calendar._TT["TOGGLE"] = "Zm�na prvn�ho dne v t�dnu";
Zapatec.Calendar._TT["PREV_YEAR"] = "P�edchoz� rok (p�idr� pro menu)";
Zapatec.Calendar._TT["PREV_MONTH"] = "P�edchoz� m�s�c (p�idr� pro menu)";
Zapatec.Calendar._TT["GO_TODAY"] = "Dne�n� datum";
Zapatec.Calendar._TT["NEXT_MONTH"] = "Dal�� m�s�c (p�idr� pro menu)";
Zapatec.Calendar._TT["NEXT_YEAR"] = "Dal�� rok (p�idr� pro menu)";
Zapatec.Calendar._TT["SEL_DATE"] = "Vyber datum";
Zapatec.Calendar._TT["DRAG_TO_MOVE"] = "Chy� a t�hni, pro p�esun";
Zapatec.Calendar._TT["PART_TODAY"] = " (dnes)";
Zapatec.Calendar._TT["MON_FIRST"] = "Uka� jako prvn� Pond�l�";
//Zapatec.Calendar._TT["SUN_FIRST"] = "Uka� jako prvn� Ned�li";

Zapatec.Calendar._TT["ABOUT"] =
"DHTML Date/Time Selector\n" +
"(c) zapatec.com 2002-2004\n" + // don't translate this this ;-)
"For latest version visit: http://www.zapatec.com/\n" +
"This translation distributed under GNU LGPL.  See http://gnu.org/licenses/lgpl.html for details." +
"\n\n" +
"V�b�r datumu:\n" +
"- Use the \xab, \xbb buttons to select year\n" +
"- Pou�ijte tla��tka " + String.fromCharCode(0x2039) + ", " + String.fromCharCode(0x203a) + " k v�b�ru m�s�ce\n" +
"- Podr�te tla��tko my�i na jak�mkoliv z t�ch tla��tek pro rychlej�� v�b�r.";

Zapatec.Calendar._TT["ABOUT_TIME"] = "\n\n" +
"V�b�r �asu:\n" +
"- Klikn�te na jakoukoliv z ��st� v�b�ru �asu pro zv��en�.\n" +
"- nebo Shift-click pro sn�en�\n" +
"- nebo klikn�te a t�hn�te pro rychlej�� v�b�r.";

// the following is to inform that "%s" is to be the first day of week
// %s will be replaced with the day name.
Zapatec.Calendar._TT["DAY_FIRST"] = "Zobraz %s prvn�";

// This may be locale-dependent.  It specifies the week-end days, as an array
// of comma-separated numbers.  The numbers are from 0 to 6: 0 means Sunday, 1
// means Monday, etc.
Zapatec.Calendar._TT["WEEKEND"] = "0,6";

Zapatec.Calendar._TT["CLOSE"] = "Zav��t";
Zapatec.Calendar._TT["TODAY"] = "Dnes";
Zapatec.Calendar._TT["TIME_PART"] = "(Shift-)Klikni nebo t�hni pro zm�nu hodnoty";

// date formats
Zapatec.Calendar._TT["DEF_DATE_FORMAT"] = "d.m.yy";
Zapatec.Calendar._TT["TT_DATE_FORMAT"] = "%a, %b %e";

Zapatec.Calendar._TT["WK"] = "wk";
Zapatec.Calendar._TT["TIME"] = "�as:";

/* Preserve data */
	if(Zapatec.Calendar._DN) Zapatec.Calendar._TT._DN = Zapatec.Calendar._DN;
	if(Zapatec.Calendar._SDN) Zapatec.Calendar._TT._SDN = Zapatec.Calendar._SDN;
	if(Zapatec.Calendar._SDN_len) Zapatec.Calendar._TT._SDN_len = Zapatec.Calendar._SDN_len;
	if(Zapatec.Calendar._MN) Zapatec.Calendar._TT._MN = Zapatec.Calendar._MN;
	if(Zapatec.Calendar._SMN) Zapatec.Calendar._TT._SMN = Zapatec.Calendar._SMN;
	if(Zapatec.Calendar._SMN_len) Zapatec.Calendar._TT._SMN_len = Zapatec.Calendar._SMN_len;
	Zapatec.Calendar._DN = Zapatec.Calendar._SDN = Zapatec.Calendar._SDN_len = Zapatec.Calendar._MN = Zapatec.Calendar._SMN = Zapatec.Calendar._SMN_len = null
