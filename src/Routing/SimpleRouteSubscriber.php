<?php

namespace Drupal\simple_api\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

class SimpleRouteSubscriber extends RouteSubscriberBase {
  /*
  * {@inheritdoc}
  */
  protected function alterRoutes(RouteCollection $collection) {
    /*
    * Change the form in system.site.site_information_settings route_name
    * to the custom form Drupal\simple_api\Form\SimpleSiteInformationForm
    */
    if($route = $collection->get('system.site_information_settings')) {
      /*
      * set value for _form to Drupal\simple_api\Form\SimpleSiteInformationForm
      */
      $route->setDefault('_form', 'Drupal\simple_api\Form\SimpleSiteInformationForm');
    }
  }
}
