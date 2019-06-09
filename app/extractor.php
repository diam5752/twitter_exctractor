<?php
namespace app;

include "src/TwitterExtractor.php";

$tweeter_results = new TwitterExtractor();
$tweeter_results->resultsToArray();

$tweeter_results->printNameAndTextOfTweet();
