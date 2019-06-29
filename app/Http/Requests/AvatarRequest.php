<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\{Facades\File, Facades\Gate, Str};
use Intervention\Image\Facades\Image;

class AvatarRequest extends FormRequest
{
    /**
     * User 인스턴스.
     *
     * @var User
     */
    protected $user;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        $this->user = $this->route()->user;

        return Gate::allows('update', $this->user);
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
        $path = 'avatars/' . Str::random(40) . '.png';

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

        $image->resize(64, 64)
              ->save(public_path($path), 90, 'png');

        if ($this->user->avatar_path) {
            $this->deleteAvatar();
        }

        return $path;
    }

    /**
     * 라우트 모델 사용자의 아바타를 삭제합니다.
     */
    protected function deleteAvatar() : void
    {
        File::delete(public_path($this->user->avatar_path));
    }
}
