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
    

    $html = "";

                       foreach ($sendMsgs as $sendMsg) {
                        
                        $ToUserName = $userRepository->getUsernameFromId($sendMsg->getUserId());

                                $html .= 
                                 '<div id="msg'.$sendMsg->getMsgId().'" class="msg">'.
                                '<table>'.
                                '<td><strong>'.$ToUserName.'</strong></td>'.
                                '<td><strong>'.$sendMsg->getSubject().'</strong></td>'.
                                '<td><strong>'.$sendMsg->getDate().'</strong></td>'.
                                '<td><strong>'.time_passed($sendMsg->getTime()).'</strong></td>'.
                                '<td><strong><a href="?SentMsg&id='.$sendMsg->getMsgId().'">Message</a></strong></td>'.
                                '</table>'.
                                '</div>';
                        }

    $htmlView->EchoHTML($html);
}


