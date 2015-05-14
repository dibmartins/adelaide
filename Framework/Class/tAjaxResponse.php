<?php
/**
 * The xajaxResponse class is used to created responses to be sent back to your
 * webpage.  A response contains one or more command messages for updating your page.
 * Currently xajax supports 17 kinds of command messages, including some common ones such as:
 * @package Framework
 * @subpackage Ajax
 * @version 0.2.4 - 2006-10-25 09:21:00 
 * @author Jared White & J. Max Wilson
 * @link http://www.diegobotelho.com.br
 * @link http://www.xajaxproject.org
 * @link http://wiki.xajaxproject.org/Documentation:xajax.inc.php 
 * @license http://www.gnu.org/copyleft/lesser.html#SEC3
 * @copyright 2005-2006 by Jared White & J. Max Wilson
 *
 * Assign - sets the specified attribute of an element in your page
 * Append - appends data to the end of the specified attribute of an element in your page
 * Prepend - prepends data to the beginning of the specified attribute of an element in your page
 * Replace - searches for and replaces data in the specified attribute of an element in your page
 * Script - runs the supplied JavaScript code
 * Alert - shows an alert box with the supplied message text
 * Note: elements are identified by their HTML id, so if you don't see your browser HTML display changing from the request, make sure you're using the right id names in your response. *
 */

class AjaxResponse
{
	/**#@+
	 * @access protected
	 */
	/**
	 * @var string internal XML storage
	 */	
	var $xml;
	/**
	 * @var string the encoding type to use
	 */
	var $sEncoding;
	/**
	 * @var boolean if special characters in the XML should be converted to
	 *              entities
	 */
	var $bOutputEntities;

	/**#@-*/
	
	/**
	 * The constructor's main job is to set the character encoding for the
	 * response.
	 * 
	 * <i>Note:</i> to change the character encoding for all of the
	 * responses, set the XAJAX_DEFAULT_ENCODING constant before you
	 * instantiate xajax.
	 * 
	 * @param string  contains the character encoding string to use
	 * @param boolean lets you set if you want special characters in the output
	 *                converted to HTML entities
	 * 
	 */
	function AjaxResponse($sEncoding=XAJAX_DEFAULT_CHAR_ENCODING, $bOutputEntities=false)
	{
		$this->SetCharEncoding($sEncoding);
		$this->bOutputEntities = $bOutputEntities;
	}
	
	/**
	 * Sets the character encoding for the response based on $sEncoding, which
	 * is a string containing the character encoding to use. You don't need to
	 * use this method normally, since the character encoding for the response
	 * gets set automatically based on the XAJAX_DEFAULT_CHAR_ENCODING
	 * constant.
	 * 
	 * @param string
	 */
	function SetCharEncoding($sEncoding)
	{
		$this->sEncoding = $sEncoding;
	}
	
	/**
	 * Tells the response object to convert special characters to HTML entities
	 * automatically (only works if the mb_string extension is available).
	 */
	function OutputEntitiesOn()
	{
		$this->bOutputEntities = true;
	}
	
	/**
	 * Tells the response object to output special characters intact. (default
	 * behavior)
	 */
	function OutputEntitiesOff()
	{
		$this->bOutputEntities = false;
	}

	/**
	 * Adds a confirm commands command message to the XML response.
	 * 
	 * <i>Usage:</i> <kbd>$objResponse->AddConfirmCommands(1, "Do you want to preview the new data?");</kbd>
	 *
	 * @param integer the number of commands to skip if the user presses
	 *                Cancel in the browsers's confirm dialog
	 * @param string  the message to show in the browser's confirm dialog
	 */
	function AddConfirmCommands($iCmdNumber, $sMessage)
	{
		$this->xml .= $this->CmdXML(array("n"=>"cc","t"=>$iCmdNumber),$sMessage);
	}
	
