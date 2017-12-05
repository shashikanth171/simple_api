<?php

namespace Drupal\simple_api\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

use Drupal;
use Drupal\node\Entity\Node;

class SimpleController {

  /**
   * This function is used in
   * route callback of path '/page_json/{siteapikey}/{node_id}' and
   * the Rest resource at '/page_json1/{siteapikey}/{node_id}'
   *
   * @param string $siteapikey
   *   A string to use.
   * @param string $node_id
   *   Another string to use, should be a number.
   */
  public function getNodeArray($siteapikey = Null, $node_id = Null) {
    // Load the node object using the $node_id from the arguments
    // Found usage at https://api.drupal.org/comment/62185#comment-62185
    $node = Node::load($node_id);

    // $node is null when $node_id is invalid
    if ($node !== NULL) {
      // Get site configuration
      // Read more about public static function Drupal::config
      // https://api.drupal.org/api/drupal/core!lib!Drupal.php/function/Drupal%3A%3Aconfig/8.2.x
      $site_config = Drupal::config('system.site');

      // Checks if siteapikey from the arguments matches with the siteapikey from site configuration
      if ($siteapikey == $site_config->get('siteapikey')) {

        // Checks if node_id from the arguments belongs to a node of 'page' content type
        if ( $node->getType() == "page" ) {
          // Convert $node object to an array which will be used in reponse
          // Read more about toArray() at
          // https://api.drupal.org/api/drupal/core%21lib%21Drupal%21Core%21Entity%21Entity.php/function/Entity%3A%3AtoArray/8.4.x
          $result = $node->toArray();
        }
        else{
          // Error message if node_id from the arguments does not belong to a node of 'page' content type
          $result["Error"] = "Given nid does not belong to a node 'page' content type";
        }
      }
      else{
        // Error message if siteapikey from the arguments does not match with the siteapikey from site configuration
        $result["Error"] = 'access denied';
      }
    }
    else {
      // Error if given nid is invalid
      $result["Error"] = 'Invalid nid';
    }
    return $result;
  }

  /**
   * This callback is mapped to the path
   * '/page_json/{siteapikey}/{node_id}'.
   *
   * @param string $siteapikey
   *   A string to use.
   * @param string $node_id
   *   Another string to use, should be a number.
   */
  public function getJson($siteapikey = Null, $node_id = Null) {

    // Get result from getNodeArray function inside the class SimpleController
    $result = SimpleController::getNodeArray($siteapikey, $node_id);

    // Generate JsonResponce from the result array
    // Read morea bout JsonResponse at
    // https://api.drupal.org/api/drupal/vendor%21symfony%21http-foundation%21JsonResponse.php/class/JsonResponse/8.2.x
    $response = new JsonResponse($result);

    return $response;
  }
}
