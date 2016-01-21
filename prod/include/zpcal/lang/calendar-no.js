// ** I18N

// Calendar NO language
// Author: Daniel Holmen, <daniel.holmen@ciber.no>
// Encoding: UTF-8
// Distributed under the same terms as the calendar itself.

// For translators: please use UTF-8 if possible.  We strongly believe that
// Unicode is the answer to a real internationalized world.  Also please
// include your contact information in the header, as can be seen above.

// full day names
Zapatec.Calendar._DN = new Array
("Søndag",
 "Mandag",
 "Tirsdag",
 "Onsdag",
 "Torsdag",
 "Fredag",
 "Lørdag",
 "Søndag");

// Please note that the following array of short day names (and the same goes
// for short month names, _SMN) isn't absolutely necessary.  We give it here
// for exemplification on how one can customize the short day names, but if
// they are simply the first N letters of the full name you can simply say:
//
//   Zapatec.Calendar._SDN_len = N; // short day name length
//   Zapatec.Calendar._SMN_len = N; // short month name length
//
// If N = 3 then this is not needed either since we assume a value of 3 if not
// present, to be compatible with translation files that were written before
// this feature.

// short day names
Zapatec.Calendar._SDN = new Array
("Søn",
 "Man",
 "Tir",
 "Ons",
 "Tor",
 "Fre",
 "Lør",
 "Søn");

// full month names
Zapatec.Calendar._MN = new Array
("Januar",
 "Februar",
 "Mars",
 "April",
 "Mai",
 "Juni",
 "Juli",
 "August",
 "September",
 "Oktober",
 "November",
 "Desember");

// short month names
Zapatec.Calendar._SMN = new Array
("Jan",
 "Feb",
 "Mar",
 "Apr",
 "Mai",
 "Jun",
 "Jul",
 "Aug",
 "Sep",
 "Okt",
 "Nov",
 "Des");

// tooltips
Zapatec.Calendar._TT_no = Zapatec.Calendar._TT = {};
Zapatec.Calendar._TT["INFO"] = "Om kalenderen";

Zapatec.Calendar._TT["ABOUT"] =
"DHTML Dato-/Tidsvelger\n" +
"(c) zapatec.com 2002-2004\n" + // don't translate this this ;-)
"For nyeste versjon, gå til: http://www.zapatec.com\n" +
"This translation distributed under GNU LGPL.  See http://gnu.org/licenses/lgpl.html for details." +
"\n\n" +
"Datovalg:\n" +
"- Bruk knappene \xab og \xbb for å velge år\n" +
"- Bruk knappene " + String.fromCharCode(0x2039) + " og " + String.fromCharCode(0x203a) + " for å velge måned\n" +
"- Hold inne musknappen eller knappene over for raskere valg.";
Zapatec.Calendar._TT["ABOUT_TIME"] = "\n\n" +
"Tidsvalg:\n" +
"- Klikk på en av tidsdelene for å øke den\n" +
"- eller Shift-klikk for å senke verdien\n" +
"- eller klikk-og-dra for raskere valg..";

Zapatec.Calendar._TT["PREV_YEAR"] = "Forrige. år (hold for meny)";
Zapatec.Calendar._TT["PREV_MONTH"] = "Forrige. måned (hold for meny)";
Zapatec.Calendar._TT["GO_TODAY"] = "Gå til idag";
Zapatec.Calendar._TT["NEXT_MONTH"] = "Neste måned (hold for meny)";
Zapatec.Calendar._TT["NEXT_YEAR"] = "Neste år (hold for meny)";
Zapatec.Calendar._TT["SEL_DATE"] = "Velg dato";
Zapatec.Calendar._TT["DRAG_TO_MOVE"] = "Dra for å flytte";
Zapatec.Calendar._TT["PART_TODAY"] = " (idag)";
Zapatec.Calendar._TT["MON_FIRST"] = "Vis mandag først";
Zapatec.Calendar._TT["SUN_FIRST"] = "Vis søndag først";
Zapatec.Calendar._TT["CLOSE"] = "Lukk";
Zapatec.Calendar._TT["TODAY"] = "Idag";
Zapatec.Calendar._TT["TIME_PART"] = "(Shift-)Klikk eller dra for å endre verdi";

// date formats
Zapatec.Calendar._TT["DEF_DATE_FORMAT"] = "%d.%m.%Y";
Zapatec.Calendar._TT["TT_DATE_FORMAT"] = "%a, %b %e";

Zapatec.Calendar._TT["WK"] = "uke";

/* Preserve data */
	if(Zapatec.Calendar._DN) Zapatec.Calendar._TT._DN = Zapatec.Calendar._DN;
	if(Zapatec.Calendar._SDN) Zapatec.Calendar._TT._SDN = Zapatec.Calendar._SDN;
	if(Zapatec.Calendar._SDN_len) Zapatec.Calendar._TT._SDN_len = Zapatec.Calendar._SDN_len;
	if(Zapatec.Calendar._MN) Zapatec.Calendar._TT._MN = Zapatec.Calendar._MN;
	if(Zapatec.Calendar._SMN) Zapatec.Calendar._TT._SMN = Zapatec.Calendar._SMN;
	if(Zapatec.Calendar._SMN_len) Zapatec.Calendar._TT._SMN_len = Zapatec.Calendar._SMN_len;
	Zapatec.Calendar._DN = Zapatec.Calendar._SDN = Zapatec.Calendar._SDN_len = Zapatec.Calendar._MN = Zapatec.Calendar._SMN = Zapatec.Calendar._SMN_len = null
