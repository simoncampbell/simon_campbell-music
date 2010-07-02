<?php

/*
=====================================================
System Messages Extension for ExpressionEngine
-----------------------------------------------------
http://www.brianlitzinger.com
=====================================================
*/

if ( ! defined('EXT')) {
    exit('Invalid file request'); }

class System_messages {

    var $settings       = array();
    var $name           = 'Custom System Messages';
    var $class_name     = 'System_messages';
    var $version        = '1.0.2';
    var $description    = 'Let\'s you override all system error messages.';
    var $settings_exist = 'y';
    var $source = 'http://www.brianlitzinger.com/assets/downloads/version_check/versions.xml';

    //
    // Constructor
    //
    function System_messages() {}
    
    //
    // Add hooks to database
    //
    function activate_extension()
    {
        global $DB;

        // Delete old hooks
        $DB->query("DELETE FROM exp_extensions WHERE class = '". $this->class_name ."'");
        
        // Add new hooks
        $ext_template = array(
            'class'    => $this->class_name,
            'settings' => '',
            'priority' => 1,
            'version'  => $this->version,
            'enabled'  => 'y'
        );
        
        $extensions = array(
            array('hook'=>'output_show_message', 'method'=>'output_show_message'),
            array('hook'=>'sessions_start', 'method'=>'extend_output_class')
        );
        
        foreach($extensions as $extension)
        {
            $ext = array_merge($ext_template, $extension);
            $DB->query($DB->insert_string('exp_extensions', $ext));
        }       
    }

    /**
     * No updates yet.
     * Manual says this function is required.
     * @param string $current currently installed version
     */
    function update_extension($current = '') {}

    /**
     * Uninstalls extension
     */
    function disable_extension() {
        global $DB;
        $DB->query("DELETE FROM exp_extensions WHERE class = '" . $this->class_name. "'");
    }
    
    function extend_output_class()
    {
        global $OUT;
        $OUT = new System_Messages_Output;
    }
    
