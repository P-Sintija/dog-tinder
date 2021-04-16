<?php

namespace App\Validations;

class ImageValidation
{

    public function checkFileType(array $allowedExtensions, string $fileExtensionLowercase): bool
    {
        return in_array($fileExtensionLowercase, $allowedExtensions);
    }

    public function checkUploadError(int $bool): bool
    {
        return $bool === 0;
    }

    public function checkFileSize(int $size, int $maxSize): bool
    {
        return $size <= $maxSize;
    }


    /*   public function checkFileProperties(array $id, array $table, array $file): bool
      {
       /*  $image = $_FILES['image'];
                        $fileExtension = explode('.', $image['name']);
                        $fileExtensionLowercase = strtolower(end($fileExtension));

                        $allowedExtensions = [
                            'jpg',
                            'png'
                        ];

                        if (in_array($fileExtensionLowercase, $allowedExtensions)) {
                            if ($_FILES['image']['error'] === 0) {
                                if ($_FILES['image']['error'] < 5000) {

                                    $fileName = uniqid('',true).".".$fileExtensionLowercase;
                                    $path = 'Images/'.$fileName;
                                    move_uploaded_file($_FILES['image']['tmp_name'],$path);

                                    if (!$this->repository->has((int)$vars['id'])) {
                                        $this->repository->save((int)$vars['id']);
                                        $this->repository->edit((int)$vars['id'], $_POST['upload'],$path);
                                    } else {
                                        $this->repository->edit((int)$vars['id'], $_POST['upload'],$path);
                                    }

                                } else {
                                    echo 'Invalid file size';
                                }
                            } else {
                                echo 'Upload error';
                            }
                        } else {
                            echo 'Invalid file type';
                        }

      }
  */


}