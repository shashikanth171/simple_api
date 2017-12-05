<?php

namespace Drupal\simple_api\Plugin\rest\resource;

use Drupal;
use Drupal\rest\ResourceResponse;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\node\Entity\Node;
use Drupal\simple_api\Controller\SimpleController;

/**
 * Provides a resource to get a node in JSON format.
 *
 * @RestResource(
 *   id = "simple_api_get_rest_resource",
 *   label = @Translation("Simple API GET"),
 *   uri_paths = {
 *     "canonical" = "/page_rest_json/{siteapikey}/{node_id}"
 *   }
 * )
 *
 * Used this article http://valuebound.com/resources/blog/create-rest-resource-for-get-method-drupal-8
 */
 class SimpleGetRestResource extends ResourceBase {

  /**
   * Responds to GET requests.
   *
   * Returns a node in JSON Format, if it of 'page' content type
   *
   * @param string $siteapikey
   *   A string to use.
   * @param string $node_id
   *   Another string to use, should be a number.
   */
  public function get($siteapikey = NULL, $node_id = NULL) {
    // Implementing the logic of your REST Resource here.

    // Get result from getNodeArray function from Drupal\simple_api\Controller\SimpleController
    $controller_object = new SimpleController;
    $result = $controller_object->getNodeArray($siteapikey, $node_id);

    // Generate ResourceResponse from the result array
    $response = new ResourceResponse($result);

    // Add Cachebility metadata using
    // https://api.drupal.org/api/drupal/core%21lib%21Drupal%21Core%21Render%21Renderer.php/function/Renderer%3A%3AaddCacheableDependency/8.2.x
    $response->addCacheableDependency($result);

    return $response;
  }

}