	/**
	 * Adds an assign command message to the XML response.
	 * 
	 * <i>Usage:</i> <kbd>$objResponse->AddAssign("contentDiv", "innerHTML", "Some Text");</kbd>
	 * 
	 * @param string contains the id of an HTML element
	 * @param string the part of the element you wish to modify ("innerHTML",
	 *               "value", etc.)
	 * @param string the data you want to set the attribute to
	 */
	function AddAssign($sTarget,$sAttribute,$sData)
	{
		$this->xml .= $this->CmdXML(array("n"=>"as","t"=>$sTarget,"p"=>$sAttribute),$sData);
	}

	/**
	 * Adds an append command message to the XML response.
	 * 
	 * <i>Usage:</i> <kbd>$objResponse->AddAppend("contentDiv", "innerHTML", "Some New Text");</kbd>
	 * 
	 * @param string contains the id of an HTML element
	 * @param string the part of the element you wish to modify ("innerHTML",
	 *               "value", etc.)
	 * @param string the data you want to append to the end of the attribute
	 */
	function AddAppend($sTarget,$sAttribute,$sData)
	{	
		$this->xml .= $this->CmdXML(array("n"=>"ap","t"=>$sTarget,"p"=>$sAttribute),$sData);
	}

	/**
	 * Adds an prepend command message to the XML response.
	 * 
	 * <i>Usage:</i> <kbd>$objResponse->AddPrepend("contentDiv", "innerHTML", "Some Starting Text");</kbd>
	 * 
	 * @param string contains the id of an HTML element
	 * @param string the part of the element you wish to modify ("innerHTML",
	 *               "value", etc.)
	 * @param string the data you want to prepend to the beginning of the
	 *               attribute
	 */
	function AddPrepend($sTarget,$sAttribute,$sData)
	{
		$this->xml .= $this->CmdXML(array("n"=>"pp","t"=>$sTarget,"p"=>$sAttribute),$sData);
	}

	/**
	 * Adds a replace command message to the XML response.
	 * 
	 * <i>Usage:</i> <kbd>$objResponse->AddReplace("contentDiv", "innerHTML", "text", "<b>text</b>");</kbd>
	 * 
	 * @param string contains the id of an HTML element
	 * @param string the part of the element you wish to modify ("innerHTML",
	 *               "value", etc.)
	 * @param string the string to search for
	 * @param string the string to replace the search string when found in the
	 *               attribute
	 */
	function AddReplace($sTarget,$sAttribute,$sSearch,$sData)
	{
		$sDta = "<s><![CDATA[$sSearch]]></s><r><![CDATA[$sData]]></r>";
		$this->xml .= $this->CmdXML(array("n"=>"rp","t"=>$sTarget,"p"=>$sAttribute),$sDta);
	}

	/**
	 * Adds a clear command message to the XML response.
	 * 
	 * <i>Usage:</i> <kbd>$objResponse->AddClear("contentDiv", "innerHTML");</kbd>
	 * 
	 * @param string contains the id of an HTML element
	 * @param string the part of the element you wish to Clear("innerHTML",
	 *               "value", etc.)
	 */	
	function AddClear($sTarget,$sAttribute)
	{
		$this->AddAssign($sTarget,$sAttribute,'');
	}
	
	/**
	 * Adds an alert command message to the XML response.
	 * 
	 * <i>Usage:</i> <kbd>$objResponse->AddAlert("This is important information");</kbd>
	 * 
	 * @param string the text to be displayed in the Javascript alert box
	 */
	function AddAlert($sMsg)
	{
		$this->xml .= $this->CmdXML(array("n"=>"al"),$sMsg);
	}

	/**
	 * Uses the AddScript() method to add a Javascript redirect to another URL.
	 * 
	 * <i>Usage:</i> <kbd>$objResponse->AddRedirect("http://www.xajaxproject.org");</kbd>
	 * 
	 * @param string the URL to redirect the client browser to
	 */	
	function AddRedirect($sURL)
	{
		//we need to parse the query part so that the values are rawurlencode()'ed
		//can't just use parse_url() cos we could be dealing with a relative URL which
		//  parse_url() can't deal with.
		$queryStart = strpos($sURL, '?', strrpos($sURL, '/'));
		if ($queryStart !== FALSE)
		{
			$queryStart++;
			$queryEnd = strpos($sURL, '#', $queryStart);
			if ($queryEnd === FALSE)
				$queryEnd = strlen($sURL);
			$queryPart = substr($sURL, $queryStart, $queryEnd-$queryStart);
			parse_str($queryPart, $queryParts);
			$newQueryPart = "";
			foreach($queryParts as $key => $value)
			{
				$newQueryPart .= rawurlencode($key).'='.rawurlencode($value).ini_get('arg_separator.output');
			}
			$sURL = str_replace($queryPart, $newQueryPart, $sURL);
		}
		$this->AddScript('window.location = "'.$sURL.'";');
	}

