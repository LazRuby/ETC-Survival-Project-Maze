﻿
var allscript = $('#textscript').html();		//스크립트 전체 읽어옴
var startindex = 0;							    //스토리 진행 처음위치 
var lastindex = 0;							    //스토리 진행 끝날위치
var println = "";							    //처음-끝을 allscript에서 뽑아와 이곳에 저장
var finalscript = new Array();				    //println을 각 (누구-대사-이미지) 단위로 나눠 저장
var storytemp = new Array();				    //storystart함수에서 누구-대사-이미지를 각각 잠시 저장할 배열
var storywhere = 0;							    //story진행중 어디인지 표시
var msgopacitycount = 1;

$('#textscript').remove();

/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////

$('body').keyup(function(e){if(event.keyCode==81) 
				{
					msgopacitycount++; 

					if(msgopacitycount%2==0){$('#textarea').css('opacity',0);}
					else if(msgopacitycount%2==1){$('#textarea').css('opacity',0.7);}
				}
			});
		
window.onload = function() 
{ 
    $('#storyarea').bind('click', function(){ storystart(); }) 
    	
    startindex = allscript.indexOf("#0001");	
    lastindex = allscript.indexOf("#0002");		

    println = allscript.substring(startindex + 6, lastindex-1);
    finalscript = println.split("\n");
	
    storystart();
}

/////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////	

function storymsg(name,string,color,size)
{
    if(string == "close")
    {
        top.window.opener = top;
        top.window.open('','_parent', '');
        top.window.close();
        return;
    }
	if (!color) { color = 'white'; }
	if (!size) { size = '1.2em' }
	
	$('#textarea').html("<b><span style='size:1.5em; color:"+color+";'>: " + name + " :</span></b><br><br><span style='font-size:"+size+"; color:"+color+";'>"+string+"</span><br>");
}

var gamecount = 0;
var seccount = 0

function mainloop()
{
	seccount = seccount + 1;
	$('#sec').html('경과시간 : ' + Math.floor(seccount) + ' 초');
}

function storystart()
{
	if(gamecount==1){return;}

	if(storywhere==finalscript.length-1)
	{
		storywhere = 0;
		return;
	}
	
	var storystaningimgtemp = new Array();		//스탠딩 이미지 누구누구인지 배열로 저장
	
	storytemp = finalscript[storywhere].split("/");
	try{storystandingimg = storytemp[2].split("o")} catch(e){}
	
	//////////////////////////////////////////////////////////////

	if(storytemp[0]=="gamestart")
	{
		msgopacitycount++; 
		if(msgopacitycount%2==0){$('#textarea').css('opacity',0);}
		else if(msgopacitycount%2==1){$('#textarea').css('opacity',0.7);}

		$('#chrarea').remove();
		$('#musicslot').remove();
		$('#centerdiv').html('<embed height="700" width="1250" src="orbit.swf" style="margin-top:10vh;"></embed> <br><br><br><h1><span id="sec" style="color:red;"></span></h1>');

		gamecount++;
		setInterval(function(){mainloop()}, 1000);

		return;
	}

	if(storytemp[0]=="아사히나"){storytemp[10]="red";}
	else if(storytemp[0]=="아카네"){storytemp[10]="gray";}
	else if(storytemp[0]=="카에데"){storytemp[10]="blue";}
	else if(storytemp[0]=="나나미"){storytemp[10]="green";}
    	else if(storytemp[0]=="쿄코"){storytemp[10]="fuchsia";}

	else if(storytemp[0]=="cg1"){ $('#centerdiv').css('opcacity',1); $('#centerdiv').html('<img src="Img/cg 1.png" style="z-index:20">'); storywhere ++; 
$('#textarea').html("<b><span style='size:1.5em; color:black;'>: System Cg 1 :</span></b><br><br><br><span style='size:1.5em; color:black;'>: Q = 대화창 ON/OFF : </span>"); $('#chrarea').html(''); return;}
	else if(storytemp[0]=="cg2"){ $('#centerdiv').css('opcacity',1); $('#centerdiv').html('<img src="Img/cg 2.png" style="z-index:20; margin-top:5vh;">'); storywhere ++;
$('#textarea').html("<b><span style='size:1.5em; color:black;'>: System Cg 2 :</span></b><br><br><br><span style='size:1.5em; color:black;'>: Q = 대화창 ON/OFF : </span>"); $('#chrarea').html(''); return;}
	else if(storytemp[0]=="cg3"){ $('#centerdiv').css('opcacity',1); $('#centerdiv').html('<img src="Img/cg 3.png" style="z-index:20">'); storywhere ++;
$('#textarea').html("<b><span style='size:1.5em; color:black;'>: System Cg 3 :</span></b><br><br><br><span style='size:1.5em; color:black;'>: Q = 대화창 ON/OFF : </span>"); $('#chrarea').html(''); return;}
	else if(storytemp[0]=="cg4"){ $('#centerdiv').css('opcacity',1); $('#centerdiv').html('<img src="Img/cg 4.png" style="z-index:20; margin-top:5vh;">'); storywhere ++;
$('#textarea').html("<b><span style='size:1.5em; color:black;'>: System Cg 4 :</span></b><br><br><br><span style='size:1.5em; color:black;'>: Q = 대화창 ON/OFF : </span>"); $('#chrarea').html(''); return;}

	else if(storytemp[0]=="cgbreak"){ $('#centerdiv').html(''); $('#chrarea').html('');
	for(var i=0; i<storystandingimg.length; i++)
	{
		//if(storystandingimg[i].length<=3){continue;}
		$('#chrarea').append('<img src="Img/' + storystandingimg[i] + '.png" class="storychrimg" style="z-index:15;">')
	} storywhere ++; return;}
	
	if(storytemp[0]=="."){storytemp[10]="black"}
	storymsg(storytemp[0], storytemp[1], storytemp[10]);
	
	///////////////////////////////////////////////////////////////

	msgopacitycount=1;
	$('#textarea').css('opacity',0.7);
	
	$('#chrarea').html('');
	for(var i=0; i<storystandingimg.length; i++)
	{
		$('#chrarea').append('<img src="Img/' + storystandingimg[i] + '.png" class="storychrimg" style="z-index:15;">')
	}
	
	storywhere ++;
}