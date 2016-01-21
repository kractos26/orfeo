// ** I18N

// Calendar PL language
// Author: Dariusz Pietrzak, <eyck@ghost.anime.pl>
// Author: Janusz Piwowarski, <jpiw@go2.pl>
// Encoding: utf-8
// Distributed under the same terms as the calendar itself.

Zapatec.Calendar._DN = new Array
("Niedziela",
 "Poniedziałek",
 "Wtorek",
 "Środa",
 "Czwartek",
 "Piątek",
 "Sobota",
 "Niedziela");
Zapatec.Calendar._SDN = new Array
("Nie",
 "Pn",
 "Wt",
 "Śr",
 "Cz",
 "Pt",
 "So",
 "Nie");
Zapatec.Calendar._MN = new Array
("Styczeń",
 "Luty",
 "Marzec",
 "Kwiecień",
 "Maj",
 "Czerwiec",
 "Lipiec",
 "Sierpień",
 "Wrzesień",
 "Październik",
 "Listopad",
 "Grudzień");
Zapatec.Calendar._SMN = new Array
("Sty",
 "Lut",
 "Mar",
 "Kwi",
 "Maj",
 "Cze",
 "Lip",
 "Sie",
 "Wrz",
 "Paź",
 "Lis",
 "Gru");

// tooltips
Zapatec.Calendar._TT_pl = Zapatec.Calendar._TT = {};
Zapatec.Calendar._TT["INFO"] = "O kalendarzu";

Zapatec.Calendar._TT["ABOUT"] =
"DHTML Date/Time Selector\n" +
"(c) zapatec.com 2002-2004\n" + // don't translate this this ;-)
"Aby pobrać najnowszą wersję, odwiedź: http://www.zapatec.com\n" +
"This translation distributed under GNU LGPL.  See http://gnu.org/licenses/lgpl.html for details." +
"\n\n" +
"Wybór daty:\n" +
"- Użyj przycisków \xab, \xbb by wybrać rok\n" +
"- Użyj przycisków " + String.fromCharCode(0x2039) + ", " + String.fromCharCode(0x203a) + " by wybrać miesiąc\n" +
"- Przytrzymaj klawisz myszy nad jednym z powyższych przycisków dla szybszego wyboru.";
Zapatec.Calendar._TT["ABOUT_TIME"] = "\n\n" +
"Wybór czasu:\n" +
"- Kliknij na jednym z pól czasu by zwiększyć jego wartość\n" +
"- lub kliknij trzymając Shift by zmiejszyć jego wartość\n" +
"- lub kliknij i przeciągnij dla szybszego wyboru.";

//Zapatec.Calendar._TT["TOGGLE"] = "Zmień pierwszy dzień tygodnia";
Zapatec.Calendar._TT["PREV_YEAR"] = "Poprzedni rok (przytrzymaj dla menu)";
Zapatec.Calendar._TT["PREV_MONTH"] = "Poprzedni miesiąc (przytrzymaj dla menu)";
Zapatec.Calendar._TT["GO_TODAY"] = "Idź do dzisiaj";
Zapatec.Calendar._TT["NEXT_MONTH"] = "Następny miesiąc (przytrzymaj dla menu)";
Zapatec.Calendar._TT["NEXT_YEAR"] = "Następny rok (przytrzymaj dla menu)";
Zapatec.Calendar._TT["SEL_DATE"] = "Wybierz datę";
Zapatec.Calendar._TT["DRAG_TO_MOVE"] = "Przeciągnij by przesunąć";
Zapatec.Calendar._TT["PART_TODAY"] = " (dzisiaj)";
Zapatec.Calendar._TT["MON_FIRST"] = "Wyświetl poniedziałek jako pierwszy";
Zapatec.Calendar._TT["SUN_FIRST"] = "Wyświetl niedzielę jako pierwszą";
Zapatec.Calendar._TT["CLOSE"] = "Zamknij";
Zapatec.Calendar._TT["TODAY"] = "Dzisiaj";
Zapatec.Calendar._TT["TIME_PART"] = "(Shift-)Kliknij lub przeciągnij by zmienić wartość";

// date formats
Zapatec.Calendar._TT["DEF_DATE_FORMAT"] = "%Y-%m-%d";
Zapatec.Calendar._TT["TT_DATE_FORMAT"] = "%e %B, %A";

Zapatec.Calendar._TT["WK"] = "ty";

/* Preserve data */
	if(Zapatec.Calendar._DN) Zapatec.Calendar._TT._DN = Zapatec.Calendar._DN;
	if(Zapatec.Calendar._SDN) Zapatec.Calendar._TT._SDN = Zapatec.Calendar._SDN;
	if(Zapatec.Calendar._SDN_len) Zapatec.Calendar._TT._SDN_len = Zapatec.Calendar._SDN_len;
	if(Zapatec.Calendar._MN) Zapatec.Calendar._TT._MN = Zapatec.Calendar._MN;
	if(Zapatec.Calendar._SMN) Zapatec.Calendar._TT._SMN = Zapatec.Calendar._SMN;
	if(Zapatec.Calendar._SMN_len) Zapatec.Calendar._TT._SMN_len = Zapatec.Calendar._SMN_len;
	Zapatec.Calendar._DN = Zapatec.Calendar._SDN = Zapatec.Calendar._SDN_len = Zapatec.Calendar._MN = Zapatec.Calendar._SMN = Zapatec.Calendar._SMN_len = null
