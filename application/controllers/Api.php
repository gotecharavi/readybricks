<?php 
header('Content-Type: application/json; Charset=UTF-8');
require_once('./application/libraries/base_ctrl.php');

class Api extends CI_Controller {
	function __construct() {
		parent::__construct();		
 		$this->load->database();   
		$this->load->helper('url');

        $this->load->model('Users_model');
        $this->load->model('Customer_model');
        $this->load->model('Manufacture_model');
        $this->load->model('Transporter_model');
        $this->load->model('Country_model');
        $this->load->model('State_model');
        $this->load->model('City_model');
        $this->load->model('Product_model');
        $this->load->model('Inventory_model');


        $this->load->model('Models_model');
        $this->load->model('Pump_model');

        $this->load->model('Category_model');
        $this->load->model('Menu_model');
        $this->load->model('Cart_model');
        $this->load->model('Order_model');
        $this->load->model('Store_model');
        $this->load->model('Demo_model');
        $this->load->model('SerialNumber_model');


	}
    public function loginwithsocial(){
        $post=json_decode( file_get_contents('php://input') );
        $Email     = $post->Email;
        $checkEmail=$this->Users_model->checkSocialEmail($Email);
           if($checkEmail){
                print json_encode(array('success'=>1, 'msg'=>'Email Address Exists','data'=>$checkEmail));

           }else{

                print json_encode(array('success'=>0, 'msg'=>'Email Address Not Exists'));
           }

    }
    public function signup(){
        $post=json_decode( file_get_contents('php://input') );
         $Role          = $post->Role;
         $Type          = $post->Type;
         $CompanyName   = isset($post->CompanyName) ? $post->CompanyName : '';
         $FirstName     = isset($post->FirstName) ? $post->FirstName : '';
         $LastName      = isset($post->LastName) ? $post->LastName : '';
         $Email         = $post->Email;
         $MobileNumber  = $post->MobileNumber;
         $VatNo         = isset($post->VatNo) ? $post->VatNo : '';
         $GstNo         = isset($post->GstNo) ? $post->GstNo : '';
         $Image         = '';
         $Password      = $post->Password;

         if(isset($post->Image) && $post->Image !=""){
            $new_data=explode(",",$post->Image);
            $exten=explode('/',$new_data[0]);
            $exten1=explode(';',$exten[1]);
            $decoded=base64_decode($new_data[1]);
            $Image='img_'.uniqid().'.'.$exten1[0];
            file_put_contents(APPPATH.'../uploads/'.$Image,$decoded);
         }

            $checkEmail=$this->Users_model->checkEmail($Email);
           if(!$checkEmail){

                $checkMobileNumber=$this->Users_model->checkMobileNumber($MobileNumber);

                   if(!$checkMobileNumber){

                        $addUser=$this->Users_model->add(array('CompanyName'=>$CompanyName,'FirstName'=>$FirstName,'LastName'=>$LastName,'Email'=>$Email,'Password'=>md5($Password),'Image'=>$Image,'MobileNumber'=>$MobileNumber,'IsEmailVerify'=>'1','IsMobileNumberVerify'=>'1','Role'=>$Role,'Status'=>'0'));

                        if($Role ==2){
                            $addCustomer = $this->Customer_model->add(array('UserId'=>$addUser,'GSTIN'=>$GstNo,'VatNumber'=>$VatNo));;
                        }
                        if($Role ==3){
                            $addManufacture = $this->Manufacture_model->add(array('UserId'=>$addUser,'GSTIN'=>$GstNo,'VatNumber'=>$VatNo));;
                        }
                        if($Role ==4){
                            $addTransporter = $this->Transporter_model->add(array('UserId'=>$addUser,'GSTIN'=>$GstNo,'VatNumber'=>$VatNo));;
                        }
                        print json_encode(array('success'=>1, 'msg'=>'Signup step2 successful','data'=>$addUser));

                    }else{

                    print json_encode(array('success'=>3, 'msg'=>'Mobile Number Already Exists'));

                    }

            }else{
                        print json_encode(array('success'=>2, 'msg'=>'Email Already Exists'));

            }            

        exit;
    }

    public function signup3(){

         $post      =json_decode( file_get_contents('php://input') );
         $Address   = $post->Address;
         $Landmark  = isset($post->Landmark) ? $post->Landmark : '';
         $CountryId = $post->CountryId;
         $StateId   = $post->StateId;
         $CityId    = $post->CityId;
         $UserId    = $post->UserId;

            $updateUser=$this->Users_model->update($UserId,array('Address'=>$Address,'Landmark'=>$Landmark,'CountryId'=>$CountryId,'StateId'=>$StateId,'CityId'=>$CityId,'Status'=>'1'));
            if($updateUser){
                print json_encode(array('success'=>1, 'msg'=>'Signup successful','data'=>$updateUser));
            }else{
                print json_encode(array('success'=>0, 'msg'=>'Something Wrong'));
            }


    }


	public function login(){
        $post=json_decode( file_get_contents('php://input') );
         $email      = $post->email;
         $password      = $post->password;
         if(!$email){

            print json_encode(array('success'=>0, 'msg'=>'Enter Complete login form','data'=>'e - '.$email));

         }else{
            $finaldata=$this->Users_model->checklogin($email);
           if($finaldata){
                   if($finaldata->Password==md5($password)){

                        unset($finaldata->Password);
                        print json_encode(array('success'=>1, 'msg'=>'Login successful','data'=>$finaldata));

                        }else{

                        print json_encode(array('success'=>0, 'msg'=>'Password Not Match'));

                        }

            }else{
                        print json_encode(array('success'=>0, 'msg'=>'Email or Mobile Not Exists'));

            }            

        }
        exit;
    }

