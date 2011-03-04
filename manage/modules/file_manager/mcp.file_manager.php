<?php

/*
=====================================================
 This module was created by Lodewijk Schutte
 - lodewijk@gmail.com
 - http://loweblog.com/
 This work is licensed under a
 Creative Commons Attribution-ShareAlike 2.5 License.
 - http://creativecommons.org/licenses/by-sa/2.5/
=====================================================
 File: mcp.file_manager.php
-----------------------------------------------------
 Purpose: File Manager class - CP
=====================================================
*/


if ( ! defined('EXT'))
{
    exit('Invalid file request');
}

class File_manager_CP {

    // BEGIN VARS YOU MIGHT WANT TO EDIT
    var $batchsize       = 6;        // default = 6, only for initialization
    var $resize_protocol = 'gd2';    // your image library protocol can be: imagemagick, netpbm, gd, gd2
    var $libpath         = '';       // path to your image lib, if any
    var $editable        = array('txt','php','html','htm','css','js'); // editable file types
    // END VARS YOU MIGHT WANT TO EDIT
    
    var $version         = '1.2.5';    
    var $recursive       = FALSE;
    
    // -------------------------
    //  Constructor
    // -------------------------
    
    function File_manager_CP( $switch = TRUE )
    {
        global $IN, $LANG, $PREFS;
        
        // get resize protocol etc from preferences
        if ('y' == $PREFS->core_ini['enable_image_resizing'])
        {
          $this->resize_protocol = $PREFS->core_ini['image_resize_protocol'];
          $this->libpath         = $PREFS->core_ini['image_library_path'];
        }
        
        $LANG->fetch_language_file('publish_ad');
        $LANG->fetch_language_file('filebrowser');
        
        if ($switch)
        { 
          switch($IN->GBL('P'))
          {
            case 'view'            :	$this->view_files();
              break;
            case 'list_action'     :	$this->list_action();
              break;
            case 'delete'          :	$this->delete_files();
              break;
            case 'delete_confirm'  :	$this->delete_confirm();
              break;
            case 'new'             :	$this->new_files();
              break;
            case 'upload'          :	$this->upload_files();
              break;
            case 'mkdir'           :   $this->create_folder();
              break;
            case 'rmdir'           :   $this->remove_folder();
              break;
            case 'edit_file'       :   $this->edit_file();
              break;
            case 'save_file'       :   $this->save_file();
              break;
            case 'upgrade'         :	$this->upgrade();
              break;
            default                :	$this->file_manager_home();
              break;
            }
        }
    }
    // END    
    
    
    // ----------------------------------------
    //  Module Homepage
    // ----------------------------------------
    
    function file_manager_home($msg = '')
    {
        global $DSP, $LANG, $DB;
        
        $show_this = '';

        // show message if any
        if (strlen($msg))
        {
          $msg = $DSP->qdiv('success',$LANG->line($msg));
        }
        
        // check if upgrade is needed
        $query = $DB->query("SELECT module_version FROM exp_modules WHERE module_name = 'File_manager'");
        
        if ($query->row['module_version'] != $this->version)
        {
          $show_this
            .=$DSP->div('box defaultBold')
            .  $DSP->anchor(BASE.AMP.'C=modules'.AMP.'M=file_manager'.AMP.'P=upgrade', $LANG->line('upgrade_module'))
            . $DSP->div_c();
        }
        else
        {
          // show listbox or 'empty' message
          if ($listbox = $this->upload_folder_listbox(0,0,0,1))
          {
            $show_this
              .=$DSP->table('tableBorder', '0', '', '100%')
              .  $DSP->tr()
              .   $DSP->table_qcell('tableHeadingAlt', array($LANG->line('select_folder'), $LANG->line('files'),''))
              .  $DSP->tr_c()
              .  $listbox
              . $DSP->table_c();
          }
          else
          {
            $show_this
              .=$DSP->qdiv('defaultBold', $LANG->line('no_folder_found'));
          }
        }

        
        $DSP->title = $LANG->line('file_manager_module_name');
        $DSP->crumb = $LANG->line('file_manager_module_name');
        
        $DSP->right_crumb($LANG->line('new_file'), BASE.AMP.'C=modules'.AMP.'M=file_manager'.AMP.'P=new');
        
        $DSP->body
          .=$msg
          . $DSP->qdiv('tableHeading', $LANG->line('file_manager_module_name'))
          . $show_this
          . $DSP->div('box')
          .  $DSP->anchor(BASE.AMP.'C=admin'.AMP.'M=blog_admin'.AMP.'P=edit_upload_pref', $LANG->line('create_new_upload_pref'))
          . $DSP->div_c();
    }
    // END
    
    
    
    // ----------------------------------------
    //  View files in an upload destination (folder)
    // ----------------------------------------
    
