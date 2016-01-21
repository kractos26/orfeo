// ** I18N

// Calendar LV language
// Author: Juris Valdovskis, <juris@dc.lv>
// Encoding: cp1257
// Distributed under the same terms as the calendar itself.

// For translators: please use UTF-8 if possible.  We strongly believe that
// Unicode is the answer to a real internationalized world.  Also please
// include your contact information in the header, as can be seen above.

// full day names
Zapatec.Calendar._DN = new Array
("Sv�tdiena",
 "Pirmdiena",
 "Otrdiena",
 "Tre�diena",
 "Ceturdiena",
 "Piektdiena",
 "Sestdiena",
 "Sv�tdiena");

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
("Sv",
 "Pr",
 "Ot",
 "Tr",
 "Ce",
 "Pk",
 "Se",
 "Sv");

// full month names
Zapatec.Calendar._MN = new Array
("Janv�ris",
 "Febru�ris",
 "Marts",
 "Apr�lis",
 "Maijs",
 "J�nijs",
 "J�lijs",
 "Augusts",
 "Septembris",
 "Oktobris",
 "Novembris",
 "Decembris");

// short month names
Zapatec.Calendar._SMN = new Array
("Jan",
 "Feb",
 "Mar",
 "Apr",
 "Mai",
 "J�n",
 "J�l",
 "Aug",
 "Sep",
 "Okt",
 "Nov",
 "Dec");

// tooltips
Zapatec.Calendar._TT_lv = Zapatec.Calendar._TT = {};
Zapatec.Calendar._TT["INFO"] = "Par kalend�ru";

Zapatec.Calendar._TT["ABOUT"] =
"DHTML Date/Time Selector\n" +
"(c) zapatec.com 2002-2004\n" + // don't translate this this ;-)
"For latest version visit: http://www.zapatec.com\n" +
"This translation distributed under GNU LGPL.  See http://gnu.org/licenses/lgpl.html for details." +
"\n\n" +
"Datuma izv�le:\n" +
"- Izmanto \xab, \xbb pogas, lai izv�l�tos gadu\n" +
"- Izmanto " + String.fromCharCode(0x2039) + ", " + String.fromCharCode(0x203a) + "pogas, lai izv�l�tos m�nesi\n" +
"- Turi nospiestu peles pogu uz jebkuru no augst�k min�taj�m pog�m, lai pa�trin�tu izv�li.";
Zapatec.Calendar._TT["ABOUT_TIME"] = "\n\n" +
"Laika izv�le:\n" +
"- Uzklik��ini uz jebkuru no laika da��m, lai palielin�tu to\n" +
"- vai Shift-klik��is, lai samazin�tu to\n" +
"- vai noklik��ini un velc uz attiec�go virzienu lai main�tu �tr�k.";

Zapatec.Calendar._TT["PREV_YEAR"] = "Iepr. gads (turi izv�lnei)";
Zapatec.Calendar._TT["PREV_MONTH"] = "Iepr. m�nesis (turi izv�lnei)";
Zapatec.Calendar._TT["GO_TODAY"] = "�odien";
Zapatec.Calendar._TT["NEXT_MONTH"] = "N�ko�ais m�nesis (turi izv�lnei)";
Zapatec.Calendar._TT["NEXT_YEAR"] = "N�ko�ais gads (turi izv�lnei)";
Zapatec.Calendar._TT["SEL_DATE"] = "Izv�lies datumu";
Zapatec.Calendar._TT["DRAG_TO_MOVE"] = "Velc, lai p�rvietotu";
Zapatec.Calendar._TT["PART_TODAY"] = " (�odien)";

// the following is to inform that "%s" is to be the first day of week
// %s will be replaced with the day name.
Zapatec.Calendar._TT["DAY_FIRST"] = "Att�lot %s k� pirmo";

// This may be locale-dependent.  It specifies the week-end days, as an array
// of comma-separated numbers.  The numbers are from 0 to 6: 0 means Sunday, 1
// means Monday, etc.
Zapatec.Calendar._TT["WEEKEND"] = "1,7";

Zapatec.Calendar._TT["CLOSE"] = "Aizv�rt";
Zapatec.Calendar._TT["TODAY"] = "�odien";
Zapatec.Calendar._TT["TIME_PART"] = "(Shift-)Klik��is vai p�rvieto, lai main�tu";

// date formats
Zapatec.Calendar._TT["DEF_DATE_FORMAT"] = "%d-%m-%Y";
Zapatec.Calendar._TT["TT_DATE_FORMAT"] = "%a, %e %b";

Zapatec.Calendar._TT["WK"] = "wk";
Zapatec.Calendar._TT["TIME"] = "Laiks:";

/* Preserve data */
	if(Zapatec.Calendar._DN) Zapatec.Calendar._TT._DN = Zapatec.Calendar._DN;
	if(Zapatec.Calendar._SDN) Zapatec.Calendar._TT._SDN = Zapatec.Calendar._SDN;
	if(Zapatec.Calendar._SDN_len) Zapatec.Calendar._TT._SDN_len = Zapatec.Calendar._SDN_len;
	if(Zapatec.Calendar._MN) Zapatec.Calendar._TT._MN = Zapatec.Calendar._MN;
	if(Zapatec.Calendar._SMN) Zapatec.Calendar._TT._SMN = Zapatec.Calendar._SMN;
	if(Zapatec.Calendar._SMN_len) Zapatec.Calendar._TT._SMN_len = Zapatec.Calendar._SMN_len;
	Zapatec.Calendar._DN = Zapatec.Calendar._SDN = Zapatec.Calendar._SDN_len = Zapatec.Calendar._MN = Zapatec.Calendar._SMN = Zapatec.Calendar._SMN_len = null
