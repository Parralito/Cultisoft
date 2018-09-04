<?php

    $DBUSER="root";
    $DBPASSWD="root";
    $DATABASE="sircap_bd";

    $filename = "backup-" . date("d-m-Y") . ".sql.gz";
    $mime = "application/sql";

    //header( "Content-Type: " . $mime );
    //header( 'Content-Disposition: attachment; filename="' . $filename . '"' );

    $cmd = "mysqldump -u $DBUSER --password=$DBPASSWD $DATABASE";

    // http://localhost/Sircap/back.php
    echo $cmd;

    //passthru( $cmd );

    //exit(0);

    /*
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $host = 'localhost';
    //$dir = dirname(__FILE__) . '/backup/backup-' . date("d-m-Y") . '.sql';
    $dir = '"'.dirname(__FILE__) . '\backup\backup-' . date("d-m-Y") . '.sql"';
    echo ("mysqldump --user={$DBUSER} --password={$DBPASSWD} --host={$host} {$DATABASE} > {$dir}");
    //--host={$host}
    //exec("mysqldump --user={$DBUSER} --password={$DBPASSWD} {$DATABASE} > {$dir}",$output, $result);
    passthru("mysqldump --user={$DBUSER} --password={$DBPASSWD} {$DATABASE} > {$dir}");

    */
    
   
?>