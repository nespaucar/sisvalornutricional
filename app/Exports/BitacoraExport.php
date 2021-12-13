<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class BitacoraExport implements 
    FromView,
    ShouldAutoSize,
    WithDrawings,
    WithColumnWidths,
    WithStyles
{
	use Exportable;

	private $name;
	private $fecha;
	private $lista;
	private $cabecera;

	public function __construct($name, $fecha, $lista, $cabecera) {
		$this->name = $name;
		$this->fecha = $fecha;
		$this->lista = $lista;
		$this->cabecera = $cabecera;
	}

	public function view(): View {
        return view('reporte.bitacora', [
            'name' => $this->name,
            'fecha' => $this->fecha,
            'lista' => $this->lista,
            'cabecera' => $this->cabecera,
        ]);
    }

    public function drawings() {
    	$drawing = new Drawing();
    	$drawing->setName('Logo de la Municipalidad');
    	$drawing->setDescription('Municipalidad Provincial de San Ignacio');
    	$drawing->setPath(public_path('logo.png'));
    	$drawing->setHeight(90);
    	$drawing->setCoordinates('B2');

    	return $drawing;
    }

    public function columnWidths(): array {
        if(count($this->lista) > 0) {
            return [
                'C' => 100,
            ];
        }
        return [];
    }

    public function styles(Worksheet $sheet) {            
        if(count($this->lista) > 0) {
            $sheet->getStyle('C')->getAlignment()->setWrapText(true);
            $style = array(
                'alignment' => array(
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                )
            );
            $styleC = array(
                'alignment' => array(
                    'horizontal' => Alignment::HORIZONTAL_LEFT,
                    'vertical' => Alignment::VERTICAL_CENTER,
                )
            );
            $styleTitle = array(
                'font' => array(
                    'size' =>  18,
                    'bold' =>  true
                )
            );
            $sheet->getStyle("A:F")->applyFromArray($style);
            $sheet->getStyle("C")->applyFromArray($styleC);        
            $sheet->getStyle('A7')->applyFromArray($styleTitle);
            $sheet->mergeCells('A7:F7');
            $sheet->getCellByColumnAndRow(1, 7)->setValue('REPORTE DE BITÁCORA - SISTEMA DE PAGOS');
        }
    }
}
