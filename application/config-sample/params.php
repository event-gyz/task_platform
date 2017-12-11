<?php

// 广告主审核状态
$config['adv_audit_status'] = [
    '0' => '待审核',
    '1' => '通过',
    '2' => '驳回',
];

// 广告主账户状态
$config['adv_account_status'] = [
    '0' => '草稿',
    '1' => '待审核',
    '2' => '正常',
    '9' => '冻结',
];

// 自媒体人审核状态
$config['media_audit_status'] = [
    '0' => '待审核',
    '1' => '通过',
    '2' => '驳回',
];

// 自媒体人账户状态
$config['media_account_status'] = [
    '0' => '草稿',
    '1' => '待审核',
    '2' => '正常',
    '9' => '冻结',
];

// 任务类型
$config['task_type'] = [
    '1' => '线下执行',
    '2' => '线上传播',
    '3' => '调查收集',
    '4' => '其他',
];

// 学校类型
$config['school_type'] = [
    '1'  => '工科',
    '2'  => '医药',
    '3'  => '财经',
    '4'  => '师范',
    '5'  => '综合',
    '6'  => '农业',
    '7'  => '理工',
    '8'  => '化工',
    '9'  => '海洋',
    '10' => '艺术',
    '11' => '政法',
];

// 办学层次
$config['school_level'] = [
    '1' => '211/985',
    '2' => '本科',
    '3' => '专科',
];

// 年龄
$config['age'] = [
    '1' => '18岁以下',
    '2' => '18-30岁',
    '3' => '31-50岁',
    '4' => '50岁以上',
];

// 兴趣爱好
$config['hobby'] = [
    '1' => '美食',
    '2' => '旅游',
    '3' => '健身',
    '4' => '减肥',
    '5' => '理财',
    '6' => '美妆',
    '7' => '宠物',
    '8' => '购物',
];

// 行业
$config['industry'] = [
    '1' => '学生',
    '2' => '互联网',
    '3' => '传媒/营销',
    '4' => '金融/财经',
    '5' => '电商/微商',
    '6' => '文娱',
    '7' => '母婴',
];

// 微信帐号类型
$config['wx_type'] = [
    '1' => '个人号',
    '2' => '企业号',
    '3' => '订阅号',
    '4' => '服务号',
];

// 微博帐号类型
$config['weibo_type'] = [
    '1' => '普通用户',
    '2' => '个人认证微博号',
    '3' => '机构认证微博号',
];

// 发布平台
$config['publishing_platform'] = [
    '1'   => '微信',
    '2'   => '微博',
    '1,2' => '微信微博',
];

// 任务类型
$config['task_type'] = [
    '1' => '线下执行',
    '2' => '线上传播',
    '3' => '调查收集',
    '4' => '其他',
];

// 任务状态
$config['task_status'] = [
    '1' => '待审核',
    '2' => '待广告主付款',
    '3' => '待财务确认',
    '4' => '财务已确认',
    '5' => '驳回',
];

// 任务审核状态
$config['task_audit_status'] = [
    '0' => '草稿',
    '1' => '待审核',
    '2' => '审核失败',
    '3' => '审核成功',
];

// 任务完成标准
$config['task_completion_criteria'] = [
    '1'   => '图片',
    '2'   => '链接',
    '1,2' => '图片加链接',
];

$config['require_sex'] = [
    '0' => '不限',
    '1' => '男',
    '2' => '女',
];

// 发布管理列表中的任务状态
$config['release_task_status'] = [
    '1' => '待发布',
    '2' => '执行中',
    '3' => '待确认完成',
];

// 自媒体人结账列表中的财务状态
$config['media_man_list_finance_status'] = [
    '1' => '待付款',
    '2' => '待确认收款',
    '3' => '已完成',
];

// 自媒体人结账列表中的支付方式
$config['media_man_list_platform_pay_way'] = [
    '1' => '线下',
    '2' => '线上',
];

// 广告主付款列表中的支付方式
$config['adv_list_pay_way'] = [
    '1' => '线下',
    '2' => '线上',
];

// 广告主付款列表中的财务状态
$config['adv_list_finance_status'] = [
    '1' => '待财务确认',
    '2' => '已支付',
];

