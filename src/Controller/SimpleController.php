<?php

namespace Drupal\simple_api\Controller;
class SimpleController {
  public function content() {
    return array(
      '#type' => 'markup',
      '#markup' => t('Hello, World!'),
    );
  }
}
