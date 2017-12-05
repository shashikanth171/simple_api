<?php

namespace Drupal\simple_api\Plugin\rest\resource;

use Drupal\Core\Session\AccountProxyInterface;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Psr\Log\LoggerInterface;
use Drupal\node\Entity\Node;
use Drupal;
/**
 * Provides a resource to get view modes by entity and bundle. /{siteapikey}/{node_id}
 *
 * @RestResource(
 *   id = "simple_api_get_rest_resource",
 *   label = @Translation("Simple API get rest resource"),
 *   uri_paths = {
 *     "canonical" = "/post_json/{siteapikey}/{node_id}"
 *   }
 * )
 */

 class SimpleGetRestResource extends ResourceBase {

  /**
   * Responds to GET requests.
   *
   * Returns a list of bundles for specified entity.
   *
   * @throws \Symfony\Component\HttpKernel\Exception\HttpException
   *   Throws exception expected.
   */
  public function get($siteapikey = NULL, $node_id = NULL) {
    // You must to implement the logic of your REST Resource here.

    $node = Node::load($node_id);
    $node_array = $node->toArray();
    // print_r($node_array['type'][0]['target_id']);
    $site_config = Drupal::config('system.site');
    if ($siteapikey == $site_config->get('siteapikey')) {
      if ($node_array['type'][0]['target_id'] == "page") {
        $result = $node_array;
      }
      else{
        $result["Error"] = "Requested node is not of 'page' content type";
      }
      $response = new ResourceResponse($result);
      $response->addCacheableDependency($result);
    }
    else{
      $siteapikey_error["Error"] = 'access denied';
      $response = new ResourceResponse($siteapikey_error);
    }
    return $response;
  }

}
