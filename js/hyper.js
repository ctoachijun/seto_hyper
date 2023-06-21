
// 검색시 페이지는 무조건 1페이지
function chgCurPage(){
  $("input[name=cur_page]").val(1);
  $("form").submit();
}  
  
function downExcel(code,admin){
  if(confirm("엑셀파일로 다운로드 하시겠습니까?")){
    let type = $("select[name=type").val();
    let sw = $("input[name=sw").val();
    
    $(".top_div").append("<form id='exceldown' action='excelDownload.php' method='post'>");
    $("#exceldown").append("<input type='hidden' name='code' value='"+code+"' />");
    $("#exceldown").append("<input type='hidden' name='admin' value='"+admin+"' />");
    $("#exceldown").append("<input type='hidden' name='type' value='"+type+"' />");
    $("#exceldown").append("<input type='hidden' name='sw' value='"+sw+"' />");
    $("#exceldown").append("</form>");
    $("#exceldown").submit();
    
    // $("#exceldown").remove();
  }
}  