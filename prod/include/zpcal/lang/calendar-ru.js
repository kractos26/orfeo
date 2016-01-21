// ** I18N

// Calendar RU language
// Translation: Sly Golovanov, http://golovanov.net, <sly@golovanov.net>
// Encoding: any
// Distributed under the same terms as the calendar itself.

// For translators: please use UTF-8 if possible.  We strongly believe that
// Unicode is the answer to a real internationalized world.  Also please
// include your contact information in the header, as can be seen above.

// full day names
Zapatec.Calendar._DN = new Array
("воскресенье",
 "понедельник",
 "вторник",
 "среда",
 "четверг",
 "пятница",
 "суббота",
 "воскресенье");

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
("вск",
 "пон",
 "втр",
 "срд",
 "чет",
 "пят",
 "суб",
 "вск");

// full month names
Zapatec.Calendar._MN = new Array
("январь",
 "февраль",
 "март",
 "апрель",
 "май",
 "июнь",
 "июль",
 "август",
 "сентябрь",
 "октябрь",
 "ноябрь",
 "декабрь");

// short month names
Zapatec.Calendar._SMN = new Array
("янв",
 "фев",
 "мар",
 "апр",
 "май",
 "июн",
 "июл",
 "авг",
 "сен",
 "окт",
 "ноя",
 "дек");

// tooltips
Zapatec.Calendar._TT_ru = Zapatec.Calendar._TT = {};
Zapatec.Calendar._TT["INFO"] = "О календаре...";

Zapatec.Calendar._TT["ABOUT"] =
"DHTML Date/Time Selector\n" +
"(c) zapatec.com 2002-2004\n" + // don't translate this this ;-)
"For latest version visit: http://www.zapatec.com\n" +
"This translation distributed under GNU LGPL.  See http://gnu.org/licenses/lgpl.html for details." +
"\n\n" +
"Как выбрать дату:\n" +
"- При помощи кнопок \xab, \xbb можно выбрать год\n" +
"- При помощи кнопок " + String.fromCharCode(0x2039) + ", " + String.fromCharCode(0x203a) + " можно выбрать месяц\n" +
"- Подержите эти кнопки нажатыми, чтобы появилось меню быстрого выбора.";
Zapatec.Calendar._TT["ABOUT_TIME"] = "\n\n" +
"Как выбрать время:\n" +
"- При клике на часах или минутах они увеличиваются\n" +
"- при клике с нажатой клавишей Shift они уменьшаются\n" +
"- если нажать и двигать мышкой влево/вправо, они будут меняться быстрее.";

Zapatec.Calendar._TT["PREV_YEAR"] = "На год назад (удерживать для меню)";
Zapatec.Calendar._TT["PREV_MONTH"] = "На месяц назад (удерживать для меню)";
Zapatec.Calendar._TT["GO_TODAY"] = "Сегодня";
Zapatec.Calendar._TT["NEXT_MONTH"] = "На месяц вперед (удерживать для меню)";
Zapatec.Calendar._TT["NEXT_YEAR"] = "На год вперед (удерживать для меню)";
Zapatec.Calendar._TT["SEL_DATE"] = "Выберите дату";
Zapatec.Calendar._TT["DRAG_TO_MOVE"] = "Перетаскивайте мышкой";
Zapatec.Calendar._TT["PART_TODAY"] = " (сегодня)";

// the following is to inform that "%s" is to be the first day of week
// %s will be replaced with the day name.
Zapatec.Calendar._TT["DAY_FIRST"] = "Первый день недели будет %s";

// This may be locale-dependent.  It specifies the week-end days, as an array
// of comma-separated numbers.  The numbers are from 0 to 6: 0 means Sunday, 1
// means Monday, etc.
Zapatec.Calendar._TT["WEEKEND"] = "0,6";

Zapatec.Calendar._TT["CLOSE"] = "Закрыть";
Zapatec.Calendar._TT["TODAY"] = "Сегодня";
Zapatec.Calendar._TT["TIME_PART"] = "(Shift-)клик или нажать и двигать";

// date formats
Zapatec.Calendar._TT["DEF_DATE_FORMAT"] = "%Y-%m-%d";
Zapatec.Calendar._TT["TT_DATE_FORMAT"] = "%e %b, %a";

Zapatec.Calendar._TT["WK"] = "нед";
Zapatec.Calendar._TT["TIME"] = "Время:";

/* Preserve data */
	if(Zapatec.Calendar._DN) Zapatec.Calendar._TT._DN = Zapatec.Calendar._DN;
	if(Zapatec.Calendar._SDN) Zapatec.Calendar._TT._SDN = Zapatec.Calendar._SDN;
	if(Zapatec.Calendar._SDN_len) Zapatec.Calendar._TT._SDN_len = Zapatec.Calendar._SDN_len;
	if(Zapatec.Calendar._MN) Zapatec.Calendar._TT._MN = Zapatec.Calendar._MN;
	if(Zapatec.Calendar._SMN) Zapatec.Calendar._TT._SMN = Zapatec.Calendar._SMN;
	if(Zapatec.Calendar._SMN_len) Zapatec.Calendar._TT._SMN_len = Zapatec.Calendar._SMN_len;
	Zapatec.Calendar._DN = Zapatec.Calendar._SDN = Zapatec.Calendar._SDN_len = Zapatec.Calendar._MN = Zapatec.Calendar._SMN = Zapatec.Calendar._SMN_len = null
