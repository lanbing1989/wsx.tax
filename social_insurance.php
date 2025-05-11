<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>五险一金计算器 - 山东省标准</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    .ins-table td, .ins-table th { font-size: 15px; }
    </style>
</head>
<body>
<?php include('nav.php'); ?>
<div class="container mt-4 mb-4">
    <h2 class="mb-3">五险一金计算器（山东省 2024）</h2>
    <form method="post" class="mb-3 row g-3 align-items-center">
        <div class="col-md-4 mb-2">
            <label class="form-label">工资基数（元，范围 4416 - 220178）：</label>
            <input type="number" step="0.01" name="base" class="form-control" required min="4416" max="220178" value="<?=isset($_POST['base']) ? htmlspecialchars($_POST['base']) : '4416'?>">
            <small class="text-muted">如低于4416按4416计，高于220178按220178计</small>
        </div>
        <div class="col-md-2 mb-2">
            <label class="form-label">当前月份：</label>
            <input type="number" name="month" class="form-control" min="1" max="12" value="<?=isset($_POST['month']) ? intval($_POST['month']) : date('n')?>">
            <small class="text-muted">如为首次参保请选择当月</small>
        </div>
        <div class="col-md-2 mb-2">
            <label class="form-label">首次参保？</label>
            <select name="first" class="form-select">
                <option value="0" <?php if(empty($_POST['first'])) echo 'selected';?>>否</option>
                <option value="1" <?php if(!empty($_POST['first'])) echo 'selected';?>>是</option>
            </select>
        </div>
        <div class="col-md-2 mb-2 align-self-end">
            <button type="submit" class="btn btn-primary">计算</button>
        </div>
    </form>
