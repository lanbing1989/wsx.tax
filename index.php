<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>汶上县涉税专业服务行业协会</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- 可选：icon库 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
<?php include('nav.php'); ?>

<div class="container mt-5 mb-5 pt-4 pb-4 shadow-sm">
    <!-- 欢迎区 -->
    <div class="text-center mb-5">
        <h2 class="mb-2" style="font-weight:700;">
            欢迎来到汶上县涉税专业服务行业协会
        </h2>
        <div class="text-secondary fs-5">
            为会员及广大纳税人提供权威、专业、便捷的涉税服务
        </div>
        <div class="mt-3 text-muted">
            使用各类税务工具、查阅最新政策、参与交流、共享资源
        </div>
    </div>
    <!-- 功能卡片区 -->
    <div class="row g-4 justify-content-center">
        <div class="col-12 col-md-4">
            <div class="card h-100 border-0 shadow-sm hover-shadow text-center py-4">
                <div class="mb-3">
                    <i class="bi bi-calculator fs-1 text-primary"></i>
                </div>
                <h5 class="mb-2">税务工具箱</h5>
                <div class="mb-3 text-muted small">便捷的税务计算与辅助工具</div>
                <a href="/tools.php" class="tax-tool-link">全部工具</a>
                <!-- 更多工具可添加 -->
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card h-100 border-0 shadow-sm hover-shadow text-center py-4">
                <div class="mb-3">
                    <i class="bi bi-file-earmark-text fs-1 text-success"></i>
                </div>
                <h5 class="mb-2">政策法规</h5>
                <div class="mb-3 text-muted small">最新政策解析与法规查询</div>
                <a href="/policy.php" class="tax-tool-link">最新政策解读</a>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card h-100 border-0 shadow-sm hover-shadow text-center py-4">
                <div class="mb-3">
                    <i class="bi bi-people fs-1 text-warning"></i>
                </div>
                <h5 class="mb-2">会员与服务</h5>
                <div class="mb-3 text-muted small">会员专享服务与行业交流</div>
                <a href="/member.php" class="tax-tool-link">会员服务</a>
            </div>
        </div>
    </div>
</div>
<?php include('footer.php'); ?>
</body>
</html>