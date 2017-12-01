<!DOCTYPE html>
<html>

<?php include VIEWPATH . '/admin/common/head.php'; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" v-loading.body="loading" element-loading-text="拼命加载中">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            自媒体人详情
            <small>修改自媒体人</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">基本信息</h3>
            </div>
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-2 invoice-col">
                        <b>用户ID：</b> <?= $info['media_man_id'] ?><br><br>
                    </div>

                    <div class="col-sm-2 invoice-col">
                        <b>用户名：</b> <?= $info['media_man_login_name'] ?><br><br>
                    </div>

                    <div class="col-sm-2 invoice-col">
                        <b>注册时间：</b> <?= $info['create_time'] ?><br><br>
                    </div>

                    <div class="col-sm-2 invoice-col">
                        <b>审核状态：</b>
                        <small class="label
                                            <?= $info['audit_status'] === "0" ? "bg-yellow" : "" ?>
                                            <?= $info['audit_status'] === "1" ? "bg-green" : "" ?>
                                            <?= $info['audit_status'] === "2" ? "bg-red" : "" ?>
                                        ">
                            <?= $media_audit_status[$info['audit_status']] ?>
                        </small>
                        <br><br>
                    </div>

                    <div class="col-sm-2">
                        <b>账户状态：</b>
                        <small class="label
                                            <?= $info['status'] === "0" ? "bg-gray" : "" ?>
                                            <?= $info['status'] === "1" ? "bg-yellow" : "" ?>
                                            <?= $info['status'] === "2" ? "bg-green" : "" ?>
                                            <?= $info['status'] === "9" ? "bg-red" : "" ?>
                                        ">
                            <?= $media_account_status[$info['status']] ?>
                        </small>

                        <br><br>
                    </div>

                </div>

            </div>
            <!-- /.box-body -->
        </div>


        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">修改基本信息</h3>
            </div>
            <div class="box-body">

                <div class="row">
                    <div class="col-xs-6">

                        <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="100px"
                                 class="demo-ruleForm" size="medium">

                            <el-form-item label="姓名" prop="name">
                                <el-input v-model="ruleForm.name"></el-input>
                            </el-form-item>

                            <el-form-item label="性别" prop="resource">
                                <el-radio-group v-model="ruleForm.audit_status">
                                    <el-radio label="1">男</el-radio>
                                    <el-radio label="2">女</el-radio>
                                </el-radio-group>
                            </el-form-item>

                            <el-form-item label="电话" prop="name">
                                <el-input v-model="ruleForm.name"></el-input>
                            </el-form-item>

                            <el-form-item label="学校名称" prop="name">
                                <el-input v-model="ruleForm.name"></el-input>
                            </el-form-item>

                            <el-form-item label="学校类型" prop="region">
                                <el-select v-model="ruleForm.region" placeholder="请选择学习类型">
                                    <el-option label="公立学校" value="1"></el-option>
                                    <el-option label="私立学校 value=" 2
                                    "></el-option>
                                </el-select>
                            </el-form-item>

                            <el-form-item label="学校地区" prop="region">

                                <el-col :span="4">
                                    <el-select v-model="ruleForm.region" placeholder="请选择学习类型">
                                        <el-option label="公立学校" value="1"></el-option>
                                        <el-option label="私立学校 value=" 2
                                        "></el-option>
                                    </el-select>
                                </el-col>

                                <el-col :span="2">&nbsp;</el-col>

                                <el-col :span="4">
                                    <el-select v-model="ruleForm.region" placeholder="请选择学习类型">
                                        <el-option label="公立学校" value="1"></el-option>
                                        <el-option label="私立学校 value=" 2
                                        "></el-option>
                                    </el-select>
                                </el-col>

                                <el-col class="line" :span="2">&nbsp;</el-col>

                                <el-col :span="4">
                                    <el-select v-model="ruleForm.region" placeholder="请选择学习类型">
                                        <el-option label="公立学校" value="1"></el-option>
                                        <el-option label="私立学校 value=" 2
                                        "></el-option>
                                    </el-select>
                                </el-col>


                            </el-form-item>


                            <el-form-item label="办学层次" prop="region">
                                <el-select v-model="ruleForm.region" placeholder="请选择学习类型">
                                    <el-option label="初中" value="1"></el-option>
                                    <el-option label="高中 value=" 2
                                    "></el-option>
                                </el-select>
                            </el-form-item>

                            <el-form-item label="支付宝账号" prop="name">
                                <el-input v-model="ruleForm.name"></el-input>
                            </el-form-item>

                            <el-form-item label="真实姓名" prop="name">
                                <el-input v-model="ruleForm.name"></el-input>
                            </el-form-item>

                            <el-form-item label="年龄" prop="resource">
                                <el-radio-group v-model="ruleForm.audit_status">
                                    <el-radio label="1">18岁以下</el-radio>
                                    <el-radio label="2">18-30</el-radio>
                                    <el-radio label="3">31-50</el-radio>
                                    <el-radio label="3">50岁以上</el-radio>
                                </el-radio-group>
                            </el-form-item>

                            <el-form-item label="兴趣爱好" prop="type">
                                <el-checkbox-group v-model="ruleForm.type">
                                    <el-checkbox label="美食/餐厅线上活动" name="type"></el-checkbox>
                                    <el-checkbox label="地推活动" name="type"></el-checkbox>
                                    <el-checkbox label="线下主题活动" name="type"></el-checkbox>
                                    <el-checkbox label="单纯品牌曝光" name="type"></el-checkbox>
                                </el-checkbox-group>
                            </el-form-item>

                            <el-form-item label="行业" prop="type">
                                <el-checkbox-group v-model="ruleForm.type">
                                    <el-checkbox label="美食/餐厅线上活动" name="type"></el-checkbox>
                                    <el-checkbox label="地推活动" name="type"></el-checkbox>
                                    <el-checkbox label="线下主题活动" name="type"></el-checkbox>
                                    <el-checkbox label="单纯品牌曝光" name="type"></el-checkbox>
                                </el-checkbox-group>
                            </el-form-item>

                            <el-form-item label="微信号" prop="name">
                                <el-input v-model="ruleForm.name"></el-input>
                            </el-form-item>


                            <el-form-item label="账号类型" prop="region">
                                <el-select v-model="ruleForm.region" placeholder="请选择学习类型">
                                    <el-option label="公众号" value="1"></el-option>
                                    <el-option label="高中 value=" 2
                                    "></el-option>
                                </el-select>
                            </el-form-item>

                            <el-form-item label="最高粉丝量" prop="name" :span="12">
                                <el-input v-model="ruleForm.name"></el-input>
                            </el-form-item>

                            <el-form-item label="微博昵称" prop="name">
                                <el-input v-model="ruleForm.name"></el-input>
                            </el-form-item>

                            <el-form-item label="账号类型" prop="region">
                                <el-select v-model="ruleForm.region" placeholder="请选择学习类型">
                                    <el-option label="企业认证" value="1"></el-option>
                                    <el-option label="个人认证 value=" 2
                                    "></el-option>
                                </el-select>
                            </el-form-item>

                            <el-form-item label="最高粉丝量" prop="name">
                                <el-input v-model="ruleForm.name"></el-input>
                            </el-form-item>

                            <el-form-item label="微博链接" prop="name">
                                <el-input v-model="ruleForm.name"></el-input>
                            </el-form-item>

                            <el-form-item>
                                <el-button type="primary" @click="submitForm('ruleForm')">立即创建</el-button>
                                <el-button @click="resetForm('ruleForm')">重置</el-button>
                            </el-form-item>
                        </el-form>

                    </div>
                    <!-- /.col -->
                </div>

            </div>
            <!-- /.box-body -->
        </div>

    </section>
    <!-- /.content -->
    <div class="clearfix"></div>
