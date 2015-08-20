<?php

if (!function_exists('curl_init')) {
  throw new Exception('Pingpp needs the CURL PHP extension.');
}
if (!function_exists('json_decode')) {
  throw new Exception('Pingpp needs the JSON PHP extension.');
}
if (!function_exists('mb_detect_encoding')) {
  throw new Exception('Pingpp needs the Multibyte String PHP extension.');
}

// Pingpp singleton
require(VENDOR_PATH . '/pingplusplus/lib/Pingpp.php');

// Utilities
require(VENDOR_PATH . '/pingplusplus/lib/Util/Util.php');
require(VENDOR_PATH . '/pingplusplus/lib/Util/Set.php');
require(VENDOR_PATH . '/pingplusplus/lib/Util/RequestOptions.php');

// Errors
require(VENDOR_PATH . '/pingplusplus/lib/Error/Base.php');
require(VENDOR_PATH . '/pingplusplus/lib/Error/Api.php');
require(VENDOR_PATH . '/pingplusplus/lib/Error/ApiConnection.php');
require(VENDOR_PATH . '/pingplusplus/lib/Error/Authentication.php');
require(VENDOR_PATH . '/pingplusplus/lib/Error/InvalidRequest.php');
require(VENDOR_PATH . '/pingplusplus/lib/Error/RateLimit.php');
require(VENDOR_PATH . '/pingplusplus/lib/Error/Channel.php');

// Plumbing
require(VENDOR_PATH . '/pingplusplus/lib/Object.php');
require(VENDOR_PATH . '/pingplusplus/lib/ApiRequestor.php');
require(VENDOR_PATH . '/pingplusplus/lib/ApiResource.php');
require(VENDOR_PATH . '/pingplusplus/lib/SingletonApiResource.php');
require(VENDOR_PATH . '/pingplusplus/lib/AttachedObject.php');
require(VENDOR_PATH . '/pingplusplus/lib/Collection.php');

// Pingpp API Resources
require(VENDOR_PATH . '/pingplusplus/lib/Charge.php');
require(VENDOR_PATH . '/pingplusplus/lib/Refund.php');
require(VENDOR_PATH . '/pingplusplus/lib/RedEnvelope.php');
require(VENDOR_PATH . '/pingplusplus/lib/Event.php');
require(VENDOR_PATH . '/pingplusplus/lib/Transfer.php');


// wx_pub OAuth 2.0 method
require(VENDOR_PATH . '/pingplusplus/lib/WxpubOAuth.php');
