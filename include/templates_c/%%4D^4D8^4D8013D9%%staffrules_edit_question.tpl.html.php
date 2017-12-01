<?php /* Smarty version 2.6.20, created on 2017-09-18 19:35:29
         compiled from staffrules_edit_question.tpl.html */ ?>
<?php if ($this->_tpl_vars['EDIT_QUESTION'] == 1): ?>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i> Kategorie bearbeiten
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
	<form method="post" name="editQuestion" action="staffrulesadmin.php?action=doeditquestion">
		<div class="tableb">Kategorie</div>
		<div class="tablea">
			<select name="category">
			<?php $_from = $this->_tpl_vars['categories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['categories_data']):
?>
				<option value="<?php echo $this->_tpl_vars['categories_data']['ID']; ?>
" <?php if ($this->_tpl_vars['question']['CATEGORY'] == $this->_tpl_vars['categories_data']['ID']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['categories_data']['NAME']; ?>
</option>
			<?php endforeach; endif; unset($_from); ?>
			</select>	
		</div>
		<div class="tableb">Regel</div><div class="tablea"><input type="text" name="question" value="<?php echo $this->_tpl_vars['question']['QUESTION']; ?>
" size="50" /></div>
		<div class="tableb">Text</div><div class="tablea"><textarea name="answer" rows="12" cols="50"><?php echo $this->_tpl_vars['question']['ANSWER']; ?>
</textarea></div>
		<div class="tableb"><input type="hidden" name="qid" value="<?php echo $this->_tpl_vars['question']['ID']; ?>
" /><input type="submit" name="submit" value="Abschicken"></div>
	</form>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>
<?php endif; ?> 
<?php if ($this->_tpl_vars['EDIT_QUESTION_DO'] == 1): ?>
	<?php if ($this->_tpl_vars['EMPTY'] == 1): ?>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i> Kategorie bearbeiten
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
		<div class="tableb">Du musst alle Felder ausfuellen! <a href="staffrulesadmin.php?action=editquestion&qid=<?php echo $this->_tpl_vars['QID']; ?>
" title="">Zum Formular</a></div>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>	
	<?php endif; ?>
	<?php if ($this->_tpl_vars['SUCCESS'] == 1): ?>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i> Kategorie bearbeiten
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
		<div class="tableb">Die Regel wurde erfolgreich bearbeitet! <a href="staffrulesadmin.php" title="">Zum Staff Rules Admin</a></div>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>	
	<?php endif; ?>
<?php endif; ?>