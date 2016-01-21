// ** I18N

// Calendar SK language
// Author: Peter Valach (pvalach@gmx.net)
// Encoding: utf-8
// Last update: 2003/10/29
// Distributed under the same terms as the calendar itself.

// full day names
Zapatec.Calendar._DN = new Array
("NedeÄľa",
 "Pondelok",
 "Utorok",
 "Streda",
 "Ĺ tvrtok",
 "Piatok",
 "Sobota",
 "NedeÄľa");

// short day names
Zapatec.Calendar._SDN = new Array
("Ned",
 "Pon",
 "Uto",
 "Str",
 "Ĺ tv",
 "Pia",
 "Sob",
 "Ned");

// full month names
Zapatec.Calendar._MN = new Array
("JanuĂˇr",
 "FebruĂˇr",
 "Marec",
 "AprĂ­l",
 "MĂˇj",
 "JĂşn",
 "JĂşl",
 "August",
 "September",
 "OktĂłber",
 "November",
 "December");

// short month names
Zapatec.Calendar._SMN = new Array
("Jan",
 "Feb",
 "Mar",
 "Apr",
 "MĂˇj",
 "JĂşn",
 "JĂşl",
 "Aug",
 "Sep",
 "Okt",
 "Nov",
 "Dec");

// tooltips
Zapatec.Calendar._TT_sk = Zapatec.Calendar._TT = {};
Zapatec.Calendar._TT["INFO"] = "O kalendĂˇri";

Zapatec.Calendar._TT["ABOUT"] =
"DHTML Date/Time Selector\n" +
"(c) zapatec.com 2002-2004\n" +
"PoslednĂş verziu nĂˇjdete na: http://www.zapatec.com\n" +
"This translation distributed under GNU LGPL.  See http://gnu.org/licenses/lgpl.html for details." +
"\n\n" +
"VĂ˝ber dĂˇtumu:\n" +
"- PouĹľite tlaÄŤidlĂˇ \xab, \xbb pre vĂ˝ber roku\n" +
"- PouĹľite tlaÄŤidlĂˇ " + String.fromCharCode(0x2039) + ", " + String.fromCharCode(0x203a) + " pre vĂ˝ber mesiaca\n" +
"- Ak ktorĂ©koÄľvek z tĂ˝chto tlaÄŤidiel podrĹľĂ­te dlhĹˇie, zobrazĂ­ sa rĂ˝chly vĂ˝ber.";
Zapatec.Calendar._TT["ABOUT_TIME"] = "\n\n" +
"VĂ˝ber ÄŤasu:\n" +
"- Kliknutie na niektorĂş poloĹľku ÄŤasu ju zvĂ˝Ĺˇi\n" +
"- Shift-klik ju znĂ­Ĺľi\n" +
"- Ak podrĹľĂ­te tlaÄŤĂ­tko stlaÄŤenĂ©, posĂşvanĂ­m menĂ­te hodnotu.";

Zapatec.Calendar._TT["PREV_YEAR"] = "PredoĹˇlĂ˝ rok (podrĹľte pre menu)";
Zapatec.Calendar._TT["PREV_MONTH"] = "PredoĹˇlĂ˝ mesiac (podrĹľte pre menu)";
Zapatec.Calendar._TT["GO_TODAY"] = "PrejsĹĄ na dneĹˇok";
Zapatec.Calendar._TT["NEXT_MONTH"] = "Nasl. mesiac (podrĹľte pre menu)";
Zapatec.Calendar._TT["NEXT_YEAR"] = "Nasl. rok (podrĹľte pre menu)";
Zapatec.Calendar._TT["SEL_DATE"] = "ZvoÄľte dĂˇtum";
Zapatec.Calendar._TT["DRAG_TO_MOVE"] = "PodrĹľanĂ­m tlaÄŤĂ­tka zmenĂ­te polohu";
Zapatec.Calendar._TT["PART_TODAY"] = " (dnes)";
Zapatec.Calendar._TT["MON_FIRST"] = "ZobraziĹĄ pondelok ako prvĂ˝";
Zapatec.Calendar._TT["SUN_FIRST"] = "ZobraziĹĄ nedeÄľu ako prvĂş";
Zapatec.Calendar._TT["CLOSE"] = "ZavrieĹĄ";
Zapatec.Calendar._TT["TODAY"] = "Dnes";
Zapatec.Calendar._TT["TIME_PART"] = "(Shift-)klik/ĹĄahanie zmenĂ­ hodnotu";

// date formats
Zapatec.Calendar._TT["DEF_DATE_FORMAT"] = "$d. %m. %Y";
Zapatec.Calendar._TT["TT_DATE_FORMAT"] = "%a, %e. %b";

Zapatec.Calendar._TT["WK"] = "tĂ˝Ĺľ";

/* Preserve data */
	if(Zapatec.Calendar._DN) Zapatec.Calendar._TT._DN = Zapatec.Calendar._DN;
	if(Zapatec.Calendar._SDN) Zapatec.Calendar._TT._SDN = Zapatec.Calendar._SDN;
	if(Zapatec.Calendar._SDN_len) Zapatec.Calendar._TT._SDN_len = Zapatec.Calendar._SDN_len;
	if(Zapatec.Calendar._MN) Zapatec.Calendar._TT._MN = Zapatec.Calendar._MN;
	if(Zapatec.Calendar._SMN) Zapatec.Calendar._TT._SMN = Zapatec.Calendar._SMN;
	if(Zapatec.Calendar._SMN_len) Zapatec.Calendar._TT._SMN_len = Zapatec.Calendar._SMN_len;
	Zapatec.Calendar._DN = Zapatec.Calendar._SDN = Zapatec.Calendar._SDN_len = Zapatec.Calendar._MN = Zapatec.Calendar._SMN = Zapatec.Calendar._SMN_len = null
