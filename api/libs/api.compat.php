<?php
/* 
 * Framework abstraction functions and wrappers
 */

// replace for content output
if (!function_exists('show_window')) {
function show_window($title,$data,$align="left") {
    $result='
        <table width="100%" border="0" id="window">
        <tr>
            <td align="center">
            <b>'.$title.'</b>
            </td>
        </tr>
        <tr>
            <td align="'.$align.'">
            '.$data.'
            </td>
        </tr>
        </table>
        ';
    print($result);
}
}

//show error
if (!function_exists('show_error')) {
function show_error($data) {
    show_window('Error', $data);
}
}

//fast debug output
function deb($data) {
    show_window('DEBUG', $data);
}

//fast debug output of array
function debarr($data) {
    $result=print_r($data,true);
    $result='<pre>'.$result.'</pre>';
    show_window('DEBUG', $result);
}

//returns current date and time in mysql DATETIME view
function curdatetime() {
    $currenttime=date("Y-m-d H:i:s");
    return($currenttime);
}

//returns current time in mysql DATETIME view
function curtime() {
    $currenttime=date("H:i:s");
    return($currenttime);
}

//returns current date in mysql DATETIME view
function curdate() {
    $currentdate=date("Y-m-d");
    return($currentdate);
}


//returns current month in mysql DATETIME view
function curmonth() {
    $currentmonth=date("Y-m");
    return($currentmonth);
}

//returns current year
function curyear() {
    $currentyear=date("Y");
    return($currentyear);
}

// dummy webmorda logging
function log_register($event) {
    $admin_login=whoami();
    @$ip=$_SERVER['REMOTE_ADDR'];
    if (!$ip) {
        $ip='127.0.0.1';
    }
    $current_time=curdatetime();
    $event=mysql_real_escape_string($event);
    $query="INSERT INTO `weblogs` (`id`,`date`,`admin`,`ip`,`event`) VALUES(NULL,'".$current_time."','".$admin_login."','".$ip."','".$event."')";
    nr_query($query);
}

// stg_putlogevent dummy wrapper
if (!function_exists('stg_putlogevent')) {
function stg_putlogevent($event) {
    log_register($event);
}
}

//dummy lang function
if (!function_exists('__')) {
function __($str) {
    return($str);
}
}

//dummy function check for right via module

function cfr($right) {
    global $system;
    if ($system->checkForRight($right)) {
    return(true);
    } else {
    return(false);
    }
}

// replace for $system->user['username']
function whoami() {
    global $system;
    @$mylogin=$system->user['username'];
    if (empty($mylogin)) {
    $mylogin='external';
    }
    return($mylogin);
}


/** * Shows redirection javascript. 
 @param string $url 
 */
if (!function_exists('rcms_redirect')) {
function rcms_redirect($url, $header = false) {
    if($header){ 
        @header('Location: ' . $url); 
        
        } else { 
         echo '<script language="javascript">document.location.href="' . $url . '";</script>'; 
         }
   }
}


?>