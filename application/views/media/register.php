<html>

<?php echo validation_errors(); ?>
<?php echo form_open('media/index/register'); ?>
<table>
    <tr>
        <td>用户名</td>
        <td><input type="text" name="username"></td>
    </tr>
    <tr>
        <td>密码</td>
        <td><input type="password" name="password"></td>
    </tr>
    <tr>
        <td>确认密码</td>
        <td><input type="password" name="re_password"></td>
    </tr>
    <tr>
        <td>手机号</td>
        <td><input type="text" name="phone"></td>
    </tr>
    <tr>
        <td>验证码</td>
        <td><input type="text" name="code"></td>
    </tr>
    <tr>
        <td>
            <button>register</button>
        </td>
    </tr>
</table>
</form>
</html>