<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>税务工具箱 - 汶上县涉税专业服务行业协会</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/style.css" rel="stylesheet">
    <link href="https://unpkg.com/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    @media (min-width: 768px) {
        .toolbox-2col > .row > .col-md-6 { border-right:1px solid #eee; }
        .toolbox-2col > .row > .col-md-6:last-child { border-right:none; }
    }
    .card-link-list .list-group-item { border: none; border-bottom: 1px solid #f1f3f5; }
    .card-link-list .list-group-item:last-child { border-bottom: none; }
    </style>
</head>
<body>
<?php include('nav.php'); ?>
<div class="container mt-4 mb-4">
    <h2 class="mb-4">税务工具箱</h2>

    <!-- 顶部直达卡片 -->
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <a href="https://shandong.chinatax.gov.cn/" class="btn btn-outline-primary w-100 py-3 fw-bold" target="_blank">
                山东省税务局官网
            </a>
        </div>
        <div class="col-md-6">
            <a href="https://etax.shandong.chinatax.gov.cn" class="btn btn-outline-primary w-100 py-3 fw-bold" target="_blank">
                山东省电子税务局
            </a>
        </div>
    </div>

    <!-- 下方两栏式菜单 -->
    <div class="toolbox-2col">
    <div class="row g-3">
        <!-- 左栏：工具箱 -->
        <div class="col-md-6">
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-primary text-white">
                    常用工具箱（自主开发）
                </div>
                <div class="list-group list-group-flush card-link-list">
                    <a href="/tax_calc.php" class="list-group-item list-group-item-action">个人所得税计算器</a>
                    <a href="/vat_calc.php" class="list-group-item list-group-item-action">增值税计算器</a>
                    <a href="/corp_tax_calc.php" class="list-group-item list-group-item-action">企业所得税计算器</a>
                    <a href="/social_insurance.php" class="list-group-item list-group-item-action">五险一金计算器</a>
                    <a href="/rate_query.php" class="list-group-item list-group-item-action">税率速查</a>
                    <a href="/invoice_check.php" class="list-group-item list-group-item-action">发票查验</a>
                    <a href="/tax_calendar.php" class="list-group-item list-group-item-action">税务日历提醒</a>
                </div>
            </div>
        </div>
        <!-- 右栏：特色服务 -->
        <div class="col-md-6">
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-secondary text-white">
                    特色功能入口（官方功能）
                </div>
                <div class="list-group list-group-flush card-link-list">
                    <a href="https://etax.shandong.chinatax.gov.cn:8443/xxbg/view/zhsffw/#/query/ybnsrzgcx" class="list-group-item list-group-item-action" target="_blank">
                        一般纳税人资格查询
                    </a>
                    <a href="https://etax.shandong.chinatax.gov.cn:8443/wfcl/view/sdsgjsjgywfcz/#/yyzx/nsfwtscl/sqxz" class="list-group-item list-group-item-action" target="_blank">
                        纳税服务投诉
                    </a>
                    <a href="https://etax.shandong.chinatax.gov.cn:8443/wfcl/view/sdsgjsjgywfcz/#/yyzx/sswfxwjjgl/gl" class="list-group-item list-group-item-action" target="_blank">
                        税收违法行为检举
                    </a>
                    <a href="https://etax.shandong.chinatax.gov.cn:8443/xxbg/view/ztxxbg/qssbswzxblwkyqs" class="list-group-item list-group-item-action" target="_blank">
                        清税申报（未办税户申请清税证明）
                    </a>
                    <a href="https://etax.shandong.chinatax.gov.cn:8443/xxbg/view/zhsffw/#/query/nsrztcx" class="list-group-item list-group-item-action" target="_blank">
                        纳税人状态查询
                    </a>
                    <a href="https://etax.shandong.chinatax.gov.cn:8443/xxbg/view/sfxc/#/swxc/zxfg" class="list-group-item list-group-item-action" target="_blank">
                        最新法规
                    </a>
                    <a href="https://etax.shandong.chinatax.gov.cn:8443/ssjg/view/zhssjg/#/sszyfw/index" class="list-group-item list-group-item-action" target="_blank">
                        涉税专业服务机构（人员）信用信息查询
                    </a>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
<?php include('footer.php'); ?>
</body>
</html>