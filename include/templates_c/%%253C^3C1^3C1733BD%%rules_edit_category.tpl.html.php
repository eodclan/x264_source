<?php /* Smarty version 2.6.20, created on 2017-05-08 15:48:59
         compiled from rules_edit_category.tpl.html */ ?>
	                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Kategorie bearbeiten
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>

              <table id='example1' class='table table-bordered table-striped'>
                <thead>
                <tr>
                  <td>
<?php if ($this->_tpl_vars['EDIT_CATEGORY'] == 1): ?>
<div class="tableinborder" style="width:750px;">
	<form method="post" name="editCategory" action="rulesadmin.php?action=doeditcategory">
		<div class="tableb">Name</div><div class="tablea"><input type="text" name="name" value="<?php echo $this->_tpl_vars['category']['NAME']; ?>
" /></div>
		<div class="tableb">Kuerzel</div><div class="tablea"><input type="text" name="short" value="<?php echo $this->_tpl_vars['category']['SHORT']; ?>
" /></div>
		<div class="tableb"><input type="hidden" name="cid" value="<?php echo $this->_tpl_vars['category']['ID']; ?>
" /><input type="submit" name="submit" value="Abschicken" /></div>
	</form>
</div>
<?php endif; ?>
<?php if ($this->_tpl_vars['EDIT_CATEGORY_DO'] == 1): ?>
	<?php if ($this->_tpl_vars['EMPTY'] == 1): ?>
	<div class="tableinborder" style="width:750px;">
		<div class="tabletitle"><span class="normalfont">Kategorie bearbeiten</span></div>
		<div class="tableb">Du musst alle Felder ausfuellen! <a href="rulesadmin.php?action=editcategory&cid=<?php echo $this->_tpl_vars['CID']; ?>
" title="">Zum Formular</a></div>
	</div>	
	<?php endif; ?>
	<?php if ($this->_tpl_vars['SUCCESS'] == 1): ?>
	<div class="tableinborder" style="width:750px;">
		<div class="tabletitle"><span class="normalfont">Kategorie bearbeiten</span></div>
		<div class="tableb">Die Kategorie wurde erfolgreich bearbeitet! <a href="rulesadmin.php" title="">Zum Rules Admin</a></div>
	</div>	
	<?php endif; ?>
<?php endif; ?>
                 </td>
				 </tr>
                </tbody>
              </table>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>