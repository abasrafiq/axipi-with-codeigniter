<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo current_url(); ?>"><?php echo $this->lang->line('items'); ?></a></li>
<li><?php echo $this->lang->line('index'); ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $this->lang->line('items'); ?> (<?php echo $position; ?>)</h1>
<ul>
<li><a class="create" href="<?php echo current_url(); ?>?a=create"><?php echo $this->lang->line('create'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('index'); ?></h2>

<?php echo form_open(current_url()); ?>
<div class="filters">
<div><?php echo form_label($this->lang->line('itm_code'), 'groups_items_itm_code'); ?><?php echo form_input('groups_items_itm_code', set_value('groups_items_itm_code', $this->session->userdata('groups_items_itm_code')), 'id="groups_items_itm_code" class="inputtext"'); ?></div>
<div><?php echo form_label($this->lang->line('itm_title'), 'groups_items_itm_title'); ?><?php echo form_input('groups_items_itm_title', set_value('groups_items_itm_title', $this->session->userdata('groups_items_itm_title')), 'id="groups_items_itm_title" class="inputtext"'); ?></div>
<div><?php echo form_label($this->lang->line('sct_code'), 'groups_items_sct_id'); ?><?php echo form_dropdown('groups_items_sct_id', $select_section, set_value('groups_items_sct_id', $this->session->userdata('groups_items_sct_id')), 'id="groups_items_sct_id" class="select"'); ?></div>
<div><?php echo form_label($this->lang->line('cmp_code'), 'groups_items_cmp_code'); ?><?php echo form_input('groups_items_cmp_code', set_value('groups_items_cmp_code', $this->session->userdata('groups_items_cmp_code')), 'id="groups_items_cmp_code" class="inputtext"'); ?></div>
<div><?php echo form_label($this->lang->line('lng_code'), 'groups_items_lng_id'); ?><?php echo form_dropdown('groups_items_lng_id', $select_language, set_value('groups_items_lng_id', $this->session->userdata('groups_items_lng_id')), 'id="groups_items_lng_id" class="select"'); ?></div>
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
<th><a class="sort_desc" href="#"><?php echo $this->lang->line('itm_id'); ?></a></th>
<th><?php echo $this->lang->line('itm_code'); ?></th>
<th><?php echo $this->lang->line('cmp_code'); ?></th>
<?php foreach($groups as $group) { ?>
<th><?php echo $group->grp_code; ?></th>
<?php } ?>
</tr>
</thead>
<tbody>

<?php foreach($results as $result) { ?>
<tr>
<td><?php echo $result->itm_id;?></td>
<td><?php echo $result->itm_code; ?></td>
<td><?php echo $result->cmp_code; ?></td>
<?php foreach($groups as $group) { ?>
<?php if($result->itm_islocked == 1 && $group->grp_islocked == 1) { ?>
<td>-</td>
<?php } else { ?>
<td><?php echo form_checkbox($result->itm_id.$group->grp_id, 1, isset($groups_saved[$result->itm_id][$group->grp_id]), 'id="'.$result->itm_id.$group->grp_id.'" class="inputcheckbox"'); ?></td>
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