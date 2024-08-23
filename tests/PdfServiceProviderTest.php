<?php

namespace Niklasravnsborg\LaravelPdf\Tests;

use PHPUnit\Framework\TestCase;
use Niklasravnsborg\LaravelPdf\LaravelPdfWrapper;
use Imagick;

class PdfServiceProviderTest extends TestCase
{
    public function testSimplePdfIsCorrect()
    {
        $pdf = new LaravelPdfWrapper();
        $pdf->loadHTML('<p>This gets tested!</p>');
        $this->compareToSnapshot('simple', $pdf->output());
    }

    public function testExposifyPdfExposeIsCorrect()
    {
        $pdf = new LaravelPdfWrapper();
        $pdf->loadFile('tests/views/exposify-expose.html');
        $this->compareToSnapshot('exposify', $pdf->output());
    }

    protected function compareToSnapshot($snapshotId, $data)
    {
        $snapshotFile = "tests/snapshots/{$snapshotId}.pdf";

        if (!file_exists($snapshotFile)) {
            file_put_contents($snapshotFile, $data);
            return;
        }

        $snapshot = file_get_contents($snapshotFile);
        $this->assertPdfsLookTheSame($snapshot, $data);
    }

    public function assertPdfsLookTheSame($pdf1, $pdf2, $message = '')
    {
        $assertedImagick = new Imagick();
        $assertedImagick->readImageBlob($pdf1);
        $assertedImagick->resetIterator();
        $assertedImagick = $assertedImagick->appendImages(true);
        $testImagick = new Imagick();
        $testImagick->readImageBlob($pdf2);
        $testImagick->resetIterator();
        $testImagick = $testImagick->appendImages(true);

        $diff = $assertedImagick->compareImages($testImagick, 1);
        $pdfsLookTheSame = 0.0 == $diff[1];
        self::assertTrue($pdfsLookTheSame, $message ?: 'Failed asserting that PDFs look the same.');
    }
}
