<?php /**
 * @var Todo\Models\Todo $items
 */ ?>
<?php foreach ($this->items as $item): ?>
    <ul>
        <li><?= $item['id'] . ' | ' . $item['todo_item']; ?>
            <a href="<?= $this->url('todos', 'delete', array('id' => $item['id'])); ?>">delete</a></li>

    </ul>

<?php endforeach; ?>
<div><a href="<?= $this->url('todos', 'add'); ?>">Add items</a></div>
<div><a href="<?= $this->url('users', 'logout'); ?>">Logout</a></div>

