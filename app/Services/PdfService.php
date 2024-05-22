<?php

namespace App\Services;

use Smalot\PdfParser\Parser;

class PdfService
{
    protected $pdfParser;

    public function __construct(Parser $pdfParser)
    {
        $this->pdfParser = $pdfParser;
    }

    public function searchFor($word, $file)
    {
        $pdf = $this->pdfParser->parseFile($file->getPathname());
        $text = $pdf->getText();

        return stripos($text, $word) !== false;
    }
}