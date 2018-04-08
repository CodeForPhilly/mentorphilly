<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\OutgoingMessage; 

use Twilio; 

use Illuminate\Notifications\Messages\SlackMessage;

use App\Phone;
use App\SMSRecipient; 


class OutgoingMessageController extends Controller
{
   

   

public function test(){

        echo 'testing'; 
        $testNumber = config('twilio.twilio.connections.twilio.test');
        $message = "Hi There from MentorPhilly"; 
        Twilio::message($testNumber, $message);
        echo 'Message sent';
    }


      /**
     * Send Slack generated message to recipient via Twilio
     *
     * @param  Request object
     */

    public function sendFromSlack(Request $request)
    {

        $outgoingMsg = new OutgoingMessage; 

        $outgoingMsg->command = $request->input('command');
        $outgoingMsg->text = $request->input('text');
        $outgoingMsg->token = $request->input('token'); 
        $outgoingMsg->user = $request->input('user_name'); 
        $outgoingMsg->channel_id = $request->input('channel_id');
        $outgoingMsg->channel_name = $request->input('channel_name');

        $auth_token = config('services.slack.auth_token');

        if($outgoingMsg->token != $auth_token){ 
            
            $msg = "The token for the slash command doesn't match.";
            die($msg);
            echo $msg;
        }

        else {

            
            $outgoingMsg->channel_name = $this->getChannelName($outgoingMsg->channel_id); 

            


            $outgoingMsg = $this->parseSlackMessage($outgoingMsg); 
            Twilio::message($outgoingMsg->to, $outgoingMsg->message);
            $outgoingMsg->create(['smsname' => $outgoingMsg->user, 'channel' => $outgoingMsg->channel_name, 'number' => $outgoingMsg->to, 'message' => $outgoingMsg->message]); 

           

            
        }



        $arr = []; 

        if (!empty($outgoingMsg->to) && !empty($outgoingMsg->message)){

            $outgoingMsg->title = 'to: '.$outgoingMsg->to;
            $outgoingMsg->message = 'Message: '.$outgoingMsg->message;

          // creating slack json attachments array
            $arr = array(
                            "title" => $outgoingMsg->to,
                            "text" => $outgoingMsg->message, 
                            "footer" => "sent from channel: " . $outgoingMsg->channel_name
                        );
        }


        return response()->json([
            'response_type' => 'in_channel',
            'text' => 'Outgoing Text Message',
            'attachments' => array($arr)
        ]);        

    }



     public function getChannelName($id){


          $client = new Client(); 

          $token = getenv('SLACK_OAUTH'); 

          try{

            $response = $client->get('https://slack.com/api/groups.info', 
                [
                    'token' => $token, 
                    'channel' => $id
                ]

            );


            $status = $response->getStatusCode();
        $body = json_decode($response->getBody());
        if ($body->ok) {
            $name = $body->group->name; 
        }

        else{

            $name = 'fail'; 
        }

          }

          catch(\Exception $e){

            $name = $e->getMessage(); 

          }

          return $name;


    }



    public function parseSlackMessage(OutgoingMessage $outgoingMsg){

              $outgoingMsg->to = config('services.twilio_setup.test_no'); 
         

            if (strpos($outgoingMsg->text, '+')){
                list($outgoingMsg->message, $outgoingMsg->to) = explode("+", $outgoingMsg->text);

                $outgoingMsg->to = '+'.$outgoingMsg->to; 
                 
                

            

            }

            elseif (strpos($outgoingMsg->text, '~')){

                list($outgoingMsg->message, $outgoingMsg->to) = explode("~", $outgoingMsg->text);

                $case = 1; 
                $outgoingMsg->to = $this->lookUpPhone($outgoingMsg->to, $outgoingMsg->channel_name, $case);
        
               

    

            }



            else{

               $outgoingMsg->message = $outgoingMsg->text; 

               $case = 2; 
               
               $outgoingMsg->to = $this->lookUpPhone($outgoingMsg->to, $outgoingMsg->channel_name, $case);


            } 



        return $outgoingMsg; 

    }





public function lookUpPhone($to, $channel, $case){


    $number; 

               $person = new SMSRecipient(); 
               $phone = new Phone(); 
               $personid; 

             switch($case) {
                case 1:
                     //CASE 1 find the person with a channel name equivalent to what's typed after the tilda
                           $person = SMSRecipient::where('smsname', 'LIKE', $to)->first();
                           if($person !== null)
                            $personid = $person->id; 

                    break;
                case 2:
                     //CASE 2
                           
                           $channel = "#".$channel; 
                           $person = SMSRecipient::where('channel', 'LIKE', $channel)->get();
                           foreach ($person as $p) {
                            if(strcasecmp( $p->channel, $channel) == 0)
                               $personid = $p->id; 
                           }
                    break;
             
            }


        if(!empty($personid)){
    
               $phone = Phone::where('s_m_s_recipient_id', '=', $personid)->first();

               if($phone != null)
                $number = $phone->number; 
        }

        else 
                    $number = env('TWILIO_TEST_NO'); 

    return $number; 
}






    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


}