    function view_files($folder=0,$msg='')
    {
        global $DSP, $LANG, $IN, $LOC, $SESS, $DB;
        
        // Get the selected folder preferences
        $folder_prefs = $this->get_folder_prefs(($folder) ? $folder : $IN->GBL('folder_id','GP'));

		// Double check for folder prefs
		if (!$folder_prefs) return $this->file_manager_home();

        // Check if logged in user is allowed to view files in this folder
        $que = $DB->query("SELECT upload_id FROM exp_upload_no_access WHERE upload_id = {$folder_prefs['id']} AND member_group = {$SESS->userdata['group_id']}");
        
        if ($que->num_rows)
        {
          // found a record in upload_no_access, so redirect unauthorised user back home
          return $this->file_manager_home('not_allowed');
        }
        
        // Get the filebrowser class
        if ( ! class_exists('Filebrowser'))
        {
           require PATH_CP.'cp.filebrowser'.EXT;
        }
         

    
        // Use the filebrowser class and folder preferences to retrieve the filelist
        $FB = new File_browser();
        $FB->show_errors  = FALSE;
        $FB->recursive	  = $this->recursive;
        $FB->upload_path  = $folder_prefs['server_path'];
        $filelist_created = $FB->create_filelist();
        
        // begin constructing the page
        $DSP->title = $LANG->line('file_manager_module_name');
        $DSP->crumb
          = $DSP->anchor(BASE.AMP.'C=modules'.AMP.'M=file_manager', $LANG->line('file_manager_module_name'))
          . $DSP->crumb_item($LANG->line('viewing_files_in') . $folder_prefs['name']);
        
        // add new link on the right
        $DSP->right_crumb($LANG->line('new_file') . ($folder_prefs['is_writable'] ? $LANG->line('in_here') : ''),  BASE.AMP.'C=modules'.AMP.'M=file_manager'.AMP.'P=new'.AMP.'folder_id='.$folder_prefs['id']);
        
        
        // show message, if any
        if (strlen($msg))
        {
          $DSP->body .= $DSP->qdiv('success',$LANG->line($msg));
        }
                
        if ($filelist_created && $num_files = count($FB->filelist))
        {
          // Use jQuery if available
		  $DSP->extra_header .= <<<EOJS
	<script type="text/javascript">
	<!--
		if (typeof jQuery != 'undefined') {
			
			function low_filter_list() {
				var filter = $('#filter')[0];
				var rows   = $('#target tr');
				var show   = $.browser.msie ? 'block' : 'table-row';
				
				if (!filter || !rows) return;

				var filter_list = function() {
					var needle = filter.value.toLowerCase();
					for (var i = 1, j = rows.length; i < j; i++) {
						var haystack = $("a",rows[i]).eq(0).text().toLowerCase();
						rows[i].style.display = (haystack.indexOf(needle) != -1) ? show : 'none';
					}
				}
				$(filter).keyup(filter_list);
			}
			$(document).ready(low_filter_list);
		}
	// -->
	</script>	
EOJS;
		  // filter list?
		  $filter = trim($IN->GBL('filter','POST'));

          // sort nested array...
          $sorted = array();
          foreach ($FB->filelist as $tmp_file)
          {
            // filter?
			if ($filter && !substr_count(strtolower($tmp_file['name']), strtolower($filter))) continue;
			
			// sort by file name, case insensitive
            $sorted[strtolower($tmp_file['name'])] = $tmp_file;
          }
          
          // sort alphabetically
          ksort($sorted);
		
		  // create filter form
          $DSP->body
            .=$DSP->qdiv('tableHeading',$LANG->line('filter_list'))
			. $DSP->form('C=modules'.AMP.'M=file_manager'.AMP.'P=view'.AMP.'folder_id='.$folder_prefs['id'],'filter_list')
			. $DSP->div('box')
			.  $DSP->input_text('filter', $filter, '20', '60', 'input', '260px', '', TRUE)
			.  $DSP->input_submit($LANG->line('submit_filter'))
			. $DSP->div_c()
			. $DSP->form_c();
			
		  // table header array
          $th = array (
            $LANG->line('file_name_flag'),
            $LANG->line('edit') .'/'. $LANG->line('view'),
            $LANG->line('file_size_flag'),
            $LANG->line('width_times_height'),
            $LANG->line('last_modified'),
            $DSP->input_checkbox('toggleflag', '', '', "onclick=\"toggle(this);\"")
          );

          // header including number of files, and start of table / form
          $DSP->body
            .=$DSP->toggle()
            . $DSP->qdiv('tableHeading',$LANG->line('viewing_files_in').$DSP->anchor(BASE.AMP.'C=admin'.AMP.'M=blog_admin'.AMP.'P=edit_upload_pref'.AMP.'id='.$folder_prefs['id'],$folder_prefs['name']).NBS."(".count($sorted).")")
            . $DSP->form('C=modules'.AMP.'M=file_manager'.AMP.'P=list_action','target')
            . $DSP->input_hidden('folder_id', $folder_prefs['id'])
            . $DSP->table('tableBorder', '0', '0', '100%')
            .  $DSP->tr()
            .   $DSP->table_qcell('tableHeadingAlt', $th)
            .  $DSP->tr_c();
            
          $i = 0;
                    
          foreach ($sorted as $file)
          {				
            $style    = ($i++ % 2) ? 'tableCellOne' : 'tableCellTwo';
            
            // filesize, modified and extension aren't in the filelist, so let's get it ourselves...
            $filesize  = round(filesize($folder_prefs['server_path'].$file['name']) / 1024).NBS.'KB';
            $modified  = $LOC->set_human_time(filemtime($folder_prefs['server_path'].$file['name']));
            $tmp_ext   = explode(".",$file['name']);
            $extension = array_pop($tmp_ext);
            $writable  = is_writable($folder_prefs['server_path'].$file['name']);
            
            // edit, view or n/a option
            if (in_array($extension,$this->editable))
            {
              $file_option
                = $DSP->anchor(BASE.AMP.'C=modules'.AMP.'M=file_manager'.AMP.'P=edit_file'.AMP.'folder_id='.$folder_prefs['id'].AMP.'file='.rawurlencode($file['name']),
                  ($writable ? $LANG->line('edit') : $LANG->line('view')));
            }
            else
            {
              $file_option = $LANG->line('not_applicable');
            }
            
            // file rows
            $DSP->body
              .=$DSP->tr()
              .  $DSP->table_qcell($style, $DSP->anchor($folder_prefs['url'].$file['name'],$file['name']), '57%')
              .  $DSP->table_qcell($style, $file_option,'5%')
              .  $DSP->table_qcell($style.' defaultRight', $filesize,'5%')
              .  $DSP->table_qcell($style.' defaultCenter', ('image' == $file['type']) ? $file['width'].NBS.'&times;'.NBS.$file['height'] : $LANG->line('not_applicable'), '15%')
              .  $DSP->table_qcell($style, $modified,'15%') 
              .  $DSP->table_qcell($style, $DSP->input_checkbox('toggle[]', $folder_prefs['server_path'].$file['name'],'','', '3%'))
              . $DSP->tr_c();
		    }
          
          // close table / form
          $DSP->body .= $DSP->table_c();
          
          
          // submit / 'not writable' message
          $DSP->body
            .=$DSP->div('box defaultRight')
            .  $LANG->line('with_selected')
            .  $DSP->input_select_header('with_selected')
            .   (($folder_prefs['is_writable']) ? $DSP->input_select_option('delete',$LANG->line('delete')) : '')
            .   $DSP->input_select_option('show_cap',$LANG->line('show_copy_and_paste'))
            .  $DSP->input_select_footer()
            .  $DSP->input_submit($LANG->line('submit'))
            . $DSP->div_c()
            . $DSP->form_c();
        }
        else
        {
          $DSP->body
            .=$DSP->div('box320')
            .  $DSP->qdiv('alert', $LANG->line(($filelist_created)?'fp_no_files':'folder_doesnt_exist'))
            .   '<ul style="line-height:1.5em;">';
          if ($filelist_created)
          {
            // Show 'no files here' message
            $DSP->body
              .='<li>'
              . ($folder_prefs['is_writable']
              ? $DSP->anchor(BASE.AMP.'C=modules'.AMP.'M=file_manager'.AMP.'P=new'.AMP.'folder_id='.$folder_prefs['id'], $LANG->line('new_file') . $LANG->line('in_here'))
              : $DSP->qdiv('alert',$LANG->line('folder_not_writable')))
              . '</li><li>'
              .  $DSP->anchor(BASE.AMP.'C=modules'.AMP.'M=file_manager'.AMP.'P=rmdir'.AMP.'folder_id='.$folder_prefs['id'], $LANG->line('delete_folder'))
              . '</li>';
          }
          else
          {
            // Folder doesn't exist on the server, ask to create
            $DSP->body
              .='<li>'
              . $DSP->anchor(BASE.AMP.'C=modules'.AMP.'M=file_manager'.AMP.'P=mkdir'.AMP.'folder_id='.$folder_prefs['id'], $LANG->line('create_folder'))
              . '</li><li>'
              . $DSP->anchor(BASE.AMP.'C=admin'.AMP.'M=blog_admin'.AMP.'P=edit_upload_pref'.AMP.'id='.$folder_prefs['id'], $folder_prefs['name'])
              . '</li>';
          }
          $DSP->body
            .='</ul>'
            . $DSP->div_c();
        }
    }
    // END

    
    
