// ** I18N
Zapatec.Calendar._DN = new Array
("Κυριακή",
 "Δευτέρα",
 "Τρίτη",
 "Τετάρτη",
 "Πέμπτη",
 "Παρασκευή",
 "Σάββατο",
 "Κυριακή");

Zapatec.Calendar._SDN = new Array
("Κυ",
 "Δε",
 "Tρ",
 "Τε",
 "Πε",
 "Πα",
 "Σα",
 "Κυ");

Zapatec.Calendar._MN = new Array
("Ιανουάριος",
 "Φεβρουάριος",
 "Μάρτιος",
 "Απρίλιος",
 "Μάϊος",
 "Ιούνιος",
 "Ιούλιος",
 "Αύγουστος",
 "Σεπτέμβριος",
 "Οκτώβριος",
 "Νοέμβριος",
 "Δεκέμβριος");

Zapatec.Calendar._SMN = new Array
("Ιαν",
 "Φεβ",
 "Μαρ",
 "Απρ",
 "Μαι",
 "Ιουν",
 "Ιουλ",
 "Αυγ",
 "Σεπ",
 "Οκτ",
 "Νοε",
 "Δεκ");

// tooltips
Zapatec.Calendar._TT_el = Zapatec.Calendar._TT = {};
Zapatec.Calendar._TT["INFO"] = "Για το ημερολόγιο";

Zapatec.Calendar._TT["ABOUT"] =
"Επιλογέας ημερομηνίας/ώρας σε DHTML\n" +
"(c) zapatec.com 2002-2004\n" + // don't translate this this ;-)
"Για τελευταία έκδοση: http://www.zapatec.com\n" +
"This translation distributed under GNU LGPL.  See http://gnu.org/licenses/lgpl.html for details." +
"\n\n" +
"Επιλογή ημερομηνίας:\n" +
"- Χρησιμοποιείστε τα κουμπιά \xab, \xbb για επιλογή έτους\n" +
"- Χρησιμοποιείστε τα κουμπιά " + String.fromCharCode(0x2039) + ", " + String.fromCharCode(0x203a) + " για επιλογή μήνα\n" +
"- Κρατήστε κουμπί ποντικού πατημένο στα παραπάνω κουμπιά για πιο γρήγορη επιλογή.";
Zapatec.Calendar._TT["ABOUT_TIME"] = "\n\n" +
"Επιλογή ώρας:\n" +
"- Κάντε κλικ σε ένα από τα μέρη της ώρας για αύξηση\n" +
"- ή Shift-κλικ για μείωση\n" +
"- ή κλικ και μετακίνηση για πιο γρήγορη επιλογή.";
Zapatec.Calendar._TT["TOGGLE"] = "Μπάρα πρώτης ημέρας της εβδομάδας";
Zapatec.Calendar._TT["PREV_YEAR"] = "Προηγ. έτος (κρατήστε για το μενού)";
Zapatec.Calendar._TT["PREV_MONTH"] = "Προηγ. μήνας (κρατήστε για το μενού)";
Zapatec.Calendar._TT["GO_TODAY"] = "Σήμερα";
Zapatec.Calendar._TT["NEXT_MONTH"] = "Επόμενος μήνας (κρατήστε για το μενού)";
Zapatec.Calendar._TT["NEXT_YEAR"] = "Επόμενο έτος (κρατήστε για το μενού)";
Zapatec.Calendar._TT["SEL_DATE"] = "Επιλέξτε ημερομηνία";
Zapatec.Calendar._TT["DRAG_TO_MOVE"] = "Σύρτε για να μετακινήσετε";
Zapatec.Calendar._TT["PART_TODAY"] = " (σήμερα)";
Zapatec.Calendar._TT["MON_FIRST"] = "Εμφάνιση Δευτέρας πρώτα";
Zapatec.Calendar._TT["SUN_FIRST"] = "Εμφάνιση Κυριακής πρώτα";
Zapatec.Calendar._TT["CLOSE"] = "Κλείσιμο";
Zapatec.Calendar._TT["TODAY"] = "Σήμερα";
Zapatec.Calendar._TT["TIME_PART"] = "(Shift-)κλικ ή μετακίνηση για αλλαγή";

// date formats
Zapatec.Calendar._TT["DEF_DATE_FORMAT"] = "dd-mm-y";
Zapatec.Calendar._TT["TT_DATE_FORMAT"] = "D, d M";

Zapatec.Calendar._TT["WK"] = "εβδ";


/* Preserve data */
	if(Zapatec.Calendar._DN) Zapatec.Calendar._TT._DN = Zapatec.Calendar._DN;
	if(Zapatec.Calendar._SDN) Zapatec.Calendar._TT._SDN = Zapatec.Calendar._SDN;
	if(Zapatec.Calendar._SDN_len) Zapatec.Calendar._TT._SDN_len = Zapatec.Calendar._SDN_len;
	if(Zapatec.Calendar._MN) Zapatec.Calendar._TT._MN = Zapatec.Calendar._MN;
	if(Zapatec.Calendar._SMN) Zapatec.Calendar._TT._SMN = Zapatec.Calendar._SMN;
	if(Zapatec.Calendar._SMN_len) Zapatec.Calendar._TT._SMN_len = Zapatec.Calendar._SMN_len;
	Zapatec.Calendar._DN = Zapatec.Calendar._SDN = Zapatec.Calendar._SDN_len = Zapatec.Calendar._MN = Zapatec.Calendar._SMN = Zapatec.Calendar._SMN_len = null
