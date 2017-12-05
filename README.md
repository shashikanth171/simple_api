# simple_api
Drupal 8 Module to create and use Site API Key to access node of 'page' content type in JSON format

## Using this module
- Download the zip and extract this repo under modules folder inside the root of your drupal project.
- Install this module by going to 'admin/modules'
- Open Site Configuration form by going to 'admin/config/system/site-information' and set your Site API Key.
- Now you can access node of 'page' content type in JSON Format by using any of the following methods.

### Method 1 : Using custom route 'page_json/{siteapikey}/{node_id}'
In this method you don't any additional settings to configure

Access data by going to 'page_json/{siteapikey}/{node_id}', where {siteapikey} will be the Site API Key you set in Site Configuration Form and {node_id} is the nid of node you want to access

#### On success: 

You will get node data in JSON format

#### On failure: 

An Error message of 
- 'access denied' if you use incorrect Site API Key
- 'Given nid does not belong to a node 'page' content type' if given nid does not belong to a node of 'page' content type


### Method 2 : Using Rest resource 'page_rest_json/{siteapikey}/{node_id}'
Before using this method
- Enable core module 'rest'
- Install and enable contributed module 'restui' (https://www.drupal.org/project/restui)
- enable "Simple API GET" by going to 'admin/config/services/rest'

Access data by going to 'page_rest_json/{siteapikey}/{node_id}?_format=json', where {siteapikey} will be the Site API Key you set in Site Configuration Form and {node_id} is the nid of node you want to access

#### On success: 

You will get node data in JSON format

#### On failure: 

An Error message of 
- 'access denied' if you use incorrect Site API Key
- 'Given nid does not belong to a node 'page' content type' if given nid does not belong to a node of 'page' content type
