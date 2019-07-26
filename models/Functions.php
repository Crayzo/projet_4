<?php
namespace Models;

class Functions
{
    public static function check($var)
    {
        $var = trim($var);
        $var = stripcslashes($var);
        $var = htmlspecialchars($var);
        return $var;
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

    public static function autoload()
    {
        spl_autoload_register(function($class) 
        {
            include str_replace('\\', DIRECTORY_SEPARATOR, lcfirst($class)) . '.php';
        });
    }
}