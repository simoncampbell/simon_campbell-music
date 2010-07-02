<?php

if ( ! defined('EXT'))
{
    exit('Invalid file request');
}

/** -----------------------------------
/*	 Successor to my original 'Spam Prevention' extension originally released in Jan 2006.
/*
/*	 @package		ExpressionEngine
/*	 @category		Extensions
/*	 @author		Paul Burdick
/*	 @copyright		Copyright (c) 2007, pMachine, Inc.
/*	 @link			http://www.expressionengine.com
/*	 @since			Version 1.1
/*	 @filesource
/*
/*	 Provides three additional spam prevention methods to the comment submission routine.
/*
/*   Version 1.1
		- Added disable_extension() method
		- Added pMachine.com Blackist download ability and settings (will NOT write .htaccess)
/** -----------------------------------*/



class Comment_spam_prevention
{
	var $settings		= array();
	
	var $name			= 'Comment Spam Prevention';
	var $version		= '1.1';
	var $description	= 'Extra spam prevention for comments';
	var $settings_exist	= 'y';
	var $docs_url		= '';
	
	var $check_interval = 7; // Interval in days between pMachine.com Blacklist checks
	
	/** -------------------------------
	/**  Constructor
	/** -------------------------------*/
	
	function Comment_spam_prevention($settings='')
	{
		$this->settings = $settings;
	}
	/* END */
	
	
	/** --------------------------------
    /**  Prevent Spam - Called by Extension Hook
    /** --------------------------------*/
    