</div>
<!-- /.content-wrapper -->

<?php include VIEWPATH . '/admin/common/foot.php' ?>

<script>

    var Main = {
        data   : function () {
            return {
                loading     : false,// 是否显示加载
                media_man_id: <?= $info['media_man_id']?>,
                ruleForm    : {
                    audit_status         : '',
                    reasons_for_rejection: ''
                },
                rules       : {
                    audit_status         : [
                        {required: true, message: '请选审核结果', trigger: 'change'}
                    ],
                    reasons_for_rejection: [
                        {required: false, message: '请填写拒绝的原因', trigger: 'blur'}
                    ]
                }
            };
        },
        methods: {
            submitForm : function (formName) {
                this.$refs[formName].validate((valid) => {

                    if (!valid) {
                        this.$message.error('请选审核结果');
                        return false;
                    }

                    if (this.ruleForm.audit_status === "2") {
                        if (this.ruleForm.reasons_for_rejection === "") {
                            this.$message.error('请填写拒绝的原因');
                            return false;
                        }
                    }

                    this.media_audit();
                });
            },
            goBack     : function (formName) {
                window.location.href = '/admin/platform_media_man/home';
            },
            media_audit: async function () {
                try {
                    this.loading = true;
                    var url      = '/admin/platform_media_man/update_media_audit_status';
                    var response = await axios.post(
                        url,
                        {
                            "id"                   : this.media_man_id,
                            "audit_status"         : this.ruleForm.audit_status,
                            "reasons_for_rejection": this.ruleForm.reasons_for_rejection,
                        },
                    );
                    this.loading = false;
                    var resData  = response.data;

                    if (resData.error_no === 0) {
                        this.$message.success('操作成功,即将刷新页面...');
                        return window.location.reload();
                    }

                    return this.$message.error(resData.msg);
                }
                catch (error) {

                    this.loading = false;

                    if (error instanceof Error) {

                        if (error.response) {
                            return this.$message.error(error.response.data.responseText);
                        }

                        if (error.request) {
                            console.error(error.request);
                            return this.$message.error('服务器未响应');
                        }

                        console.error(error);

                    }

                }
            },
        }
    };
    var Ctor = Vue.extend(Main);
    new Ctor().$mount('#app')

</script>

</html>
