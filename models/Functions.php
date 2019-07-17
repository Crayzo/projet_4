<?php
namespace Project\Models;

class Functions
{
    public static function check($data)
    {
        $data = trim($data);
        $data = stripcslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public static function setFlash($message, $type = 'danger')
    {
        $_SESSION['flash'] = [
            'message' => $message,
            'type'    => $type
        ];
    }

    public static function flash()
    {
        if(isset($_SESSION['flash']))
        {
            ?>
            <div id="alert" class="alert alert-<?= $_SESSION['flash']['type']; ?>">
                <button type="button" class="close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <?= $_SESSION['flash']['message']; ?>
            </div>
            <?php
            unset($_SESSION['flash']);
        }
    }
}