    function output_show_message($data)
    {        
        global $DB, $PREFS, $OUT, $TMPL, $IN;

        // Don't want to override control panel errors, that could 
        // be bad, or just a pain in the butt to manage.
        if($IN->GBL('C') != "admin")
        {
            // Only create a new instance of TMPL if it doesn't exist. 
            // In most cases, this will happen, however, the Forum module
            // Already has an instance of it created.
            if( ! class_exists('Template')) 
            {
                require PATH_CORE.'core.template'.EXT;
                $TMPL = new Template();
            }
            
            $settings = $this->_get_settings();
            
            if(!isset($settings['general_template']) AND !isset($settings['submission_template'])) 
            {
                return $OUT->show_user_error('general', array($LANG->line('error_no_template')));
            }
            
            if($data['type'] == 'submission')
            {
                $template = explode('/', $settings['submission_template']);
            } 
            else
            {
                $template = explode('/', $settings['general_template']);
            }
            

            $query = $DB->query("SELECT g.group_name, t.template_name
                                FROM exp_template_groups g, exp_templates t
                                WHERE g.group_id = t.group_id
                                AND g.site_id = '".$DB->escape_str($PREFS->ini('site_id'))."'
                                AND template_name = '".$DB->escape_str($template[1])."'");
                                
            if($query->num_rows == 0) 
            {
                return $OUT->show_user_error('general', array($LANG->line('error_not_found')));
            }
            
            // Lets add some additional variables to the page
            $data['referrer'] = $_SERVER['HTTP_REFERER'];
            
            // Parse the template
            $TMPL->run_template_engine($template[0], $template[1]);
            
            // Replace our template variables
            foreach ($data as $key => $val)
            {
                // Since we can control this page now, lets provide more options :)
                if($key == 'link')
                {
                    $pattern = "/<a(.*)>(.*)<\/a>/";
                    preg_match_all($pattern, $val, $matches);

                    switch($settings['accessiblity'])
                    {
                        case 'both':
                            $val .= '<noscript><a href="'. $_SERVER['HTTP_REFERER'] .'">'. $matches[2][0] .'</a></noscript>';
                        break;
                        case 'referrer':
                            $val = '<a href="'. $_SERVER['HTTP_REFERER'] .'">'. $matches[2][0] .'</a>';
                        break;
                    }
                }
                $TMPL->final_template = str_replace('{'.$key.'}', $val, $TMPL->final_template);
            }

            $OUT->display_final_output($TMPL->final_template);
            
            exit;
        }
    }
    
    
    /**
     * Settings Form
     *
     * Construct the custom settings form.
     *
     * Look and feel based on LG Addon Updater's settings form.
     *
     * @param  array   $current   Current extension settings (not site-specific)
     * @see    http://expressionengine.com/docs/development/extensions.html#settings
     * @author Leevi Graham <http://leevigraham.com>
     * @since  version 1.0.0
     */
    function settings_form($current)
    {
        global $DB, $DSP, $LANG, $IN, $PREFS;

        $settings = $this->_get_settings();

        // Form Header

        $DSP->crumbline = TRUE;

        $DSP->title  = $LANG->line('extension_settings');
        $DSP->crumb  = $DSP->anchor(BASE.AMP.'C=admin'.AMP.'area=utilities', $LANG->line('utilities')).
                                   $DSP->crumb_item($DSP->anchor(BASE.AMP.'C=admin'.AMP.'M=utilities'.AMP.'P=extensions_manager', $LANG->line('extensions_manager')));
        $DSP->crumb .= $DSP->crumb_item($this->name);

        $DSP->right_crumb($LANG->line('disable_extension'), BASE.AMP.'C=admin'.AMP.'M=utilities'.AMP.'P=toggle_extension_confirm'.AMP.'which=disable'.AMP.'name='.$IN->GBL('name'));

        $DSP->body = '';

        $DSP->body .= $DSP->heading("$this->name <small>$this->version</small>");

        $DSP->body .= $DSP->form_open(
                                    array(
                                            'action' => 'C=admin'.AMP.'M=utilities'.AMP.'P=save_extension_settings',
                                                                                    'name' => 'settings_messages',
                                                                                    'id' => 'settings_messages'
                                                                    ),
                                    array('name' => $this->class_name)
                                );

        $DSP->body .= $DSP->table_open(
                                           array(
                                               'class'  => 'tableBorder',
                                               'border' => '0',
                                               'style' => 'margin-top:18px; width:100%'
                                           )
                                       );

        $DSP->body .= $DSP->tr()
                    . $DSP->td('tableHeading', '', '2')
                    . $LANG->line("check_for_extension_updates_title")
                    . $DSP->td_c()
                    . $DSP->tr_c();

        $DSP->body .= $DSP->tr()
                    . $DSP->td('', '', '2')
                    . '<div class="box" style="border-width:0 0 1px 0; margin:0; padding:10px 5px"><p>'.$LANG->line('check_for_extension_updates_info').'</p></div>'
                    . $DSP->td_c()
                    . $DSP->tr_c();

        $DSP->body .= $DSP->tr()
                    . $DSP->td('tableCellOne', '60%')
                    . $DSP->qdiv('defaultBold', $LANG->line("check_for_extension_updates_label"))
                    . $DSP->td_c();

        $DSP->body .= $DSP->td('tableCellOne')
                    . '<select name="check_for_extension_updates">'
                    . $DSP->input_select_option('y', $LANG->line('yes'), ($settings['check_for_extension_updates'] == 'y' ? 'y' : ''))
                    . $DSP->input_select_option('n', $LANG->line('no'),  ($settings['check_for_extension_updates'] != 'y' ? 'y' : ''))
                    . $DSP->input_select_footer()
                    . $DSP->td_c()
                    . $DSP->tr_c();

        $DSP->body .= $DSP->table_c();
        
        //
        // Template select
        //
        $DSP->body .= $DSP->table_open(
                           array(
                               'class'  => 'tableBorder',
                               'border' => '0',
                               'style' => 'margin-top:18px; width:100%'
                           )
                       );
                       
       $DSP->body .= $DSP->tr()
                   . $DSP->td('tableHeading', '', '2')
                   . $LANG->line("select_template_title")
                   . $DSP->td_c()
                   . $DSP->tr_c();
                                       
       $DSP->body .= $DSP->tr()
                   . $DSP->td('tableCellOne', '60%')
                   . $DSP->qdiv('defaultBold', $LANG->line("select_template_submission"))
                   . $DSP->td_c()

                    .$DSP->td('tableCellOne')
                    . '<select name="submission_template">';
                    
                    $DSP->body .= $DSP->input_select_option('', '- Select -', '');
        
                    $templates = $this->_get_templates();
                    foreach($templates->result as $template) {
                        $file = $template['group_name'] .'/'. $template['template_name'];
                        $DSP->body .= $DSP->input_select_option(
                            $file, $file, (isset($settings['submission_template']) AND $settings['submission_template'] == $file ? 'y' : '')
                        );
                    }
                    
         $DSP->body .= '</select>'
                    . $DSP->td_c()
                    . $DSP->tr_c()
                    
                    . $DSP->tr()
                    . $DSP->td('tableCellOne', '60%')
                    . $DSP->qdiv('defaultBold', $LANG->line("select_template_general"))
                    . $DSP->td_c()

                    . $DSP->td('tableCellOne')
                    . '<select name="general_template">';
                    
                    $DSP->body .= $DSP->input_select_option('', '- Select -', '');

                    $templates = $this->_get_templates();
                    foreach($templates->result as $template) {
                        $file = $template['group_name'] .'/'. $template['template_name'];
                        $DSP->body .= $DSP->input_select_option(
                            $file, $file, (isset($settings['general_template']) AND $settings['general_template'] == $file ? 'y' : '')
                        );
                    }

         $DSP->body .= '</select>'
                    . $DSP->td_c()
                    . $DSP->tr_c()
                    . $DSP->table_c();
                    
        //
        // Accessibility
        //
        $DSP->body .= $DSP->table_open(
                           array(
                               'class'  => 'tableBorder',
                               'border' => '0',
                               'style' => 'margin-top:18px; width:100%'
                           )
                       );

       $DSP->body .= $DSP->tr()
                   . $DSP->td('tableHeading', '', '2')
                   . $LANG->line("accessibility_title")
                   . $DSP->td_c()
                   . $DSP->tr_c();

       $DSP->body .= $DSP->tr()
                   . $DSP->td('tableCellOne', '60%')
                   . $DSP->qdiv('defaultBold', $LANG->line("accessibility_description"))
                   . $DSP->td_c();

        $DSP->body .= $DSP->td('tableCellOne')
                    . '<select name="accessiblity">';
                    
                    $options = array(
                        'default' => $LANG->line("accessibility_option_default"),
                        'referrer' => $LANG->line("accessibility_option_referrer"),
                        'both' => $LANG->line("accessibility_option_both")
                    );
                    
                    foreach($options as $value => $title) {
                        $DSP->body .= $DSP->input_select_option(
                            $value, $title, (isset($settings['accessiblity']) AND $settings['accessiblity'] == $value ? 'y' : '')
                        );
                    }

         $DSP->body .= '</select>'        
                    . $DSP->td_c()
                    . $DSP->tr_c()
                    . $DSP->table_c();
                    
        


        // Close Form

        $DSP->body .= $DSP->qdiv('itemWrapperTop', $DSP->input_submit())
                    . $DSP->form_c();
    }
    

    function _get_templates()
    {
        global $DB, $PREFS;
        
        // Get the current Site ID
        $site_id = $PREFS->ini('site_id');
        
        // Borrowed from TBK Template Select
        $sql = "SELECT tg.group_name, t.template_name
                FROM exp_template_groups tg, exp_templates t
                WHERE tg.group_id = t.group_id
                AND tg.site_id = '".$site_id."' ";
                      
        if (USER_BLOG == TRUE)
        {
            $sql .= "AND tg.group_id = '".$SESS->userdata['tmpl_group_id']."' ";
        }
        else
        {
            $sql .= "AND tg.is_user_blog = 'n' ";
        }

        return $DB->query($sql." ORDER BY tg.group_name, t.template_name");
    }
 
    
    function save_settings()
    {
        // make somethings global
        global $DB, $IN, $PREFS, $REGX, $SESS;

        $default_settings = array();

        // merge the defaults with our $_POST vars
        $_POST = array_merge($default_settings, $_POST);

        // unset the name
        unset($_POST['name']);

        // load the settings from cache or DB
        // force a refresh and return the full site settings
        $settings = $this->_get_settings(TRUE, TRUE);

        // add the posted values to the settings
        $settings[$PREFS->ini('site_id')] = $_POST;

        // update the settings
        $query = $DB->query($sql = "UPDATE exp_extensions SET settings = '" . addslashes(serialize($settings)) . "' WHERE class = '" . get_class($this) . "'");
    }
    
    /**
     * Register a New Addon Source
     *
     * @param  array   $sources   The existing sources
     * @return array              The new source list
     * @see    http://leevigraham.com/cms-customisation/expressionengine/lg-addon-updater/
     * @author Leevi Graham <http://leevigraham.com>
     * @since  version 1.0.0
     */
    function register_my_addon_source($sources)
    {
        global $EXT;
    
        // Check if we're not the only one using this hook
        if($EXT->last_call !== FALSE)
            $sources = $EXT->last_call;

        // add a new source
        // must be in the following format:
        /*
        <versions>
            <addon id='LG Addon Updater' version='2.0.0' last_updated="1218852797" docs_url="http://leevigraham.com/" />
        </versions>
        */
        if(( ! isset($this->settings['check_for_extension_updates'])) OR $this->settings['check_for_extension_updates'] == 'y')
        {
            $sources[] = $this->source;
        }
        return $sources;

    }

    /**
     * Register a New Addon
     *
     * @param  array   $addons   The existing sources
     * @return array             The new addon list
     * @see    http://leevigraham.com/cms-customisation/expressionengine/lg-addon-updater/
     * @author Leevi Graham <http://leevigraham.com>
     * @since  version 1.0.0
     */
    function register_my_addon_id($addons)
    {
        global $EXT;
    
        // Check if we're not the only one using this hook
        if($EXT->last_call !== FALSE)
            $addons = $EXT->last_call;

        // add a new addon
        // the key must match the id attribute in the source xml
        // the value must be the addons current version
        if(( ! isset($this->settings['check_for_extension_updates'])) OR $this->settings['check_for_extension_updates'] == 'y')
        {
            $addons['system_messages'] = $this->version;
        }
        return $addons;
    }
    
    
    /**
    * Get the site specific settings from the extensions table
    *
    * @param $force_refresh     bool    Get the settings from the DB even if they are in the $SESS global
    * @param $return_all        bool    Return the full array of settings for the installation rather than just this site
    * @return array                     If settings are found otherwise false. Site settings are returned by default. Installation settings can be returned is $return_all is set to true
    * @since version 1.0.0
    */
    function _get_settings($force_refresh = FALSE, $return_all = FALSE)
    {

        global $SESS, $DB, $REGX, $LANG, $PREFS;

        // assume there are no settings
        $settings = FALSE;

        // Get the settings for the extension
        if(isset($SESS->cache['bl'][$this->class_name]['settings']) === FALSE || $force_refresh === TRUE)
        {
            // check the db for extension settings
            $query = $DB->query("SELECT settings FROM exp_extensions WHERE enabled = 'y' AND class = '" . get_class($this) . "' LIMIT 1");

            // if there is a row and the row has settings
            if ($query->num_rows > 0 && $query->row['settings'] != '')
            {
                // save them to the cache
                $SESS->cache['bl'][$this->class_name]['settings'] = $REGX->array_stripslashes(unserialize($query->row['settings']));
            }
        }
        // check to see if the session has been set
        // if it has return the session
        // if not return false
        if(empty($SESS->cache['bl'][$this->class_name]['settings']) !== TRUE)
        {
            $settings = ($return_all === TRUE) ?  $SESS->cache['bl'][$this->class_name]['settings'] : $SESS->cache['bl'][$this->class_name]['settings'][$PREFS->ini('site_id')];
        }

        return $settings;
    }
}

/**
* Extend the Output Class
* 
* Thanks to Nathan Pitman of (Nine Four) http://ninefour.co.uk/labs. I didn't even
* think of extending the class in this way to avoid having to add a core hack.
*
* I could just modify the code below instead using a hook, but I'm leaving it
* intact just incase, and simply adding the hook. If any reason this extension fails,
* the default system message will still be delivered to the user.
*
*/
class System_Messages_Output extends Output
{
    // Start Copy/Paste from Core.ouput.php
    
