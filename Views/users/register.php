<h1>Registration</h1>
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
            <td><input type="submit" name="register" value="Register!"/></td>
        </tr>
        <?php if($this->error ):;?>
        <tr>
            <td>Error:</td>
            <td><?=$this->error;?></td>
        </tr>
        <?php endif;?>
      
    </table>
</form>
<a href="<?=$this->url('users','login');?>">Login</a>
<div><a href="<?=$this->url('home');?>">Home</a></div>