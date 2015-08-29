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
		$document = JFactory::getDocument();
		$document->addScriptDeclaration(
'MathJax.Hub.Config({
    tex2jax: {
      inlineMath: [ ["$","$"], ["\\\\(","\\\\)"] ],
      displayMath: [ ["$$","$$"], ["\\\\[","\\\\]"] ],
      processEscapes: true
    },
  });', "text/x-mathjax-config");
		// FIXME script defer work only in IE10+ (see http://caniuse.com/#search=defer ) but the bug should not affect this particular case
		$document->addScript("https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML", "text/javascript", true);
		// $document->addScript("https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=default");
		return true;
	}
}
?>