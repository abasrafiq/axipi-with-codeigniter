<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo current_url(); ?>"><?php echo $this->lang->line('countries'); ?></a></li>
<li><?php echo $this->lang->line('index'); ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $this->lang->line('countries'); ?> (<?php echo $position; ?>)</h1>
<ul>
<li><a class="create" href="<?php echo current_url(); ?>?a=create"><?php echo $this->lang->line('create'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('index'); ?></h2>

<?php echo form_open(current_url()); ?>
<div class="filters">
<div><?php echo form_label($this->lang->line('cou_alpha2'), 'countries_cou_alpha2'); ?><?php echo form_input('countries_cou_alpha2', set_value('countries_cou_alpha2', $this->session->userdata('countries_cou_alpha2')), 'id="countries_cou_alpha2" class="inputtext"'); ?></div>
<div><?php echo form_label($this->lang->line('cou_alpha3'), 'countries_cou_alpha3'); ?><?php echo form_input('countries_cou_alpha3', set_value('countries_cou_alpha3', $this->session->userdata('countries_cou_alpha3')), 'id="countries_cou_alpha3" class="inputtext"'); ?></div>
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
<th><?php display_column('countries', $columns[0], $this->lang->line('cou_id')); ?></th>
<th><?php display_column('countries', $columns[1], $this->lang->line('cou_alpha2')); ?></th>
<th><?php display_column('countries', $columns[2], $this->lang->line('cou_alpha3')); ?></th>
<th><?php display_column('countries', $columns[3], $this->lang->line('subdivisions')); ?></th>
<th><?php display_column('countries', $columns[4], $this->lang->line('items')); ?></th>
<th><?php display_column('countries', $columns[5], $this->lang->line('users')); ?></th>
<th>&nbsp;</th>
</tr>
</thead>
<tbody>

<?php foreach($results as $result) { ?>
<tr>
<td><a href="<?php echo current_url(); ?>?a=read&amp;cou_id=<?php echo $result->cou_id;?>"><?php echo $result->cou_id;?></a></td>
<td><?php echo $result->cou_alpha2; ?></td>
<td><?php echo $result->cou_alpha3; ?></td>
<td><?php echo $result->count_subdivisions; ?></td>
<td><?php echo $result->count_items; ?></td>
<td><?php echo $result->count_users; ?></td>
<th>
<a href="<?php echo current_url(); ?>?a=update&amp;cou_id=<?php echo $result->cou_id;?>"><?php echo $this->lang->line('update'); ?></a>
<?php if($result->count_items == 0 && $result->count_users == 0 && $result->cou_islocked == 0) { ?><a href="<?php echo current_url(); ?>?a=delete&amp;cou_id=<?php echo $result->cou_id;?>"><?php echo $this->lang->line('delete'); ?></a><?php } ?>
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
