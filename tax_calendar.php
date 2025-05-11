<?php
// 配置
$areaCode = "137000000"; // 山东省（可按汶上县调整）
$year = date('Y');
$month = date('n');
$cacheFile = __DIR__ . "/tax_calendar_{$year}_{$month}.json";

// 采集及缓存
if (file_exists($cacheFile) && time() - filemtime($cacheFile) < 86400) {
    $list = json_decode(file_get_contents($cacheFile), true) ?: [];
} else {
    $url = "https://12366.chinatax.gov.cn/bsfw/calendar/getCalendarListForMonth";
    $postData = json_encode([
        "xzqhbm" => $areaCode,
        "year"   => (string)$year,
        "month"  => (string)$month
    ]);
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "User-Agent: Mozilla/5.0"
    ]);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);
    $list = [];
    if (isset($result["statusCode"]) && $result["statusCode"] == "200") {
        $list = $result["json"]["list"] ?? [];
        file_put_contents($cacheFile, json_encode($list, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    }
}

// 只保留山东及全国事项（如需汶上县自行调整）
function is_shandong_or_national($row) {
    $ssjg = $row['ssjgmc'] ?? '';
    $xzqh = $row['xzqhmc'] ?? '';
    return (
        (strpos($ssjg, '山东') !== false || strpos($xzqh, '山东') !== false) ||
        (strpos($ssjg, '国家税务总局') !== false || strpos($xzqh, '国家税务总局') !== false) ||
        (strpos($ssjg, '全国') !== false || strpos($xzqh, '全国') !== false)
    );
}
// 事项名清洗，便于合并同类项
function normalize_title($title) {
    $title = preg_replace('/[0-9]{4}年度?/', '', $title);
    $title = preg_replace('/汇算清缴申报|申报|年度申报|月报|年报|（[^）]*）/', '', $title);
    $title = preg_replace('/[\s\,，、;；\.。]+/', '', $title);
    return $title;
}

$monthStart = strtotime("{$year}-{$month}-01");
$monthEnd   = strtotime(date('Y-m-t', $monthStart) . ' 23:59:59');
$filtered = [];
foreach ($list as $item) {
    if (!is_shandong_or_national($item)) continue;
    $start = isset($item['bskssj']) ? strtotime($item['bskssj']) : 0;
    $end   = isset($item['bsjssj']) ? strtotime($item['bsjssj']) : 0;
    if (
        ($start >= $monthStart && $start <= $monthEnd) ||
        ($end >= $monthStart && $end <= $monthEnd)
    ) {
        $key = normalize_title($item['bssz'] ?? '') . ($item['bskssj'] ?? '') . ($item['bsjssj'] ?? '');
        if (!isset($filtered[$key]) || mb_strlen($item['bssz']) < mb_strlen($filtered[$key]['bssz'])) {
            $filtered[$key] = $item;
        }
    }
}

usort($filtered, function($a, $b) {
    $ea = isset($a['bsjssj']) ? strtotime($a['bsjssj']) : 0;
    $eb = isset($b['bsjssj']) ? strtotime($b['bsjssj']) : 0;
    return $ea <=> $eb;
});
?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>税务日历提醒（<?= $year ?>年<?= $month ?>月） - 汶上县涉税专业服务行业协会</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include('nav.php'); ?>
<div class="container mt-4 mb-4">
    <h2 class="mb-3">税务日历提醒（<?= $year ?>年<?= $month ?>月）</h2>
    <?php if (!empty($filtered)): ?>
        <div class="table-responsive">
        <table class="table table-bordered text-center align-middle">
            <thead>
                <tr>
                    <th>开始时间</th>
                    <th>结束时间</th>
                    <th>事项</th>
                    <th>归属机构</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($filtered as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['bskssj'] ?? '') ?></td>
                    <td><?= htmlspecialchars($item['bsjssj'] ?? '') ?></td>
                    <td><?= htmlspecialchars($item['bssz'] ?? '') ?></td>
                    <td><?= htmlspecialchars($item['ssjgmc'] ?? $item['xzqhmc'] ?? '') ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        </div>
    <?php else: ?>
        <div class="alert alert-warning">
            暂无符合条件的数据。
        </div>
    <?php endif; ?>
    <div class="text-muted mt-3">
        数据来源：<a href="https://12366.chinatax.gov.cn/bsfw/calendar/main" target="_blank">国家税务总局12366办税日历</a>
    </div>
</div>
<?php include('footer.php'); ?>
</body>
</html>