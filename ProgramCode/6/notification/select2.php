<?php

require 'dompdf/vendor/autoload.php';
// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();
$dompdf->set_options(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);
ob_start();
require('select.php');
$content = ob_get_clean();

$dompdf->loadHtml($content);



// (Optional) Setup the paper size and orientation 'A4', 'landscape'
$dompdf->setPaper('A4', 'portrain');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream();

?>
