<?php
    
    /**
     * Created by PhpStorm.
     * User: ufukozdemir
     * Date: 2019-01-04
     * Time: 10:57
     */
    
    class FtpConnection {

        /*
         * Global variables
         */
        private $login;
        public $connect;
        public $main_path = 'public_html/';

        public function __construct () {
            if ($this->is_connected() !== true) {
                die('No Internet connection');
            }
        }

        /*
         * Internet connection control
         */
        public function is_connected() {
            $url = 'www.google.com';
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            return $httpcode >= 200 && $httpcode < 300 ? true : false;
        }

        /*
         * FTP connection control
         */
        public function ftp_connect($ftp_host, $ftp_user, $ftp_pass) {
            $this->connect  = ftp_connect($ftp_host);
            $this->login    = ftp_login($this->connect, $ftp_user, $ftp_pass);

            if ((!$this->connect) || (!$this->login)) {
                die('The ftp connection could not be provided. Username or password is invalid');
            }
        }

        /*
         * FTP file upload
         */
        public function ftp_upload($local_file = null, $file = null) {
            if ($file !== null && $local_file !== null) {
                if (!ftp_put($this->connect, $this->main_path.$file, $local_file, FTP_BINARY)) {
                    die('Cannot Upload File');
                }
            } else {
                die('Enter the file name and local file path');
            }
        }

        /*
         * FTP file delete
         */
        public function ftp_delete($file = null) {
            if ($file !== null) {
                $path = $this->main_path.$file;
                if (!ftp_delete($this->connect, $path)) {
                    die('Failed to delete file');
                }
            } else {
                die('Enter the file name');
            }
        }

        /*
         * Create a new folder
         */
        public function ftp_mkdir($folder = null) {
            if ($folder !== null) {
                $path = $this->main_path.$folder;
                if (!ftp_mkdir($this->connect, $path)) {
                    die('Could not create new folder');
                }
            } else {
                die('Enter the folder name');
            }
        }

        /*
         * FTP folder delete
         */
        public function ftp_rmdir($folder = null) {
            if ($folder !== null) {
                $path = $this->main_path.$folder;
                if (!ftp_rmdir($this->connect, $path)) {
                    die('Failed to delete folder');
                }
            } else {
                die('Enter the folder name');
            }
        }

        /*
         * FTP file name change
         */
        public function ftp_rename($old_file = null, $new_file = null) {
            if ($old_file !== null && $new_file !== null) {
                if (!ftp_rename($this->connect, $this->main_path.$old_file, $this->main_path.$new_file)) {
                    die('Cannot Change File Name');
                }
            } else {
                die('Enter the old file name and new file name');
            }
        }

        /*
         * FTP folder or file permission change
         */
        public function ftp_chmod($folder = null, $permission = null) {
            if ($folder !== null && $permission !== null) {
                $path = $this->main_path.$folder;
                if (!ftp_chmod($this->connect, $permission, $path)) {
                    die('Failed to write folder permission');
                }
            } else {
                die('Enter the folder name');
            }
        }

    }

    /*
     * Starting a new class
     */
    $ftp = new ftpconnection();

    /*
     * FTP connection information
     */
    $ftp->ftp_connect('127.0.0.1', 'Your UserName', 'Your Password');

    /*
     * Create a new folder in FTP
     */
    $ftp->ftp_mkdir('folder_name');

    /*
     * FTP uploading a new file
     */
    $ftp->ftp_upload('file:///Users/username/Desktop/file_name.txt', 'folder_name/file_name.txt');

    /*
     * FTP a file delete
     */
    $ftp->ftp_delete('folder_name/file_name.txt');

    /*
     * FTP a folder delete
     */
    $ftp->ftp_rmdir('folder_name');

    /*
     * FTP a file name change
     */
    $ftp->ftp_rename('folder_name/old_name.txt', 'folder_name/new_name.txt');

    /*
     * FTP a folder or file permission change
     */
    $ftp->ftp_chmod('folder_name/file_name.txt', 0777);
