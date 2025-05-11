<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>投诉建议 - 汶上县涉税专业服务行业协会</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include('nav.php'); ?>
<div class="container mt-4 mb-4">
    <h2 class="mb-3">投诉建议</h2>
    <p>欢迎您对协会工作提出宝贵意见和建议，我们将及时处理您的反馈。</p>
    <form>
        <div class="mb-2">
            <label class="form-label">您的姓名（选填）：</label>
            <input type="text" class="form-control">
        </div>
        <div class="mb-2">
            <label class="form-label">联系方式（选填）：</label>
            <input type="text" class="form-control">
        </div>
        <div class="mb-2">
            <label class="form-label">投诉/建议内容：</label>
            <textarea class="form-control" required rows="4"></textarea>
        </div>
        <button type="button" class="btn btn-primary" disabled>提交（演示版暂未开放）</button>
    </form>
</div>
<?php include('footer.php'); ?>
</body>
</html>