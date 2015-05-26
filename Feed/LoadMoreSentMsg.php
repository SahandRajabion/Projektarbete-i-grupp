<?php

require_once('helper/time.php');
require_once('Model/Dao/MessagesRepository.php');
require_once('Model/Dao/UserRepository.php');
require_once('View/HTMLView.php');  

$messagesRepository = new MessagesRepository();
$userRepository = new UserRepository();
$htmlView = new HTMLView();

if (isset($_POST["last_id"]) && strlen($_POST['last_id']) > 0 && is_numeric($_POST['last_id'])
    && isset($_POST["user_id"]) && strlen($_POST['user_id']) > 0 && is_numeric($_POST['user_id']))
{
    // Hämtar ut sista id som har postats från Ajax anropet
    $last_id = $_POST['last_id'];
    $user_id = $_POST['user_id'];

    $sendMsgs = $messagesRepository->GetMoreSentMessages($last_id, $user_id);
    

    $html = '';        

        $html .= '<link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/customCss.css" rel="stylesheet">
        <script type="text/javascript" src="jquery.min.js"></script>
        <script type="text/javascript" src="script.js"></script>

        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>';

                       foreach ($sendMsgs as $sendMsg) {
                        
                        $ToUserName = $userRepository->getUsernameFromId($sendMsg->getUserId());
                        $sentMsgImg = '<img src="View/DefaultImages/send.png" alt="Sent message" title="Sent Message" />';
                                $html .= 
                                 '<div id="msg'.$sendMsg->getMsgId().'" class="msg">'.
                                '<div class="panel panel-info">
                                 <div class="panel-heading">
                               <h3 class="panel-title"><a href="?send&id='.$sendMsg->getMsgId().'">'.$sentMsgImg.'</a></h3>
                              </div>
                              <div class="panel-body">
                                <div class="row">
                            <div class=" col-md-9 col-lg-9 "> 
                              <table class="table table-user-information">
                                <tbody><tr><td><strong>To: </strong> '.$ToUserName.'</td>'.
                                '<td><strong>Subject: </strong> '.$sendMsg->getSubject().'</td>'.
                                '<td><strong>Date: </strong> '.$sendMsg->getDate().'</td>'.
                                '<td><strong>Time: </strong> '.time_passed($sendMsg->getTime()).'</td>'.
                                '</tr>
                                </tbody>
                              </table>
                            </div>
                            </div>
                          </div>
                        </div>'.
                    '</div>';
                        }



                    

    $htmlView->EchoHTML($html);
}