    /** ----------------------------------------
    /**  Show message
    /** ----------------------------------------*/
    
    // This function and the next enable us to show error
    // messages to users when needed.  For example, when
    // a form is submitted without the required info.
    
    // This is not used in the control panel, only with
    // publicly accessible pages.
     
    function show_message($data, $xhtml = TRUE, $type = FALSE)
    {
        global $LANG, $DB, $PREFS, $REGX;
        
        foreach (array('title', 'heading', 'content', 'redirect', 'rate', 'link') as $val)
        {
            if ( ! isset($data[$val]))
            {
                $data[$val] = '';
            }
        }
        
        if ( ! is_numeric($data['rate']) OR $data['rate'] == '')
        {
            $data['rate'] = $this->resresh_time;
        }
        
        $data['meta_refresh']   = ($data['redirect'] != '') ? "<meta http-equiv='refresh' content='".$data['rate']."; url=".$REGX->xss_clean($data['redirect'])."'>" : '';
        $data['charset']        = $PREFS->ini('charset');   
                
        if (is_array($data['link']) AND count($data['link']) > 0)
        {
            $refresh_msg = ($data['redirect'] != '' AND $this->refresh_msg == TRUE) ? $LANG->line('click_if_no_redirect') : '';
        
            $ltitle = ($refresh_msg == '') ? $data['link']['1'] : $refresh_msg;
            
            $url = (strtolower($data['link']['0']) == 'javascript:history.go(-1)') ? $data['link']['0'] : $REGX->xss_clean($data['link']['0']);
        
            $data['link'] = "<a href='".$url."'>".$ltitle."</a>";
        }
        
        if ($xhtml == TRUE)
        {
            if ( ! class_exists('Typography'))
            {
                require PATH_CORE.'core.typography'.EXT;
            }
            
            $TYPE = new Typography;
    
            $data['content'] = $TYPE->parse_type(stripslashes($data['content']), array('text_format' => 'xhtml'));
        }  
        
        // -------------------------------------------
        // 'output_show_message' hook.
        //  - Let users override the lame default system error page
        //  - Added 1.6.8, 2009-12-31
        //
            global $EXT;
            $data['type'] = $type;
            $edata = $EXT->call_extension('output_show_message', $data);
            if ($EXT->end_script === TRUE) return;
        //
        // -------------------------------------------  
                
        $query = $DB->query("SELECT template_data FROM exp_specialty_templates WHERE site_id = '".$DB->escape_str($PREFS->ini('site_id'))."' AND template_name = 'message_template'");
        
        foreach ($data as $key => $val)
        {
            $query->row['template_data'] = str_replace('{'.$key.'}', $val, $query->row['template_data']);
        }
                
        echo stripslashes($query->row['template_data']);        
        exit;
    } 
    /* END */
    
  
    /** ----------------------------------------
    /**  Show user error
    /** ----------------------------------------*/
 
    function show_user_error($type = 'submission', $errors, $heading = '')
    {
        global $LANG, $SESS;   
         
        if ($type != 'off')
        {      
            switch($type)
            {
                case 'submission' : $heading = $LANG->line('submission_error');
                    break;
                case 'general'    : $heading = $LANG->line('general_error');
                    break;
                default           : $heading = $LANG->line('submission_error');
                    break;
            }
        }
        
        $content  = '<ul>';
        
        if ( ! is_array($errors))
        {
            $content.= "<li>".$errors."</li>\n";
        }
        else
        {
            foreach ($errors as $val)
            {
                $content.= "<li>".$val."</li>\n";
            }
        }
        
        $content .= "</ul>";
        
        $data = array(  'title'     => $LANG->line('error'),
            'heading'   => $heading,
            'content'   => $content,
            'redirect'  => '',
            'link'      => array('JavaScript:history.go(-1)', $LANG->line('return_to_previous'))
        );
                
        $this->show_message($data, 0, $type);
    } 
    /* END */
    
    // End Copy/Paste from Core.ouput.php
}