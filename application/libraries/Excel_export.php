<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// requiring autoload php of spreadsheet
require_once APPPATH.'third_party/PHPSpreadsheet/vendor/autoload.php';

// Use Case of Spreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Excel_export {
    public $spreadsheet;

    public function __construct(){
        $createdSheet = new Spreadsheet();
        $this->spreadsheet = $createdSheet;
    }

    public function createdXlsx($returnedSpreadsheet){
        $createdXlsx = new Xlsx($returnedSpreadsheet);
        return $createdXlsx;
    }
}