<?php
defined('BASEPATH') OR exit('No direct script access allowed');
   
class StripePaymentController extends CI_Controller {
    
    public function __construct() 
    {
       parent::__construct();
       $this->load->library("session");
       $this->load->helper('url');
       require_once('application/libraries/stripe-php/init.php');
    }
    
    public function index()
    {
        $this->load->view('aa-front-end/checkout_stripe');
    }

    
    
    public function handlePayment()
    {       
      // create a new stripe payment instance object
         $stripe = new \Stripe\StripeClient($this->config->item('stripe_secret'));
      //payment method create object
          $paymentMethods_create = $stripe->paymentMethods->create([
            'type' => 'card',
            'card' => [
              'number' => $this->input->post('number'),
              'exp_month' => $this->input->post('exp_month'),
              'exp_year' => $this->input->post('exp_year'),
              'cvc' =>$this->input->post('card_cvc'),
            ],
          ]); 
        // create payment
        $res_create= $stripe->paymentIntents->create(
          ['amount' => 100, 'currency' => CURRENCY, 'payment_method_types' => ['card'],'return_url'=>site_url(PAYMENT_STATUS_URL),'confirm'=>true,'payment_method' =>$paymentMethods_create]
        );    
        
              
        if($res_create->charges->data[0]['captured'] ==1  && $res_create->charges->data[0]['status'] =="succeeded")
        {
          // succcess payment
          $this->return_success($res_create->charges->data[0]['id']);  
        }
         // payment is created but status is pendind and need next action ex:opt enter form
        else if($res_create->status=="requires_action")
        {
          // check if next action key is set then open next action url 
          if(isset($res_create->next_action))
          {
            redirect($res_create->next_action->redirect_to_url->url);
          }
        }
        else {
          echo "some other error";
        }

        echo "<pre>";
        print_r($res_create); 

      die();
/*
// $paymentMethods_retrieve=$stripe->paymentMethods->retrieve(
//   'pm_1M2W3eSBevmc3n9kUvpjHsRD'
// );
       // $paymentMethods_update =$stripe->paymentMethods->update($paymentMethods_create->id);
      //  echo "<br> pppppp";
      //   print_r($paymentMethods_retrieve);
      //   // echo "<br> ggggg";
      //   // print_r($paymentMethods_update);
      //   die();

        
      
       
        $res_retrieve= $stripe->paymentIntents->retrieve(
            $res_create->id,          
          );
         
        $res_update= $stripe->paymentIntents->update(
            $res_create->id,
            ['metadata' => ['order_id' => 'pre_wosa'.time()]]
          );




        // $respaymentMethods_retrieve- $stripe->paymentMethods->retrieve($res_create->id);
        // print_r($respaymentMethods_retrieve);
        
        $res_confirm= $stripe->paymentIntents->confirm(
            $res_create->id,
            ['payment_method' =>$paymentMethods_create,'confirm'=>true],
          );
          echo "<pre>";
          print_r($res_confirm);
        
          print_r($res_confirm->next_action->use_stripe_sdk->stripe_js);
          redirect($res_confirm->next_action->use_stripe_sdk->stripe_js);
          redirect($res_confirm->next_action->redirect_to_url->url);
         // redirect('/make-stripe-payment', 'refresh');
     //print_r($res_confirm);
    // print_r($res_confirm->charges->data[0]['status']);
    //   echo $res3->charges->data['captured'].'---test';
    die();
      if($res_confirm->charges->data[0]['captured'] ==1  && $res_confirm->charges->data[0]['status'] =="succeeded")
      {
        // succcess
        echo 'success';


      }
      else {
         //not captured   

        $res_capture= $stripe->paymentIntents->capture($res_create->id);
           {
            if($res_capture->charges->data[0]['captured'] ==true  && $res_capture->charges->data[0]['status'] =="succeeded")
            {
              // succcess
              echo 'success';
      
            }
            else {
                // fail capture
            }

      }

      }
      */
        
    }
   /* payment status return url from gateway*/
    function payment_status()
    {
      $stripe = new \Stripe\StripeClient($this->config->item('stripe_secret'));
      $res_retrieve= $stripe->paymentIntents->retrieve(
        $_GET['payment_intent']      
      );

      echo "<pre>";
      print_r($res_retrieve);
      
      if($res_retrieve->charges->data[0]['status'] =='succeeded')
      {
       echo "success";

      }
      else if($res_retrieve->charges->data[0]['status'] =='fail')
      {
        // fail payment
        echo $res_retrieve->charges->data[0]['failure_message'] ;
      }
      else
       {
        echo "fail by other reason";
        }
    }

    function return_success($pid)
    {
      echo $pid;

    }
}