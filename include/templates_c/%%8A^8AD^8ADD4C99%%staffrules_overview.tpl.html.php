<?php /* Smarty version 2.6.20, created on 2017-05-11 23:35:34
         compiled from staffrules_overview.tpl.html */ ?>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Staff Rules Übersicht
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
              <table id='example1' class='table table-bordered table-striped'>
                <thead>
                <tr>
                  <td>
		<?php $_from = $this->_tpl_vars['categories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['categories_list']):
?>
			<div name="<?php echo $this->_tpl_vars['categories_list']['SHORT']; ?>
" class="rules_ul">
			<?php $_from = $this->_tpl_vars['aq']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aq_list']):
?>
				<?php if ($this->_tpl_vars['categories_list']['ID'] == $this->_tpl_vars['aq_list']['CAT_ID']): ?>
				<div class="x264_title_tablename"><?php echo $this->_tpl_vars['aq_list']['QUESTION']; ?>
</div>
				<?php endif; ?>
			<?php endforeach; endif; unset($_from); ?>
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
		  
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Staff Rules
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>		  
              <table id='example1' class='table table-bordered table-striped'>
                <thead>
                <tr>
                  <td>		  
<?php $_from = $this->_tpl_vars['categories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['categories_list_1']):
?>
	<?php $_from = $this->_tpl_vars['aq']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aq_list_1']):
?>
		<?php if ($this->_tpl_vars['categories_list_1']['ID'] == $this->_tpl_vars['aq_list_1']['CAT_ID']): ?>
			<?php echo $this->_tpl_vars['aq_list_1']['ANSWER']; ?>

		<?php endif; ?>
	<?php endforeach; endif; unset($_from); ?>
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