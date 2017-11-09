Created by framework Yii (1.*)

Task 1:

lib - Google Drive: protected/vendor/GoogleLib
Controller: protected/controllers/GoogleDiskController.php
View: protected/views/googleDisk/index.php

Task 2:

Database MySQL version 4.6.4: protected/data/test.sql
Controller: protected/controllers/PagesController.php
Views and forms: protected/views/pages

Task 3:

<?php
/*
* describe what this code is doing
* notice - it is Postgresql - supposedly not familiar to you database and you need to
read the documentation before you answer
*/
//
for($i = 0; $i<10000000; $i++) {

    /*
     * create temp table tmp1 from query results with one column id
     * from table users
     * return empty table because conditions u.id=u1.id AND u.id>u1.id exclude each other
     */
    $result = DB::query('
        CREATE TEMPORARY TABLE tmp1 AS
        SELECT u.id
        FROM users AS u
        INNER JOIN users AS u1 ON (u.id=u1.id AND u.id>u1.id)
        WHERE u.email=u1.email AND u.status=1 AND u1.status=1
        LIMIT 100');
    /*
     * get count rows in tmp1
     * in MySQL work this query 'SELECT COUNT(*) AS return_count FROM tmp1'
     */
    $result_count = DB::query('SELECT COUNT(*) INTO return_count FROM tmp1', 'one');

    //Update status in table users all rows  from table tmp1
    $result = DB::query('
        UPDATE users AS u
        SET status=2
        FROM (
        SELECT id FROM tmp1
        ) AS t
        WHERE u.id=t.id;');

    // delete table tmp1
    $result = DB::query('DROP TABLE tmp1');

    if ($result_count < 100) break;
    //echo $i . ' ';
}