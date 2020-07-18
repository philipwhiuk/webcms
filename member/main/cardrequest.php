<?php
class Member_Main_CardRequest {
  public __construct($member) {
    $this->member = $member;
    $this->person = Person::getById($member->person);
  }

  public render($theme) {
    $template = $theme->getTemplate("Member_Main_CardRequest");
    return new $template(array(
      'person' => $this->person,
      'member' => $this->member
    ))
  }
}