    function getallddl(){
        $getCountry=$this->Country_model->get_all();
        $getState=$this->State_model->get_all();
        $getCity=$this->City_model->get_all();

        print json_encode(array('success'=>'true', 'msg'=>'Record Found Successfully','country'=>$getCountry,'State'=>$getState,'city'=>$getCity));



    }
    public function addproduct(){
        $post=json_decode( file_get_contents('php://input') );
         $UserId      = $post->UserId;
         $Name      = $post->Name;
         $MinDeliveryDays      = $post->MinDeliveryDays;
         $Price      = $post->Price;
         $Description      = $post->Description;
         $AdditionalInfo      = isset($post->AdditionalInfo) ? $post->AdditionalInfo : '';
         $curdate= date('Y-m-d h:i:s');
         $Image = "";
         if(isset($post->Image) && $post->Image !=""){
            $new_data=explode(",",$post->Image);
            $exten=explode('/',$new_data[0]);
            $exten1=explode(';',$exten[1]);
            $decoded=base64_decode($new_data[1]);
            $Image='product_'.uniqid().'.'.$exten1[0];
            file_put_contents(APPPATH.'../uploads/'.$Image,$decoded);
         }

         $addProduct = $this->Product_model->add(array('PManuId'=>$UserId,'PName'=>$Name,'PMinDeliveryDays'=>$MinDeliveryDays,'PImage'=>$Image,'PPrice'=>$Price,'PDescription'=>$Description,'PAdditionalInfo'=>$AdditionalInfo,'PStatus'=>0,'Created_At'=>$curdate,'Updated_At'=>$curdate));
         if($addProduct){
            print json_encode(array('success'=>1, 'msg'=>'Product Added Successfully'));

         }else{
            print json_encode(array('success'=>0, 'msg'=>'Product Not Add'));

         }


    }
    public function getproduct(){
        $post=json_decode( file_get_contents('php://input') );
        $UserId      = $post->UserId;
        $getallproduct=$this->Product_model->get_all_by_userid($UserId);

        if($getallproduct){
            print json_encode(array('success'=>1, 'msg'=>'Product Found Successfully','data'=>$getallproduct));

        }else{
            print json_encode(array('success'=>0, 'msg'=>'Product Not Found'));

        }



    }



    public function updateproduct(){
        $post=json_decode( file_get_contents('php://input') );
         $ProductId      = $post->ProductId;
         $Name      = $post->Name;
         $MinDeliveryDays      = $post->MinDeliveryDays;
         $Price      = $post->Price;
         $Description      = $post->Description;
         $AdditionalInfo      = isset($post->AdditionalInfo) ? $post->AdditionalInfo : '';
         $curdate= date('Y-m-d h:i:s');
         $Image = "";
         if(isset($post->Image) && $post->Image !=""){
            $new_data=explode(",",$post->Image);
            $exten=explode('/',$new_data[0]);
            $exten1=explode(';',$exten[1]);
            $decoded=base64_decode($new_data[1]);
            $Image='product_'.uniqid().'.'.$exten1[0];
            file_put_contents(APPPATH.'../uploads/'.$Image,$decoded);
         }

         $updateProduct = $this->Product_model->update($ProductId,array('PName'=>$Name,'PMinDeliveryDays'=>$MinDeliveryDays,'PImage'=>$Image,'PPrice'=>$Price,'PDescription'=>$Description,'PAdditionalInfo'=>$AdditionalInfo,'Updated_At'=>$curdate));
         if($updateProduct){
            print json_encode(array('success'=>1, 'msg'=>'Product Updated Successfully'));

         }else{
            print json_encode(array('success'=>0, 'msg'=>'Product Not Add'));

         }


    }

    public function updateproductstatus(){
        $post=json_decode( file_get_contents('php://input') );
         $ProductId      = $post->ProductId;
         $Status      = $post->Status;
         $curdate= date('Y-m-d h:i:s');
         $updateProduct = $this->Product_model->update($ProductId,array('PStatus'=>$Status,'Updated_At'=>$curdate));
         if($updateProduct){
            print json_encode(array('success'=>1, 'msg'=>'Product Status Changed Successfully'));

         }else{
            print json_encode(array('success'=>0, 'msg'=>'Product Not Add'));

         }


    }


    public function updateproductstockstatus(){
        $post=json_decode( file_get_contents('php://input') );
         $ProductId      = $post->ProductId;
         $Stock      = $post->Stock;
         $curdate= date('Y-m-d h:i:s');

         $updateStock = $this->Inventory_model->add(array('IProductId'=>$ProductId,'Stock_Qty'=>$Stock,'Created_At'=>$curdate,'Updated_At'=>$curdate));
         if($updateStock){
            print json_encode(array('success'=>1, 'msg'=>'Stock Updated Successfully'));

         }else{
            print json_encode(array('success'=>0, 'msg'=>'Product Not Add'));

         }


    }



    public function getallproduct(){
        $post=json_decode( file_get_contents('php://input') );
        $getallproduct=$this->Product_model->get_all($UserId);

        if($getallproduct){
            print json_encode(array('success'=>1, 'msg'=>'Product Found Successfully','data'=>$getallproduct));

        }else{
            print json_encode(array('success'=>0, 'msg'=>'Product Not Found'));

        }



    }






