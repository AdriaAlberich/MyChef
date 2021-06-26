<?php
require_once 'www.mychef.cat/dompdf/autoload.inc.php';

$dompdf = new DOMPDF();
$dompdf->load_html( file_get_contents( '/resourses/views/panel.blade.php' ) );
$dompdf->render();
$dompdf->stream("pedido.pdf");