<?php
session_start();
if (!isset($_SESSION['corp_tax_history'])) $_SESSION['corp_tax_history'] = [];

// 清除历史记录
if (isset($_GET['clear']) && $_GET['clear'] === '1') {
    $_SESSION['corp_tax_history'] = [];
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}

/**
 * 计算一般企业所得税
 */
function calc_normal_corp_tax($profit, $rate = 0.25) {
    $tax = $profit * $rate;
    return [round($tax, 2), ($rate * 100) . '%'];
}

/**
 * 计算小型微利企业所得税（2025年政策：300万及以下5%，超出则全额25%）
 */
function calc_small_micro_tax($profit) {
    if ($profit <= 3000000) {
        $tax = $profit * 0.05;
        $policy = '5%（应纳税所得额≤300万元，享受优惠）';
    } else {
        $tax = $profit * 0.25;
        $policy = '25%（超过300万元，不享受优惠）';
    }
    return [round($tax, 2), $policy];
}

$normal_result = $small_result = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['profit'])) {
    $profit = floatval($_POST['profit']);
    // 一般企业
    list($normal_tax, $normal_rate) = calc_normal_corp_tax($profit, isset($_POST['rate']) ? floatval($_POST['rate']) : 0.25);
    $normal_after = round($profit - $normal_tax, 2);
    $normal_result = [
        'profit' => $profit,
        'rate' => $normal_rate,
        'tax' => $normal_tax,
        'after' => $normal_after,
        'type' => '一般企业',
        'policy' => '按25%计征（可选20%、15%特殊情况）',
        'time' => date('Y-m-d H:i')
    ];

    // 小微企业
    list($small_tax, $small_policy) = calc_small_micro_tax($profit);
    $small_after = round($profit - $small_tax, 2);
    $small_result = [
        'profit' => $profit,
        'rate' => $small_policy,
        'tax' => $small_tax,
        'after' => $small_after,
        'type' => '小型微利企业',
        'policy' => $small_policy,
        'time' => date('Y-m-d H:i')
    ];

    // 推入历史
    array_unshift($_SESSION['corp_tax_history'], [
        'time' => date('Y-m-d H:i'),
        'profit' => $profit,
        'normal_rate' => $normal_result['rate'],
        'normal_tax' => $normal_result['tax'],
        'small_rate' => $small_result['rate'],
        'small_tax' => $small_result['tax'],
        'normal_after' => $normal_result['after'],
        'small_after' => $small_result['after'],
    ]);
    if (count($_SESSION['corp_tax_history']) > 20) array_pop($_SESSION['corp_tax_history']);
}
?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>企业所得税计算器 - 汶上县涉税专业服务行业协会</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media (min-width: 768px) {
            .tax-col { min-width: 340px; }
        }
        .tax-col { background: #f8f8fb; border-radius: 8px; padding: 18px 14px 12px 14px; margin-bottom: 20px;}
        .tax-col h4 { color:#d7263d; font-weight: 600; }
        .tax-summary { font-size: 1.1em; }
    </style>
</head>
<body>
<?php include('nav.php'); ?>
<div class="container mt-4 mb-4">
    <h2 class="mb-4">企业所得税计算器</h2>
    <form method="post" class="mb-4">
        <div class="row g-2 align-items-end">
            <div class="col-md-4 col-12 mb-2">
                <label class="form-label">利润总额（元）：</label>
                <input type="number" step="0.01" name="profit" class="form-control" required value="<?=isset($_POST['profit']) ? htmlspecialchars($_POST['profit']) : ''?>">
            </div>
            <div class="col-md-3 col-6 mb-2">
                <label class="form-label">一般企业税率：</label>
                <select name="rate" class="form-select">
                    <option value="0.25" <?php if(empty($_POST['rate'])||$_POST['rate']=='0.25') echo 'selected';?>>25%（默认）</option>
                    <option value="0.20" <?php if(!empty($_POST['rate'])&&$_POST['rate']=='0.20') echo 'selected';?>>20%（少数特殊）</option>
                    <option value="0.15" <?php if(!empty($_POST['rate'])&&$_POST['rate']=='0.15') echo 'selected';?>>15%（高新/优惠）</option>
                </select>
            </div>
            <div class="col-md-3 col-6 mb-2 text-end">
                <button type="submit" class="btn btn-primary">计算</button>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-md-6 tax-col">
            <h4>一般企业</h4>
            <div class="tax-summary">
                <?php if($normal_result): ?>
                <div><b>应纳税所得额：</b><?= $normal_result['profit'] ?> 元</div>
                <div><b>税率：</b><?= $normal_result['rate'] ?></div>
                <div><b>应缴企业所得税：</b><span style="color:#d7263d;"><?= $normal_result['tax'] ?> 元</span></div>
                <div><b>税后利润：</b><?= $normal_result['after'] ?> 元</div>
                <div class="text-muted"><?= $normal_result['policy'] ?></div>
                <?php else: ?>
                <div class="text-muted">请填写利润总额进行计算</div>
                <?php endif; ?>
            </div>
            <ul class="mt-3 mb-1 small">
                <li>一般企业标准税率为25%，部分符合条件的企业可享受20%或15%优惠税率。</li>
                <li>企业所得税=利润总额×税率</li>
            </ul>
        </div>
        <div class="col-md-6 tax-col">
            <h4>小型微利企业</h4>
            <div class="tax-summary">
                <?php if($small_result): ?>
                <div><b>应纳税所得额：</b><?= $small_result['profit'] ?> 元</div>
                <div><b>实际税负：</b><?= $small_result['rate'] ?></div>
                <div><b>应缴企业所得税：</b><span style="color:#d7263d;"><?= $small_result['tax'] ?> 元</span></div>
                <div><b>税后利润：</b><?= $small_result['after'] ?> 元</div>
                <div class="text-muted">
                    <?php if($small_result['profit'] <= 3000000): ?>
                        符合条件：年利润≤300万元，实际税负5%。
                    <?php else: ?>
                        不符合优惠：年利润＞300万元，全部按25%计征。
                    <?php endif; ?>
                </div>
                <?php else: ?>
                <div class="text-muted">请填写利润总额进行计算</div>
                <?php endif; ?>
            </div>
            <ul class="mt-3 mb-1 small">
                <li>应同时满足：年应纳税所得额≤300万、从业人数≤300人、资产总额≤5000万。</li>
                <li>政策依据：<a target="_blank" href="https://www.chinatax.gov.cn/chinatax/n810219/n810780/c102063/c102064/202303/t20230327_4424946.html">国税总局关于小型微利企业所得税优惠政策的公告</a></li>
                <li>企业所得税=利润总额×5%（超300万全部按25%）</li>
            </ul>
        </div>
    </div>
    <h5 class="mt-4">
        历史记录
        <?php if (!empty($_SESSION['corp_tax_history'])): ?>
            <a href="?clear=1" class="btn btn-outline-danger btn-sm ms-3" onclick="return confirm('确定清除所有历史记录？')">清除</a>
        <?php endif; ?>
    </h5>
    <?php if (!empty($_SESSION['corp_tax_history'])): ?>
        <div class="table-responsive">
        <table class="table table-sm table-bordered text-center align-middle">
            <tr>
                <th>时间</th>
                <th>利润总额</th>
                <th>一般企业税率</th>
                <th>一般企业税额</th>
                <th>小微企业税率</th>
                <th>小微企业税额</th>
                <th>一般税后</th>
                <th>小微税后</th>
            </tr>
            <?php foreach ($_SESSION['corp_tax_history'] as $h): ?>
                <tr>
                    <td><?= $h['time'] ?></td>
                    <td><?= $h['profit'] ?></td>
                    <td><?= $h['normal_rate'] ?></td>
                    <td><?= $h['normal_tax'] ?></td>
                    <td><?= $h['small_rate'] ?></td>
                    <td><?= $h['small_tax'] ?></td>
                    <td><?= $h['normal_after'] ?></td>
                    <td><?= $h['small_after'] ?></td>
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