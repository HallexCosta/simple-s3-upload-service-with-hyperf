<?php

namespace App\Service;

use App\Service\AbstractService;
use App\Service\Dto\AbstractDto;
use App\Service\Dto\UploadImageS3Dto;
use Hyperf\HttpMessage\Upload\UploadedFile;
// use Hyperf\Support\Filesystem\Filesystem;
use League\Flysystem\Filesystem;

use Exception;

final class UploadImageS3Service extends AbstractService 
{
    private array $allowedExtensions = [
        'jpg',
        'png',
        'jpeg'
    ];

    public function __construct(private Filesystem $s3) {}

    // #[\Override]
    public function execute(AbstractDto $dto): array
    {
        if (!($dto instanceof UploadImageS3Dto)) {
            throw new \InvalidArgumentException('Expected instance of UploadImageS3Dto');
        }

        $photo = $dto->photo;

        list($newFilename, $ext) = $this->generateUniqueFilename($photo);

        if (!$this->isValidExtension($ext)) {
            throw new Exception("The extension {$ext} cannot is valid, try with another extension [" . join(', ', $this->allowedExtensions) . "]");
        }

        list($s3Dir) = $this->up($newFilename, $photo->getRealPath());

        return [
            's3_dir' => $s3Dir,
            'real_filepath' => $photo->getRealPath(),
            'client_filename' => $photo->getClientFilename()
        ];
    }

    private function isValidExtension(string $ext) {
        if (in_array($ext, $this->allowedExtensions)) {
            return true;
        }
        return false;
    }

    private function generateUniqueFilename(UploadedFile $photo) {
        $timestamp = strtotime(gmdate('Y-m-d H:i:s'));
        $filename = "{$timestamp}-{$photo->getClientFilename()}";
        return [$filename, $photo->getExtension()];
    }

    private function up(string $newFilename, string $temporaryImagePath) {
        $fp = fopen($temporaryImagePath, 'r+');
        $location = 'photos/' . $newFilename;
        $this->s3->writeStream(
            $location,
            $fp
        );
        fclose($fp);
        return [$location];
    }
}