    // ----------------------------------------
    //  List action: either go to confirm delete or show c&p
    // ----------------------------------------
    
    function list_action()
    {
        global $IN;
        
        switch ($IN->GBL('with_selected', 'POST'))
        {
          case "delete"    : $this->delete_confirm();
            break;
          case "show_cap"  : $this->show_copy_and_paste();
            break;
          default          : $this->file_manager_home();
            break;
        }
    }
    // END

    // ----------------------------------------
    //  Show copy and paste info
    // ----------------------------------------
    
    function show_copy_and_paste()
    {
        global $IN, $DSP, $LANG;
        
        // safeguard (nothing to show)
        if ( ! $IN->GBL('toggle', 'POST'))
        {
            return $this->file_manager_home();
        }

        // Get the selected folder preferences
        $folder_prefs   = $this->get_folder_prefs($IN->GBL('folder_id','POST'));
        $selected_files = $IN->GBL('toggle', 'POST');

        // Get the filebrowser class
        if ( ! class_exists('Filebrowser'))
        {
           require PATH_CP.'cp.filebrowser'.EXT;
        }
        
        // Use the filebrowser class and folder preferences to retrieve the filelist
        $FB = new File_browser();
        $FB->show_errors  = FALSE;
        $FB->recursive	  = FALSE;
        $FB->upload_path  = $folder_prefs['server_path'];
        $filelist_created = $FB->create_filelist();
        
        // copy and paste array init
        $cap = array();
        
        if ($filelist_created && count($FB->filelist))
        {
          // loop through file list
          foreach ($FB->filelist AS $file)
          {
            // if the file is not selected, skip it
            if (!in_array($folder_prefs['server_path'].$file['name'], $selected_files)) continue;
            
            if ($file['type'] == 'image')
            {
              $cap[]
                = '<img src="{filedir_'.$folder_prefs['id'].'}'.$file['name'].'" '
                . 'width="'.$file['width'].'" '
                . 'height="'.$file['height'].'" '
                . 'alt="" />';
            }
            else
            {
              $cap[]
                = '<a href="{filedir_'.$folder_prefs['id'].'}'.$file['name'].'">'
                . $file['name'] .'</a>';
            }
          }
        }


        $DSP->title = $LANG->line('file_manager_module_name');
        $DSP->crumb
          = $DSP->anchor(BASE.AMP.'C=modules'.AMP.'M=file_manager', $LANG->line('file_manager_module_name'))
          . $DSP->crumb_item($LANG->line('show_copy_and_paste'));
        
        // add new link on the right
        $DSP->right_crumb($LANG->line('cancel'), BASE.AMP.'C=modules'.AMP.'M=file_manager'.AMP.'P=view'.AMP.'folder_id='.$folder_prefs['id']);
        
        $DSP->body
          .="<textarea class=\"textarea\" style=\"width:100%;font-family:monospace;\" cols=\"50\" rows=\"10\" >"
          .  htmlentities(implode(NL,$cap))
          . "</textarea>";
    }
    // END
    

    // ----------------------------------------
    //  Create non-existing upload destination on the server
    // ----------------------------------------
    
    function create_folder()
    {
        global $DSP, $LANG, $IN;
        
        // Get the selected folder preferences
        $folder_prefs = $this->get_folder_prefs($IN->GBL('folder_id','GP'));

        $DSP->title = $LANG->line('file_manager_module_name');
        $DSP->crumb = $DSP->anchor(BASE.AMP.'C=modules'.AMP.'M=file_manager', $LANG->line('file_manager_module_name'));
  

        // If the folder really doesn't exist...
        if (!file_exists($folder_prefs['server_path']))
        {
          // ...try to create it
          $made = @mkdir($folder_prefs['server_path']);
          
          if ($made)
          {
            // if it worked, go to the view files section
            return $this->view_files($IN->GBL('folder_id','GP'),'folder_created');
          }
          else
          {
            // if it didn't work, show error/warning
            $DSP->crumb .= $DSP->crumb_item($LANG->line('could_not_create_folder'));
            $DSP->body
              .=$DSP->heading($LANG->line('could_not_create_folder'))
              . $DSP->div('box320')
              . $DSP->qdiv('alert', $LANG->line('check_upload_destination_settings'))
              . BR
              . $DSP->anchor(BASE.AMP.'C=admin'.AMP.'M=blog_admin'.AMP.'P=edit_upload_pref'.AMP.'id='.$folder_prefs['id'], $LANG->line('view_upload_pref'))
              . " | "
              . $DSP->anchor(BASE.AMP.'C=modules'.AMP.'M=file_manager', $LANG->line('file_manager_module_name'))
              . $DSP->div_c();
          }
        }
        else
        {
          return $this->file_manager_home();
        }
    }

