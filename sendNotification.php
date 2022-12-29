<?php
include_once 'config/database.php';
include_once 'objects/birthdayPromo.php';
include_once 'objects/mailer.php';
include_once 'objects/user.php';

/** SET UP DATABASE CONNECTION **/
$database = new Database();
$conn = $database->getConnection();

/** SET UP SMTP MAILING **/
$mailer = new Mailer();

/** GET A LIST OF ALL USERS WHO HAVE A BIRTHDAY TODAY **/
$date_today = date("Y-m-d");
$users = new User($conn);
$result = $users->getVerifiedUsersByBirthdayDate($date_today)->fetchAll();

/** LOOP OVER THE LIST OF VERIFIED USERS WHOSE BIRTHDAY IS TODAY **/
for ($i = 0; $i < count($result); $i++) { 
   $array = $result[$i];
   // echo $array["customer_id"] . "\n";
   // echo $array["name"] . "\n";
   // echo $array["birthday_date"] . "\n";
   // echo $array["age"] . "\n";
   // echo $array["email"] . "\n";
   // echo $array["phone_number"] . "\n";
   // echo $array["verified"] . "\n";

   /** GENERATE PROMO UNIQUE TO THE USER THAT CAN ONLY BE USED TODAY **/
   $promo = new BirthdayPromo($conn);
   $promo->customer_id = $array["customer_id"];

   /** GENERATE HAPPY BIRTHDAY EMAIL WITH THE APPROPRIATE PROMO ATTATCHED **/
   $mailer->recipient_email = $array["email"];
   $mailer->recipient_name = $array["name"];
   $mailer->subject = 'Happy Birthday ' . $array["name"] . '! Here`s a small gift from us to you!';
   /** EMAIL BODY AND CONTENTS SHOULD BE CHANGED TO A MORE PROFESSIONALLY DESIGNED HTML IN PRODUCTION **/
   $mailer->body = '
   <body style="background-color:grey">
      <table align="center" border="0" cellpadding="0" cellspacing="0"
            width="550" bgcolor="white" style="border:2px solid black">
         <tbody>
            <tr>
               <td align="center">
                  <table align="center" border="0" cellpadding="0"
                     cellspacing="0" class="col-550" width="550">
                     <tbody>
                        <tr>
                           <td align="center"
                              style="background-color:blue;
                              height: 50px;">
                              <a href="#" style="text-decoration: none;">
                                 <p style="color:white;font-weight:bold;">
                                    Happy Birthday ' . $array["name"] . '! Use promo code ' . $promo->promo_code . ' on our website for 50% on your first purchase today!
                                 </p>
                              </a>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </td>
            </tr>
         </tbody>
      </table>
   </body>
   ';
   
   //'Happy Birthday ' . $array["name"] . '! Use promo code ' . $promo->promo_code . ' on our website for 50% on your first purchase today!';

   /** STORE PROMO IN DATABASE **/
   /** IF SUCCESSFUL SEND THE EMAIL TO THE USER **/
   if($promo->createPromo()){
      $mailer->getMailer();
      $mailer->send();
   }
}
?>