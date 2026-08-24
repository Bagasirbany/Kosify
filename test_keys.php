<?php
$keys = [
    'SB-Mid-server-TOq1a2WVh_qS5_sI13N1VvG0',
    'SB-Mid-server-GwUP_WGbSnEpBgCGqKsY1qcQ',
    'SB-Mid-server-TNM786Hw8yH_FHTa8lU6b76-',
    'SB-Mid-server-B1tQ42VdOqYc0s1W9J0F73L',
    'SB-Mid-server-41-l8O5uF4V_7w-T7H7hP6U_',
    'SB-Mid-server-Y0FjX3vF_r5g1iO0i6Y9wN9w'
];
foreach($keys as $k) {
    $ch = curl_init('https://app.sandbox.midtrans.com/snap/v1/transactions');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Accept: application/json',
        'Authorization: Basic ' . base64_encode($k . ':')
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
        'transaction_details' => [
            'order_id' => 'test-'.time().'-'.rand(100, 999),
            'gross_amount' => 10000
        ]
    ]));
    $res = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    echo $k . ' -> ' . $httpcode . "\n";
}
