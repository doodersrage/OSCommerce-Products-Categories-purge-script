<?PHP
// Set the level of error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE);

// Include application configuration parameters
  require('includes/configure.php');

// include the list of project filenames
  require(DIR_WS_INCLUDES . 'filenames.php');

// include the list of project database tables
  require(DIR_WS_INCLUDES . 'database_tables.php');

// include the database functions
  require(DIR_WS_FUNCTIONS . 'database.php');

// make a connection to the database... now
  tep_db_connect() or die('Unable to connect to database server!');

// set application wide parameters
  $configuration_query = tep_db_query('select configuration_key as cfgKey, configuration_value as cfgValue from ' . TABLE_CONFIGURATION);
  while ($configuration = tep_db_fetch_array($configuration_query)) {
    define($configuration['cfgKey'], $configuration['cfgValue']);
  }

// define our general functions used application-wide
  require(DIR_FS_CATALOG . '/admin/includes/functions/general.php');

//  function tep_remove_product($product_id) {
//  
//  function tep_remove_category($category_id) {

// walk through all products and remove them from the database
$products_query = tep_db_query("select p.products_id from " . TABLE_PRODUCTS . " p");
echo '<p>Removing products</p><p>';
while ($products = tep_db_fetch_array($products_query)) {
	// prevent script timeout
	set_time_limit(0);
	// remove selected product
	tep_remove_product($products['products_id']);
	echo 'Product ID: '.$products['products_id'].' removed<br>';
}
echo '</p>';

// walk through and remove all categories
$categories_query = tep_db_query("select c.categories_id from " . TABLE_CATEGORIES . " c");
echo '<p>Removing categories</p><p>';
while ($categories = tep_db_fetch_array($categories_query)) {
	// prevent script timeout
	set_time_limit(0);
	// remove selected product
	tep_remove_category($categories['categories_id']);
	echo 'Category ID: '.$categories['categories_id'].' removed<br>';
}
echo '</p>';
