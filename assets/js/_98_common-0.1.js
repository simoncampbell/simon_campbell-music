/**
* ---------------------------------------------------------------------------
* ---------------------------------------------------------------------------

* This file contains some functions, writen as extensions to jQuery that we
* are likely to use often rom project to project. it requires jQuery and must
* be included before the onload.js file
*
* @author  Glen Swinfield
* @version 0.1
*
* ---------------------------------------------------------------------------*
* ---------------------------------------------------------------------------
*/



/**
* Auto Submit
* -----------------
* Automatically submits a form when 'this' changes
*
* @param  form str the form to submit
* @return $(this) obj
*/
$.fn.auto_submit = function( form )
{
  $(this).change( function(){
      $(form).submit();
  });
  return $(this);
}



/**
* Search input text
* -----------------
* Places the title of the 'this' into the value attribute
* and clears it on focus. On blur, if there is no value attribute
* is is set back to the value of title.
*
* @return $(this) obj
*/
$.fn.search_text_input = function()
{  

  if(this.val() == ''){
   this.val(this.attr('title'));
  }
   
  // focus
  $(this).focus( function( ){
	  if ( this.value == this.title ) {
		  $(this).val("");
	  };
  });

  // blur
  $(this).blur(function(){
    if(!$(this).val().length){
      $(this).val(this.title);
   }
  });
  return $(this);
}



/**
* Print Link
* -----------------
* Write in a print link to print the current window
*/
$.fn.print_link = function()
{
  var new_li = $('<li class="print"><a href="#">Print this</a></li>');
  $('a',new_li).click(function(){
     window.print();
     return false;
  });
  return $(this).prepend(new_li);
}



/**
* Hide non js elements
* -----------------
* Add a class to the body element in order to hide the
* elements not required when javascript is active.
*/
$.fn.hide_non_js_elements = function( )
{
   $('body').addClass( 'js-enabled' );
}



/**
*
* Show/Hide
* -----------------
* Toggle slides and item, and changes the html() of
* the clicked item to the specified value
*
* -------------------------------------------------
* EXAMPLE: $('form#signup a#open').show_hide( 'form#signup', 'Close', 'Open', 'fast' ).hide()
* NOTE:    chain .hide() on the end if the default state is hidden, otherwise .show()
* -------------------------------------------------

* @param the_item string the item to show/hide
* @param althtml string the html content when in an alternative state
* @param orightml string the original html of the element to revert back to
* @param speed string the speed of the transition
* @return $(this) obj
*/
$.fn.show_hide = function( the_item, althtml, orightml, speed )
{
  $(this).click( function() {
    $(the_item).slideToggle( speed );
    $(this).toggleClass('open').toggleClass('closed');
    if( $(this).html() != althtml) {
      $(this).html(althtml);
    } else {
      $(this).html(orightml);
    }
    return false;
  });
  return $(this);
}



/**
* Place Video
* ---------------
* calculates the height of the video and places it using jQuery.flash()
* There is a php alternative to find the width/height that I am working on,
* until it is finished the client must provide the width/height of the
* video when uploading it.
*/
$.fn.place_video = function( vwidth, chrome )
{

  if(!$(this).length)
    return;
    
  var width_height = $('a',this).attr('rel').split(':');
  var ratio        = width_height[0] / width_height[1];
  var height       = vwidth / ratio;

  $(this).flash(
    {
     src: '/assets/flash/mediaplayer-5.0/player.swf',
     width: vwidth,
     height: height + chrome,
     expressInstall: true,
     id: 'player1',
     name: 'player1',
     allowscriptaccess: 'always',
     flashvars: { 'file':$('a', this).attr('href'), 'allowautostart': 'true' }
    },
    { version: 9 });
  return $(this);
}