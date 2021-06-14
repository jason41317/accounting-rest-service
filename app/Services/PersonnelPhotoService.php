<?php

namespace App\Services;

use Image;
use App\Models\PersonnelPhoto;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PersonnelPhotoService
{

    public function store($personnelId, $file)
    {
        try {
            if (!$personnelId) {
                throw new \Exception('Personnel id not found!');
            }

            if (!$file) {
                throw new \Exception('File not found!');
            }

            $image = Image::make($file)->resize(null, 350, function ($constraint) {
                $constraint->aspectRatio();
            });
            
            //$path = $request->file('photo')->store('public');
            $path = 'public/personnels/' . $file->hashName();
            Storage::put($path, $image->stream());

            $personnelPhoto = PersonnelPhoto::updateOrCreate(
                ['personnel_id' => $personnelId],
                [
                    'path' => $path,
                    'name' => $file->getClientOriginalName(),
                    'hash_name' => $file->hashName()
                ]
            );

            return $personnelPhoto;
        } catch (Exception $e) {
            Log::info('Error occured during PersonnelPhotoService store method call: ');
            Log::info($e->getMessage());
            throw $e;
        }
    }

    public function delete($personnelId)
    {
        try {
            if (!$personnelId) {
                throw new \Exception('Personnel id not found!');
            }

            $query = PersonnelPhoto::where('personnel_id', $personnelId);
            $photo = $query->first();
            if ($photo) {
                Storage::delete($photo->path);
                $query->delete();
                return true;
            }
            return false;
        } catch (Exception $e) {
            Log::info('Error occured during PersonnelPhotoService delete method call: ');
            Log::info($e->getMessage());
            throw $e;
        }
    }
}