/*
 * The Zapatec DHTML Calendar
 *
 * Copyright (c) 2004 by Zapatec, Inc.
 * http://www.zapatec.com
 * 1700 MLK Way, Berkeley, California,
 * 94709, U.S.A.
 * All rights reserved.
 *
 *
 * The Calendar Wizard. Collects preferences from the
 * user, creates a calendar, and generates the code.
 */


var utils = Zapatec.Utils;
var format_activeField = null;
var a_tabs = [];
var flat_calendar;
var wizard_address = document.URL;
var factory_formats = [ "%A, %B %d, %Y",
			"%a, %b %d, %Y",
			"%B %Y",
			"Day %j of year %Y (week %W)",
			"%Y/%m/%d",
			"%Y/%m/%d %I:%M %P",
			"%d-%m-%Y %H:%M"
];
function initWizard() {
	var i = 0, el;
	while (el = document.getElementById("tooltip-" + ++i))
		utils.addTooltip(el, "tooltip-" + i + "-text");
	initTabs();
	setSize('');
	format_activeField = document.getElementById("f_prop_ifFormat");

// 	var tables = document.getElementsByTagName("table"), i = 0, t;
// 	while (t = tables[i++]) {
// 		if (/form/i.test(t.className)) {
// 			var trs = t.getElementsByTagName("tr");
// 			for (var j = trs.length; --j >= 0;)
// 				addHoverEvents(trs[j]);
// 		}
// 	}

// 	var slashLoc = wizard_address.lastIndexOf('/');
// 	var dotLoc = wizard_address.lastIndexOf('.');
// 	if (dotLoc > slashLoc) {
// 		wizard_address = wizard_address.substr(0, slashLoc);
// 	}

	wizard_address = wizard_address.replace(/\/wizard\/.*/, '/');
	wizard_address = wizard_address.replace(/^https?:\/\/[^\/]+/, '');

	document.getElementById('f_path').value = wizard_address;

	flat_calendar = new Zapatec.Calendar(1, new Date(),
				     function(cal) { window.status = cal.date.print(cal.dateFormat); },
				     function(cal) {});
	flat_calendar.noGrab = true;
	flat_calendar.create();
	flat_calendar.showAtElement(document.getElementById("calendar-anchor").firstChild, "Tl");
	flat_calendar.onFDOW = onFDOW;
	flat_calendar.onFDOW();

	initFactoryFormats();
};

function initFactoryFormats() {
	var factory = ["f_prop_ifFormat-factory", "f_prop_daFormat-factory"];
	var date = new Date();
	for (var i = factory.length; --i >= 0;) {
		var id = factory[i];
		var sel = document.getElementById(id);
		while (sel.options[1])
			sel.remove(1);
		for (var j = 0; j < factory_formats.length; ++j) {
			var format = factory_formats[j];
			var o = document.createElement("option");
			o.innerHTML = date.print(format);
			o.value = format;
			sel.appendChild(o);
		}
	}
};

function addHoverEvents(el) {
	el.onmouseover = HE_onMouseOver;
	el.onmouseout = HE_onMouseOut;
};

function HE_onMouseOver(ev) {
	ev || (ev = window.event);
	if (!utils.isRelated(this, ev))
		utils.addClass(this, "hover");
};

function HE_onMouseOut(ev) {
	ev || (ev = window.event);
	if (!utils(this, ev))
		utils.removeClass(this, "hover");
};

function onFDOW(fdow) {
	if (typeof fdow == "undefined")
		fdow = this.firstDayOfWeek;
	var sel = document.getElementById("f_prop_firstDayOfWeek");
	utils.selectOption(sel, fdow);
};

