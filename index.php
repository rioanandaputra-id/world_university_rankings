<?php
header('Content-Type: application/json; charset=utf-8');
$dom = new DOMDocument;
$table = file_get_contents('https://greenmetric.ui.ac.id/rankings/ranking-by-country-2021/Indonesia');
@$dom->loadHTML($table);
$dom->preserveWhiteSpace = false;
$tables = $dom->getElementsByTagName('table');
$data = [];

foreach ($tables as $singleTable) {
    try {
        $rows = $singleTable->getElementsByTagName('tr');
        $row1 = $rows[0]->getElementsByTagName('th');

        $isResultTable = FALSE;
        foreach ($row1 as $th) {
            if (trim($th->textContent) === 'Ranking') {
                $isResultTable = TRUE;
            }
        }

        if (!$isResultTable) continue;
        foreach ($rows as $row) {
            $cols = $row->getElementsByTagName('td');
            if (!empty($cols[0]->textContent)) {
                $data[] = [
                    'rank' => $cols[0]->textContent,
                    'university' => $cols[1]->textContent,
                    'country' => $cols[2]->textContent,
                    'total_score' => $cols[3]->textContent,
                    'setting_infrastructure' => $cols[4]->textContent,
                    'energy_climate_change' => $cols[5]->textContent,
                    'waste' => $cols[6]->textContent,
                    'water' => $cols[7]->textContent,
                    'transportation' => $cols[8]->textContent,
                    'education_research' => $cols[9]->textContent,
                ];
            }
        }
    } catch (Exception $ex) {
        print_r($ex);
    }
}

echo json_encode([
    'status' => true,
    'message' => 'Ranking by Country 2021 - Indonesia',
    'data' => $data
]);
