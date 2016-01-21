// holds an instance of XMLHttpRequest
var xmlHttp = createXmlHttpRequestObject();
// when set to true, display detailed error messages
var showErrors = true;
// initialize the validation requests cache
var cache = new Array();
// creates an XMLHttpRequest instance
function createXmlHttpRequestObject()
{
	// will store the reference to the XMLHttpRequest object
	var xmlHttp;
	// this should work for all browsers except IE6 and older
	try
	{
		// try to create XMLHttpRequest object
		xmlHttp = new XMLHttpRequest();
	}
	catch(e)
	{
		// assume IE6 or older
		var XmlHttpVersions = new Array("MSXML2.XMLHTTP.6.0",
		"MSXML2.XMLHTTP.5.0",
		"MSXML2.XMLHTTP.4.0",
		"MSXML2.XMLHTTP.3.0",
		"MSXML2.XMLHTTP",
		"Microsoft.XMLHTTP");
		// try every id until one works
		for (var i=0; i<XmlHttpVersions.length && !xmlHttp; i++)
		{
			try
			{
				// try to create XMLHttpRequest object
				xmlHttp = new ActiveXObject(XmlHttpVersions[i]);
			}
			catch (e) {} // ignore potential error
		}
	}
	// return the created object or display an error message
	if (!xmlHttp)
	displayError("Error creating the XMLHttpRequest object.");
	else
	return xmlHttp;
}

// function that handles the HTTP response
function handleRequestStateChange()
{
	// when readyState is 4, we read the server response
	if (xmlHttp.readyState == 4)
	{
		// continue only if HTTP status is "OK"
		if (xmlHttp.status == 200)
		{
			try
			{
				// read the response from the server
				readResponse();
			}
			catch(e)
			{
				// display error message
				displayError(e.toString());
			}
		}
		else
		{
			// display error message
			displayError(xmlHttp.statusText);
		}
	}
}