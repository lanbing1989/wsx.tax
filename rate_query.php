<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>税率速查 - 汶上县涉税专业服务行业协会</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/style.css" rel="stylesheet">
    <link href="https://unpkg.com/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include('nav.php'); ?>
<div class="container mt-4 mb-4">
    <h2 class="mb-3">常用税率速查</h2>
    <table class="table table-bordered text-center align-middle">
        <thead>
            <tr>
                <th>税种</th>
                <th>税率</th>
                <th>说明</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>增值税（一般纳税人）</td>
                <td>13%、9%、6%</td>
                <td>不同货物/服务适用不同税率</td>
            </tr>
            <tr>
                <td>增值税（小规模）</td>
                <td>3% 或 1%</td>
                <td>小微企业、个体户</td>
            </tr>
            <tr>
                <td>企业所得税</td>
                <td>25%、20%、15%</td>
                <td>一般/小型微利/高新技术企业</td>
            </tr>
            <tr>
                <td>个人所得税</td>
                <td>3% ~ 45%</td>
                <td>超额累进，详见计算器</td>
            </tr>
            <tr>
                <td>印花税</td>
                <td>万分之三~千分之一</td>
                <td>合同、产权转移等</td>
            </tr>
            <!-- 可补充其他 -->
        </tbody>
    </table>
    <div class="text-muted mt-3">如需具体税率，请咨询税务机关或查阅最新政策。</div>
</div>
<?php include('footer.php'); ?>
</body>
</html>