<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\Dto\DeleteImageS3Dto;
use App\Service\Dto\ListImagesS3Dto;
use App\Service\Dto\UploadImageS3Dto;
use App\Service\ListImagesS3Service;
use App\Service\DeleteImageS3Service;
use Hyperf\HttpServer\Contract\RequestInterface;
use App\Service\UploadImageS3Service;
use Hyperf\Filesystem\FilesystemFactory;

class UploadController extends AbstractController
{
    public function __construct(
        private UploadImageS3Service $uploadImageS3Service,
        private ListImagesS3Service $listImagesS3Service,
        private DeleteImageS3Service $deleteImageS3Service,
        private FilesystemFactory $filesystemFactory
    ) {}

    public function index()
    {
        return [
            'message' => "I m alive"
        ];
    }

    public function list() 
    {
        $listImagesS3Dto = new ListImagesS3Dto();
        $listImagesS3Dto->directory = $this->request->query('directory', 'photos');
        $data = $this->listImagesS3Service->execute($listImagesS3Dto);

        return [
            'data' => $data
        ];

    }
    public function delete() 
    {
        $file = $this->request->query('file');

        if (!$file) {
            return $this->response->json([
                'message' => 'file query params is required'
            ])->withStatus(422);
        }
        $deleteImageS3Dto = new DeleteImageS3Dto();
        $deleteImageS3Dto->file = $file;
        return $this->deleteImageS3Service->execute($deleteImageS3Dto);
    }


    public function send(
        RequestInterface $request
    ) {
        $photo = $request->file('photo');
        $uploadImageS3Dto = new UploadImageS3Dto();
        $uploadImageS3Dto->photo = $photo;

        return  $this->uploadImageS3Service->execute($uploadImageS3Dto);
    }
}