function initTabs() {
	var bar = document.getElementById("tab-bar");
	var tabs = document.getElementById("tabs");
	var tmp;
	var current = null;
	for (var i = tabs.firstChild; i; i = i.nextSibling) {
		if (i.nodeType != 1)
			continue;
		a_tabs[a_tabs.length] = (tmp = utils.createElement("a", bar));
		//tmp.id = tmp.href = "#pane-" + a_tabs.length;
		tmp.href = "#";
		tmp.innerHTML = "<u>" + (a_tabs.length) + "</u>. <span class='bullet'>»</span>";
		tmp.accessKey = "" + (a_tabs.length);
		tmp.theSpan = i.firstChild;
		tmp.theSpan.action = tmp.theSpan.onclick;
		tmp.theSpan.onclick = "";
		tmp.appendChild(i.firstChild);
		if (!/hide/.test(i.className))
			(current = tmp).className = "active";
		tmp.onclick = changeTab;
		tmp.__msh_tab = i;

		// check if it has advanced stuff
		var cl = tmp.theSpan.className;
		if (/([^\s]+-advanced-)(.*)/.test(cl)) {
			tmp.hasAdvanced = true;
			tmp.advanced_id_prefix = RegExp.$1;
			tmp.advanced_id_suffix = RegExp.$2.split(/-/);
			tmp.advanced = false;
		} else
			tmp.hasAdvanced = false;
	}
	if (current)
		current.onclick();
};

function changeTab() {
	var i = 0, tab;
	while (tab = a_tabs[i++]) {
		utils.removeClass(tab, "active");
		if (tab === this)
			tab.__msh_tab.style.display = "block";
		else
			tab.__msh_tab.style.display = "none";
	}
	utils.addClass(this, "active");
	document.getElementById("b_prev").disabled = !this.previousSibling;
	document.getElementById("b_next").disabled = !this.nextSibling;
	if (typeof this.theSpan.action == "function")
		this.theSpan.action();
	else if (typeof this.theSpan.action == "string")
		eval(this.theSpan.action);
	updateAdvanced(this);
	this.blur();
	return false;
};

function getCurrentTab() {
	var tab = null;
	for (var i = a_tabs.length; --i >= 0;) {
		tab = a_tabs[i];
		if (/active/.test(tab.className))
			break;
	}
	return tab;
};

function nextTab() {
	var tab = getCurrentTab();
	if (tab && tab.nextSibling)
		tab.nextSibling.onclick();
};

function prevTab() {
	var tab = getCurrentTab();
	if (tab && tab.previousSibling)
		tab.previousSibling.onclick();
};

function setActiveTheme(sel) {
	var i = 0, o, a = sel.options, l;
	while (o = a[i++]) {
		l = document.getElementById("theme-" + o.value);
		if (l)
			l.disabled = true;
	}
	l = document.getElementById("theme-" + sel.value);
	if (l)
		l.disabled = false;
};

function setSize(val) {
	var i = 0, el, actual = false;
	if (val)
		val = new RegExp("" + val + ".css$");
	while (el = document.getElementById('theme-size-' + ++i)) {
		el.disabled = true;
		if (val && val.test(el.href))
			actual = el;
	}
	if (actual)
		actual.disabled = false;
};

function selectChange(sel) {
	switch (sel.id) {
	    case "f_theme":
		setActiveTheme(sel);
		break;
	    case "f_language":
		Zapatec.Calendar._TT = Zapatec.Calendar["_TT_" + sel.value];
		Zapatec.Calendar._initSDN();
		flat_calendar.refresh();
		initFactoryFormats();
		break;
	}
};

function propChange(el) {
	switch (el.id) {
	    case "f_prop_showsTime":
		flat_calendar.showsTime = el.checked;
		document.getElementById("timeprops").style.visibility = el.checked ? "visible" : "hidden";
		break;
	    case "f_prop_timeFormat":
		flat_calendar.time24 = el.value == "24";
		break;
	    case "f_prop_firstDayOfWeek":
		flat_calendar.setFirstDayOfWeek(parseInt(el.value, 10));
		return;		// no need to refresh
	    case "f_prop_weekNumbers":
		flat_calendar.weekNumbers = el.checked;
		break;
	    case "f_prop_showOthers":
		flat_calendar.showsOtherMonths = el.checked;
		break;
	    case "f_prop_yearStep":
		flat_calendar.yearStep = parseInt(el.value, 10);
		return;		// no need to refresh
	}
	flat_calendar.refresh();
};

function format_setActiveField(input) {
	format_activeField = input;
};

function tokenClicked(link, token) {
	var v = format_activeField.value;
	if (/\b$/.test(v))
		v += " ";
	v += token;
	format_activeField.value = v;
	link.blur();
	format_activeField.focus();
	format_updateTests();
	return false;
};

