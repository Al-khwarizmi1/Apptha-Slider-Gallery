<?php
/*
 ***********************************************************/
/**
 * @name          : Mac Doc Photogallery.
 * @version	      : 2.5
 * @package       : apptha
 * @subpackage    : mac-doc-photogallery
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license	      : GNU General Public License version 2 or later; see LICENSE.txt
 * @abstract      : The core file of calling Mac Photo Gallery.
 * @Creation Date : June 20 2011
 * @Modified Date : September 30 2011
 * */

/*
 ***********************************************************/

    	//Pagination
            function listPagesNoTitle($args) { //Pagination
                if ($args) {
                    $args .= '&echo=0';
                } else {
                    $args = 'echo=0';
                }
                $pages = wp_list_pages($args);
                echo $pages;
            }

            function findStart($limit) { //Pagination
                if (!(isset($_REQUEST['pages'])) || ($_REQUEST['pages'] == "1")) {
                    $start = 0;
                    $_GET['pages'] = 1;
                } else {
                    $start = ($_GET['pages'] - 1) * $limit;
                }
                return $start;
            }

            /*
             * int findPages (int count, int limit)
             * Returns the number of pages needed based on a count and a limit
             */

            function findPages($count, $limit) { //Pagination
                $pages = (($count % $limit) == 0) ? $count / $limit : floor($count / $limit) + 1;
                if ($pages == 1) {
                    $pages = '';
                }
                return $pages;
            }

            /*
             * string pageList (int curpage, int pages)
             * Returns a list of pages in the format of "Â« < [pages] > Â»"
             * */

            function pageList($curpage, $pages, $albid) {
                //Pagination
                $site_url = get_bloginfo('url');
                $page_list = "";
                if ($search != '') {

                    $self = '?page_id=' . get_query_var('page_id');
                } else {
                    $self = '?page_id=' . get_query_var('page_id');
                }

              if (($curpage - 1) > 0) {
                        $page_list .= "<a href=\"" . $self . "&pages=" . ($curpage - 1) . "\" title=\"Previous Page\" class='macpag_left'>
                                                    <img src='" . $site_url . "/wp-content/plugins/" . dirname(plugin_basename(__FILE__)) . "/images/left.png' class='mac-no-border'></a> ";
                    }
                    /* Print the Next and Last page links if necessary */
                    if (($curpage + 1) <= $pages) {
                        $page_list .= "<a href=\"" . $self . "&pages=" . ($curpage + 1) . "\" title=\"Next Page\"  class='macpag_right'>
                                                    <img src='" . $site_url . "/wp-content/plugins/" . dirname(plugin_basename(__FILE__)) . "/images/right.png' class='mac-no-border'></a> ";
                    }
                $page_list .= "</td>\n";
                return $page_list;
            }

            /*
             * string nextPrev (int curpage, int pages)
             * Returns "Previous | Next" string for individual pagination (it's a word!)
             */

            function nextPrev($curpage, $pages) { //Pagination
                $next_prev = "";

                if (($curpage - 1) <= 0) {
                    $next_prev .= "Previous";
                } else {
                    $next_prev .= "<a href=\"" . $_SERVER['PHP_SELF'] . "&pages=" . ($curpage - 1) . "\">Previous</a>";
                }

                $next_prev .= " | ";

                if (($curpage + 1) > $pages) {
                    $next_prev .= "Next";
                } else {
                    $next_prev .= "<a href=\"" . $_SERVER['PHP_SELF'] . "&pages=" . ($curpage + 1) . "\">Next</a>";
                }
                return $next_prev;
            }
            //End of Pagination
;
  ?>