// ** I18N
// Calendar PL language
// Author: Artur Filipiak, <imagen@poczta.fm>
// January, 2004
// Encoding: UTF-8
Zapatec.Calendar._DN = new Array
("Niedziela", "Poniedziałek", "Wtorek", "Środa", "Czwartek", "Piątek", "Sobota", "Niedziela");

Zapatec.Calendar._SDN = new Array
("N", "Pn", "Wt", "Śr", "Cz", "Pt", "So", "N");

Zapatec.Calendar._MN = new Array
("Styczeń", "Luty", "Marzec", "Kwiecień", "Maj", "Czerwiec", "Lipiec", "Sierpień", "Wrzesień", "Październik", "Listopad", "Grudzień");

Zapatec.Calendar._SMN = new Array
("Sty", "Lut", "Mar", "Kwi", "Maj", "Cze", "Lip", "Sie", "Wrz", "Paź", "Lis", "Gru");

// tooltips
Zapatec.Calendar._TT_pl = Zapatec.Calendar._TT = {};
Zapatec.Calendar._TT["INFO"] = "O kalendarzu";

Zapatec.Calendar._TT["ABOUT"] =
"DHTML Date/Time Selector\n" +
"(c) zapatec.com 2002-2004\n" + // don't translate this this ;-)
"For latest version visit: http://www.zapatec.com\n" +
"This translation distributed under GNU LGPL.  See http://gnu.org/licenses/lgpl.html for details." +
"\n\n" +
"Wybór daty:\n" +
"- aby wybrać rok użyj przycisków \xab, \xbb\n" +
"- aby wybrać miesiąc użyj przycisków " + String.fromCharCode(0x2039) + ", " + String.fromCharCode(0x203a) + "\n" +
"- aby przyspieszyć wybór przytrzymaj wciśnięty przycisk myszy nad ww. przyciskami.";
Zapatec.Calendar._TT["ABOUT_TIME"] = "\n\n" +
"Wybór czasu:\n" +
"- aby zwiększyć wartość kliknij na dowolnym elemencie selekcji czasu\n" +
"- aby zmniejszyć wartość użyj dodatkowo klawisza Shift\n" +
"- możesz również poruszać myszkę w lewo i prawo wraz z wciśniętym lewym klawiszem.";

Zapatec.Calendar._TT["PREV_YEAR"] = "Poprz. rok (przytrzymaj dla menu)";
Zapatec.Calendar._TT["PREV_MONTH"] = "Poprz. miesiąc (przytrzymaj dla menu)";
Zapatec.Calendar._TT["GO_TODAY"] = "Pokaż dziś";
Zapatec.Calendar._TT["NEXT_MONTH"] = "Nast. miesiąc (przytrzymaj dla menu)";
Zapatec.Calendar._TT["NEXT_YEAR"] = "Nast. rok (przytrzymaj dla menu)";
Zapatec.Calendar._TT["SEL_DATE"] = "Wybierz datę";
Zapatec.Calendar._TT["DRAG_TO_MOVE"] = "Przesuń okienko";
Zapatec.Calendar._TT["PART_TODAY"] = " (dziś)";
Zapatec.Calendar._TT["MON_FIRST"] = "Pokaż Poniedziałek jako pierwszy";
Zapatec.Calendar._TT["SUN_FIRST"] = "Pokaż Niedzielę jako pierwszą";
Zapatec.Calendar._TT["CLOSE"] = "Zamknij";
Zapatec.Calendar._TT["TODAY"] = "Dziś";
Zapatec.Calendar._TT["TIME_PART"] = "(Shift-)klik | drag, aby zmienić wartość";

// date formats
Zapatec.Calendar._TT["DEF_DATE_FORMAT"] = "%Y.%m.%d";
Zapatec.Calendar._TT["TT_DATE_FORMAT"] = "%a, %b %e";

Zapatec.Calendar._TT["WK"] = "wk";

/* Preserve data */
	if(Zapatec.Calendar._DN) Zapatec.Calendar._TT._DN = Zapatec.Calendar._DN;
	if(Zapatec.Calendar._SDN) Zapatec.Calendar._TT._SDN = Zapatec.Calendar._SDN;
	if(Zapatec.Calendar._SDN_len) Zapatec.Calendar._TT._SDN_len = Zapatec.Calendar._SDN_len;
	if(Zapatec.Calendar._MN) Zapatec.Calendar._TT._MN = Zapatec.Calendar._MN;
	if(Zapatec.Calendar._SMN) Zapatec.Calendar._TT._SMN = Zapatec.Calendar._SMN;
	if(Zapatec.Calendar._SMN_len) Zapatec.Calendar._TT._SMN_len = Zapatec.Calendar._SMN_len;
	Zapatec.Calendar._DN = Zapatec.Calendar._SDN = Zapatec.Calendar._SDN_len = Zapatec.Calendar._MN = Zapatec.Calendar._SMN = Zapatec.Calendar._SMN_len = null
