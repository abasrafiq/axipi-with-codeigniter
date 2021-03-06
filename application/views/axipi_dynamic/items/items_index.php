<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo ci_url(); ?><?php echo $this->itm->itm_code; ?>"><?php echo $this->lang->line('items'); ?></a></li>
<li><?php echo $this->lang->line('index'); ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $this->lang->line('items'); ?> (<?php echo $position; ?>)</h1>
<ul>
<li><a class="create" href="<?php echo ci_url(); ?><?php echo $this->itm->itm_code; ?>/_create"><?php echo $this->lang->line('create'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('index'); ?></h2>

<?php echo form_open(ci_url().$this->itm->itm_code); ?>
<div class="filters">
<div><?php echo form_label($this->lang->line('itm_code'), 'items_itm_code'); ?><?php echo form_input('items_itm_code', set_value('items_itm_code', $this->session->userdata('items_itm_code')), 'id="items_itm_code" class="inputtext"'); ?></div>
<div><?php echo form_label($this->lang->line('itm_title'), 'items_itm_title'); ?><?php echo form_input('items_itm_title', set_value('items_itm_title', $this->session->userdata('items_itm_title')), 'id="items_itm_title" class="inputtext"'); ?></div>
<div><?php echo form_label($this->lang->line('sct_code'), 'items_sct_id'); ?><?php echo form_dropdown('items_sct_id', $select_section, set_value('items_sct_id', $this->session->userdata('items_sct_id')), 'id="items_sct_id" class="select"'); ?></div>
<div><?php echo form_label($this->lang->line('cmp_code'), 'items_cmp_code'); ?><?php echo form_input('items_cmp_code', set_value('items_cmp_code', $this->session->userdata('items_cmp_code')), 'id="items_cmp_code" class="inputtext"'); ?></div>
<div><?php echo form_label($this->lang->line('lng_code'), 'items_lng_id'); ?><?php echo form_dropdown('items_lng_id', $select_language, set_value('items_lng_id', $this->session->userdata('items_lng_id')), 'id="items_lng_id" class="select"'); ?></div>
<div><?php echo form_label($this->lang->line('itm_ispublished'), 'items_itm_ispublished'); ?><?php echo form_dropdown('items_itm_ispublished', $select_ispublished, set_value('items_itm_ispublished', $this->session->userdata('items_itm_ispublished')), 'id="items_itm_ispublished" class="select"'); ?></div>
<div><?php echo form_label($this->lang->line('layout'), 'items_lay_id'); ?><?php echo form_dropdown('items_lay_id', $select_ispublished, set_value('items_lay_id', $this->session->userdata('items_lay_id')), 'id="items_lay_id" class="select"'); ?></div>
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
<?php display_column(ci_url().$this->itm->itm_code, 'items', $columns[0], $this->lang->line('itm_id')); ?>
<?php display_column(ci_url().$this->itm->itm_code, 'items', $columns[1], $this->lang->line('itm_code')); ?>
<?php display_column(ci_url().$this->itm->itm_code, 'items', $columns[2], $this->lang->line('itm_title')); ?>
<?php display_column(ci_url().$this->itm->itm_code, 'items', $columns[3], $this->lang->line('sct_code')); ?>
<?php display_column(ci_url().$this->itm->itm_code, 'items', $columns[4], $this->lang->line('cmp_code')); ?>
<?php display_column(ci_url().$this->itm->itm_code, 'items', $columns[5], $this->lang->line('lng_code')); ?>
<?php display_column(ci_url().$this->itm->itm_code, 'items', $columns[6], $this->lang->line('itm_ispublished')); ?>
<?php display_column(ci_url().$this->itm->itm_code, 'items', $columns[7], $this->lang->line('itm_access')); ?>
<th>&nbsp;</th>
</tr>
</thead>
<tbody>

<?php foreach($results as $result) { ?>
<tr>
<td><a href="<?php echo ci_url(); ?><?php echo $this->itm->itm_code; ?>/_read/<?php echo $result->itm_id;?>"><?php echo $result->itm_id;?></a></td>
<td><?php echo $result->itm_code; ?></td>
<td><?php echo $result->itm_title; ?></td>
<td><?php echo $result->sct_code; ?></td>
<td><?php echo $result->cmp_code; ?></td>
<td><?php echo $result->lng_code; ?></td>
<td><?php echo $this->lang->line('reply_'.$result->itm_ispublished); ?></td>
<td><?php echo $result->itm_access; ?><?php if($result->count_groups != 0 && $result->itm_access == 'groups') { ?> (<?php echo $result->groups; ?>)<?php } ?>
</td>
<th>
<a href="<?php echo ci_url(); ?><?php echo $this->itm->itm_code; ?>/_update/<?php echo $result->itm_id;?>"><?php echo $this->lang->line('update'); ?></a>
<?php if($result->count_items == 0 && $result->itm_islocked == 0) { ?><a href="<?php echo ci_url(); ?><?php echo $this->itm->itm_code; ?>/_delete/<?php echo $result->itm_id;?>"><?php echo $this->lang->line('delete'); ?></a><?php } ?>
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
