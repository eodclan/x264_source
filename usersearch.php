<?php
// ************************************************************************************//
// * D€ Source 2018
// ************************************************************************************//
// * Author: D@rk-€vil™
// ************************************************************************************//
// * Version: 2.0
// * 
// * Copyright (c) 2017 - 2018 D@rk-€vil™. All rights reserved.
// ************************************************************************************//
// * License Typ: Creative Commons licenses
// ************************************************************************************// 
require_once(dirname(__FILE__) . "/include/engine.php");
dbconn();
loggedinorreturn();
security_tactics();
check_access(UC_MODERATOR);

ini_set ('display_errors', 'On');

  error_reporting (E_ALL);
  // Oder so
  error_reporting(E_ALL & ~ E_NOTICE);


if(isset($_POST['search'])){
$ip = $_POST['ip'];
$name = $_POST['name'];
$mail = $_POST['mail'];
$pk = $_POST['pk'];

	if($ip != ''){
		if(check_ip($ip)){
		$what = 'ip';
		$ip_res = mysql_query("SELECT users.*, users.class AS ucl FROM users WHERE ip = ".sqlesc($ip)." ");
		$ip_resb = mysql_query("SELECT DISTINCT peers.userid AS id, users.username, users.class AS ucl FROM peers LEFT JOIN users ON peers.userid = users.id WHERE peers.ip = ".sqlesc($ip)." ORDER BY peers.ip ");
		}else{$fout = "<span style='color:red;font.weight:bold;'>Die IP scheint nicht korrekt zu sein!</span>";}
	}
	
	if($name != ''){
		$what = 'name';
		$name_res = mysql_query("SELECT users.*, users.class AS ucl FROM users WHERE username = ".sqlesc($name)." ");		
	}
	
	if($mail != ''){
		$what = 'mail';
		$mail_res = mysql_query("SELECT users.*, users.class AS ucl FROM users LEFT JOIN users ON users.id = users.id WHERE email = ".sqlesc($mail)." ");		
	}
	
	if($pk != ''){
		$what = 'pk';
		$pk_res = mysql_query("SELECT users.*, users.class AS ucl FROM users LEFT JOIN users ON users.id = users.id WHERE users.passkey = ".sqlesc(hex2bin($pk))." ");		
	}
	
}

x264_admin_header('Benutzer Suchen');
?>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Benutzer Suchen
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
              <table id='example1' class='table table-bordered table-striped'>
                <thead>
                <tr>
                  <td>
	<div style="margin:50px 0 0 200px;width:570px;">
		
		<div style="margin:0 0 0 9px;"><b>Suchen ... <?=$fout;?></b></div>	
			<form action="<? echo $_SERVER['PHP_SELF']; ?>" method="post">
				<div class="new_class_fields"><label>nach IP:</label><br /><input class="new_class_input" type="text" name="ip" /></div>
				<div class="new_class_fields"><label>nach Benutzername:</label><br /><input class="new_class_input" type="text" name="name" /></div>
				<div class="new_class_fields"><label>nach E-Mail-Adresse:</label><br /><input class="new_class_input" type="text" name="mail" /></div>
				<div class="new_class_fields"><label>nach Passkey:</label><br /><input class="new_class_input" type="text" name="pk" /></div>
				<div>
					<br class="clear" />	
						<input type="submit" onfocus="this.blur()" class="stand_inp_but" name="search" value="jetzt suchen" />
					<br class="clear" />
				</div>
				
			</form>

		<br />

		<?if($what == 'ip'){
			echo '<h2>Benutzer-Suche mit IP (User)</h2><hr /><br />';
			$i=1;
			while($data = mysql_fetch_object($ip_res)){?>
			<a href="userdetails.php?id=<?=$data -> id;?>" class="numbers_but" style="<?=get_class_color($data -> ucl);?>"><?=$data -> username;?></a>	
			<?$i++;}
			if($i==1){echo "<b>Kein Resulat bei den Usern.</b>";}
			echo '<br /><br /><h2>Benutzer-Suche mit IP (Peers)</h2><hr /><br />';
			$i=1;
			while($dataa = mysql_fetch_object($ip_resb)){?>
			<a href="userdetails.php?id=<?=$dataa -> id;?>" class="numbers_but" style="<?=get_class_color($dataa -> ucl);?>"><?=$dataa -> username;?></a>
			<?$i++;}
			if($i==1){echo "<b>Kein Resulat bei den Peers.</b>";}		
		}
		
		if($what == 'name'){
			echo '<h2>Benutzer-Suche mit Namen</h2><hr /><br />';
			$i=1;
			while($data = mysql_fetch_object($name_res)){?>
			<a href="userdetails.php?id=<?=$data -> id;?>" class="numbers_but" style="<?=get_class_color($data -> ucl);?>"><?=$data -> username;?></a>	
			<?$i++;}
			if($i==1){echo "<b>Kein Resulat bei den Usern.</b>";}		
		}
		
		if($what == 'mail'){
			echo '<h2>Benutzer-Suche mit Mail</h2><hr /><br />';
			$i=1;
			while($data = mysql_fetch_object($mail_res)){?>
			<a href="userdetails.php?id=<?=$data -> id;?>" class="numbers_but" style="<?=get_class_color($data -> ucl);?>"><?=$data -> username;?></a>	
			<?$i++;}
			if($i==1){echo "<b>Kein Resulat bei den Usern.</b>";}		
		}
		
		if($what == 'pk'){
			echo '<h2>Benutzer-Suche mit Passkey</h2><hr /><br />';
			$i=1;
			while($data = mysql_fetch_object($pk_res)){?>
			<a href="userdetails.php?id=<?=$data -> id;?>" class="numbers_but" style="<?=get_class_color($data -> ucl);?>"><?=$data -> username;?></a>	
			<?$i++;}
			if($i==1){echo "<b>Kein Resulat bei den Usern.</b>";}		
		}
		?>
		
		</div>
		</div>
                 </td>
				 </tr>
                </tbody>
              </table>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>
	
<?
x264_admin_footer();
?>




