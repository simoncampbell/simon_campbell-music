<?php
/**
 * Groups configuration for default Minify implementation
 * @package Minify
 */

/** 
 * You may wish to use the Minify URI Builder app to suggest
 * changes. http://yourdomain/min/builder/
 **/
 
function build_files_array($directory, $is_sub = false)
{
    $key = array_pop( explode('/',$directory) );
    $dh = opendir($directory);
    $dirs = array();

    while ( false !== ($filename = readdir($dh)) ) {
       if(is_file($directory.'/'.$filename) && !is_ignored($filename) && !$is_sub){
           $dirs[$key][] = realpath($directory).'/'.$filename;
       } elseif(is_file($directory.'/'.$filename) && !is_ignored($filename)){
           $dirs[] = realpath($directory).'/'.$filename;
       } elseif(!is_ignored($filename)) {
           $dirs[$filename] = build_files_array($directory.'/'.$filename, true);
       }
    }
    return $dirs;
}

function is_ignored($file)
{
   $ignore = array('.DS_Store','.','..');
   return in_array($file, $ignore, true);
}

function order_files_array($files)
{
    sort($files['js']);
    // foreach ( $files['js'] as $key => $script ) {
    //     if ( preg_match('/^jquery-[0-9]\./', $script) ) {
    //         unset ( $files['js'][$key] );
    //         array_unshift($files['js'],$script);
    //     }
    // }
    return $files;
}  

function build_groups($path)
{
    $files = build_files_array($path);
    $files = order_files_array($files);
    
    return $files;

}

return build_groups('../js/build');

