<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo current_url(); ?>"><?php echo $this->lang->line('items'); ?></a></li>
<li><a href="<?php echo current_url(); ?>?a=add"><?php echo $this->lang->line('index'); ?></a></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $this->lang->line('item'); ?></h1>
<ul>
<li><a href="<?php echo current_url(); ?>"><?php echo $this->lang->line('index'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('add'); ?></h2>

<?php echo validation_errors(); ?>

<?php echo form_open(current_url().'?a=add'); ?>

<div class="column1">
<p><?php echo form_label($this->lang->line('sct_code').' *', 'sct_id'); ?><?php echo form_dropdown('sct_id', $select_section, set_value('sct_id'), 'class="select"'); ?></p>
<p><?php echo form_label($this->lang->line('itm_code'), 'itm_code'); ?><?php echo form_input('itm_code', set_value('itm_code'), 'class="inputtext"'); ?></p>
<p><?php echo form_label($this->lang->line('itm_virtualcode'), 'itm_virtualcode'); ?><?php echo form_input('itm_virtualcode', set_value('itm_virtualcode'), 'class="inputtext"'); ?></p>
<p><?php echo form_label($this->lang->line('itm_title').' *', 'itm_title'); ?><?php echo form_input('itm_title', set_value('itm_title'), 'class="inputtext"'); ?></p>
<p><?php echo form_label($this->lang->line('cmp_code').' *', 'cmp_id'); ?><?php echo form_dropdown('cmp_id', $select_component, set_value('cmp_id'), 'class="select"'); ?></p>
<p><?php echo form_label($this->lang->line('itm_content'), 'itm_content'); ?><?php echo form_textarea('itm_content', set_value('itm_content'), 'class="textarea"'); ?></p>
<p><?php echo form_label($this->lang->line('itm_summary'), 'itm_summary'); ?><?php echo form_textarea('itm_summary', set_value('itm_summary'), 'class="textarea"'); ?></p>
<p><?php echo form_label($this->lang->line('itm_link'), 'itm_link'); ?><?php echo form_input('itm_link', set_value('itm_link'), 'class="inputtext"'); ?></p>
</div>

<div class="column1 columnlast">
<p><?php echo form_label($this->lang->line('itm_description'), 'itm_description'); ?><?php echo form_textarea('itm_description', set_value('itm_description'), 'class="textarea"'); ?></p>
<p><?php echo form_label($this->lang->line('itm_keywords'), 'itm_keywords'); ?><?php echo form_textarea('itm_keywords', set_value('itm_keywords'), 'class="textarea"'); ?></p>
<p><?php echo form_label($this->lang->line('itm_ordering').' *', 'itm_ordering'); ?><?php echo form_input('itm_ordering', set_value('itm_ordering', 0), 'class="inputtext numericfield"'); ?></p>
<p><?php echo form_label($this->lang->line('lng_code').' *', 'lng_id'); ?><?php echo form_dropdown('lng_id', $select_language, set_value('lng_id', 1000), 'class="select"'); ?></p>
<p><?php echo form_label($this->lang->line('itm_access').' *', 'itm_access'); ?><?php echo form_dropdown('itm_access', $this->lang->line('itm_access_values'), set_value('itm_access', 'all'), 'class="select"'); ?></p>
<p><input type="submit" name="submit" id="submit" value="<?php echo $this->lang->line('validate'); ?>"></p>
</div>

</form>

</div>
</div>
