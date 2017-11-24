<html>

<?php echo validation_errors(); ?>
<?php echo form_open('media/login/login'); ?>
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
        <td>
            <button>login</button>
        </td>
    </tr>
</table>
</form>
</html>