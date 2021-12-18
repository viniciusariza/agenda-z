<?php

class UtilDAO {

    private static function IniciarSessao() {
        if (!isset($_SESSION)) {
            session_start();
        }
    }

    public static function CriarSessao($codUser) {
        self::IniciarSessao();
        $_SESSION['iduser'] = $codUser;
    }

    public static function VerLogado() {
        self::IniciarSessao();
        if (!isset($_SESSION['iduser'])) {
            header('location:login.php');
        }
    }

    public static function CodigoLogado() {
        self::IniciarSessao();
        return $_SESSION['iduser'];
    }

    public static function Deslogar() {
        self::IniciarSessao();
        unset($_SESSION['iduser']);
        header('location:login.php');
    }

}