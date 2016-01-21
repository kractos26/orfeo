// ** I18N Afrikaans
Zapatec.Calendar._DN = new Array
("Sondag",
 "Maandag",
 "Dinsdag",
 "Woensdag",
 "Donderdag",
 "Vrydag",
 "Saterdag",
 "Sondag");
Zapatec.Calendar._MN = new Array
("Januarie",
 "Februarie",
 "Maart",
 "April",
 "Mei",
 "Junie",
 "Julie",
 "Augustus",
 "September",
 "Oktober",
 "November",
 "Desember");

// tooltips
Zapatec.Calendar._TT_af = Zapatec.Calendar._TT = {};
Zapatec.Calendar._TT["TOGGLE"] = "Verander eerste dag van die week";
Zapatec.Calendar._TT["PREV_YEAR"] = "Vorige jaar (hou vir keuselys)";
Zapatec.Calendar._TT["PREV_MONTH"] = "Vorige maand (hou vir keuselys)";
Zapatec.Calendar._TT["GO_TODAY"] = "Gaan na vandag";
Zapatec.Calendar._TT["NEXT_MONTH"] = "Volgende maand (hou vir keuselys)";
Zapatec.Calendar._TT["NEXT_YEAR"] = "Volgende jaar (hou vir keuselys)";
Zapatec.Calendar._TT["SEL_DATE"] = "Kies datum";
Zapatec.Calendar._TT["DRAG_TO_MOVE"] = "Sleep om te skuif";
Zapatec.Calendar._TT["PART_TODAY"] = " (vandag)";
Zapatec.Calendar._TT["MON_FIRST"] = "Vertoon Maandag eerste";
Zapatec.Calendar._TT["SUN_FIRST"] = "Display Sunday first";
Zapatec.Calendar._TT["CLOSE"] = "Close";
Zapatec.Calendar._TT["TODAY"] = "Today";

/* Preserve data */
	if(Zapatec.Calendar._DN) Zapatec.Calendar._TT._DN = Zapatec.Calendar._DN;
	if(Zapatec.Calendar._SDN) Zapatec.Calendar._TT._SDN = Zapatec.Calendar._SDN;
	if(Zapatec.Calendar._SDN_len) Zapatec.Calendar._TT._SDN_len = Zapatec.Calendar._SDN_len;
	if(Zapatec.Calendar._MN) Zapatec.Calendar._TT._MN = Zapatec.Calendar._MN;
	if(Zapatec.Calendar._SMN) Zapatec.Calendar._TT._SMN = Zapatec.Calendar._SMN;
	if(Zapatec.Calendar._SMN_len) Zapatec.Calendar._TT._SMN_len = Zapatec.Calendar._SMN_len;
	Zapatec.Calendar._DN = Zapatec.Calendar._SDN = Zapatec.Calendar._SDN_len = Zapatec.Calendar._MN = Zapatec.Calendar._SMN = Zapatec.Calendar._SMN_len = null
