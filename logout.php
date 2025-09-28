<?php
session_start();
session_unset();
session_destroy();
// Redirect back to the home page (where the user will see SIGN IN/REGISTER)
header('Location: index.php');
exit();
?>