    // ----------------------------------------
    //  Remove folder from the server
    // ----------------------------------------
    
    function remove_folder()
    {
        global $LANG, $IN;
        
        // Get the selected folder preferences
        $folder_prefs = $this->get_folder_prefs($IN->GBL('folder_id','GP'));
        
        if (file_exists($folder_prefs['server_path']))
        {
          $removed = @rmdir($folder_prefs['server_path']);
          
          $msg = ($removed) ? 'folder_removed' : 'folder_not_removed';
        }
        else
        {
          $msg = 'folder_not_removed';
        }
        
        return $this->file_manager_home($msg);
    }
    
    
        
    // ----------------------------------------
    //  Form for uploading new files
    // ----------------------------------------
    
    function new_files()
    {
        global $DSP, $LANG, $IN;
        
        if ( ! class_exists('Image_lib'))
        {
          require PATH_CORE.'core.image_lib'.EXT;
        }
        
        $IM = new Image_lib();
        
        $DSP->title = $LANG->line('file_manager_module_name');
        
        $DSP->crumb
          = $DSP->anchor(BASE.AMP.'C=modules'.AMP.'M=file_manager', $LANG->line('file_manager_module_name'))
          . $DSP->crumb_item($LANG->line('new_file'));
        
        // Some JavaScript to add input fields
        $javaScript = "
          <script type=\"text/javascript\">//<![CDATA[
          
          function addFileInput() {
            if (!document.getElementById && !document.getElementById('input_file_list')) return false;
            if (!document.getElementsByTagName) return false;
            
            var ol = document.getElementById('input_file_list');
            var li = ol.getElementsByTagName('li');
            
            var newItem  = document.createElement('li');
            var newInput = document.createElement('input');
            newInput.type = 'file';
            newInput.name = 'newfile[]';

            newItem.appendChild(newInput);
            ol.appendChild(newItem);
            
            return false;
          }
          
          function removeFileInput () {
            if (!document.getElementById && !document.getElementById('input_file_list')) return false;

            var ol = document.getElementById('input_file_list');
            
            if (ol.hasChildNodes()) {
              ol.removeChild(ol.lastChild);
            }
            
            return false;
          }
          
          //]]></script>
        ";
        
        // create number of input fields to upload files, init
        $input_files = '';
        for ($i = 1; $i <= $this->batchsize; $i++)
        {
           $input_files .= "<li><input type=\"file\" name=\"newfile[]\" /></li>";
        }
        
        $DSP->body
          .=$javaScript
          . $DSP->heading($LANG->line('new_file'))
          . $DSP->div('box450')
          .  $DSP->form('C=modules'.AMP.'M=file_manager'.AMP.'P=upload','uploadform','post','enctype="multipart/form-data"')
          .   $DSP->qdiv('defaultBold',$LANG->line('select_file').': <a href="#" onclick="return addFileInput();">'.$LANG->line('add_input_field').'</a>'
          .     ' | <a href="#" onclick="return removeFileInput();">'.$LANG->line('remove_input_field').'</a>')
          .   NL.'<ol id="input_file_list">'
          .   $input_files
          .   '</ol>'
          .   $DSP->qdiv('defaultBold',$LANG->line('select_destination'))
          .   '<blockquote>'
          .    $this->upload_folder_listbox('folder_id',$IN->GBL('folder_id','GP'),1)
          .   '</blockquote>'
          .   $DSP->qdiv('defaultBold',$LANG->line('rename_filename'))
          .   '<blockquote>'
          .   $DSP->input_radio('rename_filename', 'y', 1, 'style="vertical-align:middle"')
          .    $LANG->line('yes')
          .   BR
          .   $DSP->input_radio('rename_filename', 'n', 0, 'style="vertical-align:middle"')
          .    $LANG->line('no')
          .   '</blockquote>'
          .   $DSP->qdiv('defaultBold', $LANG->line('do_what_with_existing_files'))
          .   '<blockquote>'
          .   $DSP->input_select_header('overwrite_file')
          .    $DSP->input_select_option('overwrite', $LANG->line('overwrite_them'))
          .    $DSP->input_select_option('append', $LANG->line('append_them'))
          .    $DSP->input_select_option('skip', $LANG->line('skip_them'))
          .   $DSP->input_select_footer()
          .   '</blockquote>';
          
        if ($IM->gd_loaded())
        {
          $DSP->body
            // START IMAGE RESIZE OPTIONS
            .=  $DSP->div('defaultBold').$LANG->line('do_what_with_images').$DSP->div_c()
            .   '<blockquote>'
            .    '<select name="with_images" class="select" onchange="document.getElementById(\'image_options\').style.display=(this.value==\'skip\')?\'none\':\'block\';">'
            .     $DSP->input_select_option('resize', $LANG->line('resize_them'))
            .     $DSP->input_select_option('skip', $LANG->line('skip_them'))
            .    '</select>'
            .   '<fieldset id="image_options" style="margin-top:1em;">'
            .    '<legend class="defaultBold">'.NBS.$LANG->line('image_options').NBS.'</legend>'
            .    $LANG->line('quality') .': '
            .    $DSP->input_select_header('quality')
            .     $DSP->input_select_option('90',$LANG->line('high'))
            .     $DSP->input_select_option('50',$LANG->line('medium'))
            .     $DSP->input_select_option('20',$LANG->line('low'))
            .    $DSP->input_select_footer()
            .    $DSP->br(2)
            .    $DSP->input_checkbox('aspect_ratio', 'y', 'y', 'style="vertical-align:middle;"')
            .     $LANG->line('maintain_ratio')
            .    '</fieldset>'
            .   '</blockquote>';
            // FINISH IMAGE RESIZE OPTIONS
        }
        else
        {
          $DSP->body
            .= $DSP->input_hidden('with_images','skip');
        }
        
        $DSP->body
          .=  $DSP->input_submit()
          .  $DSP->form_c()
          . $DSP->div_c();
        
    }
    // END
    
    
    
