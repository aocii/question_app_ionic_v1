<?php


      		 header('Access-Control-Allow-Origin: *');
             header("Access-Control-Allow-Credentials: true"); 
             header('Access-Control-Allow-Headers: X-Requested-With');
             header('Access-Control-Allow-Headers: Content-Type');
             header('Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT'); 
             //header('Access-Control-Max-Age: 86400'); 


include 'dbm_db.php';
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$operation_type = $request->operation_type; // Kullanıcı id
$service_type = $request->service_type; // Kullanıcı id
    
///###########  SERVİS GENEL PARAMETRELER #################////


$successful='{"httpCode":200,"data":"İşlem Başarılı"}';
$successful_data='{"httpCode":200,"data":'.$json_data.'}';
$unsuccessful='{"httpCode":201,"data":"Hata oluştu"}';

if($operation_type=="insert" && $service_type=="user"){
		///#### USER YENİ  KAYIT #################////
		//##### PARAMETRELER######///
		$user_name=$request->user_name;
		$user_tel=$request->user_tel;
		$user_email=$request->user_email;
		$user_password=$request->user_password;
		$user_post_code=$request->user_post_code;

		//###### Yeni Kullanıcı oluşturulurken cep kayıtlı mı kontrol edilecek değilse kayıt yapılacak//
$stmt = $pdo->prepare("SELECT * from user where email=':user_email'");
		$stmt->bindParam(':user_email', $user_email, PDO::PARAM_STR);
        $sonuc = $stmt->execute();
 		$row = $stmt->fetch(PDO::FETCH_ASSOC);
 		if(!$row){
$stmt = $pdo->prepare("INSERT INTO user (name, tel_no, postcode, email, password) values (:name, :tel, :post_code, :email, :password)");

        $stmt->bindParam(':name', $user_name, PDO::PARAM_STR);    
        $stmt->bindParam(':tel', $user_tel, PDO::PARAM_STR);
        $stmt->bindParam(':email', $user_email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $user_password, PDO::PARAM_STR);
        $stmt->bindParam(':post_code', $user_post_code, PDO::PARAM_STR);    
		$sonuc = $stmt->execute();
		
///USER bilgileri kayıt sonrası çekiliyor.
		$user_email=$request->user_email;
		$user_password=$request->user_password;
		$user_id=$request->user_id;


$stmt = $pdo->prepare("SELECT id,name,tel_no,postcode,email from user where (email= :user_email and password= :user_password) or id= :user_id");

        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
		$stmt->bindParam(':user_email', $user_email, PDO::PARAM_STR);
        $stmt->bindParam(':user_password', $user_password, PDO::PARAM_STR);
        $sonuc = $stmt->execute();
 		$row = $stmt->fetch(PDO::FETCH_ASSOC);
 		//$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		print json_encode($row);
////////////////////////		



		}else{
			echo $unsuccessful;
		}

}else if($operation_type=="select" && $service_type=="user"){
   
		///#### USER SELECT #################////
		//##### PARAMETRELER######///
		$user_email=$request->user_email;
		$user_password=$request->user_password;
		$user_id=$request->user_id;


$stmt = $pdo->prepare("SELECT id,name,tel_no,postcode,email from user where (email= :user_email and password= :user_password) or id= :user_id");

        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
		$stmt->bindParam(':user_email', $user_email, PDO::PARAM_STR);
        $stmt->bindParam(':user_password', $user_password, PDO::PARAM_STR);
        $sonuc = $stmt->execute();
 		$row = $stmt->fetch(PDO::FETCH_ASSOC);
 		//$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		print json_encode($row);
		//$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		//$json_data=json_encode($results);
		//print $successful_data='{"httpCode":200,"data":'.$json_data.'}'; ;


}else if($operation_type=="select" && $service_type=="notification"){
   
		///#### USER SELECT #################////
		//##### PARAMETRELER######///
		$user_id=$request->user_id;


$stmt = $pdo->prepare("SELECT t.info from notification n,ntf_template t 
where n.ntf_template_id=t.id and n.user_id=:user_id");

        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
        $sonuc = $stmt->execute();
 		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$json_data=json_encode($results);
		print $json_data;
		//$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		//$json_data=json_encode($results);
		//print $successful_data='{"httpCode":200,"data":'.$json_data.'}'; ;


}else if($operation_type=='update' && $service_type=="user"){
		///#### USER UPDATE #################////
		//##### PARAMETRELER######///
		$user_id=$request->user_id;
		$user_name=$request->user_name;
		$user_tel=$request->user_tel;
		$user_post_code=$request->user_post_code;

		$stmt = $pdo->prepare("UPDATE user set name= :user_name, tel_no= :user_tel, postcode= :user_post_code where id= :user_id");
		$stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
        $stmt->bindParam(':user_name', $user_name, PDO::PARAM_STR);    
        $stmt->bindParam(':user_tel', $user_tel, PDO::PARAM_STR);
        $stmt->bindParam(':user_post_code', $user_post_code, PDO::PARAM_STR);    
		$sonuc = $stmt->execute();

          ////////!!!!!!!! ALL DELETES !!!!!////////////
		  ////////!!!!!!!! ALL DELETES !!!!!////////////
		  ////////!!!!!!!! ALL DELETES !!!!!////////////
		  
}else if($operation_type=='delete' && $operation_typeeee==10){
		///#### USER DELELE #################////
		//##### PARAMETRELER######///
		$user_id=$request->user_id;
		$stmt = $pdo->prepare("DELETE from user where id= :user_id");
		$stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
 		$sonuc = $stmt->execute();
 		

 		///#### KATEGORİ DELETE #################////
		//##### PARAMETRELER######///
		$category_id=$request->category_id;
		$stmt = $pdo->prepare("DELETE from category where id= :category_id");
		$stmt->bindParam(':category_id', $category_id, PDO::PARAM_STR);
 		$sonuc = $stmt->execute();
 		


 	    ///#### REQUEST DELETE #################////
		//##### PARAMETRELER######///
		$request_id=$request->request_id;
		$stmt = $pdo->prepare("DELETE from request where id= :request_id");
		$stmt->bindParam(':request_id', $request_id, PDO::PARAM_STR);
 		$sonuc = $stmt->execute();
 		


 		///#### ADRES DELETE #################////
		//##### PARAMETRELER######///
		$address_id=$request->address_id;
		$stmt = $pdo->prepare("DELETE from address where id= :address_id");
		$stmt->bindParam(':address_id', $address_id, PDO::PARAM_STR);
 		$sonuc = $stmt->execute();


 		///#### SURVEY DELETE #################////
		//##### PARAMETRELER######///
		$survey_id=$request->survey_id;
		$stmt = $pdo->prepare("DELETE from survey where id= :survey_id");
		$stmt->bindParam(':survey_id', $survey_id, PDO::PARAM_STR);
 		$sonuc = $stmt->execute();



 		///#### PACKAGE DELETE #################////
		//##### PARAMETRELER######///
		$package_id=$request->package_id;
		$stmt = $pdo->prepare("DELETE from packages where id= :package_id");
		$stmt->bindParam(':package_id', $package_id, PDO::PARAM_STR);
 		$sonuc = $stmt->execute();




}else if($operation_type=='select' && $service_type=="category"){
		///#### KATEGORİ SELECT #################////
		//##### PARAMETRELER######///
		$category_parent_id=$request->category_parent_id;
        $stmt = $pdo->prepare("SELECT * from category where parent_id=:category_parent_id");
		$stmt->bindParam(':category_parent_id', $category_parent_id, PDO::PARAM_STR);
		$sonuc = $stmt->execute();
 		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$json_data=json_encode($results);
		print $json_data;

}elseif($operation_type=="insert" && $service_type=="category"){
        ///#### KATEGORİ İNSERT #################////
		//##### PARAMETRELER######///
        $category_name=$request->category_name;
		$category_icon=$request->category_icon;
	    $category_info=$request->category_info;
	    $category_parent_id=$request->category_parent_id;
	    $category_country_cod=$request->category_country_cod;		

        $stmt = $pdo->prepare("INSERT INTO category (name, icon, info, parent_id, country_cod) values (:category_name, :category_icon, :category_info, :category_parent_id, :category_country_cod)");

        $stmt->bindParam(':category_name', $category_name, PDO::PARAM_STR);    
        $stmt->bindParam(':category_icon', $category_icon, PDO::PARAM_STR); 
        $stmt->bindParam(':category_info', $category_info, PDO::PARAM_STR);
        $stmt->bindParam(':category_parent_id', $category_parent_id, PDO::PARAM_STR);
        $stmt->bindParam(':category_country_cod', $category_country_cod, PDO::PARAM_STR);   
		$sonuc = $stmt->execute();


}else if($operation_type=='update' && $service_type=="category"){
		///#### KATEGORİ UPDATE #################////
		//##### PARAMETRELER######///
		$category_id=$request->category_id;
		$category_name=$request->category_name;
		$category_icon=$request->category_icon;
		$category_info=$request->category_info;
		$category_parent_id=$request->category_parent_id;
		$category_country_cod=$request->category_country_cod;

		$stmt = $pdo->prepare("UPDATE category set name= :category_name, icon= :category_icon, info= :category_info, parent_id= :category_parent_id, country_cod= :category_country_cod where id= :category_id");
		$stmt->bindParam(':category_id', $category_id, PDO::PARAM_STR);
        $stmt->bindParam(':category_name', $category_name, PDO::PARAM_STR);    
        $stmt->bindParam(':category_icon', $category_icon, PDO::PARAM_STR);
        $stmt->bindParam(':category_info', $category_info, PDO::PARAM_STR);
        $stmt->bindParam(':category_parent_id', $category_parent_id, PDO::PARAM_STR);    
        $stmt->bindParam(':category_country_cod', $category_country_cod, PDO::PARAM_STR);  
		$sonuc = $stmt->execute();
		echo "işlem başarılı";

                ///// ###### ARAÇ EKLEME MY İTEMS INSERT ######  ////////
}else if ($operation_type=='select' && $service_type=="payment") {
		///#### PAYMENT SELECT #################////
		//##### PARAMETRELER######///
		//$payment_id=$request->payment_id;

		$stmt = $pdo->prepare("SELECT * from payment");


        //$stmt->bindParam(':payment_id', $payment_id, PDO::PARAM_STR);
        $sonuc = $stmt->execute();
 		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$json_data=json_encode($results);
		print $json_data ;


}else if ($operation_type=='select' && $service_type=="settings") {
		///#### PAYMENT SELECT #################////
		//##### PARAMETRELER######///
		$type=$request->type;
		$lan_id=$request->lan_id;

		$stmt = $pdo->prepare("SELECT * from settings where type=:type and language_id=:lan_id");


        $stmt->bindParam(':type', $type, PDO::PARAM_STR);
        $stmt->bindParam(':lan_id', $lan_id, PDO::PARAM_STR);
        $sonuc = $stmt->execute();
 		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$json_data=json_encode($results);
		print $json_data ;


}else if ($operation_type=='select' && $service_type=="time") {
		///#### PAYMENT SELECT #################////
		//##### PARAMETRELER######///
		//$payment_id=$request->payment_id;

		$stmt = $pdo->prepare("SELECT * from time");


        //$stmt->bindParam(':payment_id', $payment_id, PDO::PARAM_STR);
        $sonuc = $stmt->execute();
 		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$json_data=json_encode($results);
		print $json_data ;


}else if ($operation_type=='select' && $service_type=="detail") {
		///#### PAYMENT SELECT #################////
		//##### PARAMETRELER######///
		$category_id=$request->category_id;
		//echo "dd:".$category_id;
		$stmt = $pdo->prepare("SELECT * from pagedetail where parent_id=:category_id order by list_id");
		$stmt->bindParam(':category_id', $category_id, PDO::PARAM_STR);
		//$stmt->bindValue(':keywords', '%'.$category_id.'%', PDO::PARAM_STR);
        $sonuc = $stmt->execute();
 		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$json_data=json_encode($results);
		print $json_data;


}else if($operation_type=='select' && $service_type=="packages"){
		///#### PACKAGES SELECT #################////
		//##### PARAMETRELER######///
		$packages_category_id=$request->packages_category_id;
		$stmt = $pdo->prepare("SELECT * from packages where category_id=:packages_category_id");
		$stmt->bindParam(':packages_category_id', $packages_category_id, PDO::PARAM_STR);
		$sonuc = $stmt->execute();
 		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$json_data=json_encode($results);
		print $json_data;

}else if($operation_type=='select' && $service_type=="packagesDetail"){
		///#### PACKAGES SELECT #################////
		//##### PARAMETRELER######///
		$category_name=$request->category_name;
		$stmt = $pdo->prepare("SELECT c.name,p.title,p.time 
from category c, packages_task_list p 
where c.id=p.category_id and c.name = :category_name");
		$stmt->bindParam(':category_name', $category_name, PDO::PARAM_STR);
		$sonuc = $stmt->execute();
 		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$json_data=json_encode($results);
		print $json_data;

}elseif($operation_type=='insert'&& $service_type=='package'){ 
		echo "{mesaj:'paket_ekleme'}";
        ///#### PACKAGES INSERT #################////
		//##### PARAMETRELER######///
		$package_name=$request->package_name;
		$package_price=$request->package_price;
		$package_category_id=$request->package_category_id;


$stmt = $pdo->prepare("INSERT INTO packages (name, price, category_id) 
					values (:name, :price, :category_id) ");
		$stmt->bindParam(':package_name', $package_name, PDO::PARAM_STR);
		$stmt->bindParam(':package_price', $package_price, PDO::PARAM_STR);
		$stmt->bindParam(':package_category_id', $package_category_id, PDO::PARAM_STR);
		$sonuc = $stmt->execute();
 		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$json_data=json_encode($results);

}else if ($operation_type=='update' && $service_type=='package'){ 
		echo "{mesaj:'paket_güncelle'}";
        ///#### PACKAGES UPDATE #################////
		//##### PARAMETRELER######///
        $package_name=$request->package_name;
		$package_price=$request->package_price;
		$package_id=$request->package_id;

$stmt = $pdo->prepare("UPDATE packages set name= :package_name, price= :package_price where id= :package_id");

		$stmt->bindParam(':package_name', $package_name, PDO::PARAM_STR);
		$stmt->bindParam(':package_price', $package_price, PDO::PARAM_STR);
		$stmt->bindParam(':package_id', $package_id, PDO::PARAM_STR);
		$sonuc = $stmt->execute();
 		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$json_data=json_encode($results);

}elseif($operation_type=='select' && $service_type=="address"){
		  ///#### ADDRESS SELECT #################////
		  //##### PARAMETRELER######///
		$address_user_id=$request->address_user_id;
		$stmt = $pdo->prepare("SELECT * from address where user_id=:address_user_id");
		$stmt->bindParam(':address_user_id', $address_user_id, PDO::PARAM_STR);
	    $sonuc = $stmt->execute();
 		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$json_data=json_encode($results);
		print $successful_data='{"httpCode":200,"data":'.$json_data.'}'; ;


		
}elseif($operation_type=="insert" && $service_type=="address"){
		///#### ADDRESS İNSERT #################////
		//##### PARAMETRELER######///

        $address_type=$request->address_type;
		$address=$request->address;
	    $address_user_id=$request->address_user_id;	

$stmt = $pdo->prepare("INSERT INTO address (address_type, address, user_id) values (:address_type, :address, :address_user_id)");

        $stmt->bindParam(':address_type', $address_type, PDO::PARAM_STR);    
        $stmt->bindParam(':address', $address, PDO::PARAM_STR); 
        $stmt->bindParam(':address_user_id', $address_user_id, PDO::PARAM_STR);   
		$sonuc = $stmt->execute();




}elseif($operation_type=='update' && $service_type=="address"){
		///#### ADDRESS UPDATE #################////
		//##### PARAMETRELER######///
		$address_id=$request->address_id;
		$address_type=$request->address_type;
		$address=$request->address;

		$stmt = $pdo->prepare("UPDATE address set address= :address, address_type= :address_type where id= :address_id");
		$stmt->bindParam(':address_id', $address_id, PDO::PARAM_STR);
        $stmt->bindParam(':address_type', $address_type, PDO::PARAM_STR);    
        $stmt->bindParam(':address', $address, PDO::PARAM_STR);  
		$sonuc = $stmt->execute();

  

}elseif($operation_type=="insert" && $service_type=="myitems"){
	///// ###### ARAÇ EKLEME MY İTEMS INSERT ######  ////////
		//##### PARAMETRELER######///
	    $myitems_category_id=$request->myitems_category_id;
		$myitems_user_id=$request->myitems_user_id;	
$stmt = $pdo->prepare("INSERT INTO myitems (category_id, user_id) values (:myitems_category_id, :myitems_user_id)");

        $stmt->bindParam(':myitems_category_id', $myitems_category_id, PDO::PARAM_STR);    
        $stmt->bindParam(':myitems_user_id', $myitems_user_id, PDO::PARAM_STR); 
		$sonuc = $stmt->execute();




}else if($operation_type=='select' && $service_type=="survey"){
		///#### SURVEY SELECT #################////
		//##### PARAMETRELER######///
		$survey_packages_id=$request->survey_packages_id;	
		$stmt = $pdo->prepare("SELECT * from survey where packages_id=survey_packages_id");
		$stmt->bindParam(':survey_packages_id', $survey_packages_id, PDO::PARAM_STR);
        $sonuc = $stmt->execute();
 		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$json_data=json_encode($results);
		print $successful_data='{"httpCode":200,"data":'.$json_data.'}'; ;




}elseif($operation_type=="insert" && $service_type=="survey"){
        ///#### SURVEY İNSERT #################////
		//##### PARAMETRELER######///
        $survey_question=$request->survey_question;	
		$survey_packages_id=$request->survey_packages_id;	
	    $survey_request_id=$request->survey_request_id;		

$stmt = $pdo->prepare("INSERT INTO survey (question, request_id, packages_id) values (:survey_question, :survey_packages_id, :survey_request_id)");

        $stmt->bindParam(':survey_request_id', $survey_request_id, PDO::PARAM_STR);    
        $stmt->bindParam(':survey_question', $survey_question, PDO::PARAM_STR); 
        $stmt->bindParam(':survey_packages_id', $survey_packages_id, PDO::PARAM_STR);   
		$sonuc = $stmt->execute();




}else if($operation_type=='update' && $service_type=="survey"){
		///#### SURVEY UPDATE #################////
		//##### PARAMETRELER######///
		$survey_id=$request->survey_id;	
		$survey_answer=$request->survey_answer;	
	

		$stmt = $pdo->prepare("UPDATE survey set answer= :survey_answer  where id= :survey_id");
		$stmt->bindParam(':survey_id', $survey_id, PDO::PARAM_STR);
        $stmt->bindParam(':survey_answer', $survey_answer, PDO::PARAM_STR);       
		$sonuc = $stmt->execute();



}else if($operation_type=='select' && $service_type=="request"){
		///#### REQUEST SELECT #################////
		//##### PARAMETRELER######///
		$request_user_id=$request->request_user_id;	
		$sira=-1;
		$stmt = $pdo->prepare("SELECT
			r.id,
			r.package_type,
			r.`status`,
			r.process_date,
			r.operation_date,
			r.operation_time,
			r.payment_type,
			r.category_type,
			r.user_address,
			r.package_type,
			p.price,
			p.priceTitle
 from request r,packages p where  p.`name`=r.package_type and r.user_id=:request_user_id and status not in ('delete') order by r.id desc");
		$stmt->bindParam(':request_user_id', $request_user_id, PDO::PARAM_STR);
        $sonuc = $stmt->execute();
 		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$json_data=json_encode($results);
		print $json_data ;





}else if($operation_type=='update' && $service_type=="request"){
		///#### REQUEST UPDATE #################////
		//##### PARAMETRELER######///
		$request_situation=$request->request_situation;
		$request_id=$request->request_id;
		$request_process_dat=$request->request_process_dat;
	    $request_operation_t=$request->request_operation_t;
	    $request_payment_id=$request->request_payment_id;
	    $request_worker_id=$request->request_worker_id;
	    $request_user_id=$request->request_user_id;
	    $request_package_id=$request->request_package_id;
		
		$stmt = $pdo->prepare("UPDATE request set user_id= :request_user_id, worker_id= :request_worker_id, operation_t= :request_operation_t, process_dat= :request_process_dat, package_id= :request_package_id, payment_id= :request_request_payment_id, situation= :request_situation where id= :request_id");
		$stmt->bindParam(':request_situation', $request_situation, PDO::PARAM_STR);
        $stmt->bindParam(':request_id', $request_id, PDO::PARAM_STR);    
        $stmt->bindParam(':request_process_dat', $request_process_dat, PDO::PARAM_STR);
        $stmt->bindParam(':request_operation_t', $request_operation_t, PDO::PARAM_STR);
        $stmt->bindParam(':request_payment_id', $request_payment_id, PDO::PARAM_STR);    
        $stmt->bindParam(':request_user_id', $request_user_id, PDO::PARAM_STR);  
		$stmt->bindParam(':request_package_id', $request_package_id, PDO::PARAM_STR);  
		$stmt->bindParam(':request_worker_id', $request_worker_id, PDO::PARAM_STR);

		$sonuc = $stmt->execute();
		echo "işlem başarılı";



}else if($operation_type=='delete' && $service_type=="request"){
		///#### REQUEST UPDATE #################////
		//##### PARAMETRELER######///
		
		$request_id=$request->request_id;
	    $request_user_id=$request->request_user_id;
		
		$stmt = $pdo->prepare("UPDATE request set status= 'delete' where id= :request_id and user_id=:request_user_id");
		$stmt->bindParam(':request_id', $request_id, PDO::PARAM_STR);    
     	$stmt->bindParam(':request_user_id', $request_user_id, PDO::PARAM_STR);  
	
		$sonuc = $stmt->execute();
		echo "işlem başarılı";



}elseif($operation_type=="insert" && $service_type=="request"){
        ///#### REQUEST İNSERT #################////
		//##### PARAMETRELER######///

        $request_user_id=$request->user_id;
		$request_user_address=$request->user_address;
	    $request_package_type=$request->package_type;
	    $request_operation_date=$request->operation_date;
	    $request_operation_time=$request->operation_time;
	    $request_category_type=$request->category_type;
	    $request_payment_type=$request->payment_type;
 		$save_date= date("Y-m-d H:i:s");
 		$request_status="pending";
 		

$stmt = $pdo->prepare("INSERT INTO request (operation_time,status,process_date,user_id, package_type, operation_date, payment_type, category_type, user_address) 
	values (:request_operation_time,:status,:process_date,:request_user_id, :request_package_type, :request_operation_date, :request_payment_type, :request_category_type, :request_user_address)");


        $stmt->bindParam(':request_user_id', $request_user_id, PDO::PARAM_STR);    
        $stmt->bindParam(':request_user_address', $request_user_address, PDO::PARAM_STR); 
        $stmt->bindParam(':request_package_type', $request_package_type, PDO::PARAM_STR); 
        $stmt->bindParam(':request_operation_date', $request_operation_date, PDO::PARAM_STR);    
        $stmt->bindParam(':request_operation_time', $request_operation_time, PDO::PARAM_STR);    
        $stmt->bindParam(':request_category_type', $request_category_type, PDO::PARAM_STR); 
        $stmt->bindParam(':request_payment_type', $request_payment_type, PDO::PARAM_STR); 
		$stmt->bindParam(':process_date', $save_date, PDO::PARAM_STR); 
		$stmt->bindParam(':status', $request_status, PDO::PARAM_STR); 

		$sonuc = $stmt->execute();





}elseif($operation_type=="select" && $service_type=="uber"){

$address = 'taksim'; // Kullanıcı id

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://www.uber.com/api/autocomplete-address?latitude=43.653908&longitude=-79.384293&query=".$address,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_POSTFIELDS => "",
  CURLOPT_HTTPHEADER => array(
    "Postman-Token: 629cb406-08d1-4128-9965-2c612d58c9b8",
    "cache-control: no-cache"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}

}else{
		///######### HATA MESAJI ############////
		echo "{mesaj:'Bir Hata Oluştur'}";
}









?>
