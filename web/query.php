<?php
date_default_timezone_set('America/Los_Angeles');
define("COLLECTION_ID", "<YOUR COLLECTION ID>");
define("ENVIRONMENT_ID", "<YOUR ENVIRONMENT ID>");
define("COUNT", 10);
define("ENDPOINT", "https://gateway.watsonplatform.net/discovery/api/v1/environments/%s/collections/%s/query");

function callNlu($query) {
  $url = "https://api.us-south.natural-language-understanding.watson.cloud.ibm.com/instances/<YOUR NLU INSTANCE>/v1/analyze?version=2019-07-12";
  $data = array(
    "text" => $query,
    "features" => array(
      "concepts" => array(
        "limit" => 3
      ),
      "entities" => array(
        "limit" => 3
      )
    )
  );
  $dataString = json_encode($data);

  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_POST, 1);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_USERPWD, "<YOUR API KEY>");
  curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
  curl_setopt($curl, CURLOPT_VERBOSE, false);
  curl_setopt($curl, CURLOPT_POSTFIELDS, $dataString);
  curl_setopt($curl, CURLOPT_HTTPHEADER, array(
      'Content-Type: application/json',
      'Content-Length: ' . strlen($dataString))
  );

  $json = NULL;
  $error_message = NULL;
  $response = curl_exec($curl);

  if ($errno = curl_errno($curl)) {
    $error_message = curl_strerror($errno);
    error_log('error = ' . $error_message);
  } else {
    $json = json_decode($response, true);
  }

  curl_close($curl);
  return $json;
};

$q = (isset($_REQUEST["q"]) ? trim($_REQUEST["q"]) : '');
$filter = (isset($_REQUEST["filter"]) ? trim($_REQUEST["filter"]) : NULL);
$similarity = (isset($_REQUEST["similarity"]) ? trim($_REQUEST["similarity"]) : NULL);

$conceptArray = array();
$entityArray = array();
if (empty($filter)) {
  $nlu = callNlu($q);
  if ($nlu) {
    $filterArray = array();
    if (isset($nlu["concepts"])) {
      $concepts = $nlu["concepts"];
      foreach ($concepts as $concept) {
        $filterArray[] = 'enriched_text.concepts.text:"' . $concept["text"] . '"';
        $conceptArray[] = $concept["text"];
      }
    }

    if (isset($nlu["entities"])) {
      $entities = $nlu["entities"];
      foreach ($entities as $entity) {
        $filterArray[] = 'enriched_text.entities.text:"' . $entity["text"] . '"';
        $entityArray[] = $entity["text"];
      }
    }

    if (count($filterArray) > 0) {
      $filter = implode("|", $filterArray);
    }
  }
}


$endpoint = sprintf(constant("ENDPOINT"),
  constant("ENVIRONMENT_ID"),
  constant("COLLECTION_ID")
);

$params = array(
  "version" => "2019-04-30",
  "natural_language_query" => urlencode($q),
  "count" => constant("COUNT"),
  "passages" => "true",
  "highlight" => "true",
  "passages.fields" => "text",
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

$error_message = NULL;
$response = curl_exec($curl);
if ($errno = curl_errno($curl)) {
  $error_message = curl_strerror($errno);
  error_log('error = ' . $error_message);
}
curl_close($curl);

$json = json_decode($response, true);
$json["input"] = array(
  "concepts" => $conceptArray,
  "entities" => $entityArray
);

header('Content-type: application/json');
echo json_encode($json);
?>
