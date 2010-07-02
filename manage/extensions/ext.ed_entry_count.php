<?php if ( ! defined('EXT')) exit('Invalid file request');

/**
* Entry Count
* ---------------
* Provides global variables containing the entry counts for weblog entries by status
*
* @package  entry-count-extension
* @version  1.0.1
* @author   Glen Swinfield (Erskine Design)
*/
class Ed_entry_count
{
    public $version = '1.0.1';
    
    public function Ed_entry_count( $settings = '' )
    {
        $this->settings = $settings;
    }
    
    public function entry_count()
    {
        global $DB, $IN, $PREFS;
        
        if (REQ != 'PAGE') return;
        
        $site_id = $PREFS->ini('site_id');
        
        $sql = "SELECT CONCAT('count_',w.blog_name, '_', LOWER(REPLACE(wt.status,' ','_'))) as name, count(*) as cnt FROM exp_weblogs w, exp_weblog_titles wt
                WHERE w.weblog_id = wt.weblog_id
                AND wt.site_id = '{$site_id}'
                GROUP BY w.blog_name, wt.status";
                
        $result = $DB->query( $sql );
        $flat = array();
        foreach( $result as $r ) {
            $flat[$r['name']] = $r['cnt'];
        }
        
        $IN->global_vars = array_merge($IN->global_vars,$flat);
    }
    
    // --------------------------------
    //  Activate Extension
    // --------------------------------
    function activate_extension()
    {
        global $DB, $PREFS;
        
        $DB->query(
            $DB->insert_string(
                'exp_extensions',
                array(
                    'extension_id' => '',
                    'class'        => __CLASS__,
                    'method'       => "entry_count",
                    'hook'         => "sessions_end",
                    'settings'     => '',
                    'priority'     => 1,
                    'version'      => $this->version,
                    'enabled'      => "y"
                )
            )
        ); // end db->query
    }
     
     
    // --------------------------------
    //  Update Extension
    // --------------------------------  
    function update_extension($current='')
    {
        global $DB, $PREFS;
        
        if ($current == '' OR $current == $this->version)
        {
            return FALSE;
        }
        
        $DB->query("UPDATE exp_extensions SET version = '".$DB->escape_str($this->version)."' WHERE class = '".__CLASS__."'");
    }

    // --------------------------------
    //  Disable Extension
    // --------------------------------
    function disable_extension()
    {
        global $DB, $PREFS;
        
        $DB->query("DELETE FROM exp_extensions WHERE class = '".__CLASS__."'");
    }
}
?>