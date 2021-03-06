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
        $this->load->model('District_model');
        $this->load->model('Product_model');
        $this->load->model('Inventory_model');
        $this->load->model('Cart_model');
        $this->load->model('Order_model');
        $this->load->model('Order_Detail_model');
        $this->load->model('Vehicle_model');
        $this->load->model('Driver_model');
        $this->load->model('Order_Locations_model');
        $this->load->model('Review_model');
 

        $this->load->model('Models_model');
        $this->load->model('Pump_model');

        $this->load->model('Category_model');
        $this->load->model('Menu_model');
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
                        exit;

           }else{

                print json_encode(array('success'=>0, 'msg'=>'Email Address Not Exists'));
                        exit;
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
                        $status = 0;$IsAccount =0;
                        if($Role==2){
                            $status = 1; $IsAccount = 1;
                        }

                        $addUser=$this->Users_model->add(array('CompanyName'=>$CompanyName,'FirstName'=>$FirstName,'LastName'=>$LastName,'Email'=>$Email,'Password'=>md5($Password),'Image'=>$Image,'MobileNumber'=>$MobileNumber,'IsEmailVerify'=>'1','IsMobileNumberVerify'=>'1','Role'=>$Role,'IsAccount'=>$IsAccount,'Status'=>$status));

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
                        exit;

                    }else{

                    print json_encode(array('success'=>3, 'msg'=>'Mobile Number Already Exists'));
                        exit;

                    }

            }else{
                        print json_encode(array('success'=>2, 'msg'=>'Email Already Exists'));

                        exit;
            }            

        exit;
    }

    public function signup3(){

         $post      =json_decode( file_get_contents('php://input') );
         $Address   = $post->Address;
         $Landmark  = isset($post->Landmark) ? $post->Landmark : '';
         $CountryId = $post->CountryId;
         $StateId   = $post->StateId;
         $DistrictId   = $post->DistrictId;
         $CityId    = $post->CityId;
         $UserId    = $post->UserId;

          $getUser=$this->Users_model->getId($UserId);
          $IsAccount = 0;
            if($getUser){
                $Role = $getUser->Role;
                if($Role == 2){
                    $IsAccount = 1;
                }
            }
            $updateUser=$this->Users_model->update($UserId,array('Address'=>$Address,'Landmark'=>$Landmark,'CountryId'=>$CountryId,'StateId'=>$StateId,'DistrictId'=>$DistrictId,'CityId'=>$CityId,'IsAccount'=>$IsAccount,'Status'=>1));

            if($updateUser){
              $getUser1=$this->Users_model->getId($UserId);
                print json_encode(array('success'=>1, 'msg'=>'Signup successful','data'=>$getUser1));
                exit;
            }else{
                print json_encode(array('success'=>0, 'msg'=>'Something Wrong'));
                exit;
            }


    }


    public function login(){
        $post=json_decode( file_get_contents('php://input') );
         $email      = $post->email;
         $password      = $post->password;
         if(!$email){

            print json_encode(array('success'=>0, 'msg'=>'Enter Complete login form','data'=>'e - '.$email));
            exit;

         }else{
            $finaldata=$this->Users_model->checklogin($email);
           if($finaldata){
                   if($finaldata->Password==md5($password)){

                        unset($finaldata->Password);

                        if($finaldata->IsAccount ==0){

                        print json_encode(array('success'=>2, 'msg'=>'Account Not Verify'));
                        exit;

                        }
                        if($finaldata->IsAccount ==2){

                        print json_encode(array('success'=>3, 'msg'=>$finaldata->Reason));
                        exit;

                        }


                        print json_encode(array('success'=>1, 'msg'=>'Login successful','data'=>$finaldata));
                        exit;

                    }else{

                    print json_encode(array('success'=>0, 'msg'=>'Password Not Match'));
                    exit;

                    }

            }else{


                print json_encode(array('success'=>4, 'msg'=>'Invalid Mobile Number'));

            }            

        }
        exit;
    }

    public function driverlogin(){
        $post=json_decode( file_get_contents('php://input') );
         $email      = $post->email;
         $password      = $post->password;
         if(!$email){

            print json_encode(array('success'=>0, 'msg'=>'Enter Complete login form','data'=>'e - '.$email));
            exit;

         }else{
            $finaldata=$this->Driver_model->checklogin($email);
           if($finaldata){
                   if($finaldata->DPassword==md5($password)){

                        unset($finaldata->DPassword);

                        if($finaldata->DStatus ==0){

                        print json_encode(array('success'=>2, 'msg'=>'Account Not Verify'));
                        exit;

                        }
                        if($finaldata->DStatus ==2){

                        print json_encode(array('success'=>3, 'msg'=>$finaldata->Reason));
                        exit;

                        }


                        print json_encode(array('success'=>1, 'msg'=>'Login successful','data'=>$finaldata));
                        exit;

                    }else{

                    print json_encode(array('success'=>0, 'msg'=>'Password Not Match'));
                    exit;

                    }

            }else{


                print json_encode(array('success'=>4, 'msg'=>'Invalid Mobile Number'));

            }            

        }
        exit;
    }

    function getallddl(){
        $getCountry=$this->Country_model->get_all();
        $getState=$this->State_model->get_all();
        $getDistrict=$this->District_model->get_all();
        $getCity=$this->City_model->get_all();

        print json_encode(array('success'=>'true', 'msg'=>'Record Found Successfully','country'=>$getCountry,'State'=>$getState,'District'=>$getDistrict,'city'=>$getCity));



    }
    function getallvahicledriver(){
        $post=json_decode( file_get_contents('php://input') );
        $UserId      = $post->UserId;
        $getDriver=$this->Driver_model->get_all_with_id($UserId);
        $getVehicle=$this->Vehicle_model->get_all_with_id($UserId);

        print json_encode(array('success'=>1, 'msg'=>'Record Found Successfully','data'=>['vehicle'=>$getVehicle,'driver'=>$getDriver]));



    }
    
    function gettransporterdriver(){
        $post=json_decode( file_get_contents('php://input') );
        $UserId      = $post->UserId;
        $getDriver=$this->Driver_model->get_all_by_id($UserId);
        print json_encode(array('success'=>1, 'msg'=>'Record Found Successfully','data'=>$getDriver));



    }
    function gettransportervehicle(){
        $post=json_decode( file_get_contents('php://input') );
        $UserId      = $post->UserId;
        $getVehicle=$this->Vehicle_model->get_all_by_id($UserId);
        print json_encode(array('success'=>1, 'msg'=>'Record Found Successfully','data'=>$getVehicle));



    }
    

    public function updatetransporterdriver(){
        $post=json_decode( file_get_contents('php://input') );
         $DId      = $post->DriverId;
         $FirstName      = $post->FirstName;
         $LastName      = $post->LastName;
         $MobileNumber      = $post->MobileNumber;
         $Password      = $post->Password;
         $curdate= date('Y-m-d h:i:s');
         $Image = "";
         if(isset($post->LicenceImage) && $post->LicenceImage !=""){
            $new_data=explode(",",$post->LicenceImage);
            $exten=explode('/',$new_data[0]);
            $exten1=explode(';',$exten[1]);
            $decoded=base64_decode($new_data[1]);
            $Image='driver_'.uniqid().'.'.$exten1[0];
            file_put_contents(APPPATH.'../uploads/'.$Image,$decoded);
         }

         $DImage ="";
         if(isset($post->DriverPhoto) && $post->DriverPhoto !=""){
            $new_data=explode(",",$post->DriverPhoto);
            $exten=explode('/',$new_data[0]);
            $exten1=explode(';',$exten[1]);
            $decoded=base64_decode($new_data[1]);
            $DImage='driver_'.uniqid().'.'.$exten1[0];
            file_put_contents(APPPATH.'../uploads/'.$DImage,$decoded);
         }

         $getDriverById= $this->Driver_model->get($DId);


         $checkdriver = $this->Driver_model->getwherenotid('DMobileNumber',$MobileNumber,$DId);
         if($checkdriver){
            print json_encode(array('success'=>2, 'msg'=>'Driver Mobile Number Already Exists'));
            exit;
         }


         $updateDriver = $this->Driver_model->update($DId,array('IsEdited'=>'1'));
         if($Password ==""){

         $addDriver = $this->Driver_model->add(array('PDriverId'=>$DId,'DTransId'=>$getDriverById->DTransId,'DFirstName'=>$FirstName,'DLastName'=>$LastName,'DMobileNumber'=>$MobileNumber,'DPassword'=>md5($Password),'DLicenceImage'=>$Image,'DImage'=>$DImage,'CreatedAt'=>$curdate,'UpdatedAt'=>$curdate));
         }else{

         $addDriver = $this->Driver_model->add(array('PDriverId'=>$DId,'DTransId'=>$getDriverById->DTransId,'DFirstName'=>$FirstName,'DLastName'=>$LastName,'DMobileNumber'=>$MobileNumber,'DLicenceImage'=>$Image,'DImage'=>$DImage,'CreatedAt'=>$curdate,'UpdatedAt'=>$curdate));
         }

         if($updateDriver){
            print json_encode(array('success'=>1, 'msg'=>'Driver Updated Successfully'));

         }else{
            print json_encode(array('success'=>0, 'msg'=>'Driver Not Add'));

         }


    }

    public function updatetransportervehicle(){
        $post=json_decode( file_get_contents('php://input') );
         $VId      = $post->VehicleId;
         $RcNo      = $post->RcNo;
         $VNo      = $post->VNo;
         $Image = "";
         if(isset($post->RcImage) && $post->RcImage !=""){
            $new_data=explode(",",$post->RcImage);
            $exten=explode('/',$new_data[0]);
            $exten1=explode(';',$exten[1]);
            $decoded=base64_decode($new_data[1]);
            $Image='vehicle_'.uniqid().'.'.$exten1[0];
            file_put_contents(APPPATH.'../uploads/'.$Image,$decoded);
         }

         $curdate= date('Y-m-d h:i:s');

         $getVehicleById= $this->Vehicle_model->get($VId);

         $updateVehicle = $this->Vehicle_model->update($VId,array('IsEdited'=>'1'));
         
         $addvehicle = $this->Vehicle_model->add(array('PVehicleId'=>$VId,'VTransId'=>$getVehicleById->VTransId,'VRcNo'=>$RcNo,'VNo'=>$VNo,'VRcImage'=>$Image,'CreatedAt'=>$curdate,'UpdatedAt'=>$curdate,'VStatus'=>0));

         if($updateVehicle){
            print json_encode(array('success'=>1, 'msg'=>'Driver Updated Successfully'));

         }else{
            print json_encode(array('success'=>0, 'msg'=>'Driver Not Add'));

         }


    }





    function getallddlios(){
        $getCountry=$this->Country_model->get_all();
        $getState=$this->State_model->get_all();
        $getDistrict=$this->District_model->get_all();
        $getCity=$this->City_model->get_all();

        print json_encode(array('success'=>1, 'msg'=>'Record Found Successfully','data'=>['country'=>$getCountry,'State'=>$getState,'District'=>$getDistrict,'city'=>$getCity]));



    }
    public function getaddress(){
        $post=json_decode( file_get_contents('php://input') );
         $UserId      = $post->UserId;
         $getUser= $this->Users_model->getId($UserId);

         if($getUser->Address){

            print json_encode(array('success'=>1, 'msg'=>'Record Found Successfully','data'=>$getUser));
         }else{
            print json_encode(array('success'=>0, 'msg'=>'Record Not Add'));

         }

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
         $IsImage      = $post->IsImage;
         $curdate= date('Y-m-d h:i:s');
         $Image = "";
         $getProductById= $this->Product_model->getId($ProductId);
         $Image = $getProductById->PImage;
         if($IsImage == 1){

             if(isset($post->Image) && $post->Image !=""){
                $new_data=explode(",",$post->Image);
                $exten=explode('/',$new_data[0]);
                $exten1=explode(';',$exten[1]);
                $decoded=base64_decode($new_data[1]);
                $Image='product_'.uniqid().'.'.$exten1[0];
                file_put_contents(APPPATH.'../uploads/'.$Image,$decoded);
             }
        }

         $updateProduct = $this->Product_model->update($ProductId,array('IsEdited'=>'1'));
         
         $addProduct = $this->Product_model->add(array('PProductId'=>$ProductId,'PManuId'=>$getProductById->PManuId,'PName'=>$Name,'PMinDeliveryDays'=>$MinDeliveryDays,'PImage'=>$Image,'PPrice'=>$Price,'PDescription'=>$Description,'PAdditionalInfo'=>$AdditionalInfo,'Created_At'=>$curdate,'Updated_At'=>$curdate));
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

         $getProductById= $this->Product_model->getId($ProductId);
        if($getProductById->IsAccount == 0){
            print json_encode(array('success'=>1, 'msg'=>'Product Is Pending'));
            exit;
        }
        if($getProductById->IsAccount == 2){
            print json_encode(array('success'=>2, 'msg'=>'Product Rejected By Admin'));
            exit;
        }

         $updateStock = $this->Inventory_model->add(array('IProductId'=>$ProductId,'Stock_Qty'=>$Stock,'Created_At'=>$curdate,'Updated_At'=>$curdate));
         if($updateStock){
            $this->db->where('ProductId', $post->ProductId);
            $this->db->set('PStock', 'PStock+'.$Stock, FALSE);
            $this->db->update('product');
            print json_encode(array('success'=>1, 'msg'=>'Stock Updated Successfully'));

         }else{
            print json_encode(array('success'=>3, 'msg'=>'Product Not Add'));

         }


    }



    public function getallproduct(){
        $post=json_decode( file_get_contents('php://input') );
        // Filter

        $Manufacture      = isset($post->Manufacture) ? $post->Manufacture: '';
        $Price      = isset($post->Price) ? $post->Price: '';
        $Sorting      = isset($post->Sorting) ? $post->Sorting: '';


        $getallproduct=$this->Product_model->get_all($Manufacture,$Price,$Sorting);

        $getallmenufature = $this->Manufacture_model->get_all_active_manufacture();

        if($getallproduct){
            print json_encode(array('success'=>1, 'msg'=>'Product Found Successfully','data'=>$getallproduct,'manufacturer'=>$getallmenufature));

        }else{
            print json_encode(array('success'=>0, 'msg'=>'Product Not Found'));

        }



    }
    public function getallproductios(){
        $post=json_decode( file_get_contents('php://input') );
        // Filter

        $Manufacture      = isset($post->Manufacture) ? $post->Manufacture: '';
        $Price      = isset($post->Price) ? $post->Price: '';
        $Sorting      = isset($post->Sorting) ? $post->Sorting: '';


        $getallproduct=$this->Product_model->get_all($Manufacture,$Price,$Sorting);

        $getallmenufature = $this->Manufacture_model->get_all_active_manufacture();

        if($getallproduct){
            print json_encode(array('success'=>1, 'msg'=>'Product Found Successfully','data'=>['allproduct'=>$getallproduct,'manufacturer'=>$getallmenufature]));

        }else{
            print json_encode(array('success'=>0, 'msg'=>'Product Not Found'));

        }



    }

    public function addtocart(){
        $post=json_decode( file_get_contents('php://input') );
         $ProductId      = $post->ProductId;
         $UserId      = $post->UserId;
         $Qty      = $post->Qty;
         $Price      = $post->Price;
         $curdate= date('Y-m-d h:i:s');
         // check 
        $checkcart = $this->Cart_model->get_with_userid($UserId,$ProductId);

        if($checkcart){
         $addtocart = $this->Cart_model->update($checkcart->CartId,array('CQty'=>$checkcart->CQty + 1,'UpdatedAt'=>$curdate));

        }else{

         $addtocart = $this->Cart_model->add(array('CProductId'=>$ProductId,'CUserId'=>$UserId,'CPrice'=>$Price,'CQty'=>$Qty,'CreatedAt'=>$curdate,'UpdatedAt'=>$curdate,'CStatus'=>1));

        }
         if($addtocart){
            print json_encode(array('success'=>1, 'msg'=>'Cart Added Successfully'));

         }else{
            print json_encode(array('success'=>0, 'msg'=>'Product Not Add'));

         }


    }
   function deletecartbyid(){
         $post=json_decode( file_get_contents('php://input') );

         $CartId = $post->CartId;

           $updateorder=$this->Cart_model->delete($CartId);                

           if($updateorder){
             
            print json_encode(array('success'=>1, 'msg'=>'Cart Record deleted Successfully','data'=>$updateorder));

            }else{

            print json_encode(array('success'=>0, 'msg'=>'Cart Not Deleted'));

            }


    }


    public function getcartbyuserid(){
        $post=json_decode( file_get_contents('php://input') );
        $UserId      = $post->UserId;
        $getallcart=$this->Cart_model->get_all_by_userid($UserId);

        if($getallcart){
            print json_encode(array('success'=>1, 'msg'=>'Cart Found Successfully','data'=>$getallcart));

        }else{
            print json_encode(array('success'=>0, 'msg'=>'Product Not Found'));

        }



    }

    public function updatecartbyid(){
        $post=json_decode( file_get_contents('php://input') );
         $CartId      = $post->CartId;
         $Qty      = $post->Qty;
         $curdate= date('Y-m-d h:i:s');

         $updatetocart = $this->Cart_model->update($CartId,array('CQty'=>$Qty,'UpdatedAt'=>$curdate));
         if($updatetocart){
            print json_encode(array('success'=>1, 'msg'=>'Cart Updated Successfully'));

         }else{
            print json_encode(array('success'=>0, 'msg'=>'Product Not Add'));

         }


    }


   public function addorder(){
        $post=json_decode( file_get_contents('php://input') );
         $UserId      = $post->UserId;
         $IsSameAddress   = $post->IsSameAddress;
         $Address   = isset($post->Address)? $post->Address : '';
         $Landmark  = isset($post->Landmark) ? $post->Landmark : '';
         $CountryId = isset($post->CountryId) ? $post->CountryId : 0;
         $StateId   = isset($post->StateId) ? $post->StateId : 0;
         $DistrictId    = isset($post->DistrictId) ? $post->DistrictId : 0;
         $CityId    = isset($post->CityId) ? $post->CityId : 0;
         $DeliveryDate    = $post->DeliveryDate;

         $curdate= date('Y-m-d h:i:s');

        // select cart by id

         $getallcart=$this->Cart_model->get_all_cart_by_userid($UserId);

         $total = 0;

        $addorder = $this->Order_model->add(array('OUserId'=>$UserId,'OAddress'=>$Address,'OLandMark'=>$Landmark,'OCountryId'=>$CountryId,'OStateId'=>$StateId,'ODistrictId'=>$DistrictId,'OCityId'=>$CityId,'IsSameAddress'=>$IsSameAddress,'ODeliveryDate'=>$DeliveryDate,"OStatus"=>'1','Created_At'=>$curdate,'Updated_At'=>$curdate));
         foreach($getallcart as $cart){

            $addorderdetail = $this->Order_Detail_model->add(array('OdManuId'=>$cart->PManuId,'OdProductId'=>$cart->ProductId,'OdQty'=>$cart->Qty,'OdPrice'=>$cart->Price,'OdOrderId'=>$addorder));

            $productPrice = $cart->Price* $cart->Qty;


            $total += $productPrice;
         }
        $updateorder = $this->Order_model->update($addorder,array('OTotal'=>$total));

        $getuser = $this->Users_model->getId($UserId);
        if($getuser->Address ==""){

            $updateuser = $this->Users_model->update($UserId,array('Address'=>$Address,'Landmark'=>$Landmark,'CountryId'=>$CountryId,'StateId'=>$StateId,'DistrictId'=>$DistrictId,'CityId'=>$CityId));   

        }

         if($addorder){

            $deleteCart =$this->Cart_model->delete_by_userid($UserId);
            print json_encode(array('success'=>1, 'msg'=>'Order Added Successfully','order'=>$addorder));

         }else{
            print json_encode(array('success'=>0, 'msg'=>'Cart Not Found'));

         }


    }
    public function addvehicle(){
        $post=json_decode( file_get_contents('php://input') );
         $TransporterId      = $post->TransporterId;
         $RcNo      = $post->RcNo;
         $VNo      = $post->VNo;
         $Image = "";
         if(isset($post->RcImage) && $post->RcImage !=""){
            $new_data=explode(",",$post->RcImage);
            $exten=explode('/',$new_data[0]);
            $exten1=explode(';',$exten[1]);
            $decoded=base64_decode($new_data[1]);
            $Image='vehicle_'.uniqid().'.'.$exten1[0];
            file_put_contents(APPPATH.'../uploads/'.$Image,$decoded);
         }


         $curdate= date('Y-m-d h:i:s');

         $addvehicle = $this->Vehicle_model->add(array('VTransId'=>$TransporterId,'VRcNo'=>$RcNo,'VNo'=>$VNo,'VRcImage'=>$Image,'CreatedAt'=>$curdate,'UpdatedAt'=>$curdate,'VStatus'=>0));
         if($addvehicle){
            print json_encode(array('success'=>1, 'msg'=>'Vehicle Added Successfully'));

         }else{
            print json_encode(array('success'=>0, 'msg'=>'Vehicle Not Add'));

         }


    }






    public function adddriver(){
        $post=json_decode( file_get_contents('php://input') );
         $TransporterId      = $post->TransporterId;
         $FirstName      = $post->FirstName;
         $LastName      = $post->LastName;
         $MobileNumber      = $post->MobileNumber;
         $Password      = $post->Password;
         $Image = "";
         if(isset($post->LicenceImage) && $post->LicenceImage !=""){
            $new_data=explode(",",$post->LicenceImage);
            $exten=explode('/',$new_data[0]);
            $exten1=explode(';',$exten[1]);
            $decoded=base64_decode($new_data[1]);
            $Image='driver_'.uniqid().'.'.$exten1[0];
            file_put_contents(APPPATH.'../uploads/'.$Image,$decoded);
         }
         $DImage ="";
         if(isset($post->DriverPhoto) && $post->DriverPhoto !=""){
            $new_data=explode(",",$post->DriverPhoto);
            $exten=explode('/',$new_data[0]);
            $exten1=explode(';',$exten[1]);
            $decoded=base64_decode($new_data[1]);
            $DImage='driver_'.uniqid().'.'.$exten1[0];
            file_put_contents(APPPATH.'../uploads/'.$DImage,$decoded);
         }


         $curdate= date('Y-m-d h:i:s');

         $checkdriver = $this->Driver_model->getwhere('DMobileNumber',$MobileNumber);
         if($checkdriver){
            print json_encode(array('success'=>2, 'msg'=>'Driver Mobile Number Already Exists'));
            exit;
         }

         $adddriver = $this->Driver_model->add(array('DTransId'=>$TransporterId,'DFirstName'=>$FirstName,'DLastName'=>$LastName,'DMobileNumber'=>$MobileNumber,'DImage'=>$DImage,'DPassword'=>md5($Password),'DLicenceImage'=>$Image,'CreatedAt'=>$curdate,'UpdatedAt'=>$curdate,'DStatus'=>0));
         if($adddriver){
            print json_encode(array('success'=>1, 'msg'=>'Driver Added Successfully'));

         }else{
            print json_encode(array('success'=>0, 'msg'=>'Driver Not Add'));

         }


    }

    function getcustomerorders(){
        $post=json_decode( file_get_contents('php://input') );
         $UserId      = $post->UserId;
        $Status = $post->Status; // '=pending, assign,process,delivered,' 

        $getorders=$this->Order_Detail_model->get_all_orders_by_customer($UserId,$Status);
        if($getorders){

                $tmporders = [];
                foreach($getorders as $orders){
                    $getuser=$this->Users_model->getId($orders->OdTransId);
                    $orders->TransporterDetail = $getuser;
                    $tmporders[] = $orders;
                }

            print json_encode(array('success'=>1, 'msg'=>'Record Found Successfully','data'=>$tmporders));
        }else{
            print json_encode(array('success'=>0, 'msg'=>'Record Not Found'));

        }



    }
    function gettransporterorders(){
        $post=json_decode( file_get_contents('php://input') );
        $UserId      = $post->UserId;
        $Status = $post->Status; // '=pending, assign,process,delivered,' 

        $getorders=$this->Order_Detail_model->get_all_orders_by_transporter($UserId,$Status);

        if($getorders){
                $tmporders = [];

                foreach($getorders as $orders){
                    $getmanu=$this->Manufacture_model->getId($orders->OdManuId);
                    $orders->ManufactureCountryName= $getmanu->CName;
                    $orders->ManufactureStateName= $getmanu->SName;
                    $orders->ManufactureDistrictName= $getmanu->DName;
                    $orders->ManufactureCityName= $getmanu->CityName;

                    $getuser=$this->Customer_model->getId($orders->OUserId);
                    $orders->CustomerFirstName = $getuser->FirstName;
                    $orders->CustomerLastName = $getuser->LastName;
                    $orders->CustomerAddress = $getuser->Address;
                    $orders->CustomerLandmark = $getuser->Landmark;
                    $orders->CustomerCountryName = $getuser->CName;
                    $orders->CustomerStateName = $getuser->SName;
                    $orders->CustomerDistrictName = $getuser->DName;
                    $orders->CustomerCityName = $getuser->CityName;
                    $orders->CustomerMobileNumber = $getuser->MobileNumber;
                    $tmporders[] = $orders;

                }


            print json_encode(array('success'=>1, 'msg'=>'Record Found Successfully','data'=>$tmporders));
        }else{
             print json_encode(array('success'=>0, 'msg'=>'Record Not Found'));
           
        }



    }
    function getmanufactureorders(){
        $post=json_decode( file_get_contents('php://input') );
        $UserId      = $post->UserId;
        $Status = $post->Status; // '=pending, assign,process,delivered,' 

        $getorders=$this->Order_Detail_model->get_all_orders_by_manufacture($UserId,$Status);

        if($getorders){
                $tmporders = [];

                foreach($getorders as $orders){

                    $getuser=$this->Customer_model->getId($orders->OUserId);
                    $orders->CustomerFirstName = $getuser->FirstName;
                    $orders->CustomerLastName = $getuser->LastName;
                    $orders->CustomerAddress = $getuser->Address;
                    $orders->CustomerLandmark = $getuser->Landmark;
                    $orders->CustomerCountryName = $getuser->CName;

                    $tmporders[] = $orders;

                }


            print json_encode(array('success'=>1, 'msg'=>'Record Found Successfully','data'=>$tmporders));
        }else{
             print json_encode(array('success'=>0, 'msg'=>'Record Not Found'));
           
        }



    }

    function getdriverorders(){
        $post=json_decode( file_get_contents('php://input') );
        $DriverId      = $post->DriverId;
        $Status = $post->Status; // '=pending, assign,process,delivered,' 

        $getorders=$this->Order_Detail_model->get_all_orders_by_driver($DriverId,$Status);

        if($getorders){
                $tmporders = [];

                foreach($getorders as $orders){

                    $getmanu=$this->Manufacture_model->getId($orders->OdManuId);
                    $orders->ManufactureCountryName= $getmanu->CName;
                    $orders->ManufactureStateName= $getmanu->SName;
                    $orders->ManufactureDistrictName= $getmanu->DName;
                    $orders->ManufactureCityName= $getmanu->CityName;

                    $getuser=$this->Customer_model->getId($orders->OUserId);
                    $orders->CustomerFirstName = $getuser->FirstName;
                    $orders->CustomerLastName = $getuser->LastName;
                    $orders->CustomerAddress = $getuser->Address;
                    $orders->CustomerLandmark = $getuser->Landmark;
                    $orders->CustomerCountryName = $getuser->CName;
                    $orders->CustomerStateName = $getuser->SName;
                    $orders->CustomerDistrictName = $getuser->DName;
                    $orders->CustomerCityName = $getuser->CityName;
                    $orders->CustomerMobileNumber = $getuser->MobileNumber;
                    $tmporders[] = $orders;

                }


            print json_encode(array('success'=>1, 'msg'=>'Record Found Successfully','data'=>$tmporders));
        }else{
             print json_encode(array('success'=>0, 'msg'=>'Record Not Found'));
           
        }



    }


    function assignorder(){
        $post=json_decode( file_get_contents('php://input') );
        $OdId      = $post->OdId;
        $VehicleId      = $post->VehicleId;
        $DriverId      = $post->DriverId;
        $curdate= date('Y-m-d h:i:s');
        $newdata['ProcessedAt'] = $curdate;
        $newdata['OdVehicleId']=$VehicleId;
        $newdata['OdDriverId']=$DriverId;
        $newdata['OdStatus']=3;

        $getorders=$this->Order_Detail_model->changestatus($OdId,$newdata);

        if($getorders){
            print json_encode(array('success'=>1, 'msg'=>'Record Updated Successfully','data'=>$getorders));
        }else{
             print json_encode(array('success'=>0, 'msg'=>'Record Not Found'));
           
        }



    }
    function completeorder(){
        $post=json_decode( file_get_contents('php://input') );
        $OdId      = $post->OdId;
        $curdate= date('Y-m-d h:i:s');
        $newdata['CompletedAt'] = $curdate;
        $newdata['OdStatus']=4;

        $getorders=$this->Order_Detail_model->changestatus($OdId,$newdata);

        if($getorders){
            print json_encode(array('success'=>1, 'msg'=>'Record Updated Successfully','data'=>$getorders));
        }else{
             print json_encode(array('success'=>0, 'msg'=>'Record Not Found'));
           
        }



    }
    function addordereview(){
        $post=json_decode( file_get_contents('php://input') );
        $OdId      = $post->OdId;
        $CustomerId      = $post->CustomerId;
        $ProductId      = $post->ProductId;

        $TransporterId      = $post->TransporterId;
        $TransReview      = $post->TransReview;
        $TransDescription      = $post->TransDescription;

        $ManufactureId      = $post->ManufactureId;
        $ManuReview      = $post->ManuReview;
        $ManuDescription      = $post->ManuDescription;

        $curdate= date('Y-m-d h:i:s');
        $addreview = $this->Review_model->add(array('ROdId'=>$OdId,'RProductId'=>$ProductId,'RTransporterId'=>$TransporterId,'RManufactureId'=>$ManufactureId,'TransReview'=>$TransReview,'TransDescription'=>$TransDescription,'ManuReview'=>$ManuReview,'ManuDescription'=>$ManuDescription,'CreatedAt'=>$curdate));


        $getTotal = $this->Review_model->getTotalReview($ProductId);        
        $getSumbTotal = $this->Review_model->getSumOfReview($ProductId);        

        if($getTotal !=0){
            $rate_times = $getTotal;
            $sum_rates = $getSumbTotal->Review;
            $rate_value = $sum_rates/$rate_times;
            $rate_bg = (($rate_value)/5)*100;

        }else{
            $rate_times = 0;
            $rate_value = 0;
            $rate_bg = 0;

        }
        $ReviewAvg=round($rate_value); 

            $this->db->where('ProductId', $ProductId);
            $this->db->set('PTotalReview', 'PTotalReview+1', FALSE);
            $this->db->set('PReviewAvg', $ReviewAvg, FALSE);
            $this->db->update('product');

        $updateOrderDetail = $this->Order_Detail_model->update($OdId,array('IsReview'=>1));


            print json_encode(array('success'=>1, 'msg'=>'Review Updated Successfully'));


            // $query = mysqli_query($mysqli,"select * from tbl_rating where post_id  = '$post_id' ");
               
            // while($data = mysqli_fetch_assoc($query)){
            //         $rate_db[] = $data;
            //         $sum_rates[] = $data['rate'];
               
            //     }

            //     if(@count($rate_db)){
            //         $rate_times = count($rate_db);
            //         $sum_rates = array_sum($sum_rates);
            //         $rate_value = $sum_rates/$rate_times;
            //         $rate_bg = (($rate_value)/5)*100;
            //     }else{
            //         $rate_times = 0;
            //         $rate_value = 0;
            //         $rate_bg = 0;
            //     }

        //     $rate_avg=round($rate_value); 

        //     $sql="update tbl_mp3 set total_rate=total_rate + 1,rate_avg='$rate_avg' where id='".$post_id."'";

        //     mysqli_query($mysqli,$sql);




        // $getorders=$this->Order_Detail_model->changestatus($OdId,$newdata);

        // if($getorders){
        //     print json_encode(array('success'=>1, 'msg'=>'Record Updated Successfully','data'=>$getorders));
        // }else{
        //      print json_encode(array('success'=>0, 'msg'=>'Record Not Found'));
           
        // }



    }

    function checkmobilenumber(){
        $post=json_decode( file_get_contents('php://input') );
        $MobileNumber      = $post->MobileNumber; 
        $checkMobileNumber=$this->Users_model->checkMobileNumber($MobileNumber);

        if($checkMobileNumber){
            print json_encode(array('success'=>1, 'msg'=>'Record Found Successfully','data'=>$checkMobileNumber));

        }else{

            print json_encode(array('success'=>0, 'msg'=>'Record Not Found'));
        }



    }

    function forgotpassword(){
        $post=json_decode( file_get_contents('php://input') );
        $UserId      = $post->UserId;
        $Password      = $post->Password;
        $newdata['Review'] = $curdate;

        $getuser=$this->Users_model->update($UserId,array('Password'=>md5($Password)));

        if($getuser){
            print json_encode(array('success'=>1, 'msg'=>'Record Updated Successfully','data'=>$getuser));
        }else{
             print json_encode(array('success'=>0, 'msg'=>'Record Not Found'));
           
        }



    }

    function changepassword(){
        $post=json_decode( file_get_contents('php://input') );
        $UserId      = $post->UserId;
        $CurrentPassword      = $post->CurrentPassword;
        $NewPassword      = $post->NewPassword;
            $finaldata=$this->Users_model->getId($UserId);
           if($finaldata){
                   if($finaldata->Password==md5($CurrentPassword)){
                        $getuser=$this->Users_model->update($UserId,array('Password'=>md5($NewPassword)));
                        print json_encode(array('success'=>1, 'msg'=>'Record Updated Successfully','data'=>$getuser));

                   }else{

                         print json_encode(array('success'=>2, 'msg'=>'Current Password Not Match'));
                   }
            }else{
                 print json_encode(array('success'=>0, 'msg'=>'User Not Found'));
            }



    }



    function updateorderlocation(){
        $post=json_decode( file_get_contents('php://input') );
        $OdId      = $post->OdId;
        $Latitude      = $post->Latitude;
        $Longitude      = $post->Longitude;
        $curdate= date('Y-m-d h:i:s');

        $addlocation=$this->Order_Locations_model->add(array('LOrderDetailId'=>$OdId,'Latitude'=>$Latitude,'Longitude'=>$Longitude,'CreatedAt'=>$curdate,'UpdatedAt'=>$curdate));

        if($addlocation){
            print json_encode(array('success'=>1, 'msg'=>'Record Updated Successfully','data'=>$addlocation));
        }else{
             print json_encode(array('success'=>0, 'msg'=>'Record Not Found'));
           
        }



    }

    function trackorder(){
        $post=json_decode( file_get_contents('php://input') );
        $OdId      = $post->OdId;
        $curdate= date('Y-m-d h:i:s');

        $getlocation=$this->Order_Locations_model->getorderlocation($OdId);

        if($getlocation){
            print json_encode(array('success'=>1, 'msg'=>'Record Found Successfully','data'=>$getlocation));
        }else{
             print json_encode(array('success'=>0, 'msg'=>'Record Not Found'));
           
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
//      $this->load->view('home_view');
    }

    
}

?>