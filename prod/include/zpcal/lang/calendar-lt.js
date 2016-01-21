// ** I18N

// Calendar LT language
// Author: Martynas Majeris, <martynas@solmetra.lt>
// Encoding: Windows-1257
// Distributed under the same terms as the calendar itself.

// For translators: please use UTF-8 if possible.  We strongly believe that
// Unicode is the answer to a real internationalized world.  Also please
// include your contact information in the header, as can be seen above.

// full day names
Zapatec.Calendar._DN = new Array
("Sekmadienis",
 "Pirmadienis",
 "Antradienis",
 "Treèiadienis",
 "Ketvirtadienis",
 "Pentadienis",
 "Ðeðtadienis",
 "Sekmadienis");

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
("Sek",
 "Pir",
 "Ant",
 "Tre",
 "Ket",
 "Pen",
 "Ðeð",
 "Sek");

// full month names
Zapatec.Calendar._MN = new Array
("Sausis",
 "Vasaris",
 "Kovas",
 "Balandis",
 "Geguþë",
 "Birþelis",
 "Liepa",
 "Rugpjûtis",
 "Rugsëjis",
 "Spalis",
 "Lapkritis",
 "Gruodis");

// short month names
Zapatec.Calendar._SMN = new Array
("Sau",
 "Vas",
 "Kov",
 "Bal",
 "Geg",
 "Bir",
 "Lie",
 "Rgp",
 "Rgs",
 "Spa",
 "Lap",
 "Gru");

// tooltips
Zapatec.Calendar._TT_lt = Zapatec.Calendar._TT = {};
Zapatec.Calendar._TT["INFO"] = "Apie kalendoriø";

Zapatec.Calendar._TT["ABOUT"] =
"DHTML Date/Time Selector\n" +
"(c) zapatec.com 2002-2004\n" + // don't translate this this ;-)
"Naujausià versijà rasite: http://www.zapatec.com\n" +
"This translation distributed under GNU LGPL.  See http://gnu.org/licenses/lgpl.html for details." +
"\n\n" +
"Datos pasirinkimas:\n" +
"- Metø pasirinkimas: \xab, \xbb\n" +
"- Mënesio pasirinkimas: " + String.fromCharCode(0x2039) + ", " + String.fromCharCode(0x203a) + "\n" +
"- Nuspauskite ir laikykite pelës klaviðà greitesniam pasirinkimui.";
Zapatec.Calendar._TT["ABOUT_TIME"] = "\n\n" +
"Laiko pasirinkimas:\n" +
"- Spustelkite ant valandø arba minuèiø - skaièus padidës vienetu.\n" +
"- Jei spausite kartu su Shift, skaièius sumaþës.\n" +
"- Greitam pasirinkimui spustelkite ir pajudinkite pelæ.";

Zapatec.Calendar._TT["PREV_YEAR"] = "Ankstesni metai (laikykite, jei norite meniu)";
Zapatec.Calendar._TT["PREV_MONTH"] = "Ankstesnis mënuo (laikykite, jei norite meniu)";
Zapatec.Calendar._TT["GO_TODAY"] = "Pasirinkti ðiandienà";
Zapatec.Calendar._TT["NEXT_MONTH"] = "Kitas mënuo (laikykite, jei norite meniu)";
Zapatec.Calendar._TT["NEXT_YEAR"] = "Kiti metai (laikykite, jei norite meniu)";
Zapatec.Calendar._TT["SEL_DATE"] = "Pasirinkite datà";
Zapatec.Calendar._TT["DRAG_TO_MOVE"] = "Tempkite";
Zapatec.Calendar._TT["PART_TODAY"] = " (ðiandien)";
Zapatec.Calendar._TT["MON_FIRST"] = "Pirma savaitës diena - pirmadienis";
Zapatec.Calendar._TT["SUN_FIRST"] = "Pirma savaitës diena - sekmadienis";
Zapatec.Calendar._TT["CLOSE"] = "Uþdaryti";
Zapatec.Calendar._TT["TODAY"] = "Ðiandien";
Zapatec.Calendar._TT["TIME_PART"] = "Spustelkite arba tempkite jei norite pakeisti";

// date formats
Zapatec.Calendar._TT["DEF_DATE_FORMAT"] = "%Y-%m-%d";
Zapatec.Calendar._TT["TT_DATE_FORMAT"] = "%A, %Y-%m-%d";

Zapatec.Calendar._TT["WK"] = "sav";

/* Preserve data */
	if(Zapatec.Calendar._DN) Zapatec.Calendar._TT._DN = Zapatec.Calendar._DN;
	if(Zapatec.Calendar._SDN) Zapatec.Calendar._TT._SDN = Zapatec.Calendar._SDN;
	if(Zapatec.Calendar._SDN_len) Zapatec.Calendar._TT._SDN_len = Zapatec.Calendar._SDN_len;
	if(Zapatec.Calendar._MN) Zapatec.Calendar._TT._MN = Zapatec.Calendar._MN;
	if(Zapatec.Calendar._SMN) Zapatec.Calendar._TT._SMN = Zapatec.Calendar._SMN;
	if(Zapatec.Calendar._SMN_len) Zapatec.Calendar._TT._SMN_len = Zapatec.Calendar._SMN_len;
	Zapatec.Calendar._DN = Zapatec.Calendar._SDN = Zapatec.Calendar._SDN_len = Zapatec.Calendar._MN = Zapatec.Calendar._SMN = Zapatec.Calendar._SMN_len = null
