<?php
/*
    Plugin Name: CTF Snippet Inserter
    Description: Add CTF snippet to posts via TinyMCE
    Author: Mohammad Ghasembeigi
    Version: 1.0
    Author URL: https://mohammadg.com
*/
  
//CTF snippet - Used to output useful info for CTF's
//We use a shortcode to make things easier

add_shortcode( 'ctf-snippet', 'CTF_snippet' );

function CTF_snippet($atts) {
  extract( shortcode_atts( array(
      'category' => '',
      'link' => '',
      'date' => '',
      'dofollow' => FALSE
  ), $atts ) );
  
  global $post;
  
  $snippet = "$postid<div class=\"ctf-snippet\">";
  $snippet .= "<span class=\"ctf-title\">CTF:</span> <span class=\"ctf-value\">";
  
  if (empty($category)) {
    //Default category (1st category)
    $snippet .= "<a href=\"" . get_category_link(get_the_category($post->ID)[0]->cat_ID) . "\" rel=\"category tag\">" .
                get_the_category($post->ID)[0]->name . "</a>";
  }
  else {
    $snippet .= $category;
  }
  
  $snippet .="</span>";
  
  $snippet .="<br />";
  $snippet .= "<span class=\"ctf-title\">Link to challenge:</span> <span class=\"ctf-value\">";
  //Generate link
  if (!empty($link)) {
    $snippet .= "<a href=\"$link\" rel=\"external";
    
    if (!$dofollow)
      $snippet .= " nofollow";
    
    $pu = parse_url($link);
    $link_base = $pu["scheme"] . "://" . $pu["host"];
    $snippet .= "\">$link_base</a>";
    $snippet .= "<img class=\"external_url\" src=\"" . get_stylesheet_directory_uri() . "/images/external-link.png\" />";
  }
  else {
    $snippet .= "N/A";
  }
  
  $snippet .= "</span><br />";
  
  //Date of completion
  $snippet .= "<span class=\"ctf-title\">Date Completed:</span> <span class=\"ctf-value\">$date</span>";

  $snippet .="</div>";
  
  return $snippet;
}

/** Add TinyMCE button for CTF **/
add_filter( 'mce_external_plugins', 'add_button' );
add_filter( 'mce_buttons', 'register_button' );

function add_button( $plugin_array ) {
	$plugin_array['ctfsnippet'] = plugins_url( '/js/tinymce_ctf-snippet.js', __FILE__ );
	return $plugin_array;
}

function register_button( $buttons ) {
  array_push( $buttons, 'separator', 'ctfaddblock' );
  
	return $buttons;
}

?>