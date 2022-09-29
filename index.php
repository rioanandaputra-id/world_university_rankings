<?php

$rank = $_GET['rank'] ?? null;
switch ($rank) {
    case 1:
        qs_world_university();
        break;
    case 2:
        the_wur();
        break;
    case 3:
        uni_rank_tm();
        break;
    case 4:
        webometrics();
        break;
    case 5:
        ui_greenmetric();
        break;
    default:
        qs_world_university();
        break;
}

function qs_world_university()
{
    $type = $_GET['type'] ?? 'all';
    $region = $_GET['region'] ?? 'asia';
    $country = $_GET['country'] ?? 'Indonesia';
    $year = $_GET['year'] ?? (date('Y') -1);
    $base_url = "https://greenmetric.ui.ac.id/";

    if ($type == 'all') {
        $params = "rankings/overall-rankings-{$year}";
    }
    if ($type == 'region') {
        $params = "rankings/ranking-by-region-{$year}/{$region}";
    }
    if ($type == 'country') {
        $params = "rankings/ranking-by-country-{$year}/$country";
    }
    $curl = curl_init($base_url . $params);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    $page = curl_exec($curl);

    if (curl_errno($curl)) {
        echo "Scraper error: " . curl_error($curl);
        exit;
    }

    curl_close($curl);
    $DOM = new DOMDocument;
    libxml_use_internal_errors(true);

    if (!$DOM->loadHTML($page)) {
        $errors = "";
        foreach (libxml_get_errors() as $error) {
            $errors .= $error->message . "<br/>";
        }
        libxml_clear_errors();
        print "libxml errors:<br>$errors";
        return;
    }

    $DOM->preserveWhiteSpace = false;
    $tables = $DOM->getElementsByTagName('table');
    $data = [];

    foreach ($tables as $singleTable) {
        try {
            $trs = $singleTable->getElementsByTagName('tr');
            $ths = $trs[0]->getElementsByTagName('th');

            $isResultTable = FALSE;
            foreach ($ths as $ith) {
                if (trim($ith->textContent) === "University") {
                    $isResultTable = TRUE;
                }
            }
            if (!$isResultTable) continue;

            foreach ($trs as $itrs) {
                $td = $itrs->getElementsByTagName('td');
                if (!empty($td[0]->textContent)) {
                    $data[] = [
                        'rank' => $td[0]->textContent,
                        'university' => $td[1]->textContent,
                        'country' => $td[2]->textContent,
                        'total_score' => $td[3]->textContent,
                        'setting_infrastructure' => $td[4]->textContent,
                        'energy_climate_change' => $td[5]->textContent,
                        'waste' => $td[6]->textContent,
                        'water' => $td[7]->textContent,
                        'transportation' => $td[8]->textContent,
                        'education_research' => $td[9]->textContent,
                    ];
                }
            }
        } catch (Exception $ex) {
            print_r($ex);
        }
    }

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'status' => true,
        'message' => "greenmetric {$type} - {$year}",
        'data' => $data
    ]);
}

function the_wur()
{
    # code...
}

function uni_rank_tm()
{
    # code...
}

function webometrics()
{
    # code...
}

function ui_greenmetric()
{
    $type = $_GET['type'] ?? 'all';
    $region = $_GET['region'] ?? 'asia';
    $country = $_GET['country'] ?? 'Indonesia';
    $year = $_GET['year'] ?? (date('Y') -1);
    $base_url = "https://greenmetric.ui.ac.id/";

    if ($type == 'all') {
        $params = "rankings/overall-rankings-{$year}";
    }
    if ($type == 'region') {
        $params = "rankings/ranking-by-region-{$year}/{$region}";
    }
    if ($type == 'country') {
        $params = "rankings/ranking-by-country-{$year}/$country";
    }
    $curl = curl_init($base_url . $params);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    $page = curl_exec($curl);

    if (curl_errno($curl)) {
        echo "Scraper error: " . curl_error($curl);
        exit;
    }

    curl_close($curl);
    $DOM = new DOMDocument;
    libxml_use_internal_errors(true);

    if (!$DOM->loadHTML($page)) {
        $errors = "";
        foreach (libxml_get_errors() as $error) {
            $errors .= $error->message . "<br/>";
        }
        libxml_clear_errors();
        print "libxml errors:<br>$errors";
        return;
    }

    $DOM->preserveWhiteSpace = false;
    $tables = $DOM->getElementsByTagName('table');
    $data = [];

    foreach ($tables as $singleTable) {
        try {
            $trs = $singleTable->getElementsByTagName('tr');
            $ths = $trs[0]->getElementsByTagName('th');

            $isResultTable = FALSE;
            foreach ($ths as $ith) {
                if (trim($ith->textContent) === "University") {
                    $isResultTable = TRUE;
                }
            }
            if (!$isResultTable) continue;

            foreach ($trs as $itrs) {
                $td = $itrs->getElementsByTagName('td');
                if (!empty($td[0]->textContent)) {
                    $data[] = [
                        'rank' => $td[0]->textContent,
                        'university' => $td[1]->textContent,
                        'country' => $td[2]->textContent,
                        'total_score' => $td[3]->textContent,
                        'setting_infrastructure' => $td[4]->textContent,
                        'energy_climate_change' => $td[5]->textContent,
                        'waste' => $td[6]->textContent,
                        'water' => $td[7]->textContent,
                        'transportation' => $td[8]->textContent,
                        'education_research' => $td[9]->textContent,
                    ];
                }
            }
        } catch (Exception $ex) {
            print_r($ex);
        }
    }

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'status' => true,
        'message' => "greenmetric {$type} - {$year}",
        'data' => $data
    ]);
}
