<?php

declare(strict_types=1);

class Uploader implements UploaderInterface
{
    public function __construct(private FilesManagerInterface $fm, private FilesSystemInterface $fileSytem, private ?Model $model = null)
    {
    }

    public function upload(): string
    {
        if ($this->fm->validate()) {
            $en = $this->model->getEntity();
            if ($en->isInitialized($en->getColId('media'))) {
                $incommingPath = $this->fm->getDestinationPath() . DS . $this->fm->getFileName();
                if (file_exists($incommingPath)) {
                    if ($incommingPath == $en->{$en->getColId('media')}) {
                        return $this->model;
                    } else {
                        $setter = $en->getSetter($en->getColId('media'));
                        $this->model->getEntity()->{$setter}(serialize([$incommingPath]));

                        return $this->model;
                    }
                }
            }
            $path = $this->saveFileToDisk();
            if ($path === 'error') {
                throw new UnableToSaveFileOnDiskException('Unable to save file on disk! Please contact the administrator!');
            }

            return $path;
        }
    }

    private function saveFileToDisk()
    {
        $targetFilePath = $this->fm->getDestinationPath();
        $fileName = $targetFilePath . DS . $this->fm->getFileName();
        if ($this->fileSytem->createDir($this->fm->getTargetDir() . DS . $targetFilePath)) {
            if (!file_exists($this->fm->getTargetDir() . DS . $fileName)) {
                if (move_uploaded_file($this->fm->getSourcePath() . DS . $this->fm->getFileName(), $this->fm->getTargetDir() . DS . $fileName)) {
                    if (!file_exists(IMAGE_ROOT_SRC . $targetFilePath) && !in_array($this->fm->getDestinationPath(), ['posts'])) {
                        copy($this->fm->getTargetDir() . DS . $fileName, IMAGE_ROOT_SRC . $fileName);
                    }

                    return $fileName;
                }

                return 'error';
            }

            return  $fileName;
        }
    }
}
