<?php
// no direct access
defined( '_JEXEC' ) or die;

class plgContentMathJoomla extends JPlugin
{
	/**
	 * Load the language file on instantiation. Note this is only available in Joomla 3.1 and higher.
	 * If you want to support 3.0 series you must override the constructor
	 *
	 * @var    boolean
	 * @since  3.1
	 */
	protected $autoloadLanguage = false;
 
	/**
	 * Plugin method with the same name as the event will be called automatically.
	 */
	// FIXME change event to sistem event like onAfterInitialise or similar
	function onContentPrepare($context, &$article, &$params, $page)
	{
		/*
		 * Plugin code goes here.
		 * You can access database and application objects and parameters via $this->db,
		 * $this->app and $this->params respectively
		 */
		// see https://api.joomla.org/cms-3/classes/JDocument.html#method_addScript
		//echo ("<pre>");
		//var_dump($this->params->get('version', 'non_impostata'));
		//echo ("</pre>");
		
		$version = $this->params->get("version", "latest");
		$configfile = $this->params->get("configfile");
		$https = $this->params->get("https");
		$inline_single_dollar = $this->params->get("inline_single_dollar");
		$inline_parenthesis = $this->params->get("inline_parenthesis");
		$inline_custom = $this->params->get("inline_custom");
		$inline_custom_open = $this->params->get("inline_custom_open");
		$inline_custom_close = $this->params->get("inline_custom_close");
		$display_double_dollar = $this->params->get("display_double_dollar");
		$display_parenthesis = $this->params->get("display_parenthesis");
		$display_custom = $this->params->get("display_custom");
		$display_custom_open = $this->params->get("display_custom_open");
		$display_custom_close = $this->params->get("display_custom_close");
		
		
		$inline = array();
		
		if ($inline_single_dollar) {
			$inline[] = [ '$', '$' ];
		}
		if ($inline_parenthesis) {
			$inline[] = [ '\\(', '\\)' ];
		}
		if ($inline_custom && !empty($inline_custom_open) && !empty($inline_custom_close)) {
			$inline[] = [ $inline_custom_open, $inline_custom_close ];
		}
		
		$display = array();
		
		if ($display_double_dollar) {
			$display[] = [ '$$', '$$' ];
		}
		if ($display_parenthesis) {
			$display[] = [ '\\[', '\\]' ];
		}
		if ($display_custom && !empty($display_custom_open) && !empty($display_custom_close)) {
			$display[] = [ $display_custom_open, $display_custom_close ];
		}
		
		// echo ("<pre>");
		// var_dump(json_encode($display));
		// echo ("</pre>");
		
		$document = JFactory::getDocument();
		$document->addScriptDeclaration(
'MathJax.Hub.Config({
    tex2jax: {
      inlineMath: '.json_encode($inline).',
      displayMath: '.json_encode($display).',
      processEscapes: true
    },
  });', "text/x-mathjax-config");
		// FIXME script defer work only in IE10+ (see http://caniuse.com/#search=defer ) but the bug should not affect this particular case
		
		// see http://docs.mathjax.org/en/latest/configuration.html#configuring-mathjax-after-it-is-loaded
		$cdn_url = "";
		if ($https) {
			$cdn_url = "https:";
		}
		$cdn_url .= "//cdn.mathjax.org/mathjax/" . $version . "/MathJax.js?config=" . $configfile;
		$document->addScript($cdn_url, "text/javascript", true);
		// $document->addScript("https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML", "text/javascript", true);
		// $document->addScript("https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=default");
		return true;
	}
}
?>