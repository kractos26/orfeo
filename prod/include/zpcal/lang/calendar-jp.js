// ** I18N
Zapatec.Calendar._DN = new Array
("日",
 "月",
 "火",
 "水",
 "木",
 "金",
 "土",
 "日");
Zapatec.Calendar._MN = new Array
("1月",
 "2月",
 "3月",
 "4月",
 "5月",
 "6月",
 "7月",
 "8月",
 "9月",
 "10月",
 "11月",
 "12月");

// tooltips
Zapatec.Calendar._TT_jp = Zapatec.Calendar._TT = {};
Zapatec.Calendar._TT["TOGGLE"] = "週の最初の曜日を切り替え";
Zapatec.Calendar._TT["PREV_YEAR"] = "前年";
Zapatec.Calendar._TT["PREV_MONTH"] = "前月";
Zapatec.Calendar._TT["GO_TODAY"] = "今日";
Zapatec.Calendar._TT["NEXT_MONTH"] = "翌月";
Zapatec.Calendar._TT["NEXT_YEAR"] = "翌年";
Zapatec.Calendar._TT["SEL_DATE"] = "日付選択";
Zapatec.Calendar._TT["DRAG_TO_MOVE"] = "ウィンドウの移動";
Zapatec.Calendar._TT["PART_TODAY"] = " (今日)";
Zapatec.Calendar._TT["MON_FIRST"] = "月曜日を先頭に";
Zapatec.Calendar._TT["SUN_FIRST"] = "日曜日を先頭に";
Zapatec.Calendar._TT["CLOSE"] = "閉じる";
Zapatec.Calendar._TT["TODAY"] = "今日";

// date formats
Zapatec.Calendar._TT["DEF_DATE_FORMAT"] = "y-mm-dd";
Zapatec.Calendar._TT["TT_DATE_FORMAT"] = "%m月 %d日 (%a)";

Zapatec.Calendar._TT["WK"] = "週";

/* Preserve data */
	if(Zapatec.Calendar._DN) Zapatec.Calendar._TT._DN = Zapatec.Calendar._DN;
	if(Zapatec.Calendar._SDN) Zapatec.Calendar._TT._SDN = Zapatec.Calendar._SDN;
	if(Zapatec.Calendar._SDN_len) Zapatec.Calendar._TT._SDN_len = Zapatec.Calendar._SDN_len;
	if(Zapatec.Calendar._MN) Zapatec.Calendar._TT._MN = Zapatec.Calendar._MN;
	if(Zapatec.Calendar._SMN) Zapatec.Calendar._TT._SMN = Zapatec.Calendar._SMN;
	if(Zapatec.Calendar._SMN_len) Zapatec.Calendar._TT._SMN_len = Zapatec.Calendar._SMN_len;
	Zapatec.Calendar._DN = Zapatec.Calendar._SDN = Zapatec.Calendar._SDN_len = Zapatec.Calendar._MN = Zapatec.Calendar._SMN = Zapatec.Calendar._SMN_len = null
