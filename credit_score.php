<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>汶上县涉税机构信用积分 - 汶上县涉税专业服务行业协会</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    .credit-table { font-size: 15px; }
    .credit-table th, .credit-table td { white-space: nowrap; }
    .credit-table th { background: #f0f4f8; }
    .credit-table td { background: #fff; }
    .credit-table tr:nth-child(even) td { background: #f9fbfc; }
    .credit-table { margin-bottom: 2rem; }
    </style>
</head>
<body>
<?php include('nav.php'); ?>
<div class="container mt-4 mb-4">
    <h2 class="mb-3">汶上县涉税机构信用积分（更新时间：2025.5.11）</h2>
    <p>本表数据整理自山东省电子税务局，按信用积分从高到低排序，仅供参考。如需最新数据，请以 <a href="https://etax.shandong.chinatax.gov.cn:8443/ssjg/view/zhssjg/#/sszyfw/index" target="_blank">官方查询页面</a> 为准。</p>
    <div class="table-responsive">
    <table class="table table-bordered credit-table align-middle">
        <thead>
            <tr>
                <th>序号</th>
                <th>服务机构名称</th>
                <th>机构类型</th>
                <th>法定代表人</th>
                <th>在职人数</th>
                <th>当年服务户数</th>
                <th>信用得分</th>
                <th>机构等级</th>
                <th>机构地址</th>
            </tr>
        </thead>
        <tbody>
<?php
$data = <<<EOT
1	济宁金亚税通企业咨询管理有限公司	代理记账机构	马桂平	3	9	323.81		中都街道105国道东侧1幢304号
2	济宁慧通会计师事务所（普通合伙）	会计师事务所	田太国	5	30	416.84		汶上县明星路南段路西
3	汶上县恒信会计代理记账有限公司	代理记账机构	朱井英	5	94	427.02		山东省济宁市汶上县中都街道办事处智能大厦A座17B07室
4	汶上鼎赫财务服务有限公司	代理记账机构	刘曙光	6	395	420.09		济宁市汶上县中都街道办事处尚儒沃德2120室
5	济宁沃德企业管理咨询有限公司	代理记账机构	廉颖	6	219	422.69		山东省济宁市汶上县中都街道尚儒沃德807室
6	济宁金准代理记账有限公司	代理记账机构	郭金菊	3	59	427.49		山东省济宁市汶上县中都街道宝相寺路中段路东
7	汶上企优代理记账有限公司	代理记账机构	王红美	3	28	425.53		山东省济宁市汶上县中都街道西和园闫村佳苑北区
8	济宁骐硕企业营销策划有限公司	代理记账机构	张红霞	4	412	422.91		汶上县中都街道办事处圣泽大街西段路北
9	拾佰仟企业服务（汶上）有限公司	代理记账机构	杨胜强	5	155	406.68		山东省济宁市汶上县中都街道明星路188号
10	济宁华冉电子科技有限公司	代理记账机构	张新华	3	35	407.07		汶上县苑庄镇东贾柏村
11	济宁市百元企业营销策划有限公司	财税类咨询公司	潘春艳	3	29	430.3		山东省济宁市汶上县中都街道佛都公馆10号楼1单元102-2
12	济宁融续企业服务有限公司	代理记账机构	孔祥刚	5	10	404.54		山东省济宁市汶上县中都街道智能大厦A座1214-1215室
13	源顺财税代理记账（山东）有限公司汶上分公司	税务代理公司	陈小焕	5	321	395.95		山东省济宁市汶上县南站镇立国首府北50米
14	汶上税会通代理记帐有限公司	代理记账机构	李辉	3	123	435.42		山东省济宁市汶上县中都街道智能大厦A座1113室
15	汶上县佳诺企业管理咨询有限公司	财税类咨询公司	王亭亭	1	41	408.12		山东省济宁市汶上县中都街道家和家园9号楼2单元201室
16	济宁宸晟企业管理有限公司	代理记账机构	孔德玉	6	175	385.81		山东省济宁市汶上县中都街道中达广场6号楼1单元1层1-103号
17	济宁信诚企业管理有限公司	税务代理公司	雷丽敏	1	45	384.96		山东省济宁市汶上县中都街道圣泽大街2735号4楼
18	济宁鑫汇远企业代理服务有限公司	财税类咨询公司	路则远	3	44	421.46		山东省济宁市汶上县中都街道智能大厦B座715室
19	济宁联汇代理记账有限公司	代理记账机构	郭瑞	3	94	411.33		山东省济宁市汶上县中都街道政和路智能大厦B座714室
20	山东卓帆企业服务有限公司	代理记账机构	张茂闯	3	99	439.21		中都大街2668号
21	济宁鑫恒财税服务有限公司	税务代理公司	张亚秋	2	390	436.3		山东省济宁市汶上县中都街道远航大厦401号
22	济宁金税通财税代理有限公司	代理记账机构	潘琳	3	207	391.47		山东省济宁市汶上县中都街道智能大厦17B15
23	济宁顺诚企业管理服务有限公司	代理记账机构	赵红杰	4	84	391.33		华儒电商园7号楼二楼
24	济宁金恒企业代理有限公司	代理记账机构	张玉	3	108	425.4		济宁市汶上县中都街道智能大厦A座17A07室
25	济宁金年轮企业管理咨询有限公司	代理记账机构	李凤芹	3	34	380.17		汶上县明星路中段路西（中都智能大厦）
26	汶上县荣发新能源科技有限公司	代理记账机构	王美荣	4	88	388.12		山东省济宁市汶上县中都街道东方明都9-304室
27	贝恩提（山东）咨询有限公司	税务代理公司	马林林	5	186	427.3		山东省济宁市汶上县中都街道政和路智能大厦B座2205室
28	济宁俱增企业服务有限公司	代理记账机构	邢瑞云	3	95	421.36		山东省济宁市汶上县中都街道如意花园宁民路63-2-103号
29	汶上税通会计代理有限公司	财税类咨询公司	胡克宝	3	67	449.38		济宁市汶上县汶上街道办事处西门社区文明西街003号
30	济宁智鼎财税服务有限公司	代理记账机构	林蒙	3	0	349.49		济宁市汶上县汶上街道中都美食街8号楼1单元0023号
31	济宁金竹会计记账代理有限公司	代理记账机构	杨加平	8	624	427.47		山东省济宁市汶上县中都街道办事处智能大厦B座1415室
32	济宁宏阔会计代理记账服务有限公司	代理记账机构	范士新	4	50	390.97		山东省济宁市汶上县中都街道宝相寺路工商银行家属院88号
33	中都财税服务有限公司	代理记账机构	王士辉	3	172	457.24		山东省济宁市汶上县中都街道华儒小镇1号楼206室
34	汶上县梦业会计服务有限公司	代理记账机构	高孟叶	6	184	431.58		山东省济宁市汶上县汶上街道办事处泉河路855-4
35	汶上大账房企业管理咨询服务有限公司	代理记账机构	刘吉森	4	4	404.2		济宁市汶上县中都街道远航大厦909
36	济宁凯信企业代理有限公司	代理记账机构	刘建中	4	167	441.83		汶上县政和路中段路北
37	汶上县儒源会计记账代理有限公司	代理记账机构	郭延功	3	40	396.22		山东省济宁市汶上县汶上街道北门居委办公楼
EOT;

$lines = explode("\n", trim($data));
$table = [];
foreach ($lines as $line) {
    $cols = explode("\t", $line);
    // 防止有的行“机构等级”列为空
    if (count($cols) === 9) {
        list($no, $name, $type, $legal, $num, $client, $score, $level, $addr) = $cols;
    } else { // 有的“机构等级”列为空
        list($no, $name, $type, $legal, $num, $client, $score, $level, $addr) = array_pad($cols, 9, "");
    }
    $table[] = [
        'no' => $no,
        'name' => $name,
        'type' => $type,
        'legal' => $legal,
        'num' => $num,
        'client' => $client,
        'score' => floatval($score),
        'level' => $level,
        'addr' => $addr
    ];
}

// 按信用积分从高到低排序
usort($table, function($a, $b) {
    return $b['score'] <=> $a['score'];
});

// 重新序号
$i = 1;
foreach ($table as $row) {
    echo "<tr>";
    echo "<td>".$i++."</td>";
    echo "<td>".htmlspecialchars($row['name'])."</td>";
    echo "<td>".htmlspecialchars($row['type'])."</td>";
    echo "<td>".htmlspecialchars($row['legal'])."</td>";
    echo "<td>".$row['num']."</td>";
    echo "<td>".$row['client']."</td>";
    echo "<td>".$row['score']."</td>";
    echo "<td>".htmlspecialchars($row['level'])."</td>";
    echo "<td>".htmlspecialchars($row['addr'])."</td>";
    echo "</tr>";
}
?>
        </tbody>
    </table>
    </div>
    <div class="text-muted mt-4">
        数据来源：<a href="https://etax.shandong.chinatax.gov.cn:8443/ssjg/view/zhssjg/#/sszyfw/index" target="_blank">山东省电子税务局</a>，如需查阅最新信息请点击官方页面。
    </div>
</div>
<?php include('footer.php'); ?>
</body>
</html>