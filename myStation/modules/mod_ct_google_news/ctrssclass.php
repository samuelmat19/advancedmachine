<?php

/*
# ------------------------------------------------------------------------
# CT Google News
# ------------------------------------------------------------------------
# Copyright (C) 2015 http://cssteam.net/. All rights reserved.
# @license http://www.gnu.org/licenseses/gpl-3.0.html GNU/GPL
# Author: CSS Team
# Websites: http://cssteam.net
# ------------------------------------------------------------------------
*/

defined('_JEXEC') or die('Restricted access');

?>

<style type="text/css"> 
 
ul.feeds {
  list-style-type: none;
  margin: 0; padding: 0;
}
 
ul.feeds li img {
  float: left;
  margin: 0 10px 0 0;
}
 
ul.feeds li p {
  font: 12px Helvetica, Verdana, sans-serif;
  color: #333333;
}
 
ul.feeds li {
  padding: 8px;
  overflow: auto;
}

ul.feeds li a {
  color:#0951b1;
  font: bold 12px Helvetica, Verdana, sans-serif;
  text-decoration: none;
}

ul.feeds li a:hover {
  color:#0951b1;
  font: bold 12px Helvetica, Verdana, sans-serif;
  text-decoration: underline;
  background: none;
}
 
ul.feeds li:hover {
  background: #eee;
  cursor: pointer;
}
#warning{
    color:red;
    padding:5px 0 5px 0;
    
}

</style>


<?php

 class ctrss {
  
  var $feed;

  function rss($feed) 
  
  {

    $this->feed = $feed;
  
  }
  
  
  

  function parse($desc_appear) 
  
  {
    $rss = simplexml_load_file($this->feed);
  
    $rss_split = array();
    $match = array();
  
  
    foreach ($rss->channel->item as $item) {

      $match_found = preg_match('@src="([^"]+)"@', $item->description, $match);
      
      if ($match_found) {

        $image = $match[1];
      }

      $parts = explode('<font size="-1">', $item->description);
      $title = (string) $item->title; // Title
      $link   = (string) $item->link; // Url Link
      $description = (string) $item->description; //Description 

      if ($desc_appear==0) {
        
          $rss_split[] = '
              <li>
                  <img src="'.$image.'">
                  <a href="'.$link.'" target="_blank" title="" >'.$title.'</a>
                  <p>'.$parts[2].'</p>
              </li>
          ';
      }

      if ($desc_appear==1) {
        
          $rss_split[] = '
          <li>
              <img src="'.$image.'">
              <a href="'.$link.'" target="_blank" title="" >'.$title.'</a>
          </li>
          ';
      }
    }

    return $rss_split;
  }



  function display($numrows,$desc_appear) {

    $rss_split = $this->parse($desc_appear);
    if(empty($rss_split)){
       $rss_data = '
       
    <div><ul class="feeds">';
     
    $rss_data .= '<span id="warning">No data for this category.</span>';
    $rss_data.='</ul></div>';
    return $rss_data;
        
    }
   
    else
    {
         $i = 0;
    $rss_data = '
       
    <div><ul class="feeds">';
     
    while ( $i < $numrows ) {
        $rss_data .= $rss_split[$i];
        $i++;
    }    
   
    $rss_data.='</ul></div>';
    return $rss_data;
        
    }
   
  }
}

?>