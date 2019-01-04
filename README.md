# Basic FTP Connect Class with Php
##### Starting a new class and FTP connection information
```php
$ftp = new ftpconnection();
$ftp->ftp_connect('127.0.0.1', 'Your UserName', 'Your Password');
```

##### Create a new folder in FTP
```php
$ftp->ftp_mkdir('folder_name');
```

##### FTP uploading a new file
```php
$ftp->ftp_upload('file:///Users/username/Desktop/file_name.txt', 'folder_name/file_name.txt');
```

##### FTP a file delete
```php
$ftp->ftp_delete('folder_name/file_name.txt');
```

##### FTP a folder delete
```php
$ftp->ftp_rmdir('folder_name');
```

##### FTP a file name change
```php
$ftp->ftp_rename('folder_name/old_name.txt', 'folder_name/new_name.txt');
```

##### FTP a folder or file permission change
```php
$ftp->ftp_chmod('folder_name/file_name.txt', 0777);
```
