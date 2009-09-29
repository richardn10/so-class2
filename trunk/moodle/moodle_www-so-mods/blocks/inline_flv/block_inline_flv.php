<?php
class block_inline_flv extends block_base {
  
  function init() {
    $this->title   = 'Inline FLV'; //get_string('Inline FLV', 'block_inline_flv');
    $this->version = 200909200920;
  }
  
  function get_content() {
  	global $CFG;
    
  	// TODO: need to implement this properly really.
  	//       For the time being, this is working so just generate the content each time.
  	//
  	//if ($this->content !== NULL) {
    //  return $this->content;
    //}
    
  	if (empty($this->config->flvName)) {
  		// A blank value would cause the block to be hidden.
  		$flvDiv = '<strong>No FLV video file specified</strong>';
  	} else {
  		if (!file_exists($CFG->dataroot_so_data.'/'.$this->config->flvName.'.flv')) {
  			$flvDiv = "<strong>FLV video file '".$this->config->flvName."' doesn't exist</strong>";
  		} else {
  			$flvDiv = '<div class="so_flv" rel="'.$this->config->flvName.'"></div>';
  		}
  	}
 	
    $this->content = new stdClass;
    $this->content->flvName = '';
    $this->content->text = $flvDiv;
    $this->content->footer = '';
 
    return $this->content;
  }
  
	function specialization() {
	  if (!empty($this->config->title)) {
	    $this->title = $this->config->title;
	  } else {
	    $this->config->title = 'Some title ...';
	  }
	  
	  // Will allow the block to be hidden if no flv specified.
	  if (empty($this->config->flvName) ){
	    $this->config->flvName = NULL;
	  }
	}
	
	function hide_header() {
	  return false;
	}
  
	function instance_allow_config() {
	  return true;
	}
	
	function instance_allow_multiple() {
	  return true;
	}
	
	// Allows this block to be added to 'all' modules (specifically lessons for us!).
	//
    function applicable_formats() {
        return array('all' => true, 'my' => false, 'tag' => false);
    }
}
?>