    /* -------------------------------------------
    /*   Delete Confirm
    /* -------------------------------------------*/   

    function delete_confirm()
    { 
        global $IN, $DSP, $LANG;
        
        // safeguard
        if ( ! $IN->GBL('toggle', 'POST'))
        {
            return $this->file_manager_home();
        }
        
        $DSP->title = $LANG->line('file_manager_module_name');
        
        $DSP->crumb
          = $DSP->anchor(BASE.AMP.'C=modules'.AMP.'M=file_manager', $LANG->line('file_manager_module_name'))
		    . $DSP->crumb_item($LANG->line('delete'));

        $DSP->body
          .=$DSP->form('C=modules'.AMP.'M=file_manager'.AMP.'P=delete')
          . $DSP->input_hidden('folder_id',$IN->GBL('folder_id','POST'));
        
        $files = array();
        
        foreach ($_POST as $key => $val)
        {        
          if (strstr($key, 'toggle') AND ! is_array($val))
          {
             $DSP->body .= $DSP->input_hidden('delete[]', $val);
             $xy = explode("/",$val);
             $files[] = end($xy);
          }
        }
        
        // warning / confirm message
        $DSP->body
          .=$DSP->heading($DSP->qspan('alert', $LANG->line('file_manager_delete_confirm')))
          . $DSP->div('box')
          .  $DSP->qdiv('defaultBold', $LANG->line('file_manager_delete_question'))
          .  $DSP->qdiv('', '<em>'.implode(BR,$files).'</em>')
          .  $DSP->qdiv('alert', BR.$LANG->line('action_can_not_be_undone'))
          .  $DSP->qdiv('', BR.$DSP->input_submit($LANG->line('delete')))
          .  $DSP->qdiv('alert',$DSP->div_c())
          . $DSP->div_c()
          . $DSP->form_c();
    }
    /* END */ 
    
    
    
    /* -------------------------------------------
    /*   Delete files
    /* -------------------------------------------*/  

    function delete_files()
    { 
        global $IN;        
        
        if ( ! $IN->GBL('delete', 'POST'))
        {
          return $this->file_manager_home();
        }

        foreach ($_POST as $key => $val)
        {        
          if (!is_array($val) && file_exists($val))
          {
            @unlink($val);
          }
        }

        return $this->view_files($IN->GBL('folder_id','GP'),'files_deleted');
    }
    /* END */ 

    
    /* -------------------------------------------
    /*   Upload files to the server
    /* -------------------------------------------*/  
    
