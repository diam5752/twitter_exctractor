<?php

namespace app;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "Credentials.php";

require "../vendor/autoload.php";

use Abraham\TwitterOAuth\TwitterOAuth;
use Credentials;

class TwitterExtractor
{
    private $connection;
    private $content;
    private $number_of_results;
    private $query;
    private $results;
    private $tweets_array = array();


    public function getResults()
    {
        return $this->results;
    }

    public function setResults($results)
    {
        $this->results = $results;
    }

    public function __construct()
    {
        $this->establishConnection();
        $this->setNumberOfResults($_POST["number_of_results"]);
        $this->setQuery($_POST["query"]);
        $this->setResults($this->getMostPopularTweets());
    }

    public function getNumberOfResults()
    {
        return $this->number_of_results;
    }

    public function setNumberOfResults($number_of_results)
    {
        $this->number_of_results = $number_of_results;
    }

    public function getQuery()
    {
        return $this->query;
    }

    public function setQuery($query)
    {
        $this->query = $query;
    }

    public function verifyConnection()
    {
        $this->content = $this->getConnection()->get("account/verify_credentials");
    }

    public function establishConnection()
    {
        $credentials = new Credentials();

        $this->connection = new TwitterOAuth(
            $credentials->getKey(),
            $credentials->getSecret(),
            $credentials->getAccessToken(),
            $credentials->getAccessTokenSecret()
        );
        $this->verifyConnection();
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function getMostPopularTweets()
    {
        $results = $this->connection->get(
            "search/tweets",
            [
                "q" => $this->getQuery(),
                "count" => $this->getNumberOfResults(),
                "result_type" => "popular",
                "tweet_mode" => "extended"
            ]
        );

        if (sizeof($results->statuses) == 0) {
            return 0;
        }

        if (sizeof($results->statuses) < $this->getNumberOfResults()) {
            /*
            * twitter gives us a default results for previous 7 days, so if a tweet is older
            * it gives an empty result. With this operation we ensure that as many tweets as we ask for
            * will be sent as result
            */
            $difference = $this->getNumberOfResults() - sizeof($results->statuses);

            $results = $this->connection->get(
                "search/tweets",
                [
                    "q" => $this->getQuery(),
                    "count" => $this->getNumberOfResults() + $difference,
                    "result_type" => "popular",
                    "tweet_mode" => "extended"
                ]
            );

        }

        return $results;
    }

    public function resultsToArray()
    {
        if ($this->getResults() === 0) {
            $tweet = new \stdClass();
            $tweet->name = "ERROR";
            $tweet->full_text = "no tweets found with keyword '" . $this->getQuery() . " '" . PHP_EOL  ;
            array_push($this->tweets_array, $tweet);
        } else {
            foreach ($this->getResults()->statuses as $status) {
                $tweet = new \stdClass();
                $tweet->name = $status->user->name;
                $tweet->full_text = $status->full_text;
                array_push($this->tweets_array, $tweet);
            }
        }
    }

    public function printNameAndTextOfTweet()
    {
        $tweetsJSON = json_encode($this->tweets_array, JSON_PRETTY_PRINT);
        echo $tweetsJSON;
    }
}


