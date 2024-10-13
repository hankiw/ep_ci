<%@ page language="java" import="java.io.*,java.util.*,java.text.*,crosscert.*" %>

<%@page import="com.webcash.idti.file.TaxInvoiceBeanFile"	%>
<%@page import="com.webcash.idti.acs.util.*"%>
<%@page import="java.util.HashMap"%>

<%@ page contentType = "text/html; charset=utf-8" %>
<%  
	/*-------------------------시작----------------------------*/ 
	response.setDateHeader("Expires",0); 
	response.setHeader("Prama","no-cache"); 

	if(request.getProtocol().equals("HTTP/1.1")) 
	{ 
		response.setHeader("Cache-Control","no-cache"); 
	} 
	/*------------------------- 끝----------------------------*/ 
	
	
	// 전자서명을 위한 XML 문서 생성
	HashMap taxMap  = new HashMap();
	
	TaxInvoiceBeanFile taxFile = new TaxInvoiceBeanFile();
	
	// 마스터 원장을 위한 변수
	String serv_id			= request.getParameter("SERV_ID"          ); 				// 서비스관리번호
 	String send_datetime	= request.getParameter("SEND_DATETIME"    ); 				// 발행일시 (전자서명 생성일시)
	String ISSU_ID			= request.getParameter("ISSU_ID"          );				// 국세청 승인번호
 	String erp_id			= request.getParameter("ERP_ID"        	  ); 				// 사업자관리번호
	String TAX_TYPE			= request.getParameter("TAX_TYPE"         );				// 세금계산서종류 (필수)
	String NOTE1			= request.getParameter("NOTE1"            );				// 비고1
	String ISSU_DATE		= request.getParameter("ISSU_DATE"        );				// 작성일자
	String MODY_CODE		= request.getParameter("MODY_CODE"        );				// 수정코드
	String POPS_CODE		= request.getParameter("POPS_CODE"        );				// 영수청구구분
	String IMPT_NO			= request.getParameter("IMPT_NO"          );				// 수입신고번호
	String ITEM_QUANT		= request.getParameter("ITEM_QUANT"       );				// 수입총건
	String ACEP_STAT_DATE	= request.getParameter("ACEP_STAT_DATE"   );				// 일괄발급시작일
	String ACEP_END_DATE	= request.getParameter("ACEP_END_DATE"    );				// 일괄발급종료일
	//String SELR_CORP_NO	= request.getParameter("SELR_CORP_NO"     );				// 공급자사업자번호 (필수)
	String SELR_CORP_NO		= "1234567891";												// 공급자사업자번호 (필수)
	String SELR_BUSS_CONS	= request.getParameter("SELR_BUSS_CONS"   );				// 공급자업태
	String SELR_CORP_NM		= request.getParameter("SELR_CORP_NM"     );				// 공급자상호 (필수)
	String SELR_BUSS_TYPE	= request.getParameter("SELR_BUSS_TYPE"   );				// 공급자업종
	String SELR_CODE		= request.getParameter("SELR_CODE"        );				// 공급자종사업장번호
	String SELR_CEO			= request.getParameter("SELR_CEO"         );				// 공급자대표자명 (필수)
	String SELR_CHRG_POST	= request.getParameter("SELR_CHRG_POST"   );				// 공급자 담당자부서
	String SELR_CHRG_NM		= request.getParameter("SELR_CHRG_NM"     );				// 공급자 담당자명
	String SELR_CHRG_TEL	= request.getParameter("SELR_CHRG_TEL"    );				// 공급자 담당자전화번호
	String SELR_CHRG_EMAIL	= request.getParameter("SELR_CHRG_EMAIL"  );				// 공급자 담당자이메일
	String SELR_ADDR		= request.getParameter("SELR_ADDR"        );				// 공급자주소
	String BUYR_CORP_NO		= request.getParameter("BUYR_CORP_NO"     );				// 공급받는자사업자번호 (필수)
	String BUYR_BUSS_CONS	= request.getParameter("BUYR_BUSS_CONS"   );				// 공급받는자업태
	String BUYR_CORP_NM		= request.getParameter("BUYR_CORP_NM"     );				// 공급받는자상호 (필수)
	String BUYR_BUSS_TYPE	= request.getParameter("BUYR_BUSS_TYPE"   );				// 공급받는자업종
	String BUYR_CODE		= request.getParameter("BUYR_CODE"        );				// 공급받는자종사업자번호
	String BUYR_GB			= request.getParameter("BUYR_GB"          );				// 공급받는자 사업자등록번호 구분코드 (01:사업자등록번호, 02:주민등록번호, 03:외국인)
	String BUYR_CEO			= request.getParameter("BUYR_CEO"         );				// 공급받는자대표자명 (필수)
	String BUYR_CHRG_POST1	= request.getParameter("BUYR_CHRG_POST1"  );				// 공급받는자 담당자부서
	String BUYR_CHRG_NM1	= request.getParameter("BUYR_CHRG_NM1"    );				// 공급받는자 담당자명
	String BUYR_CHRG_TEL1	= request.getParameter("BUYR_CHRG_TEL1"   );				// 공급받는자 담당자전화번호
	String BUYR_CHRG_EMAIL1	= request.getParameter("BUYR_CHRG_EMAIL1" );				// 공급받는자 담당자이메일
	String BUYR_CHRG_POST2	= request.getParameter("BUYR_CHRG_POST2"  );				// 공급받는자 담당자부서
	String BUYR_CHRG_NM2	= request.getParameter("BUYR_CHRG_NM2"    );				// 공급받는자 담당자명2
	String BUYR_CHRG_TEL2	= request.getParameter("BUYR_CHRG_TEL2"   );				// 공급받는자 담당자전화번호2
	String BUYR_CHRG_EMAIL2	= request.getParameter("BUYR_CHRG_EMAIL2" );				// 공급받는자 담당자이메일2
	String BUYR_ADDR		= request.getParameter("BUYR_ADDR"        );				// 공급받는자주소
	String BROK_CORP_NO		= request.getParameter("BROK_CORP_NO"     );				// 위수탁사업자번호 (위수탁일경우 필수)
	String BROK_BUSS_CONS	= request.getParameter("BROK_BUSS_CONS"   );				// 위소탁업태
	String BROK_CORP_NM		= request.getParameter("BROK_CORP_NM"     );				// 위수탁상호 (위수탁일경우 필수)
	String BROK_BUSS_TYPE	= request.getParameter("BROK_BUSS_TYPE"   );				// 위수탁업종
	String BROK_CODE		= request.getParameter("BROK_CODE"        );				// 위수탁종사업자번호
	String BROK_CEO			= request.getParameter("BROK_CEO"         );				// 위수탁대표자명 (위수탁일경우 필수)
	String BROK_CHRG_POST	= request.getParameter("BROK_CHRG_POST"   );				// 위수탁 담당자부서
	String BROK_CHRG_NM		= request.getParameter("BROK_CHRG_NM"     );				// 위수탁 담당자명
	String BROK_CHRG_TEL	= request.getParameter("BROK_CHRG_TEL"    );				// 위수탁 담당자전화번호
	String BROK_CHRG_EMAIL	= request.getParameter("BROK_CHRG_EMAIL"  );				// 위수탁 담당자이메일
	String BROK_ADDR		= request.getParameter("BROK_ADDR"        );				// 위수탁주소
	String PYMT_TYPE1		= request.getParameter("PYMT_TYPE1"       );				// 결제방법코드
	String PAMT_AMT1		= request.getParameter("PAMT_AMT1"        );				// 금액
	String CHRG_AMT			= request.getParameter("CHRG_AMT"         );				// 공급가액합계
	String TAX_AMT			= request.getParameter("TAX_AMT"          );				// 세액합계
	String TOTL_AMT			= request.getParameter("TOTL_AMT"         );				// 총금액
	
	//품목을 위한 변수
	String[] buy_date		= new String[99];                    // 거래월일(년-월-일)
    String[] item_nm		= new String[99];                    // 품목명
    String[] item_infm		= new String[99];                    // 규격
    String[] item_qunt		= new String[99];                    // 수량
    String[] unit_prce		= new String[99];                    // 단가
    String[] item_amt		= new String[99];                    // 공급가액
    String[] item_tax		= new String[99];                    // 세액
    String[] item_desp		= new String[99];                    // 비고
	
	
	//XML 문서 생성하기 위한 MAP 데이터 생성
	if(serv_id              != null) taxMap.put("SERV_ID"           , serv_id          ); else taxMap.put("SERV_ID"            , "20170414test");
	if(send_datetime        != null) taxMap.put("SEND_DATETIME"     , send_datetime    ); else taxMap.put("SEND_DATETIME"      , "20170414200000");
	if(ISSU_ID              != null) taxMap.put("ISSU_ID"           , ISSU_ID          ); else taxMap.put("ISSU_ID"            , "201405194100002600100000");
	if(TAX_TYPE             != null) taxMap.put("TAX_TYPE"          , TAX_TYPE         ); else taxMap.put("TAX_TYPE"           , "0101");
	if(NOTE1                != null) taxMap.put("NOTE1"             , NOTE1            ); else taxMap.put("NOTE1"              , "한글");
	if(ISSU_DATE            != null) taxMap.put("ISSU_DATE"         , ISSU_DATE        ); else taxMap.put("ISSU_DATE"          , "20170414");
	if(MODY_CODE            != null) taxMap.put("MODY_CODE"         , MODY_CODE        ); else taxMap.put("MODY_CODE"          , "");
	if(POPS_CODE            != null) taxMap.put("POPS_CODE"         , POPS_CODE        ); else taxMap.put("POPS_CODE"          , "01");
	if(IMPT_NO              != null) taxMap.put("IMPT_NO"           , IMPT_NO          ); else taxMap.put("IMPT_NO"            , "123456789012345");
	if(ITEM_QUANT           != null) taxMap.put("ITEM_QUANT"        , ITEM_QUANT       ); else taxMap.put("ITEM_QUANT"         , "123456");
	if(ACEP_STAT_DATE       != null) taxMap.put("ACEP_STAT_DATE"    , ACEP_STAT_DATE   ); else taxMap.put("ACEP_STAT_DATE"     , "20090402");
	if(ACEP_END_DATE        != null) taxMap.put("ACEP_END_DATE"     , ACEP_END_DATE    ); else taxMap.put("ACEP_END_DATE"      , "20090402");
	if(SELR_CORP_NO         != null) taxMap.put("SELR_CORP_NO"      , SELR_CORP_NO     ); else taxMap.put("SELR_CORP_NO"       , "1234567891");
	if(SELR_BUSS_CONS       != null) taxMap.put("SELR_BUSS_CONS"    , SELR_BUSS_CONS   ); else taxMap.put("SELR_BUSS_CONS"     , "테스트");
	if(SELR_CORP_NM         != null) taxMap.put("SELR_CORP_NM"      , SELR_CORP_NM     ); else taxMap.put("SELR_CORP_NM"       , "테스트");
	if(SELR_BUSS_TYPE       != null) taxMap.put("SELR_BUSS_TYPE"    , SELR_BUSS_TYPE   ); else taxMap.put("SELR_BUSS_TYPE"     , "테스트");
	if(SELR_CODE            != null) taxMap.put("SELR_CODE"         , SELR_CODE        ); else taxMap.put("SELR_CODE"          , "1234");
	if(SELR_CEO             != null) taxMap.put("SELR_CEO"          , SELR_CEO         ); else taxMap.put("SELR_CEO"           , "테스트");
	if(SELR_CHRG_POST       != null) taxMap.put("SELR_CHRG_POST"    , SELR_CHRG_POST   ); else taxMap.put("SELR_CHRG_POST"     , "");
	if(SELR_CHRG_NM         != null) taxMap.put("SELR_CHRG_NM"      , SELR_CHRG_NM     ); else taxMap.put("SELR_CHRG_NM"       , "테스터");
	if(SELR_CHRG_TEL        != null) taxMap.put("SELR_CHRG_TEL"     , SELR_CHRG_TEL    ); else taxMap.put("SELR_CHRG_TEL"      , "");
	if(SELR_CHRG_EMAIL      != null) taxMap.put("SELR_CHRG_EMAIL"   , SELR_CHRG_EMAIL  ); else taxMap.put("SELR_CHRG_EMAIL"    , "");
	if(SELR_ADDR            != null) taxMap.put("SELR_ADDR"         , SELR_ADDR        ); else taxMap.put("SELR_ADDR"          , "");
	if(BUYR_CORP_NO         != null) taxMap.put("BUYR_CORP_NO"      , BUYR_CORP_NO     ); else taxMap.put("BUYR_CORP_NO"       , "1111111123");
	if(BUYR_BUSS_CONS       != null) taxMap.put("BUYR_BUSS_CONS"    , BUYR_BUSS_CONS   ); else taxMap.put("BUYR_BUSS_CONS"     , "테스트");
	if(BUYR_CORP_NM         != null) taxMap.put("BUYR_CORP_NM"      , BUYR_CORP_NM     ); else taxMap.put("BUYR_CORP_NM"       , "테스트");
	if(BUYR_BUSS_TYPE       != null) taxMap.put("BUYR_BUSS_TYPE"    , BUYR_BUSS_TYPE   ); else taxMap.put("BUYR_BUSS_TYPE"     , "테스트");
	if(BUYR_CODE            != null) taxMap.put("BUYR_CODE"         , BUYR_CODE        ); else taxMap.put("BUYR_CODE"          , "1234");
	if(BUYR_GB              != null) taxMap.put("BUYR_GB"           , BUYR_GB          ); else taxMap.put("BUYR_GB"            , "01");
	if(BUYR_CEO             != null) taxMap.put("BUYR_CEO"          , BUYR_CEO         ); else taxMap.put("BUYR_CEO"           , "테스트");
	if(BUYR_CHRG_POST1      != null) taxMap.put("BUYR_CHRG_POST1"   , BUYR_CHRG_POST1  ); else taxMap.put("BUYR_CHRG_POST1"    , "");
	if(BUYR_CHRG_NM1        != null) taxMap.put("BUYR_CHRG_NM1"     , BUYR_CHRG_NM1    ); else taxMap.put("BUYR_CHRG_NM1"      , "");
	if(BUYR_CHRG_TEL1       != null) taxMap.put("BUYR_CHRG_TEL1"    , BUYR_CHRG_TEL1   ); else taxMap.put("BUYR_CHRG_TEL1"     , "");
	if(BUYR_CHRG_EMAIL1     != null) taxMap.put("BUYR_CHRG_EMAIL1"  , BUYR_CHRG_EMAIL1 ); else taxMap.put("BUYR_CHRG_EMAIL1"   , "");
	if(BUYR_CHRG_POST2      != null) taxMap.put("BUYR_CHRG_POST2"   , BUYR_CHRG_POST2  ); else taxMap.put("BUYR_CHRG_POST2"    , "");
	if(BUYR_CHRG_NM2        != null) taxMap.put("BUYR_CHRG_NM2"     , BUYR_CHRG_NM2    ); else taxMap.put("BUYR_CHRG_NM2"      , "");
	if(BUYR_CHRG_TEL2       != null) taxMap.put("BUYR_CHRG_TEL2"    , BUYR_CHRG_TEL2   ); else taxMap.put("BUYR_CHRG_TEL2"     , "");
	if(BUYR_CHRG_EMAIL2     != null) taxMap.put("BUYR_CHRG_EMAIL2"  , BUYR_CHRG_EMAIL2 ); else taxMap.put("BUYR_CHRG_EMAIL2"   , "");
	if(BUYR_ADDR            != null) taxMap.put("BUYR_ADDR"         , BUYR_ADDR        ); else taxMap.put("BUYR_ADDR"          , "");
	if(BROK_CORP_NO         != null) taxMap.put("BROK_CORP_NO"      , BROK_CORP_NO     ); else taxMap.put("BROK_CORP_NO"       , "");
	if(BROK_BUSS_CONS       != null) taxMap.put("BROK_BUSS_CONS"    , BROK_BUSS_CONS   ); else taxMap.put("BROK_BUSS_CONS"     , "");
	if(BROK_CORP_NM         != null) taxMap.put("BROK_CORP_NM"      , BROK_CORP_NM     ); else taxMap.put("BROK_CORP_NM"       , "");
	if(BROK_BUSS_TYPE       != null) taxMap.put("BROK_BUSS_TYPE"    , BROK_BUSS_TYPE   ); else taxMap.put("BROK_BUSS_TYPE"     , "");
	if(BROK_CODE            != null) taxMap.put("BROK_CODE"         , BROK_CODE        ); else taxMap.put("BROK_CODE"          , "");
	if(BROK_CEO             != null) taxMap.put("BROK_CEO"          , BROK_CEO         ); else taxMap.put("BROK_CEO"           , "");
	if(BROK_CHRG_POST       != null) taxMap.put("BROK_CHRG_POST"    , BROK_CHRG_POST   ); else taxMap.put("BROK_CHRG_POST"     , "");
	if(BROK_CHRG_NM         != null) taxMap.put("BROK_CHRG_NM"      , BROK_CHRG_NM     ); else taxMap.put("BROK_CHRG_NM"       , "");
	if(BROK_CHRG_TEL        != null) taxMap.put("BROK_CHRG_TEL"     , BROK_CHRG_TEL    ); else taxMap.put("BROK_CHRG_TEL"      , "");
	if(BROK_CHRG_EMAIL      != null) taxMap.put("BROK_CHRG_EMAIL"   , BROK_CHRG_EMAIL  ); else taxMap.put("BROK_CHRG_EMAIL"    , "");
	if(BROK_ADDR            != null) taxMap.put("BROK_ADDR"         , BROK_ADDR        ); else taxMap.put("BROK_ADDR"          , "");
	if(PYMT_TYPE1           != null) taxMap.put("PYMT_TYPE1"        , PYMT_TYPE1       ); else taxMap.put("PYMT_TYPE1"         , "10");
	if(PAMT_AMT1            != null) taxMap.put("PAMT_AMT1"         , PAMT_AMT1        ); else taxMap.put("PAMT_AMT1"          , "1100");
	if(CHRG_AMT             != null) taxMap.put("CHRG_AMT"          , CHRG_AMT         ); else taxMap.put("CHRG_AMT"           , "1000");
	if(TAX_AMT              != null) taxMap.put("TAX_AMT"           , TAX_AMT          ); else taxMap.put("TAX_AMT"            , "100");
	if(TOTL_AMT             != null) taxMap.put("TOTL_AMT"          , TOTL_AMT         ); else taxMap.put("TOTL_AMT"           , "1100");
	
	
	ResultMap recordMap = new ResultMap();
	
	/* 품목 다건일 경우
    for ( int i=0; i < 99; i++ ) {
		if(AppUtil.null2void(buy_date[i]).replaceAll("-","") != null){
			recordMap.setFirst();
			recordMap.putMap("SEQ_NO", AppUtil.setFistZeroSpc(2, String.valueOf(i+1)));
			recordMap.putMap("BUY_DATE", AppUtil.null2void(buy_date[i]).replaceAll("-","") );
			recordMap.putMap("ITEM_NM", AppUtil.null2void(item_nm[i]));
			recordMap.putMap("ITEM_INFM", AppUtil.null2void(item_infm[i]));
			recordMap.putMap("ITEM_QUNT", AppUtil.unformat(AppUtil.null2void(item_qunt[i]),","));
			recordMap.putMap("UNIT_PRCE", AppUtil.unformat(AppUtil.null2void(unit_prce[i]),","));
			recordMap.putMap("ITEM_AMT", AppUtil.unformat(AppUtil.null2void(item_amt[i]),","));
			recordMap.putMap("ITEM_TAX", AppUtil.unformat(AppUtil.null2void(item_tax[i]),","));
			recordMap.putMap("ITEM_DESP", AppUtil.null2void(item_desp[i]));
			recordMap.setLast();
		}else{
			recordMap.setFirst();
			recordMap.putMap("SEQ_NO"		, "1");
			recordMap.putMap("BUY_DATE"		, "20170414");
			recordMap.putMap("ITEM_NM"		, "테스트");
			recordMap.putMap("ITEM_INFM"	, "");
			recordMap.putMap("ITEM_QUNT"	, "");
			recordMap.putMap("UNIT_PRCE"	, "");
			recordMap.putMap("ITEM_AMT"		, "1000");
			recordMap.putMap("ITEM_TAX"		, "100");
			recordMap.putMap("ITEM_DESP"	, "");
			recordMap.setLast();
		}
    }
	*/
	
	// 품목 단건일 경우
	recordMap.setFirst();
	recordMap.putMap("SEQ_NO"		, "1");
	recordMap.putMap("BUY_DATE"		, "20170414");
	recordMap.putMap("ITEM_NM"		, "테스트");
	recordMap.putMap("ITEM_INFM"	, "");
	recordMap.putMap("ITEM_QUNT"	, "");
	recordMap.putMap("UNIT_PRCE"	, "");
	recordMap.putMap("ITEM_AMT"		, "1000");
	recordMap.putMap("ITEM_TAX"		, "100");
	recordMap.putMap("ITEM_DESP"	, "");
	recordMap.setLast();
	
	taxMap.put("RECORD_MAP"        , recordMap        );		// 품목의 관한 레코드 처리
	//System.out.println("taxMap >>> "+ taxMap.toString());
	
	//MAP 데이터를 이용하여 XML 문서 생성
	StringBuffer taxXML = new StringBuffer();
	taxXML.append(taxFile.makeTaxInvoiceXML(taxMap));
	//taxFile = null;
	
	System.out.println("getError >>> "+ taxFile.getErrorMsg());
	System.out.println(taxXML.toString());
	
	
