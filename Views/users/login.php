<h1>Login</h1>
<?php if(!isset($_SESSION['user_id'])):?>
<form action="" method="post">
    <table border="1">
        <tr>
            <td>Username:</td>
            <td><input type="text" name='username'/></td>
        </tr>
        <tr>
            <td>Password:</td>
            <td><input type="text" name="pass"/></td>
        </tr>
        <tr>
            <td>Action:</td>
            <td><input type="submit" name="login" value="Login!"/></td>
        </tr>
        <?php if($this->error):?>
        <tr>
            <td>Error:</td>
            <td><?=$this->error;?></td>
        </tr>
        <?php endif;?>
    </table>
</form>
<a href="<?=$this->url('users','register');?>">Register</a>
<div><a href="<?=$this->url('home');?>">Home</a></div>
<?php else:?>
<h1>welcome <?= $this->users; ?></h1>
<a href="<?=$this->url('users','logout');?>">logout</a>
<?php endif;?>