<?php
require_once(dirname(__FILE__)."/include/bittorrent.php");
require_once(dirname(__FILE__)."/include/dagent.class.php");

dbconn();
loggedinorreturn();
check_access(UC_SYSOP);
security_tactics();

if (isset($_GET["sort"])){
$sorty = $_GET["sort"]+0;
switch($sorty){
	case "1":	$sort = 'agent_name'; $art = 'ASC'; break;
	case "2":	$sort = 'hits'; $art = 'DESC'; break;
	case "3":	$sort = 'ins_date'; $art = 'DESC'; break;
	case "4":	$sort = 'aktiv'; $art = 'DESC'; break;
	
	case "5":	$sort = 'agent_name'; $art = 'DESC'; break;
	case "6":	$sort = 'hits'; $art = 'ASC'; break;
	case "7":	$sort = 'ins_date'; $art = 'ASC'; break;
	case "8":	$sort = 'aktiv'; $art = 'ASC'; break;

	default:	$sort = 'ins_date';
	}
}else{$sort = 'ins_date';}

if (isset($_GET["agent"])){
$agent_id = $_GET["agent"]+0;
$aktiv = $_GET["aktiv"]+0;
$sql = "UPDATE agents SET aktiv=$aktiv WHERE agent_id=$agent_id";
	if(mysql_query($sql)){
	header('Location: cp_agents.php?edit='.$agent_id.'&sort='.$sorty.'#go_'.$agent_id);
	}    
}

$query = "SELECT * FROM agents ORDER BY $sort $art";
$result = mysql_query($query);
// agent_id 	agent_name 	hits 	ins_date 	aktiv

x264_bootstrap_header("Clienten verwalten");
print "
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Clienten verwalten
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
              <table id='example1' class='table table-bordered table-striped'>
                <thead>
                <tr>";
?>
                  <th>Bitte achte darauf, dass du keinen Cheater Client einschaltest.</th>
                </tr>
                </thead>
				<tbody>
                <tr>
				 <td>
<?
while($data = mysql_fetch_object($result)){
if(isset($_GET['edit']) AND $_GET['edit'] == $data -> agent_id){$bg = "green";
}
?>
				<div class='x264_title_div' style='padding-left:53px;'>
					<div class='x264_title_sitelog_tab'>
						<div class="clients_a"><a name="go_<?=$data -> agent_id;?>"><?=$data -> agent_name;?></a></div>
						<div class="clients_b"><?=$data -> hits;?></div>
						<div class="clients_c"><?=date("d.m.Y - H:i", $data -> ins_date);?> Uhr</div>	
						<div class="clients_d">
							<?if($data -> aktiv == '1'){?>
							<div class="clients_green"></div><a href="cp_agents.php?agent=<?=$data -> agent_id;?>&amp;aktiv=0&amp;sort=<?=$sorty;?>" style="color:red;font-weight:bold;">ändern</a>
							<?}else{?>
							<div class="clients_red"></div><a href="cp_agents.php?agent=<?=$data -> agent_id;?>&amp;aktiv=1&amp;sort=<?=$sorty;?>" style="color:green;font-weight:bold;">ändern</a>
							<?}?>
						</div>
					</div>
				</div>
<?}?>
                 </td>
				 </tr>
                </tbody>
              </table>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>
	
<?x264_bootstrap_footer();?>