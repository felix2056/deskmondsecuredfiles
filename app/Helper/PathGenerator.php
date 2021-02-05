<?php

namespace App\Helper;

use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\PathGenerator\PathGenerator as PathGenerators;

class PathGenerator implements PathGenerators
{
    public function getPath(Media $media): string
    {
        return $this->getBasePath($media).'/';
    }

    public function getPathForConversions(Media $media): string
    {
        return $this->getBasePath($media).'/conversions/';
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getBasePath($media).'/responsive-images/';
    }

    protected function getBasePath(Media $media): string
    {
        //here im using trait to generate default path, e.g: path/mimes/avatar/media->id
        //its up to you to define folder structure, just make sure each folder
        //for conversions has unique name, or else it will be deleted

        // $base_folder = $this->get_base_folder($media->mime_type);
        $hostname = app(\Hyn\Tenancy\Environment::class)->hostname();

        $base_folder = "tenants/{$hostname->fqdn}/{$media->collection_name}/{$media->id}";
        return $base_folder;
    }
}