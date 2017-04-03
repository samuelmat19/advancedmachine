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
    
    $display_region=$params->get( 'display_region' );
    $display_cats=$params->get( 'display_cats' );
    $num = $params->get( 'num' );
    $desc_appear = $params->get( 'desc_appear' );
    $moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
  ?>
    
    <?php if(isset($display_region) && isset($display_cats)) {

        if ($display_region==1) {

            switch($display_cats) {

                // GOOGLE WORLD NEWS FEEDS
    
                case "general":
                $feed = 'http://news.google.com/news?pz=1&cf=all&ned=us&hl=en&topic=w&output=rss';
                break;  

                case 1:
                $feed = 'http://news.google.com/news?ned=us&topic=s&output=rss';
                break;

                case 2:
                $feed = 'http://news.google.com/news?ned=us&topic=e&output=rss';
                break;

                case 3:
                $feed = 'http://news.google.com/news?ned=us&topic=b&output=rss';
                break;

                case 4:
                $feed = 'http://news.google.com/news?ned=us&topic=m&output=rss';
                break;

                case 5:
                $feed = 'http://news.google.com/news?pz=1&cf=all&ned=us&hl=en&topic=snc&output=rss';
                break;

                case 6:
                $feed = 'http://news.google.com/news?pz=1&cf=all&ned=us&hl=en&topic=tc&output=rss';
                break;
            }
        }

        
        if ($display_region==2) {

            switch($display_cats) {

                // GOOGLE AUSTRALIA NEWS FEEDS
    
                case "general":
                $feed = 'http://news.google.com.au/news?pz=1&cf=all&ned=au&hl=en&topic=n&output=rss';
                break;  

                case 1:
                $feed = 'http://news.google.com.au/news?pz=1&cf=all&ned=au&hl=en&topic=s&output=rss';
                break;

                case 2:
                $feed = 'http://news.google.com.au/news?pz=1&cf=all&ned=au&hl=en&topic=e&output=rss';
                break;

                case 3:
                $feed = 'http://news.google.com.au/news?pz=1&cf=all&ned=au&hl=en&topic=b&output=rss';
                break;

                case 4:
                $feed = 'http://news.google.com.au/news?pz=1&cf=all&ned=au&hl=en&topic=m&output=rss';
                break;

                case 5:
                $feed = 'http://news.google.com.au/news?pz=1&cf=all&ned=au&hl=en&topic=snc&output=rss';
                break;

                case 6:
                $feed = 'http://news.google.com.au/news?pz=1&cf=all&ned=au&hl=en&topic=tc&output=rss';
                break;
            }

        }

        if ($display_region==3) {

            switch($display_cats) {

                // GOOGLE UK NEWS FEEDS
    
                case "general":
                $feed = 'http://news.google.co.uk/news?pz=1&cf=all&ned=uk&hl=en&topic=n&output=rss';
                break;  

                case 1:
                $feed = 'http://news.google.co.uk/news?pz=1&cf=all&ned=uk&hl=en&topic=s&output=rss';
                break;

                case 2:
                $feed = 'http://news.google.co.uk/news?pz=1&cf=all&ned=uk&hl=en&topic=e&output=rss';
                break;

                case 3:
                $feed = 'http://news.google.co.uk/news?pz=1&cf=all&ned=uk&hl=en&topic=b&output=rss';
                break;

                case 4:
                $feed = 'http://news.google.co.uk/news?pz=1&cf=all&ned=uk&hl=en&topic=m&output=rss';
                break;

                case 5:
                $feed = 'http://news.google.co.uk/news?pz=1&cf=all&ned=uk&hl=en&topic=snc&output=rss';
                break;

                case 6:
                $feed = 'http://news.google.co.uk/news?pz=1&cf=all&ned=uk&hl=en&topic=tc&output=rss';
                break;
            }

        }
        
        if($display_region==4){
           
           switch($display_cats){
               
              //GOOGLE NEW ZEALAND NEWS
              case "general":
              $feed = 'http://news.google.com/news/feeds?cf=all&ned=nz&hl=en&topic=n&output=rss';
              break; 
              
              case 1:
              $feed = 'http://news.google.com/news/feeds?cf=all&ned=nz&hl=en&topic=s&output=rss';
              break; 
              
              case 2:
              $feed='http://news.google.com/news/feeds?cf=all&ned=nz&hl=en&topic=e&output=rss';
              break;
              
              case 3:
              $feed="http://news.google.com/news/feeds?cf=all&ned=nz&hl=en&topic=b&output=rss";
              break;
              
              case 4:
              $feed ='http://news.google.com/news/feeds?cf=all&ned=nz&hl=en&topic=m&output=rss';
              break;
              
              case 5:
              $feed = 'http://news.google.com/news/feeds?cf=all&ned=nz&hl=en&topic=snc&output=rss';
              break;
              
              case 6:
              $feed = 'http://news.google.com/news/feeds?cf=all&ned=nz&hl=en&topic=tc&output=rss';
              break;
           }               
            
        }
        if($display_region == 5){
          switch($display_cats){
              //GOOGLE NEWS FRANCE
              case "general":
              $feed = 'http://news.google.com/news/feeds?cf=all&ned=fr&hl=fr&topic=n&output=rss';
              
              case 1:
              $feed = 'http://news.google.com/news/feeds?cf=all&ned=fr&hl=fr&topic=s&output=rss';
              break;
              
              case 2:
              $feed = 'http://news.google.com/news/feeds?cf=all&ned=fr&hl=fr&topic=e&output=rss';
              break;
              
              case 3:
              $feed = 'http://news.google.com/news/feeds?cf=all&ned=fr&hl=fr&topic=b&output=rss';
              break;
              
              case 4:
              $feed = 'http://news.google.com/news/feeds?cf=all&ned=fr&hl=fr&topic=m&output=rss';
              break;
              
              case 5:
              $feed='http://news.google.com/news/feeds?cf=all&ned=fr&hl=fr&topic=snc&output=rss';
              break;
              
              case 6:
              $feed ='http://news.google.com/news/feeds?cf=all&ned=fr&hl=fr&topic=tc&output=rss';
              break;
          }  
            
            
        }
        
        if($display_region == 6){
            
            switch($display_cats){
              //GOOGLE INDIA NEWS
              case "general":
              $feed = 'http://news.google.com/news/feeds?cf=all&ned=in&hl=en&topic=n&output=rss';
              break;  
              
              case 1:
              $feed = 'http://news.google.com/news/feeds?cf=all&ned=in&hl=en&topic=s&output=rss';
              break;
              
              case 2:
              $feed = 'http://news.google.com/news/feeds?cf=all&ned=in&hl=en&topic=e&output=rss';
              break;
              
              case 3:
              $feed = 'http://news.google.com/news/feeds?cf=all&ned=in&hl=en&topic=b&output=rss';
              break;
              
              case 4:
              $feed = 'http://news.google.com/news/feeds?cf=all&ned=in&hl=m&topic=m&output=rss';
              break;
              
              case 5:
              $feed = 'http://news.google.com/news/feeds?cf=all&ned=in&hl=en&topic=snc&output=rss';
              break;
              
              case 6:
              $feed = 'http://news.google.com/news/feeds?cf=all&ned=in&hl=en&topic=tc&output=rss';
              break;  
            }
        }
        
        if($display_region == 7){
            switch ($display_cats){
             //GOOGLE NETHERLANDS NEWS
             case "general":
             $feed = 'http://news.google.com/news/feeds?cf=all&ned=nl_nl&hl=nl&topic=n&output=rss';
             break;   
             
             case 1:
             $feed= 'http://news.google.com/news/feeds?cf=all&ned=nl_nl&hl=nl&topic=s&output=rss';               break;
             
             case 2:
             $feed = 'http://news.google.com/news/feeds?cf=all&ned=nl_nl&hl=nl&topic=e&output=rss';
             break;
             
             case 3:
             $feed='http://news.google.com/news/feeds?cf=all&ned=nl_nl&hl=nl&topic=b&output=rss';
             break;
             
             case 4:
             $feed='http://news.google.com/news/feeds?cf=all&ned=nl_nl&hl=nl&topic=m&output=rss';
             break;
            
             case 5:
             $feed = 'http://news.google.com/news/feeds?cf=all&ned=nl_nl&hl=snc&topic=snc&output=rss';
             break;
             
             case 6:
             $feed = 'http://news.google.com/news/feeds?cf=all&ned=nl_nl&hl=nl&topic=tc&output=rss';
             break;
            }
            
        }
        
        if($display_region == 8){
            switch($display_cats){
              //GOOGLE GREECE NEWS
            case "general":
            $feed = 'http://news.google.com/news/feeds?cf=all&ned=el_gr&hl=el&topic=n&output=rss';
            break; 
            
            case 1:
            $feed = 'http://news.google.com/news/feeds?cf=all&ned=el_gr&hl=el&topic=s&output=rss'; 
            break;
            
            case 2:
            $feed= 'http://news.google.com/news/feeds?cf=all&ned=el_gr&hl=el&topic=e&output=rss';
            break;
            
            case 3:
            $feed = 'http://news.google.com/news/feeds?cf=all&ned=el_gr&hl=el&topic=b&output=rss';
            break;    
            
            
            case 4:
            $feed = 'http://news.google.com/news/feeds?cf=all&ned=el_gr&hl=el&topic=m&output=rss';
            break;
            
            case 5:
            $feed = 'http://news.google.com/news/feeds?cf=all&ned=el_gr&hl=el&topic=snc&output=rss';
            break;
            
            case 6:
            $feed = 'http://news.google.com/news/feeds?cf=all&ned=el_gr&hl=el&topic=tc&output=rss';
            break;
        }
    }
        
        if($display_region == 9){
          switch($display_cats){
          //GOOGLE ARGENTINA NEWS
          case "general":
          $feed = 'http://news.google.com/news/feeds?cf=all&ned=es_ar&hl=es&topic=n&output=rss';
          break;    
          
          case 1:
          $feed='http://news.google.com/news/feeds?cf=all&ned=es_ar&hl=es&topic=s&output=rss';   
          break;
          
          case 2:
          $feed = 'http://news.google.com/news/feeds?cf=all&ned=es_ar&hl=es&topic=e&output=rss';
          break;
          
          case 3:
          $feed = 'http://news.google.com/news/feeds?cf=all&ned=es_ar&hl=es&topic=b&output=rss';
          break;
          
          case 4:
          $feed = 'http://news.google.com/news/feeds?cf=all&ned=es_ar&hl=es&topic=m&output=rss';
          break;
          
          case 5:
          $feed = 'http://news.google.com/news/feeds?cf=all&ned=es_ar&hl=es&topic=snc&output=rss';
          break;
          
          case 6:
          $feed = 'http://news.google.com/news/feeds?cf=all&ned=es_ar&hl=es&topic=tc&output=rss';
          break;
          }  
            
        }  
        if($display_region == 10){
            switch ($display_cats){
              //GOOGLE DEUTSCHLAND NEWS
          case "general":
          $feed = 'http://news.google.com/news/feeds?cf=all&ned=de&hl=de&topic=n&output=rss';
          break;
          
          case 1:
          $feed='http://news.google.com/news/feeds?cf=all&ned=de&hl=de&topic=s&output=rss';
          break;
          
          case 2:
          $feed = 'http://news.google.com/news/feeds?cf=all&ned=de&hl=de&topic=e&output=rss';
          break;
              
          case 3:
          $feed  ='http://news.google.com/news/feeds?cf=all&ned=de&hl=de&topic=b&output=rss';
          break;
          
          case 4:
          $feed = 'http://news.google.com/news/feeds?cf=all&ned=de&hl=de&topic=m&output=rss';
          break;
          
          case 5:
          $feed = 'http://news.google.com/news/feeds?cf=all&ned=de&hl=de&topic=snc&output=rss';
          break;
          
          case 6:
          $feed = 'http://news.google.com/news/feeds?cf=all&ned=de&hl=de&topic=tc&output=rss';
          break;
                
            }
        }
        
    if($display_region == 11){
        switch($display_cats){
          //GOOGLE NEWS RUSSIA
          case "general":
          $feed = 'http://news.google.com/news/feeds?cf=all&ned=ru_ru&hl=ru&topic=n&output=rss';
          break;            
          
          case 1:
          $feed = 'http://news.google.com/news/feeds?cf=all&ned=ru_ru&hl=ru&topic=s&output=rss';
          break;
          
          case 2:
          $feed = 'http://news.google.com/news/feeds?cf=all&ned=ru_ru&hl=ru&topic=e&output=rss';
          break; 
          
          case 3:
          $feed = 'http://news.google.com/news/feeds?cf=all&ned=ru_ru&hl=ru&topic=b&output=rss';
          break;
          
          case 4:
          $feed = 'http://news.google.com/news/feeds?cf=all&ned=ru_ru&hl=ru&topic=m&output=rss';
          break;     
          
          case 5:
          $feed = 'http://news.google.com/news/feeds?cf=all&ned=ru_ru&hl=ru&topic=snc&output=rss';
          break;
          
          case 6:
          $feed = 'http://news.google.com/news/feeds?cf=all&ned=ru_ru&hl=ru&topic=tc&output=rss';
          break;
          
          
            }
        }  
        if($display_region == 12){
            switch($display_cats){
              //GOOGLE NEWS ITALY
              
              case "general":
              $feed = 'http://news.google.com/news?cf=all&ned=it&hl=it&topic=n&output=rss';
              break;  
              
              case 1:
              $feed ='http://news.google.com/news?cf=all&ned=it&hl=it&topic=s&output=rss';
              break;  
              
              case 2:
              $feed ='http://news.google.com/news?cf=all&ned=it&hl=it&topic=e&output=rss';
              break;
              
              case 3:
              $feed ='http://news.google.com/news?cf=all&ned=it&hl=it&topic=b&output=rss';
              break;
              
              case 4:
              $feed ='http://news.google.com/news?cf=all&ned=it&hl=it&topic=m&output=rss';
              break;
              
              case 5:
              $feed ='http://news.google.com/news?cf=all&ned=it&hl=it&topic=snc&output=rss';
              break;
              
              case 6:
              $feed ='http://news.google.com/news?cf=all&ned=it&hl=it&topic=tc&output=rss';
              break;
            }
            
        }  
        
        if($display_region == 13){
            switch($display_cats){
              //GOOGLE NEWS SPAIN              
              case "general":
              $feed = 'http://news.google.com/news/feeds?cf=all&ned=es&hl=es&topic=n&output=rss';
              break;  
              
              case 1:
              $feed ='http://news.google.com/news/feeds?cf=all&ned=es&hl=es&topic=s&output=rss';
              break;  
              
              case 2:
              $feed ='http://news.google.com/news/feeds?cf=all&ned=es&hl=es&topic=e&output=rss';
              break;
              
              case 3:
              $feed ='http://news.google.com/news/feeds?cf=all&ned=es&hl=es&topic=b&output=rss';
              break;
              
              case 4:
              $feed ='http://news.google.com/news/feeds?cf=all&ned=es&hl=es&topic=m&output=rss';
              break;
              
              case 5:
              $feed ='http://news.google.com/news/feeds?cf=all&ned=es&hl=es&topic=snc&output=rss';
              break;
              
              case 6:
              $feed ='http://news.google.com/news/feeds?cf=all&ned=es&hl=es&topic=tc&output=rss';
              break;
            }
            
        }  
        
        if($display_region == 14){
            
            switch($display_cats){
              //GOOGLE NEWS BELGIUM              
             case "general":
             $feed = 'http://news.google.com/news/feeds?cf=all&ned=fr_be&hl=fr&topic=n&output=rss';
             break;  
              
             case 1:
             $feed ='http://news.google.com/news/feeds?cf=all&ned=fr_be&hl=fr&topic=s&output=rss';
             break;  
              
             case 2:
             $feed ='http://news.google.com/news/feeds?cf=all&ned=fr_be&hl=fr&topic=e&output=rss';
             break;
              
             case 3:
             $feed ='http://news.google.com/news/feeds?cf=all&ned=fr_be&hl=fr&topic=b&output=rss';
             break;
              
             case 4:
             $feed ='http://news.google.com/news/feeds?cf=all&ned=fr_be&hl=fr&topic=m&output=rss';
             break;
              
             case 5:
             $feed ='http://news.google.com/news/feeds?cf=all&ned=fr_be&hl=fr&topic=snc&output=rss';
             break;
              
             case 6:
             $feed ='http://news.google.com/news/feeds?cf=all&ned=fr_be&hl=fr&topic=tc&output=rss';
             break;
            }
            
        }
        
        if($display_region == 15){
            
            switch($display_cats){
              //GOOGLE NEWS Switzerland              
             case "general":
             $feed = 'http://news.google.com/news/feeds?cf=all&ned=fr_ch&hl=en&topic=n&output=rss';
             break;  
              
             case 1:
             $feed ='http://news.google.com/news/feeds?cf=all&ned=fr_ch&hl=en&topic=s&output=rss';
             break;  
              
             case 2:
             $feed ='http://news.google.com/news/feeds?cf=all&ned=fr_ch&hl=en&topic=e&output=rss';
             break;
              
             case 3:
             $feed ='http://news.google.com/news/feeds?cf=all&ned=fr_ch&hl=en&topic=b&output=rss';
             break;
              
             case 4:
             $feed ='http://news.google.com/news/feeds?cf=all&ned=fr_ch&hl=en&topic=m&output=rss';
             break;
              
             case 5:
             $feed ='http://news.google.com/news/feeds?cf=all&ned=fr_ch&hl=en&topic=snc&output=rss';
             break;
              
             case 6:
             $feed ='http://news.google.com/news/feeds?cf=all&ned=fr_ch&hl=en&topic=tc&output=rss';
             break;
            }
            
        } 
         if($display_region == 16){
            
            switch($display_cats){
              //GOOGLE NEWS IRELAND           
             case "general":
             $feed = 'http://news.google.com/news/feeds?cf=all&ned=en_ie&hl=en&topic=n&output=rss';
             break;  
              
             case 1:
             $feed ='http://news.google.com/news/feeds?cf=all&ned=en_ie&hl=en&topic=s&output=rss';
             break;  
              
             case 2:
             $feed ='http://news.google.com/news/feeds?cf=all&ned=en_ie&hl=en&topic=e&output=rss';
             break;
              
             case 3:
             $feed ='http://news.google.com/news/feeds?cf=all&ned=en_ie&hl=en&topic=b&output=rss';
             break;
              
             case 4:
             $feed ='http://news.google.com/news/feeds?cf=all&ned=en_ie&hl=en&topic=m&output=rss';
             break;
              
             case 5:
             $feed ='http://news.google.com/news/feeds?cf=all&ned=en_ie&hl=en&topic=snc&output=rss';
             break;
              
             case 6:
             $feed ='http://news.google.com/news/feeds?cf=all&ned=en_ie&hl=en&topic=tc&output=rss';
             break;
            }
            
        }
        if($display_region == 17){
            
            switch($display_cats){
              //GOOGLE NEWS PORTUGAL           
         case "general":
         $feed = 'http://news.google.com/news/feeds?cf=all&ned=pt-PT_pt&hl=en&topic=n&output=rss';
         break;  
              
             case 1:
         $feed ='http://news.google.com/news/feeds?cf=all&ned=pt-PT_pt&hl=en&topic=s&output=rss';
         break;  
              
         case 2:
         $feed ='http://news.google.com/news/feeds?cf=all&ned=pt-PT_pt&hl=en&topic=e&output=rss';
             break;
              
         case 3:
         $feed ='http://news.google.com/news/feeds?cf=all&ned=pt-PT_pt&hl=en&topic=b&output=rss';
             break;
              
         case 4:
         $feed ='http://news.google.com/news/feeds?cf=all&ned=pt-PT_pt&hl=en&topic=m&output=rss';
         break;
              
         case 5:
         $feed ='http://news.google.com/news/feeds?cf=all&ned=pt-PT_pt&hl=en&topic=snc&output=rss';
         break;
              
         case 6:
         $feed ='http://news.google.com/news/feeds?cf=all&ned=pt-PT_pt&hl=en&topic=tc&output=rss';
         break;
            }
            
        }
           
       if($display_region == 18){
            
       switch($display_cats){
              //GOOGLE NEWS CHINESE SIMPLIFIED         
         case "general":
         $feed = 'http://news.google.com/news/feeds?pz=1&cf=all&ned=es_ve&hl=zh-CN&topic=n&output=rss';
         break;  
              
             case 1:
         $feed ='http://news.google.com/news/feeds?pz=1&cf=all&ned=es_ve&hl=zh-CN&topic=s&output=rss';
         break;  
              
         case 2:
         $feed ='http://news.google.com/news/feeds?pz=1&cf=all&ned=es_ve&hl=zh-CN&topic=e&output=rss';
             break;
              
         case 3:
         $feed ='http://news.google.com/news/feeds?pz=1&cf=all&ned=es_ve&hl=zh-CN&topic=b&output=rss';
             break;
              
         case 4:
         $feed ='http://news.google.com/news/feeds?pz=1&cf=all&ned=es_ve&hl=zh-CN&topic=m&output=rss';
         break;
              
         case 5:
         $feed ='http://news.google.com/news/feeds?pz=1&cf=all&ned=es_ve&hl=zh-CN&topic=snc&output=rss';
         break;
              
         case 6:
         $feed ='http://news.google.com/news/feeds?pz=1&cf=all&ned=es_ve&hl=zh-CN&topic=tc&output=rss';
         break;
            }
            
        } 
        
        if($display_region == 19){
            
       switch($display_cats){
              //GOOGLE NEWS VENEZUELA         
         case "general":
         $feed ='http://news.google.com/news/feeds?pz=1&cf=all&ned=es_ve&hl=es&topic=n&output=rss';
         break;  
              
             case 1:
         $feed ='http://news.google.com/news/feeds?pz=1&cf=all&ned=es_ve&hl=es&topic=s&output=rss';
         break;  
              
         case 2:
         $feed ='http://news.google.com/news/feeds?pz=1&cf=all&ned=es_ve&hl=es&topic=e&output=rss';
             break;
              
         case 3:
         $feed ='http://news.google.com/news/feeds?pz=1&cf=all&ned=es_ve&hl=es&topic=b&output=rss';
             break;
              
         case 4:
         $feed ='http://news.google.com/news/feeds?pz=1&cf=all&ned=es_ve&hl=es&topic=m&output=rss';
         break;
              
         case 5:
         $feed ='httphttp://news.google.com/news/feeds?pz=1&cf=all&ned=es_ve&hl=es&topic=snc&output=rss';
         break;
              
         case 6:
         $feed ='http://news.google.com/news/feeds?pz=1&cf=all&ned=es_ve&hl=es&topic=tc&output=rss';
         break;
            }
            
        }    
        
             if($display_region == 20){
            
       switch($display_cats){
              //GOOGLE NEWS SWEEDEN    
         case "general":
         $feed ='http://news.google.com/news/feeds?cf=all&ned=sv_se&hl=sv&topic=n&output=rss';
         break;  
              
             case 1:
         $feed ='http://news.google.com/news/feeds?cf=all&ned=sv_se&hl=sv&topic=s&output=rss';
         break;  
              
         case 2:
         $feed ='http://news.google.com/news/feeds?cf=all&ned=sv_se&hl=sv&topic=e&output=rss';
             break;
              
         case 3:
         $feed ='http://news.google.com/news/feeds?cf=all&ned=sv_se&hl=sv&topic=b&output=rss';
             break;
              
         case 4:
         $feed ='http://news.google.com/news/feeds?cf=all&ned=sv_se&hl=sv&topic=m&output=rss';
         break;
              
         case 5:
         $feed ='http://news.google.com/news/feeds?cf=all&ned=sv_se&hl=sv&topic=snc&output=rss';
         break;
              
         case 6:
         $feed ='http://news.google.com/news/feeds?cf=all&ned=sv_se&hl=sv&topic=tc&output=rss';
         break;
            }
            
        }   
       
                    if($display_region == 21){
            
       switch($display_cats){
              //GOOGLE NEWS POLAND
         case "general":
         $feed ='http://news.google.com/news/feeds?cf=all&ned=pl_pl&hl=pl&topic=n&output=rss';
         break;  
              
             case 1:
         $feed ='http://news.google.com/news/feeds?cf=all&ned=pl_pl&hl=pl&topic=s&output=rss';
         break;  
              
         case 2:
         $feed ='http://news.google.com/news/feeds?cf=all&ned=pl_pl&hl=pl&topic=e&output=rss';
             break;
              
         case 3:
         $feed ='http://news.google.com/news/feeds?cf=all&ned=pl_pl&hl=pl&topic=b&output=rss';
             break;
              
         case 4:
         $feed ='http://news.google.com/news/feeds?cf=all&ned=pl_pl&hl=pl&topic=m&output=rss';
         break;
              
         case 5:
         $feed ='http://news.google.com/news/feeds?cf=all&ned=pl_pl&hl=pl&topic=snc&output=rss';
         break;
              
         case 6:
         $feed ='http://news.google.com/news/feeds?cf=all&ned=pl_pl&hl=pl&topic=tc&output=rss';
         break;
            }
            
        }         
          
        include_once('ctrssclass.php');
        $feedlist = new ctrss;
        $feedlist->rss($feed);
        echo $feedlist->display($num,$desc_appear);
        
        
    }
?>