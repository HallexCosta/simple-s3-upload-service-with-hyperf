<?php

namespace App\Service;

use App\Service\AbstractService;
use App\Service\Dto\AbstractDto;
use App\Service\Dto\DeleteImageS3Dto;
use League\Flysystem\Filesystem;

use InvalidArgumentException;
use App\Exception\NotFoundImageInBucketS3;

final class DeleteImageS3Service extends AbstractService {
    public function __construct(private readonly Filesystem $s3) {}
    public function execute(AbstractDto $dto): array {
        if (!($dto instanceof DeleteImageS3Dto)) {
            throw new InvalidArgumentException('Expected instance of DeleteImageS3Dto');
        }
        return $this->delete($dto);
    }

    private function delete(DeleteImageS3Dto $deleteImageS3Dto) {
        $exists = $this->verifyFileExists($deleteImageS3Dto);
        if (!$exists) {
            throw new NotFoundImageInBucketS3([
                'deleted' => $exists,
                'message' => 'file not found, try another file',
                'delete_image_dto' => $deleteImageS3Dto
            ], 400);
        }

        $this->s3->delete($deleteImageS3Dto->file);
        return [
            'deleted' => true,
            'message' => 'successfully to delete file ' . $deleteImageS3Dto->file,
        ];
    }

    private function verifyFileExists(DeleteImageS3Dto $deleteImageS3Dto) {
        $exists = $this->s3->has($deleteImageS3Dto->file);
        return $exists;
    }
}