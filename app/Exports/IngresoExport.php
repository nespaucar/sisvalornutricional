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

class IngresoExport implements 
	FromView,
    ShouldAutoSize,
    WithDrawings,
    WithStyles
{
	use Exportable;
	
    private $lista;
	private $cabecera;

	public function __construct($fecha, $fechai, $fechaf, $mes, $anno, $ingresosTotal, $lista, $cabecera) {		
		$this->fecha = $fecha;
		$this->fechai = $fechai;
		$this->fechaf = $fechaf;
		$this->mes = $mes;
		$this->anno = $anno;
		$this->ingresosTotal = $ingresosTotal;
		$this->lista = $lista;
		$this->cabecera = $cabecera;
	}

	public function view(): View {
        return view('reporte.ingreso', [
            'ingresosTotal' => $this->ingresosTotal,
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

    public function styles(Worksheet $sheet) {
    	if(count($this->lista) > 0) {
	        $sheet->getStyle('C')->getAlignment()->setWrapText(true);
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
	        $sheet->getStyle("A:I")->applyFromArray($style);
	        $sheet->mergeCells('A7:J7');
	        $sheet->getStyle('A7')->applyFromArray($styleTitle);
	        $sheet->getCellByColumnAndRow(1, 7)->setValue('REPORTE DE INGRESOS - SISTEMA DE PAGOS');
	    }
    }
}
