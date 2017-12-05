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
    $node = Node::load($node_id);

    // $node is null when $node_id is invalid
    if ($node !== NULL) {
      // Get site configuration
      $site_config = Drupal::config('system.site');

      // Checks if siteapikey from the arguments matches with the siteapikey from site configuration
      if ($siteapikey == $site_config->get('siteapikey')) {

        // Checks if node_id from the arguments belongs to a node of 'page' content type
        if ( $node_type == "page" ) {
          // Convert $node object to an array which will be used in reponse
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

    // Get result from getNodeArray function
    $result = SimpleController::getNodeArray($siteapikey, $node_id);

    // Generate JsonResponce from the result array
    $response = new JsonResponse($result);

    return $response;
  }
}
