<?php
/**
 * Function to localize our site
 * @param $site The Site object
 */
return function(Steampunked\Site $site) {
    // Set the time zone
    date_default_timezone_set('America/Detroit');

    $site->setEmail('wiechecm@cse.msu.edu');
    $site->setRoot('/~wiechecm/project2');
    $site->dbConfigure('mysql:host=mysql-user.cse.msu.edu;dbname=wiechecm',
        'wiechecm',       // Database user
        'Cr00ked92%',     // Database password
        'P2_');            // Table prefix
};