	/**
	 * Adds a Javascript command message to the XML response.
	 * 
	 * <i>Usage:</i> <kbd>$objResponse->AddScript("var x = prompt('get some text');");</kbd>
	 * 
	 * @param string contains Javascript code to be executed
	 */
	function AddScript($sJS)
	{
		$this->xml .= $this->CmdXML(array("n"=>"js"),$sJS);
	}

	/**
	 * Adds a Javascript function call command message to the XML response.
	 * 
	 * <i>Usage:</i> <kbd>$objResponse->AddScriptCall("myJSFunction", "arg 1", "arg 2", 12345);</kbd>
	 * 
	 * @param string $sFunc the name of a Javascript function
	 * @param mixed $args,... optional arguments to pass to the Javascript function
	 */
	function AddScriptCall() {
		$arguments = func_get_args();
		$sFunc = array_shift($arguments);
		$sData = $this->BuildObjXml($arguments);
		$this->xml .= $this->CmdXML(array("n"=>"jc","t"=>$sFunc),$sData);
	}

	/**
	 * Adds a remove element command message to the XML response.
	 * 
	 * <i>Usage:</i> <kbd>$objResponse->AddRemove("Div2");</kbd>
	 * 
	 * @param string contains the id of an HTML element to be removed
	 */
	function AddRemove($sTarget)
	{
		$this->xml .= $this->CmdXML(array("n"=>"rm","t"=>$sTarget),'');
	}

	/**
	 * Adds a create element command message to the XML response.
	 * 
	 * <i>Usage:</i> <kbd>$objResponse->AddCreate("parentDiv", "h3", "myid");</kbd>
	 * 
	 * @param string contains the id of an HTML element to to which the new
	 *               element will be appended.
	 * @param string the tag to be added
	 * @param string the id to be assigned to the new element
	 * @param string deprecated, use the AddCreateInput() method instead
	 */
	function AddCreate($sParent, $sTag, $sId, $sType="")
	{
		if ($sType)
		{
			trigger_error("The \$sType parameter of AddCreate has been deprecated.  Use the AddCreateInput() method instead.", E_USER_WARNING);
			return;
		}
		$this->xml .= $this->CmdXML(array("n"=>"ce","t"=>$sParent,"p"=>$sId),$sTag);
	}

	/**
	 * Adds a insert element command message to the XML response.
	 * 
	 * <i>Usage:</i> <kbd>$objResponse->AddInsert("childDiv", "h3", "myid");</kbd>
	 * 
	 * @param string contains the id of the child before which the new element
	 *               will be inserted
	 * @param string the tag to be added
	 * @param string the id to be assigned to the new element
	 */
	function AddInsert($sBefore, $sTag, $sId)
	{
		$this->xml .= $this->CmdXML(array("n"=>"ie","t"=>$sBefore,"p"=>$sId),$sTag);
	}

	/**
	 * Adds a insert element command message to the XML response.
	 * 
	 * <i>Usage:</i> <kbd>$objResponse->AddInsertAfter("childDiv", "h3", "myid");</kbd>
	 * 
	 * @param string contains the id of the child after which the new element
	 *               will be inserted
	 * @param string the tag to be added
	 * @param string the id to be assigned to the new element
	 */
	function AddInsertAfter($sAfter, $sTag, $sId)
	{
		$this->xml .= $this->CmdXML(array("n"=>"ia","t"=>$sAfter,"p"=>$sId),$sTag);
	}
	