    function getallddl1(){
        $getemployee=$this->Users_model->get_all_employee();
        $getmodels=$this->Models_model->get_all();
        $getpump=$this->Pump_model->get_all();

        print json_encode(array('success'=>'true', 'msg'=>'Record Found Successfully','employee'=>$getemployee,'model'=>$getmodels,'pump'=>$getpump));



    }
    function addinstallation(){
         $post=json_decode( file_get_contents('php://input') );

         $custid      = $post->custid;
         $name      = $post->name;
         $address      = $post->address;
         $buildingtype      = $post->buildingtype;
         $phone      = $post->phone;
         $modelid      = $post->modelid;
         $pumpid      = $post->pumpid;
         $paymentcollection = $post->paymentcollection;
         $datetime      = $post->datetime;
         $orderby      = $post->orderby;
         $ordertype  =$post->ordertype;
         $userid      = $post->userid;
         $curdate= date('d-m-Y h:i:s');
        if(isset($post->remarks)){ $remarks = $post->remarks; }else{ $remarks='';}
        if(isset($post->permanentremark)){ $permanentremark = $post->permanentremark; }else{ $permanentremark='';}
        if(isset($post->altphone)){ $altphone = $post->altphone; }else{ $altphone='';}
        if(isset($post->cpersonname)){ $cpersonname = $post->cpersonname; }else{ $cpersonname='';}


        if($custid =='' || $custid ==null){
            // check mobile number
            $checkphone=$this->Customer_model->getmobile($phone);
            if($checkphone){
            print json_encode(array('success'=>'false', 'msg'=>'Mobile Number Already Exists'));
            exit;
                // $custid = $checkphone->CustId;
            }
            else{
            $addcust=$this->Customer_model->add(array('Name'=>$name,'PhoneNo'=>$phone,'AltPhoneNo'=>$altphone,'Address'=>$address,'Date'=>$curdate,'Status'=>'1'));
            $custid= $addcust;
            }

        }
        $result = $this->Order_model->add(array("OCustId"=>$custid,"OUserId"=>$userid,"ModelId"=>$modelid,"PumpId"=>$pumpid,"CPersonName"=>$cpersonname,"Address"=>$address,"BuildingType"=>$buildingtype,"PaymentCollection"=>$paymentcollection,"datetime"=>$datetime,"OrderBy"=>$orderby,"Remark"=>$remarks,"PermanentRemark"=>$permanentremark,"Status"=>'1',"OrderType"=>$ordertype));

           if($result){
            print json_encode(array('success'=>'true', 'msg'=>'Installation Order Added Successfully','data'=>$result));

            }else{

            print json_encode(array('success'=>'false', 'msg'=>'Order Not Added'));

            }




    }
    function getserialno(){

         $post=json_decode( file_get_contents('php://input') );

            $custid      = $post->custid;
            $getallorder=$this->Order_model->getserialno($custid);
            $curdate= date('Y-m-d h:i:s');
           if($getallorder){
           $serialnoviselist=[];
                foreach ($getallorder as $orders) {

                    $orders->installed_by='';
                    $orders->Warranty = 'In Warranty';




                    $warrtydate= date("Y-m-d h:i:s", strtotime("+1 years", strtotime($orders->DateTime))); 
                    $start_date = strtotime($curdate); 
                    $end_date = strtotime($warrtydate); 
                    $diffdate=(($end_date - $start_date)/60/60/24); 
                    if($diffdate <= 0){
                        $orders->Warranty ="Expired";
                    }




                    $split=explode(',',$orders->OUserId);
                    $getcustomer=$this->Users_model->get($split[0]);
                    $orders->installed_by=ucwords($getcustomer->FirstName.' '.$getcustomer->LastName);
                    if(isset($split[1]) !=""){
                    $getcustomer=$this->Users_model->get($split[1]);
                    $orders->installed_by.=','.ucwords($getcustomer->FirstName.' '.$getcustomer->LastName);
                    }

                     $getuser=$this->Users_model->get($orders->OrderBy);
                    if($getuser){ $orders->OrderBy=ucwords($getuser->FirstName.' '.$getuser->LastName); }

                    $splitno = explode(',',$orders->SerialNo);
                    $splitmodel = explode(',', $orders->ModelId);
                    $getmodels=$this->Models_model->get($splitmodel[0]);

                    $tmparray['OrderId']= $orders->OrderId;
                    $tmparray['SerialNo']= $splitno[0];
                    $tmparray['OUserId']= $orders->OUserId;
                    $tmparray['DateTime']= $orders->DateTime;
                    $tmparray['BuildingType']= $orders->BuildingType;
                    $tmparray['CustId']= $orders->CustId;
                    $tmparray['Name']= $orders->Name;
                    $tmparray['PhoneNo']= $orders->PhoneNo;
                    $tmparray['AltPhoneNo']= $orders->AltPhoneNo;
                    $tmparray['CPersonName']= $orders->CPersonName;
                    $tmparray['PermanentRemark']= $orders->PermanentRemark;

                    $tmparray['OrderAddress']= $orders->OrderAddress;
                    $tmparray['ModelId']= $getmodels->ModelId;
                    $tmparray['ModelName']= $getmodels->Name;
                    $tmparray['PumpId']= $orders->PumpId;
                    $tmparray['PumpName']= $orders->PumpName;
                    $tmparray['installed_by']= $orders->installed_by;
                    $tmparray['Warranty']= $orders->Warranty;
                    $tmparray['OrderBy']= $orders->OrderBy;
                  

                    $serialnoviselist[] = $tmparray;


                    if(isset($splitno[1]) !=""){
                    $getmodels=$this->Models_model->get($splitmodel[1]);


                    $tmparray['OrderId']= $orders->OrderId;
                    $tmparray['SerialNo']= $splitno[1];
                    $tmparray['OUserId']= $orders->OUserId;
                    $tmparray['DateTime']= $orders->DateTime;
                    $tmparray['BuildingType']= $orders->BuildingType;
                    $tmparray['CustId']= $orders->CustId;
                    $tmparray['Name']= $orders->Name;
                    $tmparray['PhoneNo']= $orders->PhoneNo;
                    $tmparray['AltPhoneNo']= $orders->AltPhoneNo;
                    $tmparray['OrderAddress']= $orders->OrderAddress;
                    $tmparray['ModelId']= $getmodels->ModelId;
                    $tmparray['ModelName']= $getmodels->Name;
                    $tmparray['PumpId']= $orders->PumpId;
                    $tmparray['PumpName']= $orders->PumpName;
                    $tmparray['installed_by']= $orders->installed_by;
                    $tmparray['Warranty']= $orders->Warranty;
                  

                    $serialnoviselist[] = $tmparray;


                    }



                }




            print json_encode(array('success'=>'true', 'msg'=>'Serial Number Found  Successfully','data'=>$serialnoviselist));

            }else{

            print json_encode(array('success'=>'false', 'msg'=>'Serial Number Not Found '));

            }

    }    
    function addmaintenance(){
         $post=json_decode( file_get_contents('php://input') );
         
         $orderid = $post->orderid;
         $serialno = $post->serialno;
         $modelno =$post->modelid;
         $orderby =$post->orderby;
         $maintype = $post->maintype;
         $paymentcollection = $post->charges;
         $datetime      = $post->datetime;
         $userid      = $post->userid;
         $curdate= date('d-m-Y h:i:s');
        if(isset($post->remarks)){ $remarks = $post->remarks; }else{ $remarks='';}
        if(isset($post->cpersonname)){ $cpersonname = $post->cpersonname; }else{ $cpersonname='';}

        $getorder=$this->Order_model->get($orderid);

        if($getorder){


        $result = $this->Order_model->add(array("OCustId"=>$getorder->OCustId,"OUserId"=>$userid,"ModelId"=>$modelno,"SerialNo"=>$serialno,"PumpId"=>$getorder->PumpId,"Address"=>$getorder->Address,"CPersonName"=>$cpersonname,"PaymentCollection"=>$paymentcollection,"datetime"=>$datetime,"OrderBy"=>$orderby,"Remark"=>$remarks,"PermanentRemark"=>$getorder->PermanentRemark,"MainOrderId"=>$orderid,"MainType"=>$maintype,"Status"=>'1',"OrderType"=>'Maintenance'));
         $updateinstall =$this->Order_model->update($orderid,array("Address"=>$getorder->Address,"SerialNo"=>$serialno));                


           if($result){
            print json_encode(array('success'=>'true', 'msg'=>'Maintenance Order Added Successfully','data'=>$result));

            }else{

            print json_encode(array('success'=>'false', 'msg'=>'Maintenance Order Not Added'));

            }
        }else{
            print json_encode(array('success'=>'false', 'msg'=>'Order Not Found'));

        }



    }
    function getallorders(){
           $post=json_decode( file_get_contents('php://input') );
            $status = $post->status; 
            $getorders=$this->Order_model->get_order_status_all($status);

           if($getorders){

             foreach ($getorders as $orders) {
                $orders->PaymentCollectedBy = '';
                 if(is_numeric($orders->OrderBy)){
                     $getuser=$this->Users_model->get($orders->OrderBy);
                     $explode = explode(',',$orders->oUserId);
                     $userlist = "";
                    if(isset($explode[0]) !=""){
                        $empuser = $this->Users_model->get($explode[0]);
                        if($empuser){
                            $userlist.=ucwords($empuser->FirstName.' '.$empuser->LastName);
                        }
                    }
                    if(isset($explode[1]) !=""){
                        $empuser = $this->Users_model->get($explode[1]);
                        $userlist.=','.ucwords($empuser->FirstName.' '.$empuser->LastName);
                    }
                    $orders->oUserList= $userlist;

                if($getuser){
                    $orders->OrderBy=ucwords($getuser->FirstName.' '.$getuser->LastName);
                 }
                }

                if($orders->Status == '3'){
                     $getuser=$this->Users_model->get($orders->oUserId);
                     if($getuser){
                     $orders->PaymentCollectedBy=ucwords($getuser->FirstName.' '.$getuser->LastName);
                 	}
                    $splitmodel = explode(',', $orders->ModelId);
                    $getmodels=$this->Models_model->get($splitmodel[0]);
                    $ModelName = $getmodels->Name;

                    if(isset($splitmodel[1])){
                        $getmodels=$this->Models_model->get($splitmodel[1]);
                        $ModelName.= ",".$getmodels->Name;
                    }
                    $orders->ModelName = $ModelName;



                }   

                if($orders->PaymentReceivedBy != ""){
                     $getuser=$this->Users_model->get($orders->PaymentReceivedBy);
                     $orders->PaymentReceivedBy=ucwords($getuser->FirstName.' '.$getuser->LastName);

                }   




            }


            print json_encode(array('success'=>'true', 'msg'=>'Order Found Successfully','data'=>$getorders));

            }else{

            print json_encode(array('success'=>'false', 'msg'=>'Order Not Found'));

            }


    }
     function getemployeeorders(){
           $post=json_decode( file_get_contents('php://input') );
            $userid =$post->userid;
            $status = $post->status; 
              $curdate= date('d-m-Y h:i:s');
            $getorders=$this->Order_model->get_employee_orders($userid,$status);
           if($getorders){

             foreach ($getorders as $orders) {
                     if(is_numeric($orders->OrderBy)){
                         $getuser=$this->Users_model->get($orders->OrderBy);

                    if($getuser){
                        $orders->OrderBy=ucwords($getuser->FirstName.' '.$getuser->LastName);
                     }
                    }

                    $orders->Warranty = 'In Warranty';
                    $warrtydate= date("Y-m-d h:i:s", strtotime("+1 years", strtotime($orders->DateTime))); 
                    $start_date = strtotime($curdate); 
                    $end_date = strtotime($warrtydate); 
                    $diffdate=(($end_date - $start_date)/60/60/24); 
                    if($diffdate <= 0){
                        $orders->Warranty ="Expired";
                    }

                    $split=explode(',',$orders->OUserId);
                    $getcustomer=$this->Users_model->get($split[0]);                   
                    $orders->installed_by=ucwords($getcustomer->FirstName.' '.$getcustomer->LastName);
                    if(isset($split[1]) !=""){
                    $getcustomer=$this->Users_model->get($split[1]);
                    $orders->installed_by.=','.ucwords($getcustomer->FirstName.' '.$getcustomer->LastName);
                    }


            }


            print json_encode(array('success'=>'true', 'msg'=>'Order Found Successfully','data'=>$getorders));

            }else{

            print json_encode(array('success'=>'false', 'msg'=>'Order Not Found'));

            }


    }



