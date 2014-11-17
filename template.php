<?php

/**
 * @file
 * template.php
 */

/**
 * Implements hook_preprocess_html().
 */
function bootstrap_clean_blog_preprocess_html(&$variables) {
  $viewport = array(
    '#tag' => 'meta',
    '#attributes' => array(
      'name' => 'viewport',
      'content' => 'width=device-width, initial-scale=1',
    ),
  );

  drupal_add_html_head($viewport, 'viewport');
}

/**
 * Implements hook_blog_preprocess_page().
 */
function bootstrap_clean_blog_preprocess_page(&$variables) {
  $header_image = url(drupal_get_path('theme', 'clean_blog') . '/assets/img/home-bg.jpg');

  if (isset($variables['node'])) {
    $node = $variables['node'];

    $variables['submitted'] = t('Posted by !username on !datetime', array(
      '!username' => $node->name,
      '!datetime' => format_date($node->created),
    ));

    $field_header = theme_get_setting('header_image');

    if (isset($node->{$field_header}['und'][0]['uri'])) {
      $header_image = $node->{$field_header}['und'][0]['uri'];
      $header_image = file_create_url($header_image);
    }
  }

  $variables['header_image'] = $header_image;
}

/**
 * Implements hook_html_head_alter().
 */
function bootstrap_clean_blog_html_head_alter(&$head_elements) {
  if (isset($head_elements['system_meta_content_type'])) {
    $head_elements['system_meta_content_type']['#attributes'] = array(
      'charset' => 'utf-8',
    );
  }
}

/**
 * Implements hook_menu_tree__MENUNAME().
 */
function bootstrap_clean_blog_menu_tree__primary(&$variables) {
  return '<ul class="nav navbar-nav navbar-right">' . $variables['tree'] . '</ul>';
}
