// ** I18N

// Calendar EN language
// Author: Mihai Bazon, <mihai_bazon@yahoo.com>
// Translation: Yourim Yi <yyi@yourim.net>
// Encoding: EUC-KR
// lang : ko
// Distributed under the same terms as the calendar itself.

// For translators: please use UTF-8 if possible.  We strongly believe that
// Unicode is the answer to a real internationalized world.  Also please
// include your contact information in the header, as can be seen above.

// full day names

Zapatec.Calendar._DN = new Array
("일요일",
 "월요일",
 "화요일",
 "수요일",
 "목요일",
 "금요일",
 "토요일",
 "일요일");

// Please note that the following array of short day names (and the same goes
// for short month names, _SMN) isn't absolutely necessary.  We give it here
// for exemplification on how one can customize the short day names, but if
// they are simply the first N letters of the full name you can simply say:
//
//   Zapatec.Calendar._SDN_len = N; // short day name length
//   Zapatec.Calendar._SMN_len = N; // short month name length
//
// If N = 3 then this is not needed either since we assume a value of 3 if not
// present, to be compatible with translation files that were written before
// this feature.

// short day names
Zapatec.Calendar._SDN = new Array
("일",
 "월",
 "화",
 "수",
 "목",
 "금",
 "토",
 "일");

// full month names
Zapatec.Calendar._MN = new Array
("1월",
 "2월",
 "3월",
 "4월",
 "5월",
 "6월",
 "7월",
 "8월",
 "9월",
 "10월",
 "11월",
 "12월");

// short month names
Zapatec.Calendar._SMN = new Array
("1",
 "2",
 "3",
 "4",
 "5",
 "6",
 "7",
 "8",
 "9",
 "10",
 "11",
 "12");

// tooltips
Zapatec.Calendar._TT_ko = Zapatec.Calendar._TT = {};
Zapatec.Calendar._TT["INFO"] = "calendar 에 대해서";

Zapatec.Calendar._TT["ABOUT"] =
"DHTML Date/Time Selector\n" +
"(c) zapatec.com 2002-2004\n" + // don't translate this this ;-)
"\n"+
"최신 버전을 받으시려면 http://www.zapatec.com\n" +
"\n"+
"This translation distributed under GNU LGPL.  See http://gnu.org/licenses/lgpl.html for details." +
"\n\n" +
"날짜 선택:\n" +
"- 연도를 선택하려면 \xab, \xbb 버튼을 사용합니다\n" +
"- 달을 선택하려면 " + String.fromCharCode(0x2039) + ", " + String.fromCharCode(0x203a) + " 버튼을 누르세요\n" +
"- 계속 누르고 있으면 위 값들을 빠르게 선택하실 수 있습니다.";
Zapatec.Calendar._TT["ABOUT_TIME"] = "\n\n" +
"시간 선택:\n" +
"- 마우스로 누르면 시간이 증가합니다\n" +
"- Shift 키와 함께 누르면 감소합니다\n" +
"- 누른 상태에서 마우스를 움직이면 좀 더 빠르게 값이 변합니다.\n";

Zapatec.Calendar._TT["PREV_YEAR"] = "지난 해 (길게 누르면 목록)";
Zapatec.Calendar._TT["PREV_MONTH"] = "지난 달 (길게 누르면 목록)";
Zapatec.Calendar._TT["GO_TODAY"] = "오늘 날짜로";
Zapatec.Calendar._TT["NEXT_MONTH"] = "다음 달 (길게 누르면 목록)";
Zapatec.Calendar._TT["NEXT_YEAR"] = "다음 해 (길게 누르면 목록)";
Zapatec.Calendar._TT["SEL_DATE"] = "날짜를 선택하세요";
Zapatec.Calendar._TT["DRAG_TO_MOVE"] = "마우스 드래그로 이동 하세요";
Zapatec.Calendar._TT["PART_TODAY"] = " (오늘)";
Zapatec.Calendar._TT["MON_FIRST"] = "월요일을 한 주의 시작 요일로";
Zapatec.Calendar._TT["SUN_FIRST"] = "일요일을 한 주의 시작 요일로";
Zapatec.Calendar._TT["CLOSE"] = "닫기";
Zapatec.Calendar._TT["TODAY"] = "오늘";
Zapatec.Calendar._TT["TIME_PART"] = "(Shift-)클릭 또는 드래그 하세요";

// date formats
Zapatec.Calendar._TT["DEF_DATE_FORMAT"] = "%Y-%m-%d";
Zapatec.Calendar._TT["TT_DATE_FORMAT"] = "%b/%e [%a]";

Zapatec.Calendar._TT["WK"] = "주";

/* Preserve data */
	if(Zapatec.Calendar._DN) Zapatec.Calendar._TT._DN = Zapatec.Calendar._DN;
	if(Zapatec.Calendar._SDN) Zapatec.Calendar._TT._SDN = Zapatec.Calendar._SDN;
	if(Zapatec.Calendar._SDN_len) Zapatec.Calendar._TT._SDN_len = Zapatec.Calendar._SDN_len;
	if(Zapatec.Calendar._MN) Zapatec.Calendar._TT._MN = Zapatec.Calendar._MN;
	if(Zapatec.Calendar._SMN) Zapatec.Calendar._TT._SMN = Zapatec.Calendar._SMN;
	if(Zapatec.Calendar._SMN_len) Zapatec.Calendar._TT._SMN_len = Zapatec.Calendar._SMN_len;
	Zapatec.Calendar._DN = Zapatec.Calendar._SDN = Zapatec.Calendar._SDN_len = Zapatec.Calendar._MN = Zapatec.Calendar._SMN = Zapatec.Calendar._SMN_len = null
