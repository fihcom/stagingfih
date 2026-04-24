<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// requiring autoload php
require_once APPPATH.'third_party/mpdf/vendor/autoload.php';
class M_pdf {
    public $pdf;
    public function __construct(){
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'margin_header' => 10, 'margin_footer' => 10]);
        $this->pdf = $mpdf;
    }
}