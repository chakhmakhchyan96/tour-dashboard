<?php

namespace AISTGlobal\TourDashboard;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use WebPConvert\WebPConvert;

class ImageService
{

    /**
     * Save photo to S3 server
     * @param $file
     * @param $path
     * @param $object
     * @param $key
     * @return string
     */
    public static function savePhoto($file, $path)
    {
        set_time_limit(100000000);
        if ($file) {
            try {
                $imageFileName = time() . rand(1, 999999999) . '.' . $file->getClientOriginalExtension();
                $s3 = Storage::disk('public');
                $filePath = '/' . $path . '/' . $imageFileName;
                $contest = file_get_contents($file);
                $s3->put($filePath, $contest, 'public');

                $file->move(public_path('/tempFolder/'), $imageFileName);

                WebPConvert::convert(public_path('/tempFolder/') . $imageFileName, public_path('/tempFolder/') . $imageFileName . '.webp', [
                    'quality' => 'auto',
                    'max-quality' => 80,
                    'converters' => ['cwebp', 'imagick', 'wpc', 'ewww', 'gd'],]);

                $s3->put($filePath . '.webp', file_get_contents(public_path('/tempFolder/') . $imageFileName . '.webp'), 'public');
                unlink(public_path('/tempFolder/') . $imageFileName . '.webp');
                unlink(public_path('/tempFolder/') . $imageFileName);
            } catch (\Exception $e) {

                dd($e->getMessage());
            } finally {
                self::attachmentThumb($contest, $imageFileName, [400], $path);
                return $imageFileName;
            }
        }
    }

    public static function saveBase64Photo($file, $path, $object, $key = 'photo')
    {
        set_time_limit(100000000);
        if ($file) {
            try {

                $imageFileName = time() . rand(1, 999999999) . '.jpg';
                $s3 = Storage::disk('public');
                $filePath = '/' . $path . '/' . $imageFileName;
                $contest = file_get_contents($file);
                $s3->put($filePath, $contest, 'public');

                Image::make($contest)->save(public_path('/tempFolder/') . $imageFileName);

                WebPConvert::convert(public_path('/tempFolder/') . $imageFileName, public_path('/tempFolder/') . $imageFileName . '.webp', [
                    'quality' => 'auto',
                    'max-quality' => 80,
                    'converters' => ['cwebp', 'imagick', 'wpc', 'ewww', 'gd'],]);

                $s3->put($filePath . '.webp', file_get_contents(public_path('/tempFolder/') . $imageFileName . '.webp'), 'public');
                unlink(public_path('/tempFolder/') . $imageFileName . '.webp');
                unlink(public_path('/tempFolder/') . $imageFileName);
            } catch (\Exception $e) {

            } finally {
                $object->$key = $imageFileName;
                $object->save();
                self::attachmentThumb($contest, $imageFileName, [150, 200, 300, 400], $path);
            }
        }
    }

    public static function saveFile($file, $path, $object, $key)
    {
        if ($file) {
            $fileName = time() . rand(1, 999999999) . '.' . $file->getClientOriginalExtension();
            $s3 = Storage::disk('public');
            $filePath = '/' . $path . '/' . $fileName;

            $s3->put($filePath, file_get_contents($file), 'public');
            $object->$key = $fileName;
            $object->save();
            $path = base_path() . '/public/images/' . $fileName;
            return $fileName;
        }
    }

    /**
     * @param $input
     * @param $name
     * @param $widths
     * @param null $repo
     */
    public static function attachmentThumb($input, $name, $widths, $repo = null)
    {
        set_time_limit(100000000);
        foreach ($widths as $width) {
            self::attachment($input, $name, $repo, $width);
        }
    }

    /**
     * @param $input
     * @param $name
     * @param $width
     * @param null $repo
     */
    public static function attachmentThumbConsole($input, $name, $width, $repo = null)
    {

        self::attachment($input, $name, $repo, $width);
    }

    /**
     * @param $input
     * @param $name
     * @param $repo
     * @param $width
     */
    public static function attachment($input, $name, $repo, $width)
    {

        try {
            Image::make($input)->resize($width, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('/tempFolder/') . $name);

            $s3 = Storage::disk('public');
            $filePath = "$repo/thumb/$width/" . $name;
            $s3->put($filePath, file_get_contents(public_path('/tempFolder/') . $name), 'public');
            WebPConvert::convert(public_path('/tempFolder/') . $name, public_path('/tempFolder/') . $name . '.webp', [
                'quality' => 'auto',
                'max-quality' => 80,
                'converters' => ['cwebp', 'imagick', 'wpc', 'ewww', 'gd'],]);

            $s3->put($filePath . '.webp', file_get_contents(public_path('/tempFolder/') . $name . '.webp'), 'public');
            unlink(public_path('/tempFolder/') . $name . '.webp');
            unlink(public_path('/tempFolder/') . $name);
        } catch (\Exception $e) {

        }
    }

}