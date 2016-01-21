//////////////////////////////////////////////////////////////////////////////////////////////
//	Turkish Translation by Nuri AKMAN
//	Location: Ankara/TURKEY
//	e-mail	: nuriakman@hotmail.com
//	Date	: April, 9 2003
//
//	Note: if Turkish Characters does not shown on you screen
//		  please include falowing line your html code:
//
//		  <meta http-equiv="Content-Type" content="text/html; charset=windows-1254">
//
//////////////////////////////////////////////////////////////////////////////////////////////

// ** I18N
Zapatec.Calendar._DN = new Array
("Pazar",
 "Pazartesi",
 "Salı",
 "Çarşamba",
 "Perşembe",
 "Cuma",
 "Cumartesi",
 "Pazar");
Zapatec.Calendar._MN = new Array
("Ocak",
 "Şubat",
 "Mart",
 "Nisan",
 "Mayıs",
 "Haziran",
 "Temmuz",
 "Ağustos",
 "Eylül",
 "Ekim",
 "Kasım",
 "Aralık");

// tooltips
Zapatec.Calendar._TT_tr = Zapatec.Calendar._TT = {};
Zapatec.Calendar._TT["TOGGLE"] = "Haftanın ilk gününü kaydır";
Zapatec.Calendar._TT["PREV_YEAR"] = "Önceki Yıl (Menü için basılı tutunuz)";
Zapatec.Calendar._TT["PREV_MONTH"] = "Önceki Ay (Menü için basılı tutunuz)";
Zapatec.Calendar._TT["GO_TODAY"] = "Bugün'e git";
Zapatec.Calendar._TT["NEXT_MONTH"] = "Sonraki Ay (Menü için basılı tutunuz)";
Zapatec.Calendar._TT["NEXT_YEAR"] = "Sonraki Yıl (Menü için basılı tutunuz)";
Zapatec.Calendar._TT["SEL_DATE"] = "Tarih seçiniz";
Zapatec.Calendar._TT["DRAG_TO_MOVE"] = "Taşımak için sürükleyiniz";
Zapatec.Calendar._TT["PART_TODAY"] = " (bugün)";
Zapatec.Calendar._TT["MON_FIRST"] = "Takvim Pazartesi gününden başlasın";
Zapatec.Calendar._TT["SUN_FIRST"] = "Takvim Pazar gününden başlasın";
Zapatec.Calendar._TT["CLOSE"] = "Kapat";
Zapatec.Calendar._TT["TODAY"] = "Bugün";

// date formats
Zapatec.Calendar._TT["DEF_DATE_FORMAT"] = "dd-mm-y";
Zapatec.Calendar._TT["TT_DATE_FORMAT"] = "d MM y, DD";

Zapatec.Calendar._TT["WK"] = "Hafta";

/* Preserve data */
	if(Zapatec.Calendar._DN) Zapatec.Calendar._TT._DN = Zapatec.Calendar._DN;
	if(Zapatec.Calendar._SDN) Zapatec.Calendar._TT._SDN = Zapatec.Calendar._SDN;
	if(Zapatec.Calendar._SDN_len) Zapatec.Calendar._TT._SDN_len = Zapatec.Calendar._SDN_len;
	if(Zapatec.Calendar._MN) Zapatec.Calendar._TT._MN = Zapatec.Calendar._MN;
	if(Zapatec.Calendar._SMN) Zapatec.Calendar._TT._SMN = Zapatec.Calendar._SMN;
	if(Zapatec.Calendar._SMN_len) Zapatec.Calendar._TT._SMN_len = Zapatec.Calendar._SMN_len;
	Zapatec.Calendar._DN = Zapatec.Calendar._SDN = Zapatec.Calendar._SDN_len = Zapatec.Calendar._MN = Zapatec.Calendar._SMN = Zapatec.Calendar._SMN_len = null
