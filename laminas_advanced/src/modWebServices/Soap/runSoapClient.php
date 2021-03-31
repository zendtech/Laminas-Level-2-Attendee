<?php
/**
 * Code Runner
 */
use Laminas\Soap\Client;
require __DIR__ . '/../../../vendor/autoload.php';
try {
    // Get a soap client instance passing WSDL URL
    $client = new Client("http://footballpool.dataaccess.eu/data/info.wso?wsdl");

    // Make the request. Returns a standard class object
    $result = $client->TopGoalScorers(['iTopN' => 20]);

    // $result contains the result of the traversed object structure
    var_dump($result->TopGoalScorersResult->tTopGoalScorer);
} catch (SoapFault $e){
    // Handle ..
    echo 'faulted';
}
