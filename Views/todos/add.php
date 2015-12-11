<form method="post" action="">
    <textarea cols="40" rows="4" name="todo_item"></textarea>
    <input type="submit" name="add" value="Add item!"/>
</form>
<?php if($this->error): ?>
<div>
    <?=$this->error;?>
</div>
<?php endif; ?>
