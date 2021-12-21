<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class EjemploExport implements 
	FromView,
    ShouldAutoSize,
    WithDrawings,
    WithStyles
{
    use Exportable;

	private $variable1;
	private $variable2;

	public function __construct($variable1, $variable2) {
		$this->variable1 = $variable1;
		$this->variable2 = $variable2;
	}

	public function view(): View {
        return view('reporte.algunavista', [
            'variable1' => $this->variable1,
            'variable2' => $this->variable2,
        ]);
    }

    public function drawings() {
    	$drawing = new Drawing();
    	$drawing->setName('Logo del Reporte');
    	$drawing->setDescription('Descripción del Reporte');
    	$drawing->setPath(public_path('logo.png'));
    	$drawing->setHeight(90);
    	$drawing->setCoordinates('B2');
    	return $drawing;
    }

    public function styles(Worksheet $sheet) {
        $style = array(
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            )
        );
        $styleTitle = array(
            'font' => array(
                'size' =>  18,
                'bold' =>  true
            )
        );
        $style1 = array(
            'font' => array(
                'bold' =>  true
            )
        );
        $style2 = array(
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
            )
        );
        $sheet->getStyle("A:G")->applyFromArray($style);
        $sheet->getStyle('A7')->applyFromArray($styleTitle);
        $sheet->getStyle('A9')->applyFromArray($style1);
        $sheet->getStyle('B9')->applyFromArray($style2);
        $sheet->mergeCells('A7:G7');
        $sheet->mergeCells('B9:G9');
        $sheet->getCellByColumnAndRow(1, 7)->setValue('TÍTULO DE REPORTE');
        $sheet->getCellByColumnAndRow(1, 9)->setValue('Línea adicional de reporte');
        $sheet->getCellByColumnAndRow(2, 9)->setValue($this->mercader->persona->nombre);
    }
}
