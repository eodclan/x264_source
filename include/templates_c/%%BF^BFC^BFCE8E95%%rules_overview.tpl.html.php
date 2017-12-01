<?php /* Smarty version 2.6.20, created on 2017-05-18 21:58:38
         compiled from rules_overview.tpl.html */ ?>

		<?php $_from = $this->_tpl_vars['categories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['categories_list']):
?>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-user-secret'></i><a href="#<?php echo $this->_tpl_vars['categories_list']['SHORT']; ?>
" title="<?php echo $this->_tpl_vars['categories_list']['SHORT']; ?>
"><?php echo $this->_tpl_vars['categories_list']['NAME']; ?>
</a>
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
			<div name="<?php echo $this->_tpl_vars['categories_list']['SHORT']; ?>
">
			<?php $_from = $this->_tpl_vars['aq']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aq_list']):
?>
				<?php if ($this->_tpl_vars['categories_list']['ID'] == $this->_tpl_vars['aq_list']['CAT_ID']): ?>
				<div><center><a href="#<?php echo $this->_tpl_vars['categories_list']['SHORT']; ?>
<?php echo $this->_tpl_vars['aq_list']['ID']; ?>
" title="<?php echo $this->_tpl_vars['categories_list']['SHORT']; ?>
<?php echo $this->_tpl_vars['aq_list']['ID']; ?>
"><?php echo $this->_tpl_vars['aq_list']['QUESTION']; ?>
</a></center></div>
				<?php endif; ?>
			<?php endforeach; endif; unset($_from); ?>
			</div>
		<?php endforeach; endif; unset($_from); ?>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>

<?php $_from = $this->_tpl_vars['categories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['categories_list_1']):
?>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-user-secret'></i><a id="<?php echo $this->_tpl_vars['categories_list_1']['SHORT']; ?>
" name="<?php echo $this->_tpl_vars['categories_list_1']['SHORT']; ?>
"></a><?php echo $this->_tpl_vars['categories_list_1']['NAME']; ?>

                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
	<?php $_from = $this->_tpl_vars['aq']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aq_list_1']):
?>
		<?php if ($this->_tpl_vars['categories_list_1']['ID'] == $this->_tpl_vars['aq_list_1']['CAT_ID']): ?>
			<div>
				<div><span class="normalfont"><a id="<?php echo $this->_tpl_vars['categories_list_1']['SHORT']; ?>
<?php echo $this->_tpl_vars['aq_list_1']['ID']; ?>
" name="<?php echo $this->_tpl_vars['categories_list_1']['SHORT']; ?>
<?php echo $this->_tpl_vars['aq_list_1']['ID']; ?>
"></a><?php echo $this->_tpl_vars['aq_list_1']['QUESTION']; ?>
</span></div>
				<div><?php echo $this->_tpl_vars['aq_list_1']['ANSWER']; ?>
</div>
			</div>
		<?php endif; ?>
	<?php endforeach; endif; unset($_from); ?>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>
<?php endforeach; endif; unset($_from); ?>