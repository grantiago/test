<?php
 /* 
 * boi2json.php
 * mysql query to json
 */
header('Content-Type: application/json');
require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'includes/pdo.php';

// vars
$section = "%river%";
$gid =41;
$agency = "%usgs%";
$station = 13206000;
$result = array();

$sql = <<<SQL
SELECT android.id, android.name, android.imageurl, gages.cfs, gages.usgs, 
YEAR(android.updated) as year, 
MONTH( android.updated ) AS month,
TIME_FORMAT(`updated`, '%H:%i') as hour,
android.agency
FROM rivers.android 
INNER JOIN rivers.gages
ON gages.usgs = android.usgs
WHERE gages.usgs = ?
and android.agency LIKE ?
SQL;

$stmt = $pdo->prepare($sql);
$stmt->execute([$station, $agency]);
$data = $stmt->fetchAll();

foreach($data as $result) {
    // check what is in the array
    // echo $result['cfs'] . ' ' . $result['agency'] . '<br>';
}
// print it to this page
print $json = (json_encode($result, JSON_NUMERIC_CHECK));
// save it as a json file.
file_put_contents ('boise.json', $json)
?>
