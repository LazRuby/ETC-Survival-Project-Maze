<!DOCTYPE html><html>

<head>
	<title>Maze World !!</title>
	<meta charset="UTF-8">
	<script src="..\ETC\Jquery.js"></script>
	<link rel= "stylesheet" type="text/css" href="Maze CSS2.css?ver=1">
	<link rel= "stylesheet" type="text/css" href="Maze CSS.css?ver=3">
	<link rel="shortcut icon" href="..\ETC\Icon.ico">
	<script>//if(sessionStorage.getItem("LoginID")==null) {location.href="http://www.lazruby.com";}</script>
</head>

<body onmousedown="javascript:mousestat=1;" onmouseup="javascript:mousestat=0;" oncontextmenu="return false">

	<?php		
	
        $cnt = mysql_connect("localhost", "lazruby", "!wn22131967")
            or die ("서버 접속 실패.");
        mysql_select_db("lazruby", $cnt);
       
        $idcheck1 = $_POST["inputid"];
        $query = "Select count(*) as Count from lazruby.maze where MazeId = '$idcheck1'";
        $idcheck2 = mysql_query($query, $cnt);
        $idcheck3 = mysql_fetch_array($idcheck2);
        
        $loadid = $_POST["inputid"];
        $query = "Select * from lazruby.maze where MazeId = '$loadid';";
        $result = mysql_query($query, $cnt);
        $array = mysql_fetch_array($result);
              
        if(($idcheck3[Count]>=1)&&(strlen($_POST["savecodeslot"])>30))
        {echo "<script>alert('이미 존재하는 아이디입니다!!'); location.href='http://www.lazruby.com/Html,%20PHP/Maze/MazeMaking.html';</script>";}
        else if(strlen($_POST["savecodeslot"])>30)
        {
           $query = "Select max(MazeNum) as Count from lazruby.maze";
           $result = mysql_query($query, $cnt);
           $rownum = mysql_fetch_array($result);
            
           $savedatatemp = Array();
           $savedatatemp[0] = $rownum[Count] + 2;
           $savedatatemp[1] = $_POST["inputid"];
           $savedatatemp[2] = $_POST["inputpass"];
           $savedatatemp[3] = $_POST["explanation"];
           $savedatatemp[4] = $_POST["savecodeslot"];
           $savedatatemp[5] = $_POST["timelimit"];
           $savedatatemp[6] = $_POST["openswitch"];
           
           if($_POST["timelimit"]==null){$savedatatemp[5]=600;}
           
          $query="Insert into lazruby.maze(MazeNum,MazeId,MazePass,MazeExplanation,MazeData,MazeTime,MazeOpenSwitch) values('$savedatatemp[0]', '$savedatatemp[1]', '$savedatatemp[2]', '$savedatatemp[3]', '$savedatatemp[4]', '$savedatatemp[5]', '$savedatatemp[6]')";
          mysql_query($query, $cnt);
          
          echo "<script> var dbcodeload='$savedatatemp[4]';</script>";
        }
        else if($array[MazePass]==$_POST["inputpass"])
        {   
           $MazeNum = $array[MazeNum];
           $MazeExplanation = $array[MazeExplanation];
           $MazeId = $array[MazeId];
           $MazePass = $array[MazePass];
           $MazedData = $array[MazeData];
           $MazedTime = $array[MazedTime];
           $MazedOpenSwitch = $array[MazedOpenSwitch];
           
           echo "<script>  var dbcodeload='$MazedData';</script>";
        }
        else {echo "<script>alert('아이디 또는 비밀번호가 틀렸습니다!!'); location.href='http://www.lazruby.com/Html,%20PHP/Maze/MazeMaking.html';</script>";}
   
       mysql_close($cnt);
    ?>
    


	<div id="Area"></div>
	<form name="pform">
	<div class="palette" id="palettea" onmouseover="javascript:mousestat2=0" onmouseout="javascript:mousestat2=1">
		<br><b>: 기본 요소 :</b><br><br>
			<input type="button" value="◀이전 페이지" onclick="pagemove('d');" style="float:left;"> &nbsp;&nbsp;<a href="Maze.php"><input type="button" value="메인으로" size="8"></a>&nbsp;&nbsp; <input type="button" value="다음 페이지▶" onclick="pagemove('b');" style="float:right"><br><br>
			
			<input type="radio" name="paletteoption" id="pidload" value="pload" checked> ← <font color="white">길</font> : 일반적인 <br>이동가능한 길입니다.<br><br>
			<input type="radio" name="paletteoption" value="pwall"> ← <font color="gray">벽</font> : 이동할 수 없는 벽입니다. <br><br>
			<input type="radio" name="paletteoption" value="pstarting"> ← <font color="violet">시작지점</font> : 최초로 시작하는<br>장소입니다. (제한 1) <br><br>
			<input type="radio" name="paletteoption" value="pgoal"> ← <font color="pink">목표지점</font> : 미로 목표지점입니다.<br>도달시 승리합니다.<br>제한이 없기에 여러개 까셔도 됩니다.<br><br>
			<input type="button" value="All Road" onclick="bigevent('1')"> ← 미로 전체를 길로 만듭니다.<br><br>
			<input type="button" value="All Wall" onclick="bigevent('2')"> ← 미로 전체를 벽으로 만듭니다.<br><br>
			<input type="button" value="Remove Trap" onclick="bigevent('3')"> ← 미로의 모든 함정을 <br>제거합니다.<br><br>
			<input type="button" value="Remove Item" onclick="bigevent('4')"> ← 미로의 모든 아이템을 <br>제거합니다.<br><br>
			
			<input type="button" value="◀이전 페이지" onclick="pagemove('d');" style="float:left;"> <input type="button" value="Save" onclick="savecode()"> <input type="button" value="Load" onclick="loadcode()"> <input type="button" value="다음 페이지▶" onclick="pagemove('b');" style="float:right"><br><br>
	</div>
	
	<div class="palette" id="paletteb" onmouseover="javascript:mousestat2=0" onmouseout="javascript:mousestat2=1">
		<br><b><font color="yellow">: 아이템 :</font></b><br><br>
			<input type="button" value="◀이전 페이지" onclick="pagemove('a');" style="float:left;"> &nbsp;&nbsp;<a href="Maze.php"><input type="button" value="메인으로" size="8"></a>&nbsp;&nbsp; <input type="button" value="다음 페이지▶" onclick="pagemove('c');" style="float:right"><br><br>
	
			<input type="radio" name="paletteoption" value="psight"> ← <font color="yellow">만원경</font> : 최대 시야가<br> 
			<select id='sightrange'>
   				 <option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option>
   				 <option value='5'>5</option><option value='6'>6</option><option value='7'>7</option><option value='8'>8</option>
			</select> 만큼 증가합니다. <br><br>
			<input type="radio" name="paletteoption" value="pflash"> ← <font color="yellow">섬광탄</font> : 주변을<br>
			<select id='flashrange'>
   				 <option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option>
    			 <option value='5'>5</option><option value='6'>6</option><option value='7'>7</option><option value='8'>8</option>
			</select> 칸 밝게 비춥니다. <br><br>
			<input type="radio" name="paletteoption" value="pmaphack"> ← <font color="yellow">맵핵</font> : 미로 전체를<br>환하게 밝힙니다.<br>(아이템이나 함정은<br> 보이지 않습니다.)<br><br>
			<input type="radio" name="paletteoption" value="pbomb"> ← <font color="yellow">휴대용 폭탄 (소지형)</font> : 사방 1칸의 벽을 파괴합니다.<br><br>
			<input type="radio" name="paletteoption" value="ppocketflash"> ← <font color="yellow">휴대용 섬광탄(소지형)</font> : 사방 3칸의 시야를 밝힙니다.<br><br>
			<input type="radio" name="paletteoption" value="ppocketportal"> ← <font color="yellow">휴대용 포탈(소지형)</font> : 저장된 지역으로 순간이동합니다.<br>플레이어가 게임중 자신이 지난길중 선택하여 스스로 저장지점을 정할 수 있습니다.<br><br>
			<input type="radio" name="paletteoption" value="ptimeplus"> ← <font color="yellow">시간 증가</font> : 제한시간을 <br>30초 증가시킵니다.<br><br>
			
			<input type="button" value="◀이전 페이지" onclick="pagemove('a');" style="float:left;"> <input type="button" value="Save" onclick="savecode()"> <input type="button" value="Load" onclick="loadcode()"> <input type="button" value="다음 페이지▶" onclick="pagemove('c');" style="float:right"><br><br>
	</div>
	
	<div class="palette" id="palettec" onmouseover="javascript:mousestat2=0" onmouseout="javascript:mousestat2=1">
		<br><b><font color="red">: 함정 :</font></b><br><br>
			<input type="button" value="◀이전 페이지" onclick="pagemove('b');" style="float:left;"> &nbsp;&nbsp;<a href="Maze.php"><input type="button" value="메인으로" size="8"></a>&nbsp;&nbsp; <input type="button" value="다음 페이지▶" onclick="pagemove('d');" style="float:right"><br><br>
			
			<input type="radio" name="paletteoption" value="prestart"> ← <font color="red">귀가</font> : 플레이어를<br> 게임시작 위치로<br>강제이동 시킵니다. <br><br>
			<input type="radio" name="paletteoption" value="pgameover"> ← <font color="red">사망</font> : 플레이어를 죽입니다. <br>강제로 게임을 처음부터<br>다시 시작합니다. <br><br>
			<input type="radio" name="paletteoption" value="psightminus"> ← <font color="red">시야 감소</font> : 플레이어의 시야를 <br>1감소 시킵니다. <br><br>
			<input type="radio" name="paletteoption" value="ptimeminus"> ← <font color="red">시간 감소</font> : 제한시간을 <br>30초 감소시킵니다.<br><br>
			<input type="radio" name="paletteoption" value="pbombminus"> ← <font color="red">휴대용 폭탄 감소</font><br> : 폭탄을 1개 제거합니다.<br><br>
			<input type="radio" name="paletteoption" value="pflashminus"> ← <font color="red">휴대용 섬광탄 감소</font><br> : 섬광탄을 1개 제거합니다.<br><br>
			<input type="radio" name="paletteoption" value="pportalminus"> ← <font color="red">휴대용 포탈 감소</font><br> : 포탈을 1개 제거합니다.<br><br>
			
			<input type="button" value="◀이전 페이지" onclick="pagemove('b');" style="float:left;"> <input type="button" value="Save" onclick="savecode()"> <input type="button" value="Load" onclick="loadcode()"> <input type="button" value="다음 페이지▶" onclick="pagemove('d');" style="float:right"><br><br>
	</div>
	
	<div class="palette" id="paletted" onmouseover="javascript:mousestat2=0" onmouseout="javascript:mousestat2=1">
		<br><b><font color="springgreen">: 기타 작업 :</font></b><br><br>
			<input type="button" value="◀이전 페이지" onclick="pagemove('c');" style="float:left;"> &nbsp;&nbsp;<a href="Maze.php"><input type="button" value="메인으로" size="8"></a>&nbsp;&nbsp; <input type="button" value="다음 페이지▶" onclick="pagemove('a');" style="float:right"><br><br>
			
			: 포탈 사용법 : <br>포탈의 입구는 갯수 제한이 없지만 출구는 반드시 한가지만 존재해야합니다.<br>
			포탈입구번호와 같은 번호의 포탈출구로 이동됩니다.<br>
			반드시, 출구를 먼저 설치하고 입구를 설치해야 합니다.<br>
			입구먼저 만들고 출구를 만들면 안됩니다.<br><br>
			<input type="radio" name="paletteoption" id="pportalin" value="pportalin"> ← <font color="springgreen">포탈 입구</font><br>포탈 번호 : <input type="number" size="2" id="portalintext"><br>
			포탈 입구입니다.<br><br>
			<input type="radio" name="paletteoption" id="pportalout" value="pportalout"> ← <font color="springgreen">포탈 출구</font><br>포탈 번호 : <input type="number" size="2" id="portalouttext"><br>
			포탈 출구입니다.<br><br>
			<input type="radio" name="paletteoption" value="pcheck"> ← <font color="springgreen">디버깅</font> : 디버깅용 입니다.<br><br>
			
			<input type="button" value="◀이전 페이지" onclick="pagemove('c');" style="float:left;"> <input type="button" value="Save" onclick="savecode()"> <input type="button" value="Load" onclick="loadcode()"> <input type="button" value="다음 페이지▶" onclick="pagemove('a');" style="float:right"><br><br>
	</div>
	</form>
	
	<div class="palette" id="palettee" onmouseover="javascript:mousestat2=0" onmouseout="javascript:mousestat2=1">
		<br><h3>:: Maze Save &amp; Load ::</h3><br>
		저장 &amp; 불러오기에 사용할<br>아이디와 비밀번호를 입력해주세요.<br><br>
		<form id="Mazeform" method="post" action="MazeMaking.php">
		ID : <input type=text size="20" placeholder="Please Input ID.." autofocus name="inputid" onkeypress="JavaScript:press(this.form)"><br>
		Password : <input type=password size="20" placeholder="Please Input Password.." name="inputpass" onkeypress="JavaScript:press(this.form)"><br><br>
		미로 설명 : <input type=text size="25" name="explanation" placeholder="Please Input Explanation.." onkeypress="JavaScript:press(this.form)"><br>
		시간 제한 : <input type=number size="10" name="timelimit" placeholder="Please Input Time Limit.." onkeypress="JavaScript:press(this.form)"><br>
		(미입력시 10분)<br><br>
		공개/비공개 : <input type="button" id="openswitch1" value="공개" onclick="javascript:if($('#openswitch').attr('value')=='공개'){$('#openswitch').attr('value','비공개');$('#openswitch1').attr('value','비공개');}else{$('#openswitch').attr('value','공개');$('#openswitch1').attr('value','공개');}"><br>
		<input type=hidden size="0" id="openswitch" name="openswitch" value="공개"><input type=hidden size="0" id ="savecodeslot" name="savecodeslot"><br><br>
		<input type="button" value="확인" onclick="press2();"> <input type="button" value="취소" onclick="pagemove('a');">
		</form>
	</div>
	
	<script src="Maze JS.js?ver=15" charset="utf-8"></script>
	
</body>
</html>