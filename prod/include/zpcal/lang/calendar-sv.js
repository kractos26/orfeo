// ** I18N

// Calendar SV language (Swedish, svenska)
// Author: Mihai Bazon, <mihai_bazon@yahoo.com>
// Translation team: <sv@li.org>
// Translator: Leonard Norrg�rd <leonard.norrgard@refactor.fi>
// Last translator: Leonard Norrg�rd <leonard.norrgard@refactor.fi>
// Encoding: iso-latin-1
// Distributed under the same terms as the calendar itself.

// For translators: please use UTF-8 if possible.  We strongly believe that
// Unicode is the answer to a real internationalized world.  Also please
// include your contact information in the header, as can be seen above.

// full day names
Zapatec.Calendar._DN = new Array
("s�ndag",
 "m�ndag",
 "tisdag",
 "onsdag",
 "torsdag",
 "fredag",
 "l�rdag",
 "s�ndag");

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
Zapatec.Calendar._SDN_len = 2;
Zapatec.Calendar._SMN_len = 3;

// full month names
Zapatec.Calendar._MN = new Array
("januari",
 "februari",
 "mars",
 "april",
 "maj",
 "juni",
 "juli",
 "augusti",
 "september",
 "oktober",
 "november",
 "december");

// tooltips
Zapatec.Calendar._TT_sv = Zapatec.Calendar._TT = {};
Zapatec.Calendar._TT["INFO"] = "Om kalendern";

Zapatec.Calendar._TT["ABOUT"] =
"DHTML Datum/tid-v�ljare\n" +
"(c) zapatec.com 2002-2004\n" + // don't translate this this ;-)
"F�r senaste version g� till: http://www.zapatec.com\n" +
"This translation distributed under GNU LGPL.  See http://gnu.org/licenses/lgpl.html for details." +
"\n\n" +
"Val av datum:\n" +
"- Anv�nd knapparna \xab, \xbb f�r att v�lja �r\n" +
"- Anv�nd knapparna " + String.fromCharCode(0x2039) + ", " + String.fromCharCode(0x203a) + " f�r att v�lja m�nad\n" +
"- H�ll musknappen nedtryckt p� n�gon av ovanst�ende knappar f�r snabbare val.";
Zapatec.Calendar._TT["ABOUT_TIME"] = "\n\n" +
"Val av tid:\n" +
"- Klicka p� en del av tiden f�r att �ka den delen\n" +
"- eller skift-klicka f�r att minska den\n" +
"- eller klicka och drag f�r snabbare val.";

Zapatec.Calendar._TT["PREV_YEAR"] = "F�reg�ende �r (h�ll f�r menu)";
Zapatec.Calendar._TT["PREV_MONTH"] = "F�reg�ende m�nad (h�ll f�r menu)";
Zapatec.Calendar._TT["GO_TODAY"] = "G� till dagens datum";
Zapatec.Calendar._TT["NEXT_MONTH"] = "F�ljande m�nad (h�ll f�r menu)";
Zapatec.Calendar._TT["NEXT_YEAR"] = "F�ljande �r (h�ll f�r menu)";
Zapatec.Calendar._TT["SEL_DATE"] = "V�lj datum";
Zapatec.Calendar._TT["DRAG_TO_MOVE"] = "Drag f�r att flytta";
Zapatec.Calendar._TT["PART_TODAY"] = " (idag)";
Zapatec.Calendar._TT["MON_FIRST"] = "Visa m�ndag f�rst";
Zapatec.Calendar._TT["SUN_FIRST"] = "Visa s�ndag f�rst";
Zapatec.Calendar._TT["CLOSE"] = "St�ng";
Zapatec.Calendar._TT["TODAY"] = "Idag";
Zapatec.Calendar._TT["TIME_PART"] = "(Skift-)klicka eller drag f�r att �ndra tid";

// date formats
Zapatec.Calendar._TT["DEF_DATE_FORMAT"] = "%Y-%m-%d";
Zapatec.Calendar._TT["TT_DATE_FORMAT"] = "%A %d %b %Y";

Zapatec.Calendar._TT["WK"] = "vecka";

/* Preserve data */
	if(Zapatec.Calendar._DN) Zapatec.Calendar._TT._DN = Zapatec.Calendar._DN;
	if(Zapatec.Calendar._SDN) Zapatec.Calendar._TT._SDN = Zapatec.Calendar._SDN;
	if(Zapatec.Calendar._SDN_len) Zapatec.Calendar._TT._SDN_len = Zapatec.Calendar._SDN_len;
	if(Zapatec.Calendar._MN) Zapatec.Calendar._TT._MN = Zapatec.Calendar._MN;
	if(Zapatec.Calendar._SMN) Zapatec.Calendar._TT._SMN = Zapatec.Calendar._SMN;
	if(Zapatec.Calendar._SMN_len) Zapatec.Calendar._TT._SMN_len = Zapatec.Calendar._SMN_len;
	Zapatec.Calendar._DN = Zapatec.Calendar._SDN = Zapatec.Calendar._SDN_len = Zapatec.Calendar._MN = Zapatec.Calendar._SMN = Zapatec.Calendar._SMN_len = null
