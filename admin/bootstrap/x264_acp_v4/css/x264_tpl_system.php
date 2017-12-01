<?php
// ************************************************************************************//
// * X264 Source
// ************************************************************************************//
// * Author: D@rk-€vil™
// ************************************************************************************//
// * Version: 4.0
// * 
// * Copyright (c) 2015 D@rk-€vil™. All rights reserved.
// ************************************************************************************//
// * License Typ: Creative Commons licenses
// ************************************************************************************//
  ob_start ("ob_gzhandler");
  ob_start("compress");
  header("Content-type: text/css;charset: UTF-8");
  header("Cache-Control: must-revalidate");
  $offset = 60 * 60 ;
  $ExpStr = "Expires: " . gmdate("D, d M Y H:i:s",time() + $offset) . " GMT";
  header($ExpStr);
  function compress($buffer) {
    $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
    $buffer = str_replace(array("\r\n","\r","\n","\t",'  ','    ','    '),'',$buffer);
    $buffer = str_replace('{ ', '{', $buffer);
    $buffer = str_replace(' }', '}', $buffer);
    $buffer = str_replace('; ', ';', $buffer);
    $buffer = str_replace(', ', ',', $buffer);
    $buffer = str_replace(' {', '{', $buffer);
    $buffer = str_replace('} ', '}', $buffer);
    $buffer = str_replace(': ', ':', $buffer);
    $buffer = str_replace(' ,', ',', $buffer);
    $buffer = str_replace(' ;', ';', $buffer);
    $buffer = str_replace(';}', '}', $buffer);
    return $buffer;
  }
?>

@font-face {
	font-family: 'LeagueGothicRegular';
	src: url('../fonts/League_Gothic-webfont.eot');
	src: url('../fonts/League_Gothic-webfont.eot?#iefix') format('embedded-opentype'),
         url('../fonts/League_Gothic-webfont.woff') format('woff'),
         url('../fonts/League_Gothic-webfont.ttf') format('truetype'),
         url('../fonts/League_Gothic-webfont.svg#LeagueGothicRegular') format('svg');
    font-weight: normal;
    font-style: normal;
}

@font-face {
    font-family: 'BebasNeueRegular';
    src: url('../fonts/bebasneue-webfont.eot');
    src: url('../fonts/bebasneue-webfont.eot?#iefix') format('embedded-opentype'),
         url('../fonts/bebasneue-webfont.woff') format('woff'),
         url('../fonts/bebasneue-webfont.ttf') format('truetype'),
         url('../fonts/bebasneue-webfont.svg#BebasNeueRegular') format('svg');
    font-weight: normal;
    font-style: normal;
}

@font-face {
    font-family: 'BoycottRegular';
    src: url('../fonts/boycott_-webfont.eot');
    src: url('../fonts/boycott_-webfont.eot?#iefix') format('embedded-opentype'),
         url('../fonts/boycott_-webfont.woff') format('woff'),
         url('../fonts/boycott_-webfont.ttf') format('truetype'),
         url('../fonts/boycott_-webfont.svg#BoycottRegular') format('svg');
    font-weight: normal;
    font-style: normal;
}

@font-face {
    font-family: 'ZeroIsRegular';
    src: url('../fonts/zero_and_zero_is-webfont.eot');
    src: url('../fonts/zero_and_zero_is-webfont.eot?#iefix') format('embedded-opentype'),
         url('../fonts/zero_and_zero_is-webfont.woff') format('woff'),
         url('../fonts/zero_and_zero_is-webfont.ttf') format('truetype'),
         url('../fonts/zero_and_zero_is-webfont.svg#Zero&ZeroIsRegular') format('svg');
    font-weight: normal;
    font-style: normal;
}

@font-face {
    font-family: 'SnicklesRegular';
    src: url('../fonts/snickles-webfont.eot');
    src: url('../fonts/snickles-webfont.eot?#iefix') format('embedded-opentype'),
         url('../fonts/snickles-webfont.woff') format('woff'),
         url('../fonts/snickles-webfont.ttf') format('truetype'),
         url('../fonts/snickles-webfont.svg#SnicklesRegular') format('svg');
    font-weight: normal;
    font-style: normal;
}

@font-face {
    font-family: 'QlassikRegular';
    src: url('../fonts/qlassik_tb-webfont.eot');
    src: url('../fonts/qlassik_tb-webfont.eot?#iefix') format('embedded-opentype'),
         url('../fonts/qlassik_tb-webfont.woff') format('woff'),
         url('../fonts/qlassik_tb-webfont.ttf') format('truetype'),
         url('../fonts/qlassik_tb-webfont.svg#QlassikMediumRegular') format('svg');
    font-weight: normal;
    font-style: normal;
}

@font-face {
    font-family: 'GoodDogRegular';
    src: url('../fonts/gooddog-webfont.eot');
    src: url('../fonts/gooddog-webfont.eot?#iefix') format('embedded-opentype'),
         url('../fonts/gooddog-webfont.woff') format('woff'),
         url('../fonts/gooddog-webfont.ttf') format('truetype'),
         url('../fonts/gooddog-webfont.svg#GoodDogRegular') format('svg');
    font-weight: normal;
    font-style: normal;
}

@font-face {
    font-family: 'TendernessRegular';
    src: url('../fonts/tenderness-webfont.eot');
    src: url('../fonts/tenderness-webfont.eot?#iefix') format('embedded-opentype'),
         url('../fonts/tenderness-webfont.woff') format('woff'),
         url('../fonts/tenderness-webfont.ttf') format('truetype'),
         url('../fonts/tenderness-webfont.svg#TendernessRegular') format('svg');
    font-weight: normal;
    font-style: normal;
}

.x264_top_subnavbg {
	color: #606060; 
	font: normal normal 17px BebasNeueRegular,Arial,sans-serif;
	font-size: 14px; 
	background: rgb(0, 0, 0) url('../images/subnavbg.png') repeat-x 0 0;
	margin-top: 0px;
}

.logo-image {
	-moz-transition: all 0.15s ease-in-out 0.15s;
	-webkit-transition: all 0.15s ease-in-out 0.15s;
	-o-transition: all 0.15s ease-in-out 0.15s;
	transition: all 0.15s ease-in-out 0.15s;
}

.logo-image:hover {
	-moz-transition: all 0.15s ease-in-out 0.15s;
	-webkit-transition: all 0.15s ease-in-out 0.15s;
	-o-transition: all 0.15s ease-in-out 0.15s;
	transition: all 0.15s ease-in-out 0.15s;
	opacity: 0.70;
	filter:alpha(opacity=70);
}

.footer {
    background: rgb(15,15,15) url('../images/footerbg.png') repeat-x -30px center;

}

#loginBar
{
	color: rgb(166, 166, 166);
	background-color: rgb(10, 10, 10);
	border-bottom: 1px solid rgb(36, 36, 36);
	position: relative;
	z-index: 1000;
}

	#loginBar .ctrlWrapper
	{
		margin: 0 10px;
	}

	#loginBar .pageContent
	{
		padding-top: 0px;
		position: relative;
		_height: 0px;
	}

	#loginBar a
	{
		color: rgb(200,200,200);

	}

	#loginBar form
	{
		padding: 5px 0;
margin: 0 auto 5px;
display: none;
line-height: 20px;
position: relative;
-webkit-border-radius: 0; -moz-border-radius: 0; -khtml-border-radius: 0; border-radius: 0;

	}
	
		#loginBar .xenForm .ctrlUnit,		
		#loginBar .xenForm .ctrlUnit > dt label
		{
			margin: 0;
			border: none;
		}
	
		#loginBar .xenForm .ctrlUnit > dd
		{
			position: relative;
		}
	
	#loginBar .lostPassword,
	#loginBar .lostPasswordLogin
	{
		font-size: 11px;
	}
	
	#loginBar .rememberPassword
	{
		font-size: 11px;
	}

	#loginBar .textCtrl
	{
		color: rgb(200,200,200);
background-color: rgb(15, 15, 15);
border: 1px solid rgb(92, 92, 92);

	}
	
	#loginBar .textCtrl[type=text]
	{
		font-weight: bold;
font-size: 18px;

	}

	#loginBar .textCtrl:-webkit-autofill /* http://code.google.com/p/chromium/issues/detail?id=1334#c35 */
	{
		background: rgb(15, 15, 15) !important;
		color: rgb(200,200,200);
	}

	#loginBar .textCtrl:focus
	{
		color: rgb(228, 137, 27);
background: black none;

	}
	
	#loginBar input.textCtrl.disabled
	{
		color: rgb(100,100,100);
background-color: rgb(10, 10, 10);
border-style: dashed;

	}
	
	#loginBar
	{
		min-width: 85px;
		*width: 85px;
	}
	
		#loginBar .primary
		{
			font-weight: bold;
		}
		
/** changes when eAuth is present **/

#loginBar form.eAuth
{
	-x-max-width: 700px; /* normal width + 170px */
}

	#loginBar form.eAuth .ctrlWrapper
	{
		border-right: 1px dotted rgb(24, 24, 24);
		margin-right: 200px;
		-webkit-box-sizing: border-box; -moz-box-sizing: border-box; -ms-box-sizing: border-box; box-sizing: border-box;
	}

	#loginBar form.eAuth #eAuthUnit
	{
		position: absolute;
		top: 0px;
		right: 10px;
	}

		#eAuthUnit li
		{
			margin-top: 10px;
			line-height: 0;
		}
	
/** handle **/

#loginBar #loginBarHandle
{
	font-size: 12px;
color: rgb(200,200,200);
background-color: rgb(10, 10, 10);
padding: 0 10px;
margin-right: 20px;
-webkit-border-bottom-right-radius: 10px; -moz-border-radius-bottomright: 10px; -khtml-border-bottom-right-radius: 10px; border-bottom-right-radius: 10px;
-webkit-border-bottom-left-radius: 10px; -moz-border-radius-bottomleft: 10px; -khtml-border-bottom-left-radius: 10px; border-bottom-left-radius: 10px;
position: absolute;
right: 0px;
bottom: -20px;
text-align: center;
z-index: 1;
line-height: 20px;
-webkit-box-shadow: 0px 2px 5px rgb(10, 10, 10); -moz-box-shadow: 0px 2px 5px rgb(10, 10, 10); -khtml-box-shadow: 0px 2px 5px rgb(10, 10, 10); box-shadow: 0px 2px 5px rgb(10, 10, 10);

}


@media (max-width:800px)
{
	.Responsive #loginBar form.eAuth .ctrlWrapper
	{
		border-right: none;
		margin-right: 10px;
	}

	.Responsive #loginBar form.eAuth #eAuthUnit
	{
		position: static;
		width: 180px;
		margin: 0 auto 10px;
	}
}


/* --- node_link.css --- */

/* tbd */

/* --- node_list.css --- */











.nodeList.sectionMain
{
	background: url(rgba.php?r=0&g=0&b=0&a=0); 
background: rgba(0, 0, 0, 0);
 _filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#00000000,endColorstr=#00000000);
padding: 0px;
margin: 0px;
border-width: 0px;
-webkit-border-radius: 0px; -moz-border-radius: 0px; -khtml-border-radius: 0px; border-radius: 0px;

}
.xb_catBottom_center
{
	background-color: rgb(78, 78, 78);
display: block;
overflow: hidden;

}
.xb_goToTop_button
{
	padding-top: 2px;
padding-right: 5px;
padding-bottom: 2px;
float: right;

}
.XenBase .subForumsPopup .PopupOpen .dt
{
	color: rgb(228, 137, 27);
}
.subForumList li .nodeTitle:before
{
	font-size: 1.3em;
color: rgb(150,150,150);
margin-right: 5px;
content: "•";
position: relative;
top: 1px;

}
.subForumList li .unread .nodeTitle:before
{
	font-size: 1.3em;
color: rgb(87, 87, 87);
margin-right: 5px;
content: "•";
position: relative;
top: 1px;

}
.nodeStats dl, .nodeStats dt
{
	
}
.nodeStats dd
{
	margin-right: 5px;

}
.nodeInfo.forumNodeInfo.primaryContent.unread
{
        
}



#forums .nodeList
{
	border: 1px solid rgb(35, 35, 35);
border-top-width: 0;
-webkit-border-bottom-right-radius: 5px; -moz-border-radius-bottomright: 5px; -khtml-border-bottom-right-radius: 5px; border-bottom-right-radius: 5px;
-webkit-border-bottom-left-radius: 5px; -moz-border-radius-bottomleft: 5px; -khtml-border-bottom-left-radius: 5px; border-bottom-left-radius: 5px;
overflow: hidden;

}

.nodeList .node.level_1
{
	
}

li .nodeList .nodeInfo.primaryContent,
li .nodeList .nodeInfo.categoryForumNodeInfo,
li .nodeList .nodeInfo.pageNodeInfo,
li .nodeList .nodeInfo.linkNodeInfo
{
	background: rgb(24, 24, 24) url('../images/nodebg2.png') repeat-x top center;
border-bottom-width: 0;
-webkit-border-bottom-right-radius: 0; -moz-border-radius-bottomright: 0; -khtml-border-bottom-right-radius: 0; border-bottom-right-radius: 0;

}


.XenBase .node .forumNodeInfo .nodeIcon,
.XenBase .node .categoryForumNodeInfo .nodeIcon,
.XenBase .node .forumNodeInfo.unread .nodeIcon,
.XenBase .node .categoryForumNodeInfo.unread .nodeIcon,
.XenBase .node .linkNodeInfo .nodeIcon,
.XenBase .node .pageNodeInfo .nodeIcon
{
	background: none;
}
.node .nodeIcon:hover .fa
{
	cursor: default;
}
.node .unread a.nodeIcon:hover .fa
{
	cursor: pointer;
}
.node .nodeIcon .fa-comments-o
{
	color: rgb(78, 78, 78);

}

.node .unread .nodeIcon .fa-comments-o
{
	color: rgb(228, 137, 27);
text-decoration: none;

}

.link .nodeIcon .fa-link
{
	color: rgb(228, 137, 27);

}

.page .nodeIcon .fa-file-text-o
{
	color: rgb(228, 137, 27);

}




/* -- Node Alt Background -- */



.nodeList { zoom: 1; }
.nodeList .node {
	zoom: 1;
	vertical-align: bottom;
}

.nodeList .node.level_1
{
	margin-bottom: 20px;
}

.nodeList .node.level_1:last-child
{
	margin-bottom: 0;
}

.nodeList .node.groupNoChildren + .node.groupNoChildren
{
	margin-top: -20px;
}

.node .nodeInfo
{
	overflow: hidden; zoom: 1;
	position: relative;
}

	.node .nodeInfo.primaryContent,
	.node .nodeInfo.secondaryContent
	{
		padding: 0;
	}

.node .nodeIcon
{
	margin: 10px 0 10px 10px;
float: left;
text-align: center;
width: 43px;
height: 43px;
	
}

	.node .forumNodeInfo .nodeIcon,
	.node .categoryForumNodeInfo .nodeIcon
	{
		background-image: url('../images/node-sprite.png');
background-repeat: no-repeat;
background-position: -45px -5px;

	}

	.node .forumNodeInfo.unread .nodeIcon,
	.node .categoryForumNodeInfo.unread .nodeIcon
	{
		background-image: url('../images/node-sprite.png');
background-repeat: no-repeat;
background-position: 1px -5px;

	}

	.node .pageNodeInfo .nodeIcon
	{
		background-image: url('../images/node-sprite.png');
background-repeat: no-repeat;
background-position: -133px -5px;

	}

	.node .linkNodeInfo .nodeIcon
	{
		background-image: url('../images/node-sprite.png');
background-repeat: no-repeat;
background-position: -89px -5px;

	}

.node .nodeText
{
	margin: 12px 270px 10px 75px;

}

	.node .nodeText .nodeTitle
	{	
		font-size: 14px;

	}
	
		.node .unread .nodeText .nodeTitle
		{
			font-weight: bold;

		}

	.node .nodeDescription
	{
		font-size: 12px;

	}
	
	.hasJs .node .nodeDescriptionTooltip
	{
		/* will be shown as a tooltip */
		display: none;
	}
	
	.Touch .node .nodeDescriptionTooltip
	{
		/* touch browsers don't see description tooltips */
		display: block;
	}

	.node .nodeStats
	{
		font-size: 12px;
padding-top: 2px;
padding-bottom: 2px;
margin-top: 2px;

	}
	
	.node .nodeExtraNote
	{
		text-align: right;
		font-size: 11px;
		color: rgb(150,150,150);
	}
	
	.node .subForumList
	{
		overflow: hidden; *zoom: 1;
		margin: -5px 0 10px;
		margin-left: 75px;
	}
	
		.node .subForumList li
		{
			float: left;
			width: 31%;
			margin: 2px 0 2px 2%;
		}
		
			.node .subForumList li .nodeTitle
			{
				font-size: 11px;
				overflow: hidden;
				white-space: nowrap;
				word-wrap: normal;
				text-overflow: ellipsis;
			}
			
			.node .subForumList .unread .nodeTitle
			{
				font-weight: bold;

			}
		
			.node .subForumList li ol,
			.node .subForumList li ul
			{
				display: none;
			}

.node .nodeLastPost
{
	background-color: rgb(18, 18, 18);
padding: 10px;
border-bottom: 1px solid rgb(35, 35, 35);

	
	font-size: 12px;
padding: 3px 10px;
margin: 10px;
border: 1px solid rgb(35, 35, 35);
-webkit-border-radius: @xb_borderradius; -moz-border-radius: @xb_borderradius; -khtml-border-radius: @xb_borderradius; border-radius: @xb_borderradius;
position: absolute;
top: 0;
right: 0;
white-space: nowrap;
word-wrap: normal;
overflow: hidden;
width: 210px;

}

.node .nodeLastPost .lastThreadTitle
{
	text-overflow: ellipsis;
	max-width: 100%;
	display: block;
	overflow: hidden;
}

	.node .nodeLastPost .lastThreadMeta
	{
		display: block;
	}

	.node .nodeLastPost .noMessages
	{
		line-height: 28px;
	}

.node .nodeControls
{
	position: absolute;
	top: 0;
	right: 242px;
	margin: 20px 0;
}

	.node .tinyIcon
	{
		color: rgb(255, 102, 0);
background-color: transparent;
margin: 1px 4px;
display: block;
white-space: nowrap;
opacity: 0.25;
width: 12px;
height: 16px;

	}

	.node .nodeInfo:hover .tinyIcon[href],
	.Touch .node .tinyIcon
	{
		opacity: 1;

	}

		/*.node .feedIcon
		{
			background: transparent url('../images/ui-sprite.png') no-repeat -112px -16px;
		}*/

/* description tooltip */

.nodeDescriptionTip
{
	padding: 4px 10px;
margin-top: -22px;
line-height: 1.5;
width: 350px;
height: auto;

}

	.nodeDescriptionTip .arrow
	{
		border: 6px solid transparent;
border-right-color:  rgb(0, 0, 0); border-right-color:  rgba(0, 0, 0, 0.8); _border-right-color:  rgb(0, 0, 0);
border-left: 1px none black;
top: 6px;
left: -6px;
bottom: auto;

	}
	
	.nodeDescriptionTip.arrowBottom .arrow
	{
		top: auto;
		left: 10px;
		bottom: -6px;
		border: 6px solid transparent;
		border-top-color:  rgb(0, 0, 0); border-top-color:  rgba(0, 0, 0, 0.8); _border-top-color:  rgb(0, 0, 0);
		border-bottom: 1px none black;
	}
	
/* main area - used for L2 categories and most other nodes */

.nodeList .categoryForumNodeInfo,
.nodeList .forumNodeInfo,
.nodeList .pageNodeInfo,
.nodeList .linkNodeInfo
{
	background-color: rgb(20, 20, 20);
padding: 10px;
border-bottom: 1px solid rgb(31, 31, 31);

	
	padding: 0;
}

/* category strip - used for L1 categories and group headers */

.nodeList .categoryStrip
{
	font-size: 14px !important;
font-family: 'Oswald', sans-serif;
color: rgb(255, 255, 255);
background: rgb(87, 87, 87) url('../images/gradient.png') repeat-x;
padding: 9px 10px;
margin: 3px auto 0;

	
	padding-right: 10px;
padding-left: 10px;
margin: 0;
border-bottom-color: ;
-webkit-border-radius: 5px; -moz-border-radius: 5px; -khtml-border-radius: 5px; border-radius: 5px;
-webkit-border-bottom-right-radius: 0px; -moz-border-radius-bottomright: 0px; -khtml-border-bottom-right-radius: 0px; border-bottom-right-radius: 0px;
-webkit-border-bottom-left-radius: 0px; -moz-border-radius-bottomleft: 0px; -khtml-border-bottom-left-radius: 0px; border-bottom-left-radius: 0px;
min-height: 6px;

}

	.nodeList .categoryStrip .nodeTitle
	{
		font-family: 'Oswald', sans-serif;
color: rgb(255, 255, 255);

	}
	
		.nodeList .categoryStrip .nodeTitle a
		{
			color: rgb(255, 255, 255);
		}

	.nodeList .categoryStrip .nodeDescription
	{
		font-size: 10px;
color: rgb(255, 255, 255);

	}
	
		.nodeList .categoryStrip .nodeDescription a
		{
			color: rgb(255, 255, 255);
		}

.nodeList .node.groupNoChildren + .node.groupNoChildren .categoryStrip
{
	display: none;
}

/* node stats area */

.nodeStats
{
	overflow: hidden; zoom: 1;
}

.nodeStats dl,
.subForumsPopup
{
	float: left;
	display: block;
	margin-right: 3px;
}

.subForumsPopup.Popup .PopupControl.PopupOpen
{
	background-image: none;
	color: rgb(228, 137, 27) !important
}

.subForumsPopup a.PopupControl
{
	padding-left: 5px;
	padding-right: 5px;
}

.subForumsPopup .dt
{
	color: rgb(150,150,150);
}

.subForumsPopup .PopupOpen .dt
{
	color: rgb(166, 166, 166);
}

.subForumsMenu .node .node /* for depths 2+ */
{
	padding-left: 10px;
}

	.subForumsMenu .node .nodeTitle
	{
		font-size: 11px;
	}
	
	.subForumsMenu .node .unread .nodeTitle
	{
		font-weight: bold;

	}
	
/** new discussion button below nodelist **/

.nodeListNewDiscussionButton
{
	margin-top: 10px;
	text-align: right;
}


@media (max-width:610px)
{
	.Responsive .node .nodeText
	{
		margin-right: 0;
	}
	
	.Responsive.Touch .node .nodeDescriptionTooltip,
	.Responsive .node .nodeDescription
	{
		display: none;
	}

	.Responsive .node .nodeLastPost
	{
		position: static;
		height: auto;
		width: auto;
		background: none;
		border: none;
		padding: 0;
		margin: -8px 0 10px 75px;
	}
	
		.Responsive .node .nodeLastPost .noMessages 
		{
			display: none;
		}
		
		.Responsive .node .nodeLastPost .lastThreadTitle,
		.Responsive .node .nodeLastPost .lastThreadUser
		{
			display: none;
		}
				
		.Responsive .node .nodeLastPost .lastThreadDate:before
		{
			content: attr(data-latest);
		}

	.Responsive .node .nodeControls
	{
		display: none;
	}
		
	.Responsive .node .subForumList
	{
		display: none;
	}
	
	.Responsive .nodeDescriptionTip
	{
		width: auto;
		max-width: 350px;
	}
}

@media (max-width:480px)
{
	.Responsive .subForumsPopup
	{
		display: none;
	}
}


/* --- node_page.css --- */

.nodeList .page .nodeText
{
	margin-right: 10px;
}

/* --- notices.css --- */

.hasJs .FloatingContainer .Notice
{
	display: none;
}

