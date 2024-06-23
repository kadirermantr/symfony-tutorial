<?php

namespace App\Services;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
	private string $uploadsDir;

	public function __construct(
		private ParameterBagInterface $parameterBag
	) {
		$this->uploadsDir = $this->parameterBag->get('uploads_dir');
	}

	public function uploadFile(UploadedFile $file): string
	{
		$fileName = sprintf('%s.%s', md5(uniqid()), $file->guessClientExtension());

		$file->move($this->uploadsDir, $fileName);

		return $fileName;
	}
}
