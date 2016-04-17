<?php
namespace Steampunked;

/**
 * Manage users in our system.
 */
class Users extends Table {
    const BASE_PUSH_KEY = 'wie-ste-reu-';   ///< First part of any push key used to uniquely identify our keys

    /**
     * Constructor
     * @param $site The Site object
     */
    public function __construct(Site $site) {
        parent::__construct($site, "User");
    }

    /**
     * Test for a valid login.
     * @param $email User email
     * @param $password Password credential
     * @returns User object if successful, null otherwise.
     */
    public function login($email, $password) {

        $sql =<<<SQL
SELECT * from $this->tableName
where email=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($email));
        if($statement->rowCount() === 0) {
            return null;
        }

        $row = $statement->fetch(\PDO::FETCH_ASSOC);

        // Get the encrypted password and salt from the record
        $hash = $row['password'];
        $salt = $row['salt'];

        // Ensure it is correct
        if($hash !== hash("sha256", $password . $salt)) {
            return null;
        }

        return new User($row);

    }

    /**
     * Get a user based on the id
     * @param $id ID of the user
     * @returns User object if successful, null otherwise.
     */
    public function get($id) {
        $sql = <<<SQL
SELECT * FROM $this->tableName
WHERE id=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($id));
        if ($statement->rowCount() === 0) {
            return null;
        }

        return new User($statement->fetch(\PDO::FETCH_ASSOC));
    }

    /**
     * Modify a user record based on the contents of a User object
     * @param User $user User object for object with modified data
     * @return true if successful, false if failed or user does not exist
     */
    public function update(User $user) {

        $sql =<<<SQL
UPDATE $this->tableName
SET email=?, name=?
where id=?
SQL;

        try {
            $statement = $this->pdo()->prepare($sql);
            $statement->execute(array($user->getEmail(), $user->getName(), $user->getId()));
        } catch(\PDOException $e) {
            // do something when the exception occurs...
            return false;
            //die("There's an error in the update!");

        }
        return true;
    }

    /**
     * Get all users in the system
     * @return mixed Returns array containing all users in the system
     */
    public function getUsers() {

        $sql = <<<SQL
SELECT *
FROM $this->tableName
SQL;

        $statement = $this->pdo()->prepare($sql);
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
    * Determine if a user exists in the system.
    * @param $email An email address.
    * @returns true if $email is an existing email address
    */
    public function exists($email) {

        $sql =<<<SQL
SELECT *
FROM $this->tableName
WHERE email= ?
SQL;

        $statement = $this->pdo()->prepare($sql);
        $statement->execute(array($email));

        $statement->fetchAll(\PDO::FETCH_ASSOC);
        if($statement->rowCount()===0) {return false;}
        return true;
    }

    /**
     * Create a new user.
     * @param User $user The new user data
     * @param Email $mailer An Email object to use
     * @return null on success or error message if failure
     */
    public function add(User $user, Email $mailer) {
        // Ensure we have no duplicate email address
        if($this->exists($user->getEmail())) {
            return "Email address already exists.";
        }

        // Add a record to the user table
        $sql = <<<SQL
INSERT INTO $this->tableName(email, name, pushKey)
values(?, ?, ?)
SQL;

        $statement = $this->pdo()->prepare($sql);
        $statement->execute(array(
            $user->getEmail(), $user->getName(), $user->getpushKey()));
        $id = $this->pdo()->lastInsertId();

        // Create a validator and add to the validator table
        $validators = new Validators($this->site);
        $validator = $validators->newValidator($id);

        // Send email with the validator in it
        $link = "http://webdev.cse.msu.edu"  . $this->site->getRoot() .
            '/password-validate.php?v=' . $validator;

        $from = $this->site->getEmail();
        $name = $user->getName();

        $subject = "Confirm your email";
        $message = <<<MSG
<html>
<p>Greetings, $name,</p>

<p>Welcome to Steampunked. In order to complete your registration,
please verify your email address by visiting the following link:</p>

<p><a href="$link">$link</a></p>
</html>
MSG;
        $headers = "MIME-Version: 1.0\r\nContent-type: text/html; charset=iso=8859-1\r\nFrom: $from\r\n";
        $mailer->mail($user->getEmail(), $subject, $message, $headers);

        return 'success';

    }

    public function createGuestAccount() {
        // Ensure we have no duplicate email address
        // Generate a fake email. (just a random string)
        $guestEmail = $this->randomKey();
        $guestPushKey = self::BASE_PUSH_KEY . $this->randomKey();

        // Keep trying to make a new email that is unique
        while($this->exists($guestEmail)) {
            $guestEmail = $this->randomKey();
        }

        // Add a record to the user table
        $sql = <<<SQL
INSERT INTO $this->tableName(email, name, pushKey)
values(?, ?, ?)
SQL;

        $statement = $this->pdo()->prepare($sql);
        $statement->execute(array(
            $guestEmail, 'guest', $guestPushKey));
        $id = $this->pdo()->lastInsertId();

        return $this->get($id);
    }

    /**
     * Add a validator record to the validator table and send a password reset email
     * @param $email The email to add a password reset record for
     * @param Email $mailer The email to be sent
     * @return null
     */
    public function resetPassword($email, Email $mailer) {

        $sql = <<< __SQL__
    select * from $this->tableName where email=?
__SQL__;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($email));
        if($statement->rowCount() === 0) {
            return null;
        }

        $user = $this->get($statement->fetch(\PDO::FETCH_ASSOC)['id']);
        $id = $user->getId();

        // Create a validator and add to the validator table
        $validators = new Validators($this->site);
        $validator = $validators->newValidator($id);

        // Send email with the validator in it
        $link = "http://webdev.cse.msu.edu"  . $this->site->getRoot() .
            '/password-validate.php?v=' . $validator;

        $from = $this->site->getEmail();
        $name = $user->getName();

        $subject = "Password reset request";
        $message = <<<MSG
<html>
<p>Greetings, $name,</p>

<p>Please reset your password with the following link:</p>

<p><a href="$link">$link</a></p>
</html>
MSG;
        $headers = "MIME-Version: 1.0\r\nContent-type: text/html; charset=iso=8859-1\r\nFrom: $from\r\n";
        $mailer->mail($user->getEmail(), $subject, $message, $headers);
    }

    /**
     * Set the password for a user
     * @param $userid The ID for the user
     * @param $password New password to set
     */
    public function setPassword($userid, $password) {
        // Create a new push key for the user
        $this->setPushKey($userid);

        $sql =<<<SQL
UPDATE $this->tableName
SET password=?, salt=?
where id=?
SQL;
        $salt = $this->randomSalt(16);
        $hash = hash("sha256", $password.$salt);
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        try {

            if($statement->execute(array($hash, $salt, $userid)) === false) {
                return null;
            };

        } catch(\PDOException $e) {
            return null;
        }

        return $pdo->lastInsertId();
    }

    /**
     * Generate a random salt string of characters for password salting
     * @param $len Length to generate, default is 16
     * @returns Salt string
     */
    public static function randomSalt($len = 16) {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789`~!@#$%^&*()-=_+';
        $l = strlen($chars) - 1;
        $str = '';
        for ($i = 0; $i < $len; ++$i) {
            $str .= $chars[rand(0, $l)];
        }
        return $str;
    }

    /**
     * Set the push key for a user
     * @param $userid
     * @return null
     */
    public function setPushKey($userid) {
        $sql =<<<SQL
UPDATE $this->tableName
SET pushKey=?
where id=?
SQL;
        $key = self::BASE_PUSH_KEY . $this->randomKey(16);
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        try {
            if($statement->execute(array($key, $userid)) === false) {
                return null;
            };
        } catch(\PDOException $e) {
            return null;
        }

        return $key;
    }

    public function getPushKey($userId) {
        $sql =<<<SQL
select pushKey from  $this->tableName
where id=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($userId));

        $result = $statement->fetch(\PDO::FETCH_ASSOC);

        return $result['pushKey'];
    }

    /**
     * Generate a random string
     * @param int $len The length the string should be
     * @return string The randomly generated string
     */
    public static function randomKey($len = 16) {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789`~!@#$%^&*()-=_+';
        $l = strlen($chars) - 1;
        $str = '';
        for ($i = 0; $i < $len; ++$i) {
            $str .= $chars[rand(0, $l)];
        }
        return $str;
    }
}