    function upload_files()
    {
       global $LANG, $IN;
       
       if ( ! class_exists('Upload'))
       {
          require PATH_CORE.'core.upload'.EXT;
       }
       
       if ( ! class_exists('Image_lib'))
       {
          require PATH_CORE.'core.image_lib'.EXT;
       }

       $folder_prefs = $this->get_folder_prefs($IN->GBL('folder_id','GP'));
       
       // initiate upload class
       $UP = new Upload();
       $UP->set_upload_path($folder_prefs['server_path']);
       $UP->set_max_filesize($folder_prefs['max_size']);
       $UP->set_allowed_types($folder_prefs['allowed_types']);
       $UP->remove_spaces = ('y' == $IN->GBL('rename_filename','POST')) ? 1 : 0;
       
       // Set max width/height to 0 if we want to resize. Which we'll do later.
       $UP->set_max_width('resize' == $IN->GBL('with_images','POST') ? 0 : $folder_prefs['max_width']);
       $UP->set_max_height('resize' == $IN->GBL('with_images','POST') ? 0 : $folder_prefs['max_height']);
       
       $upped_files = array();
       
       // loop through uploaded files
       for ($f=0; $f < count($_FILES['newfile']['name']); $f++)
       {
         // put the file in 'userfile' so we can use the EE upload class
         $_FILES['userfile'] = array(
           'name'     => $_FILES['newfile']['name'][$f],
           'type'     => $_FILES['newfile']['type'][$f],
           'tmp_name' => $_FILES['newfile']['tmp_name'][$f],
           'error'    => $_FILES['newfile']['error'][$f],
           'size'     => $_FILES['newfile']['size'][$f]
         );
         
         // no file? skip it...
         if (!strlen($_FILES['userfile']['name']))
         {
           continue;
         }
         else
         {
           // reset some vars
           $UP->error_msg = '';
           $UP->width     = 0;
           $UP->height    = 0;
           $UP->is_image  = 0;
           $UP->new_name  = '';

           $upped_files[$f]['name'] = $_FILES['userfile']['name'];
           $upped_file = FALSE;
           $upped_file_result = $UP->error_msg;
           
           if ($UP->upload_file()) // TEH UPLOAD!!!!111!one~
           {
             // exist-check
             if ($UP->file_exists)
             {
               // OVERWRITE
               if ('overwrite' == $IN->GBL('overwrite_file','POST'))
               {
                 $UP->file_overwrite($UP->file_name, $UP->file_name);
                 $upped_file = TRUE;
                 $upped_file_result = $LANG->line('success');
               }
               // APPEND NUMBER TO FILENAME
               elseif ('append' == $IN->GBL('overwrite_file','POST'))
               {
                 $old_name = $UP->file_name;     // place original filename in var
                 $ext = strrchr($old_name, "."); // get extension from filename
                 
                 $i = 1;
                 $existing_file = TRUE;
                 
                 while ($existing_file == TRUE)
                 {
                   // construct new name
                   $new_name = str_replace($ext,"-".$i.$ext,$old_name);
                   
                   if (file_exists($folder_prefs['server_path'].$new_name))
                   {
                     // if that file exists too, crank up the number and try again
                     $i++;
                   }
                   else
                   {
                     // or else copy the new filename to its destination and break out of the loop
                     $UP->file_overwrite($old_name, $new_name);
                     $UP->file_name = $new_name;
                     $existing_file = FALSE;
                   }
                 }
                 // done appending
                 $upped_file = TRUE;
                 $upped_file_result = $LANG->line('success');
               }
               // SKIP FILE
               else // if ('skip' == $IN->GBL('overwrite_file','POST'))
               {
                 // skip the file is in fact deleting the temporary file
                 @unlink($folder_prefs['server_path'].$UP->temp_prefix.$UP->file_name);
                 $upped_file = FALSE;
                 $upped_file_result = $LANG->line('file_skipped');
               }
             }
             else
             {
               // file doesn't exist already
               $upped_file = TRUE;
               $upped_file_result = $LANG->line('success');
             }
             // end FILE EXISTS check
           }
           else
           {
             // something went wrong with the upload
             $upped_file = FALSE;
             $upped_file_result = $LANG->line($UP->error_msg);
           }
         }
         // array for further handling: resizing / showing result
         $upped_files[$f]['result'] = $upped_file_result;
         $upped_files[$f]['new_name'] = $UP->file_name;
         $upped_files[$f]['was_uploaded'] = $upped_file;
         $upped_files[$f]['width'] = $UP->width;
         $upped_files[$f]['height'] = $UP->height;
         $upped_files[$f]['is_image'] = $UP->is_image;

       }

       if ('resize' == $IN->GBL('with_images','POST') && ($folder_prefs['max_width'] || $folder_prefs['max_height']))
       {
         // loop thru result to see if resize is needed
         for ($i = 0; $i < count($upped_files); $i++)
         {
           // no file / not an image
           if (!isset($upped_files[$i]) || !$upped_files[$i]['was_uploaded'] || !$upped_files[$i]['is_image']) continue;
           
           // check image dimensions
           $wok = true;
           $hok = true;

           if (($folder_prefs['max_width'] > 0) && ($upped_files[$i]['width'] > $folder_prefs['max_width']))
             $wok = false;

           if (($folder_prefs['max_height'] > 0) && ($upped_files[$i]['height'] <= $folder_prefs['max_height']))
             $hok = false;

           // A-okay, daddy-o!
           if ($hok && $wok) continue;

           if ('y' == $IN->GBL('aspect_ratio','POST'))
           {
             // Get the smallest max_ which isn't 0 and resize to that
             if ($folder_prefs['max_width'] > 0 && $folder_prefs['max_height'] == 0)
             {
               // Only max_width has been defined, resize by width
               $longest_side = 'width';
             }
             else if ($folder_prefs['max_width'] == 0 && $folder_prefs['max_height'] > 0)
             {
               // Only max_height has been defined, resize by height
               $longest_side = 'height';
             }
             else if ($folder_prefs['max_width'] > 0 && $folder_prefs['max_height'] > 0)
             {
               // Both max_width and max_height have been defined, resize by the smallest of the two
               $longest_side = ($folder_prefs['max_width'] > $folder_prefs['max_height']) ? 'height' : 'width';
             }
             
             // Oh boy. My own personal maintain aspect ration thingie. The function in the image_lib class was giving me headaches.
             if ($longest_side == 'width')
             {
               $new_width  = $folder_prefs['max_width'];
               $new_height = ceil(($upped_files[$i]['height'] / $upped_files[$i]['width']) * $new_width);
             
               // If, after calculating the new dimensions, the new height is still too big, recalculate...
               // probably won't happen that often, but check it nonetheless
               if (($new_height > $folder_prefs['max_height']) && ($folder_prefs['max_height'] > 0))
               {
                 $new_height = $folder_prefs['max_height'];
                 $new_width  = ceil(($upped_files[$i]['width'] / $upped_files[$i]['height']) * $new_height);
               }
             }
             else
             {
               $new_height = $folder_prefs['max_height'];
               $new_width  = ceil(($upped_files[$i]['width'] / $upped_files[$i]['height']) * $new_height);
    
               // If, after calculating the new dimensions, the new width is still too big, recalculate...
               // probably won't happen that often, but check it nonetheless
               if (($new_width > $folder_prefs['max_width']) && ($folder_prefs['max_width'] > 0))
               {
                 $new_width  = $folder_prefs['max_width'];
                 $new_height = ceil(($upped_files[$i]['height'] / $upped_files[$i]['width']) * $new_width);
               }
             }
           }
           else
           {
             // just put the new values to the max value, if needed
             $new_width  = ($upped_files[$i]['width']  > $folder_prefs['max_width'])  ? $folder_prefs['max_width']  : $upped_files[$i]['width'];
             $new_height = ($upped_files[$i]['height'] > $folder_prefs['max_height']) ? $folder_prefs['max_height'] : $upped_files[$i]['height'];
           }
           
           $IM = new Image_lib();

           $res = $IM->set_properties(			
			    array(
               'resize_protocol'=> $this->resize_protocol,
               'libpath'        => $this->libpath,
               'file_path'      => $folder_prefs['server_path'],
               'file_name'      => $upped_files[$i]['new_name'],
               'dst_width'      => $new_width,
               'dst_height'     => $new_height,
               'quality'        => $IN->GBL('quality','POST')
             )
           );
           
           if ($res === FALSE OR !$IM->image_resize())
	        {
		       // delete the image (too big, can't resize)
             @unlink($folder_prefs['server_path'].$upped_files[$i]['new_name']);
             $upped_files[$i]['was_uploaded'] = FALSE;
             $upped_files[$i]['result'] = implode(BR,$IM->error_msg);
	        }
           else
           {
             // Yay! It worked!
             // Set new values for width and height
             $upped_files[$i]['width']   = $new_width;
             $upped_files[$i]['height']  = $new_height;
             $upped_files[$i]['result'] .= BR.$LANG->line('image_was_resized');
           }
         }
       }
       // done resizing...
       
       return $this->upload_result($upped_files,$folder_prefs['id']);
    }
    // END
    
    
    /* -------------------------------------------
    /*   Show upload result
    /* -------------------------------------------*/  
    