.FloatingContainer
{
	position: fixed;
	width: 300px;
	z-index: 9997;
	top: auto;
	left: auto;
	bottom: 0;
	right: 20px;
}

.Notices .Notice .blockImage
{
	padding: 10px 0 5px 10px;
}

.Notices .Notice .blockImage,
.FloatingContainer .floatingImage
{
	float: left;
}

.Notices .Notice .blockImage img,
.FloatingContainer .floatingImage img
{
	max-width: 48px;
	max-height: 48px;
}

.Notices .hasImage,
.FloatingContainer .hasImage
{
	margin-left: 64px;
	min-height: 52px;
}

.FloatingContainer .floatingItem
{
	display: block;
	padding: 10px;
	font-size: 11px;
	position: relative;
	margin-bottom: 20px;
	border: 1px solid transparent;
	-webkit-border-radius: 6px; -moz-border-radius: 6px; -khtml-border-radius: 6px; border-radius: 6px;
	-webkit-box-shadow: 1px 1px 3px rgba(0,0,0, 0.25); -moz-box-shadow: 1px 1px 3px rgba(0,0,0, 0.25); -khtml-box-shadow: 1px 1px 3px rgba(0,0,0, 0.25); box-shadow: 1px 1px 3px rgba(0,0,0, 0.25);
}

.FloatingContainer .floatingItem.primary
{
	background-color: rgb(18, 18, 18);
	border-color: rgb(67, 67, 67);
}

.FloatingContainer .floatingItem.secondary
{
	color: rgb(24, 24, 24);
	background-color: rgb(23, 23, 23);
	border-color: rgb(23, 23, 23);
}

.FloatingContainer .floatingItem.dark
{
	color: #fff;
	background: black;
	background: url(rgba.php?r=0&g=0&b=0&a=204); background: rgba(0,0,0, 0.8); _filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#CC000000,endColorstr=#CC000000);
	border-color: #333;
}

.FloatingContainer .floatingItem.light
{
	color: #000;
	background: white;
	background: url(rgba.php?r=255&g=255&b=255&a=204); background: rgba(255,255,255, 0.8); _filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#CCFFFFFF,endColorstr=#CCFFFFFF);
	border-color: #ddd;
}

.FloatingContainer .floatingItem .title
{
	font-size: 14px;
	padding-bottom: 5px;
	font-weight: bold;
	display: block;
}

.FloatingContainer .floatingItem .DismissCtrl
{
	position: static;
	float: right;
	margin-left: 5px;
	margin-right: -5px;
	margin-top: -5px;
}

.Notices
{
	display: none;
}


	@media (max-width:800px)
	{
		.Responsive .Notice.wide { display: none !important; }
	}
	
	@media (max-width:610px)
	{
		.Responsive .Notice.medium { display: none !important; }
	}
	
	@media (max-width:480px)
	{
		.Responsive .Notice.narrow { display: none !important; }
		
		.Responsive .FloatingContainer
		{
			right: 50%;
			margin-right: -150px;
		}
	}


/* --- panel_scroller.css --- */

.hasJs .Notices.PanelScroller { display: none; }

.PanelScroller .scrollContainer,
.PanelScrollerOff .panel
{
	background-color: rgb(11, 11, 11);
padding: 3px;
margin-bottom: 10px;
border: 1px solid rgb(31, 31, 31);
-webkit-border-radius: 5px; -moz-border-radius: 5px; -khtml-border-radius: 5px; border-radius: 5px;
font-size: 14px;

}

.PanelScroller .PanelContainer
{
	position: relative;
	clear: both;
	width: 100%;
	overflow: auto;
}

	.hasJs .PanelScroller .Panels
	{
		position: absolute;
	}

	.PanelScroller .Panels
	{
		clear: both;
		margin: 0;
		padding: 0;
	}
	
		.PanelScroller .panel,
		.PanelScrollerOff .panel
		{
			overflow: hidden;
			position: relative;
			padding: 0 !important;

			background-color: rgb(34, 34, 34);
padding: 10px;

		}
			
		.PanelScroller .panel .noticeContent,
		.PanelScrollerOff .panel .noticeContent
		{
			padding: 10px;
		}

/** panel scroller nav **/

.PanelScroller .navContainer
{
	margin: -11px 21px 10px;
overflow: hidden;
zoom: 1;

}

.PanelScroller .navControls
{
	float: right;
}

/* clearfix */ .PanelScroller .navControls { zoom: 1; } .PanelScroller .navControls:after { content: '.'; display: block; height: 0; clear: both; visibility: hidden; }

	.PanelScroller .navControls a
	{
		font-size: 11px;
color: rgb(166, 166, 166);
background-color: rgb(34, 34, 34);
padding: 3px 6px 2px;
margin-left: -1px;
float: left;
display: block;
position: relative;

		
		border: 1px solid rgb(31, 31, 31);
-webkit-border-radius: 5px; -moz-border-radius: 5px; -khtml-border-radius: 5px; border-radius: 5px;
		-webkit-border-radius: 0; -moz-border-radius: 0; -khtml-border-radius: 0; border-radius: 0;
	}
	
		.PanelScroller .navControls > a:first-child
		{
			-webkit-border-bottom-left-radius: 5px; -moz-border-radius-bottomleft: 5px; -khtml-border-bottom-left-radius: 5px; border-bottom-left-radius: 5px;
		}
		
		.PanelScroller .navControls > a:last-child
		{
			-webkit-border-bottom-right-radius: 5px; -moz-border-radius-bottomright: 5px; -khtml-border-bottom-right-radius: 5px; border-bottom-right-radius: 5px;
		}
		
		.PanelScroller .navControls a:hover
		{
			text-decoration: none;
background-color: rgb(78, 78, 78);

		}
		
		.PanelScroller .navControls a.current
		{
			background-color: rgb(69, 69, 69);

		}
		
			.PanelScroller .navControls a .arrow
			{
				display: none;
			}
			
			.PanelScroller .navControls a.current span
			{
				display: block;
				line-height: 0px;
				width: 0px;
				height: 0px;
				border-top: 5px solid rgb(67, 67, 67);
				border-right: 5px solid transparent;
				border-bottom: 1px none black;
				border-left: 5px solid transparent;
				-moz-border-bottom-colors: rgb(67, 67, 67);
				position: absolute;
			}
			
			.PanelScroller .navControls a.current .arrow
			{
				border-top-color: rgb(31, 31, 31);
				top: 0px;
				left: 50%;
				margin-left: -5px;
			}
			
				.PanelScroller .navControls a .arrow span
				{
					border-top-color: rgb(11, 11, 11);
					top: -6px;
					left: -5px;
				}
				
/* notices */

.Notices .panel .noticeContent
{
	padding-right: 25px;
}

/* --- profile_post_list_simple.css --- */

.profilePostListItem
{
	overflow: hidden; zoom: 1;

	margin: 5px 0;
	padding-top: 5px;
	border-top: 1px solid rgb(69, 69, 69);
}

:not(.nonInitial) > .profilePostListItem:first-child
{
	border-top: none;
	padding-top: 0;
}

.profilePostListItem .avatar
{
	float: left;
	font-size: 0;
}

	.profilePostListItem .avatar img
	{
		width: 24px;
		height: 24px;
	}

.profilePostListItem .messageInfo
{
	margin-left: 34px;
}


.profilePostListItem .messageContent article,
.profilePostListItem .messageContent blockquote
{
	display: inline;
}

.profilePostListItem .poster
{
	font-weight: bold;
}

.profilePostListItem .messageMeta
{
	overflow: hidden; zoom: 1;
	font-size: 11px;
	line-height: 14px;
	padding-top: 4px;
}

.profilePostListItem .privateControls
{
	float: left;
}

	.profilePostListItem .privateControls .item
	{
		float: left;
		margin-right: 10px;
	}

.profilePostListItem .publicControls
{
	float: right;
}

	.profilePostListItem .publicControls .item
	{
		float: left;
		margin-left: 10px;
	}
	
.sidebar .statusPoster textarea
{
	width: 100%;
	margin: 0;
	-webkit-box-sizing: border-box; -moz-box-sizing: border-box; -ms-box-sizing: border-box; box-sizing: border-box;
	resize: vertical;
	overflow: hidden;
}

.sidebar .statusPoster .submitUnit
{
	margin-top: 5px;
	text-align: right;
}

/* --- sidebar_share_page.css --- */

.sidebar .sharePage .shareControl
{
	margin-top: 10px;
	min-height: 23px;
}

.sidebar .sharePage iframe
{
	width: 200px;
	height: 20px;
}

.sidebar .sharePage iframe.fb_ltr
{
	_width: 200px !important;
}

.sidebar .sharePage .facebookLike iframe
{
	z-index: 52;
}

.mast .sharePage .secondaryContent
{
	overflow: visible !important;
}




@media (max-width:480px)
{
	.Responsive .sidebar .sharePage
	{
		display: none;
	}
}


/* --- xb.css --- */

/***** User Panel Sprites and CSS *****/
.userpanelboxc .xenForm
{
	border-width: 0;
	padding: 0;
	margin: 0;
	background-color: transparent;
}
html .userpanelboxc .xenForm .ctrlUnit
{
	margin: 0px;
}
.userpanelbox .xenForm .ctrlUnit dd
{
	width: 280px;
}
.usercpbuttons .arrowWidget
{
	display: none;
}
#USERPANELSPRITE_03_png { 
	height: 74px; 
	width: 89px; 
	background-position: -0px -0px; 
	margin-top: 10px;
	margin-bottom: 15px;
	margin-left: 10px;
	float: left;
} 
 
#USERPANELSPRITE_07_png { 
	height: 23px; 
	width: 57px; 
	background-position: -89px -0px; 
} 
 
#USERPANELSPRITE_09_png { 
	height: 23px; 
	width: 59px; 
	background-position: -146px -0px; 
} 
 
#USERPANELSPRITE_11_png { 
	height: 23px; 
	width: 59px; 
	background-position: -205px -0px; 
} 
 
#USERPANELSPRITE_13_png { 
	height: 23px; 
	width: 58px; 
	background-position: -264px -0px; 
} 
 
#USERPANELSPRITE_15_png { 
	height: 23px; 
	width : 58px; 
	background-position: -322px -0px; 
} 
 
#USERPANELSPRITE_16_png { 
	height: 23px; 
	width: 57px; 
	background-position: -380px -0px; 
} 
 
#USERPANELSPRITE_17_png { 
	height: 23px; 
	width: 60px; 
	background-position  : -437px -0px; 
} 
 
#USERPANELSPRITE_18_png { 
    height: 23px; 
    width: 60px; 
    background-position: -497px -0px; 
} 
 .userpanelbox {
	background-image: url('../images/userpanelbg.png'); 
	background-repeat: no-repeat;
	-webkit-border-radius: 5px; -moz-border-radius: 5px; -khtml-border-radius: 5px; border-radius: 5px;
	width: 306px;
	padding-bottom: 8px;
	padding-right: 4%;
	margin-top: 25px;
	margin-bottom: 10px;
	float: right;
	font-family: Arial;
	color: #FFF;
	height: 160px;
	text-transform: uppercase;
	font-size: 10px;
	font-weight: bold;
	margin-top: 25px;
	margin-bottom: 10px;
}
.userpaneltext {
	padding-left: 7px;
	padding-top: 5px;
}
.userpanelboxc {
	padding: 8px 7px 0px 7px;
}
.upstats  span {
	color: rgb(228, 137, 27);
	padding-left: 15px;
	float: right;
}
.upstats {
	float:right;
	color: #6d6d6d;
	line-height: 21px;
	padding-left: 10px;
	padding-right: 60px;
	padding-top: 0px;
	padding-bottom: 12px;
}
.userpaneltext span {
	float: right;
	padding-right: 7px;
}
.usercpbuttons  {
	list-style-type: none;
	float: left;
	padding-left: 15px;
	margin-left: 0px;
}
.usercpbuttons li {
	float: left;
	margin: 0px 4px 0px 4px;
}
.upsprites { 
	background-image     : url('../images/sprite.png'); 
	background-color     : transparent; 
	background-repeat    : no-repeat; 
} 
.upsprites img {
	background-color: transparent;
	border: 0 none;
	padding: 4px 6px 4px 7px;
	width: 76px !important;
	height: 76px !important;
}
/***** User Panel Sprites and CSS*****/
.upstats .userMood {
	padding: 5px !important;
}

.userpanelboxc .itemCount
{
	font-weight: bold;
font-size: 9px;
color: white;
background-color: #e03030;
padding: 0 2px;
-webkit-border-radius: 2px; -moz-border-radius: 2px; -khtml-border-radius: 2px; border-radius: 2px;
position: absolute;
right: 2px;
top: -20px;
line-height: 16px;
min-width: 12px;
_width: 12px;
text-align: center;
text-shadow: none;
white-space: nowrap;
word-wrap: normal;
-webkit-box-shadow: 2px 2px 5px rgba(0,0,0, 0.25); -moz-box-shadow: 2px 2px 5px rgba(0,0,0, 0.25); -khtml-box-shadow: 2px 2px 5px rgba(0,0,0, 0.25); box-shadow: 2px 2px 5px rgba(0,0,0, 0.25);
height: 16px;

}

	.userpanelboxc .itemCount .arrow
	{
		border: 3px solid transparent;
border-top-color: rgb(224, 48, 48);
border-bottom: 1px none black;
position: absolute;
bottom: -3px;
right: 4px;
line-height: 0px;
text-shadow: none;
_display: none;
/* Hide from IE6 */
width: 0px;
height: 0px;

	}
	
.userpanelboxc .itemCount.Zero
{
	display: none;
}

@media (max-width:800px)
{
	.userpanelbox
	{
		display: none;
	}
	#logoBlock #logo img
	{
		max-width: 100%;
		max-height: 100%;
	}
}
@media (min-width:800px)
{
	.navTabs .visitorTabs .navLink
	{
		display: none;
	}
}
.userText .fgRed, .userText .fgGreen, .userText .fgOrange, .userText .fgBlue, .userText .fgSilver, .userText .fgYellow, .userText .fgTeal
{
	display: block;
	margin-top: 3px;
}

.fgRed
{
	background: #AF0202 !important;
	border: none !important;
	color: #E0E0E0  !important;
	font-weight: bold;
	text-shadow: 0 0 0 transparent, 0px 0px 2px #000;
	-webkit-box-shadow: inset 0px 1px 0px 0px #DD0A0A; -moz-box-shadow: inset 0px 1px 0px 0px #DD0A0A; -khtml-box-shadow: inset 0px 1px 0px 0px #DD0A0A; box-shadow: inset 0px 1px 0px 0px #DD0A0A;
	padding: 3px 8px;
	-webkit-border-radius: 3px; -moz-border-radius: 3px; -khtml-border-radius: 3px; border-radius: 3px;
}
.fgGreen
{
	background: #02af06 !important;
	border: none !important;
		color: #E0E0E0  !important;
	font-weight: bold;
	text-shadow: 0 0 0 transparent, 0px 0px 2px #000;
	-webkit-box-shadow: inset 0px 1px 0px 0px #1bce20; -moz-box-shadow: inset 0px 1px 0px 0px #1bce20; -khtml-box-shadow: inset 0px 1px 0px 0px #1bce20; box-shadow: inset 0px 1px 0px 0px #1bce20;
	padding: 3px 8px;
	-webkit-border-radius: 3px; -moz-border-radius: 3px; -khtml-border-radius: 3px; border-radius: 3px;
}
.fgOrange
{
	background: #e26b1b !important;
	border: none !important;
	color: #E0E0E0  !important;;
	font-weight: bold;
	text-shadow: 0 0 0 transparent, 0px 0px 2px #000;
	-webkit-box-shadow: inset 0px 1px 0px 0px #f08238; -moz-box-shadow: inset 0px 1px 0px 0px #f08238; -khtml-box-shadow: inset 0px 1px 0px 0px #f08238; box-shadow: inset 0px 1px 0px 0px #f08238;
	padding: 3px 8px;
	-webkit-border-radius: 3px; -moz-border-radius: 3px; -khtml-border-radius: 3px; border-radius: 3px;
}
.fgBlue
{
	background: #0571bc !important;
	border: none !important;
	color: #E0E0E0  !important;
	font-weight: bold;
	text-shadow: 0 0 0 transparent, 0px 0px 2px #000;
	-webkit-box-shadow: inset 0px 1px 0px 0px #32a1ef; -moz-box-shadow: inset 0px 1px 0px 0px #32a1ef; -khtml-box-shadow: inset 0px 1px 0px 0px #32a1ef; box-shadow: inset 0px 1px 0px 0px #32a1ef;
	padding: 3px 8px;
	-webkit-border-radius: 3px; -moz-border-radius: 3px; -khtml-border-radius: 3px; border-radius: 3px;
}
.fgSilver
{
	background: #cbcbcb !important;
	border: none !important;
	color: #333333 !important;
	font-weight: bold;
	text-shadow: 0 0 0 transparent, 0px 0px 2px #888888;
	-webkit-box-shadow: inset 0px 1px 0px 0px #dedfdf; -moz-box-shadow: inset 0px 1px 0px 0px #dedfdf; -khtml-box-shadow: inset 0px 1px 0px 0px #dedfdf; box-shadow: inset 0px 1px 0px 0px #dedfdf;
	padding: 3px 8px;
	-webkit-border-radius: 3px; -moz-border-radius: 3px; -khtml-border-radius: 3px; border-radius: 3px;
}
.fgYellow
{
	background: #ecea28 !important;
	border: none !important;
	color: #242424 !important;
	font-weight: bold;
	text-shadow: 0 0 0 transparent, 0px 0px 2px #fffd4a;
	-webkit-box-shadow: inset 0px 1px 0px 0px #fffd60; -moz-box-shadow: inset 0px 1px 0px 0px #fffd60; -khtml-box-shadow: inset 0px 1px 0px 0px #fffd60; box-shadow: inset 0px 1px 0px 0px #fffd60;
	padding: 3px 8px;
	-webkit-border-radius: 3px; -moz-border-radius: 3px; -khtml-border-radius: 3px; border-radius: 3px;
}
.fgTeal
{
	background: #05cb95 !important;
	border: none !important;
	color: #373737 !important;
	font-weight: bold;
	text-shadow: 0 0 0 transparent, 0px 0px 2px #55facd;
	-webkit-box-shadow: inset 0px 1px 0px 0px #3ef7c5; -moz-box-shadow: inset 0px 1px 0px 0px #3ef7c5; -khtml-box-shadow: inset 0px 1px 0px 0px #3ef7c5; box-shadow: inset 0px 1px 0px 0px #3ef7c5;
	padding: 3px 8px;
	-webkit-border-radius: 3px; -moz-border-radius: 3px; -khtml-border-radius: 3px; border-radius: 3px;
}
html .userBanner.bannerStaff /* Styling for default staff banner */
{
	background: #AF0202;
	border: none;
	color: rgb(200,200,200);
	font-weight: bold;
	text-shadow: 0 0 0 transparent, 0px 0px 2px #000;
	-webkit-box-shadow: inset 0px 1px 0px 0px #DD0A0A; -moz-box-shadow: inset 0px 1px 0px 0px #DD0A0A; -khtml-box-shadow: inset 0px 1px 0px 0px #DD0A0A; box-shadow: inset 0px 1px 0px 0px #DD0A0A;
	-webkit-border-radius: 3px; -moz-border-radius: 3px; -khtml-border-radius: 3px; border-radius: 3px;
}
/*Taigachat fixes*/

#taigachat_box
{
	background-color: rgb(24, 24, 24) !important;
	color: #FFF !important;
}

#taigachat_box li
{
	background: rgb(24, 24, 24) !important;
}



.XenBase .pollResult .bar
{
	background-color: rgb(87, 87, 87);
}
.node .subForumList
{
	border-width: 0px;
}
.XenBase .mediaSmall ul
{
	margin-right: 0px;
	margin-top: 4px;
}
.XenBase .mediaSmall li .mediaContent
{
	margin: 5px;
}
.XenBase .conversation_view .messageList
{
	padding-right: 0px;
}
.bbCode > dl > dt, html .bbCode .title .option
{
	color: rgb(100,100,100);
}
.XenBase .bbCode dl dd
{
	background-color: rgb(18, 18, 18);
	border: 1px solid rgb(35, 35, 35);
}
.xenForm
{
	background-color: rgb(18, 18, 18);
	border: 1px solid rgb(35, 35, 35);
	-webkit-border-radius: 5px; -moz-border-radius: 5px; -khtml-border-radius: 5px; border-radius: 5px;
	padding: 10px;
}
.XenBase #calroot
{
	background-color: rgb(10, 10, 10);
	-webkit-box-shadow: none; -moz-box-shadow: none; -khtml-box-shadow: none; box-shadow: none;
}
.calweek a:hover, .calfocus
{
	background-color: rgb(24, 24, 24);
}
.searchResult
{
	border: 1px solid rgb(35, 35, 35);
	padding: 5px !important;
}
.formPopup .controlsWrapper
{
	background: rgb(10, 10, 10) !important;
}
.event
{
	padding-left: 10px !important;
}
.XenBase .messageSimple, html .page_section
{
	padding: 10px !important;
}

.message .menuIcon
{
	color: rgb(166, 166, 166);
}
.attachment .boxModelFixer
{
	background: rgb(24, 24, 24);
}
.navigationSideBar .heading
{
	color: rgb(150,150,150);
}

/*START RESOURCE MANAGER STYLING*/
.imageCollection
{
	background: rgb(15, 15, 15) !important;
}
.imageCollection li
{
	background: rgb(10, 10, 10) !important;
}
.resourceInfo
{
	margin-top: 10px;
}
.downloadButton
{
	width: auto !important;
}
/*END RESOURCE MANAGER STYLING*/

.XenBase .container .xengallerySideBar .section h3 a
{
	color: rgb(255, 255, 255);
}
.pollBlock .pollContent .questionMark, html .pollBlock .question .questionText
{
	color: rgb(200,200,200);
}
.breadcrumb .crust a.crumb:after
{
	content: "/";
	font-weight: bold;
	position: absolute;
	top: -1px;
	right: -2px;
}
.PopupOpen .xbTabPopupArrow .arrow {
    -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    border-color:  rgb(31, 31, 31) rgb(0, 0, 0); border-color:  rgb(31, 31, 31) rgba(0, 0, 0, 0); _border-color:  rgb(31, 31, 31) rgb(0, 0, 0);
    border-image: none;
    border-style: none solid solid;
    border-width: 1px 10px 10px;
    display: block;
    height: 0;
    line-height: 0;
    margin-top: -10px;
    position: absolute;
    width: 0;
    top: 32px;
    left: 32px;
}
.XenBase #caltitle, .XenBase #caldays span, .XenBase #calcurrent
{
	color: rgb(200,200,200);
}

#QuickSearch
{
	top: -11.5px;
}