%>
<!DOCTYPE html>
<html>
	<head>
  		<meta charset="utf-8">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
		<title> CrosscertWeb Plugin-Free :: HTML5 </title>
		<title></title>
		<!-- 전자인증 모듈 설정 //-->
		<link rel="stylesheet" type="text/css" href="../CC_WSTD_home/unisignweb/rsrc/css/certcommon.css?v=1" />
		<script type="text/javascript" src="../CC_WSTD_home/unisignweb/js/unisignwebclient.js?v=1"></script>
		<script type="text/javascript" src="./UniSignWeb_Multi_Init_Nim.js?v=1"></script>
		<!-- 전자인증 모듈 설정 //-->

  <style type="text/css">
	.box{
		border: 1px solid #888;
		width: 460px;
		height: 300px;
		margin: 10px;
	}
  </style>

<script>
	function getXMLRootNode(data){
		var xmlDoc = getXMLDoc(data);
		if(xmlDoc == null) return null;
		
		var rootNode = xmlDoc.documentElement;
		
		if(rootNode == null || rootNode.getElementsByTagName('parsererror')[0] || (rootNode.firstChild.data != null && rootNode.firstChild.data.trim() != '') ) {
			return null;
		}
		
		return rootNode;
	}
	
	function getXMLDoc(data){
		var xmlDoc=null;
		try{
			if (window.DOMParser){
				var parser=new DOMParser();
			    xmlDoc=parser.parseFromString(data,"text/xml");
			    xmlDoc.async=false;
			}else if (window.ActiveXObject) {
				xmlDoc = new ActiveXObject("Microsoft.XMLDOM");
				xmlDoc.async=false;
				xmlDoc.loadXML(data);
				alert("123");
			} else {
				alert("");
				return null;
			}
		}catch(e){
			return null;
		}
		return xmlDoc;
	}

	function fnXMLCheck(obj){
		var data = document.getElementById('txt_box').value;
		if(obj == 2){
			data = document.getElementById('signedxml').value;
		}
		
		var rootNode = getXMLRootNode(data);
		if(!rootNode){
			alert("XML이 아닙니다.");
			return;
		}else{
			alert("OK!");
			//alert(rootNode.getElementsByTagName('mem')[0].getElementsByTagName('part')[0]);
		}
	}
	
	function fnNext(){
		var textBox = document.getElementById('txt_box');
		var signedTextBox = document.getElementById('signedxml');
		
		var rValueBox = document.getElementById('rvalue');
		var b64KMCert = document.getElementById('base64kmcert');
		
		
		
			
		unisign.GetUserDN(function( resultObject ) {
				
				
				if( !resultObject || resultObject.resultCode != 0 ){
					alert( resultObject.resultMessage + "\n오류코드 : " + resultObject.resultCode );
					return;
				}
		//alert(resultObject.userDN);
		
		unisign.GetRValueFromKey(resultObject.userDN, "", function( retObj ) {

				var rValueBox = document.getElementById('rvalue');

				if( !retObj || retObj.resultCode != 0 ){
					alert( retObj.resultMessage + "\n오류코드 : " + retObj.resultCode );
					return;
				}
				rValueBox.value=retObj.RValue;  // R 값 
				});
						
		unisign.MakeTaxXMLDSIGNonEnveloped( textBox.value, resultObject.userDN, "", 
				
					function(retObj )
					{
						signedTextBox.value = retObj.signedData["0"];
						if ( null == signedTextBox.value || '' == signedTextBox.value )
						{
							unisign.GetLastError(
								function(errCode, errMsg) 
								{ 
									alert('Error code : ' + errCode + '\n\nError Msg : ' + errMsg); 
								}
							);
						}
						else 
						{
							alert(retObj.certAttrs.subjectName);
							
							/*
							 인증서 정보 certAttrs 구조
							 Version,                      // 버전
							 serialNumber,                 // 일련번호
							 signAlgo,                     // 서명알고리즘
							 issuerName,                   // 발급자
							 validateFrom,                 // 유효시간 시작
							 validateTo,                   // 유효기간 만료
							 subjectName,                  // DN 
							 publicKey,                    // 공개키
							 authorityKeyIndentifier,      // 기관키 식별자
							 subjectKeyIndentifier,        // 주체키 식별자
							 keyUsage,                     // 키 사용 
							 policiesOid,                  // 인증서 정책
							 subjectAltName,               // 주체대체이름
							 authorityInfoAccess,          // 기관 정보 액세스
							 crlDistributionPoints,        // CRL 배포지점
							 policiesCps,                  // CPS
							 policiesUserNotice,           // 사용자 알림
							*/
						}
					} 
				);
		});
	}
	
	function fnResult(ar, tf){
		window.console.log(ar + ', ' + tf);
	}
</script>
</head>
<body>
form 속성에 onsubmit="return false" 을 설정해야 함 <br>
<form name="frm" onsubmit="return false">

<textarea id="txt_box" class="box"><%=taxXML.toString()%></textarea>
<input type="button" value="XML구문체크" onclick="fnXMLCheck()">
<input type="button" value="xml전자서명" onclick="fnNext()">
<textarea id="signedxml" name="signedxml" class="box"></textarea>
<br>
<table>
			<tr>
				<td>
					<center><textarea id="rvalue" name="rvalue" rows="5" cols="40"> </textarea></center>
					<center><h3>USER_R</h3><br></center> 
					 
	<!--<br><br><br><center>사업자번호<br><input id="ssn" name="ssn" value="1234567890" type="text"></center>	-->
									
				</td>
			</tr>	
</table>
<!--<textarea id="trace_txt" style="width: 100%; height: 500px;"></textarea>-->

			


		</form>
	</body>
</html>