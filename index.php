<?php
header('Content-Type: application/json; charset=utf-8');

$category = $_GET['category'] ?? null;
switch ($category) {
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
    try {
        $file = file_get_contents("https://www.topuniversities.com/sites/default/files/qs-rankings-data/en/3740566.txt?rillxx");
        echo json_encode([
            'status' => true,
            'message' => "unirank tm",
            'data' => json_decode($file)
        ]);
    } catch (Exception $e) {
        echo json_encode([
            'status' => false,
            'message' => "unirank tm",
            'data' => $e
        ]);
    }
}

function the_wur()
{
    try {
        $file = file_get_contents("https://www.timeshighereducation.com/sites/default/files/the_data_rankings/world_university_rankings_2022_0__e7070f0c2581be5fe6ab6392da206b36.json");
        echo json_encode([
            'status' => true,
            'message' => "unirank tm",
            'data' => json_decode($file)
        ]);
    } catch (Exception $e) {
        echo json_encode([
            'status' => false,
            'message' => "unirank tm",
            'data' => $e
        ]);
    }
}

function uni_rank_tm()
{
    try {
        $dom = new DOMDocument;
        $table = file_get_contents("https://www.4icu.org/id/");
        @$dom->loadHTML($table);
        $dom->preserveWhiteSpace = false;
        $tables = $dom->getElementsByTagName('table');
        $data = [];

        foreach ($tables as $singleTable) {
            $rows = $singleTable->getElementsByTagName('tr');
            $row1 = $rows[1]->getElementsByTagName('th');

            $isResultTable = FALSE;
            foreach ($row1 as $th) {
                if (trim($th->textContent) === 'University') {
                    $isResultTable = TRUE;
                }
            }

            if (!$isResultTable) continue;
            foreach ($rows as $row) {
                $cols = $row->getElementsByTagName('td');
                if (!empty($cols[2]->textContent)) {
                    $data[] = [
                        'rank' => $cols[0]->textContent,
                        'university' => $cols[1]->textContent,
                        'town' => $cols[2]->textContent,
                    ];
                }
            }
        }

        echo json_encode([
            'status' => true,
            'message' => "unirank tm",
            'data' => $data
        ]);
    } catch (Exception $e) {
        echo json_encode([
            'status' => false,
            'message' => "unirank tm",
            'data' => $e
        ]);
    }
}

function webometrics()
{
    try {
        $page = $_GET['page'] ?? 1;
        $dom = new DOMDocument;
        $table = file_get_contents("https://www.webometrics.info/en/Asia/Indonesia/?page={$page}");
        @$dom->loadHTML($table);
        $dom->preserveWhiteSpace = false;
        $tables = $dom->getElementsByTagName('table');
        $data = [];

        foreach ($tables as $singleTable) {
            $rows = $singleTable->getElementsByTagName('tr');
            $row1 = $rows[0]->getElementsByTagName('th');

            $isResultTable = FALSE;
            foreach ($row1 as $th) {
                if (trim($th->textContent) === 'World Rank') {
                    $isResultTable = TRUE;
                }
            }

            if (!$isResultTable) continue;
            foreach ($rows as $row) {
                $cols = $row->getElementsByTagName('td');
                if (!empty($cols[0]->textContent)) {
                    $data[] = [
                        'rank' => $cols[0]->textContent,
                        'word_rank' => $cols[1]->textContent,
                        'university' => $cols[2]->textContent,
                        'impact_rank' => $cols[4]->textContent,
                        'openness_rank' => $cols[5]->textContent,
                        'excellence_rank' => $cols[6]->textContent,
                    ];
                }
            }
        }

        echo json_encode([
            'status' => true,
            'message' => "webometrics",
            'data' => $data
        ]);
    } catch (Exception $e) {
        echo json_encode([
            'status' => false,
            'message' => "webometrics",
            'data' => $e
        ]);
    }
}

function ui_greenmetric()
{
    try {
        $year = $_GET['year'] ?? (date('Y') - 1);
        $base_url = "https://greenmetric.ui.ac.id/rankings/ranking-by-country-{$year}/Indonesia";
        $dom = new DOMDocument;
        $table = file_get_contents($base_url);
        @$dom->loadHTML($table);
        $dom->preserveWhiteSpace = false;
        $tables = $dom->getElementsByTagName('table');
        $data = [];

        foreach ($tables as $singleTable) {
            $rows = $singleTable->getElementsByTagName('tr');
            $row1 = $rows[0]->getElementsByTagName('th');

            $isResultTable = FALSE;
            foreach ($row1 as $th) {
                if (trim($th->textContent) === 'University') {
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
        }

        echo json_encode([
            'status' => true,
            'message' => "ui greenmetric",
            'data' => $data
        ]);
    } catch (Exception $e) {
        echo json_encode([
            'status' => false,
            'message' => "ui greenmetric",
            'data' => $e
        ]);
    }
}