@media (max-width:480px)
{
	.Responsive .messageUserBlock { background-color: #101010; text-align: left; }
	.messageList .message { padding: 3px; }
	.Responsive .message .messageInfo { border-width: 0; }
	.messageUserBlock .userText .userBanner { display: none; }
}


.xenOverlay a.close:before, #redactor_modal_close:before
{
	content: "\f057";
	display: inline-block;
	font-family: FontAwesome;
	font-style: normal;
	font-weight: normal;
	color: rgb(87, 87, 87);
	position: relative;
	top: -6px;
	right: 1px;
}







#logoBlock img
{
	max-height: 209px;
}
.pollBlock { margin-right: 5px; }



.xbMaxwidth
{
	max-width: 1190px;
	margin: 0 auto;
}
.Menu .xbMaxwidth
{
	max-width: 100%;
}


/* === Login CSS === */
	

#xb_eAuthUnit li
{
	margin-top: 5px;
}



/* === Misc Pages === */
.XenBase .news_feed_page_global .eventList:first-of-type, .XenBase .messageSimpleList.topBorder
{
	border-top-color: rgb(35, 35, 35);
}
.help_bb_codes .bbCode > dl > dd, .smilieList .smilieText, .smilieList .smilieText:hover
{
		
}
.titleBar
{
	margin: 8px;

}
.textCtrl .arrowWidget:before
{
	font-size: 16px;
}
.XenBase .navigationSideBar a
{
	border-bottom-color: rgb(35, 35, 35);
	
}
.XenBase .navigationSideBar a:hover
{
	color: rgb(166, 166, 166);
background: rgb(29, 29, 29) none;
	
}
.sharePage .textHeading
{
        color: rgb(228, 137, 27);

}

.profilePage .textWithCount.subHeading .text
{
        color: rgb(255, 255, 255);

}
.profilePage .textWithCount.subHeading .count
{
        color: rgb(255, 255, 255);

}
.XenBase .mediaContainer .statsSection, .XenBase .mediaContainer .statsSection i, .XenBase .mediaLabel.labelStandard
{
	color: rgb(100,100,100);
}




.displaynone
{
	visibility: hidden;
}

/* MAGICAL WONDERFUL BREADCRUMB */
.pageContent .breadcrumb .crust .arrow, .pageContent .breadcrumb .crust .arrow span
{
	border-top-width: 15px;
	border-bottom-width: 15px;
	border-left-width: 8px;
}
.pageContent .breadcrumb .crust .arrow
{
	right: -8px;
}
.pageContent .breadcrumb
{
	height: 30px;
}
.pageContent .breadcrumb .crust a.crumb
{
	line-height: 30px;
}
.pageContent .breadcrumb .crust .arrow span
{
	top: -15px;
	left: -9px;
}
.pageContent .breadcrumb.showAll
{
	height: auto;
}



/* Magical Page Nav */
.PageNav a, .PageNav .pageNavHeader
{
	height: 20px;
	line-height: 20px;
}
.PageNav .scrollable
{
	height: 22px;
}







.profilePostListItem
{
	border-top: 1px solid rgb(35, 35, 35);
}
.xenForm .ctrlUnit
{
	padding-top: 10px;
}
.breadBoxTop 
{
	
}
.breadBoxBottom
{
	
}
.XenBase .messageSimple, .XenBase .profilePage .eventList li, .XenBase .searchResult
{
	
}
.nodeList .categoryStrip .nodeTitle a, .navTabs .navTab .navLink, .sidebar .section .primaryContent h3 a, .profilePage .mast .section.infoBlock h3, .sidebar .section .primaryContent h3, .sidebar .section .secondaryContent h3, .sidebar .section .secondaryContent h3 a,
 .discussionList .sectionHeaders a, .discussionList .sectionHeaders a span, a.callToAction span, #SignupButton .inner
{
	text-transform: uppercase;
letter-spacing: 1px;

}
.XenBase .discussionListItem .noteRow
{
	color: rgb(166, 166, 166);
}


.account_two_step_enable .xenForm canvas
{
	background-color: rgb(142, 142, 142);
	padding: 5px;
}





.search_form .xenForm, .search_form_post .xenForm, .search_form_profile_post .xenForm,
.search_form_resource_update .xenForm, .tag_search .xenForm, .xengallery_search_form_media .xenForm,
.nflj_showcase_search_form .xenForm, .nflj_sportsbook_search_form .xenForm
{
	background-color: rgb(20, 20, 20);
padding: 10px;
border: 1px solid rgb(31, 31, 31);
-webkit-border-radius: 5px; -moz-border-radius: 5px; -khtml-border-radius: 5px; border-radius: 5px;

}


.topCtrl.xbTopCtrl
{
	display: block;
	float: none;
	margin-bottom: 10px;
	text-align: right;
}
.sectionMain.insideSidebar .sectionHeader
{
	color: rgb(100,100,100);
}

/* Responsive Settings */

@media (max-width:800px)
{
	
	
}
@media (max-width:800px)
{
	
}
@media (max-width:610px)
{
	.XenBase .visitorTabs .navLink .miniMe
	{
		
		margin: 0;
	}
	
	.navLink .accountUsername .xbVisitorText
	{
		display: none;
	}
	#goTop
	{
		opacity: 0.5;
		right: 5%;
	}	
	
		
}

@media (max-width:480px)
{
	.Responsive .navigationSideBar .heading span:before
	{
		content: "\f0c9";
		font-family: FontAwesome;
		font-weight: normal;
		color: rgb(200,200,200);
		font-size: 14px;
	}
	.XenBase.Responsive .navigationSideBar .heading span
	{
		position: relative;
		top: -4px;
	}
	.XenBase .item.control.like:before 
	{
    		display: none;
	}
	.XenBase .item.control.reply:before 
	{
    		display: none;
	}
}


/* --- xb_footer_layouts.css --- */

.extraFooter
{
	font-size: 13px;
color: rgb(166, 166, 166);
background-color: rgb(15, 15, 15);
padding: 15px;
-webkit-border-top-left-radius: 0px; -moz-border-radius-topleft: 0px; -khtml-border-top-left-radius: 0px; border-top-left-radius: 0px;
-webkit-border-top-right-radius: 0px; -moz-border-radius-topright: 0px; -khtml-border-top-right-radius: 0px; border-top-right-radius: 0px;
-webkit-border-bottom-right-radius: 8px; -moz-border-radius-bottomright: 8px; -khtml-border-bottom-right-radius: 8px; border-bottom-right-radius: 8px;
-webkit-border-bottom-left-radius: 8px; -moz-border-radius-bottomleft: 8px; -khtml-border-bottom-left-radius: 8px; border-bottom-left-radius: 8px;
display: block;
overflow: hidden;

}
.footerBlockContainer
{
	display: table;
	-webkit-box-sizing: border-box; -moz-box-sizing: border-box; -ms-box-sizing: border-box; box-sizing:border-box;
	width: 100%;
}
.footerBlock
{
	padding: 0px 20px;
display: table-cell;
-webkit-box-sizing: border-box; -moz-box-sizing: border-box; -ms-box-sizing: border-box; box-sizing: border-box;
vertical-align: top;

}
.footerBlockOne		{ width: 25%; }
.footerBlockTwo		{ width: 25%; }
.footerBlockThree	{ width: 25%; }
.footerBlockFour	{ width: 25%; }

.footerBlock p
{
	padding: 6px 0;
line-height: 1.7;

}
.footerBlockOne
{
	
}
.footerBlockTwo
{
	
}
.footerBlockThree
{
	
}
.footerBlockFour
{
	
}
.extraFooter h3
{
	font-size: 17px;
color: rgb(228, 137, 27);
margin: 0 auto 7px;
font-weight: 700;

}
.footerBlock ul.footerList li a
{
	color: rgb(200,200,200);
padding: 6px 0;
border-bottom: 1px dashed rgb(31, 31, 31);
display: block;

}
.footerBlock ul.footerList li:last-child a
{
	border-bottom-width: 0px;
}
.footerBlock ul.footerList li a:hover
{
	color: rgb(228, 137, 27);
text-decoration: none;

}
.footerBlock ul.footerList li .fa
{
	color: rgb(44, 44, 44);
margin-right: 5px;

}
.footer .pageContent
{
	-webkit-border-radius: 0; -moz-border-radius: 0; -khtml-border-radius: 0; border-radius: 0;
}

@media (max-width:800px)
{
	.extraFooter .footerBlock { width: 50%; text-align: center; display: block; float: left; }
}
@media (max-width:610px)
{
	.XenBase .extraFooter .footerBlock { width: 100% !important; display: block; float: none;}
}
@media (max-width:480px)
{

}

@media (max-width:610px)
{
	.Responsive .extraFooter { display: none; }
}


/* --- xb_offcanvas_menu.css --- */

.xbContentWrapper
{
	overflow: hidden;
	position: relative;
}
.xbOffCanvasList
{
	padding-bottom: 50px;
}
.xbOffCanvas, .XenBase #xbOffCanvasToggle, .XenBase .xbOffCanvasNew, .xbOffCanvasSubMenu
{
	display: none;
}

@media (max-width:800px)
{
	html, body
	{
		overflow: hidden;
	}
	.Responsive .xbOffCanvas 
	{
		background-color: rgb(15, 15, 15);
padding-bottom: 50px;
position: fixed;
top: 0;
z-index: 7600;
transition: all 0.2s ease-in-out;
overflow-y: auto;
display: block;
width: 250px;
height: 100%;

		left: -250px;
	}
	.Responsive .xbOffCanvas.xbOffCanvasOpen
	{
		transition: 300ms ease all;
		left: 0px;
	}
	.xbOffCanvasSubMenu .secondaryContent
	{
		background-color: transparent;
		border-width: 0;
		padding: 0;
	}
	.Responsive .selected .xbOffCanvasSubMenu
	{
		display: block;
	}
	.XenBase .navTab .xbOffCanvasArrow
	{
		color: rgb(255, 255, 255);
		float: right;
		font-size: 16px;
		padding: 0px 10px;
		position: relative;
		z-index: 1;
		display: block;
		cursor: pointer;
		height: 45px;
		line-height: 45px;
	}
	.Responsive .xbOffCanvas .navLink
	{
		font-family: 'Oswald', sans-serif;
color: rgb(224, 224, 224);
background-color: rgb(15, 15, 15);
padding: 0px 15px;
border-top:  1px solid rgb(0, 0, 0); border-top:  1px solid rgba(0, 0, 0, 0.18); _border-top:  1px solid rgb(0, 0, 0);
border-bottom:  1px solid rgb(255, 255, 255); border-bottom:  1px solid rgba(255, 255, 255, 0.08); _border-bottom:  1px solid rgb(255, 255, 255);
text-transform: uppercase;
line-height: 45px;
width: 100%;
height: 45px;

		display: block;
		-webkit-box-sizing: border-box; -moz-box-sizing: border-box; -ms-box-sizing: border-box; box-sizing: border-box;
	}
	.xbOffCanvas .xbOffCanvasSubMenu a
	{
		font-size: 12px;
color: rgb(244, 244, 244);
background-color: rgb(27, 27, 27);
padding: 10px;
border-bottom: 1px solid rgb(37, 36, 36);
-webkit-border-radius: 0px; -moz-border-radius: 0px; -khtml-border-radius: 0px; border-radius: 0px;

		display: block;
	}
	.navTab.selected .xbOffCanvasArrow .fa:before
	{
		content: "\f077";
	}
	#xbOffCanvasToggle .fa
	{
		font-size: 16px;
		position: relative;
		top: 1px;
	}
	.XenBase .xbOffCanvasNew .fa
	{
		font-size: 16px;
		margin-right: 5px;
	}
	.marginLeft #xbOffCanvasToggle .fa:before
	{
		content: "\f00d";
	}
	.xbOffCanvasMask
	{
		background-color: rgba(45, 45, 45, 0.6);
		cursor: pointer;
		display: none;
		height: 100%;
		left: 0;
		position: fixed;
		top: 0;
		width: 100%;
		z-index: 7500;
		overflow: hidden;
	}
	.XenBase .navTabs .publicTabs .navLink, .XenBase .navTabs .navTab .SplitCtrl
	{
		display: none;
	}
	
	.xbOffCanvasContainer 
	{
		overflow: hidden;
		transition: 300ms ease all;
		width: 100%;
	}
	.xbOffCanvasContainer.marginLeft
	{
		overflow-y: auto;
		position: relative;
		transition: 300ms ease all;
		margin-left: 250px;
	}
	
	.marginLeft
	{

	}
	 
	.xbOffCanvasControls
	{
		float: left;
	}	
	.XenBase #xbOffCanvasToggle, .XenBase .xbOffCanvasNew
	{
		cursor:pointer;
		padding:0px 10px;
		height: 30px;
		line-height: 30px;
		color: rgb(255, 255, 255);
		display: inline-block;
	}
	.xbOffCanvasMask.xbOffCanvasOpen
	{
		display: block;
	}
	.xbOffCanvas .navLink .itemCount
	{
		font-weight: bold;
		color: white;
		background-color: rgb(224, 48, 48);
		-webkit-border-radius: 3px; -moz-border-radius: 3px; -khtml-border-radius: 3px; border-radius: 3px;
		position: relative;
		line-height: 20px;
		padding: 0px 5px;
		display: inline-block;
		text-align: center;
		white-space: nowrap;
		word-wrap: normal;
		height: 20px;
		margin-left: 5px;
		font-size: 11px;
	}
	.xbOffCanvas .navLink .itemCount .arrow
	{
		display: none;
	}
}
@media (max-width:480px)
{
	.xbOffCanvasNew span { display: none; }
}

/* counteract the word-wrap setting in 'body' */
pre, textarea
{
	word-wrap: normal;
}

[dir=auto] { text-align: left; }



	
	.emCtrl,
	.messageContent a
	{
		-webkit-border-radius: 5px; -moz-border-radius: 5px; -khtml-border-radius: 5px; border-radius: 5px;
	}
	
		.emCtrl:hover,
		.emCtrl:focus,
		.ugc a:hover,
		.ugc a:focus
		{
			/*position: relative;
			top: -1px;*/
			text-decoration: none;
			-webkit-box-shadow: 5px 5px 7px #CCCCCC; -moz-box-shadow: 5px 5px 7px #CCCCCC; -khtml-box-shadow: 5px 5px 7px #CCCCCC; box-shadow: 5px 5px 7px #CCCCCC;
			outline: 0 none;
		}
		
			.emCtrl:active,
			.ugc a:active
			{
				position: relative;
				top: 1px;
				-webkit-box-shadow: 2px 2px 7px #CCCCCC; -moz-box-shadow: 2px 2px 7px #CCCCCC; -khtml-box-shadow: 2px 2px 7px #CCCCCC; box-shadow: 2px 2px 7px #CCCCCC;
				outline: 0 none;
			}

	.ugc a:link,
	.ugc a:visited
	{
		color: rgb(228, 137, 27);
padding: 0 3px;
margin: 0 -3px;
-webkit-border-radius: 5px; -moz-border-radius: 5px; -khtml-border-radius: 5px; border-radius: 5px;

	}
	
		.ugc a:hover,
		.ugc a:focus
		{
			color: rgb(255, 255, 255);
background: url(rgba.php?r=0&g=0&b=0&a=0) none; background: rgba(0, 0, 0, 0) none; _filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#00000000,endColorstr=#00000000);
-webkit-box-shadow: none; -moz-box-shadow: none; -khtml-box-shadow: none; box-shadow: none;

		}
		
img.mceSmilie,
img.mceSmilieSprite
{
	vertical-align: text-bottom;
	margin: 0 1px;
}
		
/** title bar **/

.titleBar
{
	margin-bottom: 10px;
}

/* clearfix */ .titleBar { zoom: 1; } .titleBar:after { content: '.'; display: block; height: 0; clear: both; visibility: hidden; }

.titleBar h1
{
	font-size: 18pt;
overflow: hidden;
zoom: 1;

}

	.titleBar h1 em
	{
		color: rgb(100,100,100);
	}
		
	.titleBar h1 .Popup
	{
		float: left;
	}

#pageDescription
{
	font-size: 12px;
color: rgb(150,150,150);
margin-top: 2px;

}

.topCtrl
{
	float: right;
}
	
	.topCtrl h2
	{
		font-size: 12pt;
	}
		
/** images **/

img
{
	-ms-interpolation-mode: bicubic;
}

a.avatar 
{ 
	*cursor: pointer; /* IE7 refuses to do this */ 
} 

.avatar img,
.avatar .img,
.avatarCropper
{
	background-color: rgb(11, 11, 11);
padding: 2px;
border: 1px solid rgb(31, 31, 31);
-webkit-border-radius: 3px; -moz-border-radius: 3px; -khtml-border-radius: 3px; border-radius: 3px;

}

.avatar.plainImage img,
.avatar.plainImage .img
{
	border: none;
	-webkit-border-radius: 0; -moz-border-radius: 0; -khtml-border-radius: 0; border-radius: 0;
	padding: 0;
	background-position: left top;
}

	.avatar .img
	{
		display: block;
		background-repeat: no-repeat;
		background-position: 2px 2px;
		text-indent: 1000px;
		overflow: hidden;
		white-space: nowrap;
		word-wrap: normal;
	}

	.avatar .img.s { width: 48px;  height: 48px;  }
	.avatar .img.m { width: 96px;  height: 96px;  }
	.avatar .img.l { width: 192px; height: 192px; }

.avatarCropper
{
	width: 192px;
	height: 192px;
	direction: ltr;
}

.avatarCropper a,
.avatarCropper span,
.avatarCropper label
{
	overflow: hidden;
	position: relative;
	display: block;
	width: 192px;
	height: 192px;
}

.avatarCropper img
{
	padding: 0;
	border: none;
	-webkit-border-radius: 0; -moz-border-radius: 0; -khtml-border-radius: 0; border-radius: 0;

	position: relative;
	display: block;
}

.avatarScaler img
{
	max-width: 192px;
	_width: 192px;
}

/* ***************************** */

.highlight { font-weight: bold; }

.concealed,
.concealed a,
.cloaked,
.cloaked a
{
	text-decoration: inherit !important;
	color: inherit !important;
	*clear:expression( style.color = parentNode.currentStyle.color, style.clear = "none", 0);
}

a.concealed:hover,
.concealed a:hover
{
	text-decoration: underline !important;
}

/* ***************************** */

.xenTooltip
{
	font-size: 12px;
color: rgb(255, 255, 255);
background: url(rgba.php?r=0&g=0&b=0&a=204); background: rgba(0, 0, 0, 0.8); _filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#CC000000,endColorstr=#CC000000);
padding: 5px 10px;
-webkit-border-radius: 5px; -moz-border-radius: 5px; -khtml-border-radius: 5px; border-radius: 5px;
display: none;
z-index: 15000;
cursor: default;

}

.xenTooltip a,
.xenTooltip a:hover
{
	color: rgb(255, 255, 255);
	text-decoration: underline;
}

	.xenTooltip .arrow
	{
		border-top:  6px solid rgb(0, 0, 0); border-top:  6px solid rgba(0, 0, 0, 0.8); _border-top:  6px solid rgb(0, 0, 0);
border-right: 6px solid transparent;
border-bottom: 1px none black;
border-left: 6px solid transparent;
position: absolute;
bottom: -6px;
line-height: 0px;
width: 0px;
height: 0px;

		left: 9px;
		
		/* Hide from IE6 */
		_display: none;
	}

	.xenTooltip.flipped .arrow
	{
		left: auto;
		right: 9px;
	}

.xenTooltip.statusTip
{
	/* Generated by XenForo.StatusTooltip JavaScript */
	padding: 5px 10px;
line-height: 17px;
width: 250px;
height: auto;

}

	.xenTooltip.statusTip .arrow
	{
		border: 6px solid transparent;
border-right-color:  rgb(0, 0, 0); border-right-color:  rgba(0, 0, 0, 0.8); _border-right-color:  rgb(0, 0, 0);
border-left: 1px none black;
top: 6px;
left: -6px;
bottom: auto;
right: auto;

	}
			
.xenTooltip.iconTip { margin-left: -6px; }
.xenTooltip.iconTip.flipped { margin-left: 7px; }

/* ***************************** */

#PreviewTooltip
{
	display: none;
}

.xenPreviewTooltip
{
	border: 10px solid rgb(10, 10, 10);
-webkit-border-radius: 10px; -moz-border-radius: 10px; -khtml-border-radius: 10px; border-radius: 10px;
position: relative;
-webkit-box-shadow: 0px 12px 25px rgba(0,0,0, 0.5); -moz-box-shadow: 0px 12px 25px rgba(0,0,0, 0.5); -khtml-box-shadow: 0px 12px 25px rgba(0,0,0, 0.5); box-shadow: 0px 12px 25px rgba(0,0,0, 0.5);
width: 400px;

	
	display: none;	
	z-index: 15000;
	cursor: default;
	
	border-color:  rgb(10, 10, 10); border-color:  rgba(10, 10, 10, 0.5); _border-color:  rgb(10, 10, 10);
}

	.xenPreviewTooltip .arrow
	{
		border-top:  15px solid rgb(3,42,70); border-top:  15px solid rgba(3,42,70, 0.25); _border-top:  15px solid rgb(3,42,70);
border-right: 15px solid transparent;
border-bottom: 1px none black;
border-left: 15px solid transparent;
position: absolute;
bottom: -15px;
left: 22px;

		
		_display: none;
	}
	
		.xenPreviewTooltip .arrow span
		{
			border-top: 15px solid rgb(20, 20, 20);
border-right: 15px solid transparent;
border-bottom: 1px none black;
border-left: 15px solid transparent;
position: absolute;
top: -17px;
left: -15px;

		}

	.xenPreviewTooltip .section,
	.xenPreviewTooltip .sectionMain,
	.xenPreviewTooltip .primaryContent,
	.xenPreviewTooltip .secondaryContent
	{
		margin: 0;
	}
	
		.xenPreviewTooltip .previewContent
		{
			overflow: hidden; zoom: 1;
			min-height: 1em;
		}

/* ***************************** */

.importantMessage
{
	margin: 10px 0;
	color: rgb(27, 27, 27);
	background-color: rgb(43, 43, 43);
	text-align: center;
	padding: 5px;
	-webkit-border-radius: 5px; -moz-border-radius: 5px; -khtml-border-radius: 5px; border-radius: 5px;
	border: solid 1px rgb(23, 23, 23);
}

.importantMessage a
{
	font-weight: bold;
	color: rgb(27, 27, 27);
}

/* ***************************** */

.section
{
	margin: 10px auto;

}

.sectionMain
{
	background-color: rgb(11, 11, 11);
padding: 10px;
margin: 10px auto;
border: 1px solid rgb(31, 31, 31);
-webkit-border-radius: 5px; -moz-border-radius: 5px; -khtml-border-radius: 5px; border-radius: 5px;

}

.heading,
.xenForm .formHeader
{
	font-weight: bold;
font-size: 16px;
color: rgb(200,200,200);
background-color: rgb(36, 36, 36);
padding: 5px 10px;
margin-bottom: 3px;
border-bottom: 1px solid rgb(24, 24, 24);
-webkit-border-top-left-radius: 5px; -moz-border-radius-topleft: 5px; -khtml-border-top-left-radius: 5px; border-top-left-radius: 5px;
-webkit-border-top-right-radius: 5px; -moz-border-radius-topright: 5px; -khtml-border-top-right-radius: 5px; border-top-right-radius: 5px;

}

	.heading a { color: rgb(200,200,200); }

.subHeading
{
	font-size: 14px !important;
font-family: 'Oswald', sans-serif;
color: rgb(255, 255, 255);
background: rgb(87, 87, 87) url('../images/gradient.png') repeat-x;
padding: 9px 10px;
margin: 3px auto 0;

}

	.subHeading a { color: rgb(255, 255, 255); }

.textHeading,
.xenForm .sectionHeader
{
	font-weight: bold;
color: rgb(166, 166, 166);
padding-bottom: 2px;
margin: 10px auto 5px;
border-bottom: 1px solid rgb(35, 35, 35);

}

.xenForm .sectionHeader,
.xenForm .formHeader
{
	margin: 10px 0;
}

.primaryContent > .textHeading:first-child,
.secondaryContent > .textHeading:first-child
{
	margin-top: 0;
}

.larger.textHeading,
.xenForm .sectionHeader
{
	color: rgb(67, 67, 67);
	font-size: 11pt;
	margin-bottom: 6px;
}

	.larger.textHeading a,
	.xenForm .sectionHeader a
	{
		color: rgb(67, 67, 67);
	}

.primaryContent
{
	background-color: rgb(20, 20, 20);
padding: 10px;
border-bottom: 1px solid rgb(31, 31, 31);

}

	.primaryContent a
	{
		color: rgb(228, 137, 27);

	}

.secondaryContent
{
	background-color: rgb(18, 18, 18);
padding: 10px;
border-bottom: 1px solid rgb(35, 35, 35);

}

	.secondaryContent a
	{
		color: rgb(228, 137, 27);

	}

.sectionFooter
{
	overflow: hidden; zoom: 1;
	font-size: 12px;
color: rgb(166, 166, 166);
background-color: rgb(20, 20, 20);
padding: 8px 10px;
border-bottom: 1px solid rgb(31, 31, 31);
line-height: 16px;

}

	.sectionFooter a { color: rgb(166, 166, 166); }

	.sectionFooter .left
	{
		float: left;
	}

	.sectionFooter .right
	{
		float: right;
	}

/* used for section footers with central buttons, esp. in report viewing */

.actionList
{
	text-align: center;
}

/* left-right aligned options */

.opposedOptions
{
	overflow: hidden; zoom: 1;
}
	
	.opposedOptions .left
	{
		float: left;
	}
	
	.opposedOptions .right
	{
		float: right;
	}

.columns
{
	overflow: hidden; zoom: 1;
}

	.columns .columnContainer
	{
		float: left;
	}
	
		.columns .columnContainer .column
		{
			margin-left: 3px;
		}
		
		.columns .columnContainer:first-child .column
		{
			margin-left: 0;
		}

.c50_50 .c1,
.c50_50 .c2 { width: 49.99%; }

.c70_30 .c1 { width: 70%; }
.c70_30 .c2 { width: 29.99%; }

.c60_40 .c1 { width: 60%; }
.c60_40 .c2 { width: 39.99%; }

.c40_30_30 .c1 { width: 40%; }
.c40_30_30 .c2,
.c40_30_30 .c3 { width: 29.99%; }

.c50_25_25 .c1 { width: 50%; }
.c50_25_25 .c2,
.c50_25_25 .c3 { width: 25%; }

/* ***************************** */
/* Basic Tabs */

.tabs
{
	font-size: 12px;
padding: 0 10px;
border-bottom: 1px solid rgb(31, 31, 31);
word-wrap: normal;
min-height: 23px;
_height: 23px;

	
	display: table;
	width: 100%;
	*width: auto;
	-webkit-box-sizing: border-box; -moz-box-sizing: border-box; -ms-box-sizing: border-box; box-sizing: border-box;
}

.tabs li
{
	float: left;
}

.tabs li a,
.tabs.noLinks li
{
	color: rgb(255, 255, 255);
text-decoration: none;
background-color: rgb(20, 20, 20);
padding: 0 8px;
margin-right: -1px;
margin-bottom: -1px;
border: 1px solid rgb(35, 35, 35);
-webkit-border-top-left-radius: 3px; -moz-border-radius-topleft: 3px; -khtml-border-top-left-radius: 3px; border-top-left-radius: 3px;
-webkit-border-top-right-radius: 3px; -moz-border-radius-topright: 3px; -khtml-border-top-right-radius: 3px; border-top-right-radius: 3px;
display: inline-block;
line-height: 30px;
cursor: pointer;
outline: 0 none;
white-space: nowrap;
word-wrap: normal;
height: 30px;

}

.tabs li:hover a,
.tabs.noLinks li:hover
{
	text-decoration: none;
background-color: rgb(44, 44, 44);
		
}

.tabs li.active a,
.tabs.noLinks li.active
{
	color: rgb(200,200,200);
background-color: rgb(11, 11, 11);
padding-bottom: 1px;
border-bottom: 1px none black;

}

/* Tabs inside forms */

.xenForm .tabs,
.xenFormTabs
{
	padding: 5px 30px 0;
}


@media (max-width:480px)
{
	.Responsive .tabs li
	{
		float: none;
	}

	.Responsive .tabs li a,
	.Responsive .tabs.noLinks li
	{
		display: block;
	}
	
	.Responsive .tabs
	{
		display: flex;
		display: -webkit-flex;
		flex-wrap: wrap;
		-webkit-flex-wrap: wrap;
	}
	
	.Responsive .tabs li
	{
		flex-grow: 1;
		-webkit-flex-grow: 1;
		text-align: center;
	}
	
	.Responsive .xenForm .tabs,
	.Responsive .xenFormTabs
	{
		padding-left: 10px;
		padding-right: 10px;
	}
}


/* ***************************** */
/* Popup Menus */

.Popup
{
	position: relative;
}

	.Popup.inline
	{
		display: inline;
	}
	
/** Popup menu trigger **/

.Popup .arrowWidget
{
	/* circle-arrow-down */
	color: rgb(166, 166, 166);
background-color: transparent;
margin-top: -2px;
margin-left: 2px;
display: inline-block;
*margin-top: 0;
vertical-align: middle;
width: 13px;
height: 14px;

}

.PopupOpen .arrowWidget
{
	/* circle-arrow-up */
	background-position: -48px 1px;

}

.Popup .PopupControl,
.Popup.PopupContainerControl
{
	display: inline-block;
	cursor: pointer;
}

	.Popup .PopupControl:hover,
	.Popup.PopupContainerControl:hover
	{
		color: rgb(87, 87, 87);
text-decoration: none;

	}

	.Popup .PopupControl:focus,
	.Popup .PopupControl:active,
	.Popup.PopupContainerControl:focus,
	.Popup.PopupContainerControl:active
	{
		outline: 0;
	}
	
	.Popup .PopupControl.PopupOpen,
	.Popup.PopupContainerControl.PopupOpen
	{
		color: rgb(228, 137, 27);
background-color: rgb(31, 31, 31);
-webkit-border-top-left-radius: 3px; -moz-border-radius-topleft: 3px; -khtml-border-top-left-radius: 3px; border-top-left-radius: 3px;
-webkit-border-top-right-radius: 3px; -moz-border-radius-topright: 3px; -khtml-border-top-right-radius: 3px; border-top-right-radius: 3px;
-webkit-border-bottom-right-radius: 0px; -moz-border-radius-bottomright: 0px; -khtml-border-bottom-right-radius: 0px; border-bottom-right-radius: 0px;
-webkit-border-bottom-left-radius: 0px; -moz-border-radius-bottomleft: 0px; -khtml-border-bottom-left-radius: 0px; border-bottom-left-radius: 0px;

	}
	
	.Popup .PopupControl.BottomControl.PopupOpen,
	.Popup.PopupContainerControl.BottomControl.PopupOpen
	{
		-webkit-border-top-left-radius: 0px; -moz-border-radius-topleft: 0px; -khtml-border-top-left-radius: 0px; border-top-left-radius: 0px;
		-webkit-border-top-right-radius: 0px; -moz-border-radius-topright: 0px; -khtml-border-top-right-radius: 0px; border-top-right-radius: 0px;
		-webkit-border-bottom-left-radius: 3px; -moz-border-radius-bottomleft: 3px; -khtml-border-bottom-left-radius: 3px; border-bottom-left-radius: 3px;
		-webkit-border-bottom-right-radius: 3px; -moz-border-radius-bottomright: 3px; -khtml-border-bottom-right-radius: 3px; border-bottom-right-radius: 3px;
	}
		
		.Popup .PopupControl.PopupOpen:hover,
		.Popup.PopupContainerControl.PopupOpen:hover
		{
			text-decoration: none;
		}
		
/** Menu body **/

.Menu
{
	/*background-color: rgb(18, 18, 18);*/
	
	font-size: 12px;
background-color: rgb(11, 11, 11);
border: 1px solid rgb(31, 31, 31);
border-top-width: 5px;
overflow: hidden;
-webkit-box-shadow: 0px 5px 5px rgba(0,0,0, 0.5); -moz-box-shadow: 0px 5px 5px rgba(0,0,0, 0.5); -khtml-box-shadow: 0px 5px 5px rgba(0,0,0, 0.5); box-shadow: 0px 5px 5px rgba(0,0,0, 0.5);

	
	min-width: 200px;
	*width: 200px;
	
	/* makes menus actually work... */
	position: absolute;
	z-index: 7500;
	display: none;
}

/* allow menus to operate when JS is disabled */
.Popup:hover .Menu
{
	display: block;
}

.Popup:hover .Menu.JsOnly
{
	display: none;
}

.Menu.BottomControl
{
	border-top-width: 1px;
	border-bottom-width: 3px;
	-webkit-box-shadow: 0px 0px 0px transparent; -moz-box-shadow: 0px 0px 0px transparent; -khtml-box-shadow: 0px 0px 0px transparent; box-shadow: 0px 0px 0px transparent;
}

	.Menu > li > a,
	.Menu .menuRow
	{
		display: block;
	}
	
.Menu.inOverlay
{
	z-index: 10000;
}
		
/* Menu header */

.Menu .menuHeader
{
	overflow: hidden; zoom: 1;
}

.Menu .menuHeader h3
{
	font-size: 16px;

}

.Menu .menuHeader .muted
{
	font-size: 12px;

}

/* Standard menu sections */

.Menu .primaryContent
{
	background-color: rgba(20, 20, 20, 0.96);
}

.Menu .secondaryContent
{
	background-color: rgba(18, 18, 18, 0.96);
}

.Menu .sectionFooter
{
	background-color: rgba(20, 20, 20, 0.9);
}

/* Links lists */

.Menu .blockLinksList
{	
	max-height: 400px;
	overflow: auto;
}

/* form popups */

.formPopup
{
	width: 250px;
	background-color: rgb(11, 11, 11);
}

	.formPopup form,
	.formPopup .ctrlUnit
	{
		margin: 5px auto;
	}
	
		.formPopup .ctrlUnit
		{
		}
		
	.formPopup .textCtrl,
	.formPopup
	{
		width: 232px;
	}
		
	.formPopup .ctrlUnit > dt label
	{
		display: block;
		margin-bottom: 2px;
	}
		
	.formPopup .submitUnit dd
	{
		text-align: center;
	}
	
		.formPopup .ctrlUnit > dd .explain
		{
			margin: 2px 0 0;
		}
	
	.formPopup .primaryControls
	{
		zoom: 1;
		white-space: nowrap;
		word-wrap: normal;
		padding: 0 5px;
	}
	
		.formPopup .primaryControls input.textCtrl
		{
			margin-bottom: 0;
		}
	
	.formPopup .secondaryControls
	{
		padding: 0 5px;
	}
	
		.formPopup .controlsWrapper
		{
			background-color: rgb(69, 69, 69);
			-webkit-border-radius: 5px; -moz-border-radius: 5px; -khtml-border-radius: 5px; border-radius: 5px;
			padding: 5px;
			margin: 5px 0;
			font-size: 11px;
		}

			.formPopup .controlsWrapper .textCtrl
			{
				width: 222px;
			}
	
	.formPopup .advSearchLink
	{
		display: block;
		text-align: center;
		padding: 5px;
		font-size: 11px;
		-webkit-border-radius: 5px; -moz-border-radius: 5px; -khtml-border-radius: 5px; border-radius: 5px;
		border: 1px solid rgb(69, 69, 69);
		background-color: rgb(78, 78, 78);
	}
	
		.formPopup .advSearchLink:hover
		{
			background-color: rgb(69, 69, 69);
			text-decoration: none;
		}

/* All overlays must have this */
.xenOverlay
{
	display: none;
	z-index: 10000;
	width: 90%;
	-webkit-box-sizing: border-box; -moz-box-sizing: border-box; -ms-box-sizing: border-box; box-sizing: border-box;
	max-width: 690px; /*calc: 90=overlay padding+borders*/
}

	.xenOverlay .overlayScroll
	{
		max-height: 400px;
		overflow: auto;
	}
	
	.xenOverlay .overlayScroll.ltr
	{
		direction: ltr;
	}
	
	.xenOverlay .overlayScroll .sortable-placeholder
	{
		background-color: rgb(67, 67, 67);
	}
	
	.xenOverlay .overlayContain
	{
		overflow-x: auto;
	}
	
	.xenOverlay .overlayContain.ltr
	{
		direction: ltr;
	}

.overlayOnly /* needs a bit more specificity over regular buttons */
{
	display: none !important;
}

	.xenOverlay .overlayOnly
	{
		display: block !important;
	}
	
	.xenOverlay input.overlayOnly,
	.xenOverlay .overlayOnly,
	.xenOverlay a.overlayOnly
	{
		display: inline !important;
	}
	
	.xenOverlay a.close 
	{
		font-size: 23px;
color: rgb(87, 87, 87);
position: absolute;
right: 4px;
top: 4px;
cursor: pointer;
text-indent: 0;
text-align: center;
width: 25px;
height: 25px;

	}
	
.xenOverlay .nonOverlayOnly
{
	display: none !important;
}

/* Generic form overlays */

.xenOverlay .formOverlay
{
	color: #eee;
background: url(rgba.php?r=0&g=0&b=0&a=191); background: rgba(0,0,0, 0.75); _filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#BF000000,endColorstr=#BF000000);
padding: 15px 25px;
border:  20px solid rgb(0,0,0); border:  20px solid rgba(0,0,0, 0.25); _border:  20px solid rgb(0,0,0);
-webkit-border-radius: 20px; -moz-border-radius: 20px; -khtml-border-radius: 20px; border-radius: 20px;
-webkit-box-shadow: 0px 25px 50px rgba(0,0,0, 0.5); -moz-box-shadow: 0px 25px 50px rgba(0,0,0, 0.5); -khtml-box-shadow: 0px 25px 50px rgba(0,0,0, 0.5); box-shadow: 0px 25px 50px rgba(0,0,0, 0.5);
_zoom: 1;

	margin: 0;
}

	.Touch .xenOverlay .formOverlay
	{
		background: rgb(0, 0, 0);
		-webkit-box-shadow: none; -moz-box-shadow: none; -khtml-box-shadow: none; box-shadow: none;
	}

	.xenOverlay .formOverlay a.muted,
	.xenOverlay .formOverlay .muted a
	{
		color: rgb(150,150,150);
	}

	.xenOverlay .formOverlay .heading
	{
		font-weight: bold;
font-size: 14px;
color: rgb(200,200,200);
background-color: rgb(24, 24, 24);
padding: 5px 10px;
margin-bottom: 10px;
border: 1px solid rgb(15, 15, 15);
-webkit-border-radius: 5px; -moz-border-radius: 5px; -khtml-border-radius: 5px; border-radius: 5px;

	}

	.xenOverlay .formOverlay .subHeading
	{
		font-weight: bold;
font-size: 12px;
color: rgb(200,200,200);
background-color: rgb(15, 15, 15);
padding: 5px 10px;
margin-bottom: 10px;
border: 1px solid rgb(24, 24, 24);
-webkit-border-radius: 3px; -moz-border-radius: 3px; -khtml-border-radius: 3px; border-radius: 3px;

	}
	
	.xenOverlay .formOverlay .textHeading
	{
		color: rgb(166, 166, 166);

	}
	
	.xenOverlay .formOverlay > p
	{
		padding-left: 10px;
		padding-right: 10px;
	}

	.xenOverlay .formOverlay .textCtrl
	{
		color: rgb(166, 166, 166);
background-color: black;
border-color: rgb(67, 67, 67);

	}

	.xenOverlay .formOverlay .textCtrl option
	{
		background-color: black;
	}

	.xenOverlay .formOverlay .textCtrl:focus,
	.xenOverlay .formOverlay .textCtrl.Focus
	{
		background: rgb(10, 10, 10) none;

	}

	.xenOverlay .formOverlay .textCtrl:focus option
	{
		background: rgb(10, 10, 10) none;
	}

	.xenOverlay .formOverlay .textCtrl.disabled
	{
		background: url(rgba.php?r=0&g=0&b=0&a=63); background: rgba(0,0,0, 0.25); _filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#3F000000,endColorstr=#3F000000);

	}

	.xenOverlay .formOverlay .textCtrl.disabled option
	{
		background: url(rgba.php?r=0&g=0&b=0&a=63); background: rgba(0,0,0, 0.25); _filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#3F000000,endColorstr=#3F000000);
	}

	.xenOverlay .formOverlay .textCtrl.prompt
	{
		color: rgb(160,160,160);

	}

	.xenOverlay .formOverlay .ctrlUnit > dt dfn,
	.xenOverlay .formOverlay .ctrlUnit > dd li .hint,
	.xenOverlay .formOverlay .ctrlUnit > dd .explain
	{
		color: #bbb;

	}

	.xenOverlay .formOverlay a
	{
		color: #fff;

	}

		.xenOverlay .formOverlay
		{
			
		}

	.xenOverlay .formOverlay .avatar img,
	.xenOverlay .formOverlay .avatar .img,
	.xenOverlay .formOverlay .avatarCropper
	{
		background-color: transparent;
	}
	
	/* tabs in form overlay */
	
	.xenOverlay .formOverlay .tabs /* the actual tabs */
	{
		background: transparent none;
border-color: rgb(67, 67, 67);

	}

		.xenOverlay .formOverlay .tabs a
		{
			background: transparent none;
border-color: rgb(67, 67, 67);

		}
		
			.xenOverlay .formOverlay .tabs a:hover
			{
				background: url(rgba.php?r=255&g=255&b=255&a=63); background: rgba(255,255,255, 0.25); _filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#3FFFFFFF,endColorstr=#3FFFFFFF);

			}
			
			.xenOverlay .formOverlay .tabs .active a
			{
				background-color: black;

			}
			
	.xenOverlay .formOverlay .tabPanel /* panels switched with the tab controls */
	{
		background: transparent url('styles/fusiongamer/xenforo/color-picker/panel.png') repeat-x top;
border: 1px solid rgb(67, 67, 67);

	}


/* Generic overlays */

.xenOverlay .section,
.xenOverlay .sectionMain
{
	padding: 0px;
border: 20px solid rgb(10, 10, 10);
-webkit-border-radius: 10px; -moz-border-radius: 10px; -khtml-border-radius: 10px; border-radius: 10px;
-webkit-box-shadow: 0px 25px 50px rgba(0,0,0, 0.5); -moz-box-shadow: 0px 25px 50px rgba(0,0,0, 0.5); -khtml-box-shadow: 0px 25px 50px rgba(0,0,0, 0.5); box-shadow: 0px 25px 50px rgba(0,0,0, 0.5);

	
	border-color:  rgb(10, 10, 10); border-color:  rgba(10, 10, 10, 0.5); _border-color:  rgb(10, 10, 10);
}

	.Touch .xenOverlay .section,
	.Touch .xenOverlay .sectionMain
	{
		border-color: rgb(10, 10, 10);
		-webkit-box-shadow: none; -moz-box-shadow: none; -khtml-box-shadow: none; box-shadow: none;
	}

.xenOverlay > .section,
.xenOverlay > .sectionMain
{
	background: none;
	margin: 0;
}

	.xenOverlay .section .heading,
	.xenOverlay .sectionMain .heading
	{
		-webkit-border-radius: 0; -moz-border-radius: 0; -khtml-border-radius: 0; border-radius: 0;
		margin-bottom: 0;
	}

	.xenOverlay .section .subHeading,
	.xenOverlay .sectionMain .subHeading
	{
		margin-top: 0;
	}

	.xenOverlay .section .sectionFooter,
	.xenOverlay .sectionMain .sectionFooter
	{
		overflow: hidden; zoom: 1;
	}
		
		.xenOverlay .sectionFooter .buttonContainer
		{
			line-height: 31px;
		}
	
		.xenOverlay .sectionFooter,
		.xenOverlay .sectionFooter .buttonContainer
		{
			min-width: 75px;
			*min-width: 0;
			float: right;
			margin-left: 5px;
		}
		
			.xenOverlay .sectionFooter .buttonContainer
			{
				float: none;
				margin-left: 0;
			}

/* The AJAX progress indicator overlay */

#AjaxProgress.xenOverlay
{
	width: 100%;
	max-width: none;
	overflow: hidden; zoom: 1;
}

	#AjaxProgress.xenOverlay .content
	{
		background: rgb(0, 0, 0) url('styles/fusiongamer/xenforo/widgets/ajaxload.info_FFFFFF_facebook.gif') no-repeat center center; background: rgba(0,0,0, 0.5) url('styles/fusiongamer/xenforo/widgets/ajaxload.info_FFFFFF_facebook.gif') no-repeat center center;
-webkit-border-bottom-left-radius: 10px; -moz-border-radius-bottomleft: 10px; -khtml-border-bottom-left-radius: 10px; border-bottom-left-radius: 10px;
float: right;
width: 85px;
height: 30px;

	}
	
		.Touch #AjaxProgress.xenOverlay .content
		{
			background-color: rgb(0, 0, 0);
		}

/* Timed message for redirects */

.xenOverlay.timedMessage
{
	color: black;
background: transparent url('styles/fusiongamer/xenforo/overlay/timed-message.png') repeat-x;
border-bottom: 1px solid black;
max-width: none;
width: 100%;

}

	.xenOverlay.timedMessage .content
	{
		font-size: 18pt;
padding: 30px;
text-align: center;

	}
	
/* Growl-style message */

#StackAlerts
{
	position: fixed;
	bottom: 70px;
	left: 35px;
	z-index: 9999; /* in front of the expose mask */
}

	#StackAlerts .stackAlert
	{
		position: relative;
		width: 270px;
		border: 1px solid rgb(44, 44, 44);
		-webkit-border-radius: 5px; -moz-border-radius: 5px; -khtml-border-radius: 5px; border-radius: 5px;
		-webkit-box-shadow: 2px 2px 5px 0 rgba(0,0,0, 0.4); -moz-box-shadow: 2px 2px 5px 0 rgba(0,0,0, 0.4); -khtml-box-shadow: 2px 2px 5px 0 rgba(0,0,0, 0.4); box-shadow: 2px 2px 5px 0 rgba(0,0,0, 0.4);
		margin-top: 5px;
	}

		#StackAlerts .stackAlertContent
		{
			padding: 10px;
			padding-right: 30px;
			-webkit-border-radius: 4px; -moz-border-radius: 4px; -khtml-border-radius: 4px; border-radius: 4px;
			border: solid 2px rgb(69, 69, 69);
			background: url(rgba.php?r=78&g=78&b=78&a=229); background: rgba(78, 78, 78, 0.9); _filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#E54E4E4E,endColorstr=#E54E4E4E);
			font-size: 11px;
			font-weight: bold;
		}
	
/* Inline Editor */

.xenOverlay .section .messageContainer
{
	padding: 0;
}

.xenOverlay .section .messageContainer .mceLayout
{
	border: none;	
}

.xenOverlay .section .messageContainer tr.mceFirst td.mceFirst
{
	border-top: none;
}

.xenOverlay .section .messageContainer tr.mceLast td.mceLast,
.xenOverlay .section .messageContaner tr.mceLast td.mceIframeContainer
{
	border-bottom: none;
}

.xenOverlay .section .textCtrl.MessageEditor,
.xenOverlay .section .mceLayout,
.xenOverlay .section .bbCodeEditorContainer textarea
{
	width: 100% !important;
	min-height: 260px;
	_height: 260px;
	-webkit-box-sizing: border-box; -moz-box-sizing: border-box; -ms-box-sizing: border-box; box-sizing: border-box;
}


@media (max-width:610px)
{
	.Responsive .xenOverlay
	{
		width: 100%;
	}
	
	.Responsive .xenOverlay .formOverlay,
	.Responsive .xenOverlay .section,
	.Responsive .xenOverlay .sectionMain
	{
		-webkit-border-radius: 10px; -moz-border-radius: 10px; -khtml-border-radius: 10px; border-radius: 10px;
		border-width: 10px;
	}
	
	.Responsive .xenOverlay a.close 
	{
		top: 0;
		right: 0;
		width: 28px;
		height: 28px;
		background-size: 100% 100%;
	}
}


.alerts .alertGroup
{
	margin-bottom: 20px;
}

.alerts .primaryContent
{
	overflow: hidden; zoom: 1;
	padding: 5px;
}

.alerts .avatar
{
	float: left;
}

.alerts .avatar img
{
	width: 32px;
	height: 32px;
}

.alerts .alertText
{
	margin-left: 32px;
	padding: 0 5px;
}

.alerts h3
{
	display: inline;
}

.alerts h3 .subject
{
	font-weight: bold;
}

.alerts .timeRow
{
	font-size: 11px;
	margin-top: 5px;
}
	
	.alerts .newIcon,
	.alertsPopup .newIcon
	{
		display: inline-block;
		vertical-align: baseline;
		margin-left: 2px;
		width: 11px;
		height: 11px;
		background: url('styles/fusiongamer/xenforo/xenforo-ui-sprite.png') no-repeat -144px -40px;
	}

/** Data tables **/

.dataTableWrapper
{
	overflow-x: auto;
	overflow-y: visible;
}

table.dataTable
{
	width: 100%;
	_width: 99.5%;
	margin: 10px 0;
}

.dataTable caption
{
	font-weight: bold;
font-size: 16px;
color: rgb(200,200,200);
background-color: rgb(36, 36, 36);
padding: 5px 10px;
margin-bottom: 3px;
border-bottom: 1px solid rgb(24, 24, 24);
-webkit-border-top-left-radius: 5px; -moz-border-radius-topleft: 5px; -khtml-border-top-left-radius: 5px; border-top-left-radius: 5px;
-webkit-border-top-right-radius: 5px; -moz-border-radius-topright: 5px; -khtml-border-top-right-radius: 5px; border-top-right-radius: 5px;

}

.dataTable tr.dataRow td
{
	border-bottom: 1px solid rgb(69, 69, 69);
	padding: 5px 10px;
	word-wrap: break-word;
}

.dataTable tr.dataRow td.secondary
{
	background: rgb(78, 78, 78) url("styles/fusiongamer/xenforo/gradients/category-23px-light.png") repeat-x top;
}

.dataTable tr.dataRow th
{
	background: rgb(23, 23, 23) url("styles/fusiongamer/xenforo/gradients/category-23px-light.png") repeat-x top;
	border-bottom: 1px solid rgb(23, 23, 23);
	border-top: 1px solid rgb(23, 23, 23);
	color: rgb(27, 27, 27);
	font-size: 11px;
	padding: 5px 10px;
}

	.dataTable tr.dataRow th a
	{
		color: inherit;
		text-decoration: underline;
	}

.dataTable .dataRow .dataOptions
{
	text-align: right;
	white-space: nowrap;
	word-wrap: normal;
	padding: 0;
}

.dataTable .dataRow .important,
.dataTable .dataRow.important
{
	font-weight: bold;
}

.dataTable .dataRow .dataOptions a.secondaryContent
{
	display: inline-block;
	border-left: 1px solid rgb(69, 69, 69);
	border-bottom: none;
	padding: 7px 10px 6px;
	font-size: 11px;
}

	.dataTable .dataRow .dataOptions a.secondaryContent:hover
	{
		background-color: rgb(69, 69, 69);
		text-decoration: none;
	}

	.dataTable .dataRow .delete
	{
		padding: 0px;
		width: 26px;
		border-left: 1px solid rgb(69, 69, 69);
		background-color: rgb(18, 18, 18);
	}	
				
		.dataTable .dataRow .delete a
		{
			display: block;
			background: transparent url('styles/fusiongamer/xenforo/permissions/deny.png') no-repeat center center;
			cursor: pointer;
		
			padding: 5px;
			width: 16px;
			height: 16px;
			
			overflow: hidden;
			white-space: nowrap;
			text-indent: -1000px;
		}

.memberListItem
{
	overflow: hidden;
zoom: 1;

}

	.memberListItem .avatar,
	.memberListItem .icon
	{
		float: left;

	}
	
	/* ----------------------- */
	
	.memberListItem .extra
	{
		font-size: 12px;
float: right;

	}

		.memberListItem .extra .DateTime
		{
			display: block;
		}

		.memberListItem .extra .bigNumber
		{
			font-size: 250%;
			color: rgb(150,150,150);
		}
	
	.memberListItem .member
	{
		margin-left: 65px;

	}
	
	/* ----------------------- */
		
		.memberListItem h3.username
		{
			font-weight: bold;
font-size: 14px;
margin-bottom: 3px;

		}
			
		.memberListItem .username.guest
		{
			font-style: italic;
font-weight: normal;

		}
	
	/* ----------------------- */
		
		.memberListItem .userInfo
		{
			font-size: 12px;
margin-bottom: 3px;

		}
		
			.memberListItem .userBlurb
			{
			}
		
				.memberListItem .userBlurb .userTitle
				{
					font-weight: bold;

				}

			.memberListItem .userStats dt,
			.memberListItem .userStats dd
			{
				white-space: nowrap;
			}
				
	
	/* ----------------------- */
		
		.memberListItem .member .contentInfo
		{
			margin-top: 5px;

		}
	
	/* ----------------------- */
	
	
/* extended member list items have a fixed 200px right column */

.memberListItem.extended .extra
{
	width: 200px;
}

.memberListItem.extended .member
{
	margin-right: 210px;
}

/* Styling for hover-dismiss controls */

.DismissParent .DismissCtrl
{
	position: absolute;
	top: 12px;
	right: 5px;
	
	display: block;
	background: transparent url('styles/fusiongamer/xenforo/xenforo-ui-sprite.png') no-repeat -80px 0;
	color: white;
	width: 15px;
	height: 15px;
	line-height: 15px;
	text-align: center;
	
	opacity: .4;
	-webkit-transition: opacity 0.3s ease-in-out;
	-moz-transition: opacity 0.3s ease-in-out;
	transition: opacity 0.3s ease-in-out;
	
	font-size: 10px;
	
	overflow: hidden;
	white-space: nowrap;
	text-indent: 20000em;
	
	cursor: pointer;
}

	.DismissParent:hover .DismissCtrl,
	.Touch .DismissParent .DismissCtrl
	{
		opacity: 1;
	}
	
		.DismissParent:hover .DismissCtrl:hover
		{
			background-position: -96px 0;
		}
		
			.DismissParent:hover .DismissCtrl:active
			{
				background-position: -112px 0;
			}

/* ***************************** */
/* un-reset, mostly from YUI */

.baseHtml h1
	{ font-size:138.5%; } 
.baseHtml h2
	{ font-size:123.1%; }
.baseHtml h3
	{ font-size:108%; } 
.baseHtml h1, .baseHtml h2, .baseHtml h3
	{  margin:1em 0; } 
.baseHtml h1, .baseHtml h2, .baseHtml h3, .baseHtml h4, .baseHtml h5, .baseHtml h6, .baseHtml strong
	{ font-weight:bold; } 
.baseHtml abbr, .baseHtml acronym
	{ border-bottom:1px dotted #000; cursor:help; }  
.baseHtml em
	{  font-style:italic; } 
.baseHtml blockquote, .baseHtml ul, .baseHtml ol, .baseHtml dl
	{ margin:1em; } 
.baseHtml ol, .baseHtml ul, .baseHtml dl
	{ margin-left:3em; margin-right:0; } 
.baseHtml ul ul, .baseHtml ul ol, .baseHtml ul dl, .baseHtml ol ul, .baseHtml ol ol, .baseHtml ol dl, .baseHtml dl ul, .baseHtml dl ol, .baseHtml dl dl
	{ margin-top:0; margin-bottom:0; }
.baseHtml ol li
	{ list-style: decimal outside; } 
.baseHtml ul li
	{ list-style: disc outside; } 
.baseHtml ol ul li, .baseHtml ul ul li
	{ list-style-type: circle; }
.baseHtml ol ol ul li, .baseHtml ol ul ul li, .baseHtml ul ol ul li, .baseHtml ul ul ul li
	{ list-style-type: square; }
.baseHtml ul ol li, .baseHtml ul ol ol li, .baseHtml ol ul ol li
	{ list-style: decimal outside; }
.baseHtml dl dd
	{ margin-left:1em; } 
.baseHtml th, .baseHtml td
	{ border:1px solid #000; padding:.5em; } 
.baseHtml th
	{ font-weight:bold; text-align:center; } 
.baseHtml caption
	{ margin-bottom:.5em; text-align:center; } 
.baseHtml p, .baseHtml pre, .baseHtml fieldset, .baseHtml table
	{ margin-bottom:1em; }

.PageNav
{
	font-size: 12px;
padding: 2px 0;
overflow: hidden;
zoom: 1;
line-height: 16px;
word-wrap: normal;
min-width: 150px;
white-space: nowrap;

	
	margin-bottom: -.5em;
}

	.PageNav .hidden
	{
		display: none;
	}
	
	.PageNav .pageNavHeader,
	.PageNav a,
	.PageNav .scrollable
	{
		display: block;
		float: left;
		margin-right: 3px;
		margin-bottom: .5em;
	}
	
	.PageNav .pageNavHeader
	{
		padding: 1px 0;
	}

	.PageNav a
	{		
		color: rgb(166, 166, 166);
text-decoration: none;
background-color: rgb(23, 23, 23);
border: 1px solid rgb(43, 43, 43);
-webkit-border-radius: 3px; -moz-border-radius: 3px; -khtml-border-radius: 3px; border-radius: 3px;
text-align: center;

		
		
		width: 19px;
	}
		
		.PageNav a[rel=start]
		{
			width: 19px !important;
		}

		.PageNav a.text
		{
			width: auto !important;
			padding: 0 4px;
		}
			
		.PageNav a.currentPage
		{
			color: rgb(255, 255, 255);
background-color: rgb(87, 87, 87);
border-color: rgb(87, 87, 87);
position: relative;

		}

		a.PageNavPrev,
		a.PageNavNext
		{
			color: rgb(166, 166, 166);
background-color: transparent;
padding: 1px;
border: 1px none black;
cursor: pointer;

			
			width: 19px !important;
		}
		
		.PageNav a:hover,
		.PageNav a:focus
		{
			color: rgb(255, 255, 255);
text-decoration: none;
background-color: rgb(228, 137, 27);
border-color: rgb(228, 137, 27);

		}
		
	.PageNav a.distinct
	{
		margin-left: 3px;
	}
			
	.PageNav .scrollable
	{
		position: relative;
		overflow: hidden;
		width: 117px; /* width of 5 page numbers plus their margin & border */
		height: 18px; /* only needs to be approximate */
	}
	
		.PageNav .scrollable .items
		{
			display: block;
			width: 20000em; /* contains scrolling items, should be huge */
			position: absolute;
			display: block;
		}
		
/** Edge cases - large numbers of digits **/

.PageNav .gt999 
{
	font-size: 9px;
	letter-spacing: -0.05em; 
}

.PageNav.pn5 a { width: 29px; } .PageNav.pn5 .scrollable { width: 167px; }
.PageNav.pn6 a { width: 33px; } .PageNav.pn6 .scrollable { width: 187px; }
.PageNav.pn7 a { width: 37px; } .PageNav.pn7 .scrollable { width: 207px; }


@media (max-width:610px)
{
	.Responsive .PageNav .pageNavHeader
	{
		display: none;
	}
}

@media (max-width:480px)
{
	.Responsive .PageNav .unreadLink
	{
		display: none;
	}
}


/* ***************************** */
/* DL Name-Value Pairs */

.pairs dt,
.pairsInline dt,
.pairsRows dt,
.pairsColumns dt,
.pairsJustified dt
{
	color: rgb(150,150,150);
}

.pairsRows,
.pairsColumns,
.pairsJustified
{
	line-height: 1.5;
}

.pairsInline dl,
.pairsInline dt,
.pairsInline dd
{
	display: inline;
}

.pairsRows dt,
.pairsRows dd
{
	display: inline-block;
	vertical-align: top;

	*display: inline;
	*margin-right: 1ex;
	*zoom: 1;
}

dl.pairsColumns,
dl.pairsJustified,
.pairsColumns dl,
.pairsJustified dl
{
	overflow: hidden; zoom: 1;
}

.pairsColumns dt,
.pairsColumns dd
{
	float: left;
	width: 48%;
}

.pairsJustified dt
{
	float: left;
	max-width: 100%;
	margin-right: 5px;
}
.pairsJustified dd
{
	float: right;
	text-align: right;
	max-width: 100%
}


/* ***************************** */
/* Lists that put all elements on a single line */

.listInline ul,
.listInline ol,
.listInline li,
.listInline dl,
.listInline dt,
.listInline dd
{
	display: inline;
}

/* intended for use with .listInline, produces 'a, b, c, d' / 'a * b * c * d' lists */

.commaImplode li:after,
.commaElements > *:after
{
	content: ', ';
}

.commaImplode li:last-child:after,
.commaElements > *:last-child:after
{
	content: '';
}

.bulletImplode li:before
{
	content: '\2022\a0';
}

.bulletImplode li:first-child:before
{
	content: '';
}

/* Three column list display */

.threeColumnList
{
	overflow: hidden; zoom: 1;
}

.threeColumnList li
{
	float: left;
	width: 32%;
	margin: 2px 1% 2px 0;
}

.twoColumnList
{
	overflow: hidden; zoom: 1;
}

.twoColumnList li
{
	float: left;
	width: 48%;
	margin: 2px 1% 2px 0;
}

/* ***************************** */
/* Preview tooltips (threads etc.) */

.previewTooltip
{
}
		
	.previewTooltip .avatar
	{
		float: left;
	}
	
	.previewTooltip .text
	{
		margin-left: 64px;
	}
	
		.previewTooltip blockquote
		{
			font-size: 14px;
color: rgb(166, 166, 166);
line-height: 1.4;

			
			font-size: 10pt;
			max-height: 150px;
			overflow: hidden;
		}
	
		.previewTooltip .posterDate
		{
			font-size: 11px;
			padding-top: 5px;
			border-top: 1px solid rgb(69, 69, 69);
			margin-top: 5px;
		}

/* ***************************** */
/* List of block links */

.blockLinksList
{
	font-size: 12px;
padding: 2px;

}
		
	.blockLinksList a,
	.blockLinksList label
	{
		padding: 5px 10px;
-webkit-border-radius: 5px; -moz-border-radius: 5px; -khtml-border-radius: 5px; border-radius: 5px;
display: block;
outline: 0 none;

	}
	
		.blockLinksList a:hover,
		.blockLinksList a:focus,
		.blockLinksList li.kbSelect a,
		.blockLinksList label:hover,
		.blockLinksList label:focus,
		.blockLinksList li.kbSelect label
		{
			text-decoration: none;
background-color: rgb(36, 36, 36);

		}
		
		.blockLinksList a:active,
		.blockLinksList li.kbSelect a:active,
		.blockLinksList a.selected,
		.blockLinksList li.kbSelect a.selected,
		.blockLinksList label:active,
		.blockLinksList li.kbSelect label:active,
		.blockLinksList label.selected,
		.blockLinksList li.kbSelect label.selected
		{
			color: rgb(228, 137, 27);
background-color: rgb(67, 67, 67);

		}
		
		.blockLinksList a.selected,
		.blockLinksList li.kbSelect a.selected,
		.blockLinksList label.selected,
		.blockLinksList li.kbSelect label.selected
		{
			font-weight: bold;
display: block;

		}
		
		.blockLinksList span.depthPad
		{
			display: block;
		}

.blockLinksList .itemCount
{
	font-weight: bold;
font-size: 9px;
color: white;
background-color: #e03030;
padding: 0 2px;
-webkit-border-radius: 2px; -moz-border-radius: 2px; -khtml-border-radius: 2px; border-radius: 2px;
position: absolute;
right: 2px;
top: -20px;
line-height: 16px;
min-width: 12px;
_width: 12px;
text-align: center;
text-shadow: none;
white-space: nowrap;
word-wrap: normal;
-webkit-box-shadow: 2px 2px 5px rgba(0,0,0, 0.25); -moz-box-shadow: 2px 2px 5px rgba(0,0,0, 0.25); -khtml-box-shadow: 2px 2px 5px rgba(0,0,0, 0.25); box-shadow: 2px 2px 5px rgba(0,0,0, 0.25);
height: 16px;


	float: right;
	position: relative;
	right: 0;
	top: -1px;
}

	.blockLinksList .itemCount.Zero
	{
		display: none;
	}
	
.bubbleLinksList
{
	overflow: hidden;
}

.bubbleLinksList a
{
	float: left;
	padding: 2px 4px;
	margin-right: 2px;
	-webkit-border-radius: 3px; -moz-border-radius: 3px; -khtml-border-radius: 3px; border-radius: 3px;
	text-decoration: none;
}
	
	.bubbleLinksList a:hover,
	.bubbleLinksList a:active
	{
		text-decoration: none;
background-color: rgb(36, 36, 36);

	}
	
	.bubbleLinksList a.active
	{
		color: rgb(228, 137, 27);
background-color: rgb(67, 67, 67);

		font-weight: bold;
display: block;

	}

/* ***************************** */
/* Normally-indented nested lists */

.indentList ul,
.indentList ol
{
	margin-left: 2em;
}

/* ***************************** */
/* AJAX progress image */

.InProgress
{
	background: transparent url('styles/fusiongamer/xenforo/widgets/ajaxload.info_B4B4DC_facebook.gif') no-repeat right center;
}

/* ***************************** */
/* Hidden inline upload iframe */

.hiddenIframe
{
	display: block;
	width: 500px;
	height: 300px;
}

/* ***************************** */
/* Exception display */

.traceHtml { font-size:11px; font-family:calibri, verdana, arial, sans-serif; }
.traceHtml .function { color:rgb(180,80,80); font-weight:normal; }
.traceHtml .file { font-weight:normal; }
.traceHtml .shade { color:rgb(128,128,128); }
.traceHtml .link { font-weight:bold; }

/* ***************************** */
/* Indenting for options */

._depth0 { padding-left:  0em; }
._depth1 { padding-left:  2em; }
._depth2 { padding-left:  4em; }
._depth3 { padding-left:  6em; }
._depth4 { padding-left:  8em; }
._depth5 { padding-left: 10em; }
._depth6 { padding-left: 12em; }
._depth7 { padding-left: 14em; }
._depth8 { padding-left: 16em; }
._depth9 { padding-left: 18em; }

.xenOverlay .errorOverlay
{
	color: white;
	padding: 25px;
	-webkit-border-radius: 20px; -moz-border-radius: 20px; -khtml-border-radius: 20px; border-radius: 20px;	
	border:  20px solid rgb(0,0,0); border:  20px solid rgba(0,0,0, 0.25); _border:  20px solid rgb(0,0,0);
	
	background: url(rgba.php?r=0&g=0&b=0&a=191); background: rgba(0,0,0, 0.75); _filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#BF000000,endColorstr=#BF000000);
}

	.xenOverlay .errorOverlay .heading
	{
		padding: 5px 10px;
		font-weight: bold;
		font-size: 12pt;
		background: rgb(180,0,0);
		color: white;
		margin-bottom: 10px;
		-webkit-border-radius: 5px; -moz-border-radius: 5px; -khtml-border-radius: 5px; border-radius: 5px;
		border: 1px solid rgb(100,0,0);
	}

	.xenOverlay .errorOverlay li
	{
		line-height: 2;
	}
	
	.xenOverlay .errorOverlay .exceptionMessage
	{
		color: rgb(150,150,150);
	}

/*** inline errors ***/

.formValidationInlineError
{
	display: none;
	position: absolute;
	z-index: 5000;
	background-color: white;
	border: 1px solid rgb(180,0,0);
	color: rgb(180,0,0);
	-webkit-box-shadow: 2px 2px 10px #999; -moz-box-shadow: 2px 2px 10px #999; -khtml-box-shadow: 2px 2px 10px #999; box-shadow: 2px 2px 10px #999;
	-webkit-border-radius: 3px; -moz-border-radius: 3px; -khtml-border-radius: 3px; border-radius: 3px;
	padding: 2px 5px;
	font-size: 11px;
	width: 175px;
	min-height: 2.5em;
	_height: 2.5em;
	word-wrap: break-word;
}

	.formValidationInlineError.inlineError
	{
		position: static;
		width: auto;
		min-height: 0;
	}

/** Block errors **/

.errorPanel
{
	margin: 10px 0 20px;
	color: rgb(180,0,0);
	background: rgb(255, 235, 235);
	-webkit-border-radius: 5px; -moz-border-radius: 5px; -khtml-border-radius: 5px; border-radius: 5px;
	border: 1px solid rgb(180,0,0);
}

	.errorPanel .errorHeading
	{
		margin: .75em;
		font-weight: bold;
		font-size: 12pt;
	}
	
	.errorPanel .errors
	{
		margin: .75em 2em;
		display: block;
		line-height: 1.5;
	}


@media (max-width:800px)
{
	.Responsive .formValidationInlineError
	{
		position: static;
		width: auto;
		min-height: auto;
	}
}


/* Undo some nasties */

input[type=search]
{
	-webkit-appearance: textfield;
	-webkit-box-sizing: content-box; -moz-box-sizing: content-box; -ms-box-sizing: content-box; box-sizing: content-box;
}

/* ignored content hiding */

.ignored { display: none !important; }

/* Misc */

.floatLeft { float: left; }
.floatRight { float: right; }

.horizontalContain { overflow-x: auto; }

.ltr { direction: ltr; }

/* Square-cropped thumbs */

.SquareThumb
{
	position: relative;
	display: block;
	overflow: hidden;
	padding: 0;
	direction: ltr;
	
	/* individual instances can override this size */
	width: 48px;
	height: 48px;
}

.SquareThumb img
{
	position: relative;
	display: block;
}

/* Basic, common, non-templated BB codes */

.bbCodeImage
{
	max-width: 100%;
}

.bbCodeImageFullSize
{
	position: absolute;
	z-index: 50000;
	background-color: rgb(20, 20, 20);
}

.bbCodeStrike
{
	text-decoration: line-through;
}

img.mceSmilie,
img.mceSmilieSprite
{
	vertical-align: text-bottom;
	margin: 0 1px;
}

/* smilie sprite classes */

img.mceSmilieSprite.mceSmilie1
{
	width: 18px; height: 18px; background: url('styles/default/xenforo/xenforo-smilies-sprite.png') no-repeat 0px 0px;
}

img.mceSmilieSprite.mceSmilie2
{
	width: 18px; height: 18px; background: url('styles/default/xenforo/xenforo-smilies-sprite.png') no-repeat -60px -21px;
}

img.mceSmilieSprite.mceSmilie3
{
	width: 18px; height: 18px; background: url('styles/default/xenforo/xenforo-smilies-sprite.png') no-repeat -40px -42px;
}

img.mceSmilieSprite.mceSmilie4
{
	width: 18px; height: 18px; background: url('styles/default/xenforo/xenforo-smilies-sprite.png') no-repeat -60px 0px;
}

img.mceSmilieSprite.mceSmilie5
{
	width: 18px; height: 18px; background: url('styles/default/xenforo/xenforo-smilies-sprite.png') no-repeat -40px -21px;
}

img.mceSmilieSprite.mceSmilie6
{
	width: 18px; height: 18px; background: url('styles/default/xenforo/xenforo-smilies-sprite.png') no-repeat -40px 0px;
}

img.mceSmilieSprite.mceSmilie7
{
	width: 18px; height: 18px; background: url('styles/default/xenforo/xenforo-smilies-sprite.png') no-repeat -20px -21px;
}

img.mceSmilieSprite.mceSmilie8
{
	width: 18px; height: 18px; background: url('styles/default/xenforo/xenforo-smilies-sprite.png') no-repeat -20px 0px;
}

img.mceSmilieSprite.mceSmilie9
{
	width: 18px; height: 18px; background: url('styles/default/xenforo/xenforo-smilies-sprite.png') no-repeat -20px -42px;
}

img.mceSmilieSprite.mceSmilie10
{
	width: 18px; height: 18px; background: url('styles/default/xenforo/xenforo-smilies-sprite.png') no-repeat 0px -42px;
}

img.mceSmilieSprite.mceSmilie11
{
	width: 18px; height: 18px; background: url('styles/default/xenforo/xenforo-smilies-sprite.png') no-repeat 0px -21px;
}

img.mceSmilieSprite.mceSmilie12
{
	width: 18px; height: 18px; background: url('styles/default/xenforo/xenforo-smilies-sprite.png') no-repeat -80px -42px;
}


.visibleResponsiveFull { display: inherit !important; }

.visibleResponsiveWide,
.visibleResponsiveMedium,
.visibleResponsiveNarrow { display: none !important; }

.hiddenResponsiveFull { display: none !important; } 

.hiddenResponsiveWide,
.hiddenResponsiveMedium,
.hiddenResponsiveNarrow { display: inherit !important; }


@media (max-width:800px)
{
	.Responsive .visibleResponsiveFull { display: none !important; }
	
	.Responsive .hiddenResponsiveFull { display: inherit !important; }
	
	.Responsive .hiddenWideUnder { display: none !important; }
}
@media (min-width:611px) AND (max-width:800px)
{
	.Responsive .visibleResponsiveWide { display: inherit !important; }
	
	.Responsive .hiddenResponsiveWide { display: none !important; }
	}

@media (min-width:481px) AND (max-width:610px)
{
	.Responsive .visibleResponsiveMedium { display: inherit !important; }
	
	.Responsive .hiddenResponsiveMedium { display: none !important; }
	
	.Responsive .hiddenWideUnder,
	.Responsive .hiddenMediumUnder { display: none !important; }
}

@media (max-width:480px)
{
	.Responsive .visibleResponsiveNarrow { display: inherit !important; }
	
	.Responsive .hiddenResponsiveNarrow { display: none !important; }
	
	.Responsive .hiddenWideUnder,
	.Responsive .hiddenMediumUnder,
	.Responsive .hiddenNarrowUnder { display: none !important; }
}

@media (max-width:610px)
{
	.Responsive .threeColumnList li
	{
		float: none;
		width: auto;
		margin: 2px 1% 2px 0;
	}
}

@media (max-width:480px)
{
	.Responsive .xenTooltip.statusTip
	{
		width: auto;
	}
	
	.Responsive .xenPreviewTooltip
	{
		-webkit-box-sizing: border-box; -moz-box-sizing: border-box; -ms-box-sizing: border-box; box-sizing: border-box;
		width: auto;
		max-width: 100%;
	}
	
	.Responsive .xenPreviewTooltip .arrow
	{
		display: none;
	}
	
	.Responsive .previewTooltip .avatar
	{
		display: none;
	}
	
	.Responsive .previewTooltip .text
	{
		margin-left: 0;
	}
}




/* --- form.css --- */

/** Forms **/

.xenForm
{
	margin: 10px auto;
	max-width: 800px;
}

	.xenOverlay .xenForm
	{
		max-width: 600px;
	}

.xenForm .ctrlUnit > dd
{
	width: 68%;
	-webkit-box-sizing: border-box; -moz-box-sizing: border-box; -ms-box-sizing: border-box; box-sizing: border-box;
	padding-right: 30px;
}

.xenForm .ctrlUnit > dd .textCtrl
{
	-webkit-box-sizing: border-box; -moz-box-sizing: border-box; -ms-box-sizing: border-box; box-sizing: border-box;
	width: 100%;
}

	.xenForm .ctrlUnit > dd .textCtrl.indented
	{
		width: calc(100% - 16px);
	}

	.xenForm .ctrlUnit > dd .textCtrl[size],
	.xenForm .ctrlUnit > dd .textCtrl.autoSize
	{
		width: auto !important;
		min-width: 0;
	}

	.xenForm .ctrlUnit > dd .textCtrl.number
	{
		width: 150px;
	}


.xenForm > .sectionHeader:first-child,
.xenForm > fieldset > .sectionHeader:first-child
{
	margin-top: 0;
}

/** Sections **/

.xenForm fieldset,
.xenForm .formGroup
{
	border-top: 1px solid rgb(69, 69, 69);
	margin: 20px auto;
}

.xenForm > fieldset:first-child,
.xenForm > .formGroup:first-child
{
	border-top: none;
	margin: auto;
}

.xenForm .PreviewContainer + fieldset,
.xenForm .PreviewContainer + .formGroup
{
	border-top: none;
}

.xenForm fieldset + .ctrlUnit,
.xenForm .formGroup + .ctrlUnit,
.xenForm .submitUnit
{
	border-top: 1px solid rgb(69, 69, 69);
}

.xenForm fieldset + .ctrlUnit,
.xenForm .formGroup + .ctrlUnit
{
	padding-top: 10px;
}

.xenForm .primaryContent + .submitUnit,
.xenForm .secondaryContent + .submitUnit
{
	margin-top: 0;
	border-top: none;
}

.xenForm .ctrlUnit.submitUnit dd
{	
	line-height: 31px;
	padding-top: 0;
}

	.ctrlUnit.submitUnit dd .explain,
	.ctrlUnit.submitUnit dd .text,
	.ctrlUnit.submitUnit dd label
	{
		line-height: 1.28;
	}

/* now undo that */

.xenOverlay .ctrlUnit.submitUnit dd,
.Menu .ctrlUnit.submitUnit dd,
#QuickSearch .ctrlUnit.submitUnit dd
{
	border: none;
	background: none;
}

.xenForm .ctrlUnit
{
	
}

	.xenForm .ctrlUnit.limited
	{
		display: none;
	}

	/** Sections Immediately Following Headers **/

	.xenForm .sectionHeader + fieldset,
	.xenForm .heading + fieldset,
	.xenForm .subHeading + fieldset,
	.xenForm .sectionHeader + .formGroup,
	.xenForm .heading + .formGroup,
	.xenForm .subHeading + .formGroup
	{
		border-top: none;
		margin-top: 0;
	}
	
.xenForm .formHiderHeader
{
	margin: 10px;
	font-size: 15px;
	font-weight: bold;
}


/** *********************** **/
/** TEXT INPUTS             **/
/** *********************** **/

.textCtrl
{
	font-size: 14px;
font-family: Calibri, 'Trebuchet MS', Verdana, Geneva, Arial, Helvetica, sans-serif;
color: rgb(201, 201, 201);
background-color: rgb(18, 18, 18);
padding: 3px;
margin-bottom: 2px;
border: 1px solid rgb(35, 35, 35);
-webkit-border-radius: 3px; -moz-border-radius: 3px; -khtml-border-radius: 3px; border-radius: 3px;
outline: 0;

}

select.textCtrl
{
	word-wrap: normal;
	-webkit-appearance: menulist;
}

select[multiple].textCtrl,
select[size].textCtrl
{
	-webkit-appearance: listbox;
}

select[size="0"].textCtrl,
select[size="1"].textCtrl
{
	-webkit-appearance: menulist;
}

textarea.textCtrl
{
	word-wrap: break-word;
}

	.textCtrl:focus,
	.textCtrl.Focus
	{
		color: rgb(200,200,200);
background-color: rgb(10, 10, 10);
background-repeat: repeat-x;

	}	

	textarea.textCtrl:focus
	{
		
	}

	input.textCtrl.disabled,
	textarea.textCtrl.disabled,
	.disabled .textCtrl
	{
		font-style: italic;
color: rgb(100,100,100);
background-color: rgb(245,245,245);

	}
	
	.textCtrl.prompt
	{
		font-style: italic;
color: rgb(160,160,160);

	}
	
	.textCtrl:-moz-placeholder
	{
		/* needs to be in its own rule due to weird selector */
		font-style: italic;
color: rgb(160,160,160);

	}
	
	.textCtrl::-moz-placeholder
	{
		/* needs to be in its own rule due to weird selector */
		font-style: italic;
color: rgb(160,160,160);

	}

	.textCtrl::-webkit-input-placeholder
	{
		/* needs to be in its own rule due to weird selector */
		font-style: italic;
color: rgb(160,160,160);

	}
	
	.textCtrl:-ms-input-placeholder
	{
		/* needs to be in its own rule due to weird selector */
		font-style: italic;
color: rgb(160,160,160);

	}
	
	.textCtrl.autoSize
	{
		width: auto !important;
	}

	.textCtrl.number,
	.textCtrl.number input
	{
		text-align: right;
		width: 150px;
	}
	
	.textCtrl.fillSpace
	{
		width: 100%;
		-webkit-box-sizing: border-box; -moz-box-sizing: border-box; -ms-box-sizing: border-box; box-sizing: border-box;
		_width: 95%;
	}

	.textCtrl.code,
	.textCtrl.code input
	{
		font-family: Consolas, "Courier New", Courier, monospace;
white-space: pre;
word-wrap: normal;
direction: ltr;

	}
	
	input.textCtrl[type="password"]
	{
		font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
	}

	input[type="email"],
	input[type="url"]
	{
		direction: ltr;
	}

	.textCtrl.titleCtrl,
	.textCtrl.titleCtrl input
	{
		font-size: 18pt;
	}

textarea.textCtrl.Elastic
{
	/* use for jQuery.elastic */
	max-height: 300px;
}

/* for use with wrapped inputs */
.textCtrlWrap
{
	display: inline-block;
}

.textCtrlWrap input.textCtrl
{
	padding: 0 !important;
	margin: 0 !important;
	border: none !important;
	background: transparent !important;
	-webkit-border-radius: 0 !important; -moz-border-radius: 0 !important; -khtml-border-radius: 0 !important; border-radius: 0 !important;
}

.textCtrlWrap.blockInput input.textCtrl
{
	border-top: 1px solid rgb(35, 35, 35) !important;
	margin-top: 4px !important;
}

.taggingInput.textCtrl
{
	padding-top: 1px;
	min-height: 25px;
}

.taggingInput input
{
	margin: 0px;
	font-size: 12px;
	border: 1px solid transparent;
	padding: 0;
	background: transparent;
	outline: 0;
	color: inherit;
	font-family: inherit;
}

.taggingInput .tag
{
	border: 1px solid rgb(67, 67, 67);
	-webkit-border-radius: 3px; -moz-border-radius: 3px; -khtml-border-radius: 3px; border-radius: 3px;
	display: inline-block;
	padding: 0 3px;
	text-decoration: none;
	background: rgb(69, 69, 69) url('../images/form-button-white-25px.png') repeat-x top;
	color: rgb(24, 24, 24);
	margin-right: 3px;
	margin-top: 2px;
	font-size: 12px;
	max-width: 98%;
	-webkit-box-shadow: 1px 1px 3px rgba(0,0,0, 0.25); -moz-box-shadow: 1px 1px 3px rgba(0,0,0, 0.25); -khtml-box-shadow: 1px 1px 3px rgba(0,0,0, 0.25); box-shadow: 1px 1px 3px rgba(0,0,0, 0.25);
}

.disabled.taggingInput .tag
{
	opacity: 0.7;
}

	.disabled.taggingInput .tag a
	{
		pointer-events: none;
	}

	html .taggingInput .tag a
	{
		color: rgb(44, 44, 44);
		font-weight: bold;
		text-decoration: none;
	}

.taggingInput .addTag
{
	display: inline-block;
	min-width: 150px;
	max-width: 100%;
	margin-top: 2px;
}

.taggingInput .tagsClear
{
	clear: both;
	width: 100%;
	height: 0px;
	float: none;
}





/** Control Units **/

.xenForm .ctrlUnit
{
	position: relative;
	margin: 10px auto;
}

/* clearfix */ .xenForm .ctrlUnit { zoom: 1; } .xenForm .ctrlUnit:after { content: '.'; display: block; height: 0; clear: both; visibility: hidden; }

.xenForm .ctrlUnit.fullWidth
{
	overflow: visible;
}

/** Control Unit Labels **/

.xenForm .ctrlUnit > dt
{
	padding-top: 4px;
padding-right: 15px;
text-align: right;
vertical-align: top;

	-webkit-box-sizing: border-box; -moz-box-sizing: border-box; -ms-box-sizing: border-box; box-sizing: border-box;
	width: 32%;
	float: left;
}

/* special long-text label */
.xenForm .ctrlUnit > dt.explain
{
	font-size: 11px;
	text-align: justify;
}


.xenForm .ctrlUnit.fullWidth dt,
.xenForm .ctrlUnit.submitUnit.fullWidth dt
{
	float: none;
	width: auto;
	text-align: left;
	height: auto;
}

.xenForm .ctrlUnit.fullWidth dt
{
	margin-bottom: 2px;
}

	.xenForm .ctrlUnit > dt label
	{
		margin-left: 30px;
	}

	/** Hidden Labels **/

	.xenForm .ctrlUnit.surplusLabel dt label
	{
		display: none;
	}

	/** Section Links **/

	.ctrlUnit.sectionLink dt
	{
		text-align: left;
		font-size: 11px;
	}

		.ctrlUnit.sectionLink dt a
		{
			margin-left: 11px; /*TODO: sectionHeader padding + border*/
		}		

	/** Hints **/

	.ctrlUnit > dt dfn
	{
		font-style: italic;
font-size: 12px;
color: rgb(150,150,150);
margin-left: 30px;
display: block;

	}
	
	.ctrlUnit.fullWidth dt dfn
	{
		display: inline;
		margin: 0;
	}
	
		.ctrlUnit > dt dfn b,
		.ctrlUnit > dt dfn strong
		{
			color: rgb(100,100,100);
		}

	/** Inline Errors **/

	.ctrlUnit > dt .error
	{
		font-size: 12px;
color: red;
display: block;

	}
	
	.ctrlUnit > dt dfn,
	.ctrlUnit > dt .error,
	.ctrlUnit > dt a
	{
		font-weight: normal;
	}

.xenForm .ctrlUnit.submitUnit dt
{
	height: 19px;
	display: block;
}

	.ctrlUnit.submitUnit dt.InProgress
	{
		background: transparent url('styles/fusiongamer/xenforo/widgets/ajaxload.info_B4B4DC_facebook.gif') no-repeat center center;
	}

/** Control Holders **/

.xenForm .ctrlUnit > dd
{
	/*todo: kill property */
	
	float: left;
}

.xenForm .ctrlUnit.fullWidth > dd
{
	float: none;
	width: auto;
	padding-left: 30px;
}

/** Explanatory paragraph **/

.ctrlUnit > dd .explain
{
	font-size: 12px;
color: rgb(150,150,150);
margin-top: 2px;

	/*TODO:max-width: auto;*/
}
	
	.ctrlUnit > dd .explain b,
	.ctrlUnit > dd .explain strong
	{
		color: rgb(100,100,100);
	}

/** List items inside controls **/

.ctrlUnit > dd > * > li
{
	margin: 4px 0 8px;
	padding-left: 1px; /* fix a webkit display bug */
}

.ctrlUnit > dd > * > li:first-child > .textCtrl:first-child
{
	margin-top: -3px;
}

.ctrlUnit > dd .break
{
	margin-bottom: 0.75em;
	padding-bottom: 0.75em;
}

.ctrlUnit > dd .rule
{
	border-bottom: 1px solid rgb(69, 69, 69);
}

.ctrlUnit > dd .ddText
{
	margin-bottom: 2px;
}

/** Hints underneath checkbox / radio controls **/

.ctrlUnit > dd > * > li .hint
{
	font-size: 11px;
	color: rgb(150,150,150);
	margin-left: 16px;
	margin-top: 2px;
}

/** DISABLERS **/

.ctrlUnit > dd > * > li > ul,
.ctrlUnit .disablerList,
.ctrlUnit .indented
{
	margin-left: 16px;
}

.ctrlUnit > dd > * > li > ul > li:first-child
{
	margin-top: 6px;
}

.ctrlUnit > dd .disablerList > li,
.ctrlUnit > dd .checkboxColumns > li,
.ctrlUnit > dd .choiceList > li
{
	margin-top: 6px;
}
	
/** Other stuff... **/

.ctrlUnit > dd .helpLink
{
	font-size: 10px;
}

.ctrlUnit.textValue dt
{
	padding-top: 0px;
}

spinBoxButton
{
	font-family: 'Trebuchet MS',Helvetica,Arial,sans-serif;
	font-size: 11pt;
}

.unitPairsJustified li
{
	overflow: hidden;
}

	.unitPairsJustified li .label
	{
		float: left;
	}
	
	.unitPairsJustified li .value
	{
		float: right;
	}

#calroot
{
	margin-top: -1px;
	width: 198px;
	padding: 2px;
	background-color: rgb(20, 20, 20);
	font-size: 11px;
	border: 1px solid rgb(31, 31, 31);
	-webkit-border-radius: 5px; -moz-border-radius: 5px; -khtml-border-radius: 5px; border-radius: 5px;
	-webkit-box-shadow: 0 0 7px rgba(37, 37, 37, 0.46); -moz-box-shadow: 0 0 7px rgba(37, 37, 37, 0.46); -khtml-box-shadow: 0 0 7px rgba(37, 37, 37, 0.46); box-shadow: 0 0 7px rgba(37, 37, 37, 0.46);
	z-index: 7500;
}

#calhead
{	
	padding: 2px 0;
	height: 22px;
} 

	#caltitle {
		font-size: 11pt;
		color: rgb(166, 166, 166);
		float: left;
		text-align: center;
		width: 155px;
		line-height: 20px;
	}
	
	#calnext, #calprev {
		display: block;
		width: 20px;
		height: 20px;
		font-size: 11pt;
		line-height: 20px;
		text-align: center;
		float: left;
		cursor: pointer;
	}

	#calnext {
		float: right;
	}

	#calprev.caldisabled, #calnext.caldisabled {
		visibility: hidden;	
	}

