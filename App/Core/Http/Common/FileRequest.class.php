<?php

declare(strict_types=1);

class FileRequest extends SplFileInfo
{
    private const ERROR_MESSGAES = [
        UPLOAD_ERR_OK => 'There is no error, the file uploaded with success.',
        UPLOAD_ERR_INI_SIZE => 'The file "%s" exceeds the upload_max_filesize directive in php.ini.',
        UPLOAD_ERR_FORM_SIZE => 'The file "%s" exceeds the upload limit in your form.',
        UPLOAD_ERR_PARTIAL => 'The file "%s" was only partially uploaded.',
        UPLOAD_ERR_NO_FILE => 'No file was uploaded.',
        UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder.',
        UPLOAD_ERR_CANT_WRITE => 'The file "%s" could not be written on the disk',
        UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload.',
        -1 => 'The file "%s" was not upload due to an unknown error.',
    ];
    private ?string $originalName;
    private ?string $mimeType;
    private int $errorCode;
    private FilesSystemInterface $fm;

    public function __construct(?string $path = null, ?string $originalName = null, ?string $mimeType = null, int|null $errorCode = null, ?FilesSystemInterface $fm = null)
    {
        $this->originalName = $originalName;
        $this->mimeType = $mimeType ?: 'application/octet-stram';
        $this->errorCode = $errorCode ?: UPLOAD_ERR_OK;
        if ($this->errorCode === UPLOAD_ERR_OK && !is_file($path)) {
            throw new FileNotFoundException($path);
        }
        $this->fm = $fm;
        parent::__construct($path);
    }

    public function getOriginalName(): ?string
    {
        return $this->originalName;
    }

    public function setOriginalName(?string $originalName): self
    {
        $this->originalName = $originalName;

        return $this;
    }

    public function getExtension(): string
    {
        return pathinfo($this->originalName, PATHINFO_EXTENSION);
    }

    public function getMimeType(): ?string
    {
        return $this->mimeType;
    }

    public function setMimeType(?string $mimeType): self
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    public function getErrorCode(): int|null
    {
        return !$this->isValid() ? $this->errorCode : null;
    }

    public function setErrorCode(int $errorCode): self
    {
        $this->errorCode = $errorCode;

        return $this;
    }

    public function isValid() : bool
    {
        return $this->errorCode === UPLOAD_ERR_OK && is_uploaded_file($this->getPathname());
    }

    public function getErrorMessage() : ?string
    {
        if ($this->isValid()) {
            return null;
        }
        $maxFileSize = $this->errorCode === UPLOAD_ERR_INI_SIZE ? FileInfoUtils::getMaxFileSize() : 0;

        return sprintf(self::ERROR_MESSGAES[$this->getErrorCode()] ?: self::ERROR_MESSGAES[-1], $this->originalName, $maxFileSize);
    }

    public function move(string $directory, string|null $newName = null) : string
    {
        if (!$this->isValid()) {
            throw new FilesException($this->getErrorMessage());
        }
        $this->fm->createDirectory($directory);
        $target = $directory . DS . ($newName ?? $this->originalName);
        $error = '';
        set_error_handler(function ($type, $msg) use (&$error) {
            $error = $msg;
        });
        $fileMoved = move_uploaded_file($this->getPathname(), $target);
        restore_error_handler();
        if (!$fileMoved) {
            throw new FilesException(sprintf('Could not move file "%s" to "%s"-->"%s".', $this->getPathname(), $target, strip_tags($error)));
        }
        @chmod($target, 0666 & ~umask());

        return $target;
    }
}
