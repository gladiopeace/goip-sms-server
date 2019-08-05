<?php

define("OK", true);
require_once("session.php");
if($_SESSION['goip_permissions'] > 1 && $_SESSION['goip_permissions'] < 4)
        die("Permission denied!");
require_once("global.php");
//!defined('OK') && exit('ForbIdden');

if(isset($_REQUEST['action'])) {
	//if($_GET['action'] != "modifyself" && $_GET['action'] != "savemodifyself" && $_SESSION['goip_adminname']!="admin" )
		//WriteErrMsg("<br><li>需要admin权限!</li>");
	$action=$_REQUEST['action'];

	function get_id()
	{
		$num=$_REQUEST['boxs'];
		for($i=0;$i<$num;$i++)
		{
			if(!empty($_REQUEST["Id$i"])){
				if($id=="")
					$id=$_REQUEST["Id$i"];
				else
					$id=$_REQUEST["Id$i"].",$id";
			}
		}
		if($_REQUEST['rstr']) {
			if($id=="")
				$id=$_REQUEST['rstr'];
			else
				$id=$_REQUEST['rstr'].",$id";

		}
		return $id;
	}

        if($action=="del") 
        {
		if(operator_owner_forbid()) WriteErrMsg('<br><li>forbidden</li>');
		if($_REQUEST['chkAll0']) {
			$db->query("DELETE FROM goip WHERE 1");
			sendto_cron();
			WriteSuccessMsg("<br><li>Delete success</li>","goip.php");
		}
		$ErrMsg="";
		$Id=$_GET['id'];
		//if(($Id=$_GET['id']) == "1")
		//$ErrMsg="<br><li>超級用戶不能刪除</li>";

		if(empty($Id)){
			$Id=get_id();
		}
		//WriteErrMsg($num."$Id");

		if(empty($Id))
			$ErrMsg ='<br><li>Please choose one</li>';
		if($ErrMsg!="")
			WriteErrMsg($ErrMsg);
		else{
			$query=$db->query("DELETE FROM goip WHERE id IN ($Id)");
			$db->query("DELETE FROM record WHERE goipid IN ($Id)");
			sendto_cron();
			WriteSuccessMsg("<br><li>Delete success</li>","goip.php");

		}
		//$id=$_GET['id'];
		//$query=$db->query("Delete  from ".$tablepre."admin WHERE Id=$id");
	}
	elseif($action=="set_prov")
	{
		if(operator_owner_forbid()) WriteErrMsg('<br><li>forbidden</li>');
		if($_REQUEST['chkAll0']) {
			$db->query("update goip set provider='$_REQUEST[provider]' WHERE 1");
			sendto_cron();
			WriteSuccessMsg("<br><li>save success</li>","goip.php");
		}
		$ErrMsg="";
		$Id=$_GET['id'];
		//if(($Id=$_GET['id']) == "1")
		//$ErrMsg="<br><li>超級用戶不能刪除</li>";

		if(empty($Id)){
			$Id=get_id();
		}
		//WriteErrMsg($num."$Id");

		if(empty($Id))
			$ErrMsg ='<br><li>Please choose one</li>';
		if($ErrMsg!="")
			WriteErrMsg($ErrMsg);
		else{
			$db->query("update goip set provider='$_REQUEST[provider]' WHERE id in ($Id)");
			//$query=$db->query("DELETE FROM goip WHERE id IN ($Id)");
			//$db->query("DELETE FROM record WHERE goipid IN ($Id)");
			sendto_cron();
			WriteSuccessMsg("<br><li>save success</li>","goip.php");

		}
	
	}
        elseif($action=="set_group")
        {       
                if(operator_forbid()) WriteErrMsg('<br><li>forbidden</li>');
                if($_REQUEST['chkAll0']) {
                        $db->query("update goip set group_id='$_REQUEST[group_id]' WHERE 1");
                        sendto_cron();
                        WriteSuccessMsg("<br><li>save success</li>","goip.php");
                }       
                $ErrMsg="";
                $Id=$_GET['id'];
                
                if(empty($Id)){
                        $Id=get_id();
                }
                
                if(empty($Id))
                        $ErrMsg ='<br><li>Please choose one</li>';
                if($ErrMsg!="")
                        WriteErrMsg($ErrMsg);
                else{   
                        $db->query("update goip set group_id='$_REQUEST[group_id]' WHERE id in ($Id)");
                        sendto_cron();
                        WriteSuccessMsg("<br><li>save success</li>","goip.php");
                }       
                        
        }    
	elseif($action=="reset_remain_count"){
		if(operator_forbid()) WriteErrMsg('<br><li>forbidden</li>');
		if($_REQUEST['chkAll0']) {
			$db->query("update goip set remain_count=count_limit WHERE 1");
			//sendto_cron();
			WriteSuccessMsg("<br><li>重置剩余短信次数成功</li>","goip.php");
		}
		$ErrMsg="";
		$Id=$_GET['id'];

		if(empty($Id)){
			$Id=get_id();
		}

		if(empty($Id))
			$ErrMsg ='<br><li>Please choose one</li>';
		if($ErrMsg!="")
			WriteErrMsg($ErrMsg);
		else{
			$db->query("update goip set remain_count=count_limit WHERE id in ($Id)");
			WriteSuccessMsg("<br><li>重置剩余短信次数成功</li>","goip.php");
		}

	}
	elseif($action=="reset_remain_count_d"){
		if(operator_forbid()) WriteErrMsg('<br><li>forbidden</li>');
		if($_REQUEST['chkAll0']) {
			$db->query("update goip set remain_count_d=count_limit_d WHERE 1");
			WriteSuccessMsg("<br><li>重置单天剩余短信次数成功</li>","goip.php");
		}
		$ErrMsg="";
		$Id=$_GET['id'];

		if(empty($Id)){
			$Id=get_id();
		}

		if(empty($Id))
			$ErrMsg ='<br><li>Please choose one</li>';
		if($ErrMsg!="")
			WriteErrMsg($ErrMsg);
		else{
			$db->query("update goip set remain_count_d=count_limit_d WHERE id in ($Id)");
			WriteSuccessMsg("<br><li>重置单天剩余短信次数成功</li>","goip.php");
		}

	}
        elseif($action=="sms_fwd_mail"){
                if(operator_forbid()) WriteErrMsg('<br><li>forbidden</li>');
                $report_mail=$_POST['report_mail'];
                if($_POST['fwd_mail_enable']=='on') $fwd_mail_enable=1;
                else $fwd_mail_enable=0;
                if($_REQUEST['chkAll0']) {
                        $db->query("update goip set fwd_mail_enable=$fwd_mail_enable WHERE 1");
                        WriteSuccessMsg("<br><li>Set SMS Forward to Mail success</li>","goip.php");
                }       
                $ErrMsg="";
                $Id=$_GET['id'];
                        
                if(empty($Id)){
                        $Id=get_id();
                }       
                
                if(empty($Id))
                        $ErrMsg ='<br><li>Please choose one</li>';
                if($ErrMsg!="") 
                        WriteErrMsg($ErrMsg);
                else{
                        $db->query("update goip set fwd_mail_enable=$fwd_mail_enable WHERE id in ($Id)");
                        WriteSuccessMsg("<br><li>SMS Forward to Mail success</li>","goip.php");
                }

        }
        elseif($action=="fwd_http_enable"){
                if(operator_forbid()) WriteErrMsg('<br><li>forbidden</li>');
                if($_POST['fwd_http_enable']=='on') $fwd_http_enable=1;
                else $fwd_http_enable=0;
                if($_REQUEST['chkAll0']) {
                        $db->query("update goip set fwd_http_enable=$fwd_http_enable WHERE 1");
                        WriteSuccessMsg("<br><li>Set SMS Forward to http success</li>","goip.php");
                }
                $ErrMsg="";
                $Id=$_GET['id'];

                if(empty($Id)){
                        $Id=get_id();
                }

                if(empty($Id))
                        $ErrMsg ='<br><li>Please choose one</li>';
                if($ErrMsg!="")
                        WriteErrMsg($ErrMsg);
                else{
                        $db->query("update goip set fwd_http_enable=$fwd_http_enable WHERE id in ($Id)");
                        WriteSuccessMsg("<br><li>SMS Forward to http success</li>","goip.php");
                }

        }
        elseif($action=="mail_addr"){
                if(operator_forbid()) WriteErrMsg('<br><li>forbidden</li>');
                $report_mail=$_POST['report_mail'];
                if($_POST['fwd_mail_enable']=='on') $fwd_mail_enable=1;
                else $fwd_mail_enable=0;
                if($_REQUEST['chkAll0']) {
                        $db->query("update goip set report_mail='$report_mail' WHERE 1");
                        WriteSuccessMsg("<br><li>Set mail addr success</li>","goip.php");
                }
                $ErrMsg="";
                $Id=$_GET['id'];

                if(empty($Id)){
                        $Id=get_id();
                }

                if(empty($Id))
                        $ErrMsg ='<br><li>Please choose one</li>';
                if($ErrMsg!="")
                        WriteErrMsg($ErrMsg);
                else{
                        $db->query("update goip set report_mail='$report_mail' WHERE id in ($Id)");
                        WriteSuccessMsg("<br><li>Set mail addr success</li>","goip.php");
                }

        }
        elseif($action=="http_addr"){
                if(operator_forbid()) WriteErrMsg('<br><li>forbidden</li>');
                $report_http=$_POST['report_http'];
                if($_REQUEST['chkAll0']) {
                        $db->query("update goip set report_http='$report_http' WHERE 1");
                        WriteSuccessMsg("<br><li>Set http addr success</li>","goip.php");
                }       
                $ErrMsg="";
                $Id=$_GET['id'];
                
                if(empty($Id)){
                        $Id=get_id();
                }
                
                if(empty($Id))
                        $ErrMsg ='<br><li>Please choose one</li>';
                if($ErrMsg!="") 
                        WriteErrMsg($ErrMsg);
                else{   
                        $db->query("update goip set report_http='$report_http' WHERE id in ($Id)");
                        WriteSuccessMsg("<br><li>Set mail addr success</li>","goip.php");
                }
        }
	elseif($action=="add")
	{
		if(operator_owner_forbid()) WriteErrMsg('<br><li>forbidden</li>');
		$query=$db->query("select id,prov from prov ");
		while($row=$db->fetch_array($query)) {
			$prsdb[]=$row;
		}
		$query=$db->query("select * from goip_group ");
		while($row=$db->fetch_array($query)) {
			$ggrsdb[]=$row;
		}
	}
	elseif($action=="modify")
	{
		if(operator_owner_forbid()) WriteErrMsg('<br><li>forbidden</li>');
		$id=$_GET['id'];
		$query=$db->query("select id,prov from prov ");
		while($row=$db->fetch_array($query)) {
			$prsdb[]=$row;
		}
                $query=$db->query("select * from goip_group ");
                while($row=$db->fetch_array($query)) {
                        $ggrsdb[]=$row;
                }
		$rs=$db->fetch_array($db->query("SELECT * FROM goip where id=$id"));
		if($rs['remain_count']==-1) $rs['remain_count']="";
		if($rs['count_limit']==-1) $rs['count_limit']="";
		if($rs['remain_count_d']==-1) $rs['remain_count_d']="";
		if($rs['count_limit_d']==-1) $rs['count_limit_d']="";
                if($rs['fwd_mail_enable']) $fwd_mail_checked="checked";
                else $fwd_mail_display="none";
                if($rs['fwd_http_enable']) $fwd_http_checked="checked";
                else $fwd_http_display="none";
	}
	elseif($action=="saveadd")
	{
		if(operator_owner_forbid()) WriteErrMsg('<br><li>forbidden</li>');
		//WriteErrMsg("'$_POST['name']'");
		$name=$_POST['name'];
		$password=$_POST['Password'];
		$provider=$_POST['provider'];
                $group_id=$_POST['goip_group'];
                $report_mail=$_POST['report_mail'];
                if($_POST['fwd_mail_enable']=='on') $fwd_mail_enable=1;
                else $fwd_mail_enable=0;
                $report_http=$_POST['report_http'];
                if($_POST['fwd_http_enable']=='on') $fwd_http_enable=1;
                else $fwd_http_enable=0;
		//$info=$_POST['info'];
		$ErrMsg="";
		if(empty($name))
			$ErrMsg ='<br><li>请输入名称</li>';
		if(empty($password))
			$ErrMsg ='<br><li>请输入密码</li>';
		$no_t=$db->fetch_array($db->query("select id from goip where name='".$name."'"));
		if($no_t[0])
			$ErrMsg	.='<br><li>已存在ID: '.$name.'</li>';
		if($ErrMsg!="")
			WriteErrMsg($ErrMsg);
		else{
			$count_limit=$_REQUEST['count_limit'];
			if($_REQUEST['count_limit']==="") $count_limit=-1;
			if($count_limit<-1 || $count_limit>99999999) $count_limit=-1;
			$count_limit_d=$_REQUEST['count_limit_d'];
			if($_REQUEST['count_limit_d']==="") $count_limit_d=-1;
			if($count_limit_d<-1 || $count_limit_d>99999999) $count_limit_d=-1;

			if($_REQUEST['line']>99 || $_REQUEST['line']<1) $_REQUEST['line']=1;
			if($_REQUEST['line']!=1){
				for($i=$_REQUEST['line'];$i>0;$i--){
					$db->query("INSERT INTO goip (name,password,provider,count_limit,count_limit_d,remain_count,remain_count_d,group_id,report_mail,fwd_mail_enable,report_http,fwd_http_enable) VALUES ('$name".sprintf("%02d",$i)."','$password','$provider','$count_limit','$count_limit_d','$count_limit','$count_limit_d', '$group_id','$report_mail','$fwd_mail_enable','$report_http','$fwd_http_enable')");
				}
			}
			else
				$db->query("INSERT INTO goip (name,password,provider,count_limit,count_limit_d,remain_count,remain_count_d,group_id,report_mail,fwd_mail_enable,report_http,fwd_http_enable) VALUES ('$name','$password','$provider','$count_limit','$count_limit_d', '$count_limit','$count_limit_d','$group_id','$report_mail','$fwd_mail_enable','$report_http','$fwd_http_enable')");
			sendto_cron(); 
			WriteSuccessMsg("<br><li>添加goip设备成功</li>","goip.php");				
		}
	}
	elseif($action=="savemodify")
	{
		if(operator_owner_forbid()) WriteErrMsg('<br><li>forbidden</li>');
		$password=$_POST['Password'];
		$Id=$_POST['Id'];
		$name=$_POST['name'];
		$group_id=$_POST['goip_group'];
		$report_mail=$_POST['report_mail'];
		if($_POST['fwd_mail_enable']=='on') $fwd_mail_enable=1;
		else $fwd_mail_enable=0;
                $report_http=$_POST['report_http'];
                if($_POST['fwd_http_enable']=='on') $fwd_http_enable=1;
                else $fwd_http_enable=0;
		$ErrMsg="";
		/*
		   if(empty($password))
		   $ErrMsg ='<br><li>Your password should not be empty</li>';
		 */
		$no_t=$db->fetch_array($db->query("select id from goip where name='".$name."' and id != $Id" ));
		if($no_t[0])
			$ErrMsg	.='<br><li>已存在ID: '.$name.'</li>';					
		if($ErrMsg!="")
			WriteErrMsg($ErrMsg);
		else{
			$count_limit=$_REQUEST['count_limit'];
			if($_REQUEST['count_limit']==="") $count_limit=-1;
			if($count_limit<-1 || $count_limit>99999999) $count_limit=-1;
			$count_limit_d=$_REQUEST['count_limit_d'];
			if($_REQUEST['count_limit_d']==="") $count_limit_d=-1;
			if($count_limit_d<-1 || $count_limit_d>99999999) $count_limit_d=-1;
			$remain_count=$_REQUEST['remain_count'];
			if($remain_count==="") $remain_count=-1;
			if($remain_count<-1 || $remain_count>99999999) $remain_count=-1;
			$remain_count_d=$_REQUEST['remain_count_d'];
			if($remain_count_d==="") $remain_count_d=-1;
			if($remain_count_d<-1 || $remain_count_d>99999999) $remain_count_d=-1;
			if($password)
				$pas=",password='$password'";
			$query=$db->query("UPDATE goip SET remain_count=if(count_limit='$count_limit','$remain_count',$count_limit),count_limit='$count_limit', remain_count_d=if(count_limit_d='$count_limit_d','$remain_count_d',$count_limit_d),count_limit_d='$count_limit_d',name='$name',provider='".$_POST['provider']."',group_id='$group_id',report_mail='$report_mail',fwd_mail_enable='$fwd_mail_enable',report_http='$report_http',fwd_http_enable='$fwd_http_enable'".$pas."  WHERE id='$Id'");
			sendto_cron(); 
			WriteSuccessMsg("<br><li>Modify administrator success</li>","goip.php");
		}
	}
	elseif($action=="search"){
	}
/*
		$key=$_POST['key'];
		$type=$_POST['type'];
		switch($type){
			case 1:
				$query=$db->query("SELECT goip.*,prov.prov, prov.id as provid FROM goip,prov where goip.provider=prov.id and goip.name like '%$key%' ORDER BY goip.id DESC");
				$typename="ID";
				break;
			default:
				$typename="无效项";
		}
		$searchcount=0;
		while($row=$db->fetch_array($query)) {
			if($row['alive'] == 1){
				$row['alive']="已注册";
			}
			elseif($row['alive'] == 0){
				$row['alive']="未注册";
				$row['sendsms']="onClick=\"alert('GoIP logout!');return false;\"";
			}
			$searchcount++;
			$rsdb[]=$row;
		}
		//$action="searchmain";
                $maininfo="搜索项：$typename, 查询关键字：$key, 结果共{$searchcount}项.";
	}
*/
	else $action="main";
	
}
else $action="main";

