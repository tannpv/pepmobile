<?php 
// No direct access allowed to this file
defined( '_JEXEC' ) or die( 'Restricted access' );

// Import Joomla! Plugin library file
jimport('joomla.plugin');

//The Content plugin MakePlugIn
class plgContentPaymentActiveButton extends JPlugin
{
    public function __construct(& $subject, $config)
{
        parent::__construct($subject, $config);
        $this->loadLanguage();
}
    function PaymentActiveButton (&$subject)
    {
        parent::__construct ($subject);
    }
    function activeGolfPayment ()
     {
    $app = JFactory::getApplication();
    $param = $this->params->get('payment_golf');
    if($param==1){
        return true;
    }
    return false ;
    }
    function activeReversePayment ()
     {
    $app = JFactory::getApplication();
    $param = $this->params->get('payment_Reverse');
    if($param==1){
        return true;
    }
    return false ;
    }
    function activeBreakfastPayment ()
     {
    $app = JFactory::getApplication();
    $param = $this->params->get('payment_breakfast');
    if($param==1){
        return true;
    }
    return false ;
    }
}
?>