	/**
	 * Adds a create input command message to the XML response.
	 * 
	 * <i>Usage:</i> <kbd>$objResponse->AddCreateInput("form1", "text", "username", "input1");</kbd>
	 * 
	 * @param string contains the id of an HTML element to which the new input
	 *               will be appended
	 * @param string the type of input to be created (text, radio, checkbox,
	 *               etc.)
	 * @param string the name to be assigned to the new input and the variable
	 *               name when it is submitted
	 * @param string the id to be assigned to the new input
	 */
	function AddCreateInput($sParent, $sType, $sName, $sId)
	{
		$this->xml .= $this->CmdXML(array("n"=>"ci","t"=>$sParent,"p"=>$sId,"c"=>$sType),$sName);
	}

	/**
	 * Adds an insert input command message to the XML response.
	 * 
	 * <i>Usage:</i> <kbd>$objResponse->AddInsertInput("input5", "text", "username", "input1");</kbd>
	 * 
	 * @param string contains the id of the child before which the new element
	 *               will be inserted
	 * @param string the type of input to be created (text, radio, checkbox,
	 *               etc.)
	 * @param string the name to be assigned to the new input and the variable
	 *               name when it is submitted
	 * @param string the id to be assigned to the new input
	 */
	function AddInsertInput($sBefore, $sType, $sName, $sId)
	{
		$this->xml .= $this->CmdXML(array("n"=>"ii","t"=>$sBefore,"p"=>$sId,"c"=>$sType),$sName);
	}

	/**
	 * Adds an insert input command message to the XML response.
	 * 
	 * <i>Usage:</i> <kbd>$objResponse->AddInsertInputAfter("input7", "text", "email", "input2");</kbd>
	 * 
	 * @param string contains the id of the child after which the new element
	 *               will be inserted
	 * @param string the type of input to be created (text, radio, checkbox,
	 *               etc.)
	 * @param string the name to be assigned to the new input and the variable
	 *               name when it is submitted
	 * @param string the id to be assigned to the new input
	 */
	function AddInsertInputAfter($sAfter, $sType, $sName, $sId)
	{
		$this->xml .= $this->CmdXML(array("n"=>"iia","t"=>$sAfter,"p"=>$sId,"c"=>$sType),$sName);
	}

	/**
	 * Adds an event command message to the XML response.
	 * 
	 * <i>Usage:</i> <kbd>$objResponse->AddEvent("contentDiv", "onclick", "alert(\'Hello World\');");</kbd>
	 * 
	 * @param string contains the id of an HTML element
	 * @param string the event you wish to set ("onclick", "onmouseover", etc.)

	 * @param string the Javascript string you want the event to invoke
	 */
	function AddEvent($sTarget,$sEvent,$sScript)
	{
		$this->xml .= $this->CmdXML(array("n"=>"ev","t"=>$sTarget,"p"=>$sEvent),$sScript);
	}

	/**
	 * Adds a handler command message to the XML response.
	 * 
	 * <i>Usage:</i> <kbd>$objResponse->AddHandler("contentDiv", "onclick", "content_click");</kbd>
	 * 
	 * @param string contains the id of an HTML element
	 * @param string the event you wish to set ("onclick", "onmouseover", etc.)
	 * @param string the name of a Javascript function that will handle the
	 *               event. Multiple handlers can be added for the same event
	 */
	function AddHandler($sTarget,$sEvent,$sHandler)
	{	
		$this->xml .= $this->CmdXML(array("n"=>"ah","t"=>$sTarget,"p"=>$sEvent),$sHandler);
	}

	/**
	 * Adds a remove handler command message to the XML response.
	 * 
	 * <i>Usage:</i> <kbd>$objResponse->AddRemoveHandler("contentDiv", "onclick", "content_click");</kbd>
	 * 
	 * @param string contains the id of an HTML element
	 * @param string the event you wish to remove ("onclick", "onmouseover",
	 *               etc.)
	 * @param string the name of a Javascript handler function that you want to
	 *               remove
	 */
	function AddRemoveHandler($sTarget,$sEvent,$sHandler)
	{	
		$this->xml .= $this->CmdXML(array("n"=>"rh","t"=>$sTarget,"p"=>$sEvent),$sHandler);
	}

