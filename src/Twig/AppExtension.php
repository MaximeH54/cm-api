<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('iconFile', [$this, 'getIcon']),
        ];
    }

    public function getIcon($type)
    {
				if ($type === 'application/pdf') {
						return 'fa-file-pdf-o';
				}

				if (in_array($type, ['image/gif', 'image/jpeg', 'image/png'])) {
						return 'fa-file-image-o';
				}

				if (in_array($type, ['application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])) {
						return 'fa-file-word-o';
				}

				if ($type === 'application/vnd.ms-excel') {
						return 'fa-file-excel-o';
				}

				if ($type === 'application/vnd.ms-powerpoint') {
						return 'fa-file-powerpoint-o';
				}

				return 'fa-file-o';
    }
}
?>
