<?php
class CloneprojectPlugin extends MantisPlugin {

    function register() {
        $this->name        = 'Clone your projects';
        $this->description = 'Allows cloning of projects including all dependencies' ;
        $this->version     = '2.02';
        $this->requires    = array('MantisCore'       => '2.0.0',);
        $this->author      = 'Cas Nuy';
        $this->contact     = 'Cas.Nuy@stahl.com';
        $this->url         = 'http://www.nuy.info/mantis2';
		$this->page			= 'config';
    }
	
	function config() {
		return array(
			'clone_hierarchy'		=> ON,
			'clone_subprojects'		=> ON,
			'clone_categories'		=> ON,
			'clone_catactive'		=> ON,
			'clone_versions'		=> OFF,
			'clone_customfields'	=> ON,
			'clone_users'			=> ON,
		);
	}

    function init() {
		plugin_event_hook( 'EVENT_MANAGE_PROJECT_PAGE', 'clone_it' );
    }

    function clone_it($f_project_id) {
		include 'plugins/Cloneproject/pages/clone_project.php';;    
	}

}