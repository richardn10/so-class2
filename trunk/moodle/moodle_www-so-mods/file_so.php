<?php // $Id: file.php,v 1.46.2.4 2008/07/10 09:48:43 scyrma Exp $
      // This is a rip-off of the default file.php!
      // Since file.php doesn't allow files outside of course directories (1, 2, etc.).
      // This version also has minimal security.
      //
      // This script fetches files *only* from the $CFG->dataroot_so_data directory.
      //
      // Syntax:      file_so.php/dir/dir/dir/filename.ext
      //              file_so.php/dir/dir/dir/filename.ext?forcedownload=1 (download instead of inline)
      // Workaround:  file_so.php?file=/dir/dir/dir/filename.ext
      // Test:        file_so.php/testslasharguments


    require_once('config.php');
    require_once('lib/filelib.php');

    if (!isset($CFG->filelifetime)) {
        $lifetime = 86400;     // Seconds for files to remain in caches
    } else {
        $lifetime = $CFG->filelifetime;
    }

    // disable moodle specific debug messages
    disable_debugging();

    $relativepath = get_file_argument('file.php');
    $forcedownload = optional_param('forcedownload', 0, PARAM_BOOL);
    
    // relative path must start with '/', because of backup/restore!!!
    if (!$relativepath) {
        error('No valid arguments supplied or incorrect server configuration');
    } else if ($relativepath{0} != '/') {
        error('No valid arguments supplied, path does not start with slash!');
    }

    $pathname = $CFG->dataroot_so_data.$relativepath;

    // extract relative path components
    $args = explode('/', trim($relativepath, '/'));
    if (count($args) == 0) { // always at least one pathitem
        error('No valid arguments supplied');
    }
  
    // security: login to course if necessary
    // Note: file.php always calls require_login() with $setwantsurltome=false
    //       in order to avoid messing redirects. MDL-14495
    if ($CFG->forcelogin) {
        if (!empty($CFG->sitepolicy)
            and ($CFG->sitepolicy == $CFG->wwwroot.'/file.php'.$relativepath
                 or $CFG->sitepolicy == $CFG->wwwroot.'/file.php?file='.$relativepath)) {
            //do not require login for policy file
        } else {
            require_login(0, true, null, false);
        }
    }

    if (is_dir($pathname)) {
        // security: do not return directory node!
        not_found();
    }

    // check that file exists
    if (!file_exists($pathname)) {
        not_found();
    }

    // ========================================
    // finally send the file
    // ========================================
    session_write_close(); // unlock session during fileserving
    $filename = $args[count($args)-1];
    send_file($pathname, $filename, $lifetime, $CFG->filteruploadedfiles, false, $forcedownload);

    function not_found() {
        global $CFG;
        header('HTTP/1.0 404 not found');
        print_error('filenotfound', 'error', $CFG->wwwroot); //this is not displayed on IIS??
    }
?>
