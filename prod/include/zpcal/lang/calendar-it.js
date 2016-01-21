// ** I18N

// Calendar EN language
// Author: Mihai Bazon, <mihai_bazon@yahoo.com>
// Translator: Fabio Di Bernardini, <altraqua@email.it>
// Encoding: any
// Distributed under the same terms as the calendar itself.

// For translators: please use UTF-8 if possible.  We strongly believe that
// Unicode is the answer to a real internationalized world.  Also please
// include your contact information in the header, as can be seen above.

// full day names
Zapatec.Calendar._DN = new Array
("Domenica",
 "Lunedì",
 "Martedì",
 "Mercoledì",
 "Giovedì",
 "Venerdì",
 "Sabato",
 "Domenica");

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
("Dom",
 "Lun",
 "Mar",
 "Mer",
 "Gio",
 "Ven",
 "Sab",
 "Dom");

// full month names
Zapatec.Calendar._MN = new Array
("Gennaio",
 "Febbraio",
 "Marzo",
 "Aprile",
 "Maggio",
 "Giugno",
 "Luglio",
 "Augosto",
 "Settembre",
 "Ottobre",
 "Novembre",
 "Dicembre");

// short month names
Zapatec.Calendar._SMN = new Array
("Gen",
 "Feb",
 "Mar",
 "Apr",
 "Mag",
 "Giu",
 "Lug",
 "Ago",
 "Set",
 "Ott",
 "Nov",
 "Dic");

// tooltips
Zapatec.Calendar._TT_it = Zapatec.Calendar._TT = {};
Zapatec.Calendar._TT["INFO"] = "Informazioni sul calendario";

Zapatec.Calendar._TT["ABOUT"] =
"DHTML Date/Time Selector\n" +
"(c) zapatec.com 2002-2004\n" + // don't translate this this ;-)
"Per gli aggiornamenti: http://www.zapatec.com\n" +
"This translation distributed under GNU LGPL.  See http://gnu.org/licenses/lgpl.html for details." +
"\n\n" +
"Selezione data:\n" +
"- Usa \xab, \xbb per selezionare l'anno\n" +
"- Usa  " + String.fromCharCode(0x2039) + ", " + String.fromCharCode(0x203a) + " per i mesi\n" +
"- Tieni premuto a lungo il mouse per accedere alle funzioni di selezione veloce.";
Zapatec.Calendar._TT["ABOUT_TIME"] = "\n\n" +
"Selezione orario:\n" +
"- Clicca sul numero per incrementarlo\n" +
"- o Shift+click per decrementarlo\n" +
"- o click e sinistra o destra per variarlo.";

Zapatec.Calendar._TT["PREV_YEAR"] = "Anno prec.(clicca a lungo per il menù)";
Zapatec.Calendar._TT["PREV_MONTH"] = "Mese prec. (clicca a lungo per il menù)";
Zapatec.Calendar._TT["GO_TODAY"] = "Oggi";
Zapatec.Calendar._TT["NEXT_MONTH"] = "Pross. mese (clicca a lungo per il menù)";
Zapatec.Calendar._TT["NEXT_YEAR"] = "Pross. anno (clicca a lungo per il menù)";
Zapatec.Calendar._TT["SEL_DATE"] = "Seleziona data";
Zapatec.Calendar._TT["DRAG_TO_MOVE"] = "Trascina per spostarlo";
Zapatec.Calendar._TT["PART_TODAY"] = " (oggi)";

// the following is to inform that "%s" is to be the first day of week
// %s will be replaced with the day name.
Zapatec.Calendar._TT["DAY_FIRST"] = "Mostra prima %s";

// This may be locale-dependent.  It specifies the week-end days, as an array
// of comma-separated numbers.  The numbers are from 0 to 6: 0 means Sunday, 1
// means Monday, etc.
Zapatec.Calendar._TT["WEEKEND"] = "0,6";

Zapatec.Calendar._TT["CLOSE"] = "Chiudi";
Zapatec.Calendar._TT["TODAY"] = "Oggi";
Zapatec.Calendar._TT["TIME_PART"] = "(Shift-)Click o trascina per cambiare il valore";

// date formats
Zapatec.Calendar._TT["DEF_DATE_FORMAT"] = "%d-%m-%Y";
Zapatec.Calendar._TT["TT_DATE_FORMAT"] = "%a:%b:%e";

Zapatec.Calendar._TT["WK"] = "set";
Zapatec.Calendar._TT["TIME"] = "Ora:";

/* Preserve data */
	if(Zapatec.Calendar._DN) Zapatec.Calendar._TT._DN = Zapatec.Calendar._DN;
	if(Zapatec.Calendar._SDN) Zapatec.Calendar._TT._SDN = Zapatec.Calendar._SDN;
	if(Zapatec.Calendar._SDN_len) Zapatec.Calendar._TT._SDN_len = Zapatec.Calendar._SDN_len;
	if(Zapatec.Calendar._MN) Zapatec.Calendar._TT._MN = Zapatec.Calendar._MN;
	if(Zapatec.Calendar._SMN) Zapatec.Calendar._TT._SMN = Zapatec.Calendar._SMN;
	if(Zapatec.Calendar._SMN_len) Zapatec.Calendar._TT._SMN_len = Zapatec.Calendar._SMN_len;
	Zapatec.Calendar._DN = Zapatec.Calendar._SDN = Zapatec.Calendar._SDN_len = Zapatec.Calendar._MN = Zapatec.Calendar._SMN = Zapatec.Calendar._SMN_len = null