if($action=="main"  || $action=="search")
{
        $where=" where 1 ";
        if($_REQUEST['action']=="search"){
                $column=myaddslashes($_REQUEST['column']);
                $s_key=myaddslashes($_REQUEST['s_key']);
                $type=myaddslashes($_REQUEST['type']);
                $where.="and `$column`";
                $t_selected[$type]="selected";
                $c_selected[$column]="selected";
                if($type=="equal"){
                        $where.="='$s_key'";
                        //$t_selected['equal']="selected";
                }
                else if($type=="unequal"){
                        $where.="!='$s_key'";
                        //$t_selected['unequal']="selected";
                }
                else if($type=="prefix"){
                        $where.=" like '$s_key%'";
                        //$t_selected['prefix']="selected";
                }
                else if($type=="postfix"){
                        $where.=" like '%$s_key'";
                        //$t_selected['postfix']="selected";
                }
                else if($type=="contain"){
                        $where.=" like '%$s_key%'";
                        //$t_selected['postfix']="selected";
                }
                else if($type=="less"){
                        $where.=" <= '$s_key'";
                }
                else if($type=="more"){
                        $where.=" >= '$s_key'";
                }
                $maininfo="当前位置: 搜索GoIP";
        }
        else {
                $t_selected['contain']="selected";
                $c_selected['name']="selected";
                $maininfo="当前位置: GoIP列表";
        }
$select="搜索项目<select name=\"column\"  style=\"width:80px\" >";
$select.="\t<option value='name' $c_selected[name]>ID</option>\n";
$select.="\t<option value='gsm_status' $c_selected[gsm_status]>GSM状态</option>\n";
$select.="\t<option value='voip_state' $c_selected[voip_state]>Voip状态</option>\n";
$select.="\t<option value='remain_time' $c_selected[remain_time]>剩余时间</option>\n";
$select.="\t<option value='signal' $c_selected[signal]>GSM信号</option>\n";
$select.="\t<option value='num' $c_selected[num]>SIM卡号码</option>\n";
$select.="\t<option value='prov' $c_selected[prov]>服务商</option>\n";
$select.="\t<option value='group_name' $c_selected[group_name]>组</option>\n";
$select.="\t<option value='host' $c_selected[host]>IP地址</option>\n";
$select.="</select>\n";
$select.="搜索类型<select name=\"type\"  style=\"width:80px\" >";
$select.="\t<option value='equal' $t_selected[equal]>相等</option>\n";
$select.="\t<option value='contain' $t_selected[contain]>包含</option>\n";
$select.="\t<option value='unequal' $t_selected[unequal]>不等</option>\n";
$select.="\t<option value='prefix' $t_selected[prefix]>前缀</option>\n";
$select.="\t<option value='postfix' $t_selected[postfix]>后缀</option>\n";
$select.="\t<option value='less' $t_selected[less]>小于</option>\n";
$select.="\t<option value='more' $t_selected[more]>大于</option>\n";
$select.="</select>\n";
$select.="关键字<input type=\"text\" name=\"s_key\" value=\"$_REQUEST[s_key]\" size=16>&nbsp;\n";
$select.="<input type=\"submit\" value=\"搜索\">\n";

        if(!$_REQUEST['order']){
                $_REQUEST['order']="desc";
        }
        if($_REQUEST['order']=="desc") $order2='asc';
        else $order2='desc';
        if(!$_REQUEST['order_key']){
                $_REQUEST['order_key']="id";
        }

        $orderby=" order by `$_REQUEST[order_key]` $_REQUEST[order] ";
        $query=$db->query("SELECT count(*) AS count FROM goip left join prov on goip.provider=prov.id left join goip_group on goip.group_id=goip_group.id $where");
        $row=$db->fetch_array($query);
        $count=$row['count'];
        $numofpage=ceil($count/$perpage);
        $totlepage=$numofpage;
        if(isset($_GET['page'])) {
                $page=$_GET['page'];
        } else {
                $page=1;
        }
        if($numofpage && $page>$numofpage) {
                $page=$numofpage;
        }
        if($page > 1) {
                $start_limit=($page - 1)*$perpage;
        } else{
                $start_limit=0;
                $page=1;
        }
        //$fenye=showpage("?",$page,$count,$perpage,true,true,"rows");
        $fenye=showpage2("?action=$action&column=$column&type=$type&s_key=$s_key&order_key=$_REQUEST[order_key]&order=$_REQUEST[order]&",$page,$count,$perpage,true,true,"编","myform","boxs");
        $query=$db->query("SELECT goip.*,prov.prov,prov.id as provid,group_name FROM goip left join prov on goip.provider=prov.id left join goip_group on goip.group_id=goip_group.id $where $orderby LIMIT $start_limit,$perpage");
        //echo ("SELECT goip.*,prov.prov,prov.id as provid FROM goip left join prov on goip.provider=prov.id $where ORDER BY goip.id DESC LIMIT $start_limit,$perpage");
        while($row=$db->fetch_array($query)) {
                if($row['alive'] == 1)
                        $row['alive']="已注册";
                elseif($row['alive'] == 0){
                        $row['sendsms']="onClick=\"alert('GoIP logout!');return false;\"";
                        $row['alive']="未注册";
                }
		if($row['remain_time']==-1) $row['remain_time']="";
		if($row['bal']==-1) $row['bal']="";
		if($row['remain_time']==-1) $row['remain_time']="";
		if($row['bal']==-1) $row['bal']="";
		if($row['remain_count']==-1) $row['remain_count']="";
		if($row['count_limit']==-1) $row['count_limit']="";
		if($row['remain_count']=="") $row['remain_count']="";
		else $row['remain_count']="<a href='?action=reset_remain_count&id=".$row['id']."' onClick=\"return confirm('sure to reset remain count?')\">".$row['remain_count']."/".$row['count_limit']."(T)</a>";
		if($row['remain_count_d']==-1) $row['remain_count_d']="";
		if($row['count_limit_d']==-1) $row['count_limit_d']="";
		if($row['remain_count_d']=="") $row['remain_count_d']="";
		else $row['remain_count_d']="<a href='?action=reset_remain_count_d&id=".$row['id']."' onClick=\"return confirm('sure to reset remain count of this day?')\">".$row['remain_count_d']."/".$row['count_limit_d']."(D)";
		if($row['remain_count'] && $row['remain_count_d']) $row['remain_count'].="\n";
		$row['remain_count']=$row['remain_count'].$row['remain_count_d'];
	
                $row['mail']="N";
                if($row['fwd_mail_enable']==1) {
                        $row['mail']="Y";
                        $row['mail_title']="Mail to:";
                        if($row['report_mail']) $row['mail_title'].=$row['report_mail'];
                        else $row['mail_title'].=$report_mail."(Default)";
                }
		if($row['fwd_http_enable']==1) {
                        $row['mail']="Y";
                        if($row['mail_title']) $row['mail_title'].="\nPost to: ".$row['report_http'];
                        else $row['mail_title']="Post to: ".$row['report_http'];
                }

		$rsdb[]=$row;
                $strs[]=$row['id'];
        }
        $gsm_logout_time=time()-60*4;
        if(isset($_POST['rstr'])){

                $nrcount=0;
                unset($strs0);
                $strs0=array();
                if($_POST['rstr']) $strs0=explode(",",$_POST['rstr']);

                $num=$_POST['boxs'];
                for($i=0;$i<$num;$i++)
                {
                        if(!empty($_POST["Id$i"])){
                                $strs0[]=$_POST["Id$i"];
                        }
                }

        }else {
                $nrcount=0;
                $rsdblen=count($rsdb);
        }
        foreach($strs0 as $v){
                $nrcount++;
                if(in_array($v,$strs)) continue;
                //$nrcount++;
                $str.=$v.",";

        }
        //print_r();
        $str=substr($str,0,strlen($str)-1);

	$query=$db->query("select id,prov from prov ");
	while($row=$db->fetch_array($query)) {
		$prsdb[]=$row;
	}
        $query=$db->query("select * from goip_group ");
        while($row=$db->fetch_array($query)) {
                $grsdb[]=$row;
        }
}
	require_once ('goip.htm');

?>
