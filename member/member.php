<?php
class Member_Member {
  public $id;
  public $user;
  public $person;
  public $membership_number;
  public $renewal_date;
  public $expiry_date;
  public $approval_date;
  public $join_date;
  public $notes;
  public $first_claim;

  function getState() {
    if ($this->expiry_date < time()) {
      if ($this->$approval_date == null) {
        return "unapproved";
      } elseif ($this->join_date) {
        return "not_joined";
      } else {
        return "expired";
      }
    } else {
      return "active";
    }
  }

  static function userHasMember($user) {
    $statement = DB::getConnection()->prepare("SELECT * from member WHERE user = ?");
    $statement->setFetchMode(PDO::FETCH_CLASS, "Member_Member");
    $statement->execute(array($user));
    return $statement->rowCount() > 0;
  }

  static function getByUser($user) {
    $statement = DB::getConnection()->prepare("SELECT * from member WHERE user = ?");
    $statement->setFetchMode(PDO::FETCH_CLASS, "Member_Member");
    $statement->execute(array($user));
    if ($statement->rowCount() < 1) {
      throw new Exception("MEMBER_NOT_FOUND");
    }
    return $statement->fetch(PDO::FETCH_CLASS);
  }

  static function getCount() {
    $statement = DB::getConnection()->prepare("SELECT COUNT(*) as member_count from member");
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    return (int) $result[0]['member_count'];
  }

  static function getPercentageWomen() {
    $statement = DB::getConnection()->prepare("SELECT COUNT(*) as women_count from member
      LEFT JOIN person ON member.person = person.id
      LEFT JOIN event_gender on person.gender = event_gender.id
      WHERE event_gender.name = ?");
    $statement->execute(array('Female'));
    $result = $statement->fetch(PDO::FETCH_ASSOC);

    $women_count = (float) $result[0]['women_count'];
    $total = (float) self::getCount();
    $percentage = (int) (($women_count / $total) * 100);
    return $percentage;
  }
}