   function chagneorderstatus(){
         $post=json_decode( file_get_contents('php://input') );

         $orderid = $post->orderid;
         $status = $post->status;

            $updateorder=$this->Order_model->update($orderid,array('Status'=>$status));                

           if($updateorder){
             
            print json_encode(array('success'=>'true', 'msg'=>'Order Status Changed  Successfully','data'=>$updateorder));

            }else{

            print json_encode(array('success'=>'false', 'msg'=>'Order Status Not Changed'));

            }


    }


   function chagneorderpayment(){
         $post=json_decode( file_get_contents('php://input') );

         $orderid = $post->OrderId;
         $paymentreceivedby = $post->paymentreceivedby;

            $updateorder=$this->Order_model->update($orderid,array('PaymentReceivedBy'=>$paymentreceivedby));                

           if($updateorder){
             
            print json_encode(array('success'=>'true', 'msg'=>'Order Status Changed  Successfully','data'=>$updateorder));

            }else{

            print json_encode(array('success'=>'false', 'msg'=>'Order Status Not Changed'));

            }


    }


   function chagneordertoqueue(){
         $post=json_decode( file_get_contents('php://input') );

         $orderid = $post->orderid;
         $reason = $post->reason;

            $updateorder=$this->Order_model->update($orderid,array('Reason'=>$reason,'Status'=>'2'));                

           if($updateorder){
             
            print json_encode(array('success'=>'true', 'msg'=>'Order Status Changed  Successfully','data'=>$updateorder));

            }else{

            print json_encode(array('success'=>'false', 'msg'=>'Order Status Not Changed'));

            }


    }