#caldays {
	height: 14px;
	border-bottom: 1px solid rgb(31, 31, 31);
}

	#caldays span {
		display: block;
		float: left;
		width: 28px;
		text-align: center;
		color: rgb(150,150,150);
	}

#calweeks {
	margin-top: 4px;
}

.calweek {
	clear: left;
	height: 22px;
}

	.calweek a {
		display: block;
		float: left;
		width: 27px;
		height: 20px;
		text-decoration: none;
		font-size: 11px;
		margin-left: 1px;
		text-align: center;
		line-height: 20px;
		-webkit-border-radius: 3px; -moz-border-radius: 3px; -khtml-border-radius: 3px; border-radius: 3px;
	} 
	
		.calweek a:hover, .calfocus {
			background-color: rgb(18, 18, 18);
		}

a.caloff {
	color: rgb(150,150,150);		
}

a.caloff:hover {
	background-color: rgb(18, 18, 18);		
}

a.caldisabled {
	background-color: #efefef !important;
	color: #ccc	!important;
	cursor: default;
}

#caltoday {
	font-weight: bold;
}

#calcurrent {
	background-color: rgb(249, 217, 176);
	color: rgb(109, 63, 3);
}
ul.autoCompleteList
{
	background-color: rgb(18, 18, 18);
	
	border: 1px solid rgb(44, 44, 44);
	padding: 2px;
	
	font-size: 11px;
	
	min-width: 180px;
	_width: 180px;
	
	z-index: 1000;
}

