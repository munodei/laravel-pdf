<?php


namespace Niklasravnsborg\LaravelPdf;


use Mpdf\Mpdf;


class LaravelPdfWrapper
{
    protected $mpdf;


    public function __construct()
    {
        $this->mpdf = new Mpdf();
    }


    public function loadHTML($html)
    {
        $this->mpdf->WriteHTML($html);
        return $this;
    }


    public function loadFile($file)
    {
        $html = file_get_contents($file);
        return $this->loadHTML($html);
    }


    public function output()
    {
        return $this->mpdf->Output('', 'S');
    }


    public function loadView($view, $data = [], $mergeData = [])
    {
        $html = view($view, $data, $mergeData)->render();
        return $this->loadHTML($html);
    }


}
