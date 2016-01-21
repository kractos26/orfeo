// ** I18N

// Calendar DA language
// Author: Michael Thingmand Henriksen, <michael (a) thingmand dot dk>
// Encoding: any
// Distributed under the same terms as the calendar itself.

// For translators: please use UTF-8 if possible. We strongly believe that
// Unicode is the answer to a real internationalized world. Also please
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
// for short month names, _SMN) isn't absolutely necessary. We give it here
// for exemplification on how one can customize the short day names, but if
// they are simply the first N letters of the full name you can simply say:
//
// Zapatec.Calendar._SDN_len = N; // short day name length
// Zapatec.Calendar._SMN_len = N; // short month name length
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
"Marts",
"April",
"Maj",
"Juni",
"Juli",
"August",
"September",
"Oktober",
"November",
"December");

// short month names
Zapatec.Calendar._SMN = new Array
("Jan",
"Feb",
"Mar",
"Apr",
"Maj",
"Jun",
"Jul",
"Aug",
"Sep",
"Okt",
"Nov",
"Dec");

// tooltips
Zapatec.Calendar._TT_da = Zapatec.Calendar._TT = {};
Zapatec.Calendar._TT["INFO"] = "Om Kalenderen";

Zapatec.Calendar._TT["ABOUT"] =
"DHTML Date/Time Selector\n" +
"(c) zapatec.com 2002-2004\n" + // don't translate this this ;-)
"For latest version visit: http://www.zapatec.com/\n" +
"This translation distributed under GNU LGPL.  See http://gnu.org/licenses/lgpl.html for details." +
"\n\n" +
"Valg af dato:\n" +
"- Brug \xab, \xbb knapperne for at vælge år\n" +
"- Brug " + String.fromCharCode(0x2039) + ", " + String.fromCharCode(0x203a) + " knapperne for at vælge måned\n" +
"- Hold knappen på musen nede på knapperne ovenfor for hurtigere valg.";
Zapatec.Calendar._TT["ABOUT_TIME"] = "\n\n" +
"Valg af tid:\n" +
"- Klik på en vilkårlig del for større værdi\n" +
"- eller Shift-klik for for mindre værdi\n" +
"- eller klik og træk for hurtigere valg.";

Zapatec.Calendar._TT["PREV_YEAR"] = "Ét år tilbage (hold for menu)";
Zapatec.Calendar._TT["PREV_MONTH"] = "Én måned tilbage (hold for menu)";
Zapatec.Calendar._TT["GO_TODAY"] = "Gå til i dag";
Zapatec.Calendar._TT["NEXT_MONTH"] = "Én måned frem (hold for menu)";
Zapatec.Calendar._TT["NEXT_YEAR"] = "Ét år frem (hold for menu)";
Zapatec.Calendar._TT["SEL_DATE"] = "Vælg dag";
Zapatec.Calendar._TT["DRAG_TO_MOVE"] = "Træk vinduet";
Zapatec.Calendar._TT["PART_TODAY"] = " (i dag)";

// the following is to inform that "%s" is to be the first day of week
// %s will be replaced with the day name.
Zapatec.Calendar._TT["DAY_FIRST"] = "Vis %s først";

// This may be locale-dependent. It specifies the week-end days, as an array
// of comma-separated numbers. The numbers are from 0 to 6: 0 means Sunday, 1
// means Monday, etc.
Zapatec.Calendar._TT["WEEKEND"] = "0,6";

Zapatec.Calendar._TT["CLOSE"] = "Luk";
Zapatec.Calendar._TT["TODAY"] = "I dag";
Zapatec.Calendar._TT["TIME_PART"] = "(Shift-)klik eller træk for at ændre værdi";

// date formats
Zapatec.Calendar._TT["DEF_DATE_FORMAT"] = "%d-%m-%Y";
Zapatec.Calendar._TT["TT_DATE_FORMAT"] = "%a, %b %e";

Zapatec.Calendar._TT["WK"] = "Uge";
Zapatec.Calendar._TT["TIME"] = "Tid:";

/* Preserve data */
	if(Zapatec.Calendar._DN) Zapatec.Calendar._TT._DN = Zapatec.Calendar._DN;
	if(Zapatec.Calendar._SDN) Zapatec.Calendar._TT._SDN = Zapatec.Calendar._SDN;
	if(Zapatec.Calendar._SDN_len) Zapatec.Calendar._TT._SDN_len = Zapatec.Calendar._SDN_len;
	if(Zapatec.Calendar._MN) Zapatec.Calendar._TT._MN = Zapatec.Calendar._MN;
	if(Zapatec.Calendar._SMN) Zapatec.Calendar._TT._SMN = Zapatec.Calendar._SMN;
	if(Zapatec.Calendar._SMN_len) Zapatec.Calendar._TT._SMN_len = Zapatec.Calendar._SMN_len;
	Zapatec.Calendar._DN = Zapatec.Calendar._SDN = Zapatec.Calendar._SDN_len = Zapatec.Calendar._MN = Zapatec.Calendar._SMN = Zapatec.Calendar._SMN_len = null
