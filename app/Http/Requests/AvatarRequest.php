<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\{Facades\Storage, Str};
use Intervention\Image\Facades\Image;

class AvatarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() : array
    {
        return [
            'src' => 'required',
            'rotate' => 'numeric',
            'width' => 'numeric',
            'height' => 'numeric',
            'x' => 'numeric',
            'y' => 'numeric',
        ];
    }

    /**
     * 속성들을 반환합니다.
     *
     * @return array
     */
    public function getAttributes() : array
    {
        return [
            'avatar_path' => $this->storeAvatar(),
        ];
    }

    /**
     * 아바타를 저장하고 기존 아바타는 삭제합니다. 저장된 아바타의 경로를 반환합니다.
     *
     * @return string
     */
    public function storeAvatar() : string
    {
        $path = config('filesystems.disks.s3.paths.avatars') . Str::random(40) . '.png';

        $image = Image::make($this->get('src'))
                      ->rotate((Int) $this->get('rotate') * -1);

        if ($this->has(['width', 'height', 'x', 'y'])) {
            $image->crop(
                (Int) $this->get('width'),
                (Int) $this->get('height'),
                (Int) $this->get('x'),
                (Int) $this->get('y')
            );
        }

        Storage::put($path, (string) $image->resize(64, 64)->encode('png'));

        if ($oldAvatar = $this->route()->user->avatar_path) {
            Storage::delete($oldAvatar);
        }

        return $path;
    }
}
