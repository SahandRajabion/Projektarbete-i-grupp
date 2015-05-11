<?php

require_once('helper/time.php');
require_once('Model/Dao/MessagesRepository.php');
require_once('View/HTMLView.php');

$messagesRepository = new MessagesRepository();
$htmlView = new HTMLView();

if (isset($_POST["last_id"]) && strlen($_POST['last_id']) > 0 && is_numeric($_POST['last_id'])
    && isset($_POST["user_id"]) && strlen($_POST['user_id']) > 0 && is_numeric($_POST['user_id']))
{
    // Hämtar ut sista id som har postats från Ajax anropet
    $last_id = $_POST['last_id'];
    $user_id = $_POST['user_id'];

    $messages = $messagesRepository->GetMoreMessages($last_id, $user_id);

    $html = "";

    foreach ($messages as $message) {
                        
                            # code...
                            if ($message->getOpen() == 0) {

                            $open = '<img src="img/not_open.png" alt="NotOpened" title="NotOpened" />';
                            }
                            else {
                                $open ='<img src="img/open.png" alt="Opened" title="Opened" />';
                            }
                        
                            $html .= 
                                '<div id="msg'.$message->getMsgId().'" class="msg">'.
                                '<table>'.
                                '<td><strong>'.$message->getFromName().'</strong></td>'.
                                '<td><strong>'.$message->getSubject().'</strong></td>'.
                                '<td><strong>'.$message->getDate().'</strong></td>'.
                                '<td><strong>'.time_passed($message->getTime()).'</strong></td>'.
                                '<td><strong><a href="?msg&id='.$message->getMsgId().'">'.$open.'</a></strong></td>'.
                                '</table>'.
                                '</div>';
                        }

    $htmlView->EchoHTML($html);
}