    function upload_result($msg,$folder=0)
    {
        global $DSP, $LANG;
        
        // set output var and 'copy and paste links'
        $show_this = "";
        $cap_links = "";
        
        // if msg is an array, loop thru elements
        if (is_array($msg))
        {
          //$this->printr($msg);
          foreach($msg AS $result)
          {
            // get the new file name
            $the_name = (!strlen($result['new_name'])?$result['name']:$result['new_name']);
            
            // make list item with result
            $show_this
              .="<li style='margin-bottom:1em'>"
              . $DSP->qdiv('defaultBold',$the_name)
              . (($result['was_uploaded']) ? $DSP->qspan('success',$result['result']) : $DSP->qspan('alert',$result['result']))
              . "</li>";
            
            // make copy and paste data
            if ($result['was_uploaded'])
            {
              if ($result['is_image'])
              {
                // img tag if it's an image
                $cap_links
                  .='<img src="{filedir_'.$folder.'}'.$the_name.'" '
                  . 'width="'.$result['width'].'" height="'.$result['height'].'" '
                  . 'alt="" />'.NL;
              }
              else
              {
                // link if it isn't an image
                $cap_links
                  .= "<a href=\"{filedir_".$folder."}".$the_name."\">".$the_name."</a>".NL;
              }
            }
          }
          // put result list items in ordered list
          $show_this = "<ol>$show_this</ol>";
        }
        else
        {
          $show_this = $LANG->line($msg);
        }
        
        if ($folder)
        {
          $folder_prefs  = $this->get_folder_prefs($folder);
          $folder_anchor = ' | '.$DSP->anchor(BASE.AMP.'C=modules'.AMP.'M=file_manager'.AMP.'P=view'.AMP.'folder_id='.$folder, $LANG->line('view').' '. $folder_prefs['name']);
        }
        else
        {
          $folder_anchor = '';
        }
        
        // build page
        $DSP->title = $LANG->line('file_manager_module_name');
        $DSP->crumb
          = $DSP->anchor(BASE.AMP.'C=modules'.AMP.'M=file_manager', $LANG->line('file_manager_module_name'))
          . $DSP->crumb_item($LANG->line('upload_result'));
        
        $DSP->body
          .= $DSP->div('box')
          .  $DSP->heading($LANG->line('upload_result'))
          .   $show_this
          .  $DSP->heading($LANG->line('copy_and_paste'))
          .   '<textarea class="textarea" style="width:99%;font-family:monospace;" cols="30" rows="5">'.htmlentities($cap_links).'</textarea>'
          .  $DSP->br(2)
          .  $DSP->anchor(BASE.AMP.'C=modules'.AMP.'M=file_manager', $LANG->line('file_manager_module_name'))
          .  ' | '
          .  $DSP->anchor(BASE.AMP.'C=modules'.AMP.'M=file_manager'.AMP.'P=new', $LANG->line('new_file'))
          .  $folder_anchor
          . $DSP->div_c();
    }
    // END
    


    /* -------------------------------------------
    /*   Edit file
    /* -------------------------------------------*/  
        
    function edit_file($folder=0,$filename='',$msg='')
    {
        global $DSP, $LANG, $IN;
        
        // Get the selected folder preferences
        $folder_prefs = $this->get_folder_prefs(($folder) ? $folder : $IN->GBL('folder_id','GP'));
        
        // Get selected file name from request
        $the_file = (strlen($filename) ? $filename : rawurldecode($IN->GBL('file','GP')));
        
        // begin constructing the page
        $DSP->title = $LANG->line('file_manager_module_name');
        $DSP->crumb
          = $DSP->anchor(BASE.AMP.'C=modules'.AMP.'M=file_manager', $LANG->line('file_manager_module_name'))
          . $DSP->crumb_item($DSP->anchor(BASE.AMP.'C=modules'.AMP.'M=file_manager'.AMP.'P=view'.AMP.'folder_id='.$folder_prefs['id'], $folder_prefs['name']))
          . $DSP->crumb_item($LANG->line('edit').' '.$the_file);
        
        // add cancel link on the right
        $DSP->right_crumb($LANG->line('cancel'), BASE.AMP.'C=modules'.AMP.'M=file_manager'.AMP.'P=view'.AMP.'folder_id='.$folder_prefs['id']);
        
        // show message if any
        if (strlen($msg))
        {
          $DSP->body .= $DSP->qdiv('success',$LANG->line($msg));
        }
        
        // get the file contents, using the more compatible file() function
        $file_contents = implode("", file($folder_prefs['server_path'].$the_file));
        
        $DSP->body
          .= $DSP->form('C=modules'.AMP.'M=file_manager'.AMP.'P=save_file','file_edit_form','post')
          .   $DSP->input_hidden('folder_id', $folder_prefs['id'])
          .   $DSP->input_hidden('file_name', $the_file)
          .   "<textarea class=\"textarea\" style=\"width:100%;font-family:monospace;\" cols=\"50\" rows=\"30\" name=\"new_file_contents\">"
          .    htmlentities($file_contents)
          .   "</textarea>"
          .   (is_writable($folder_prefs['server_path'].$the_file) ? $DSP->input_submit() : $DSP->qdiv('alert',$LANG->line('file_not_writable')))
          . $DSP->form_c();
    }
    // END


    /* -------------------------------------------
    /*   Save file
    /* -------------------------------------------*/  
        
    function save_file()
    {
        global $LANG, $IN;
        
        // Get the selected folder preferences
        $folder_prefs = $this->get_folder_prefs($IN->GBL('folder_id','POST'));
        
        // Get selected file name from request
        $the_file = $IN->GBL('file_name','POST');
        
        // Get new file contents from request
        $new_file_contents = stripslashes($IN->GBL('new_file_contents','POST'));
        
        // Set default return message
        $msg = 'edited_successfully';
        
        // open file
        $fp = @fopen($folder_prefs['server_path'].$the_file,'w');
        
        if ($fp)
        {        
          // try to write and close the file
          if (fwrite($fp, $new_file_contents) === FALSE) { $msg = 'fwrite_failed'; }
          if (fclose($fp) == FALSE) { $msg = 'fclose_failed'; }
        }
        else
        {
          $msg = 'fopen_failed';
        }
        
        return $this->edit_file($folder_prefs['id'],$the_file,$msg);
        
    }
    // END
    
    
    /* -------------------------------------------
    /*   Get row from exp_upload_prefs
    /* -------------------------------------------*/  
        
