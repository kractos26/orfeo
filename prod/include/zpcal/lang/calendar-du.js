// ** I18N
Zapatec.Calendar._DN = new Array
("Zondag",
 "Maandag",
 "Dinsdag",
 "Woensdag",
 "Donderdag",
 "Vrijdag",
 "Zaterdag",
 "Zondag");
Zapatec.Calendar._MN = new Array
("Januari",
 "Februari",
 "Maart",
 "April",
 "Mei",
 "Juni",
 "Juli",
 "Augustus",
 "September",
 "Oktober",
 "November",
 "December");

// tooltips
Zapatec.Calendar._TT_du = Zapatec.Calendar._TT = {};
Zapatec.Calendar._TT["TOGGLE"] = "Toggle startdag van de week";
Zapatec.Calendar._TT["PREV_YEAR"] = "Vorig jaar (indrukken voor menu)";
Zapatec.Calendar._TT["PREV_MONTH"] = "Vorige month (indrukken voor menu)";
Zapatec.Calendar._TT["GO_TODAY"] = "Naar Vandaag";
Zapatec.Calendar._TT["NEXT_MONTH"] = "Volgende Maand (indrukken voor menu)";
Zapatec.Calendar._TT["NEXT_YEAR"] = "Volgend jaar (indrukken voor menu)";
Zapatec.Calendar._TT["SEL_DATE"] = "Selecteer datum";
Zapatec.Calendar._TT["DRAG_TO_MOVE"] = "Sleep om te verplaatsen";
Zapatec.Calendar._TT["PART_TODAY"] = " (vandaag)";
Zapatec.Calendar._TT["MON_FIRST"] = "Toon Maandag eerst";
Zapatec.Calendar._TT["SUN_FIRST"] = "Toon Zondag eerst";
Zapatec.Calendar._TT["CLOSE"] = "Sluiten";
Zapatec.Calendar._TT["TODAY"] = "Vandaag";

// date formats
Zapatec.Calendar._TT["DEF_DATE_FORMAT"] = "y-mm-dd";
Zapatec.Calendar._TT["TT_DATE_FORMAT"] = "D, M d";

Zapatec.Calendar._TT["WK"] = "wk";

/* Preserve data */
	if(Zapatec.Calendar._DN) Zapatec.Calendar._TT._DN = Zapatec.Calendar._DN;
	if(Zapatec.Calendar._SDN) Zapatec.Calendar._TT._SDN = Zapatec.Calendar._SDN;
	if(Zapatec.Calendar._SDN_len) Zapatec.Calendar._TT._SDN_len = Zapatec.Calendar._SDN_len;
	if(Zapatec.Calendar._MN) Zapatec.Calendar._TT._MN = Zapatec.Calendar._MN;
	if(Zapatec.Calendar._SMN) Zapatec.Calendar._TT._SMN = Zapatec.Calendar._SMN;
	if(Zapatec.Calendar._SMN_len) Zapatec.Calendar._TT._SMN_len = Zapatec.Calendar._SMN_len;
	Zapatec.Calendar._DN = Zapatec.Calendar._SDN = Zapatec.Calendar._SDN_len = Zapatec.Calendar._MN = Zapatec.Calendar._SMN = Zapatec.Calendar._SMN_len = null
