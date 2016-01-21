/* Croatian language file for the DHTML Calendar version 0.9.2 
* Author Krunoslav Zubrinic <krunoslav.zubrinic@vip.hr>, June 2003.
* Feel free to use this script under the terms of the GNU Lesser General
* Public License, as long as you do not remove or alter this notice.
*/
Zapatec.Calendar._DN = new Array
("Nedjelja",
 "Ponedjeljak",
 "Utorak",
 "Srijeda",
 "Četvrtak",
 "Petak",
 "Subota",
 "Nedjelja");
Zapatec.Calendar._MN = new Array
("Siječanj",
 "Veljača",
 "Ožujak",
 "Travanj",
 "Svibanj",
 "Lipanj",
 "Srpanj",
 "Kolovoz",
 "Rujan",
 "Listopad",
 "Studeni",
 "Prosinac");

// tooltips
Zapatec.Calendar._TT_hr = Zapatec.Calendar._TT = {};
Zapatec.Calendar._TT["TOGGLE"] = "Promjeni dan s kojim počinje tjedan";
Zapatec.Calendar._TT["PREV_YEAR"] = "Prethodna godina (dugi pritisak za meni)";
Zapatec.Calendar._TT["PREV_MONTH"] = "Prethodni mjesec (dugi pritisak za meni)";
Zapatec.Calendar._TT["GO_TODAY"] = "Idi na tekući dan";
Zapatec.Calendar._TT["NEXT_MONTH"] = "Slijedeći mjesec (dugi pritisak za meni)";
Zapatec.Calendar._TT["NEXT_YEAR"] = "Slijedeća godina (dugi pritisak za meni)";
Zapatec.Calendar._TT["SEL_DATE"] = "Izaberite datum";
Zapatec.Calendar._TT["DRAG_TO_MOVE"] = "Pritisni i povuci za promjenu pozicije";
Zapatec.Calendar._TT["PART_TODAY"] = " (today)";
Zapatec.Calendar._TT["MON_FIRST"] = "Prikaži ponedjeljak kao prvi dan";
Zapatec.Calendar._TT["SUN_FIRST"] = "Prikaži nedjelju kao prvi dan";
Zapatec.Calendar._TT["CLOSE"] = "Zatvori";
Zapatec.Calendar._TT["TODAY"] = "Danas";

// date formats
Zapatec.Calendar._TT["DEF_DATE_FORMAT"] = "dd-mm-y";
Zapatec.Calendar._TT["TT_DATE_FORMAT"] = "DD, dd.mm.y";

Zapatec.Calendar._TT["WK"] = "Tje";
/* Preserve data */
	if(Zapatec.Calendar._DN) Zapatec.Calendar._TT._DN = Zapatec.Calendar._DN;
	if(Zapatec.Calendar._SDN) Zapatec.Calendar._TT._SDN = Zapatec.Calendar._SDN;
	if(Zapatec.Calendar._SDN_len) Zapatec.Calendar._TT._SDN_len = Zapatec.Calendar._SDN_len;
	if(Zapatec.Calendar._MN) Zapatec.Calendar._TT._MN = Zapatec.Calendar._MN;
	if(Zapatec.Calendar._SMN) Zapatec.Calendar._TT._SMN = Zapatec.Calendar._SMN;
	if(Zapatec.Calendar._SMN_len) Zapatec.Calendar._TT._SMN_len = Zapatec.Calendar._SMN_len;
	Zapatec.Calendar._DN = Zapatec.Calendar._SDN = Zapatec.Calendar._SDN_len = Zapatec.Calendar._MN = Zapatec.Calendar._SMN = Zapatec.Calendar._SMN_len = null
