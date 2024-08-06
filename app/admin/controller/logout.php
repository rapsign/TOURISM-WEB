<?php
session_start();                    // START: Mulai sesi

session_destroy();                  // START: Hancurkan sesi

header("Location: ../index.php");   // Redirect ke halaman index
exit();                             // Hentikan eksekusi script
// END: Hancurkan sesi dan redirect
?>