function clear_field(el) {
	if (typeof el == "string")
		el = document.getElementById(el);
	el.value = '';
	el.focus();
};

function radioTabChange(r) {
	var tabs_id = "tab-" + r.name;
	var id = r.name + "-" + r.value;
	var tabs = document.getElementById(tabs_id);
	for (var i = tabs.firstChild; i; i = i.nextSibling) {
		if (i.nodeType != 1)
			continue;
		i.style.display = i.id == id ? "block" : "none";
	}
};

function testAlign(btn) {
	function H(cal) { cal.destroy(); };
	var cal = new Zapatec.Calendar(1, new Date(), H, H);
	cal.create();
	var align = document.getElementById("f_prop_valign").value + document.getElementById("f_prop_halign").value;
	cal.showAtElement(btn, align);
};

function makeCode(test) {
	var c = {
		lang              : document.getElementById("f_language").value,
		theme             : document.getElementById("f_theme").value,
		size              : document.getElementById("f_size").value,

		// generic
		firstDay          : document.getElementById("f_prop_firstDayOfWeek").value,
		weekNumbers       : document.getElementById("f_prop_weekNumbers").checked,
		showOthers        : document.getElementById("f_prop_showOthers").checked,
		showsTime         : document.getElementById("f_prop_showsTime").checked,
		timeFormat        : document.getElementById("f_prop_timeFormat").value,
		step              : document.getElementById("f_prop_yearStep").value,
		electric          : document.getElementById("f_prop_electric").checked,
		range             : ( document.getElementById("f_prop_rangeLeft").value + '.' +
				      document.getElementById("f_prop_rangeLeft_Month").value + ', ' +
				      document.getElementById("f_prop_rangeRight").value + '.' +
				      document.getElementById("f_prop_rangeRight_Month").value ),
		ifFormat          : document.getElementById("f_prop_ifFormat").value,
		daFormat          : document.getElementById("f_prop_daFormat").value,
		singleClick       : !document.getElementById("f_prop_dblclick").checked,

		// popup calendars
		inputField        : document.getElementById("f_prop_inputField").value,
		displayArea       : document.getElementById("f_prop_displayArea").value,
		button            : document.getElementById("f_prop_button").value,
		align             : ( document.getElementById("f_prop_valign").value +
				      document.getElementById("f_prop_halign").value ),

		// flat calendars
		flat              : document.getElementById("f_prop_flat").value,
		flatCallback      : document.getElementById("f_prop_flatCallback").value
	};
	var html = "<html>\n";
	var path = test ? wizard_address : document.getElementById('f_path').value;
	path = path.replace(/\/*$/, '/');

	function comment(txt) {
		html += "<!-- " + txt + " -->\n";
	};

	html += "  <head>\n\n";
	comment("UTF-8 is the recommended encoding for your pages");
	html += '    <meta http-equiv="content-type" content="text/xml; charset=utf-8" />\n';
	html += '    <title>Zapatec DHTML Calendar</title>\n\n';

	comment("Loading Theme file(s)");
	html += '    <link rel="stylesheet" href="' + path + 'themes/' + c.theme + '.css" />\n';
	if (c.size)
		html += '    <link rel="stylesheet" href="' + path + 'themes/layouts/' + c.size + '.css" />\n';
	html += "\n";

	comment("Loading Calendar JavaScript files");
	html += '    <script type="text/javascript" src="' + path + 'src/utils.js"></script>\n';
	html += '    <script type="text/javascript" src="' + path + 'src/calendar.js"></script>\n';
	html += '    <script type="text/javascript" src="' + path + 'src/calendar-setup.js"></script>\n\n';

	comment("Loading language definition file");
	html += '    <script type="text/javascript" src="' + path + 'lang/calendar-' + c.lang + '.js"></script>\n\n';

	html += '  </head>\n';
	html += '  <body>\n\n';

	html += '<!-- CUT THIS LINE --><h1>Test your calendar</h1>\n';
	html += '<!-- CUT THIS LINE --><blockquote>\n';

	function beginScript() {
		html += '    <script type="text/javascript">//<![CDATA[\n';
	};

	function endScript() {
	html += '    //]]></script>\n';
	html += '<noscript>\n';
	html += '<br/>\n';
	html += 'This page uses a <a href="http://www.zapatec.com/website/main/products/prod1/"> Javascript Calendar </a>, but\n';
	html += 'your browser does not support Javascript. \n';
	html += '<br/>\n';
	html += 'Either enable Javascript in your Browser or upgrade to a newer version.\n';
	html += '</noscript>\n';
	};

	function beginCommonCalendarSetup() {
		beginScript();
		html += '/* CUT THIS LINE */ window.onload = function() {\n';
		html += '      Zapatec.Calendar.setup({\n';
		html += '        firstDay          : ' + c.firstDay + ',\n';
		html += '        weekNumbers       : ' + c.weekNumbers + ',\n';
		html += '        showOthers        : ' + c.showOthers + ',\n';
		html += '        showsTime         : ' + c.showsTime + ',\n';
		html += '        timeFormat        : "' + c.timeFormat + '",\n';
		html += '        step              : ' + c.step + ',\n';
		html += '        range             : [' + c.range + '],\n';
	};

	function endCommonCalendarSetup() {
		html += '      });\n';
		html += '/* CUT THIS LINE */ };\n';
		endScript();
	};

	if (document.getElementById("r_popup").checked) {
		// generating a popup calendar
		if (!c.inputField && !c.displayArea && !c.button) {
			comment("ERROR: none of the input field, display area or trigger button\n" +
				"properties are defined. Please go back to step 1 (“Type”)\n" +
				"and define at least one of them.");
		} else {
			if (c.inputField)
				html += '    <input type="' + (c.displayArea ? "hidden" : "text") + '"' +
					' id="' + c.inputField + '" name="' + c.inputField + '" />\n';
			if (c.displayArea)
				if (c.button)
					html += '    <div style="border: 1px solid #000; padding: 2px 5px;" id="' +
						c.displayArea + '">Select date</div>\n';
				else
					html += '    <a href="#" id="' + c.displayArea + '">Select date</a>\n';
			if (c.button)
				html += '    <button id="' + c.button + '">...</button>\n';
			beginCommonCalendarSetup();
			html += '        electric          : ' + c.electric + ',\n';
			html += '        singleClick       : ' + c.singleClick + ',\n';
			if (c.inputField)
				html += '        inputField        : "' + c.inputField + '",\n';
			if (c.displayArea)
				html += '        displayArea       : "' + c.displayArea + '",\n';
			if (c.button)
				html += '        button            : "' + c.button + '",\n';
			if (c.ifFormat)
				html += '        ifFormat          : "' + c.ifFormat + '",\n';
			if (c.daFormat)
				html += '        daFormat          : "' + c.daFormat + '",\n';
			html += '        align             : "' + c.align + '"\n';
			endCommonCalendarSetup();
		}
	} else {
		// generating a flat calendar
		if (!c.flat || !c.flatCallback) {
			comment("ERROR: you did not specify the container ID and/or\n" +
				"the flat callback function name.  Please go back to\n" +
				"step 1 (“Type”) and make sure they are defined.");
		} else {
			comment("The following empty element is the container for the calendar.\n" +
				"It has the ID that you defined at step 1 (“Type”).\n" +
				"When “Calendar.setup” is called below, the calendar will be generated\n" +
				"in this element.  Feel free to position it the way you want\n" +
				"using CSS.  You will normally want this to be a floating element\n" +
				"which is why we generated one having the style “float: right”.");

			html += "\n";
			html += '<div style="float: right; margin: 0 0 1em 1em" id="' + c.flat + '"></div>\n\n';

			comment("The following JavaScript code defines a function that will\n" +
				"get called each time the user modifies the date inside the calendar.\n" +
				"To make sure that a date was actually clicked, we check the\n" +
				"cal.dateClicked variable.  If a date wasn't clicked this will be\n" +
				"“false” and it usually means that the date was modified using the\n" +
				"month or year navigation buttons, or that only the time got modified.");
			html += "\n";
			// generating the flat callback function
			beginScript();
			html += '      function ' + c.flatCallback + '(cal) {\n';
			html += '        if (cal.dateClicked) {\n';
			html += '          var url = "http://www.mydomain.com/" + cal.date.print("%Y/%m/%d/");\n';
			html += '          alert("Jumping to: “" + url + "” (not really).");\n';
			html += '          // uncomment the following line to actually jump:\n';
			html += '          // window.location = url;\n';
			html += '        }\n';
			html += '      };\n';
			endScript();

			html += "\n";

			beginCommonCalendarSetup();
			html += '        flat              : "' + c.flat + '",\n';
			html += '        flatCallback      : ' + c.flatCallback + '\n';
			endCommonCalendarSetup();
		}
	}

	html += '<!-- CUT THIS LINE --></blockquote>\n';

	html += '<!-- CUT THIS LINE --><blockquote>If you are not happy with the result, go back to the ' +
		'wizard and configure more options.  Otherwise, go back to the wizard, copy the code ' +
		'displayed in the “Generate” tab and insert it into your own application.</blockquote>\n';

	html += '<!-- CUT THIS LINE --><p>' +
		'<a href="javascript:window.close()">close this window</a></p>\n';

	html += '\n  </body>\n';
	html += '</html>\n';

	return html;
};

function onGenerate() {
	var ta = document.getElementById("code");
	var html = makeCode(false);

	ta.value = code_removeCuts(html);

	setTimeout(function() {
		ta.focus();
		if (!ta.__msh_positioned) {
			ta.style.height = ta.parentNode.parentNode.parentNode.offsetHeight - 200 + "px";
			ta.__msh_positioned = true;
		}
	}, 100);
};

function selectCode() {
	var ta = document.getElementById("code");
	ta.focus();
	ta.select();
};

function code_removeCuts(text) {
	return text.replace(/(\/\*|<!--)\s*CUT.THIS.LINE\s*(\*\/|-->).*\n/ig, '');
};

function testCode() {
	var
		HM = 300,
		WM = 400,
		h = screen.height - HM,
		w = screen.width - WM;
	var win = window.open(Zapatec.is_gecko ? "javascript:false" : "blank.html", "TESTCAL",
			      "width="+w+",height="+h+",left="+Math.round(WM/2)+",top="+Math.round(HM/2)+",toolbar=no," +
			      "menubar=no,directories=no,channelmode=no,resizable=yes,scrollbars=yes");
	win.focus();
	var doc = win.document;
	doc.open();
	doc.write(makeCode(true));
	doc.close();
};

function updateAdvanced(tab) {
	var ab = document.getElementById("b_advanced");
	ab.style.visibility = tab.hasAdvanced ? "visible" : "hidden";
	if (tab.hasAdvanced)
		ab.innerHTML = tab.advanced ? "Hide advanced options" : "Show advanced options";
};

function advanced() {
	var tab = getCurrentTab();
	if (tab.hasAdvanced) {
		tab.advanced =! tab.advanced;
		var id = tab.advanced_id_prefix;
		var a = tab.advanced_id_suffix;
		var vis = tab.advanced ? "visible" : "hidden";
		for (var i = a.length; --i >= 0;)
			document.getElementById(id + a[i]).style.visibility = vis;
		updateAdvanced(tab);
	} else
		alert("No advanced stuff in this tab");
};

function format_updateTests() {
	var date = new Date();
	var f1 = document.getElementById("f_prop_ifFormat");
	var t1 = document.getElementById(f1.id + "-test");
	var f2 = document.getElementById("f_prop_daFormat");
	var t2 = document.getElementById(f2.id + "-test");

	if (!f1.value)
		t1.innerHTML = "[empty format]";
	else
		t1.innerHTML = date.print(f1.value);

	if (!f2.value)
		t2.innerHTML = "[empty format]";
	else
		t2.innerHTML = date.print(f2.value);
};

function format_keyPress(field) {
	var factory = document.getElementById(field.id + "-factory");
	if (factory)
		utils.selectOption(factory, "");
	setTimeout(function() {
		format_updateTests();
	}, 10);
};

function factoryFormat(sel) {
	if (sel.value) {
		var id = sel.id.replace(/-factory$/, '');
		var field = document.getElementById(id);
		field.value = sel.value;
		format_updateTests();
	}
};

function setWizardPath(newAddress) {
	wizard_address = newAddress;
	document.getElementById('f_path').value = newAddress;
}