    function get_folder_prefs($folder_id)
    {
        global $DB;
        
        $query = $DB->query("SELECT id, name, server_path, url, allowed_types, max_size, max_width, max_height FROM exp_upload_prefs WHERE id = '".$folder_id."'");
        
		if ($query->num_rows)
		{
        	$folder = $query->row;
	        $folder['is_writable'] = is_writable($folder['server_path']);
        
	        // if width/height are not set, set them to 0 for calculation reasons
	        if (!$folder['max_width'])  { $folder['max_width']  = 0; }
	        if (!$folder['max_height']) { $folder['max_height'] = 0; }
    	}
		else
		{
			$folder = false;
		}
        return $folder;
    }
    // END
    
    
    /* -------------------------------------------
    /*   Compose a listbox from available upload prefs
    /* -------------------------------------------*/  
    
    function upload_folder_listbox($listbox_name='folder_id',$selected=0,$full=0,$aslist=0)
    {
        global $DB, $DSP, $LANG, $SESS, $IN;

		// get site id
		$site_id = $IN->GBL('cp_last_site_id','COOKIE');
		if (!$site_id) { $site_id = 1; }
        
        // get upload_no_access data according to usergroup
        $que = $DB->query("SELECT upload_id FROM exp_upload_no_access WHERE member_group = {$SESS->userdata['group_id']}");
        
        // init array
        $upload_ids = array();
        
        if ($que->num_rows)
        {
          foreach ($que->result AS $r)
          {
            $upload_ids[] = $r['upload_id'];
          }
        }
        
        // if we've got some results from upload_no_access, limit query using NOT IN...
        $where = (count($upload_ids)) ? "AND id NOT IN (". implode(",",$upload_ids) .")" : "";  
        
        $query = $DB->query("SELECT id, name, allowed_types, max_size, server_path FROM exp_upload_prefs WHERE site_id = '{$site_id}' {$where} ORDER BY name");
        
        if ($query->num_rows)
        {
          // Get the filebrowser class
          if ( ! class_exists('Filebrowser'))
          {
             require PATH_CP.'cp.filebrowser'.EXT;
          }

          $return_this = ($aslist) ? '' : $DSP->input_select_header($listbox_name);

          // set counter to check if there are any
          $i = 0;
          foreach ($query->result AS $row)
          {
            if ($full && !is_writable($row['server_path'])) continue;
            $style = ($i % 2) ? 'tableCellOne' : 'tableCellTwo';
            $i++; 
            $input_display = $row['name'];
            
            if ($full) // show details in listbox or not
            {
              $input_display
                .=": "
                . (('img' == $row['allowed_types']) ? $LANG->line('images_only') : $LANG->line('all_filetypes'))
                . (($row['max_size']) ? " &lt;= ". round($row['max_size']/1024) ." KB" : "");
            }
            
            if ($aslist)
            {
              // Use the filebrowser class and folder preferences to retrieve the filelist
              $FB = new File_browser();
              $FB->show_errors  = FALSE;
              $FB->recursive	  = FALSE;
              $FB->upload_path  = $row['server_path'];
              $filelist_created = $FB->create_filelist();
              
              $return_this
                .= $DSP->tr()
                .   $DSP->table_qcell($style.' defaultBold', $DSP->anchor(BASE.AMP.'C=modules'.AMP.'M=file_manager'.AMP.'P=view'.AMP.'folder_id='.$row['id'], $input_display), '50%')
                .   $DSP->table_qcell($style, count($FB->filelist), '25%')
                .   $DSP->table_qcell($style, $DSP->anchor(BASE.AMP.'C=admin'.AMP.'M=blog_admin'.AMP.'P=edit_upload_pref'.AMP.'id='.$row['id'], $LANG->line('edit')), '25%')
                .  $DSP->tr_c();
            }
            else
            {
              $return_this
                .=$DSP->input_select_option($row['id'], $input_display, ($selected==$row['id'])?'y':'');
            }
          }
          $return_this .= ($aslist) ? '' : $DSP->input_select_footer();
          
          if ($full && !$i)
          {
            // No writable folders found!
            return $this->file_manager_home('no_writable_folders_found');
          }
        }
        else
        {
          $return_this = FALSE;
        }
        
        return $return_this;
    }
    // END
    
    // ----------------------------------------
    //  Module upgrader
    // ----------------------------------------

    function upgrade()
    {
      global $DB;
      
      $query = $DB->query("UPDATE exp_modules SET module_version = '".$DB->escape_str($this->version)."' WHERE module_name = 'File_manager'");
      
      return $this->file_manager_home('upgrade_successful');
    }

    
    // ----------------------------------------
    //  Module installer
    // ----------------------------------------
    
    function file_manager_module_install()
    {
        global $DB;        
        
        $sql[] = "INSERT INTO exp_modules (module_id, 
                                           module_name, 
                                           module_version, 
                                           has_cp_backend) 
                                           VALUES 
                                           ('', 
                                           'File_manager', 
                                           '$this->version', 
                                           'y')";
                 
        foreach ($sql as $query)
        {
            $DB->query($query);
        }
        
        return true;
    }
    // END
    
    
    // ----------------------------------------
    //  Module de-installer
    // ----------------------------------------
    
    function file_manager_module_deinstall()
    {
        global $DB;    
    
        $query = $DB->query("SELECT module_id
                             FROM exp_modules 
                             WHERE module_name = 'File_manager'"); 
                
        $sql[] = "DELETE FROM exp_modules 
                  WHERE module_name = 'File_manager'";
   
        foreach ($sql as $query)
        {
            $DB->query($query);
        }
    
        return true;
    }
    // END
    
    // ----------------------------------------
    //  DEBUG function...
    // ----------------------------------------

    function printr($a)
    {
      echo "<pre>";
      print_r($a);
      echo "</pre>";
      exit;
    }
    

}
// END CLASS


?>