   function updateinstallation(){
         $post=json_decode( file_get_contents('php://input') );
         $updatedtime = date('d-m-Y h:i:s');

         $orderid = $post->orderid;


            $modelno = explode(',',$post->modelno);
            $serialno = $post->serialno;
            $explodserial = explode(',', $serialno);
            if(isset($explodserial[0]) && $explodserial[0] !=""){

                $checkserial = $this->SerialNumber_model->check_serialnumber($modelno[0],$explodserial[0]);
                if($checkserial ==0){
                    print json_encode(array('success'=>'false', 'msg'=>'1Serial Number Not Exists'));
                    exit;
                }
                $checkserialorder = $this->SerialNumber_model->check_serialnumber_order($modelno[0],$explodserial[0]);

                if($checkserialorder !=0){
                    print json_encode(array('success'=>'false', 'msg'=>'Serial Number Already Added'));
                    exit;
                }

            }
            if(isset($explodserial[1]) && $explodserial[1] !=""){

                $checkserial = $this->SerialNumber_model->check_serialnumber($modelno[1],$explodserial[1]);
                if($checkserial ==0){
                    print json_encode(array('success'=>'false', 'msg'=>'2Serial Number Not Exists'));
                    exit;
                }
                $checkserialorder = $this->SerialNumber_model->check_serialnumber_order($modelno[1],$explodserial[1]);

                if($checkserialorder !=0){
                    print json_encode(array('success'=>'false', 'msg'=>'Serial Number Already Added'));
                    exit;
                }

            }
             $paymode = $post->paymentmode;
             $paymentcollection = $post->paymentcollection;
             $userid = $post->paycollectedby;
             $signature = $post->signature;


           if($post->signature !='' && $post->signature !=null){
            $new_data=explode(",",$post->signature);
            $exten=explode('/',$new_data[0]);
            $exten1=explode(';',$exten[1]);
            $decoded=base64_decode($new_data[1]);
            $img_name='img_'.uniqid().'.'.$exten1[0];
            file_put_contents(APPPATH.'../uploads/'.$img_name,$decoded);
            }
            $signature =$img_name;


            $array=array("ModelId"=>implode(',',$modelno),"SerialNo"=>$serialno,"PaymentMode"=>$paymode,"Signature"=>$signature,"PaymentCollection"=>$paymentcollection,"OUserId"=>$userid,"UpdatedDateTime"=>$updatedtime,"Status"=>'3');
             if(isset($post->permanentremark)){ $array['PermanentRemark'] = $post->permanentremark; }


            $updateorder=$this->Order_model->update($orderid,$array);                
       
       

           if($updateorder){
             
            print json_encode(array('success'=>'true', 'msg'=>'Order Status Changed  Successfully','data'=>$updateorder));

            }else{

            print json_encode(array('success'=>'false', 'msg'=>'Order Status Not Changed'));

            }


    }


