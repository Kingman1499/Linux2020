﻿<?php
  require("../dbconnect.php");
  //新增房型
  if($_POST["action"]=="insertt")
  { 
    $sql = "insert into roomtype (typename,area,bednum,hasFood,hasNet,hasTV,hasWC,price,totalnum,leftnum) values('".$_POST["typename"]."','".$_POST["area"]."','".$_POST["bednum"]."','".$_POST["hasFood"]."','".$_POST["hasNet"]."','".$_POST["hasTV"]."','".$_POST["hasWC"]."','".$_POST["price"]."','".$_POST["totalnum"]."','".$_POST["totalnum"]."')";
    //echo $sql;
    $arr=mysqli_query($db_link,$sql);
    if ($arr)
    {
      echo "<script language=javascript>alert('添加成功！');window.location='admin_addt.php'</script>";
    }
    else
    {
      echo "<script>alert('添加失败');history.go(-1);</script>";
    }
  }
  
  //新增房间
  if($_POST["action"]=="inserth")
  {
    $sql = "insert into room (roomid,typeid,location,status,remarks) values('".$_POST["roomid"]."','".$_POST["typeid"]."','".$_POST["location"]."','".$_POST["status"]."','".$_POST["remarks"]."')";
    $arr=mysqli_query($db_link,$sql);
    if ($arr)
    {
      echo "<script language=javascript>alert('添加成功！');window.location='admin_addh.php'</script>";
    }
    else
    {
      echo "<script>alert('添加失败');history.go(-1);</script>";
    }
  }
  
  //大堂入住
  if($_POST["action"]=="inserto")
  {
    //在customer表中插入一条记录
    $sql1 = "insert into customer (cardid,cardtype,cname,csex) values('".$_POST["cardid"]."','".$_POST["cardtype"]."','".$_POST["cname"]."','".$_POST["csex"]."')";
    //echo $sql1;
    mysqli_query($db_link,$sql1) or die ("在customer表中插入记录失败：".mysqli_error());
    
    //在order表中插入一条记录
    $sql2 = "insert into orders (roomid,cardid,entertime,leavetime,typeid,linkman,phone,ostatus,oremarks) values('".$_POST["roomid"]."','".$_POST["cardid"]."','".$_POST["entertime"]."','".$_POST["leavetime"]."','".$_POST["typeid"]."','".$_POST["cname"]."','".$_POST["phone"]."','否','是')";
    //echo $sql2;
    mysqli_query($db_link,$sql2) or die ("在orders表中插入记录失败：".mysqli_error());

    //更新roomtype表中leftunm字段
    $sql3 = "update roomtype set leftnum=leftnum-1 where typeid=".$_POST["typeid"];
    //echo $sql3;
    mysqli_query($db_link,$sql3) or die ("更新roomtype表中leftunm字段失败：".mysqli_error());

    //更新room表中status字段
    $sql4 = "update room set status='是' where roomid=".$_POST["roomid"];
    //echo $sql4;
    mysqli_query($db_link,$sql4) or die ("更新room表中status字段失败：".mysqli_error());
  
    echo "<script language=javascript>alert('大堂入住成功');window.location='admin_addn.php'</script>";
  }
?>
