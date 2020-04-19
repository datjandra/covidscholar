<?php
date_default_timezone_set('America/Los_Angeles');
define("COLLECTION_ID", "news-en");
define("ENVIRONMENT_ID", "<YOUR ENVIRONMENT_ID>");
define("COUNT", 10);
define("ENDPOINT", "https://api.us-south.discovery.watson.cloud.ibm.com/instances/%s/v1/environments/system/collections/%s/query");

$q = (isset($_REQUEST["q"]) ? trim($_REQUEST["q"]) : '');
$filter = (isset($_REQUEST["filter"]) ? trim($_REQUEST["filter"]) : NULL);
$similarity = (isset($_REQUEST["similarity"]) ? trim($_REQUEST["similarity"]) : NULL);

$endpoint = sprintf(constant("ENDPOINT"),
  constant("ENVIRONMENT_ID"),
  constant("COLLECTION_ID")
);

$params = array(
  "version" => "2018-12-03",
  "natural_language_query" => urlencode($q),
  "count" => constant("COUNT"),
  "passages" => "false",
  "highlight" => "true",
  "deduplicate" => "true",
  "aggregation" => "[term(enriched_text.concepts.text,count:10),term(enriched_text.entities.text,count:10),term(enriched_text.entities.sentiment.label,count:3)]"
);

if ($filter) {
  $params["filter"] = urlencode($filter);
}

if ($similarity) {
  $params["similar"] = "true";
  $params["similar.document_ids"] = $similarity;
}

$query = urldecode(http_build_query($params));
$url = $endpoint . "?" . $query;

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_USERPWD, "<YOUR API KEY>");
curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($curl, CURLOPT_VERBOSE, true);
error_log('endpoint = ' . $endpoint);

$error_message = NULL;
$response = curl_exec($curl);
if ($errno = curl_errno($curl)) {
  $error_message = curl_strerror($errno);
  error_log('error = ' . $error_message);
}
curl_close($curl);

header('Content-type: application/json');
echo $response;
?>
