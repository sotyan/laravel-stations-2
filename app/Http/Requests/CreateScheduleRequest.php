<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;
use Dotenv\Validator;
use PDO;

class CreateScheduleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'movie_id' => ['required'],
            'start_time_date' => ['required', 'date_format:Y-m-d', 'before_or_equal:end_time_date'],
            //'start_time_time' => ['required', 'date_format:H:i', 'before:end_time_time'],
            'start_time_time' => ['required', 'date_format:H:i', 'before:end_time_time', function ($attribute, $value, $fail) {
                // 開始時刻と終了時刻の差が5分以上あることを確認
                $startTime = Carbon::createFromFormat('Y-m-d H:i',$this->input('start_time_date') . ' ' . $this->input('start_time_time'));
                $endTime = Carbon::createFromFormat('Y-m-d H:i',$this->input('end_time_date') . ' ' . $this->input('end_time_time'));
                $diffInMinutes = $endTime->diffInMinutes($startTime);

                if ($diffInMinutes <= 5) {
                    $fail('上映時間の差は5分以上にしてください。');
                }
            }],
            'end_time_date' => ['required', 'date_format:Y-m-d', 'after_or_equal:start_time_date'],
            'end_time_time' => ['required', 'date_format:H:i', 'after:start_time_time', function ($attribute, $value, $fail) {
                // 開始時刻と終了時刻の差が5分以上あることを確認
                $startTime = Carbon::createFromFormat('Y-m-d H:i',$this->input('start_time_date') . ' ' . $this->input('start_time_time'));
                $endTime = Carbon::createFromFormat('Y-m-d H:i',$this->input('end_time_date') . ' ' . $this->input('end_time_time'));
                $diffInMinutes = $endTime->diffInMinutes($startTime);

                if ($diffInMinutes <= 5) {
                    $fail('上映時間の差は5分以上にしてください。');
                }
            }],
        ];
    }
}
