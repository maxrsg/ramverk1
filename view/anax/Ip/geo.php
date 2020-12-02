<?php
    namespace Anax\View;

?>

<h1>Find geographical position of IP address</h1>
<div class="ip-validate-wrap">
    <form method="POST">
        <label>Input IP address:<br>
        <input type="text" name="ip" value="<?= $userIP ?>"></label>
        <input type="submit" value="Validate">
    </form>
</div>

<div class="validate-result-wrap">
    <h2>Result:</h2>
    <?php if (isset($result) && gettype($result) == "object") { ?>
    <pre class="hljs">
IP:        <?= $result->ip ?>

Type:      <?= $result->type ?>

Continent: <?= $result->continent_name ?>

Country:   <?= $result->country_name ?>

Region:    <?= $result->region_name ?>

City:      <?= $result->city ?>

Zip:       <?= $result->zip ?>

Latitude:  <?= $result->latitude ?>

Longitude: <?= $result->longitude ?>
    </pre>
    <?php } else if (isset($result)) { 
        echo $result;
    } else {?>
Please enter IP above
    <?php } ?>

</div>

<div class="api-wrap">
    <h2>JSON IP validator</h2>
    <!-- <form method="POST" action="http://www.student.bth.se/~magm19/dbwebb-kurser/ramverk1/me/redovisa/htdocs/geoApi"> -->
    <form method="POST" action="http://localhost:8080/dbwebb/ramverk1/me/redovisa/htdocs/geoApi">
        <label>Input IP address:<br>
        <input type="text" name="ip" value="<?= $userIP ?>"></label>
        <input type="submit" value="Validate">
    </form>
</div>

<div class="test-api-wrap">
    <h2>Test the API:</h2>
    <!-- <form method="POST" action="http://www.student.bth.se/~magm19/dbwebb-kurser/ramverk1/me/redovisa/htdocs/geoApi"> -->
    <form method="POST" action="http://localhost:8080/dbwebb/ramverk1/me/redovisa/htdocs/geoApi">
        Valid ip:<input type="submit" value="194.47.150.9" name="ip"><br>
        Invalid ip: <input type="submit" value="000000" name="ip">
    </form>
</div>

<div class="api-explained-wrap">
    <h2>How to use the API</h2>
    <p>Send a post request containing json data in the body to this address:</p>
    <pre class="hljs">http://www.student.bth.se/~magm19/dbwebb-kurser/ramverk1/me/redovisa/htdocs/geoApi</pre>

    <p>The JSON data needs to have a key called "ip" containing an IP address <br>
    Example JSON data:</p>
    <pre class="hljs">
{
    "ip": "194.47.150.9"
}</pre>

    <p>Expected output from data above:</p>
    <pre class="hljs">
{
    "IP":        "194.47.150.9"
    "Type":      "ipv4"
    "Continent": "Europe"
    "Country":   "Sweden"
    "Region":    "Blekinge"
    "City":      "Karlskrona"
    "Zip":       "371 00"
    "Latitude":  56.16122055053711
    "Longitude": 15.586899757385254
}</pre>
</div>

