<?php
/**
 * Require the action class
 */
require_once 'HTML/AJAX/Action.php';

class usuarios{
	function updateClassName() {
		$response = new HTML_AJAX_Action();

		$response->assignAttr('test','className','test');

		return $response;
	}

	function greenText($id) {
		$response = new HTML_AJAX_Action();
		$response->assignAttr($id,'style','color: green');
		return $response;
	}

	function highlight($id) {
		$response = new HTML_AJAX_Action();
		$response->assignAttr($id,'style','background-color: yellow');
		return $response;
	}

	function getUsuarios($id, $depeCodi) {
		// there really should be an action method to do this
		$response = new HTML_AJAX_Action();
		
		$response->insertScript("
		 document.getElementById('$depeCodi').appendChild(new
		 Option('ppGammaridae ','Gammaridae'));");
		return $response;
	}
}