ul.autoCompleteList li
{
	padding: 3px 3px;
	height: 24px;
	line-height: 24px;
}

ul.autoCompleteList li:hover,
ul.autoCompleteList li.selected
{
	background-color: rgb(69, 69, 69);
	-webkit-border-radius: 3px; -moz-border-radius: 3px; -khtml-border-radius: 3px; border-radius: 3px;
}

ul.autoCompleteList img.autoCompleteAvatar
{
	float: left;
	margin-right: 3px;
	width: 24px;
	height: 24px;
}

ul.autoCompleteList li strong
{
	font-weight: bold;
}

/** status editor **/

.statusEditorCounter
{
	color: green;
}

.statusEditorCounter.warning
{
	color: orange;
	font-weight: bold;
}

.statusEditorCounter.error
{
	color: red;
	font-weight: bold;
}

.explain .statusHeader
{
	display: inline;
}

.explain .CurrentStatus
{
	color: rgb(166, 166, 166);
	font-style: italic;
	padding-left: 5px;
}

/* BB code-based editor styling */

.xenForm .ctrlUnit.fullWidth dd .bbCodeEditorContainer textarea
{
	margin-left: 0;
	min-height: 200px;
}

.bbCodeEditorContainer a
{
	font-size: 11px;
}

/*
 * Fix silly top padding. This may require additional tags in the padding-top selector.
 */