   function updatefield(){
         $post=json_decode( file_get_contents('php://input') );
         $updatedtime = date('d-m-Y h:i:s');

         $orderid = $post->orderid;
         $datetime      = $post->datetime;
         $userid      = $post->userid;
         $name = $post->name;
         $address = $post->address;
         $serialno = $post->serialno;
         if(isset($post->remarks)){ $remarks = $post->remarks; }else{ $remarks='';}
         if(isset($post->permanentremark)){ $permanentremark = $post->permanentremark; }else{ $permanentremark='';}
        if(isset($post->altphone)){ $altphone = $post->altphone; }else{ $altphone='';}
        if(isset($post->cpersonname)){ $cpersonname = $post->cpersonname; }else{ $cpersonname='';}

            $seleorder = $this->Order_model->get($orderid);

            $updatecustomer=$this->Customer_model->update($seleorder->OCustId,array("Name"=>$name,"Address"=>$address,"AltPhoneNo"=>$altphone));                
            

         if(isset($post->serialno) && $post->serialno !='' ){
            $updateorder=$this->Order_model->update($orderid,array("DateTime"=>$datetime,"OUserId"=>$userid,"Address"=>$address,"Remark"=>$remarks,"PermanentRemark"=>$permanentremark,"CPersonName"=>$cpersonname,"SerialNo"=>$serialno));                

            $getsingleorder = $this->Order_model->get($orderid);

            $updateinstall =$this->Order_model->update($getsingleorder->MainOrderId,array("Address"=>$address,"SerialNo"=>$serialno));                

         }else{
            $updateorder=$this->Order_model->update($orderid,array("DateTime"=>$datetime,"OUserId"=>$userid,"Address"=>$address,"Remark"=>$remarks,"CPersonName"=>$cpersonname,"PermanentRemark"=>$permanentremark));                
            
         }


           if($updateorder){
             
            print json_encode(array('success'=>'true', 'msg'=>'Order Status Changed  Successfully','data'=>$updateorder));

            }else{

            print json_encode(array('success'=>'false', 'msg'=>'Order Status Not Changed'));

            }


    }
 


   function updateadminfield(){
         $post=json_decode( file_get_contents('php://input') );
         $updatedtime = date('d-m-Y h:i:s');

         $orderid = $post->orderid;
//         $userid      = $post->userid;
         $name = $post->name;
         $address = $post->address;
        if(isset($post->permanentremark)){ $permanentremark = $post->permanentremark; }else{ $permanentremark='';}
        if(isset($post->altphone)){ $altphone = $post->altphone; }else{ $altphone='';}
        if(isset($post->cpersonname)){ $cpersonname = $post->cpersonname; }else{ $cpersonname='';}

            $seleorder = $this->Order_model->get($orderid);

            $updatecustomer=$this->Customer_model->update($seleorder->OCustId,array("Name"=>$name,"Address"=>$address,"AltPhoneNo"=>$altphone));                
            

         // if(isset($post->serialno) && $post->serialno !='' ){
         //    $updateorder=$this->Order_model->update($orderid,array("DateTime"=>$datetime,"OUserId"=>$userid,"Address"=>$address,"Remark"=>$remarks,"PermanentRemark"=>$permanentremark,"CPersonName"=>$cpersonname,"SerialNo"=>$serialno));                

         //    $getsingleorder = $this->Order_model->get($orderid);

         //    $updateinstall =$this->Order_model->update($getsingleorder->MainOrderId,array("Address"=>$address,"SerialNo"=>$serialno));                

         // }else{
            $updateorder=$this->Order_model->update($orderid,array("Address"=>$address,"CPersonName"=>$cpersonname,"PermanentRemark"=>$permanentremark));                 //"Remark"=>$remarks
            
//         }


           if($updateorder){
             
            print json_encode(array('success'=>'true', 'msg'=>'Order Status Changed  Successfully','data'=>$updateorder));

            }else{

            print json_encode(array('success'=>'false', 'msg'=>'Order Status Not Changed'));

            }


    }
 

   function updatemaintenance(){
         $post=json_decode( file_get_contents('php://input') );

         $orderid = $post->orderid;
         $solutiontype = $post->solutiontype;
//         $modelno = $post->modelno;
  //       $serialno = $post->serialno;
         $paymode = $post->paymentmode;
         $paymentcollection = $post->paymentcollection;
         $userid = $post->paycollectedby;
         $signature = $post->signature;
         $updatedtime = date('d-m-Y h:i:s');


       if($post->signature !='' && $post->signature !=null){
        $new_data=explode(",",$post->signature);
        $exten=explode('/',$new_data[0]);
        $exten1=explode(';',$exten[1]);
        $decoded=base64_decode($new_data[1]);
        $img_name='img_'.uniqid().'.'.$exten1[0];
        file_put_contents(APPPATH.'../uploads/'.$img_name,$decoded);
        }
        $signature =$img_name;

            $updateorder=$this->Order_model->update($orderid,array("PaymentMode"=>$paymode,"Signature"=>$signature,"PaymentCollection"=>$paymentcollection,"OUserId"=>$userid,"SolutionType"=>$solutiontype,"UpdatedDateTime"=>$updatedtime,"Status"=>'3'));                


           if($updateorder){
             
            print json_encode(array('success'=>'true', 'msg'=>'Order Status Changed  Successfully','data'=>$updateorder));

            }else{

            print json_encode(array('success'=>'false', 'msg'=>'Order Status Not Changed'));

            }


    }















