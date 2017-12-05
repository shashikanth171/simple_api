<?php

namespace Drupal\simple_api\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\system\Form\SiteInformationForm;

/**
 * Configure site information form to add Site API Key field.
 */

class SimpleSiteInformationForm extends SiteInformationForm {
  /*
  * {@inheritdoc}
  */
  public function buildForm(array $form, FormStateInterface $form_state) {

    // Retrive the system.site configuration.
    $site_config = $this->config('system.site');

    // Get the original Site Information Form.
    $form = parent::buildForm($form, $form_state);

    // Add Site API Key field to the form.
    $default_value_for_api = "No API Key yet";
    if($site_config->get('siteapikey') != Null) {
      $default_value_for_api = $site_config->get('siteapikey');
    }
    $form['site_information']['site_api_key_form_item'] = [
      '#type' => 'textfield',
      '#title' => t('Site API Key'),
      '#default_value' => $default_value_for_api ,
      '#description' => t('Add the Site API Key, which will be used to get a node of "page" content type in json format'),
    ];
    $form['actions']['submit']['#value'] = t('Update Configuration');

    return $form;

  }

  /*
  * {@inheritdoc}
  */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    // Retreiving Site API Key from Value of 'site_api_key_form_item' in Form and
    // saving Site API Key to 'site_api_key' element of system.site
    $this->config('system.site')
      ->set('siteapikey', $form_state->getValue('site_api_key_form_item'))
      ->save();

    parent::submitForm($form, $form_state);

    if ($form_state->getValue('site_api_key_form_item') != "No API Key yet") {
      drupal_set_message(t('Site API Key is saved with the value, "') . $form_state->getValue('site_api_key_form_item') . '". ');
    }

  }





 }
