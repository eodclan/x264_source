<?php /* Smarty version 2.6.20, created on 2017-05-08 15:48:55
         compiled from rules_admin_overview.tpl.html */ ?>
	                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i><a href="rulesadmin.php?action=createcategory">Kategorie anlegen</a> | <a href="rulesadmin.php?action=createquestion">Regel anlegen</a>
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>

              <table id='example1' class='table table-bordered table-striped'>
                <thead>
                <tr>
                  <td>

<div class="rules_box" style="width:100%;"> 
	<div class="rules_head"><span class="normalfont">Rules Admin Übersicht</span></div>
	<div class="rules_tableb">
		<?php $_from = $this->_tpl_vars['categories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['categories_list']):
?>
			<?php echo $this->_tpl_vars['categories_list']['NAME']; ?>

			<div name="<?php echo $this->_tpl_vars['categories_list']['SHORT']; ?>
" class="rules_ul">
			<?php $_from = $this->_tpl_vars['aq']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aq_list']):
?>
				<?php if ($this->_tpl_vars['categories_list']['ID'] == $this->_tpl_vars['aq_list']['CAT_ID']): ?>
				<div class="rules_li"><center><a href="#<?php echo $this->_tpl_vars['categories_list']['SHORT']; ?>
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
<?php $_from = $this->_tpl_vars['categories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['categories_list_1']):
?>
<div class="rules_box" style="width:100%;"> 
	<div class="rules_head"><span class="normalfont"><a id="<?php echo $this->_tpl_vars['categories_list_1']['SHORT']; ?>
" name="<?php echo $this->_tpl_vars['categories_list_1']['SHORT']; ?>
"></a><?php echo $this->_tpl_vars['categories_list_1']['NAME']; ?>
 <a href="rulesadmin.php?action=editcategory&cid=<?php echo $this->_tpl_vars['categories_list_1']['ID']; ?>
"><img src="<?php echo $this->_tpl_vars['PIC_URL']; ?>
edit.png" border="0" alt="" /></a><a href="rulesadmin.php?action=deletecategory&cid=<?php echo $this->_tpl_vars['categories_list_1']['ID']; ?>
"><img src="<?php echo $this->_tpl_vars['PIC_URL']; ?>
editdelete.png" border="0" alt="" /></a></span></div>
	<div class="rules_tableb">
	<?php $_from = $this->_tpl_vars['aq']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aq_list_1']):
?>
		<?php if ($this->_tpl_vars['categories_list_1']['ID'] == $this->_tpl_vars['aq_list_1']['CAT_ID']): ?>
		<div class="rules_question_box"> 
			<div class="rules_tableb"><span class="normalfont"><a id="<?php echo $this->_tpl_vars['categories_list_1']['SHORT']; ?>
<?php echo $this->_tpl_vars['aq_list_1']['ID']; ?>
" name="<?php echo $this->_tpl_vars['categories_list_1']['SHORT']; ?>
<?php echo $this->_tpl_vars['aq_list_1']['ID']; ?>
"></a><?php echo $this->_tpl_vars['aq_list_1']['QUESTION']; ?>
<a href="rulesadmin.php?action=editquestion&qid=<?php echo $this->_tpl_vars['aq_list_1']['ID']; ?>
"><img src="<?php echo $this->_tpl_vars['PIC_URL']; ?>
edit.png" border="0" alt="" /></a><a href="rulesadmin.php?action=deletequestion&qid=<?php echo $this->_tpl_vars['aq_list_1']['ID']; ?>
"><img src="<?php echo $this->_tpl_vars['PIC_URL']; ?>
editdelete.png" border="0" alt="" /></a></span></div>
			<div class="rules_tablea"><?php echo $this->_tpl_vars['aq_list_1']['ANSWER']; ?>
</div>
		</div>
		<?php endif; ?>
	<?php endforeach; endif; unset($_from); ?>
	</div>
</div>

<?php endforeach; endif; unset($_from); ?> 
                 </td>
				 </tr>
                </tbody>
              </table>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>