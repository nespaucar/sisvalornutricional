<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Grupo;
use App\Models\Alimento;

use Google\Client;
use Google\Service\Sheets;
use Google\Service\Sheets\ValueRange;

ini_set('max_execution_time', 0);

class GoogleSheetsController extends Controller {

    public $client, $service, $documentId, $range;

    public function __construct() {
        $this->middleware('auth');
        $this->client = $this->getClient();
        $this->service = new Sheets($this->client);
        $this->documentId = '1Hd7ghwQH5ZeBMvcm5fyPWEDBv54IT8Wty6ZVl5GdccE';
        $this->range = 'A:Z';
    }

    public function getClient() {
        $client = new Client();
        $client->setApplicationName('Google Sheets PHP Integration');
        $client->setRedirectUri('http://localhost/valornutricional');
        $client->setScopes(Sheets::SPREADSHEETS);
        $client->setAuthConfig('credentials.json');
        $client->setAccessType('offline');

        return $client;
    }

    public function readSheet() {
        $doc = $this->service->spreadsheets_values->get($this->documentId, $this->range);
        return $doc;
    }

    public function writeSheet($values) {
        // $values = [
        // [] Additional Rows
        // ];

        $body = new ValueRange([
            'values' => $values
        ]);
        $params = [
            'valueInputOption' => 'RAW'
        ];
        $result = $this->service->spreadsheets_values->update($this->documentId, $this->range, $body, $params);
    }

    public function show($id)
    {
        //
    }

    public function sheetOperation(Request $request) {
        $data = $this->readSheet();
        $jsonData = json_decode(json_encode($data));
        $arrayData = array_filter($jsonData->values);
        $num = 0;
        foreach ($arrayData as $val) {

            // Para registrar alimentos desde Google SpreedSheets

            /*$grupo = Grupo::select('id')->where('codigo', '=', trim($val[0]))->first();
            $alimento = new Alimento();
            $alimento->grupo_id = $grupo->id;
            $alimento->numero = trim($val[1]);
            $alimento->descripcion = trim($val[2]);
            $alimento->energia_kcal = (is_numeric(trim($val[3]))?(trim($val[3])/100):NULL);
            $alimento->energia_kJ = (is_numeric(trim($val[4]))?(trim($val[4])/100):NULL);
            $alimento->agua = (is_numeric(trim($val[5]))?(trim($val[5])/100):NULL);
            $alimento->proteina = (is_numeric(trim($val[6]))?(trim($val[6])/100):NULL);
            $alimento->grasa = (is_numeric(trim($val[7]))?(trim($val[7])/100):NULL);
            $alimento->carbohidrato_total = (is_numeric(trim($val[8]))?(trim($val[8])/100):NULL);
            $alimento->carbohidrato_disponible = (is_numeric(trim($val[9]))?(trim($val[9])/100):NULL);
            $alimento->fibra_dietaria = (is_numeric(trim($val[10]))?(trim($val[10])/100):NULL);
            $alimento->ceniza = (is_numeric(trim($val[11]))?(trim($val[11])/100):NULL);
            $alimento->calcio = (is_numeric(trim($val[12]))?(trim($val[12])/100):NULL);
            $alimento->fosforo  = (is_numeric(trim($val[13]))?(trim($val[13])/100):NULL);
            $alimento->zinc = (is_numeric(trim($val[14]))?(trim($val[14])/100):NULL);
            $alimento->hierro = (is_numeric(trim($val[15]))?(trim($val[15])/100):NULL);
            $alimento->bcaroteno = (is_numeric(trim($val[16]))?(trim($val[16])/100):NULL);
            $alimento->vitaminaA = (is_numeric(trim($val[17]))?(trim($val[17])/100):NULL);
            $alimento->tiamina = (is_numeric(trim($val[18]))?(trim($val[18])/100):NULL);
            $alimento->riboflavina = (is_numeric(trim($val[19]))?(trim($val[19])/100):NULL);
            $alimento->niacina = (is_numeric(trim($val[20]))?(trim($val[20])/100):NULL);
            $alimento->vitaminaC = (is_numeric(trim($val[21]))?(trim($val[21])/100):NULL);
            $alimento->acido_folico = (is_numeric(trim($val[22]))?(trim($val[22])/100):NULL);
            $alimento->sodio = (is_numeric(trim($val[23]))?(trim($val[23])/100):NULL);
            $alimento->potasio = (is_numeric(trim($val[24]))?(trim($val[24])/100):NULL);
            $alimento->estrato = trim($val[25]);
            $alimento->estado = 1; //ACTIVO 
            $alimento->save();*/
            
            echo $num . " ALIMENTO " . $alimento->descripcion . " REGISTRADO CORRECTAMENTE.<br>";
            $num++;
        }
    }
}

