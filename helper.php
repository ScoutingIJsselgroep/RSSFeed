<?php
/**
 * Helper class for Hello World! module
 *
 * @package    Joomla.Tutorials
 * @subpackage Modules
 * @link http://docs.joomla.org/J3.x:Creating_a_simple_module/Developing_a_Basic_Module
 * @license        GNU/GPL, see LICENSE.php
 * mod_helloworld is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */
class ModRssFeedHelper
{
    /**
     * Retrieves the Mailchimp feed
     *
     * @param   array  $params An object containing the module parameters
     *
     * @access public
     */
    public static function getMailchimpFeed($params)
    {
      if (($response_xml_data = file_get_contents($params->get('mailchimp-feed')))===false){
        echo "Error fetching XML\n";
      } else {
        libxml_use_internal_errors(true);

        $data = simplexml_load_string($response_xml_data);
        if (!$data) {
          echo "Error loading XML\n";
          foreach(libxml_get_errors() as $error) {
            echo "\t", $error->message;
          }
        } else {
          $i = $params->get('mailchimp-feed-number');

          echo '<ul class="list-group">';
          foreach($data->channel->item as $item) {
            if (--$i == -1) break;
            $date = new JDate($item->pubDate);
            echo '<li>
                    <a target="blank" href="'.htmlspecialchars($item->link).'">
                      <h3>'.htmlspecialchars($item->title).'</h3>
                      <p>'.htmlspecialchars($date->format("j F Y, G:i")).'</p>
                    </a>
              </li>
            ';
          }
          echo '</ul>';
        }
      }
    }

    /**
     * Retrieves the Instagram feed
     *
     * @param   array  $params An object containing the module parameters
     *
     * @access public
     */
    public static function getInstagramFeed($params)
    {
      if (($response_xml_data = file_get_contents($params->get('instagram-feed')))===false){
        echo "Error fetching XML\n";
      } else {
        libxml_use_internal_errors(true);

        $data = simplexml_load_string($response_xml_data);
        if (!$data) {
          echo "Error loading XML\n";
          foreach(libxml_get_errors() as $error) {
            echo "\t", $error->message;
          }
        } else {
          $i = $params->get('instagram-feed-number');

          echo '<ul class="list-group">';
          foreach($data->channel->item as $item) {
            if (--$i == -1) break;
            echo '
            <div class="thumbnail"><a href="'.$item->link.'" target="blank">
              <img src="'.htmlspecialchars($item->enclosure->attributes()->url).'" alt="...">
              <div class="caption">
                <p><b>'.htmlspecialchars($item->author).'</b> '.htmlspecialchars($item->description).'</p>
              </div>
              </a>
            </div>';
          }
          echo '</ul>';
        }
      }
    }
}
