<?php
session_start();
if (!isset($_SESSION['vat_history'])) $_SESSION['vat_history'] = [];

// 清除历史记录
if (isset($_GET['clear']) && $_GET['clear'] === '1') {
    $_SESSION['vat_history'] = [];
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['income'], $_POST['rate'])) {
    $income = floatval($_POST['income']);
    $rate = floatval($_POST['rate']);
    $tax = round($income * $rate / (1 + $rate), 2);
    $net = round($income - $tax, 2);
    $result = [
        'income' => $income,
        'rate' => $rate,
        'tax' => $tax,
        'net' => $net,
        'time' => date('Y-m-d H:i')
    ];
    array_unshift($_SESSION['vat_history'], $result);
    if (count($_SESSION['vat_history']) > 20) array_pop($_SESSION['vat_history']);
}
?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>增值税计算器 - 汶上县涉税专业服务行业协会</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/style.css" rel="stylesheet">
    <link href="https://unpkg.com/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include('nav.php'); ?>
<div class="container mt-4 mb-4">
    <h2 class="mb-3">增值税计算器</h2>
    <form method="post" class="mb-3">
        <div class="mb-2">
            <label class="form-label">含税收入（元）：</label>
            <input type="number" step="0.01" name="income" class="form-control" required value="<?=isset($_POST['income']) ? htmlspecialchars($_POST['income']) : ''?>">
        </div>
        <div class="mb-2">
            <label class="form-label">适用税率：</label>
            <select name="rate" class="form-select">
                <option value="0.13" <?php if(isset($_POST['rate']) && $_POST['rate']=='0.13') echo 'selected'; ?>>13%</option>
                <option value="0.09" <?php if(isset($_POST['rate']) && $_POST['rate']=='0.09') echo 'selected'; ?>>9%</option>
                <option value="0.06" <?php if(isset($_POST['rate']) && $_POST['rate']=='0.06') echo 'selected'; ?>>6%</option>
                <option value="0.03" <?php if(isset($_POST['rate']) && $_POST['rate']=='0.03') echo 'selected'; ?>>3%（小规模）</option>
                <option value="0.01" <?php if(isset($_POST['rate']) && $_POST['rate']=='0.01') echo 'selected'; ?>>1%（部分小微）</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">计算</button>
    </form>
    <?php if (!empty($result)): ?>
        <div class='alert alert-success'>
            <b>税额：</b><?= $result['tax'] ?> 元<br>
            <b>不含税收入：</b><?= $result['net'] ?> 元
        </div>
    <?php endif; ?>
    <div class="text-muted mt-3 mb-2">计算方法：税额 = 含税收入 × 税率 / (1 + 税率)</div>
    <h5 class="mt-4">
        历史记录
        <?php if (!empty($_SESSION['vat_history'])): ?>
            <a href="?clear=1" class="btn btn-outline-danger btn-sm ms-3" onclick="return confirm('确定清除所有历史记录？')">清除</a>
        <?php endif; ?>
    </h5>
    <?php if (!empty($_SESSION['vat_history'])): ?>
        <div class="table-responsive">
        <table class="table table-sm table-bordered text-center align-middle">
            <tr>
                <th>时间</th>
                <th>含税收入</th>
                <th>税率</th>
                <th>税额</th>
                <th>不含税收入</th>
            </tr>
            <?php foreach ($_SESSION['vat_history'] as $h): ?>
                <tr>
                    <td><?= $h['time'] ?></td>
                    <td><?= $h['income'] ?></td>
                    <td><?= ($h['rate']*100) ?>%</td>
                    <td><?= $h['tax'] ?></td>
                    <td><?= $h['net'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        </div>
    <?php else: ?>
        <div class="text-muted">暂无历史记录</div>
    <?php endif; ?>
</div>
<?php include('footer.php'); ?>
</body>
</html>