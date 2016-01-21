// Calendar ALBANIAN language
//author Rigels Gordani rige@hotmail.com

// ditet
Zapatec.Calendar._DN = new Array
("E Diele",
"E Hene",
"E Marte",
"E Merkure",
"E Enjte",
"E Premte",
"E Shtune",
"E Diele");

//ditet shkurt
Zapatec.Calendar._SDN = new Array
("Die",
"Hen",
"Mar",
"Mer",
"Enj",
"Pre",
"Sht",
"Die");

// muajt
Zapatec.Calendar._MN = new Array
("Janar",
"Shkurt",
"Mars",
"Prill",
"Maj",
"Qeshor",
"Korrik",
"Gusht",
"Shtator",
"Tetor",
"Nentor",
"Dhjetor");

// muajte shkurt
Zapatec.Calendar._SMN = new Array
("Jan",
"Shk",
"Mar",
"Pri",
"Maj",
"Qes",
"Kor",
"Gus",
"Sht",
"Tet",
"Nen",
"Dhj");

// ndihmesa
Zapatec.Calendar._TT_al = Zapatec.Calendar._TT = {};
Zapatec.Calendar._TT["INFO"] = "Per kalendarin";

Zapatec.Calendar._TT["ABOUT"] =
"Zgjedhes i ores/dates ne DHTML \n" +
"\n\n" +"Zgjedhja e Dates:\n" +
"- Perdor butonat \xab, \xbb per te zgjedhur vitin\n" +
"- Perdor  butonat" + String.fromCharCode(0x2039) + ", " + 
String.fromCharCode(0x203a) +
" per te  zgjedhur muajin\n" +
"- Mbani shtypur butonin e mousit per nje zgjedje me te shpejte.";
Zapatec.Calendar._TT["ABOUT_TIME"] = "\n\n" +
"Zgjedhja e kohes:\n" +
"- Kliko tek ndonje nga pjeset e ores per ta rritur ate\n" +
"- ose kliko me Shift per ta zvogeluar ate\n" +
"- ose cliko dhe terhiq per zgjedhje me te shpejte.";

Zapatec.Calendar._TT["PREV_YEAR"] = "Viti i shkuar (prit per menune)";
Zapatec.Calendar._TT["PREV_MONTH"] = "Muaji i shkuar (prit per menune)";
Zapatec.Calendar._TT["GO_TODAY"] = "Sot";
Zapatec.Calendar._TT["NEXT_MONTH"] = "Muaji i ardhshem (prit per menune)";
Zapatec.Calendar._TT["NEXT_YEAR"] = "Viti i ardhshem (prit per menune)";
Zapatec.Calendar._TT["SEL_DATE"] = "Zgjidh daten";
Zapatec.Calendar._TT["DRAG_TO_MOVE"] = "Terhiqe per te levizur";
Zapatec.Calendar._TT["PART_TODAY"] = " (sot)";

// "%s" eshte dita e pare e javes
// %s do te zevendesohet me emrin e dite
Zapatec.Calendar._TT["DAY_FIRST"] = "Trego te %s te paren";


Zapatec.Calendar._TT["WEEKEND"] = "0,6";

Zapatec.Calendar._TT["CLOSE"] = "Mbyll";
Zapatec.Calendar._TT["TODAY"] = "Sot";
Zapatec.Calendar._TT["TIME_PART"] = "Kliko me (Shift-)ose terhiqe per te ndryshuar vleren";

// date formats
Zapatec.Calendar._TT["DEF_DATE_FORMAT"] = "%Y-%m-%d";
Zapatec.Calendar._TT["TT_DATE_FORMAT"] = "%a, %b %e";

Zapatec.Calendar._TT["WK"] = "Java";
Zapatec.Calendar._TT["TIME"] = "Koha:";


/* Preserve data */
	if(Zapatec.Calendar._DN) Zapatec.Calendar._TT._DN = Zapatec.Calendar._DN;
	if(Zapatec.Calendar._SDN) Zapatec.Calendar._TT._SDN = Zapatec.Calendar._SDN;
	if(Zapatec.Calendar._SDN_len) Zapatec.Calendar._TT._SDN_len = Zapatec.Calendar._SDN_len;
	if(Zapatec.Calendar._MN) Zapatec.Calendar._TT._MN = Zapatec.Calendar._MN;
	if(Zapatec.Calendar._SMN) Zapatec.Calendar._TT._SMN = Zapatec.Calendar._SMN;
	if(Zapatec.Calendar._SMN_len) Zapatec.Calendar._TT._SMN_len = Zapatec.Calendar._SMN_len;
	Zapatec.Calendar._DN = Zapatec.Calendar._SDN = Zapatec.Calendar._SDN_len = Zapatec.Calendar._MN = Zapatec.Calendar._SMN = Zapatec.Calendar._SMN_len = null