    function getallpayment(){
           $post=json_decode( file_get_contents('php://input') );
            $status = $post->status; 
            $getorders=$this->Order_model->get_payment_status_all($status);

           if($getorders){

             foreach ($getorders as $orders) {
                 if(is_numeric($orders->OrderBy)){
                     $getuser=$this->Users_model->get($orders->OrderBy);

                if($getuser){
                    $orders->OrderBy=ucwords($getuser->FirstName.' '.$getuser->LastName);
                 }
                }

                  if($orders->Status == '3'){
                 	 $orders->PaymentCollectedBy ="";
                     $getuser=$this->Users_model->get($orders->oUserId);
                     $orders->OwnerId=$orders->PaymentReceivedBy;
                     $getowner= $this->Users_model->get($orders->OwnerId);
                     if($getowner){
                     $orders->OwnerName=ucwords($getowner->FirstName.' '.$getowner->LastName);
                 	}
                     if($getuser){
                     $orders->PaymentCollectedBy=ucwords($getuser->FirstName.' '.$getuser->LastName);
                 	}
                    $splitmodel = explode(',', $orders->ModelId);
                    $getmodels=$this->Models_model->get($splitmodel[0]);
                    $ModelName = $getmodels->Name;

                    if(isset($splitmodel[1])){
                        $getmodels=$this->Models_model->get($splitmodel[1]);
                        $ModelName.= ",".$getmodels->Name;
                    }
                    $orders->ModelName = $ModelName;
                }  
            }


            print json_encode(array('success'=>'true', 'msg'=>'Payment Found Successfully','data'=>$getorders));

            }else{

            print json_encode(array('success'=>'false', 'msg'=>'Payment Not Found'));

            }


    }

    function getalldemo(){
           $post=json_decode( file_get_contents('php://input') );
            $status = $post->status; 
            $getorders=$this->Demo_model->get_order_status_all($status);

           if($getorders){

            print json_encode(array('success'=>'true', 'msg'=>'Demo Found Successfully','data'=>$getorders));

            }else{

            print json_encode(array('success'=>'false', 'msg'=>'Demo Not Found'));

            }


    }

    function adddemo(){
         $post=json_decode( file_get_contents('php://input') );

         $name      = $post->partyname;
         $address      = $post->address;
         $phone      = $post->phone;
         $modelid      = $post->modelid;
         $pumpid      = $post->pumpid;
         $price      = $post->price;
         $orderby      = $post->orderby;
         $apptime      = $post->apptime;
         $remark      = $post->remark;
         $datetime      = date('Y-m-d h:i:s');
         $status      = $post->status;
        if(isset($post->altphone)){ $altphone = $post->altphone; }else{ $altphone='';}
        if(isset($post->cpersonname)){ $cpersonname = $post->cpersonname; }else{ $cpersonname='';}


        $result = $this->Demo_model->add(array("PartyName"=>$name,"Address"=>$address,"ModelId"=>$modelid,"PumpId"=>$pumpid,"OrderBy"=>$orderby,"datetime"=>$datetime,"PhoneNo"=>$phone,"price"=>$price,"AppTime"=>$apptime,"CPersonName"=>$cpersonname,"AltPhoneNo"=>$altphone,"Remark"=>$remark,"Status"=>'1'));

           if($result){
            print json_encode(array('success'=>'true', 'msg'=>'Demo Order Added Successfully','data'=>$result));

            }else{

            print json_encode(array('success'=>'false', 'msg'=>'Order Not Added'));

            }




    }


   function chagnedemostatus(){
         $post=json_decode( file_get_contents('php://input') );

         $demoid = $post->demoid;
         $status = $post->status;

            $updateorder=$this->Demo_model->update($demoid,array('Status'=>$status));                

           if($updateorder){
             
            print json_encode(array('success'=>'true', 'msg'=>'Demo Status Changed  Successfully','data'=>$updateorder));

            }else{

            print json_encode(array('success'=>'false', 'msg'=>'Demo Status Not Changed'));

            }


    }
   function deletedemo(){
         $post=json_decode( file_get_contents('php://input') );

         $demoid = $post->demoid;

           $updateorder=$this->Demo_model->delete($demoid);                

           if($updateorder){
             
            print json_encode(array('success'=>'true', 'msg'=>'Demo Record deleted Successfully','data'=>$updateorder));

            }else{

            print json_encode(array('success'=>'false', 'msg'=>'Demo Status Not Changed'));

            }


    }

