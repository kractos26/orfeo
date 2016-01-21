/* Slovenian language file for the DHTML Calendar version 0.9.2 
* Author David Milost <mercy@volja.net>, January 2004.
* Feel free to use this script under the terms of the GNU Lesser General
* Public License, as long as you do not remove or alter this notice.
*/
 // full day names
Zapatec.Calendar._DN = new Array
("Nedelja",
 "Ponedeljek",
 "Torek",
 "Sreda",
 "Četrtek",
 "Petek",
 "Sobota",
 "Nedelja");
 // short day names
 Zapatec.Calendar._SDN = new Array
("Ned",
 "Pon",
 "Tor",
 "Sre",
 "Čet",
 "Pet",
 "Sob",
 "Ned");
// short month names
Zapatec.Calendar._SMN = new Array
("Jan",
 "Feb",
 "Mar",
 "Apr",
 "Maj",
 "Jun",
 "Jul",
 "Avg",
 "Sep",
 "Okt",
 "Nov",
 "Dec");
  // full month names
Zapatec.Calendar._MN = new Array
("Januar",
 "Februar",
 "Marec",
 "April",
 "Maj",
 "Junij",
 "Julij",
 "Avgust",
 "September",
 "Oktober",
 "November",
 "December");

// tooltips
// tooltips
Zapatec.Calendar._TT_si = Zapatec.Calendar._TT = {};
Zapatec.Calendar._TT["INFO"] = "O koledarju";

Zapatec.Calendar._TT["ABOUT"] =
"DHTML Date/Time Selector\n" +
"(c) zapatec.com 2002-2004\n" + // don't translate this this ;-)
"Za zadnjo verzijo pojdine na naslov: http://www.zapatec.com\n" +
"This translation distributed under GNU LGPL.  See http://gnu.org/licenses/lgpl.html for details." +
"\n\n" +
"Izbor datuma:\n" +
"- Uporabite \xab, \xbb gumbe za izbor leta\n" +
"- Uporabite " + String.fromCharCode(0x2039) + ", " + String.fromCharCode(0x203a) + " gumbe za izbor meseca\n" +
"- Zadržite klik na kateremkoli od zgornjih gumbov za hiter izbor.";
Zapatec.Calendar._TT["ABOUT_TIME"] = "\n\n" +
"Izbor ćasa:\n" +
"- Kliknite na katerikoli del ćasa za poveć. le-tega\n" +
"- ali Shift-click za zmanj. le-tega\n" +
"- ali kliknite in povlecite za hiter izbor.";

Zapatec.Calendar._TT["TOGGLE"] = "Spremeni dan s katerim se prićne teden";
Zapatec.Calendar._TT["PREV_YEAR"] = "Predhodnje leto (dolg klik za meni)";
Zapatec.Calendar._TT["PREV_MONTH"] = "Predhodnji mesec (dolg klik za meni)";
Zapatec.Calendar._TT["GO_TODAY"] = "Pojdi na tekoći dan";
Zapatec.Calendar._TT["NEXT_MONTH"] = "Naslednji mesec (dolg klik za meni)";
Zapatec.Calendar._TT["NEXT_YEAR"] = "Naslednje leto (dolg klik za meni)";
Zapatec.Calendar._TT["SEL_DATE"] = "Izberite datum";
Zapatec.Calendar._TT["DRAG_TO_MOVE"] = "Pritisni in povleci za spremembo pozicije";
Zapatec.Calendar._TT["PART_TODAY"] = " (danes)";
Zapatec.Calendar._TT["MON_FIRST"] = "Prikaži ponedeljek kot prvi dan";
Zapatec.Calendar._TT["SUN_FIRST"] = "Prikaži nedeljo kot prvi dan";
Zapatec.Calendar._TT["CLOSE"] = "Zapri";
Zapatec.Calendar._TT["TODAY"] = "Danes";

// date formats
Zapatec.Calendar._TT["DEF_DATE_FORMAT"] = "%Y-%m-%d";
Zapatec.Calendar._TT["TT_DATE_FORMAT"] = "%a, %b %e";

Zapatec.Calendar._TT["WK"] = "Ted";

/* Preserve data */
	if(Zapatec.Calendar._DN) Zapatec.Calendar._TT._DN = Zapatec.Calendar._DN;
	if(Zapatec.Calendar._SDN) Zapatec.Calendar._TT._SDN = Zapatec.Calendar._SDN;
	if(Zapatec.Calendar._SDN_len) Zapatec.Calendar._TT._SDN_len = Zapatec.Calendar._SDN_len;
	if(Zapatec.Calendar._MN) Zapatec.Calendar._TT._MN = Zapatec.Calendar._MN;
	if(Zapatec.Calendar._SMN) Zapatec.Calendar._TT._SMN = Zapatec.Calendar._SMN;
	if(Zapatec.Calendar._SMN_len) Zapatec.Calendar._TT._SMN_len = Zapatec.Calendar._SMN_len;
	Zapatec.Calendar._DN = Zapatec.Calendar._SDN = Zapatec.Calendar._SDN_len = Zapatec.Calendar._MN = Zapatec.Calendar._SMN = Zapatec.Calendar._SMN_len = null
