// ** I18N

// Calendar FI language (Finnish, Suomi)
// Author: Jarno Käyhkö, <gambler@phnet.fi>
// Encoding: UTF-8
// Distributed under the same terms as the calendar itself.

// full day names
Zapatec.Calendar._DN = new Array
("Sunnuntai",
 "Maanantai",
 "Tiistai",
 "Keskiviikko",
 "Torstai",
 "Perjantai",
 "Lauantai",
 "Sunnuntai");

// short day names
Zapatec.Calendar._SDN = new Array
("Su",
 "Ma",
 "Ti",
 "Ke",
 "To",
 "Pe",
 "La",
 "Su");

// full month names
Zapatec.Calendar._MN = new Array
("Tammikuu",
 "Helmikuu",
 "Maaliskuu",
 "Huhtikuu",
 "Toukokuu",
 "Kesäkuu",
 "Heinäkuu",
 "Elokuu",
 "Syyskuu",
 "Lokakuu",
 "Marraskuu",
 "Joulukuu");

// short month names
Zapatec.Calendar._SMN = new Array
("Tam",
 "Hel",
 "Maa",
 "Huh",
 "Tou",
 "Kes",
 "Hei",
 "Elo",
 "Syy",
 "Lok",
 "Mar",
 "Jou");

// tooltips
Zapatec.Calendar._TT_fi = Zapatec.Calendar._TT = {};
Zapatec.Calendar._TT["INFO"] = "Tietoja kalenterista";

Zapatec.Calendar._TT["ABOUT"] =
"DHTML Date/Time Selector\n" +
"(c) zapatec.com 2002-2004\n" + // don't translate this this ;-)
"For latest version visit: http://www.zapatec.com/\n" +
"Uusin versio osoitteessa: http://www.zapatec.com\n" +
"This translation distributed under GNU LGPL.  See http://gnu.org/licenses/lgpl.html for details." +
"\n\n" +
"Päivämäärä valinta:\n" +
"- Käytä \xab, \xbb painikkeita valitaksesi vuosi\n" +
"- Käytä " + String.fromCharCode(0x2039) + ", " + String.fromCharCode(0x203a) + " painikkeita valitaksesi kuukausi\n" +
"- Pitämällä hiiren painiketta minkä tahansa yllä olevan painikkeen kohdalla, saat näkyviin valikon nopeampaan siirtymiseen.";
Zapatec.Calendar._TT["ABOUT_TIME"] = "\n\n" +
"Ajan valinta:\n" +
"- Klikkaa kellonajan numeroita lisätäksesi aikaa\n" +
"- tai pitämällä Shift-näppäintä pohjassa saat aikaa taaksepäin\n" +
"- tai klikkaa ja pidä hiiren painike pohjassa sekä liikuta hiirtä muuttaaksesi aikaa nopeasti eteen- ja taaksepäin.";

Zapatec.Calendar._TT["PREV_YEAR"] = "Edell. vuosi (paina hetki, näet valikon)";
Zapatec.Calendar._TT["PREV_MONTH"] = "Edell. kuukausi (paina hetki, näet valikon)";
Zapatec.Calendar._TT["GO_TODAY"] = "Siirry tähän päivään";
Zapatec.Calendar._TT["NEXT_MONTH"] = "Seur. kuukausi (paina hetki, näet valikon)";
Zapatec.Calendar._TT["NEXT_YEAR"] = "Seur. vuosi (paina hetki, näet valikon)";
Zapatec.Calendar._TT["SEL_DATE"] = "Valitse päivämäärä";
Zapatec.Calendar._TT["DRAG_TO_MOVE"] = "Siirrä kalenterin paikkaa";
Zapatec.Calendar._TT["PART_TODAY"] = " (tänään)";
Zapatec.Calendar._TT["MON_FIRST"] = "Näytä maanantai ensimmäisenä";
Zapatec.Calendar._TT["SUN_FIRST"] = "Näytä sunnuntai ensimmäisenä";
Zapatec.Calendar._TT["CLOSE"] = "Sulje";
Zapatec.Calendar._TT["TODAY"] = "Tänään";
Zapatec.Calendar._TT["TIME_PART"] = "(Shift-) Klikkaa tai liikuta muuttaaksesi aikaa";

// date formats
Zapatec.Calendar._TT["DEF_DATE_FORMAT"] = "%d.%m.%Y";
Zapatec.Calendar._TT["TT_DATE_FORMAT"] = "%d.%m.%Y";

Zapatec.Calendar._TT["WK"] = "Vko";

/* Preserve data */
	if(Zapatec.Calendar._DN) Zapatec.Calendar._TT._DN = Zapatec.Calendar._DN;
	if(Zapatec.Calendar._SDN) Zapatec.Calendar._TT._SDN = Zapatec.Calendar._SDN;
	if(Zapatec.Calendar._SDN_len) Zapatec.Calendar._TT._SDN_len = Zapatec.Calendar._SDN_len;
	if(Zapatec.Calendar._MN) Zapatec.Calendar._TT._MN = Zapatec.Calendar._MN;
	if(Zapatec.Calendar._SMN) Zapatec.Calendar._TT._SMN = Zapatec.Calendar._SMN;
	if(Zapatec.Calendar._SMN_len) Zapatec.Calendar._TT._SMN_len = Zapatec.Calendar._SMN_len;
	Zapatec.Calendar._DN = Zapatec.Calendar._SDN = Zapatec.Calendar._SDN_len = Zapatec.Calendar._MN = Zapatec.Calendar._SMN = Zapatec.Calendar._SMN_len = null
