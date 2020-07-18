<?php
class Member_Main_Self_View {
  function __construct($user) {
    $this->transactions = Payment_Transaction::getByUser($user->id);
    $this->emails = Email_Email::getByUserByDate($user->id);
    if (Member_Member::userHasMember($user->id)) {
      $member = Member_Member::getByUser($user->id);
      $this->membership_status = Content_Formatter::format(
        Member_Config::getByKey('membership_'.$member->getState()->text),
        array(
          array('key' => '%EXPIRY_DATE%', 'type' => 'date', 'value' => $member_state->expiryDate)
        )
      );
    } else {
      $this->membership_status = Content_Formatter::format(
        Member_Config::getByKey('membership_not_joined')->text
      );
    }

    $lastLoginData = User_LoginAttempt::getPreviousForUser($user->id);
    if ($lastLoginData) {
      $this->last_login_status = Content_Formatter::format(
        Member_Config::getByKey('last_login_details')->text,
        array(
          array('key' => '%DATE%', 'type' => 'date', 'value' => $lastLoginData->date),
          array('key' => '%TIME%', 'type' => 'time', 'value' => $lastLoginData->date)
        )
      );
    } else {
      $this->last_login_status = Content_Formatter::format(
        Member_Config::getByKey('last_login_never')->text
      );
    }
  }

  function render($theme, $page) {
    $template = $theme->getTemplate("Member_Main_Self_View");
    return new $template(
        array(
          'membership_status' => $this->membership_status,
          'last_login' => $this->last_login_status,
          'transactions' => $this->transactions,
          'emails' => $this->emails,
        )
    );
  }
}