    function addsingleserialno(){
         $post=json_decode( file_get_contents('php://input') );

         $modelid      = $post->modelid;
         $finalserialnumber      = $post->serialno;
         $datetime      = date('Y-m-d h:i:s');
         $checkModelNo=$this->SerialNumber_model->checkSerialNoInOrder($finalserialnumber);

         $result ="";
           if(empty($checkModelNo)){
                // check serial number 
                $checkserialnumber = $this->SerialNumber_model->checkSerialNoAndModelNo($modelid,$finalserialnumber);

                if(empty($checkserialnumber)){

                $result = $this->SerialNumber_model->add(array("ModelId"=>$modelid,"SerialNo"=>$finalserialnumber,"Date"=>$datetime,"Status"=>'1'));
                }

            }else{

                $getserialno = explode(',',$checkModelNo->SerialNo);
                $getserialindex = array_search($finalserialnumber, $getserialno);
                $getmodelno = explode(',',$checkModelNo->ModelId);
                if($modelid != $getmodelno[$getserialindex]){

                $checkserialnumber = $this->SerialNumber_model->checkSerialNoAndModelNo($modelid,$finalserialnumber);

                if(empty($checkserialnumber)){

                   $result = $this->SerialNumber_model->add(array("ModelId"=>$modelid,"SerialNo"=>$finalserialnumber,"Date"=>$datetime,"Status"=>'1'));
                }

                }

            }
           // $result = $this->SerialNumber_model->add(array("ModelId"=>$modelid,"SerialNo"=>$serialno,"Date"=>$datetime,"Status"=>'1'));

           if($result){
            print json_encode(array('success'=>'true', 'msg'=>'Serial Number Added Successfully','data'=>$result));

            }else{

            print json_encode(array('success'=>'false', 'msg'=>'Serial Number Not Added'));

            }




    }

    function addmultiserialno(){
         $post=json_decode( file_get_contents('php://input') );

         $modelid      = $post->modelid;
         $prefix = $post->prefix;
         $startid = $post->startid;
         $endid = $post->endid;
         $strlen = strlen($startid);         
         $datetime      = date('Y-m-d h:i:s');
         $result ="";
         $listofserialnumber=[];
         $isempty =0;
         $j=0;
         for($i=$startid;$i<=$endid; $i++){
           $str = substr(str_repeat(0, $strlen) . $i, -$strlen);
           $finalserialnumber = $prefix.$str;

           $finalserialnumber = $prefix.$str;
           $checkModelNo=$this->SerialNumber_model->checkSerialNoInOrder($finalserialnumber);
         
            if(empty($checkModelNo)){
                // check serial number 
                $checkserialnumber = $this->SerialNumber_model->checkSerialNoAndModelNo($modelid,$finalserialnumber);

                if(empty($checkserialnumber)){
                    $isempty++;
                }

            }else{

                $getserialno = explode(',',$checkModelNo->SerialNo);
                $getserialindex = array_search($finalserialnumber, $getserialno);
                $getmodelno = explode(',',$checkModelNo->ModelId);
                if($modelid != $getmodelno[$getserialindex]){

                $checkserialnumber = $this->SerialNumber_model->checkSerialNoAndModelNo($modelid,$finalserialnumber);

                if(empty($checkserialnumber)){
                    $isempty++;
                }

                }

            }
        $j++;
         }

        if($isempty == $j){

         for($i=$startid;$i<=$endid; $i++){
           $str = substr(str_repeat(0, $strlen) . $i, -$strlen);
           $finalserialnumber = $prefix.$str;
                  $result = $this->SerialNumber_model->add(array("ModelId"=>$modelid,"SerialNo"=>$finalserialnumber,"Date"=>$datetime,"Status"=>'1'));
         }

        }




//          for($i=$startid;$i<=$endid; $i++){
//            $str = substr(str_repeat(0, $strlen) . $i, -$strlen);
//            $finalserialnumber = $prefix.$str;
//            $checkModelNo=$this->SerialNumber_model->checkSerialNoInOrder($finalserialnumber);
         
//             if(empty($checkModelNo)){
//                 // check serial number 
//                 $checkserialnumber = $this->SerialNumber_model->checkSerialNoAndModelNo($modelid,$finalserialnumber);

//                 if(empty($checkserialnumber)){

//                 $result = $this->SerialNumber_model->add(array("ModelId"=>$modelid,"SerialNo"=>$finalserialnumber,"Date"=>$datetime,"Status"=>'1'));
//                 }

//             }else{

//                 $getserialno = explode(',',$checkModelNo->SerialNo);
//                 $getserialindex = array_search($finalserialnumber, $getserialno);
//                 $getmodelno = explode(',',$checkModelNo->ModelId);
//                 if($modelid != $getmodelno[$getserialindex]){

//                 $checkserialnumber = $this->SerialNumber_model->checkSerialNoAndModelNo($modelid,$finalserialnumber);

//                 if(empty($checkserialnumber)){

//                    $result = $this->SerialNumber_model->add(array("ModelId"=>$modelid,"SerialNo"=>$finalserialnumber,"Date"=>$datetime,"Status"=>'1'));
//                 }

//                 }

//             }

// //           $result = $this->SerialNumber_model->add(array("ModelId"=>$modelid,"SerialNo"=>$prefix.$str,"Date"=>$datetime,"Status"=>'1'));


//          }

           if($result){
            print json_encode(array('success'=>'true', 'msg'=>'Serial Number Added Successfully','data'=>$result));

            }else{

            print json_encode(array('success'=>'false', 'msg'=>'Serial Number Not Added'));

            }




    }

     function getserialnobymodel(){
           $post=json_decode( file_get_contents('php://input') );
            $modelid = $post->modelid; 
            $getserialno=$this->SerialNumber_model->get_serialno_model($modelid);

           if($getserialno){

            print json_encode(array('success'=>'true', 'msg'=>'Serial Number Found Successfully','data'=>$getserialno));

            }else{

            print json_encode(array('success'=>'false', 'msg'=>'Serial Number Not Found'));

            }


    }
	public function index()
	{
        echo '212121';
//		$this->load->view('home_view');
	}

	
}

?>