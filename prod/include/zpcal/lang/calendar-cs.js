/* 
	calendar-cs-win.js
	language: Czech
	encoding: UTF-8
	author: Lubos Jerabek (xnet@seznam.cz)
	        Jan Uhlir (espinosa@centrum.cz)
*/

// ** I18N
Zapatec.Calendar._DN  = new Array('Neděle','Pondělí','Úterý','Středa','Čtvrtek','Pátek','Sobota','Neděle');
Zapatec.Calendar._SDN = new Array('Ne','Po','Út','St','Čt','Pá','So','Ne');
Zapatec.Calendar._MN  = new Array('Leden','Únor','Březen','Duben','Květen','Červen','Červenec','Srpen','Září','Říjen','Listopad','Prosinec');
Zapatec.Calendar._SMN = new Array('Led','Úno','Bře','Dub','Kvě','Črv','Čvc','Srp','Zář','Říj','Lis','Pro');

// tooltips
Zapatec.Calendar._TT_cs = Zapatec.Calendar._TT = {};
Zapatec.Calendar._TT["INFO"] = "O komponentě kalendář";
Zapatec.Calendar._TT["TOGGLE"] = "Změna prvního dne v týdnu";
Zapatec.Calendar._TT["PREV_YEAR"] = "Předchozí rok (přidrž pro menu)";
Zapatec.Calendar._TT["PREV_MONTH"] = "Předchozí měsíc (přidrž pro menu)";
Zapatec.Calendar._TT["GO_TODAY"] = "Dnešní datum";
Zapatec.Calendar._TT["NEXT_MONTH"] = "Další měsíc (přidrž pro menu)";
Zapatec.Calendar._TT["NEXT_YEAR"] = "Další rok (přidrž pro menu)";
Zapatec.Calendar._TT["SEL_DATE"] = "Vyber datum";
Zapatec.Calendar._TT["DRAG_TO_MOVE"] = "Chyť a táhni, pro přesun";
Zapatec.Calendar._TT["PART_TODAY"] = " (dnes)";
Zapatec.Calendar._TT["MON_FIRST"] = "Ukaž jako první Pondělí";
//Zapatec.Calendar._TT["SUN_FIRST"] = "Ukaž jako první Neděli";

Zapatec.Calendar._TT["ABOUT"] =
"DHTML Date/Time Selector\n" +
"(c) zapatec.com 2002-2004\n" + // don't translate this this ;-)
"For latest version visit: http://www.zapatec.com/\n" +
"This translation distributed under GNU LGPL.  See http://gnu.org/licenses/lgpl.html for details." +
"\n\n" +
"Výběr datumu:\n" +
"- Use the \xab, \xbb buttons to select year\n" +
"- Použijte tlačítka " + String.fromCharCode(0x2039) + ", " + String.fromCharCode(0x203a) + " k výběru měsíce\n" +
"- Podržte tlačítko myši na jakémkoliv z těch tlačítek pro rychlejší výběr.";

Zapatec.Calendar._TT["ABOUT_TIME"] = "\n\n" +
"Výběr času:\n" +
"- Klikněte na jakoukoliv z částí výběru času pro zvýšení.\n" +
"- nebo Shift-click pro snížení\n" +
"- nebo klikněte a táhněte pro rychlejší výběr.";

// the following is to inform that "%s" is to be the first day of week
// %s will be replaced with the day name.
Zapatec.Calendar._TT["DAY_FIRST"] = "Zobraz %s první";

// This may be locale-dependent.  It specifies the week-end days, as an array
// of comma-separated numbers.  The numbers are from 0 to 6: 0 means Sunday, 1
// means Monday, etc.
Zapatec.Calendar._TT["WEEKEND"] = "0,6";

Zapatec.Calendar._TT["CLOSE"] = "Zavřít";
Zapatec.Calendar._TT["TODAY"] = "Dnes";
Zapatec.Calendar._TT["TIME_PART"] = "(Shift-)Klikni nebo táhni pro změnu hodnoty";

// date formats
Zapatec.Calendar._TT["DEF_DATE_FORMAT"] = "d.m.yy";
Zapatec.Calendar._TT["TT_DATE_FORMAT"] = "%a, %b %e";

Zapatec.Calendar._TT["WK"] = "wk";
Zapatec.Calendar._TT["TIME"] = "Čas:";

/* Preserve data */
	if(Zapatec.Calendar._DN) Zapatec.Calendar._TT._DN = Zapatec.Calendar._DN;
	if(Zapatec.Calendar._SDN) Zapatec.Calendar._TT._SDN = Zapatec.Calendar._SDN;
	if(Zapatec.Calendar._SDN_len) Zapatec.Calendar._TT._SDN_len = Zapatec.Calendar._SDN_len;
	if(Zapatec.Calendar._MN) Zapatec.Calendar._TT._MN = Zapatec.Calendar._MN;
	if(Zapatec.Calendar._SMN) Zapatec.Calendar._TT._SMN = Zapatec.Calendar._SMN;
	if(Zapatec.Calendar._SMN_len) Zapatec.Calendar._TT._SMN_len = Zapatec.Calendar._SMN_len;
	Zapatec.Calendar._DN = Zapatec.Calendar._SDN = Zapatec.Calendar._SDN_len = Zapatec.Calendar._MN = Zapatec.Calendar._SMN = Zapatec.Calendar._SMN_len = null
