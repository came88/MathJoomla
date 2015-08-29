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
		JFactory::getDocument()->addScript("https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML");
		return true;
	}
}
?>