.xenForm .ctrlUnit > dd
{
	padding-top: 4px;
}

	.xenForm .ctrlUnit.fullWidth > dd
	{
		padding-top: 0;
	}

.xenForm .ctrlUnit > dd > input,
.xenForm .ctrlUnit > dd > select,
.xenForm .ctrlUnit > dd > textarea,
.xenForm .ctrlUnit > dd > ul,
.xenForm .ctrlUnit > dd > .verticalShift
{
	margin-top: -4px;
}

	.xenForm .ctrlUnit.fullWidth > dd > input,
	.xenForm .ctrlUnit.submitUnit > dd > input,
	.xenForm .ctrlUnit.fullWidth > dd > select,
	.xenForm .ctrlUnit.submitUnit > dd > select,
	.xenForm .ctrlUnit.fullWidth > dd > textarea,
	.xenForm .ctrlUnit.submitUnit > dd > textarea,
	.xenForm .ctrlUnit.fullWidth > dd > ul,
	.xenForm .ctrlUnit.submitUnit > dd > ul
	{
		margin-top: 0;
	}
	
/*
 * Multi-column checkboxes
 */
 
.xenForm .checkboxColumns > dd > ul,
ul.checkboxColumns
{
	-webkit-column-count : 2; -moz-column-count : 2;column-count: 2;
	-webkit-column-gap : 8px; -moz-column-gap : 8px;column-gap: 8px;
}

	.xenForm .checkboxColumns > dd > ul li,
	ul.checkboxColumns li
	{
		-webkit-column-break-inside : avoid; -moz-column-break-inside : avoid;column-break-inside: avoid;
		break-inside: avoid-column;
		margin-bottom: 4px;
		padding-left: 1px;
		display: inline-block;
		width: 100%;
	}
	
	.xenForm .checkboxColumns.blockLinksList > dd > ul li,
	ul.checkboxColumns.blockLinksList li
	{
		display: block;
	}

.xenForm .checkboxColumns.multiple > dd > ul
{
	-webkit-column-count : auto; -moz-column-count : auto;column-count: auto;
	-webkit-column-gap : normal; -moz-column-gap : normal;column-gap: normal;
}

.xenForm .checkboxColumns.multiple > dd
{
	-webkit-column-count : 2; -moz-column-count : 2;column-count: 2;
	-webkit-column-gap : 8px; -moz-column-gap : 8px;column-gap: 8px;
}

.xenForm .checkboxColumns.multiple > dd > ul
{
	margin-bottom: 18px;
}

#recaptcha_image
{
	-webkit-box-sizing: content-box; -moz-box-sizing: content-box; -ms-box-sizing: content-box; box-sizing: content-box;
	max-width: 100%;
}

#recaptcha_image img
{
	max-width: 100%;
}

#helper_birthday { display: inline-block; }
#helper_birthday > li
{
	display: inline;
}
html[dir=rtl] #helper_birthday input,
html[dir=rtl] #helper_birthday select
{
	direction: rtl;
}


