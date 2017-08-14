<?php
/*
 * extends the xmlrpc with "wpserver.favicon"
 * takes a single uri and returns a single favicon html code
 * 
 * dependencies: 
 * - /includes/class-xmlrpc.php : the abstract class it is based on
 * 
 */

namespace leau\co\wp_favicons_server;

if (!class_exists("\\leau\\co\\wp_favicons_server\\uri_xmlrpc"))
{

class uri_xmlrpc extends MasterXMLRPC {

	public function favicon($data){
				
		if (!isset($data["blog"]))
		return "Missing 'blog' parameter";

		if (!isset($data["text"]))
		return "Missing 'text' parameter";

		$blog = $data["blog"];
		$text = $data["text"];
		
			// get the icon, status and generate html code
		// return html code
		//return do_filter('xmlrpc_text', $text);
		$wp_favicon_the_content = new MetaData('module','plugin');
		$text = apply_filters( Config::GetPluginSlug() . 'xmlrpc_text', $text);
		
		return $text;
	}
}

}


