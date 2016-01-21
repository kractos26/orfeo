// ** I18N

// Calendar HU language
// Author: ???
// Modifier: KARASZI Istvan, <jscalendar@spam.raszi.hu>
// Encoding: any
// Distributed under the same terms as the calendar itself.

// For translators: please use UTF-8 if possible.  We strongly believe that
// Unicode is the answer to a real internationalized world.  Also please
// include your contact information in the header, as can be seen above.

// full day names
Zapatec.Calendar._DN = new Array
("Vasárnap",
 "Hétfõ",
 "Kedd",
 "Szerda",
 "Csütörtök",
 "Péntek",
 "Szombat",
 "Vasárnap");

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
("v",
 "h",
 "k",
 "sze",
 "cs",
 "p",
 "szo",
 "v");

// full month names
Zapatec.Calendar._MN = new Array
("január",
 "február",
 "március",
 "április",
 "május",
 "június",
 "július",
 "augusztus",
 "szeptember",
 "október",
 "november",
 "december");

// short month names
Zapatec.Calendar._SMN = new Array
("jan",
 "feb",
 "már",
 "ápr",
 "máj",
 "jún",
 "júl",
 "aug",
 "sze",
 "okt",
 "nov",
 "dec");

// tooltips
Zapatec.Calendar._TT_hu = Zapatec.Calendar._TT = {};
Zapatec.Calendar._TT["INFO"] = "A kalendáriumról";

Zapatec.Calendar._TT["ABOUT"] =
"DHTML dátum/idõ kiválasztó\n" +
"(c) zapatec.com 2002-2004\n" + // don't translate this this ;-)
"a legfrissebb verzió megtalálható: http://www.zapatec.com\n" +
"This translation distributed under GNU LGPL.  See http://gnu.org/licenses/lgpl.html for details." +
"\n\n" +
"Dátum választás:\n" +
"- használja a \xab, \xbb gombokat az év kiválasztásához\n" +
"- használja a " + String.fromCharCode(0x2039) + ", " + String.fromCharCode(0x203a) + " gombokat a hónap kiválasztásához\n" +
"- tartsa lenyomva az egérgombot a gyors választáshoz.";
Zapatec.Calendar._TT["ABOUT_TIME"] = "\n\n" +
"Idõ választás:\n" +
"- kattintva növelheti az idõt\n" +
"- shift-tel kattintva csökkentheti\n" +
"- lenyomva tartva és húzva gyorsabban kiválaszthatja.";

Zapatec.Calendar._TT["PREV_YEAR"] = "Elõzõ év (tartsa nyomva a menühöz)";
Zapatec.Calendar._TT["PREV_MONTH"] = "Elõzõ hónap (tartsa nyomva a menühöz)";
Zapatec.Calendar._TT["GO_TODAY"] = "Mai napra ugrás";
Zapatec.Calendar._TT["NEXT_MONTH"] = "Köv. hónap (tartsa nyomva a menühöz)";
Zapatec.Calendar._TT["NEXT_YEAR"] = "Köv. év (tartsa nyomva a menühöz)";
Zapatec.Calendar._TT["SEL_DATE"] = "Válasszon dátumot";
Zapatec.Calendar._TT["DRAG_TO_MOVE"] = "Húzza a mozgatáshoz";
Zapatec.Calendar._TT["PART_TODAY"] = " (ma)";

// the following is to inform that "%s" is to be the first day of week
// %s will be replaced with the day name.
Zapatec.Calendar._TT["DAY_FIRST"] = "%s legyen a hét elsõ napja";

// This may be locale-dependent.  It specifies the week-end days, as an array
// of comma-separated numbers.  The numbers are from 0 to 6: 0 means Sunday, 1
// means Monday, etc.
Zapatec.Calendar._TT["WEEKEND"] = "0,6";

Zapatec.Calendar._TT["CLOSE"] = "Bezár";
Zapatec.Calendar._TT["TODAY"] = "Ma";
Zapatec.Calendar._TT["TIME_PART"] = "(Shift-)Klikk vagy húzás az érték változtatásához";

// date formats
Zapatec.Calendar._TT["DEF_DATE_FORMAT"] = "%Y-%m-%d";
Zapatec.Calendar._TT["TT_DATE_FORMAT"] = "%b %e, %a";

Zapatec.Calendar._TT["WK"] = "hét";
Zapatec.Calendar._TT["TIME"] = "idõ:";

/* Preserve data */
	if(Zapatec.Calendar._DN) Zapatec.Calendar._TT._DN = Zapatec.Calendar._DN;
	if(Zapatec.Calendar._SDN) Zapatec.Calendar._TT._SDN = Zapatec.Calendar._SDN;
	if(Zapatec.Calendar._SDN_len) Zapatec.Calendar._TT._SDN_len = Zapatec.Calendar._SDN_len;
	if(Zapatec.Calendar._MN) Zapatec.Calendar._TT._MN = Zapatec.Calendar._MN;
	if(Zapatec.Calendar._SMN) Zapatec.Calendar._TT._SMN = Zapatec.Calendar._SMN;
	if(Zapatec.Calendar._SMN_len) Zapatec.Calendar._TT._SMN_len = Zapatec.Calendar._SMN_len;
	Zapatec.Calendar._DN = Zapatec.Calendar._SDN = Zapatec.Calendar._SDN_len = Zapatec.Calendar._MN = Zapatec.Calendar._SMN = Zapatec.Calendar._SMN_len = null
