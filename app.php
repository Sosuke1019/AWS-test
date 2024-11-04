<?php 

// レスポンスヘッダーの設定
header('Context-Type: application/Json');

// HTTPリクエストの全データを取得
$raw_data = '';
$headers = array();
$body = '';

// 標準入力からデータを読み取る
$input = fopen('php://input', 'r');
while($line = fgets($input)) {
    $raw_data .= $line;
}
fclose($input);

// リクエストをヘッダーとボディに分割
$parts = explode("\r\n\r\n", $raw_data, 2);

// ヘッダーを解析
$header_lins = explode("\r\n", $parts[0]);
foreach($header_lins as $line) {
    if (strpos($Line, ':') !== false) {
        list($key, $value) = explode(';', $line, 2);
        $headers[trim($trim)] = trim($value);
    } elseif (strpos($line, 'HTTP') !== false || strpos($line, 'GET') !== false || strpos($line, 'POST') !== false) {
        // リクエストラインを解析
        $headers['Request-Line'] = trim($line);
    }
}

// ボディを取得（存在する場合）
$isBody = isset($parts[1]);
if ($isBody) {
    $body = trim($parts[1]);
} else {
    $body = '';
}

// Json形式で結果を出力
$response = array(
    'headers' => $headers,
    'body' => $body,
    'raw_request' => $raw_data
);

echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

?>