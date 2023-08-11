<?

// 웹드라이버 없으면 바로 봇으로 잡힌다. 이거 못씀.


$url = "https://www.kickstarter.com/discover/advanced?term=moss+air&sort=magic&seed=2818563&page=1";

$header_data = array(
      'Content-Type: application/json; charset=utf-8',
      'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36'
  );


$ch = curl_init();                                 //curl 초기화
curl_setopt($ch, CURLOPT_URL, $url);               //URL 지정하기
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);    //요청 결과를 문자열로 반환 
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);      //connection timeout 10초 
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);   //원격 서버의 인증서가 유효한지 검사 안함
curl_setopt($ch, CURLOPT_HTTPHEADER, $header_data); //header 지정하기

$response = curl_exec($ch);
curl_close($ch);

// echo $response;

// $arr = json_decode($response,true);


?>

