<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo current_url(); ?>"><?php echo $this->lang->line('permissions'); ?></a></li>
<li><?php echo $this->lang->line('index'); ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $this->lang->line('permissions'); ?> (<?php echo $position; ?>)</h1>
<ul>
<li><a class="create" href="<?php echo current_url(); ?>?a=create"><?php echo $this->lang->line('create'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('index'); ?></h2>

<?php echo form_open(current_url()); ?>
<div class="filters">
<div><?php echo form_label($this->lang->line('per_code'), 'groups_permissions_per_code'); ?><?php echo form_input('groups_permissions_per_code', set_value('groups_permissions_per_code', $this->session->userdata('groups_permissions_per_code')), 'id="groups_permissions_per_code" class="inputtext"'); ?></div>
<div><input class="inputsubmit" type="submit" name="submit" id="submit" value="<?php echo $this->lang->line('validate'); ?>"></div>
</div>
</form>

<?php if($results) { ?>

<div class="paging">
<?php echo $pagination; ?>
</div>

<?php echo form_open(current_url()); ?>

<table>
<thead>
<tr>
<th><a class="sort_desc" href="#"><?php echo $this->lang->line('per_id'); ?></a></th>
<th><?php echo $this->lang->line('per_code'); ?></th>
<?php foreach($groups as $group) { ?>
<th><?php echo $group->grp_code; ?></th>
<?php } ?>
</tr>
</thead>
<tbody>

<?php foreach($results as $result) { ?>
<tr>
<td><a href="<?php echo current_url(); ?>?a=read&amp;per_id=<?php echo $result->per_id;?>"><?php echo $result->per_id;?></a></td>
<td><?php echo $result->per_code; ?></td>
<?php foreach($groups as $group) { ?>
<?php if($result->per_islocked == 1 && $group->grp_islocked == 1) { ?>
<td>-</td>
<?php } else { ?>
<td><?php echo form_checkbox($result->per_id.$group->grp_id, 1, isset($groups_saved[$result->per_id][$group->grp_id]), 'id="'.$result->per_id.$group->grp_id.'" class="inputcheckbox"'); ?></td>
<?php } ?>
<?php } ?>
</tr>
<?php } ?>

</tbody>
</table>

<p><input class="inputsubmit" type="submit" name="submit_groups" id="submit_groups" value="<?php echo $this->lang->line('validate'); ?>"></p>

</form>

<div class="paging">
<?php echo $pagination; ?>
</div>

<?php } ?>

</div>
</div>