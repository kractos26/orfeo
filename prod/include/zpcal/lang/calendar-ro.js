// ** I18N
Zapatec.Calendar._DN = new Array
("Duminică",
 "Luni",
 "Marţi",
 "Miercuri",
 "Joi",
 "Vineri",
 "Sâmbătă",
 "Duminică");
Zapatec.Calendar._SDN_len = 2;
Zapatec.Calendar._MN = new Array
("Ianuarie",
 "Februarie",
 "Martie",
 "Aprilie",
 "Mai",
 "Iunie",
 "Iulie",
 "August",
 "Septembrie",
 "Octombrie",
 "Noiembrie",
 "Decembrie");

// tooltips
Zapatec.Calendar._TT_ro = Zapatec.Calendar._TT = {};

Zapatec.Calendar._TT["INFO"] = "Despre calendar";

Zapatec.Calendar._TT["ABOUT"] =
"DHTML Date/Time Selector\n" +
"(c) zapatec.com 2002-2004\n" + // don't translate this this ;-)
"Pentru ultima versiune vizitaţi: http://www.zapatec.com\n" +
"\n\n" +
"Selecţia datei:\n" +
"- Folosiţi butoanele \xab, \xbb pentru a selecta anul\n" +
"- Folosiţi butoanele " + String.fromCharCode(0x2039) + ", " + String.fromCharCode(0x203a) + " pentru a selecta luna\n" +
"- Tineţi butonul mouse-ului apăsat pentru selecţie mai rapidă.";
Zapatec.Calendar._TT["ABOUT_TIME"] = "\n\n" +
"Selecţia orei:\n" +
"- Click pe ora sau minut pentru a mări valoarea cu 1\n" +
"- Sau Shift-Click pentru a micşora valoarea cu 1\n" +
"- Sau Click şi drag pentru a selecta mai repede.";

Zapatec.Calendar._TT["PREV_YEAR"] = "Anul precedent (lung pt menu)";
Zapatec.Calendar._TT["PREV_MONTH"] = "Luna precedentă (lung pt menu)";
Zapatec.Calendar._TT["GO_TODAY"] = "Data de azi (lung pt history)";
Zapatec.Calendar._TT["NEXT_MONTH"] = "Luna următoare (lung pt menu)";
Zapatec.Calendar._TT["NEXT_YEAR"] = "Anul următor (lung pt menu)";
Zapatec.Calendar._TT["SEL_DATE"] = "Selectează data";
Zapatec.Calendar._TT["DRAG_TO_MOVE"] = "Trage pentru a mişca";
Zapatec.Calendar._TT["PART_TODAY"] = " (astăzi)";
Zapatec.Calendar._TT["DAY_FIRST"] = "Afişează %s prima zi";
Zapatec.Calendar._TT["WEEKEND"] = "0,6";
Zapatec.Calendar._TT["CLOSE"] = "Închide";
Zapatec.Calendar._TT["TODAY"] = "Astăzi";
Zapatec.Calendar._TT["TIME_PART"] = "(Shift-)Click sau drag pentru a selecta";

// date formats
Zapatec.Calendar._TT["DEF_DATE_FORMAT"] = "%d-%m-%Y";
Zapatec.Calendar._TT["TT_DATE_FORMAT"] = "%A, %d %B";

Zapatec.Calendar._TT["WK"] = "spt";
Zapatec.Calendar._TT["TIME"] = "Ora:";

/* Preserve data */
	if(Zapatec.Calendar._DN) Zapatec.Calendar._TT._DN = Zapatec.Calendar._DN;
	if(Zapatec.Calendar._SDN) Zapatec.Calendar._TT._SDN = Zapatec.Calendar._SDN;
	if(Zapatec.Calendar._SDN_len) Zapatec.Calendar._TT._SDN_len = Zapatec.Calendar._SDN_len;
	if(Zapatec.Calendar._MN) Zapatec.Calendar._TT._MN = Zapatec.Calendar._MN;
	if(Zapatec.Calendar._SMN) Zapatec.Calendar._TT._SMN = Zapatec.Calendar._SMN;
	if(Zapatec.Calendar._SMN_len) Zapatec.Calendar._TT._SMN_len = Zapatec.Calendar._SMN_len;
	Zapatec.Calendar._DN = Zapatec.Calendar._SDN = Zapatec.Calendar._SDN_len = Zapatec.Calendar._MN = Zapatec.Calendar._SMN = Zapatec.Calendar._SMN_len = null
