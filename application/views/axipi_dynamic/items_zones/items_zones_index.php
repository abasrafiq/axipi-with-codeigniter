<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo ci_url(); ?><?php echo $this->itm->itm_code; ?>"><?php echo $this->lang->line('zones'); ?></a></li>
<li><?php echo $this->lang->line('index'); ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $this->lang->line('zones'); ?> (<?php echo $position; ?>)</h1>
<div class="display">

<?php echo form_open(ci_url().$this->itm->itm_code); ?>
<div class="filters">
<div><?php echo form_label($this->lang->line('zon_code'), 'items_zones_zon_code'); ?><?php echo form_input('items_zones_zon_code', set_value('items_zones_zon_code', $this->session->userdata('items_zones_zon_code')), 'id="items_zones_zon_code" class="inputtext"'); ?></div>
<div><?php echo form_label($this->lang->line('lay_code'), 'items_zones_lay_id'); ?><?php echo form_dropdown('items_zones_lay_id', $select_layout, set_value('items_zones_lay_id', $this->session->userdata('items_zones_lay_id')), 'id="items_zones_lay_id" class="select"'); ?></div>
<div><input class="inputsubmit" type="submit" name="submit" id="submit" value="<?php echo $this->lang->line('validate'); ?>"></div>
</div>
</form>

<div class="paging">
<?php echo $pagination; ?>
</div>

<?php foreach($results as $result) { ?>
<div class="box1">
<h1><?php echo $result->lay_code.' - '.$result->zon_code; ?></h1>
<ul>
<li><a class="create" href="<?php echo ci_url(); ?><?php echo $this->itm->itm_code; ?>/_create/<?php echo $result->zon_id; ?>"><?php echo $this->lang->line('create'); ?></a></li>
</ul>
<div class="display">

<?php if(isset($items_zones[$result->zon_id]) == 1) { ?>

<table>
<thead>
<tr>
<th style="width: 20%;"><?php echo $this->lang->line('itm_title'); ?></th>
<th style="width: 10%;"><?php echo $this->lang->line('sct_code'); ?></th>
<th style="width: 20%;"><?php echo $this->lang->line('cmp_code'); ?></th>
<th style="width: 10%;"><?php echo $this->lang->line('lng_code'); ?></th>
<th style="width: 15%;"><?php echo $this->lang->line('itm_access'); ?></th>
<th style="width: 10%;"><?php echo $this->lang->line('itm_zon_ordering'); ?></th>
<th style="width: 10%;"><?php echo $this->lang->line('itm_zon_ispublished'); ?></th>
<th style="width: 5%;">&nbsp;</th>
</tr>
</thead>
<tbody>

<?php foreach($items_zones[$result->zon_id] as $itm_zon) { ?>
<tr>
<td><a href="<?php echo ci_url(); ?><?php echo $this->itm->itm_code; ?>/_read/<?php echo $result->zon_id;?>/<?php echo $itm_zon->itm_id;?>"><?php echo $itm_zon->itm_title;?></a></td>
<td><?php echo $itm_zon->sct_code; ?></td>
<td><?php echo $itm_zon->cmp_code; ?></td>
<td><?php echo $itm_zon->lng_code; ?></td>
<td><?php echo $itm_zon->itm_access; ?><?php if($itm_zon->count_groups != 0 && $itm_zon->itm_access == 'groups') { ?> (<?php echo $itm_zon->groups; ?>)<?php } ?>
<td><?php echo $itm_zon->itm_zon_ordering; ?></td>
<td><?php echo $this->lang->line('reply_'.$itm_zon->itm_zon_ispublished); ?></td>
<th>
<a href="<?php echo ci_url(); ?><?php echo $this->itm->itm_code; ?>/_update/<?php echo $result->zon_id;?>/<?php echo $itm_zon->itm_id;?>"><?php echo $this->lang->line('update'); ?></a>
<a href="<?php echo ci_url(); ?><?php echo $this->itm->itm_code; ?>/_delete/<?php echo $result->zon_id;?>/<?php echo $itm_zon->itm_id;?>"><?php echo $this->lang->line('delete'); ?></a>
</th>
</tr>
<?php } ?>

</tbody>
</table>

<?php } ?>

</div>
</div>

<?php } ?>

<div class="paging">
<?php echo $pagination; ?>
</div>

</div>
</div>
