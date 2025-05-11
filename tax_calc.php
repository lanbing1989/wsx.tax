<?php
session_start();
function calculate_tax($mode, $data) {
    $threshold = 5000; // 起征点
    $levels = [
        [36000, 0.03, 0],
        [144000, 0.10, 2520],
        [300000, 0.20, 16920],
        [420000, 0.25, 31920],
        [660000, 0.30, 52920],
        [960000, 0.35, 85920],
        [PHP_INT_MAX, 0.45, 181920]
    ];
    if ($mode == 'monthly') {
        $income = floatval($data['income']);
        $deductions = floatval($data['deductions']);
        $taxable = $income - $deductions - $threshold;
        if ($taxable <= 0) return ['tax'=>0, 'after_tax'=>$income, 'desc'=>'本月应纳税所得额不超过0，免税'];
        foreach ($levels as $level) {
            if ($taxable <= $level[0]) {
                $tax = $taxable * $level[1] - $level[2];
                $tax = max(0, round($tax, 2));
                $after_tax = round($income - $tax, 2);
                return [
                    'tax' => $tax,
                    'after_tax' => $after_tax,
                    'desc' => "本月应纳税所得额：{$taxable}，适用税率：".($level[1]*100)."%"
                ];
            }
        }
    } elseif ($mode == 'cumulative') {
        $cum_income = floatval($data['cum_income']);
        $cum_deductions = floatval($data['cum_deductions']);
        $cum_tax_paid = floatval($data['cum_tax_paid']);
        $months = intval($data['months']);
        $taxable = $cum_income - $cum_deductions - $threshold * $months;
        if ($taxable <= 0) return ['tax'=>0, 'after_tax'=>$cum_income-$cum_tax_paid, 'desc'=>'累计应纳税所得额不超过0，免税'];
        foreach ($levels as $level) {
            if ($taxable <= $level[0]) {
                $tax_total = $taxable * $level[1] - $level[2];
                $tax_total = max(0, round($tax_total, 2));
                $tax_should_pay = round($tax_total - $cum_tax_paid, 2);
                $after_tax = round($cum_income - $tax_total, 2);
                return [
                    'tax' => $tax_should_pay,
                    'after_tax' => $after_tax,
                    'desc' => "累计应纳税所得额：{$taxable}，适用税率：".($level[1]*100)."%"
                ];
            }
        }
    } elseif ($mode == 'bonus') {
        $bonus = floatval($data['bonus_income']);
        $avg = $bonus / 12;
        foreach ($levels as $level) {
            if ($avg <= $level[0]) {
                $tax = $bonus * $level[1] - $level[2];
                $tax = max(0, round($tax, 2));
                $after_tax = round($bonus - $tax, 2);
                return [
                    'tax' => $tax,
                    'after_tax' => $after_tax,
                    'desc' => "年终奖按单独计税，平均每月{$avg}元，适用税率：".($level[1]*100)."%"
                ];
            }
        }
    }
    return ['tax'=>0, 'after_tax'=>0, 'desc'=>'未知错误'];
}
$result = null;
$input = null;
$mode = 'monthly';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mode = $_POST['mode'] ?? 'monthly';
    $input = [];
    if ($mode == 'monthly') {
        $input['income'] = $_POST['income'] ?? 0;
        $input['deductions'] = $_POST['deductions'] ?? 0;
    } elseif ($mode == 'cumulative') {
        $input['cum_income'] = $_POST['cum_income'] ?? 0;
        $input['cum_deductions'] = $_POST['cum_deductions'] ?? 0;
        $input['cum_tax_paid'] = $_POST['cum_tax_paid'] ?? 0;
        $input['months'] = $_POST['months'] ?? 1;
    } elseif ($mode == 'bonus') {
        $input['bonus_income'] = $_POST['bonus_income'] ?? 0;
    }
    $result = calculate_tax($mode, $input);
}
?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>个人所得税计算器 - 汶上县涉税专业服务行业协会</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include('nav.php'); ?>
<div class="container mt-4 mb-4">
    <h2 class="mb-3">个人所得税计算器</h2>
    <form class="p-3 shadow bg-white rounded mb-3" action="tax_calc.php" method="post" id="taxForm">
        <div class="mb-3">
            <label class="form-label"><b>计税方式：</b></label>
            <select name="mode" id="mode" class="form-select w-auto d-inline" onchange="toggleInputs()">
                <option value="monthly" <?php if($mode=='monthly') echo 'selected'; ?>>月度计税</option>
                <option value="cumulative" <?php if($mode=='cumulative') echo 'selected'; ?>>累计预扣法</option>
                <option value="bonus" <?php if($mode=='bonus') echo 'selected'; ?>>年终奖计税</option>
            </select>
        </div>
        <div id="monthly_inputs" <?php echo ($mode=='monthly') ? '' : 'style="display:none;"'; ?>>
            <div class="mb-2">
                <label class="form-label">本月收入（元）：</label>
                <input type="number" step="0.01" name="income" class="form-control" value="<?=htmlspecialchars($_POST['income']??'')?>">
            </div>
            <div class="mb-2">
                <label class="form-label">五险一金及专项扣除（元）：</label>
                <input type="number" step="0.01" name="deductions" class="form-control" value="<?=htmlspecialchars($_POST['deductions']??'0')?>">
            </div>
        </div>
        <div id="cumulative_inputs" <?php echo ($mode=='cumulative') ? '' : 'style="display:none;"'; ?>>
            <div class="mb-2">
                <label class="form-label">本年累计收入（元）：</label>
                <input type="number" step="0.01" name="cum_income" class="form-control" value="<?=htmlspecialchars($_POST['cum_income']??'')?>">
            </div>
            <div class="mb-2">
                <label class="form-label">累计扣除（五险一金等+专项，元）：</label>
                <input type="number" step="0.01" name="cum_deductions" class="form-control" value="<?=htmlspecialchars($_POST['cum_deductions']??'0')?>">
            </div>
            <div class="mb-2">
                <label class="form-label">已预扣税额（元）：</label>
                <input type="number" step="0.01" name="cum_tax_paid" class="form-control" value="<?=htmlspecialchars($_POST['cum_tax_paid']??'0')?>">
            </div>
            <div class="mb-2">
                <label class="form-label">月份（如3月请填3）：</label>
                <input type="number" name="months" class="form-control" value="<?=htmlspecialchars($_POST['months']??date('n'))?>">
            </div>
        </div>
        <div id="bonus_inputs" <?php echo ($mode=='bonus') ? '' : 'style="display:none;"'; ?>>
            <div class="mb-2">
                <label class="form-label">年终奖金额（元）：</label>
                <input type="number" step="0.01" name="bonus_income" class="form-control" value="<?=htmlspecialchars($_POST['bonus_income']??'')?>">
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-2">计算</button>
    </form>
    <?php if($result): ?>
    <div class="result alert alert-success">
        <h5>计算结果</h5>
        <div>应缴个人所得税：<b style="color:#d7263d;"><?=$result['tax']?> 元</b></div>
        <div>税后收入：<b><?=$result['after_tax']?> 元</b></div>
        <div class="text-muted"><?=$result['desc']?></div>
    </div>
    <?php endif; ?>
    <div class="tax-info mt-4 mb-3">
        <h5>算法说明</h5>
        <ul>
            <li>1. 起征点为 <b>5000元/月</b>。</li>
            <li>2. <b>月度计税</b>：应纳税所得额 = 工资收入 - 五险一金等扣除 - 起征点。</li>
            <li>3. <b>累计预扣法</b>：全年累计收入、扣除、已缴税、月份计算所需补缴税额。</li>
            <li>4. <b>年终奖</b>：单独计税，按年终奖除以12后的税率分段计税。</li>
        </ul>
        <h5>2024年工资薪金所得税率表</h5>
        <table class="table table-bordered table-sm text-center align-middle">
            <tr><th>级数</th><th>应纳税所得额（元）</th><th>税率(%)</th><th>速算扣除数（元）</th></tr>
            <tr><td>1</td><td> ≤36,000</td><td>3</td><td>0</td></tr>
            <tr><td>2</td><td>36,000 - 144,000</td><td>10</td><td>2,520</td></tr>
            <tr><td>3</td><td>144,000 - 300,000</td><td>20</td><td>16,920</td></tr>
            <tr><td>4</td><td>300,000 - 420,000</td><td>25</td><td>31,920</td></tr>
            <tr><td>5</td><td>420,000 - 660,000</td><td>30</td><td>52,920</td></tr>
            <tr><td>6</td><td>660,000 - 960,000</td><td>35</td><td>85,920</td></tr>
            <tr><td>7</td><td>＞960,000</td><td>45</td><td>181,920</td></tr>
        </table>
    </div>
</div>
<?php include('footer.php'); ?>
<script>
function toggleInputs() {
    var mode = document.getElementById('mode').value;
    document.getElementById('monthly_inputs').style.display = (mode=="monthly") ? "" : "none";
    document.getElementById('cumulative_inputs').style.display = (mode=="cumulative") ? "" : "none";
    document.getElementById('bonus_inputs').style.display = (mode=="bonus") ? "" : "none";
}
</script>
</body>
</html>