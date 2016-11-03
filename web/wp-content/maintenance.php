<?php
/*
 * WordPress theme
 * Page de maintenance
 *
 * @package    wp-product-theme
 * @subpackage wordpress theme
 * @author     pacomoreau
 *
 */
$protocol = "HTTP/1.0";
if ("HTTP/1.1" == $_SERVER["SERVER_PROTOCOL"])
  $protocol = "HTTP/1.1";
header("$protocol 503 Service Unavailable", true, 503);
header("Retry-After: 600");
wp_load_translations_early();
?><!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="format-detection" content="telephone=no">
  <title><?php _e("Maintenance"); ?></title>
  <meta name='robots' content='noindex,follow' />
  <link rel='stylesheet' href='/wp-content/themes/wp-product-theme/styles/maintenance.css' type='text/css' media='all' />
</head>
<body>

  <div id="primary">
    <main id="main" class="site-main" role="main">
      <h1 class="page-title"><?php _e("Maintenance"); ?></h1>
      <div class="entry-content">
        <?php _e("Briefly unavailable for scheduled maintenance. Check back in a minute."); ?>
      </div>
    </main>
  </div>

</body>
</html>
