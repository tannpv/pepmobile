<?php 
defined('_JEXEC') or die;
jimport('joomla.application.component.modellist');
class BpsmemberModelBpsmembers extends JModelList{
     protected $searchInFields = array('first_name','last_name','company_name');//),'someotherfieldtosearchin');
	 public function __construct($config = array()) {
                $config['filter_fields']=array_merge($this->searchInFields,array('first_name','last_name','company_name'));
                parent::__construct($config);
        }
    protected function getListQuery(){
       	$db = JFactory::getDBO();
		$query = $db->getQuery(true);		
		$query->select('*');	
		$query->from('#__bpsmember');
        $regex = str_replace(' ', '|', $this->getState('filter.search'));
        
        if (!empty($regex)) {
                $regex=' REGEXP '.$db->quote($regex);
                $query->where('('.implode($regex.' OR ',$this->searchInFields).$regex.')');
        }
      //  echo $query; exit;
		return $query;
    }
      public function populateState($ordering = null, $direction = null)
        {
                // Initialise variables.
                $app = JFactory::getApplication('administrator');
 
                // Load the filter state.
                $search = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
                //Omit double (white-)spaces and set state
                $this->setState('filter.search', preg_replace('/\s+/',' ', $search));
 
                parent::populateState('id', 'asc');
        }
        
    }