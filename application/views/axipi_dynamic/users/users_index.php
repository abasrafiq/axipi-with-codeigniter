<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo current_url(); ?>"><?php echo $this->lang->line('users'); ?></a></li>
<li><?php echo $this->lang->line('index'); ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $this->lang->line('users'); ?> (<?php echo $position; ?>)</h1>
<ul>
<li><a class="create" href="<?php echo current_url(); ?>?a=create"><?php echo $this->lang->line('create'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('index'); ?></h2>

<?php echo form_open(current_url()); ?>
<div class="filters">
<div><?php echo form_label($this->lang->line('usr_email'), 'users_usr_email'); ?><?php echo form_input('users_usr_email', set_value('users_usr_email', $this->session->userdata('users_usr_email')), 'id="users_usr_email" class="inputtext"'); ?></div>
<div><input class="inputsubmit" type="submit" name="submit" id="submit" value="<?php echo $this->lang->line('validate'); ?>"></div>
</div>
</form>

<?php if($results) { ?>

<div class="paging">
<?php echo $pagination; ?>
</div>

<table>
<thead>
<tr>
<?php display_column('users', $columns[0], $this->lang->line('usr_id')); ?>
<?php display_column('users', $columns[1], $this->lang->line('usr_email')); ?>
<?php display_column('users', $columns[2], $this->lang->line('groups')); ?>
<th>&nbsp;</th>
</tr>
</thead>
<tbody>

<?php foreach($results as $result) { ?>
<tr>
<td><a href="<?php echo current_url(); ?>?a=read&amp;usr_id=<?php echo $result->usr_id;?>"><?php echo $result->usr_id;?></a></td>
<td><?php echo $result->usr_email; ?></td>
<td><?php echo $result->count_groups; ?><?php if($result->count_groups > 0) { ?> (<?php echo $result->groups; ?>)<?php } ?></td>
<th>
<a href="<?php echo current_url(); ?>?a=update&amp;usr_id=<?php echo $result->usr_id;?>"><?php echo $this->lang->line('update'); ?></a>
<?php if($result->count_groups == 0 && $result->usr_islocked == 0) { ?><a href="<?php echo current_url(); ?>?a=delete&amp;usr_id=<?php echo $result->usr_id;?>"><?php echo $this->lang->line('delete'); ?></a><?php } ?>
</th>
</tr>
<?php } ?>

</tbody>
</table>

<div class="paging">
<?php echo $pagination; ?>
</div>

<?php } ?>

</div>
</div>