@media (max-width:480px)
{
	.Responsive .xenForm .ctrlUnit > dt
	{
		float: none;
		width: auto;
		text-align: left;
		height: auto;
	}

		.Responsive .xenForm .ctrlUnit > dt label,
		.Responsive .xenForm .ctrlUnit > dt dfn
		{
			margin-left: 0;
		}

	.Responsive .xenForm .ctrlUnit.submitUnit dt
	{
		height: auto;
	}

	.Responsive .xenForm .ctrlUnit > dd,
	.Responsive .xenForm .ctrlUnit.fullWidth dd
	{
		float: none;
		width: auto;
		text-align: left;
		height: auto;
		padding-left: 10px;
		padding-right: 10px;
		overflow: hidden;
	}

	.Responsive .xenForm .checkboxColumns > dd > ul,
	.Responsive ul.checkboxColumns
	{
		-webkit-column-count : 1; -moz-column-count : 1;column-count: 1;
	}
	
	.Responsive #ctrl_upload
	{
		max-width: 200px;
	}
	
	.Responsive .xenForm .ctrlUnit > dd .textCtrl[size],
	.Responsive .xenForm .ctrlUnit > dd .textCtrl.autoSize
	{
		width: 100% !important;
	}
	
	.Responsive .xenForm .ctrlUnit > dd > input,
	.Responsive .xenForm .ctrlUnit > dd > select,
	.Responsive .xenForm .ctrlUnit > dd > textarea,
	.Responsive .xenForm .ctrlUnit > dd > ul,
	.Responsive .xenForm .ctrlUnit > dd > .verticalShift
	{
		margin-top: 0;
	}
}

@media (max-width:610px)
{
	.Responsive .insideSidebar .xenForm .ctrlUnit > dt
	{
		float: none;
		width: auto;
		text-align: left;
		height: auto;
	}

		.Responsive .insideSidebar .xenForm .ctrlUnit > dt label,
		.Responsive .insideSidebar .xenForm .ctrlUnit > dt dfn
		{
			margin-left: 0;
		}

	.Responsive .insideSidebar .xenForm .ctrlUnit.submitUnit dt
	{
		height: auto;
	}

	.Responsive .insideSidebar .xenForm .ctrlUnit > dd,
	.Responsive .insideSidebar .xenForm .ctrlUnit.fullWidth dd
	{
		float: none;
		width: auto;
		text-align: left;
		height: auto;
		padding-left: 10px;
		padding-right: 10px;
		overflow: hidden;
	}
	
	.Responsive .insideSidebar .xenForm .ctrlUnit > dd .textCtrl[size],
	.Responsive .insideSidebar .xenForm .ctrlUnit > dd .textCtrl.autoSize
	{
		width: 100% !important;
	}
	
	.Responsive .insideSidebar .xenForm .ctrlUnit > dd > input,
	.Responsive .insideSidebar .xenForm .ctrlUnit > dd > select,
	.Responsive .insideSidebar .xenForm .ctrlUnit > dd > textarea,
	.Responsive .insideSidebar .xenForm .ctrlUnit > dd > ul
	{
		margin-top: -0;
	}
}

@media (max-device-width:568px)
{
	.Responsive .textCtrl,
	.Responsive .taggingInput input,
	.Responsive .taggingInput .tag
	{
		font-size: 16px;
	}
}


/* --- public.css --- */

#header
{
	
}

/* clearfix */ #header .pageWidth .pageContent { zoom: 1; } #header .pageWidth .pageContent:after { content: '.'; display: block; height: 0; clear: both; visibility: hidden; }

#logo
{
    display: block;
    float: left;
    line-height: 205px;
    height: 209px;
    max-width: 100%;
    vertical-align: middle;
}

		/* IE6/7 vertical align fix */
		#logo span
		{
			*display: inline-block;
			*height: 100%;
		}

		#logo a:hover
		{
			text-decoration: none;
		}

		#logo img
		{
			vertical-align: middle;
			max-width: 100%;
		}

	#visitorInfo
	{
		float: right;
		min-width: 250px;
		_width: 250px;
		overflow: hidden; zoom: 1;
		background: rgb(67, 67, 67);
		padding: 5px;
		-webkit-border-radius: 5px; -moz-border-radius: 5px; -khtml-border-radius: 5px; border-radius: 5px;
		margin: 10px 0;
		border: 1px solid rgb(10, 10, 10);
		color: rgb(10, 10, 10);
	}

		#visitorInfo .avatar
		{
			float: left;
			display: block;
		}

			#visitorInfo .avatar .img
			{
				border-color: rgb(36, 36, 36);
			}

		#visitorInfo .username
		{
			font-size: 18px;
			text-shadow: 0 0 0 transparent, 1px 1px 10px white;
			color: rgb(10, 10, 10);
			white-space: nowrap;
			word-wrap: normal;
		}

		#alerts
		{
			zoom: 1;
		}

		#alerts #alertMessages
		{
			padding-left: 5px;
		}

		#alerts li.alertItem
		{
			font-size: 11px;
		}

			#alerts .label
			{
				color: rgb(10, 10, 10);
			}

.footer .pageContent
{
border-top: 1px solid rgb(35,35,35);
	font-size: 12px;
color: rgb(67, 67, 67);
background-color: rgb(18, 18, 18);
-webkit-border-bottom-right-radius: 10px; -moz-border-radius-bottomright: 10px; -khtml-border-bottom-right-radius: 10px; border-bottom-right-radius: 10px;
-webkit-border-bottom-left-radius: 10px; -moz-border-radius-bottomleft: 10px; -khtml-border-bottom-left-radius: 10px; border-bottom-left-radius: 10px;
overflow: hidden;
zoom: 1;

}
	
	.footer a,
	.footer a:visited
	{
		color: rgb(200,200,200);
padding: 12px 5px;
display: block;

	}
	
		.footer a:hover,
		.footer a:active
		{
			color: rgb(87, 87, 87);

		}

	.footer .choosers
	{
		padding-left: 5px;
float: left;
overflow: hidden;
zoom: 1;

	}
	
		.footer .choosers dt
		{
			display: none;
		}
		
		.footer .choosers dd
		{
			float: left;
			
		}
		
	.footerLinks
	{
		padding-right: 5px;
float: right;
overflow: hidden;
zoom: 1;

	}
	
		.footerLinks li
		{
			float: left;
			
		}
		

.footerLegal .pageContent
{
	font-size: 12px;
	overflow: hidden; zoom: 1;
	padding: 8px;
	text-align: center;
}
	
	#copyright
	{
		color: rgb(100,100,100);
		float: left;
	}
	
	#legal
	{
		float: right;
	}
	
		#legal li
		{
			float: left;
			
			margin-left: 10px;
		}


@media (max-width:610px)
{
	.Responsive .footerLinks a.globalFeed,
	.Responsive .footerLinks a.topLink,
	.Responsive .footerLinks a.homeLink
	{
		display: none;
	}

	.Responsive .footerLegal .debugInfo
	{
		clear: both;
	}
}

@media (max-width:480px)
{
	.Responsive #copyright span
	{
		display: none;
	}
}


.breadBoxTop,
.breadBoxBottom
{
	padding: 10px 0;
overflow: hidden;
zoom: 1;
clear: both;
-webkit-box-sizing: border-box; -moz-box-sizing: border-box; -ms-box-sizing: border-box; box-sizing: border-box;

}

.breadBoxTop
{
}

.breadBoxTop .topCtrl
{
	margin-left: 5px;
float: right;
line-height: 24px;

}

.breadcrumb
{
	font-size: 12px;
background-color: rgb(18, 18, 18);
border: 1px solid rgb(35, 35, 35);
-webkit-border-radius: 5px; -moz-border-radius: 5px; -khtml-border-radius: 5px; border-radius: 5px;
overflow: hidden;
zoom: 1;
max-width: 100%;
height: 24px;

}

.breadcrumb.showAll
{
	height: auto;
}

.breadcrumb .boardTitle
{
	display: none;

}

.breadcrumb .crust
{
	display: block;
float: left;
position: relative;
zoom: 1;
max-width: 50%;

}

.breadcrumb .crust a.crumb
{
	cursor: pointer;
	text-decoration: none;
padding: 0 10px 0 18px;
border-bottom-width: 0px;
outline: 0 none;
-moz-outline-style: 0 none;
display: block;
_border-bottom: none;
line-height: 24px;

}

	.breadcrumb .crust a.crumb > span
	{
		display: block;
		text-overflow: ellipsis;
		word-wrap: normal;
		white-space: nowrap;
		overflow: hidden;
		max-width: 100%;
	}

	.breadcrumb .crust:first-child a.crumb,
	.breadcrumb .crust.firstVisibleCrumb a.crumb
	{
		padding-left: 10px;
-webkit-border-top-left-radius: 5px; -moz-border-radius-topleft: 5px; -khtml-border-top-left-radius: 5px; border-top-left-radius: 5px;
-webkit-border-bottom-left-radius: 5px; -moz-border-radius-bottomleft: 5px; -khtml-border-bottom-left-radius: 5px; border-bottom-left-radius: 5px;

	}
	
	.breadcrumb .crust:last-child a.crumb
	{
		font-weight: bold;

	}

.breadcrumb .crust .arrow
{
	border-color: transparent;
display: none;

}

.breadcrumb .crust .arrow span
{
	border-color: transparent;
display: none;

}

.breadcrumb .crust:hover a.crumb
{
	color: rgb(213, 211, 211);

}

.breadcrumb .crust:hover .arrow span
{
	border-left-color: ;
}

	.breadcrumb .crust .arrow
	{
		/* hide from IE6 */
		_display: none;
	}

.breadcrumb .jumpMenuTrigger
{
	font-size: 14px;
background-color: transparent;
margin-right: 5px;
margin-left: 5px;
display: block;
float: right;
white-space: nowrap;
overflow: hidden;
line-height: 30px;
width: 16px;
height: 30px;

}


@media (max-width:480px)
{
	.Responsive .breadBoxTop.withTopCtrl
	{
		display: table;
		table-layout: fixed;
		width: 100%;
	}

	.Responsive .breadBoxTop.withTopCtrl nav
	{
		display: table-header-group;
	}

	.Responsive .breadBoxTop.withTopCtrl .topCtrl
	{
		display: table-footer-group;
		margin-top: 5px;
		text-align: right;
	}
}


.xbnavLogo
{
	float: left;
}
.xbnavLogo img
{
	max-height: 30px;
}
.fixed
{
	position: fixed !important;
	z-index: 95;
	top: 0;
	width: 100%;
	z-index: 101;
}
.xbBoxedStyle .fixed
{
	left: 0;
}
.fixed .navTabs .navLink .itemCount
{
	top: 0;
}

.fixed .navTabs
{
	-webkit-border-radius: 0px; -moz-border-radius: 0px; -khtml-border-radius: 0px; border-radius: 0px;

}
.navTabs .visitorTabs .navLink .fa
{
	line-height: 30px;
	vertical-align: middle;
	font-size: 18px;
}
.navTabs .visitorTabs .navLink .miniMe
{
        margin-right: 10px;
vertical-align: middle;
width: 20px;
height: 20px;

}
.XenBase .navTabs .navTab.selected .tabLinks
{
        background: rgb(0, 0, 0) url('../images/subnavbg.png') repeat-x 0 0;
margin-top: 30px;

}
.navPopup .listPlaceholder ol.secondaryContent.Unread
{
	
}

.XenBase #AccountMenu
{
	width: 295px;

}

.XenBase #AccountMenu .menuColumns a, .XenBase #AccountMenu .menuColumns label
{
	width: 125px;

}

#logoBlock .pageContent
{
		
}

#logoBlock
{
		
}


.navTabs .navTab.account .navLink .accountUsername
{
	display: inline-block;
}
















#navigation .pageContent
{
	
	height: 75px;
	
	position: relative;
}

#navigation .menuIcon
{
	position: relative;
	font-size:18px;
	width: 16px;
	display: inline-block;
	text-indent: -9999px;
}

#navigation .PopupOpen .menuIcon:before,
#navigation .navLink .menuIcon:before
{
	zoom: 1;
}

#navigation .menuIcon:before
{
	content: "";
	font-size: 18px;
	position: absolute;
	top: 0.6em;
	left: 0;
	width: 16px;
	height: 2px;
	border-top: 6px double currentColor;
	border-bottom: 2px solid currentColor;
}

	.navTabs
	{
		font-size: 12px;
font-family: 'Oswald', sans-serif;
background: rgb(15, 15, 15) url('../images/mainnavbg.png') repeat-x -30px center;
padding: 15px 20px;
-webkit-border-top-left-radius: 10px; -moz-border-radius-topleft: 10px; -khtml-border-top-left-radius: 10px; border-top-left-radius: 10px;
-webkit-border-top-right-radius: 10px; -moz-border-radius-topright: 10px; -khtml-border-top-right-radius: 10px; border-top-right-radius: 10px;

		border-bottom:1px solid rgb(35,35,35);
		border-top: 1px solid rgb(35,35,35);
		height: 30px;
	}
	
		.navTabs .publicTabs
		{
			float: left;
			
		}
		
		.navTabs .visitorTabs
		{
			float: right;
			
		}
		
			.navTabs .navTab
			{
				float: left;
				white-space: nowrap;
				word-wrap: normal;
				
			}


/* ---------------------------------------- */
/* Links Inside Tabs */