<?php
// 山东省2024年五险一金比例（单位/个人）
$rate = [
    '养老保险' => ['unit'=>16, 'person'=>8, 'type'=>'社保'],
    '医疗保险' => ['unit'=>7, 'person'=>2, 'type'=>'社保'],
    '失业保险' => ['unit'=>0.7, 'person'=>0.3, 'type'=>'社保'],
    '工伤保险' => ['unit'=>0.2, 'person'=>0, 'type'=>'社保'],
    '生育保险' => ['unit'=>0.5, 'person'=>0, 'type'=>'社保'],
    '住房公积金' => ['unit'=>7, 'person'=>7, 'type'=>'公积金'],
];
$min_base = 4416;
$max_base = 220178;
$big_medical_company = 72;
$big_medical_personal = 48;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['base'])) {
    $base = floatval($_POST['base']);
    if ($base < $min_base) $base = $min_base;
    if ($base > $max_base) $base = $max_base;
    $month = isset($_POST['month']) ? intval($_POST['month']) : date('n');
    $is_first = !empty($_POST['first']);

    $result = [];
    $total_person = 0;
    $total_unit = 0;
    $person_shebao = 0;
    $unit_shebao = 0;
    $person_gjj = 0;
    $unit_gjj = 0;

    foreach ($rate as $name => $r) {
        $unit = round($base * $r['unit'] / 100, 2);
        $person = round($base * $r['person'] / 100, 2);
        $result[] = [
            'name' => $name,
            'unit' => $unit,
            'person' => $person,
            'unit_rate' => $r['unit'],
            'person_rate' => $r['person'],
            'type' => $r['type'],
        ];
        $total_person += $person;
        $total_unit += $unit;
        if ($r['type'] === '社保') {
            $person_shebao += $person;
            $unit_shebao += $unit;
        } elseif ($r['type'] === '公积金') {
            $person_gjj += $person;
            $unit_gjj += $unit;
        }
    }

    // 大额医疗缴纳条件
    $show_big_medical = ($month == 1) || $is_first;
    $person_shebao_plus = $person_shebao + ($show_big_medical ? $big_medical_personal : 0);
    $unit_shebao_plus = $unit_shebao + ($show_big_medical ? $big_medical_company : 0);
    $total_person_plus = $total_person + ($show_big_medical ? $big_medical_personal : 0);
    $total_unit_plus = $total_unit + ($show_big_medical ? $big_medical_company : 0);

    // 输出社保和公积金的单位+个人
    $shebao_all = $person_shebao_plus + $unit_shebao_plus;
    $gjj_all = $person_gjj + $unit_gjj;
    $all_all = $total_person_plus + $total_unit_plus;
    ?>
    <div class="alert alert-success">
        <b>基数：</b><?= $base ?> 元<br>
        <b>个人社保合计：</b><?= $person_shebao ?> 元/月<?php if($show_big_medical): ?>，本月需多缴大额医疗<?= $big_medical_personal ?>元<?php endif; ?><br>
        <b>个人社保合计：</b><?= $person_shebao_plus ?> 元/月（含大额医疗）<br>
        <b>个人公积金：</b><?= $person_gjj ?> 元/月<br>
        <b>个人全部合计：</b><?= $total_person_plus ?> 元/月（含大额医疗）<br>
        <b>单位社保合计：</b><?= $unit_shebao ?> 元/月<?php if($show_big_medical): ?>，本月需多缴大额医疗<?= $big_medical_company ?>元<?php endif; ?><br>
        <b>单位社保合计：</b><?= $unit_shebao_plus ?> 元/月（含大额医疗）<br>
        <b>单位公积金：</b><?= $unit_gjj ?> 元/月<br>
        <b>单位全部合计：</b><?= $total_unit_plus ?> 元/月（含大额医疗）<br>
        <b style="color:#0a58ca;">社保合计（单位+个人）：</b><?= $shebao_all ?> 元/月<br>
        <b style="color:#0a58ca;">公积金合计（单位+个人）：</b><?= $gjj_all ?> 元/月<br>
        <b style="color:#0a58ca;">全部合计（单位+个人）：</b><?= $all_all ?> 元/月
    </div>
    <div class="table-responsive">
    <table class="table table-bordered ins-table text-center align-middle">
        <thead>
            <tr>
                <th>险种</th>
                <th>单位比例</th>
                <th>单位缴纳（元）</th>
                <th>个人比例</th>
                <th>个人缴纳（元）</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($result as $item): ?>
            <tr>
                <td><?= $item['name'] ?></td>
                <td><?= $item['unit_rate'] ?>%</td>
                <td><?= $item['unit'] ?></td>
                <td><?= $item['person_rate'] ?>%</td>
                <td><?= $item['person'] ?></td>
            </tr>
        <?php endforeach; ?>
        <?php if($show_big_medical): ?>
        <tr>
            <td>大额医疗</td>
            <td>-</td>
            <td><?= $big_medical_company ?> <span class="text-muted">(本月)</span></td>
            <td>-</td>
            <td><?= $big_medical_personal ?> <span class="text-muted">(本月)</span></td>
        </tr>
        <?php endif; ?>
        <tr style="font-weight:bold;background:#f7f7f7;">
            <td>个人社保合计</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td><?= $person_shebao_plus ?></td>
        </tr>
        <tr style="font-weight:bold;background:#f7f7f7;">
            <td>个人公积金</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td><?= $person_gjj ?></td>
        </tr>
        <tr style="font-weight:bold;background:#e1f7ff;">
            <td>个人全部合计</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td><?= $total_person_plus ?></td>
        </tr>
        <tr style="font-weight:bold;background:#f7f7f7;">
            <td>单位社保合计</td>
            <td>-</td>
            <td><?= $unit_shebao_plus ?></td>
            <td>-</td>
            <td>-</td>
        </tr>
        <tr style="font-weight:bold;background:#f7f7f7;">
            <td>单位公积金</td>
            <td>-</td>
            <td><?= $unit_gjj ?></td>
            <td>-</td>
            <td>-</td>
        </tr>
        <tr style="font-weight:bold;background:#e1f7ff;">
            <td>单位全部合计</td>
            <td>-</td>
            <td><?= $total_unit_plus ?></td>
            <td>-</td>
            <td>-</td>
        </tr>
        <tr style="font-weight:bold;background:#cff4fc;">
            <td>社保合计（单位+个人）</td>
            <td>-</td>
            <td colspan="3"><?= $shebao_all ?> 元/月</td>
        </tr>
        <tr style="font-weight:bold;background:#cff4fc;">
            <td>公积金合计（单位+个人）</td>
            <td>-</td>
            <td colspan="3"><?= $gjj_all ?> 元/月</td>
        </tr>
        <tr style="font-weight:bold;background:#cff4fc;">
            <td>全部合计（单位+个人）</td>
            <td>-</td>
            <td colspan="3"><?= $all_all ?> 元/月</td>
        </tr>
        </tbody>
    </table>
    </div>
    <?php
}
?>
    <div class="text-muted mt-3">
        <b>注：</b>本计算器以山东省2024年城镇职工标准为例，实际比例或缴纳基数以各地政策为准。工伤保险比例因行业可能略有不同，公积金比例如有单位单独规定请以实际为准。<br>
        <b>大额医疗费：</b>山东省2024年度大额医疗公司72元/年，个人48元/年，仅首月或1月一次性收取。
    </div>
</div>
<?php include('footer.php'); ?>
</body>
</html>