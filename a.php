<?php
$lines=file("named1.txt",FILE_IGNORE_NEW_LINES);
$lines2=file("named2.txt",FILE_IGNORE_NEW_LINES);
$new_lines="{$lines[rand(0,4)]}{$lines2[rand(0,2)]}";
echo $new_lines;
?>