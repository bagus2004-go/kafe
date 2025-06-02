<?php 
if (isset($success_msg)) { 
    // Check if it's an array, if not make it one
    $messages = is_array($success_msg) ? $success_msg : [$success_msg];
    foreach ($messages as $message) { 
        echo '<script>swal("'.$message.'", "", "success")</script>'; 
    } 
} 

if (isset($warning_msg)) { 
    $messages = is_array($warning_msg) ? $warning_msg : [$warning_msg];
    foreach ($messages as $message) { 
        echo '<script>swal("'.$message.'", "", "warning")</script>'; 
    } 
} 

if (isset($info_msg)) { 
    $messages = is_array($info_msg) ? $info_msg : [$info_msg];
    foreach ($messages as $message) { 
        echo '<script>swal("'.$message.'", "", "info")</script>'; 
    } 
} 

if (isset($error_msg)) { 
    $messages = is_array($error_msg) ? $error_msg : [$error_msg];
    foreach ($messages as $message) { 
        echo '<script>swal("'.$message.'", "", "error")</script>'; 
    } 
} 
?>