	/**
	 * Adds an include script command message to the XML response.
	 * 
	 * <i>Usage:</i> <kbd>$objResponse->AddIncludeScript("functions.js");</kbd>
	 * 
	 * @param string URL of the Javascript file to include
	 */
	function AddIncludeScript($sFileName)
	{
		$this->xml .= $this->CmdXML(array("n"=>"in"),$sFileName);
	}

	/**	
	 * Returns the XML to be returned from your function to the xajax processor
	 * on your page. Since xajax 0.2, you can also return an xajaxResponse
	 * object from your function directly, and xajax will automatically request
	 * the XML using this method call.
	 * 
	 * <i>Usage:</i> <kbd>return $objResponse->GetXML();</kbd>
	 * 
	 * @return string response XML data
	 */
	function GetXML()
	{
		$sXML = "<?xml version=\"1.0\"";
		if ($this->sEncoding && strlen(trim($this->sEncoding)) > 0)
			$sXML .= " encoding=\"".$this->sEncoding."\"";
		$sXML .= " ?"."><xjx>" . $this->xml . "</xjx>";
		
		return $sXML;
	}
	
	/**
	 * Adds the commands of the provided response XML output to this response
	 * object
	 * 
	 * <i>Usage:</i>
	 * <code>$r1 = $objResponse1->GetXML();
	 * $objResponse2->LoadXML($r1);
	 * return $objResponse2->GetXML();</code>
	 * 
	 * @param string the response XML (returned from a getXML() method) to add
	 *               to the end of this response object
	 */
	function LoadXML($mXML)
	{
		if (is_a($mXML, "xajaxResponse")) {
			$mXML = $mXML->GetXML();
		}
		$sNewXML = "";
		$iStartPos = strpos($mXML, "<xjx>") + 5;
		$sNewXML = substr($mXML, $iStartPos);
		$iEndPos = strpos($sNewXML, "</xjx>");
		$sNewXML = substr($sNewXML, 0, $iEndPos);
		$this->xml .= $sNewXML;
	}

	/**
	 * Generates XML from command data
	 * 
	 * @access private
	 * @param array associative array of attributes
	 * @param string data
	 * @return string XML command
	 */
	function CmdXML($aAttributes, $sData)
	{
		if ($this->bOutputEntities) {
			if (function_exists('mb_convert_encoding')) {
				$sData = call_user_func_array('mb_convert_encoding', array(&$sData, 'HTML-ENTITIES', $this->sEncoding));
			}
			else {
				trigger_error("A saída da resposta XML não pode ser convertida para HTML entities porque a função mb_convert_encoding não está disponível", E_USER_NOTICE);
			}
		}
		$xml = "<cmd";
		foreach($aAttributes as $sAttribute => $sValue)
			$xml .= " $sAttribute=\"$sValue\"";
		if ($sData !== null && !stristr($sData,'<![CDATA['))
			$xml .= "><![CDATA[$sData]]></cmd>";
		else if ($sData !== null)
			$xml .= ">$sData</cmd>";
		else
			$xml .= "></cmd>";
		
		return $xml;
	}

	/**
	 * Recursively serializes a data structure in XML so it can be sent to
	 * the client. It could be thought of as the opposite of
	 * {@link xajax::ParseObjXml()}.
	 * 
	 * @access private
	 * @param mixed data structure to serialize to XML
	 * @return string serialized XML
	 */
	function BuildObjXml($var) {
		if (gettype($var) == "object") $var = get_object_vars($var);
		if (!is_array($var)) {
			return "<![CDATA[$var]]>";
		}
		else {
			$data = "<xjxobj>";
			foreach ($var as $key => $value) {
				$data .= "<e>";
				$data .= "<k>" . htmlspecialchars($key) . "</k>";
				$data .= "<v>" . $this->BuildObjXml($value) . "</v>";
				$data .= "</e>";
			}
			$data .= "</xjxobj>";
			return $data;
		}
	}
	
}
