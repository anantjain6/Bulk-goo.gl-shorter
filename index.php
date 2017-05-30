<?php

// Add your API key here:
$google_key = "XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX";

function shorten($url)
{
    $gurl = "https://www.googleapis.com/urlshortener/v1/url?key=" . $GLOBALS['google_key'];
    $url  = json_encode(array("longUrl" => $url));
    $ch   = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_URL, $gurl);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept: appliaction/json", "Content-Type: application/json"));
    
    $r = json_decode(curl_exec($ch));
    return $r->id;
}

?>

<html>
    <head>
        <title>Bulk goo.gl shorter</title>

        <!-- Including Bootstrap files for theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </head>
    <body>
        <div style="max-width:360px;margin-left: auto; margin-right: auto;">
            <center>
                <h1>Bulk goo.gl shporter</h1>
                <form action="index.php" method="POST">
                    <textarea name="url" placeholder="Type your URLs here, onre line each" class="form-control"></textarea>
                    <br/>
                    <input type="submit" value="Short All" class="btn btn-success"/>
                </form>
                <?php
                
                if( isset($_POST['url']) )
                {
                    $text = trim($_POST['url']);
                    $textAr = explode("\n", $text);
                    $textAr = array_filter($textAr, 'trim'); // remove any extra \r characters left behind
                    
                    echo '<br>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Short URL</th>
                                    <th>Long URL</th>
                                </tr>
                            <thead>
                            <tbody>';
                    
                    foreach ($textAr as $line)
                    {
                        echo '<tr>
                                <td>'.shorten($line).'</td>
                                <td>'.$line.'</td>
                            </tr>';
                    }
                    
                    echo '</tbody>
                    </table>';
                    
                }
                
                ?>
            </center>
        </div>
    </body>
</html>