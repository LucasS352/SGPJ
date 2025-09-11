<?php

$sqlFile = 'processos.sql';
$jsonFile = 'processos.json';

$sql = file_get_contents($sqlFile);

// Extrai todos os INSERT INTO processos
preg_match_all("/INSERT INTO `processos` .*? VALUES\s*(.+?);/is", $sql, $matches);

$allRows = [];

foreach ($matches[1] as $block) {
    $block = str_replace(["\r", "\n"], '', $block);

    $tuplas = preg_split("/\),\s*\(/", trim($block, "();"));

    foreach ($tuplas as $tuple) {
        $tuple = trim($tuple);

        $fields = [];
        $current = '';
        $inString = false;

        for ($i = 0; $i < strlen($tuple); $i++) {
            $char = $tuple[$i];

            if ($char === "'" && ($i == 0 || $tuple[$i-1] !== "\\")) {
                $inString = !$inString;
            }

            if ($char === "," && !$inString) {
                $fields[] = trim($current, " '");
                $current = '';
                continue;
            }

            $current .= $char;
        }

        $fields[] = trim($current, " '");

        if (count($fields) === 6) {
            $allRows[] = [
                'id' => (int)$fields[0],
                'numero_processo' => $fields[1],
                'nome_reu' => $fields[2],
                'cpf_cnpj_reu' => $fields[3],
                'valor_causa' => $fields[4],
                'status' => $fields[5],
            ];
        }
    }
}

file_put_contents($jsonFile, json_encode($allRows, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

echo " JSON gerado com sucesso: $jsonFile\n";