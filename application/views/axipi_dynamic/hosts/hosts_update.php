<?php
if($hst) {
?>

<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo current_url(); ?>"><?php echo $this->lang->line('hosts'); ?></a></li>
<li><?php echo $this->lang->line('update'); ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $hst->hst_code; ?></h1>
<ul>
<li><a href="<?php echo current_url(); ?>?a=read&amp;hst_id=<?php echo $hst->hst_id; ?>"><?php echo $this->lang->line('read'); ?></a></li>
<li><a href="<?php echo current_url(); ?>"><?php echo $this->lang->line('index'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('update'); ?></h2>

<?php echo validation_errors(); ?>

<?php echo form_open(current_url().'?a=update&amp;hst_id='.$hst->hst_id); ?>

<div class="column1">
<p><?php echo form_label($this->lang->line('hst_code').' *', 'hst_code'); ?><?php echo form_input('hst_code', set_value('hst_code', $hst->hst_code), 'id="hst_code" class="inputtext"'); ?></p>
<p><?php echo form_label($this->lang->line('hst_url').' *', 'hst_url'); ?><?php echo form_input('hst_url', set_value('hst_url', $hst->hst_url), 'id="hst_url" class="inputtext"'); ?></p>
<p><?php echo form_label($this->lang->line('hst_environment'), 'hst_environment'); ?><?php echo form_input('hst_environment', set_value('hst_environment', $hst->hst_environment), 'id="hst_environment" class="inputtext"'); ?></p>
<p><?php echo form_label($this->lang->line('lay_code'), 'lay_id'); ?><?php echo form_dropdown('lay_id', $select_layout, set_value('lay_id', $hst->lay_id), 'id="lay_id" class="select"'); ?></p>
</div>

<div class="column1 columnlast">
<p><?php echo form_label($this->lang->line('hst_gzhandler'), 'hst_gzhandler'); ?><?php echo form_checkbox('hst_gzhandler', 1, set_value('hst_gzhandler', $hst->hst_gzhandler), 'id="hst_gzhandler" class="inputcheckbox"'); ?></p>
<p><?php echo form_label($this->lang->line('hst_debug'), 'hst_debug'); ?><?php echo form_checkbox('hst_debug', 1, set_value('hst_debug', $hst->hst_debug), 'id="hst_debug" class="inputcheckbox"'); ?></p>
<p><input class="inputsubmit" type="submit" name="submit" id="submit" value="<?php echo $this->lang->line('validate'); ?>"></p>
</div>

</form>

</div>
</div>

<?php
} else {
?>

<?php
}
?>
