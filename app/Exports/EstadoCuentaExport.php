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

class EstadoCuentaExport implements 
	FromView,
    ShouldAutoSize,
    WithDrawings,
    WithStyles
{
    use Exportable;

	private $anno;
	private $detconceptopago;
	private $mercader;
	private $cabecera;

	public function __construct($totPagar, $totPagado, $totDeuda, $anno, $detconceptopago, $mercader, $cabecera) {
		$this->anno = $anno;
		$this->detconceptopago = $detconceptopago;
		$this->mercader = $mercader;
        $this->cabecera = $cabecera;
        $this->totPagar = $totPagar;
        $this->totPagado = $totPagado;
		$this->totDeuda = $totDeuda;
	}

	public function view(): View {
        return view('reporte.estadocuenta', [
            'anno' => $this->anno,
            'detconceptopago' => $this->detconceptopago,
            'mercader' => $this->mercader,
            'cabecera' => $this->cabecera,
            'totPagar' => $this->totPagar,
            'totPagado' => $this->totPagado,
            'totDeuda' => $this->totDeuda,
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
        $styleMercader = array(
            'font' => array(
                'bold' =>  true
            )
        );
        $styleMercader2 = array(
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
            )
        );
        $sheet->getStyle("A:G")->applyFromArray($style);
        $sheet->getStyle('A7')->applyFromArray($styleTitle);
        $sheet->getStyle('A9')->applyFromArray($styleMercader);
        $sheet->getStyle('B9')->applyFromArray($styleMercader2);
        $sheet->mergeCells('A7:G7');
        $sheet->mergeCells('B9:G9');
        $sheet->getCellByColumnAndRow(1, 7)->setValue('REPORTE DE ESTADO DE CUENTA - SISTEMA DE PAGOS');
        $sheet->getCellByColumnAndRow(1, 9)->setValue('Mercader');
        $sheet->getCellByColumnAndRow(2, 9)->setValue($this->mercader->persona->nombre);
    }
}
