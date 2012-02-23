<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo current_url(); ?>"><?php echo $this->lang->line('components'); ?></a></li>
<li><?php echo $this->lang->line('index'); ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $this->lang->line('components'); ?></h1>
<ul>
<li><a class="create" href="<?php echo current_url(); ?>?a=create"><?php echo $this->lang->line('create'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('index'); ?></h2>

<?php echo form_open(current_url()); ?>
<div class="filters">
<div><?php echo form_label($this->lang->line('cmp_code'), 'components_cmp_code'); ?><?php echo form_input('components_cmp_code', set_value('components_cmp_code', $this->session->userdata('components_cmp_code')), 'class="inputtext"'); ?></div>
<div><input class="inputsubmit" type="submit" name="submit" id="submit" value="<?php echo $this->lang->line('validate'); ?>"></div>
</div>
</form>

<div class="paging">
<?php echo $pagination; ?>
</div>

<table>
<thead>
<tr>
<th><a class="sort_desc" href="#"><?php echo $this->lang->line('cmp_id'); ?></a></th>
<th><?php echo $this->lang->line('cmp_code'); ?></th>
<th><?php echo $this->lang->line('items'); ?></th>
<th>&nbsp;</th>
</tr>
</thead>
<tbody>

<?php foreach($results as $result):?>
<tr>
<td><a href="<?php echo current_url(); ?>?a=read&amp;cmp_id=<?php echo $result->cmp_id;?>"><?php echo $result->cmp_id;?></a></td>
<td><?php echo $result->cmp_code; ?></td>
<td><?php echo $result->count_items; ?></td>
<th>
<a href="<?php echo current_url(); ?>?a=update&amp;cmp_id=<?php echo $result->cmp_id;?>"><?php echo $this->lang->line('update'); ?></a>
<?php if($result->count_items == 0 && $result->cmp_islocked == 0) { ?><a href="<?php echo current_url(); ?>?a=delete&amp;cmp_id=<?php echo $result->cmp_id;?>"><?php echo $this->lang->line('delete'); ?></a><?php } ?>
</th>
</tr>
<?php endforeach;?>

</tbody>
</table>

<div class="paging">
<?php echo $pagination; ?>
</div>

</div>
</div>