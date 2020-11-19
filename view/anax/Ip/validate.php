<?php
    namespace Anax\View;

?>

<h1>Validate IP</h1>
<div class="ip-validate-wrap">
    <form method="POST">
        <label>Input IP address:<br>
        <input type="text" name="ip"></label>
        <input type="submit" value="Validate">
    </form>
</div>

<div class="test-validate-wrap">
    <h2>Test the validator:</h2>
    <form method="POST">
        Valid ipv4:<input type="submit" value="127.0.0.1" name="ip"><br>
        Valid ipv6: <input type="submit" value="2001:0db8:85a3:0000:0000:8a2e:0370:7334" name="ip"><br>
        Invalid: <input type="submit" value="000000" name="ip">
    </form>
</div>

<div class="validate-result-wrap">
    <h2>Result:</h2>
    <pre class="hljs">
IP: <?= $ip ?? '""' ?>

Type: <?= $type ?? '""' ?>

Hostname:  <?= $hostname ?? '""' ?></pre>
</div>

<div class="api-wrap">
    <h2>JSON IP validator</h2>
    <form method="POST" action="http://localhost:8080/dbwebb/ramverk1/me/redovisa/htdocs/ipApi">
        <label>Input IP address:<br>
        <input type="text" name="ip"></label>
        <input type="submit" value="Validate">
    </form>
</div>

<div class="test-api-wrap">
    <h2>Test the API:</h2>
    <form method="POST" action="http://localhost:8080/dbwebb/ramverk1/me/redovisa/htdocs/ipApi">
        Valid ipv4:<input type="submit" value="127.0.0.1" name="ip"><br>
        Valid ipv6: <input type="submit" value="2001:0db8:85a3:0000:0000:8a2e:0370:7334" name="ip"><br>
        Invalid: <input type="submit" value="000000" name="ip">
    </form>
</div>

<div class="api-explained-wrap">
    <h2>How to use the API</h2>
    <p>Send a post request containing json data in the body to this address:</p>
    <pre class="hljs">http://www.student.bth.se/~magm19/dbwebb-kurser/ramverk1/me/redovisa/htdocs/ipApi</pre>

    <p>The JSON data needs to have a key called "ip" containing an IP address <br>
    Example JSON data:</p>
    <pre class="hljs">
{
    "ip": "127.0.0.1"
}</pre>

    <p>Expected output from data above:</p>
    <pre class="hljs">
{
    ip:         "127.0.0.1"
    type: IPv4
    hostname:   localhost
}</pre>
</div>

