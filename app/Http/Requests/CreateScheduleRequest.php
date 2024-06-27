<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

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
            'start_time_time' => ['required', 'date_format:H:i'],
            'end_time_date' => ['required', 'date_format:Y-m-d', 'after_or_equal:start_time_date'],
            'end_time_time' => ['required', 'date_format:H:i'],
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    // 時刻に関するバリデーションの追加
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // migrationファイルの型（dateTime型)に合わせる
            $startDateTime = Carbon::createFromFormat('Y-m-d H:i', $this->start_time_date . ' ' . $this->start_time_time);
            $endDateTime = Carbon::createFromFormat('Y-m-d H:i', $this->end_time_date . ' ' . $this->end_time_time);

            if ($startDateTime >= ($endDateTime)) {
                $validator->errors()->add('start_time_time', 'The start time must be before the end time.');
            }

            if ($startDateTime->diffInMinutes($endDateTime) < 5){
                $validator->errors()->add('start_time_time', 'The start time must be before the end time.');
            }
        });
    }
}