    function prevent_spam()
    {
    	global $DB, $EXT, $OUT, $IN, $LANG, $PREFS, $SESS, $LOC;
    	
		/** --------------------------------
		/**  Download pMachine.com Blacklist, Sir?
		/** --------------------------------*/
    	
    	if ($this->settings['download_pmachine_blacklist'] == 'y')
    	{
    		$check = FALSE;
    		
    		if ($this->settings['pmachine_blacklist_next'] == '')
    		{
    			$check = TRUE;
    		}
    		else
    		{
    			$time = $LOC->convert_human_date_to_gmt($this->settings['pmachine_blacklist_next']);
    			
    			if ($time == FALSE OR ! is_numeric($time) OR $LOC->now > $time)
    			{
    				$check = TRUE;
    			}
    		}
    		
    		if ($check === TRUE)
    		{
    			// Retrieve and Store pMachine.com Blacklist Through XML-RPC
    			$this->retrieve_pmachine_blacklist();
    			
    			// Check this request against Blacklist using Input class method
    			$IN->check_blacklist();
    			
    			// Reset Time for Next Week
    			
    			$this->settings['pmachine_blacklist_next'] = $LOC->set_human_time($LOC->now + (60 * 60 * 24 * $this->check_interval));
    			
				$DB->query("UPDATE exp_extensions SET settings = '".addslashes(serialize($this->settings))."'  
    						WHERE class = '".$DB->escape_str(ucfirst(get_class($this)))."'");
    		}
    	}
    	
		/** --------------------------------
		/**  SuperAdmins Are Free From Checks, They Are Invincible!
		/** --------------------------------*/
		
    	if ($SESS->userdata['group_id'] == '1')
    	{
    		return;
    	}
    	
    	
		/** --------------------------------
		/**  Find URLs in the Comment Data
		/** --------------------------------*/

    	$domains = array('net','com','org','info', 'name','biz','us','de', 'uk', 'ru');
    	
    	if (preg_match_all("/([f|ht]+tp(s?):\/\/[a-z0-9@%_.~#\/\-\?&=]+.)".
    					   "|(www.[a-z0-9@%_.~#\-\?&]+.)".
    					   "|([a-z0-9@%_~#\-\?&]*\.(".implode('|', $domains)."))/si", 
    					   $_POST['comment'], $matches))
    	{
    		/** --------------------------------
    		/**  Maximum # of URLs check
    		/** --------------------------------*/
    		
    		if (sizeof($matches['0']) > $this->settings['number_urls'])
    		{
    			$EXT->end_script = TRUE;
    			return $OUT->show_user_error('general', array($LANG->line('not_authorized')));
    		}
    		
    		/** --------------------------------
    		/**  Blacklist Check
    		/** --------------------------------*/
    		
    		if (trim($this->settings['cblacklist']) != '')
    		{
    			$blacklist_values = preg_split("/\s+/", $this->settings['cblacklist']);
    			
    			for($i = 0; $i < sizeof($matches['0']); $i++)
    			{
    				foreach($blacklist_values as $bad_url)
					{
						if ($bad_url != '')
						{
							if (substr($bad_url, 0, 5) == 'grep:')
							{
								continue;
							}
							elseif(stristr($matches['0'][$i], $bad_url) !== FALSE)
							{
								$EXT->end_script = TRUE;
    							return $OUT->show_user_error('general', array($LANG->line('not_authorized')));
    						}
						}
					}
    			}
    		}
    	}
    	
    	/** --------------------------------
		/**  Grep Comment Blacklist Check
		/** --------------------------------*/
	
    	if ( ! isset($blacklist_values))
    	{
    		$blacklist_values = preg_split("/\s+/", $this->settings['cblacklist']);
    	}

		foreach($blacklist_values as $bad_url)
		{
			// We allow grep searches (because Chris wants 'em)
			// But they have to be given a prefix of 'grep:' so that
			// we know to treat them thus and they are checked against
			// the original comment POST value
			
			if (substr($bad_url, 0, 5) == 'grep:')
			{
				if (preg_match(substr($bad_url, 5), $_POST['comment'], $naughties))
				{
					$EXT->end_script = TRUE;
					return $OUT->show_user_error('general', array($LANG->line('not_authorized')));
				}
			}
		}
    	
    	/** --------------------------------
    	/**  Minimum Load Time Check
    	/** --------------------------------*/
    	
    	if ($this->settings['min_load_time'] != 0 && $PREFS->ini('secure_forms') == 'y')
        {
            $query = $DB->query("SELECT date FROM exp_security_hashes 
            					 WHERE hash='".$DB->escape_str($_POST['XID'])."' 
            					 AND ip_address = '".$IN->IP."'");
            
            if ($query->num_rows == 0 OR 
            	($query->row['date'] + round($this->settings['min_load_time'])) >= time())
            {
            	$EXT->end_script = TRUE;
    			return $OUT->show_user_error('general', array($LANG->line('not_authorized')));
            }
		}
    }
    /* END */
    
    
    
	/** ---------------------------------
    /**  Retrieve pMachine.com Blacklist and Process
    /** ---------------------------------*/
    
    function retrieve_pmachine_blacklist()
    {
    	global $DB, $PREFS, $STAT;
    	
        if ( ! $DB->table_exists('blacklisted'))
        {
			return FALSE;
        }
        
        if ( ! $DB->table_exists('whitelisted'))
        {
			return FALSE;
        }   
        
        if ( ! class_exists('XML_RPC'))
		{
			require PATH_CORE.'core.xmlrpc'.EXT;
		}
		                
        
        /** -----------------------------------------
        /**  Get Current Black List from pMachine.com
        /** -----------------------------------------*/
        
        if ( ! $license = $PREFS->ini('license_number'))
        {
        	return FALSE;
        }
        
        $client = new XML_RPC_Client('/blacklists.php','ping.pmachine.com','80');
        $message = new XML_RPC_Message('blacklists.referrer',array(new XML_RPC_Values($license)));

        if ( ! $result = $client->send($message))
        {
        	return FALSE;
        }        
       
        if ( ! is_object($result->val))
        {
        	return FALSE;
        }
        
        // Array of our returned info        
        $remote_info = $result->decode();
        
        if ($remote_info['flerror'] != 0)
        {
        	return FALSE; 	
        }
        
        $new['url'] 	= ( ! isset($remote_info['urls']) || sizeof($remote_info['urls']) == 0) 	? array() : explode('|',$remote_info['urls']);
        $new['agent'] 	= ( ! isset($remote_info['agents']) || sizeof($remote_info['agents']) == 0) ? array() : explode('|',$remote_info['agents']);   
        $new['ip'] 		= ( ! isset($remote_info['ips']) || sizeof($remote_info['ips']) == 0) 		? array() : explode('|',$remote_info['ips']);        
        
        /** -----------------------------------------
        /**  Add Current Blacklisted
        /** -----------------------------------------*/
        
        $query			= $DB->query("SELECT * FROM exp_blacklisted");
        $old['url']		= array();
        $old['agent']	= array();
        $old['ip']		= array();
        
        if ($query->num_rows > 0)
        {
        	foreach($query->result as $row)
        	{
        		$old_values = explode('|',$row['blacklisted_value']);
        		for ($i=0; $i < sizeof($old_values); $i++)
        		{
        			$old[$row['blacklisted_type']][] = $old_values[$i]; 
        		}       	
        	}
        }
        
        /** -----------------------------------------
        /**  Current Whitelisted
        /** -----------------------------------------*/
        
        $query				= $DB->query("SELECT * FROM exp_whitelisted");
        $white['url']		= array();
        $white['agent']		= array();
        $white['ip']		= array();
        
        if ($query->num_rows > 0)
        {
        	foreach($query->result as $row)
        	{
        		$white_values = explode('|',$row['whitelisted_value']);
        		for ($i=0; $i < sizeof($white_values); $i++)
        		{
        			if (trim($white_values[$i]) != '')
        			{
        				$white[$row['whitelisted_type']][] = $white_values[$i]; 
        			}
        		}       	
        	}
        }
        
        
        /** -----------------------------------------
        /**  Check for uniqueness and sort
        /** -----------------------------------------*/
        
        $new['url'] 	= array_unique(array_merge($old['url'],$new['url']));
        $new['agent']	= array_unique(array_merge($old['agent'],$new['agent']));
        $new['ip']		= array_unique(array_merge($old['ip'],$new['ip']));
        
        sort($new['url']);
        sort($new['agent']);
        sort($new['ip']); 
        
        
        /** -----------------------------------------
		/**  Put blacklist info back into database
		/** -----------------------------------------*/
		
		$DB->query("DELETE FROM exp_blacklisted");
		
		foreach($new as $key => $value)
		{
			$blacklisted_value = implode('|',$value);
			
			$data = array(	'blacklisted_type' 	=> $key,
							'blacklisted_value'	=> $blacklisted_value);
								
			$DB->query($DB->insert_string('exp_blacklisted', $data));
		}
		
		/** ----------------------------------------------
		/**  Using new blacklist members, clean out spam
		/** ----------------------------------------------*/
		
		$new['url']		= array_diff($new['url'], $old['url']);
		$new['agent']	= array_diff($new['agent'], $old['agent']);
        $new['ip']		= array_diff($new['ip'], $old['ip']);
        
        $modified_weblogs = array();
        
        foreach($new as $key => $value)
		{
			sort($value);
			$name = ($key == 'url') ? 'from' : $key; 
			
			if (sizeof($value) > 0)
			{
				for($i=0; $i < sizeof($value); $i++)
				{
					if ($value[$i] != '')
					{
						$sql = "DELETE FROM exp_referrers WHERE ref_{$name} LIKE '%{$value[$i]}%' ";
						
						if (sizeof($white[$key]) > 1)
						{
							$sql .=  " AND ref_{$name} NOT LIKE '%".implode("%' AND ref_{$name} NOT LIKE '%", $white[$key])."%'";
						}
						elseif (sizeof($white[$key]) > 0)
						{
							$sql .= "AND ref_{$name} NOT LIKE '%".$white[$key]['0']."%'";
						}					
					
						$DB->query($sql);
						
						if ($key == 'url' OR $key == 'ip')
						{
							$sql = " exp_trackbacks WHERE trackback_".$key." LIKE '%{$value[$i]}%'";
							
							if (sizeof($white[$key]) > 1)
							{
								$sql .=  " AND trackback_".$key." NOT LIKE '%".implode("%' AND trackback_".$key." NOT LIKE '%", $white[$key])."%'";
							}
							elseif (sizeof($white[$key]) > 0)
							{
								$sql .= "AND trackback_".$key." NOT LIKE '%".$white[$key]['0']."%'";
							}
							
							$query = $DB->query("SELECT entry_id, weblog_id FROM".$sql);
							
							if ($query->num_rows > 0)
							{
								$DB->query("DELETE FROM".$sql);
							
								foreach($query->result as $row)
								{
									$modified_weblogs[] = $row['weblog_id'];
									
									$results = $DB->query("SELECT COUNT(*) AS count from exp_trackbacks WHERE entry_id = '".$row['entry_id']."'");
									$results2 = $DB->query("SELECT trackback_date FROM exp_trackbacks WHERE entry_id = '".$row['entry_id']."' ORDER BY trackback_date desc LIMIT 1");
            						$date = ($results2->num_rows == 0) ? 0 : $results2->row['trackback_date'];
            						
									$DB->query("UPDATE exp_weblog_titles 
												SET trackback_total = '".$results->row['count']."',
												recent_trackback_date = '{$date}'
												WHERE entry_id = '".$row['entry_id']."'");									
								}							
							}
						}
					}			
				}
			}
		}
		
		if (isset($modified_weblogs) && sizeof($modified_weblogs) > 0)
        {
        	$modified_weblogs = array_unique($modified_weblogs);
        	
        	foreach($modified_weblogs as $weblog_id)
        	{
        		$STAT->update_trackback_stats($weblog_id);
        	}
        }
        
        return TRUE;
    }
    /* END */
    
    
    /** --------------------------------
    /**  Activate Extension
    /** --------------------------------*/
    
    function activate_extension()
    {
    	global $DB;
    	
    	$default_settings = serialize(array('number_urls' 					=> '2',
    										'min_load_time' 				=> '8',
    										'cblacklist' 					=> '',
    										'download_pmachine_blacklist'	=> 'n',
    										'pmachine_blacklist_next'		=> ''));
    										
    	$data = array('extension_id'	=> '',
    				  'class'			=> "Comment_spam_prevention",
    				  'method'			=> "prevent_spam",
    				  'hook'			=> "insert_comment_start",
    				  'settings'		=> $default_settings,
    				  'priority'		=> 10,
    				  'version'			=> $this->version,
    				  'enabled'			=> "y");
    	
    	$DB->query($DB->insert_string('exp_extensions', $data));
    }
    /* END */
    
    
	/** --------------------------------
    /**  Settings
    /** --------------------------------*/
    
    function settings()
    {
    	global $PREFS;
    	
    	$settings = array();
    	
    	$settings['number_urls']				 = '2';
    	$settings['min_load_time']				 = '8';
    	$settings['cblacklist']					 = array('t', "");
    	$settings['download_pmachine_blacklist'] = array('r', array('y' => 'yes', 'n' => 'no'), 'n');
    	$settings['pmachine_blacklist_next'] 	 = '';
    	
    	return $settings;
    }
    /* END */
    
	/** --------------------------------
    /**  Settings
    /** --------------------------------*/
    
	function disable_extension()
	{
		global $DB;
		
		$DB->query("DELETE FROM exp_extensions WHERE class = '".$DB->escape_str(ucfirst(get_class($this)))."'");
	}
	/* END */

    /** --------------------------------
    /**  Update Extension
    /** --------------------------------*/
    
    function update_extension($current='')
    {
    	global $DB, $REGX;
    	
    	if ($current == '' OR $current == $this->version)
    	{
    		return FALSE;
    	}
    	
		if ( ! is_array($this->settings))
		{
			$query = $DB->query("SELECT settings FROM exp_extensions WHERE class = '".$DB->escape_str(ucfirst(get_class($this)))."'");
			
			$this->settings = $REGX->array_stripslashes(unserialize($query->row['settings']));
		}
		
    	/** --------------------------------------*/
    	/**  Version 1.1 Upgrade.  Added Two New Settings
    	/** --------------------------------------*/
    	
    	if ($current < '1.1')
    	{
			$settings['download_pmachine_blacklist'] = 'n';
			$settings['pmachine_blacklist_next'] 	 = '';
    	
    		$DB->query("UPDATE exp_extensions SET settings = '".addslashes(serialize($this->settings))."'  
    					WHERE class = '".$DB->escape_str(ucfirst(get_class($this)))."'");
    	}
    	
		/** --------------------------------------*/
    	/**  Update Version Number
    	/** --------------------------------------*/
    	
    	$DB->query("UPDATE exp_extensions  SET version = '".$DB->escape_str($this->version)."'  
    				WHERE class = '".$DB->escape_str(ucfirst(get_class($this)))."'");
    }
    /* END */


}
// END Class

?>