.navTabs .navLink,
.navTabs .SplitCtrl
{
	color: rgb(255, 255, 255);
display: block;
float: left;
vertical-align: text-bottom;
text-align: center;
outline: 0 none;

	
	
	
	height: 30px;
	line-height: 30px;
}

	.navTabs .publicTabs .navLink
	{
		padding: 0 15px;
	}
	
	.navTabs .visitorTabs .navLink
	{
		padding: 0 10px;
	}
	.navTabs .navTab:hover
	{
		background-color: transparent;
	}
	.navTabs .navLink:hover
	{
		text-decoration: none;
	}
	
	/* ---------------------------------------- */
	/* unselected tab, popup closed */

	.navTabs .navTab.PopupClosed
	{
		position: relative;
	}
		
		.navTabs .navTab.PopupClosed:hover .navLink, .navTabs .navTab.PopupClosed:hover .SplitCtrl
		{
			color: rgb(228, 137, 27);
background: url(background: rgba(0, 0, 0, 0); _filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#00000000,endColorstr=#00000000);

		}
		
			.navTabs .navTab.PopupClosed:hover .navLink
			{
				color: rgb(228, 137, 27);
			}
		
	
	.navTabs .navTab.PopupClosed .SplitCtrl
	{
		margin-left: -14px;
		width: 14px;
	}
		
		.XenBase .navTabs .navTab.PopupClosed:hover .SplitCtrl
		{
			position: relative;
			background-color: transparent;
		}
	
	/* ---------------------------------------- */
	/* selected tab */

	html .navTabs .navTab.selected .navLink
	{
		position: relative;
		color: rgb(255, 255, 255);
background: rgb(87, 87, 87) url('../images/gradient.png') repeat-x center;
padding: 5px 10px 3px;
margin-top: -3px;
-webkit-border-radius: 5px; -moz-border-radius: 5px; -khtml-border-radius: 5px; border-radius: 5px;

	}
	
	
	.navTabs .navTab.selected .SplitCtrl
	{
		display: none;
	}
	
	
	/* ---------------------------------------- */
	/* selected tab, popup open (account) */
	
	html .navTabs .navTab.PopupOpen .navLink
	{
		color: rgb(228, 137, 27);

	}
	
/* ---------------------------------------- */
/* Second Row */

.navTabs .navTab.selected .tabLinks
{
    background: rgb(138, 45, 20) url('../images/gradient.png') repeat-x center;
    width: 100%;
    padding: 0;
    border: none;
    overflow: hidden;
    zoom: 1;
    position: absolute;
    left: 0px;
    top: 30px;
    height: 45px;
}

	.navTabs .navTab.selected .blockLinksList
	{
		background: none;
		padding: 0;
		border: none;
		margin-left: 8px;
	}
	
	@media(min-width:800px)
	{
		.withSearch .navTabs .navTab.selected .blockLinksList
		{
			margin-right: 275px;
		}
	}

	.navTabs .navTab.selected .tabLinks .menuHeader
	{
		display: none;
	}
	
	.navTabs .navTab.selected .tabLinks li
	{
		float: left;
		padding: 2px 0;
	}
	
		.navTabs .navTab.selected .tabLinks a
		{
			font-size: 12px;
font-family: 'Trebuchet MS',Helvetica,Arial,sans-serif;
color: rgb(166, 166, 166);
padding: 1px 10px;
display: block;
font-weight: normal;

			
			line-height: 39px;
		}
		
		.navTabs .navTab.selected .tabLinks .PopupOpen a
		{
			color: inherit;
			text-shadow: none;
		}
		
			.navTabs .navTab.selected .tabLinks a:hover,
			.navTabs .navTab.selected .tabLinks a:focus
			{
				color: rgb(228, 137, 27);
text-decoration: none;
background: url(background: rgba(0, 0, 0, 0); _filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#00000000,endColorstr=#00000000);
padding: 1px 10px;
border-width: 0px;
outline: 0;

			}
			
			.navTabs .navTab.selected .tabLinks .Popup a:hover,
			.navTabs .navTab.selected .tabLinks .Popup a:focus
			{
				color: inherit;
				background: none;
				border-color: transparent;
				-webkit-border-radius: 0; -moz-border-radius: 0; -khtml-border-radius: 0; border-radius: 0;
				text-shadow: none;
			}
	
/* ---------------------------------------- */
/* Alert Balloons */
	
.navTabs .navLink .itemCount
{
	font-weight: bold;
font-size: 9px;
color: white;
background-color: #e03030;
padding: 0 2px;
-webkit-border-radius: 2px; -moz-border-radius: 2px; -khtml-border-radius: 2px; border-radius: 2px;
position: absolute;
right: 2px;
top: -20px;
line-height: 16px;
min-width: 12px;
_width: 12px;
text-align: center;
text-shadow: none;
white-space: nowrap;
word-wrap: normal;
-webkit-box-shadow: 2px 2px 5px rgba(0,0,0, 0.25); -moz-box-shadow: 2px 2px 5px rgba(0,0,0, 0.25); -khtml-box-shadow: 2px 2px 5px rgba(0,0,0, 0.25); box-shadow: 2px 2px 5px rgba(0,0,0, 0.25);
height: 16px;

}

	.navTabs .navLink .itemCount .arrow
	{
		border: 3px solid transparent;
border-top-color: rgb(224, 48, 48);
border-bottom: 1px none black;
position: absolute;
bottom: -3px;
right: 4px;
line-height: 0px;
text-shadow: none;
_display: none;
/* Hide from IE6 */
width: 0px;
height: 0px;

	}
	
.navTabs .navLink .itemCount.Zero
{
	display: none;
}

.navTabs .navLink .itemCount.ResponsiveOnly
{
	display: none !important;
}

.NoResponsive #VisitorExtraMenu_Counter,
.NoResponsive #VisitorExtraMenu_ConversationsCounter,
.NoResponsive #VisitorExtraMenu_AlertsCounter
{
	display: none !important;
}
	
/* ---------------------------------------- */
/* Account Popup Menu */

	.navTabs .navTab.account .navLink .accountUsername
	{
		display: block;
		max-width: 100px;
		overflow: hidden;
		text-overflow: ellipsis;
	}

#AccountMenu
{
	width: 274px;
}

#AccountMenu .menuHeader
{
	position: relative;
}

	#AccountMenu .menuHeader .avatar
	{
		float: left;
		margin-right: 10px;
	}

	#AccountMenu .menuHeader .visibilityForm
	{
		margin-top: 10px;
		color: rgb(24, 24, 24);
	}
	
	#AccountMenu .menuHeader .links .fl
	{
		position: absolute;
		bottom: 10px;
		left: 116px;
	}

	#AccountMenu .menuHeader .links .fr
	{
		position: absolute;
		bottom: 10px;
		right: 10px;
	}
	
#AccountMenu .menuColumns
{
	overflow: hidden; zoom: 1;
	padding: 2px;
}

	#AccountMenu .menuColumns ul
	{
		float: left;
		padding: 0;
		max-height: none;
		overflow: hidden;
	}

		#AccountMenu .menuColumns a,
		#AccountMenu .menuColumns label
		{
			width: 115px;
		}

#AccountMenu .statusPoster textarea
{
	width: 245px;
	margin: 0;
	resize: vertical;
	overflow: hidden;
}

#AccountMenu .statusPoster .submitUnit
{
	margin-top: 5px;
	text-align: right;
}

	#AccountMenu .statusPoster .submitUnit .statusEditorCounter
	{
		float: left;
		line-height: 23px;
		height: 23px;
	}
	
/* ---------------------------------------- */
/* Inbox, Alerts Popups */

.navPopup
{
	width: 260px;
}

.navPopup a:hover,
.navPopup .listItemText a:hover
{
	background: none;
	text-decoration: underline;
}

	.navPopup .menuHeader .InProgress
	{
		float: right;
		display: block;
		width: 20px;
		height: 20px;
	}

.navPopup .listPlaceholder
{
	max-height: 350px;
	overflow: auto;
}

	.navPopup .listPlaceholder ol.secondaryContent
	{
		padding: 0 10px;
	}

		.navPopup .listPlaceholder ol.secondaryContent.Unread
		{
			background-color: rgb(99, 21, 22);
		}

.navPopup .listItem
{
	overflow: hidden; zoom: 1;
	padding: 5px 0;
	border-bottom: 1px solid rgb(69, 69, 69);
}

.navPopup .listItem:last-child
{
	border-bottom: none;
}

.navPopup .PopupItemLinkActive:hover
{
	margin: 0 -8px;
	padding: 5px 8px;
	-webkit-border-radius: 5px; -moz-border-radius: 5px; -khtml-border-radius: 5px; border-radius: 5px;
	background-color: rgb(69, 69, 69);
	cursor: pointer;
}

.navPopup .avatar
{
	float: left;
}

	.navPopup .avatar img
	{
		width: 32px;
		height: 32px;
	}

.navPopup .listItemText
{
	margin-left: 37px;
}

	.navPopup .listItemText .muted
	{
		font-size: 9px;
	}

	.navPopup .unread .listItemText .title,
	.navPopup .listItemText .subject
	{
		font-weight: bold;
	}

.navPopup .sectionFooter .floatLink
{
	float: right;
}
.xbSearchNav
{
	float: right;
}

/* clearfix */ #navigation { zoom: 1; } #navigation:after { content: '.'; display: block; height: 0; clear: both; visibility: hidden; }


@media (max-width:800px)
{
	.Responsive #logoBlock .pageWidth
	{
		padding: 0 10px;
	}
}
@media (max-width:610px)
{
	.Responsive .navTabs
	{
		padding-left: 10px;
		padding-right: 10px;
	}
}

@media (max-width:480px)
{
	.Responsive.hasJs .navTabs:not(.showAll) .publicTabs .navTab:not(.selected):not(.navigationHiddenTabs)
	{
		display: none;
	}
}
@media(max-width:800px)
{
	.Responsive .withSearch .navTabs .navTab.selected .blockLinksList
	{
		margin-right: 50px;
	}
}


#searchBar
{
	position: relative;
	zoom: 1;
	z-index: 52; /* higher than breadcrumb arrows */
}

	#QuickSearchPlaceholder
	{
		top: -40px;
		
		
		font-size: 17px;
color: rgb(228, 137, 27);
background-color: transparent;
margin-top: -3px;
-webkit-border-radius: 5px; -moz-border-radius: 5px; -khtml-border-radius: 5px; border-radius: 5px;
position: absolute;
right: 20px;
display: none;
cursor: pointer;
-webkit-box-sizing: border-box; -moz-box-sizing: border-box; -ms-box-sizing: border-box; box-sizing: border-box;
overflow: hidden;
top: 0px;
width: 16px;
height: 20px;

		
	}

	#QuickSearch
	{
		top: -27.5px;
		background-color: rgb(11, 11, 11);
padding-top: 5px;
padding-bottom: 3px;
margin: 0;
border-width: 0px;
-webkit-border-radius: 5px; -moz-border-radius: 5px; -khtml-border-radius: 5px; border-radius: 5px;
display: block;
position: absolute;
right: 20px;
_padding-top: 3px;
z-index: 7500;

	}
	#QuickSearch .formPopup 
	{
		background-color: transparent;
	}
	#QuickSearch .formPopup .controlsWrapper .textCtrl
	{
		width: 210px;
	}
	#QuickSearch .formPopup .controlsWrapper
	{
		background-image: none;
padding: 10px;

	}
			
		#QuickSearch .secondaryControls
		{
			display: none;

		}
	
		#QuickSearch.active
		{
			background-color: rgb(20, 20, 20);
padding-bottom: 5px;
-webkit-box-shadow: 5px 5px 25px rgba(0,0,0, 0.5); -moz-box-shadow: 5px 5px 25px rgba(0,0,0, 0.5); -khtml-box-shadow: 5px 5px 25px rgba(0,0,0, 0.5); box-shadow: 5px 5px 25px rgba(0,0,0, 0.5);

		}
		
	#QuickSearch .submitUnit
	{
	min-width: 0;
	}
		
	#QuickSearch 
	{

		float: left;
		width: 110px;

	}
	
	#QuickSearch #commonSearches
	{
		float: right;
	}
	
		#QuickSearch #commonSearches
		{
			width: 23px;
			padding: 0;
		}
		
			#QuickSearch #commonSearches .arrowWidget
			{
				margin: 0;
				float: left;
				margin-left: 4px;
				margin-top: 0px;
				background: none;
			}
	
	#QuickSearch .moreOptions
	{
		display: block;
		margin: 0 25px 0 112px;
		width: auto;
	}
#QuickSearch #commonSearches:hover .arrowWidget:before
{
	color: rgb(87, 87, 87);
}	
#QuickSearch #commonSearches .arrowWidget:before
{
	display: inline-block;
	content: "\f13a";
	font-family: FontAwesome;
	font-style: normal;
	font-weight: normal;
	font-size: 14px;
	position: relative;
	color: rgb(255, 255, 255);
	line-height: normal;
}

#QuickSearch #commonSearches .PopupControl.PopupOpen .arrowWidget:before
{
	content: "\f139";
	color: rgb(228, 137, 27);
}

#QuickSearch .formPopup .primaryControls
{
	
}

#QuickSearchQuery
{
	background-color: rgb(36, 36, 36);
border: 1px solid rgb(35, 35, 35);
-webkit-border-radius: 5px; -moz-border-radius: 5px; -khtml-border-radius: 5px; border-radius: 5px;

}

@media (max-width:800px)
{
	.Responsive #QuickSearchPlaceholder
	{
		display: block;
	}

	.Responsive #QuickSearchPlaceholder.hide
	{
		visibility: hidden;
	}

	.Responsive #QuickSearch
	{
		display: none;
	}

	.Responsive #QuickSearch.show
	{
		display: block;
	}
}



 

/** move the header to the top again **/

#headerMover
{
	position: relative;
	zoom: 1;
}

	
	#headerMover #headerProxy
	{
		
		
		height: 314px; /* +2 borders */
		
	}
	
	#headerMover #header
	{
		width: 100%;
		position: absolute;
		top: 0px;
		left: 0px;
	}
	


/** Generic page containers **/

.pageWidth
{
_margin: 0 auto;
-webkit-box-sizing: border-box; 
-moz-box-sizing: border-box; 
-ms-box-sizing: border-box; 
box-sizing: border-box;

}

.NoResponsive body
{
	min-width: 976px;
}

#content .pageContent
{
	background-color: rgb(11, 11, 11);
padding: 10px 20px;
position: relative;

}

/* clearfix */ #content .pageContent { zoom: 1; } #content .pageContent:after { content: '.'; display: block; height: 0; clear: both; visibility: hidden; }

/* sidebar structural elements */


.mainContainer
{
	 float: left;
	 margin-right: -270px;
	 width: 100%;
}
.mainContent
{
	margin-right: 270px;
}

.sidebar
{
	float: right;
	font-size: 12px;
width: 260px;

}







/* visitor panel */

.sidebar .visitorPanel
{
	overflow: hidden; zoom: 1;
}

	.sidebar .visitorPanel h2 .muted
	{
		display: none;
	}

	.sidebar .visitorPanel .avatar
	{
		margin-right: 5px;
float: left;

		
		width: auto;
		height: auto;
	}
	
		.sidebar .visitorPanel .avatar img
		{
			width: ;
			height: ;
		}
	
	.sidebar .visitorPanel .username
	{
		font-weight: bold;
font-size: 11pt;

	}
	
	.sidebar .visitorPanel .stats
	{
		margin-top: 2px;

	}
	
	.sidebar .visitorPanel .stats .pairsJustified
	{
		line-height: normal;
	}













	
/* generic sidebar blocks */
		
.sidebar .section .primaryContent   h3,
.sidebar .section .secondaryContent h3,
.profilePage .mast .section.infoBlock h3, .XenBase .xengallerySideBarContainer .xengallerySideBar .section h3
{
	font-size: 14px;
font-family: 'Oswald', sans-serif;
color: rgb(255, 255, 255);
background-image: url('../images/sidebarhead.png');
background-repeat: repeat-x;
padding-top: 9px;
padding-bottom: 4px;
padding-left: 10px;
margin: -12px -10px 5px;
height: 28px;

}

.sidebar .section .primaryContent   h3 a,
.sidebar .section .secondaryContent h3 a
{
	color: rgb(255, 255, 255);
}

.sidebar .section .secondaryContent .footnote,
.sidebar .section .secondaryContent .minorHeading
{
	color: rgb(150, 150, 150);
margin-top: 5px;

}

	.sidebar .section .secondaryContent .minorHeading a
	{
		color: rgb(150, 150, 150);
	}












/* list of users with 32px avatars, username and user title */

.sidebar .avatarList li
{
	margin: 5px 0;
overflow: hidden;
zoom: 1;

}

	.sidebar .avatarList .avatar
	{
		margin-right: 5px;
float: left;
width: 32px;
height: 32px;

		
		width: auto;
		height: auto;
	}
		
	.sidebar .avatarList .avatar img
	{
		width: 32px;
		height: 32px;
	}
	
	.sidebar .avatarList .username
	{
		font-size: 11pt;
margin-top: 2px;
display: block;

	}
	
	.sidebar .avatarList .userTitle
	{
		color: rgb(150,150,150);

	}









/* list of users */

.sidebar .userList
{
}

	.sidebar .userList .username
	{
		font-size: 12px;

	}

	.sidebar .userList .username.invisible
	{
		color: rgb(228, 137, 27);

	}
	
	.sidebar .userList .username.followed
	{
		
	}

	.sidebar .userList .moreLink
	{
		display: block;
	}
	
	
	
	
/* people you follow online now */

.followedOnline
{
	margin-top: 3px;
margin-bottom: -5px;
overflow: hidden;
zoom: 1;

}

.followedOnline li
{
	margin-right: 5px;
margin-bottom: 5px;
float: left;

}

	.followedOnline .avatar
	{
		width: 32px;
height: 32px;

		
		width: auto;
		height: auto;
	}
	
		.followedOnline .avatar img
		{
			width: 32px;
			height: 32px;
		}
	
	
	

	
	
/* call to action */

#SignupButton
{
	margin: 10px 30px;
text-align: center;
line-height: 30px;
-webkit-box-shadow: 0px 2px 5px rgba(0,0,0, 0.2); -moz-box-shadow: 0px 2px 5px rgba(0,0,0, 0.2); -khtml-box-shadow: 0px 2px 5px rgba(0,0,0, 0.2); box-shadow: 0px 2px 5px rgba(0,0,0, 0.2);
display: block;
cursor: pointer;
height: 30px;

}

	#SignupButton .inner
	{
		font-weight: bold;
font-size: 16px;
font-family: 'Oswald', sans-serif;
color: rgb(41, 38, 38);
border-width: 1px;
border-style: solid;
border-top-color: rgb(220, 200, 161);
border-right-color: rgb(152, 118, 40);
border-bottom-color: rgb(255, 176, 0);
border-left-color: rgb(152, 118, 40);
-webkit-border-radius: 4px; -moz-border-radius: 4px; -khtml-border-radius: 4px; border-radius: 4px;
display: block;
text-shadow: 0 0 0 transparent, 0px 0px 3px rgba(255,255,255, 0.5);
background: #fff984; /* Old browsers */
background: -moz-linear-gradient(top,  #fff984 0%, #ffed54 2%, #ffae04 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#fff984), color-stop(2%,#ffed54), color-stop(100%,#ffae04)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #fff984 0%,#ffed54 2%,#ffae04 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #fff984 0%,#ffed54 2%,#ffae04 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #fff984 0%,#ffed54 2%,#ffae04 100%); /* IE10+ */
background: linear-gradient(to bottom,  #fff984 0%,#ffed54 2%,#ffae04 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fff984', endColorstr='#ffae04',GradientType=0 ); /* IE6-9 */

	}
	
	#SignupButton:hover .inner
	{
		text-decoration: none;

	}
	
	#SignupButton:active
	{
		-webkit-box-shadow: 0 0 3px rgba(0,0,0, 0.2); -moz-box-shadow: 0 0 3px rgba(0,0,0, 0.2); -khtml-box-shadow: 0 0 3px rgba(0,0,0, 0.2); box-shadow: 0 0 3px rgba(0,0,0, 0.2);
/*position: relative;
		top: 2px;*/

	}


@media (max-width:800px)
{
	.Responsive .mainContainer
	{
		 float: none;
		 margin-right: 0;
		 width: auto;
	}

		.Responsive .mainContent
		{
			margin-right: 0;
		}
	
	.Responsive .sidebar
	{
		float: none;
		margin: 0 auto;
	}

		.Responsive .sidebar .visitorPanel
		{
			display: none;
		}
}

@media (max-width:340px)
{
	.Responsive .sidebar
	{
		width: 100%;
	}
}


/* XenBase Sidebar */
.sidebar .section, .xengallerySideBar .section {
	
}

.sidebar .secondaryContent, .xengallerySideBar .secondaryContent {
	
}

.sidebar .visitorPanel
{
		
}

.sidebar .visitorPanel .secondaryContent
{
		
}
.sidebar .loginButton .xbSocialLogins
{
		
}
html .profilePage .mast .section.infoBlock
{
	border-color: rgb(35, 35, 35);
}
html .container .xengallerySideBar .section h3
{
	font-size: 14px;
font-family: 'Oswald', sans-serif;
color: rgb(255, 255, 255);
background-image: url('../images/sidebarhead.png');
background-repeat: repeat-x;
padding-top: 9px;
padding-bottom: 4px;
padding-left: 10px;
margin: -12px -10px 5px;
height: 28px;

}

/** Text used in message bodies **/

.messageText
{
	font-size: 14px;
color: rgb(166, 166, 166);
line-height: 1.4;

}

	.messageText img,
	.messageText iframe,
	.messageText object,
	.messageText embed
	{
		max-width: 100%;
	}

/** Link groups and pagenav container **/

.pageNavLinkGroup
{
	display: table;
	*zoom: 1;
	table-layout: fixed;
	-webkit-box-sizing: border-box; -moz-box-sizing: border-box; -ms-box-sizing: border-box; box-sizing: border-box;
	
	font-size: 12px;
margin: 10px 0;
line-height: 16px;

}

opera:-o-prefocus, .pageNavLinkGroup
{
	display: block;
	overflow: hidden;
}

	.pageNavLinkGroup:after
	{
		content: ". .";
		display: block;
		word-spacing: 99in;
		overflow: hidden;
		height: 0;
		font-size: 0.13em;
		line-height: 0;
	}

	.pageNavLinkGroup .linkGroup
	{
		float: right;
	}

.linkGroup
{
}
	
	.linkGroup a
	{
		padding-top: 5px;

	}

		.linkGroup a.inline
		{
			padding: 0;
		}

	.linkGroup a,
	.linkGroup .Popup,
	.linkGroup .element
	{
		margin-left: 10px;
		display: block;
		float: left;
		
	}
	
		.linkGroup .Popup a
		{
			margin-left: -2px;
			margin-right: -5px;
			*margin-left: 10px;
			padding: 5px 5px;
		}

	.linkGroup .element
	{
		padding: 3px 0;
	}

/** Call to action buttons **/

a.callToAction
{
	background: rgb(87, 87, 87) url('../images/gradient.png') repeat-x center top;
padding: 2px;
border: 1px solid rgb(87, 87, 87);
-webkit-border-radius: 5px; -moz-border-radius: 5px; -khtml-border-radius: 5px; border-radius: 5px;
display: inline-block;
line-height: 26px;
outline: 0 none;
height: 26px;

	
}

	a.callToAction span
	{
		font-weight: bold;
font-size: 12px;
font-family: 'Oswald', sans-serif;
color: rgb(255, 255, 255);
padding: 0 15px;
-webkit-border-radius: 3px; -moz-border-radius: 3px; -khtml-border-radius: 3px; border-radius: 3px;
display: block;
/*text-shadow: 0 0 0 transparent, 0px 0px 3px rgb(24, 24, 24);*/

	}
	
	a.callToAction:hover
	{
		text-decoration: none;
	}

		a.callToAction:hover span
		{
			color: rgb(206, 206, 206);

		}
		
		a.callToAction:active
		{
			/*position: relative;
			top: 2px;*/
		}
		
		a.callToAction:active span
		{
			
		}

/*********/

.avatarHeap
{
	overflow: hidden; zoom: 1;
}

	.avatarHeap ol
	{
		margin-right: -4px;
		margin-top: -4px;
	}
	
		.avatarHeap li
		{
			float: left;
			margin-right: 4px;
			margin-top: 4px;
		}
		
		.avatarHeap li .avatar
		{
			display: block;
		}
		
/*********/

.fbWidgetBlock .fb_iframe_widget,
.fbWidgetBlock .fb_iframe_widget > span,
.fbWidgetBlock .fb_iframe_widget iframe
{
	width: 100% !important;
}

/*********/

.tagBlock
{
	margin: 10px 0;
	font-size: 11px;
}

.tagList,
.tagList li
{
	display: inline;
}


.tagList .tag
{
	position: relative;
	display: inline-block;
	background: rgb(18, 18, 18);
	margin-left: 9px;
	height: 14px;
	line-height: 14px;
	padding: 1px 4px 1px 6px;
	border: 1px solid rgb(35, 35, 35);
	border-left: none;
	-webkit-border-radius: 4px; -moz-border-radius: 4px; -khtml-border-radius: 4px; border-radius: 4px;
	-webkit-border-top-left-radius: 0; -moz-border-radius-topleft: 0; -khtml-border-top-left-radius: 0; border-top-left-radius: 0;
	-webkit-border-bottom-left-radius: 0; -moz-border-radius-bottomleft: 0; -khtml-border-bottom-left-radius: 0; border-bottom-left-radius: 0;
	color: rgb(166, 166, 166);
	font-size: 11px;
	margin-bottom: 2px;
}

	.tagList .tag:hover
	{
		text-decoration: none;
		background-color: rgb(20, 20, 20);
		color: ;
		border-color: rgb(31, 31, 31);
	}
	
	.tagList .tag:hover .arrow
	{
		border-right-color: rgb(31, 31, 31);
	}

	.tagList .tag .arrow
	{
		content: '';
		position: absolute;
		display: block;
		height: 2px;
		width: 0;
		left: -9px;
		top: -1px;
		border-style: solid;
		border-width: 8px 9px 8px 0;
		border-color: transparent;
		border-right-color: rgb(35, 35, 35);
	}

		.tagList .tag .arrow:after
		{
			content: '';
			position: absolute;
			display: block;
			height: 2px;
			width: 0;
			left: 1px;
			top: -7px;
			border-style: solid;
			border-width: 7px 8px 7px 0;
			border-color: transparent;
			border-right-color: rgb(18, 18, 18);
		}

		.tagList .tag:hover .arrow:after
		{
			border-right-color: rgb(20, 20, 20);
		}

	.tagList .tag:after
	{
		content: '';
		position: absolute;
		left: -2px;
		top: 6px;
		display: block;
		height: 3px;
		width: 3px;
		-webkit-border-radius: 50%; -moz-border-radius: 50%; -khtml-border-radius: 50%; border-radius: 50%;
		border: 1px solid rgb(35, 35, 35);
		background: rgb(11, 11, 11);
	}

/* User name classes */


.username .banned
{
	text-decoration: line-through;
}

.prefix
{
	background: transparent url('../images/form-button-white-25px.png') repeat-x top;
padding: 0px 6px;
margin: -1px 0;
border: 1px solid transparent;
-webkit-border-radius: 3px; -moz-border-radius: 3px; -khtml-border-radius: 3px; border-radius: 3px;
display: inline-block;

}

a.prefixLink:hover
{
	text-decoration: none;
}

a.prefixLink:hover .prefix
{
	color: rgb(24, 24, 24);
text-decoration: none;
background-color: rgb(78, 78, 78);
padding: 0 6px;
border: 1px solid rgb(67, 67, 67);

}

.prefix a { color: inherit; }

.prefix.prefixPrimary    { color: rgb(24, 24, 24); background-color: rgb(69, 69, 69); border-color: rgb(69, 69, 69); }
.prefix.prefixSecondary  { color: rgb(24, 24, 24); background-color: rgb(23, 23, 23); border-color: rgb(23, 23, 23); }

.prefix.prefixRed        { color: white; background-color: red; border-color: #F88; }
.prefix.prefixGreen      { color: white; background-color: green; border-color: green; }
.prefix.prefixOlive      { color: black; background-color: olive; border-color: olive; }
.prefix.prefixLightGreen { color: black; background-color: lightgreen; border-color: lightgreen; }
.prefix.prefixBlue       { color: white; background-color: blue; border-color: #88F; }
.prefix.prefixRoyalBlue  { color: white; background-color: royalblue; border-color: #81A9E1;  }
.prefix.prefixSkyBlue    { color: black; background-color: skyblue; border-color: skyblue; }
.prefix.prefixGray       { color: black; background-color: gray; border-color: #AAA; }
.prefix.prefixSilver     { color: black; background-color: silver; border-color: silver; }
.prefix.prefixYellow     { color: black; background-color: yellow; border-color: #E0E000; }
.prefix.prefixOrange     { color: black; background-color: orange; border-color: #FFC520; }

.discussionListItem .prefix,
.searchResult .prefix
{
	font-size: 80%;
margin: 0;
line-height: 16px;

	
	font-weight: normal;
}

h1 .prefix
{
	font-size: 80%;
margin: 0;
line-height: 16px;

	
	line-height: normal;
}

.breadcrumb span.prefix,
.heading span.prefix
{
	font-style: italic;
font-weight: bold;
padding: 0;
margin: 0;
border: 0 none black;
-webkit-border-radius: 0; -moz-border-radius: 0; -khtml-border-radius: 0; border-radius: 0;
display: inline;

	color: inherit;
}

.userBanner
{
	font-size: 11px;
	background: transparent url('../images/form-button-white-25px.png') repeat-x top;
	padding: 1px 5px;
	border: 1px solid transparent;
	-webkit-border-radius: 3px; -moz-border-radius: 3px; -khtml-border-radius: 3px; border-radius: 3px;
	-webkit-box-shadow: 1px 1px 3px rgba(0,0,0, 0.25); -moz-box-shadow: 1px 1px 3px rgba(0,0,0, 0.25); -khtml-box-shadow: 1px 1px 3px rgba(0,0,0, 0.25); box-shadow: 1px 1px 3px rgba(0,0,0, 0.25);
	text-align: center;
}

	.userBanner.wrapped
	{
		-webkit-border-top-right-radius: 0; -moz-border-radius-topright: 0; -khtml-border-top-right-radius: 0; border-top-right-radius: 0;
		-webkit-border-top-left-radius: 0; -moz-border-radius-topleft: 0; -khtml-border-top-left-radius: 0; border-top-left-radius: 0;
		position: relative;
	}
		
		.userBanner.wrapped span
		{
			position: absolute;
			top: -4px;
			width: 5px;
			height: 4px;
			background-color: inherit;
		}
		
		.userBanner.wrapped span.before
		{
			-webkit-border-top-left-radius: 3px; -moz-border-radius-topleft: 3px; -khtml-border-top-left-radius: 3px; border-top-left-radius: 3px;
			left: -1px;
		}
		
		.userBanner.wrapped span.after
		{
			-webkit-border-top-right-radius: 3px; -moz-border-radius-topright: 3px; -khtml-border-top-right-radius: 3px; border-top-right-radius: 3px;
			right: -1px;
		}
		
.userBanner.bannerHidden { background: none; -webkit-box-shadow: none; -moz-box-shadow: none; -khtml-box-shadow: none; box-shadow: none; border: none; }
.userBanner.bannerHidden.wrapped { margin-left: 0; margin-right: 0; }
.userBanner.bannerHidden.wrapped span { display: none; }

.userBanner.bannerStaff { color: rgb(24, 24, 24); background-color: rgb(69, 69, 69); border-color: rgb(67, 67, 67); }
.userBanner.bannerStaff.wrapped span { background-color: rgb(67, 67, 67); }

.userBanner.bannerPrimary { color: rgb(24, 24, 24); background-color: rgb(69, 69, 69); border-color: rgb(67, 67, 67); }
.userBanner.bannerPrimary.wrapped span { background-color: rgb(67, 67, 67); }

.userBanner.bannerSecondary { color: rgb(24, 24, 24); background-color: rgb(23, 23, 23); border-color: rgb(23, 23, 23); }
.userBanner.bannerSecondary.wrapped span { background-color: rgb(23, 23, 23); }

.userBanner.bannerRed        { color: white; background-color: red; border-color: #F88; }
.userBanner.bannerRed.wrapped span { background-color: #F88; }

.userBanner.bannerGreen      { color: white; background-color: green; border-color: green; }
.userBanner.bannerGreen.wrapped span { background-color: green; }

.userBanner.bannerOlive      { color: black; background-color: olive; border-color: olive; }
.userBanner.bannerOlive.wrapped span { background-color: olive; }

.userBanner.bannerLightGreen { color: black; background-color: lightgreen; border-color: lightgreen; }
.userBanner.bannerLightGreen.wrapped span { background-color: lightgreen; }

.userBanner.bannerBlue       { color: white; background-color: blue; border-color: #88F; }
.userBanner.bannerBlue.wrapped span { background-color: #88F; }

.userBanner.bannerRoyalBlue  { color: white; background-color: royalblue; border-color: #81A9E1;  }
.userBanner.bannerRoyalBlue.wrapped span { background-color: #81A9E1; }

.userBanner.bannerSkyBlue    { color: black; background-color: skyblue; border-color: skyblue; }
.userBanner.bannerSkyBlue.wrapped span { background-color: skyblue; }

.userBanner.bannerGray       { color: black; background-color: gray; border-color: #AAA; }
.userBanner.bannerGray.wrapped span { background-color: #AAA; }

.userBanner.bannerSilver     { color: black; background-color: silver; border-color: silver; }
.userBanner.bannerSilver.wrapped span { background-color: silver; }

.userBanner.bannerYellow     { color: black; background-color: yellow; border-color: #E0E000; }
.userBanner.bannerYellow.wrapped span { background-color: #E0E000; }

.userBanner.bannerOrange     { color: black; background-color: orange; border-color: #FFC520; }
.userBanner.bannerOrange.wrapped span { background-color: #FFC520; }


@media (max-width:800px)
{
	.Responsive .pageWidth
	{
		max-width: 100%;

	}

	.Responsive #content .pageContent
	{
		padding-left: 10px;
		padding-right: 10px;
	}
}

@media (max-width:610px)
{
	.Responsive .pageWidth
	{
		padding-right: 0;
padding-left: 0;
margin-right: 0;
margin-left: 0;

	}
	
	.Responsive .forum_view #pageDescription,
	.Responsive .thread_view #pageDescription
	{
		display: none;
	}
}

@media (max-width:480px)
{
	.Responsive .pageWidth
	{
		
	}
	
	.Responsive .pageNavLinkGroup .PageNav,
	.Responsive .pageNavLinkGroup .linkGroup
	{
		clear: right;
	}
}



	