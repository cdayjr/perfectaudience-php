<!DOCTYPE HTML>
<html>
<head>
    <title>Perfect Audience API v1 Display data status example</title>
    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css" rel="stylesheet">
</head>

<?php
// Load the library.
require_once '../src/Prad/autoload.php';

use Prad\PerfectAudience;
use Prad\Exceptions\PradException;

// Enter here your access to Perfect Audience
define('CLIENT_ID', 'ENTER YOUR API KEY');
define('CLIENT_SECRET', 'ENTER YOUR ACCESS TOKEN');

$pa = new PerfectAudience(CLIENT_ID, CLIENT_SECRET);

try {
	$campaignStatus = $pa->getDataStatus('campaign_report');
	$adStatus = $pa->getDataStatus('ad_report');
	$conversionStatus = $pa->getDataStatus('conversion_report');
} catch(PradException $e) {
	$error = $e->getMessage();
}
?>

<?php if (isset($error)) { ?>
<div><?=$error?></div>
<?php } else { ?>
<ul>
	<li>Campaign report status: <?=$campaignStatus?></li>
	<li>Ad report status: <?=$adStatus?></li>
	<li>Conversion report status: <?=$conversionStatus?></li>
</ul>
<?php } ?>