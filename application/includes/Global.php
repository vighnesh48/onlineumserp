<?php
/*******************************************
#  Global File to be included in each file
/*******************************************/

// Global Seetings
ini_set("display_errors",1);

global $max_entries_per_page,$default_user_priv_path,$privilege_prefix;
$max_entries_per_page=5;

$default_user_priv_path="user_privileges/";
$privilege_prefix="user_priv_";
        
global $menudata,$sessionArray,$privData;
$menudata=array();
$sessionArray=array();
$privData=array();

global $masterButtonList,$projectList;
?>