<?php

namespace App\Controllers;

class Documentos extends BaseController
{
    // Mostrar el panel de documentos
    public function index()
    {
        return view('documentos/index');
    }

    // Generar documento Word
    public function word()
    {
        $documento = new \PhpOffice\PhpWord\PhpWord();

        $seccion = $documento->addSection();

        $seccion->addTitle(
            'Producto integrador Backend',
            1
        );

        $seccion->addText(
            'Generación de documentos Word con CodeIgniter 4.'
        );

        $seccion->addText(
            'Materia: Lenguajes de programación Backend.'
        );

        $ruta = WRITEPATH . 'documento_word.docx';

        $writer = \PhpOffice\PhpWord\IOFactory::createWriter(
            $documento,
            'Word2007'
        );

        $writer->save($ruta);

        return $this->response
            ->download($ruta, null)
            ->setFileName('actividad_integradora.docx');
    }

    // Generar archivo Excel
    public function excel()
    {
        $excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

        $hoja = $excel->getActiveSheet();

        $hoja->setCellValue('A1', 'ID');
        $hoja->setCellValue('B1', 'Nombre');
        $hoja->setCellValue('C1', 'Materia');

        $hoja->setCellValue('A2', 1);
        $hoja->setCellValue('B2', 'Ejemplo de usuario');
        $hoja->setCellValue(
            'C2',
            'Lenguajes de programación Backend'
        );

        $ruta = WRITEPATH . 'documento_excel.xlsx';

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx(
            $excel
        );

        $writer->save($ruta);

        $excel->disconnectWorksheets();
        unset($excel);

        return $this->response
            ->download($ruta, null)
            ->setFileName('actividad_integradora.xlsx');
    }

    // Generar documento PDF
    public function pdf()
    {
        $pdf = new \FPDF();

        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);

        $pdf->Cell(
            0,
            12,
            'Producto integrador Backend',
            0,
            1,
            'C'
        );

        $pdf->SetFont('Arial', '', 12);

        $pdf->MultiCell(
            0,
            10,
            'Documento PDF generado con CodeIgniter 4 y FPDF.'
        );

        $contenido = $pdf->Output('S');

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader(
                'Content-Disposition',
                'attachment; filename="actividad_integradora.pdf"'
            )
            ->setBody($contenido);
    }

    // Generar imagen PNG
    public function png()
    {
        if (!extension_loaded('gd')) {
            return redirect()->to(site_url('documentos'))
                ->with(
                    'error',
                    'La extensión GD no está habilitada.'
                );
        }

        $imagen = imagecreatetruecolor(800, 400);

        $fondo = imagecolorallocate($imagen, 245, 245, 245);
        $azul = imagecolorallocate($imagen, 0, 102, 204);
        $negro = imagecolorallocate($imagen, 30, 30, 30);

        imagefill($imagen, 0, 0, $fondo);

        imagefilledrectangle(
            $imagen,
            0,
            0,
            800,
            75,
            $azul
        );

        imagestring(
            $imagen,
            5,
            230,
            28,
            'PRODUCTO INTEGRADOR BACKEND',
            imagecolorallocate($imagen, 255, 255, 255)
        );

        imagestring(
            $imagen,
            4,
            190,
            160,
            'Lenguajes de programacion Back End',
            $negro
        );

        imagestring(
            $imagen,
            4,
            255,
            210,
            'Imagen generada con PHP GD',
            $negro
        );

        ob_start();
        imagepng($imagen);
        $contenido = ob_get_clean();

        imagedestroy($imagen);

        return $this->response
            ->setHeader('Content-Type', 'image/png')
            ->setHeader(
                'Content-Disposition',
                'attachment; filename="actividad_integradora.png"'
            )
            ->setBody($contenido);
    }
}
