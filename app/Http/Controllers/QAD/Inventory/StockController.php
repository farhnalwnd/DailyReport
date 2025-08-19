<?php

namespace App\Http\Controllers\QAD\Inventory;

use App\Http\Controllers\Controller;
use App\Jobs\DailyReport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StockController extends Controller
{
     // GET DATA EXPORT
    private function httpHeader($req)
    {
        return array(
            'Content-type: text/xml;charset="utf-8"',
            'Accept: text/xml',
            'Cache-Control: no-cache',
            'Pragma: no-cache',
            'SOAPAction: ""',
            'Content-length: ' . strlen(preg_replace("/\s+/", " ", $req))
        );
    }


    public function getInventoryStock()
    {
        $qxUrl = 'http://smii.qad:24079/wsa/smiiwsa';
        $timeout = 10;

        // Prepare SOAP request
        $qdocRequest =
            '<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
                <Body>
                    <getInventoryStock xmlns="urn:services-qad-com:smiiwsa:0001:smiiwsa"/>
                </Body>
            </Envelope>';

        $curlOptions = array(
            CURLOPT_URL => $qxUrl,
            CURLOPT_CONNECTTIMEOUT => $timeout,
            CURLOPT_TIMEOUT => $timeout + 5,
            CURLOPT_HTTPHEADER => $this->httpHeader($qdocRequest),
            CURLOPT_POSTFIELDS => preg_replace("/\s+/", " ", $qdocRequest),
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false
        );

        $curl = curl_init();
        if ($curl) {
            curl_setopt_array($curl, $curlOptions);
            $qdocResponse = curl_exec($curl);
            curl_close($curl);
        } else {
            Log::error('Gagal menghubungi server.');
            return;
        }

        if (!$qdocResponse) {
            Log::error('Tidak ada respons dari server.');
            return;
        }

        $xmlResp = simplexml_load_string($qdocResponse);
        $xmlResp->registerXPathNamespace('ns', 'urn:services-qad-com:smiiwsa:0001:smiiwsa');

        $rows = $xmlResp->xpath('//ns:getInventoryStockResponse/ns:StockTable/ns:StockTableRow');
        $data = [];

        if (count($rows) > 0) {
            foreach ($rows as $item) {
                $data[] = [
                    'tt_pt_part' => (string) $item->tt_pt_part,
                    'tt_pt_desc1' => (string) $item->tt_pt_desc1,
                    'tt_pt_sfty_stk' => (string) $item->tt_pt_sfty_stk,
                    'tt_total_qty' => (string) $item->tt_total_qty,
                ];
            }
        }

        if (!empty($data)) {
            $users = User::role('stocker')->get();
            foreach ($users as $user){
                DailyReport::dispatch($data, $user);
            }
        } else {
            Log::warning('Tidak ada data inventaris untuk dikirim.');
        }

        Log::info('Inventory Stock Data:', $data);
    }
}
